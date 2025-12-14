<?php

class RoleModel
{
    /**
     * Get all roles
     */
    public static function getAllRoles($conn)
    {
        try {
            $query = 'SELECT * FROM role ORDER BY id DESC';
            $stmt = $conn->query($query);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all roles error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get roles with pagination
     */
    public static function getRolesPaginated($conn, $page = 1, $pageSize = 25)
    {
        try {
            $offset = ($page - 1) * $pageSize;
            
            $query = "
                SELECT * FROM role
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset
            ";
            
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get paginated roles error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get total count of roles
     */
    public static function getTotalRoles($conn)
    {
        try {
            $query = "SELECT COUNT(*) as total FROM role";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Get total roles error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get role by ID
     */
    public static function getRoleById($id, $conn)
    {
        try {
            $query = 'SELECT * FROM role WHERE id = :id';
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get role error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get role by code
     */
    public static function getRoleByCode($code, $conn)
    {
        try {
            $query = 'SELECT * FROM role WHERE role_code = :code';
            $stmt = $conn->prepare($query);
            $stmt->execute(['code' => $code]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get role by code error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get active roles
     */
    public static function getActiveRoles($conn)
    {
        try {
            $query = 'SELECT * FROM role WHERE is_active = TRUE ORDER BY role_name ASC';
            $stmt = $conn->query($query);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get active roles error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Create new role
     */
    public static function createRole($data, $conn)
    {
        try {
            $query = 'INSERT INTO role (role_code, role_name, is_active, created_by, created_on) 
                      VALUES (:role_code, :role_name, :is_active, :created_by, NOW())';

            $stmt = $conn->prepare($query);
            $stmt->execute([
                'role_code' => $data['role_code'],
                'role_name' => $data['role_name'],
                'is_active' => $data['is_active'],
                'created_by' => $data['created_by']
            ]);

            return true;
        } catch (PDOException $e) {
            error_log("Create role error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update role
     */
    public static function updateRole($id, $data, $conn)
    {
        try {
            $query = 'UPDATE role SET 
                      role_code = :role_code,
                      role_name = :role_name,
                      is_active = :is_active,
                      modified_by = :modified_by,
                      modified_on = NOW()
                      WHERE id = :id';

            $stmt = $conn->prepare($query);
            $stmt->execute([
                'role_code' => $data['role_code'],
                'role_name' => $data['role_name'],
                'is_active' => $data['is_active'],
                'modified_by' => $data['modified_by'],
                'id' => $id
            ]);

            return true;
        } catch (PDOException $e) {
            error_log("Update role error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete role
     */
    public static function deleteRole($id, $conn)
    {
        try {
            $query = 'DELETE FROM role WHERE id = :id';
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);

            return true;
        } catch (PDOException $e) {
            error_log("Delete role error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Toggle role status
     */
    public static function toggleStatus($id, $conn)
    {
        try {
            $query = 'UPDATE role SET is_active = NOT is_active WHERE id = :id';
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);

            return true;
        } catch (PDOException $e) {
            error_log("Toggle role status error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if role is being used by users
     */
    public static function isRoleUsed($id, $conn)
    {
        try {
            // Assuming you have a role_id column in users table
            $query = 'SELECT COUNT(*) as count FROM users WHERE role_id = :id';
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Check role usage error: " . $e->getMessage());
            return false;
        }
    }
}