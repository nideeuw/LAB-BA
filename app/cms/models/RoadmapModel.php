<?php

class RoadmapModel
{
    /**
     * Get all roadmap items
     */
    public static function getAllRoadmap($conn)
    {
        try {
            $query = "SELECT * FROM roadmap ORDER BY sort_order ASC, created_on DESC";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all roadmap error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get roadmap with pagination
     */
    public static function getRoadmapPaginated($conn, $page = 1, $pageSize = 10)
    {
        try {
            $offset = ($page - 1) * $pageSize;
            
            $query = "SELECT * FROM roadmap 
                      ORDER BY sort_order ASC, created_on DESC 
                      LIMIT :limit OFFSET :offset";
            
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get paginated roadmap error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get total count of roadmap
     */
    public static function getTotalRoadmap($conn)
    {
        try {
            $query = "SELECT COUNT(*) as total FROM roadmap";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Get total roadmap error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get all active roadmap items (for public view)
     */
    public static function getActiveRoadmap($conn)
    {
        try {
            $query = "SELECT * FROM roadmap WHERE is_active = TRUE ORDER BY sort_order ASC";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get active roadmap error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get roadmap by ID
     */
    public static function getRoadmapById($id, $conn)
    {
        try {
            $query = "SELECT * FROM roadmap WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get roadmap by ID error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create new roadmap
     */
    public static function createRoadmap($data, $conn)
    {
        try {
            $query = "INSERT INTO roadmap (title, content, sort_order, is_active, created_by, created_on) 
                      VALUES (:title, :content, :sort_order, :is_active, :created_by, NOW())";

            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                'title' => $data['title'],
                'content' => $data['content'],
                'sort_order' => $data['sort_order'] ?? 0,
                'is_active' => $data['is_active'] ?? true,
                'created_by' => $_SESSION['user_name'] ?? 'system'
            ]);

            if ($result) {
                return $conn->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Create roadmap error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update roadmap
     */
    public static function updateRoadmap($id, $data, $conn)
    {
        try {
            $query = "UPDATE roadmap SET 
                        title = :title,
                        content = :content,
                        sort_order = :sort_order,
                        is_active = :is_active,
                        modified_by = :modified_by,
                        modified_on = NOW()
                      WHERE id = :id";

            $stmt = $conn->prepare($query);
            return $stmt->execute([
                'id' => $id,
                'title' => $data['title'],
                'content' => $data['content'],
                'sort_order' => $data['sort_order'] ?? 0,
                'is_active' => $data['is_active'] ? 'true' : 'false',
                'modified_by' => $_SESSION['user_name'] ?? 'system'
            ]);
        } catch (PDOException $e) {
            error_log("Update roadmap error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete roadmap
     */
    public static function deleteRoadmap($id, $conn)
    {
        try {
            $query = "DELETE FROM roadmap WHERE id = :id";
            $stmt = $conn->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Delete roadmap error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get next sort order
     */
    public static function getNextSortOrder($conn)
    {
        try {
            $query = "SELECT COALESCE(MAX(sort_order), 0) + 1 as next_order FROM roadmap";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['next_order'];
        } catch (PDOException $e) {
            error_log("Get next sort order error: " . $e->getMessage());
            return 1;
        }
    }
}