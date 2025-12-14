<?php

class UserModel
{
    /**
     * Register user baru
     */
    public static function register($username, $password, $conn)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $query = 'INSERT INTO "users" ("username", "password") VALUES (:username, :password)';
            $stmt = $conn->prepare($query);
            $stmt->execute([
                'username' => $username,
                'password' => $hashedPassword
            ]);

            return true;
        } catch (PDOException $e) {
            error_log("Register error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Login user
     */
    public static function login($username, $password, $conn)
    {
        try {
            $query = 'SELECT * FROM users WHERE username = :username AND is_active = TRUE';
            $stmt = $conn->prepare($query);
            $stmt->execute(['username' => $username]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verify password
                if (password_verify($password, $user['password'])) {
                    return $user;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user by ID
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
     */
    public static function getUsersPaginated($conn, $page = 1, $pageSize = 25)
    {
        try {
            $offset = ($page - 1) * $pageSize;
            
            $query = "
                SELECT * FROM users
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset
            ";
            
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
     * Update user
     */
    public static function updateUser($id, $data, $conn)
    {
        try {
            $query = 'UPDATE users SET username = :username';

            // Jika password diupdate
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
                $query .= ', password = :password';
            } else {
                unset($data['password']);
            }

            $query .= ' WHERE id = :id';

            $data['id'] = $id;

            $stmt = $conn->prepare($query);
            $stmt->execute($data);

            return true;
        } catch (PDOException $e) {
            error_log("Update user error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete user
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