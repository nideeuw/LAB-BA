<?php

/**
 * Model: VisiMisiModel
 * Location: app/cms/models/VisiMisiModel.php
 * Purpose: Manage Visi & Misi - Multiple records with CRUD
 */

class VisiMisiModel
{
    /**
     * Get all visi misi (ordered by newest first)
     */
    public static function getAllVisiMisi($conn)
    {
        try {
            $query = "SELECT * FROM visi_misi ORDER BY created_on DESC";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all visi misi error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get active visi misi (for frontend)
     */
    public static function getActiveVisiMisi($conn)
    {
        try {
            $query = "SELECT * FROM visi_misi WHERE is_active = TRUE ORDER BY created_on DESC LIMIT 1";
            $stmt = $conn->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get active visi misi error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get visi misi by ID
     */
    public static function getVisiMisiById($id, $conn)
    {
        try {
            $query = "SELECT * FROM visi_misi WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get visi misi by ID error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create visi misi
     */
    public static function createVisiMisi($data, $conn)
    {
        try {
            $query = "INSERT INTO visi_misi (visi, misi, is_active, created_by, created_on) 
                      VALUES (:visi, :misi, :is_active, :created_by, NOW())";

            $stmt = $conn->prepare($query);
            return $stmt->execute([
                'visi' => $data['visi'],
                'misi' => $data['misi'],
                'is_active' => $data['is_active'] ? 'true' : 'false',
                'created_by' => $_SESSION['user_name'] ?? 'system'
            ]);
        } catch (PDOException $e) {
            error_log("Create visi misi error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update visi misi
     */
    public static function updateVisiMisi($id, $data, $conn)
    {
        try {
            $query = "UPDATE visi_misi SET 
                        visi = :visi,
                        misi = :misi,
                        is_active = :is_active,
                        modified_by = :modified_by,
                        modified_on = NOW()
                      WHERE id = :id";

            $stmt = $conn->prepare($query);
            return $stmt->execute([
                'id' => $id,
                'visi' => $data['visi'],
                'misi' => $data['misi'],
                'is_active' => $data['is_active'] ? 'true' : 'false',
                'modified_by' => $_SESSION['user_name'] ?? 'system'
            ]);
        } catch (PDOException $e) {
            error_log("Update visi misi error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete visi misi
     */
    public static function deleteVisiMisi($id, $conn)
    {
        try {
            $query = "DELETE FROM visi_misi WHERE id = :id";
            $stmt = $conn->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Delete visi misi error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if record exists
     */
    public static function exists($conn)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM visi_misi";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Check visi misi exists error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Count total records
     */
    public static function countAll($conn)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM visi_misi";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            error_log("Count visi misi error: " . $e->getMessage());
            return 0;
        }
    }
}
