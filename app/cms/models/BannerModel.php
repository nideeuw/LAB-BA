<?php

class BannerModel
{
    /**
     * Get all banner items
     */
    public static function getAllBanner($conn)
    {
        try {
            $query = 'SELECT * FROM banner ORDER BY created_on DESC';
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all banner error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get active banner items (for public view)
     */
    public static function getActiveBanner($conn)
    {
        try {
            $query = 'SELECT * FROM banner WHERE is_active = TRUE ORDER BY created_on DESC';
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get active banner error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get single banner by ID
     */
    public static function getBannerById($id, $conn)
    {
        try {
            $query = 'SELECT * FROM banner WHERE id = :id';
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get banner by ID error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create new banner item
     */
    public static function createBanner($data, $conn)
    {
        try {
            $query = 'INSERT INTO banner (
                        image, is_active, created_by, created_on
                      ) VALUES (
                        :image, :is_active, :created_by, NOW()
                      )';

            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                'image' => $data['image'] ?? null,
                'is_active' => $data['is_active'] ?? true,
                'created_by' => $_SESSION['user_name'] ?? 'system'
            ]);

            if ($result) {
                return $conn->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Create banner error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update banner item
     */
    public static function updateBanner($id, $data, $conn)
    {
        try {
            $query = 'UPDATE banner SET
                        is_active = :is_active,
                        modified_by = :modified_by,
                        modified_on = NOW()';

            // Only update image if new image provided
            if (isset($data['image'])) {
                $query .= ', image = :image';
            }

            $query .= ' WHERE id = :id';

            $params = [
                'id' => $id,
                'is_active' => $data['is_active'] ? 'true' : 'false',
                'modified_by' => $_SESSION['user_name'] ?? 'system'
            ];

            if (isset($data['image'])) {
                $params['image'] = $data['image'];
            }

            $stmt = $conn->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Update banner error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete banner item
     */
    public static function deleteBanner($id, $conn)
    {
        try {
            // Get image path before delete
            $banner = self::getBannerById($id, $conn);

            // Delete from database
            $query = 'DELETE FROM banner WHERE id = :id';
            $stmt = $conn->prepare($query);
            $result = $stmt->execute(['id' => $id]);

            // Delete image file if exists
            if ($result && !empty($banner['image'])) {
                $imagePath = ROOT_PATH . 'public/' . $banner['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Delete banner error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Upload and save image
     * Returns: image path or false
     */
    public static function uploadImage($file)
    {
        try {
            // Validate file
            if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
                return false;
            }

            // Check file size (max 5MB)
            if ($file['size'] > 5 * 1024 * 1024) {
                return false;
            }

            // Check file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mimeType, $allowedTypes)) {
                return false;
            }

            // Create upload directory structure
            $uploadDir = ROOT_PATH . 'public/uploads/banner/' . date('Y/m');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $filepath = $uploadDir . '/' . $filename;

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                // Return relative path for database
                return 'uploads/banner/' . date('Y/m') . '/' . $filename;
            }

            return false;
        } catch (Exception $e) {
            error_log("Upload image error: " . $e->getMessage());
            return false;
        }
    }
}
