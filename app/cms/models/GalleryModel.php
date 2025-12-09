<?php

class GalleryModel
{
    /**
     * Get all gallery items (for CMS)
     */
    public static function getAllGallery($conn)
    {
        try {
            $query = 'SELECT * FROM gallery ORDER BY date DESC, created_on DESC';
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all gallery error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get active gallery items (for public view)
     */
    public static function getActiveGallery($conn)
    {
        try {
            $query = 'SELECT * FROM gallery WHERE is_active = TRUE ORDER BY date DESC, created_on DESC';
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get active gallery error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get single gallery by ID
     */
    public static function getGalleryById($id, $conn)
    {
        try {
            $query = 'SELECT * FROM gallery WHERE id = :id';
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get gallery by ID error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create new gallery item
     */
    public static function createGallery($data, $conn)
    {
        try {
            $query = 'INSERT INTO gallery (
                        title, date, description, image, is_active,
                        created_by, created_on
                      ) VALUES (
                        :title, :date, :description, :image, :is_active,
                        :created_by, NOW()
                      )';

            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                'title' => $data['title'],
                'date' => $data['date'] ?? null,
                'description' => $data['description'] ?? null,
                'image' => $data['image'] ?? null,
                'is_active' => $data['is_active'] ?? true,
                'created_by' => $_SESSION['user_name'] ?? 'system'
            ]);

            if ($result) {
                return $conn->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Create gallery error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update gallery item
     */
    public static function updateGallery($id, $data, $conn)
    {
        try {
            $query = 'UPDATE gallery SET 
                        title = :title,
                        date = :date,
                        description = :description,
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
                'title' => $data['title'],
                'date' => $data['date'] ?? null,
                'description' => $data['description'] ?? null,
                'is_active' => $data['is_active'] ? 'true' : 'false',
                'modified_by' => $_SESSION['user_name'] ?? 'system'
            ];

            if (isset($data['image'])) {
                $params['image'] = $data['image'];
            }

            $stmt = $conn->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Update gallery error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete gallery item
     */
    public static function deleteGallery($id, $conn)
    {
        try {
            // Get image path before delete
            $gallery = self::getGalleryById($id, $conn);

            // Delete from database
            $query = 'DELETE FROM gallery WHERE id = :id';
            $stmt = $conn->prepare($query);
            $result = $stmt->execute(['id' => $id]);

            // Delete image file if exists
            if ($result && !empty($gallery['image'])) {
                $imagePath = ROOT_PATH . 'assets/' . $gallery['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Delete gallery error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Upload and save image
     * Returns: image path or false
     * 
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

            $uploadDir = ROOT_PATH . 'assets/uploads/gallery';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $filepath = $uploadDir . '/' . $filename;

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                return 'uploads/gallery/' . $filename;
            }

            return false;
        } catch (Exception $e) {
            error_log("Upload image error: " . $e->getMessage());
            return false;
        }
    }
}