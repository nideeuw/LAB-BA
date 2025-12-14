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
     * Get banner with pagination
     */
    public static function getBannerPaginated($conn, $page = 1, $pageSize = 25)
    {
        try {
            $offset = ($page - 1) * $pageSize;
            
            $query = "
                SELECT * 
                FROM banner 
                ORDER BY created_on DESC
                LIMIT :limit OFFSET :offset
            ";
            
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get paginated banner error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get total count of banners
     */
    public static function getTotalBanner($conn)
    {
        try {
            $query = "SELECT COUNT(*) as total FROM banner";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Get total banner error: " . $e->getMessage());
            return 0;
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
            $banner = self::getBannerById($id, $conn);

            $query = 'DELETE FROM banner WHERE id = :id';
            $stmt = $conn->prepare($query);
            $result = $stmt->execute(['id' => $id]);

            if ($result && !empty($banner['image'])) {
                $imagePath = ROOT_PATH . 'assets/' . $banner['image'];
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
     */
    public static function uploadImage($file)
    {
        try {
            if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
                return false;
            }

            if ($file['size'] > 5 * 1024 * 1024) {
                return false;
            }

            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mimeType, $allowedTypes)) {
                return false;
            }

            $uploadDir = ROOT_PATH . 'assets/uploads/banner/' . date('Y/m');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $filepath = $uploadDir . '/' . $filename;

            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                return 'uploads/banner/' . date('Y/m') . '/' . $filename;
            }

            return false;
        } catch (Exception $e) {
            error_log("Upload image error: " . $e->getMessage());
            return false;
        }
    }
}