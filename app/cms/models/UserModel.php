<?php

class UserModel
{
    /**
     * Register/Create new user
     * 
     * @param array $data User data (username, email, password, full_name, role_id, is_active, created_by)
     * @param PDO $conn Database connection
     * @return int|bool Returns user ID if success, false if failed
     */
    public static function register($data, $conn)
    {
        try {
            // Hash password menggunakan BCRYPT
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

            // Build dynamic query - field yang wajib
            $fields = ['username', 'email', 'password'];
            $placeholders = [':username', ':email', ':password'];
            $params = [
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $hashedPassword
            ];

            // Tambahkan field optional jika ada
            if (!empty($data['full_name'])) {
                $fields[] = 'full_name';
                $placeholders[] = ':full_name';
                $params['full_name'] = $data['full_name'];
            }

            if (isset($data['role_id']) && $data['role_id'] !== '') {
                $fields[] = 'role_id';
                $placeholders[] = ':role_id';
                $params['role_id'] = $data['role_id'];
            }

            // Handle is_active - default true jika tidak di-set
            $fields[] = 'is_active';
            $placeholders[] = ':is_active';
            $params['is_active'] = isset($data['is_active']) && $data['is_active'] ? true : false;

            // Handle created_by - boleh NULL
            if (isset($data['created_by']) && $data['created_by'] !== null) {
                $fields[] = 'created_by';
                $placeholders[] = ':created_by';
                $params['created_by'] = $data['created_by'];
            }

            // Build final query dengan RETURNING untuk dapat ID user baru
            $fieldsStr = implode(', ', $fields);
            $placeholdersStr = implode(', ', $placeholders);
            $query = "INSERT INTO users ($fieldsStr) VALUES ($placeholdersStr) RETURNING id";
            
            $stmt = $conn->prepare($query);
            $result = $stmt->execute($params);
            
            if ($result) {
                // Return ID user yang baru dibuat
                return $stmt->fetchColumn();
            }
            
            return false;
        } catch (PDOException $e) {
            error_log("Register error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Login user - verify username and password
     * 
     * @param string $username Username
     * @param string $password Plain text password
     * @param PDO $conn Database connection
     * @return array|bool Returns user data if success, false if failed
     */
    public static function login($username, $password, $conn)
    {
        try {
            // Cari user berdasarkan username
            $query = 'SELECT * FROM users WHERE username = :username';
            $stmt = $conn->prepare($query);
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Cek apakah user aktif
                if (!$user['is_active']) {
                    return false; // User tidak aktif
                }
                
                // Verify password dengan hash di database
                if (password_verify($password, $user['password'])) {
                    return $user; // Login berhasil
                }
            }
            
            return false; // User tidak ditemukan atau password salah
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user by ID
     * 
     * @param int $id User ID
     * @param PDO $conn Database connection
     * @return array|bool User data or false if not found
     */
    public static function getUserById($id, $conn)
    {
        try {
            $query = 'SELECT * FROM users WHERE id = :id';
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get user error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all users
     * 
     * @param PDO $conn Database connection
     * @return array List of all users
     */
    public static function getAllUsers($conn)
    {
        try {
            $query = 'SELECT * FROM users ORDER BY id DESC';
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all users error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get users with pagination
     * 
     * @param PDO $conn Database connection
     * @param int $page Current page number
     * @param int $pageSize Number of records per page
     * @return array Paginated list of users
     */
    public static function getUsersPaginated($conn, $page = 1, $pageSize = 25)
    {
        try {
            $offset = ($page - 1) * $pageSize;
            
            $query = "SELECT * FROM users ORDER BY id DESC LIMIT :limit OFFSET :offset";
            
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get paginated users error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get total count of users
     * 
     * @param PDO $conn Database connection
     * @return int Total number of users
     */
    public static function getTotalUsers($conn)
    {
        try {
            $query = "SELECT COUNT(*) as total FROM users";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Get total users error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Update user data
     * 
     * @param int $id User ID
     * @param array $data Data to update
     * @param PDO $conn Database connection
     * @return bool True if success, false if failed
     */
    public static function updateUser($id, $data, $conn)
    {
        try {
            $updates = [];
            $params = ['id' => $id];

            // Build dynamic update query
            if (isset($data['username'])) {
                $updates[] = 'username = :username';
                $params['username'] = $data['username'];
            }

            if (isset($data['full_name'])) {
                $updates[] = 'full_name = :full_name';
                $params['full_name'] = $data['full_name'];
            }

            if (isset($data['email'])) {
                $updates[] = 'email = :email';
                $params['email'] = $data['email'];
            }

            if (isset($data['role_id'])) {
                $updates[] = 'role_id = :role_id';
                $params['role_id'] = $data['role_id'] !== '' ? $data['role_id'] : null;
            }

            if (isset($data['is_active'])) {
                $updates[] = 'is_active = :is_active';
                $params['is_active'] = $data['is_active'] ? true : false;
            }

            // Update password jika ada (hash dulu)
            if (isset($data['password']) && !empty($data['password'])) {
                $updates[] = 'password = :password';
                $params['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            }

            if (isset($data['modified_by'])) {
                $updates[] = 'modified_by = :modified_by';
                $params['modified_by'] = $data['modified_by'];
            }

            // Auto-update timestamp modified_on
            $updates[] = 'modified_on = CURRENT_TIMESTAMP';

            // Jika tidak ada yang diupdate, return true
            if (empty($updates)) {
                return true;
            }

            $query = 'UPDATE users SET ' . implode(', ', $updates) . ' WHERE id = :id';
            $stmt = $conn->prepare($query);
            $stmt->execute($params);

            return true;
        } catch (PDOException $e) {
            error_log("Update user error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete user
     * 
     * @param int $id User ID
     * @param PDO $conn Database connection
     * @return bool True if success, false if failed
     */
    public static function deleteUser($id, $conn)
    {
        try {
            $query = 'DELETE FROM users WHERE id = :id';
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Delete user error: " . $e->getMessage());
            return false;
        }
    }
}