<?php

/**
 * Model: ResearchScopeModel
 * Location: app/cms/models/ResearchScopeModel.php
 * Purpose: Manage Research Scope (multiple records with CRUD)
 */

class ResearchScopeModel
{
    /**
     * Get all research scopes
     */
    public static function getAllResearchScopes($conn)
    {
        try {
            $query = "SELECT * FROM research_scope ORDER BY created_on DESC";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all research scopes error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get active research scope (for frontend)
     */
    public static function getActiveResearchScope($conn)
    {
        try {
            $query = "SELECT * FROM research_scope WHERE is_active = TRUE ORDER BY created_on DESC LIMIT 1";
            $stmt = $conn->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get active research scope error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get research scope by ID
     */
    public static function getResearchScopeById($id, $conn)
    {
        try {
            $query = "SELECT * FROM research_scope WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get research scope by ID error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create research scope
     */
    public static function createResearchScope($data, $conn)
    {
        try {
            $query = "INSERT INTO research_scope (title, image, description, is_active, created_by, created_on) 
                      VALUES (:title, :image, :description, :is_active, :created_by, NOW())";

            $stmt = $conn->prepare($query);
            return $stmt->execute([
                'title' => $data['title'],
                'image' => $data['image'] ?? null,
                'description' => $data['description'] ?? null,
                'is_active' => $data['is_active'] ? 'true' : 'false',
                'created_by' => $_SESSION['user_name'] ?? 'system'
            ]);
        } catch (PDOException $e) {
            error_log("Create research scope error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update research scope
     */
    public static function updateResearchScope($id, $data, $conn)
    {
        try {
            $query = "UPDATE research_scope SET 
                        title = :title,
                        description = :description,
                        is_active = :is_active,
                        modified_by = :modified_by,
                        modified_on = NOW()";

            $params = [
                'id' => $id,
                'title' => $data['title'],
                'description' => $data['description'],
                'is_active' => $data['is_active'] ? 'true' : 'false',
                'modified_by' => $_SESSION['user_name'] ?? 'system'
            ];

            // Only update image if provided
            if (isset($data['image'])) {
                $query .= ", image = :image";
                $params['image'] = $data['image'];
            }

            $query .= " WHERE id = :id";

            $stmt = $conn->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Update research scope error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete research scope
     */
    public static function deleteResearchScope($id, $conn)
    {
        try {
            $query = "DELETE FROM research_scope WHERE id = :id";
            $stmt = $conn->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Delete research scope error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if record exists
     */
    public static function exists($conn)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM research_scope";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Check research scope exists error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Upload and save research scope image
     */
    public static function uploadImage($file)
    {
        try {
            if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
                return false;
            }

            // Check file size (max 5MB)
            if ($file['size'] > 5 * 1024 * 1024) {
                return false;
            }

            // Check file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mimeType, $allowedTypes)) {
                return false;
            }

            $uploadDir = ROOT_PATH . 'assets/uploads/research_scope';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $filepath = $uploadDir . '/' . $filename;

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                return 'uploads/research_scope/' . $filename;
            }

            return false;
        } catch (Exception $e) {
            error_log("Upload research scope image error: " . $e->getMessage());
            return false;
        }
    }
}
