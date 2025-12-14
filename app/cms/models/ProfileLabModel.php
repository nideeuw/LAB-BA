<?php

class ProfileLabModel
{
    /**
     * Get all profile lab entries
     */
    public static function getAllProfileLab($conn)
    {
        try {
            $query = "SELECT * FROM profile_lab ORDER BY created_on DESC";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all profile lab error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get profile labs with pagination
     */
    public static function getProfileLabsPaginated($conn, $page = 1, $pageSize = 10)
    {
        try {
            $offset = ($page - 1) * $pageSize;
            
            $query = "SELECT * FROM profile_lab 
                      ORDER BY created_on DESC 
                      LIMIT :limit OFFSET :offset";
            
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get paginated profile labs error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get total count of profile labs
     */
    public static function getTotalProfileLabs($conn)
    {
        try {
            $query = "SELECT COUNT(*) as total FROM profile_lab";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Get total profile labs error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get active profile lab (for public view)
     */
    public static function getActiveProfileLab($conn)
    {
        try {
            $query = "SELECT * FROM profile_lab WHERE is_active = TRUE LIMIT 1";
            $stmt = $conn->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get active profile lab error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get single profile lab by ID
     */
    public static function getProfileLabById($id, $conn)
    {
        try {
            $query = "SELECT * FROM profile_lab WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get profile lab by ID error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create new profile lab
     */
    public static function createProfileLab($data, $conn)
    {
        try {
            $query = "INSERT INTO profile_lab (
                        title, description, image, is_active,
                        created_by, created_on
                      ) VALUES (
                        :title, :description, :image, :is_active,
                        :created_by, NOW()
                      )";

            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                'title' => $data['title'],
                'description' => $data['description'],
                'image' => $data['image'] ?? null,
                'is_active' => $data['is_active'] ?? false,
                'created_by' => $_SESSION['user_name'] ?? 'system'
            ]);

            if ($result) {
                return $conn->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Create profile lab error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update profile lab
     */
    public static function updateProfileLab($id, $data, $conn)
    {
        try {
            $query = "UPDATE profile_lab SET 
                        title = :title,
                        description = :description,
                        is_active = :is_active,
                        modified_by = :modified_by,
                        modified_on = NOW()";

            if (isset($data['image'])) {
                $query .= ", image = :image";
            }

            $query .= " WHERE id = :id";

            $params = [
                'id' => $id,
                'title' => $data['title'],
                'description' => $data['description'],
                'is_active' => $data['is_active'] ?? false,
                'modified_by' => $_SESSION['user_name'] ?? 'system'
            ];

            if (isset($data['image'])) {
                $params['image'] = $data['image'];
            }

            $stmt = $conn->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Update profile lab error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete profile lab
     */
    public static function deleteProfileLab($id, $conn)
    {
        try {
            $profileLab = self::getProfileLabById($id, $conn);

            $query = "DELETE FROM profile_lab WHERE id = :id";
            $stmt = $conn->prepare($query);
            $result = $stmt->execute(['id' => $id]);

            if ($result && !empty($profileLab['image'])) {
                $imagePath = ROOT_PATH . 'assets/' . $profileLab['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Delete profile lab error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Deactivate all profile labs
     */
    public static function deactivateAll($conn)
    {
        try {
            $query = "UPDATE profile_lab SET is_active = FALSE";
            $stmt = $conn->prepare($query);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Deactivate all error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Set active status (deactivate all others first)
     */
    public static function setActiveProfileLab($id, $conn)
    {
        try {
            $conn->beginTransaction();

            self::deactivateAll($conn);

            $query = "UPDATE profile_lab SET is_active = TRUE WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);

            $conn->commit();
            return true;
        } catch (PDOException $e) {
            $conn->rollBack();
            error_log("Set active profile lab error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Upload and save profile lab image
     */
    public static function uploadImage($file)
    {
        try {
            if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
                return false;
            }

            if ($file['size'] > 2 * 1024 * 1024) {
                return false;
            }

            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mimeType, $allowedTypes)) {
                return false;
            }

            $uploadDir = ROOT_PATH . 'assets/uploads/profile_lab';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $filepath = $uploadDir . '/' . $filename;

            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                return 'uploads/profile_lab/' . $filename;
            }

            return false;
        } catch (Exception $e) {
            error_log("Upload profile lab image error: " . $e->getMessage());
            return false;
        }
    }
}