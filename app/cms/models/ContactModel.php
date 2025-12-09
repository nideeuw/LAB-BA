<?php

class ContactModel
{
    /**
     * Get active contact info (for footer display)
     */
    public static function getActiveContact($conn)
    {
        try {
            $query = 'SELECT * FROM contact WHERE is_active = TRUE LIMIT 1';
            $stmt = $conn->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get active contact error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get all contacts
     */
    public static function getAllContacts($conn)
    {
        try {
            $query = 'SELECT * FROM contact ORDER BY created_on DESC';
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all contacts error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get contact by ID
     */
    public static function getContactById($id, $conn)
    {
        try {
            $query = 'SELECT * FROM contact WHERE id = ?';
            $stmt = $conn->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get contact by ID error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create new contact
     */
    public static function createContact($data, $conn)
    {
        try {
            $query = 'INSERT INTO contact (
                        email, alamat, no_telp, is_active,
                        created_by, created_on
                      ) VALUES (
                        ?, ?, ?, ?,
                        ?, NOW()
                      )';

            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                $data['email'],
                $data['alamat'],
                $data['no_telp'],
                $data['is_active'] ?? true,
                $_SESSION['user_name'] ?? 'system'
            ]);

            if ($result) {
                return $conn->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Create contact error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update contact
     */
    public static function updateContact($id, $data, $conn)
    {
        try {
            $query = 'UPDATE contact SET 
                        email = ?,
                        alamat = ?,
                        no_telp = ?,
                        is_active = ?,
                        modified_by = ?,
                        modified_on = NOW()
                      WHERE id = ?';

            $stmt = $conn->prepare($query);
            return $stmt->execute([
                $data['email'],
                $data['alamat'],
                $data['no_telp'],
                $data['is_active'] ? 'true' : 'false',
                $_SESSION['user_name'] ?? 'system',
                $id
            ]);
        } catch (PDOException $e) {
            error_log("Update contact error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete contact
     */
    public static function deleteContact($id, $conn)
    {
        try {
            $query = 'DELETE FROM contact WHERE id = ?';
            $stmt = $conn->prepare($query);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Delete contact error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Set contact as active (deactivate others)
     */
    public static function setActiveContact($id, $conn)
    {
        try {
            // Start transaction
            $conn->beginTransaction();

            // Deactivate all contacts
            $query1 = 'UPDATE contact SET is_active = FALSE';
            $conn->exec($query1);

            // Activate selected contact
            $query2 = 'UPDATE contact SET is_active = TRUE WHERE id = ?';
            $stmt = $conn->prepare($query2);
            $stmt->execute([$id]);

            $conn->commit();
            return true;
        } catch (PDOException $e) {
            $conn->rollBack();
            error_log("Set active contact error: " . $e->getMessage());
            return false;
        }
    }
}