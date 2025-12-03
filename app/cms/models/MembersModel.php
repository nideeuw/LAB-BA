<?php

class MembersModel
{
    /**
     * Get all members
     */
    public static function getAllMembers($conn)
    {
        try {
            $query = 'SELECT * FROM members ORDER BY nama ASC';
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all members error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get active members (for public view)
     */
    public static function getActiveMembers($conn)
    {
        try {
            $query = 'SELECT * FROM members WHERE is_active = TRUE ORDER BY nama ASC';
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get active members error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get single member by ID
     */
    public static function getMemberById($id, $conn)
    {
        try {
            $query = 'SELECT * FROM members WHERE id = :id';
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get member by ID error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create new member
     */
    public static function createMember($data, $conn)
    {
        try {
            $query = 'INSERT INTO members (
                        nama, gelar_depan, gelar_belakang, jabatan, 
                        email, image, sinta_link, is_active,
                        created_by, created_on
                      ) VALUES (
                        :nama, :gelar_depan, :gelar_belakang, :jabatan,
                        :email, :image, :sinta_link, :is_active,
                        :created_by, NOW()
                      )';

            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                'nama' => $data['nama'],
                'gelar_depan' => $data['gelar_depan'] ?? null,
                'gelar_belakang' => $data['gelar_belakang'] ?? null,
                'jabatan' => $data['jabatan'] ?? null,
                'email' => $data['email'] ?? null,
                'image' => $data['image'] ?? null,
                'sinta_link' => $data['sinta_link'] ?? null,
                'is_active' => $data['is_active'] ?? true,
                'created_by' => $_SESSION['user_name'] ?? 'system'
            ]);

            if ($result) {
                return $conn->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Create member error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update member
     */
    public static function updateMember($id, $data, $conn)
    {
        try {
            $query = 'UPDATE members SET 
                        nama = :nama,
                        gelar_depan = :gelar_depan,
                        gelar_belakang = :gelar_belakang,
                        jabatan = :jabatan,
                        email = :email,
                        sinta_link = :sinta_link,
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
                'nama' => $data['nama'],
                'gelar_depan' => $data['gelar_depan'] ?? null,
                'gelar_belakang' => $data['gelar_belakang'] ?? null,
                'jabatan' => $data['jabatan'] ?? null,
                'email' => $data['email'] ?? null,
                'sinta_link' => $data['sinta_link'] ?? null,
                'is_active' => $data['is_active'] ?? true,
                'modified_by' => $_SESSION['user_name'] ?? 'system'
            ];

            if (isset($data['image'])) {
                $params['image'] = $data['image'];
            }

            $stmt = $conn->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Update member error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete member
     */
    public static function deleteMember($id, $conn)
    {
        try {
            // Get image path before delete
            $member = self::getMemberById($id, $conn);
            
            // Delete from database
            $query = 'DELETE FROM members WHERE id = :id';
            $stmt = $conn->prepare($query);
            $result = $stmt->execute(['id' => $id]);

            // Delete image file if exists
            if ($result && !empty($member['image'])) {
                $imagePath = ROOT_PATH . 'public/' . $member['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Delete member error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Upload and save member photo
     * Returns: image path or false
     */
    public static function uploadImage($file)
    {
        try {
            // Validate file
            if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
                return false;
            }

            // Check file size (max 2MB for profile photos)
            if ($file['size'] > 2 * 1024 * 1024) {
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

            // Create upload directory
            $uploadDir = ROOT_PATH . 'public/uploads/members';
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
                return 'uploads/members/' . $filename;
            }

            return false;
        } catch (Exception $e) {
            error_log("Upload member image error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get full member name with titles
     */
    public static function getFullName($member)
    {
        $name = '';
        
        if (!empty($member['gelar_depan'])) {
            $name .= $member['gelar_depan'] . ' ';
        }
        
        $name .= $member['nama'];
        
        if (!empty($member['gelar_belakang'])) {
            $name .= ', ' . $member['gelar_belakang'];
        }
        
        return $name;
    }
}