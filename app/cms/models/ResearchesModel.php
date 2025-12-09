<?php

class ResearchesModel
{
    /**
     * Get all researches
     */
    public static function getAllResearches($conn)
    {
        try {
            $query = "
                SELECT 
                    r.*,
                    m.nama as member_name,
                    m.gelar_depan,
                    m.gelar_belakang
                FROM researches r
                LEFT JOIN members m ON r.id_members = m.id
                ORDER BY r.title ASC
            ";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all researches error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get active researches (for landing page)
     */
    public static function getActiveResearches($conn)
    {
        try {
            $query = "
                SELECT 
                    r.*,
                    m.nama as member_name,
                    m.gelar_depan,
                    m.gelar_belakang
                FROM researches r
                LEFT JOIN members m ON r.id_members = m.id
                WHERE r.is_active = TRUE
                ORDER BY r.title ASC
            ";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get active researches error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get researches grouped by title (research areas with members)
     */
    public static function getResearchesGrouped($conn)
    {
        try {
            $query = "
                SELECT 
                    r.title as research_title,
                    r.deskripsi,
                    COUNT(DISTINCT r.id_members) as member_count,
                    STRING_AGG(DISTINCT m.nama, ', ' ORDER BY m.nama) as member_names
                FROM researches r
                LEFT JOIN members m ON r.id_members = m.id AND m.is_active = TRUE
                WHERE r.is_active = TRUE
                GROUP BY r.title, r.deskripsi
                ORDER BY r.title ASC
            ";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get researches grouped error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get members by research title
     */
    public static function getMembersByResearch($research_title, $conn)
    {
        try {
            $query = "
                SELECT DISTINCT
                    m.id,
                    m.nama,
                    m.gelar_depan,
                    m.gelar_belakang,
                    m.image as foto,
                    m.jabatan
                FROM researches r
                INNER JOIN members m ON r.id_members = m.id
                WHERE r.title = ? 
                AND r.is_active = TRUE 
                AND m.is_active = TRUE
                ORDER BY m.nama ASC
            ";
            $stmt = $conn->prepare($query);
            $stmt->execute([$research_title]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get members by research error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get research by ID
     */
    public static function getResearchById($id, $conn)
    {
        try {
            $query = "
                SELECT 
                    r.*,
                    m.nama as member_name,
                    m.gelar_depan,
                    m.gelar_belakang
                FROM researches r
                LEFT JOIN members m ON r.id_members = m.id
                WHERE r.id = ?
            ";
            $stmt = $conn->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get research by ID error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create new research
     */
    public static function createResearch($data, $conn)
    {
        try {
            $query = "
                INSERT INTO researches (
                    id_members, title, deskripsi, year, is_active,
                    created_by, created_on
                ) VALUES (
                    ?, ?, ?, ?, ?,
                    ?, NOW()
                )
            ";

            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                $data['id_members'],
                $data['title'],
                $data['deskripsi'] ?? null,
                $data['year'] ?? null,
                $data['is_active'] ?? true,
                $_SESSION['user_name'] ?? 'system'
            ]);

            if ($result) {
                return $conn->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Create research error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update research
     */
    public static function updateResearch($id, $data, $conn)
    {
        try {
            $query = "
                UPDATE researches SET 
                    id_members = ?,
                    title = ?,
                    deskripsi = ?,
                    year = ?,
                    is_active = ?,
                    modified_by = ?,
                    modified_on = NOW()
                WHERE id = ?
            ";

            $stmt = $conn->prepare($query);
            return $stmt->execute([
                $data['id_members'],
                $data['title'],
                $data['deskripsi'] ?? null,
                $data['year'] ?? null,
                $data['is_active'] ? 'true' : 'false',
                $_SESSION['user_name'] ?? 'system',
                $id
            ]);
        } catch (PDOException $e) {
            error_log("Update research error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete research
     */
    public static function deleteResearch($id, $conn)
    {
        try {
            $query = 'DELETE FROM researches WHERE id = ?';
            $stmt = $conn->prepare($query);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Delete research error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get member full name helper
     */
    public static function getMemberFullName($research)
    {
        $name = '';

        if (!empty($research['gelar_depan'])) {
            $name .= $research['gelar_depan'] . ' ';
        }

        $name .= $research['member_name'];

        if (!empty($research['gelar_belakang'])) {
            $name .= ', ' . $research['gelar_belakang'];
        }

        return $name;
    }
}
