<?php

class PublicationsModel
{
    /**
     * Get all publications
     */
    public static function getAllPublications($conn)
    {
        try {
            $query = "
                SELECT 
                    p.*,
                    m.nama as member_name,
                    m.gelar_depan,
                    m.gelar_belakang
                FROM publications p
                LEFT JOIN members m ON p.id_members = m.id
                ORDER BY p.year DESC, p.title ASC
            ";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all publications error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get active publications (for landing page)
     */
    public static function getActivePublications($conn, $year_filter = null, $member_filter = null)
    {
        try {
            $query = "
                SELECT 
                    p.*,
                    m.nama as member_name,
                    m.gelar_depan,
                    m.gelar_belakang
                FROM publications p
                LEFT JOIN members m ON p.id_members = m.id
                WHERE p.is_active = TRUE
            ";

            $params = [];

            if ($year_filter && $year_filter !== 'all') {
                $query .= " AND p.year = ?";
                $params[] = $year_filter;
            }

            if ($member_filter && $member_filter !== 'all') {
                $query .= " AND p.id_members = ?";
                $params[] = $member_filter;
            }

            $query .= " ORDER BY p.year DESC, p.title ASC";

            if (empty($params)) {
                $stmt = $conn->query($query);
            } else {
                $stmt = $conn->prepare($query);
                $stmt->execute($params);
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get active publications error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get publication by ID
     */
    public static function getPublicationById($id, $conn)
    {
        try {
            $query = "
                SELECT 
                    p.*,
                    m.nama as member_name,
                    m.gelar_depan,
                    m.gelar_belakang
                FROM publications p
                LEFT JOIN members m ON p.id_members = m.id
                WHERE p.id = ?
            ";
            $stmt = $conn->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get publication by ID error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get available years for filter
     */
    public static function getAvailableYears($conn)
    {
        try {
            $query = "
                SELECT DISTINCT year 
                FROM publications 
                WHERE is_active = TRUE 
                ORDER BY year DESC
            ";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log("Get available years error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get active members who have publications (for filter)
     */
    public static function getMembersWithPublications($conn)
    {
        try {
            $query = "
                SELECT DISTINCT 
                    m.id,
                    m.nama,
                    m.gelar_depan,
                    m.gelar_belakang
                FROM members m
                INNER JOIN publications p ON m.id = p.id_members
                WHERE p.is_active = TRUE AND m.is_active = TRUE
                ORDER BY m.nama ASC
            ";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get members with publications error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Create new publication
     */
    public static function createPublication($data, $conn)
    {
        try {
            $query = "
                INSERT INTO publications (
                    id_members, title, journal_name, year, 
                    journal_link, kategori_publikasi, is_active,
                    created_by, created_on
                ) VALUES (
                    ?, ?, ?, ?,
                    ?, ?, ?,
                    ?, NOW()
                )
            ";

            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                $data['id_members'],
                $data['title'],
                $data['journal_name'] ?? null,
                $data['year'],
                $data['journal_link'] ?? null,
                $data['kategori_publikasi'] ?? null,
                $data['is_active'] ?? true,
                $_SESSION['user_name'] ?? 'system'
            ]);

            if ($result) {
                return $conn->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Create publication error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update publication
     */
    public static function updatePublication($id, $data, $conn)
    {
        try {
            $query = "
                UPDATE publications SET 
                    id_members = ?,
                    title = ?,
                    journal_name = ?,
                    year = ?,
                    journal_link = ?,
                    kategori_publikasi = ?,
                    is_active = ?,
                    modified_by = ?,
                    modified_on = NOW()
                WHERE id = ?
            ";

            $stmt = $conn->prepare($query);
            return $stmt->execute([
                $data['id_members'],
                $data['title'],
                $data['journal_name'] ?? null,
                $data['year'],
                $data['journal_link'] ?? null,
                $data['kategori_publikasi'] ?? null,
                $data['is_active'] ? 'true' : 'false',
                $_SESSION['user_name'] ?? 'system',
                $id
            ]);
        } catch (PDOException $e) {
            error_log("Update publication error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete publication
     */
    public static function deletePublication($id, $conn)
    {
        try {
            $query = 'DELETE FROM publications WHERE id = ?';
            $stmt = $conn->prepare($query);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Delete publication error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get member full name helper
     */
    public static function getMemberFullName($publication)
    {
        $name = '';

        if (!empty($publication['gelar_depan'])) {
            $name .= $publication['gelar_depan'] . ' ';
        }

        $name .= $publication['member_name'];

        if (!empty($publication['gelar_belakang'])) {
            $name .= ', ' . $publication['gelar_belakang'];
        }

        return $name;
    }
}
