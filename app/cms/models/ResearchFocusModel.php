<?php

class ResearchFocusModel
{
    /**
     * Get all research focus items
     */
    public static function getAllResearchFocus($conn)
    {
        try {
            $query = "SELECT * FROM research_focus ORDER BY sort_order ASC, created_on DESC";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all research focus error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get research focus with pagination
     */
    public static function getResearchFocusPaginated($conn, $page = 1, $pageSize = 10)
    {
        try {
            $offset = ($page - 1) * $pageSize;
            
            $query = "SELECT * FROM research_focus 
                      ORDER BY sort_order ASC, created_on DESC 
                      LIMIT :limit OFFSET :offset";
            
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get paginated research focus error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get total count of research focus
     */
    public static function getTotalResearchFocus($conn)
    {
        try {
            $query = "SELECT COUNT(*) as total FROM research_focus";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Get total research focus error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get all active research focus items (for public view)
     */
    public static function getActiveResearchFocus($conn)
    {
        try {
            $query = "SELECT * FROM research_focus WHERE is_active = TRUE ORDER BY sort_order ASC";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get active research focus error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get research focus by ID
     */
    public static function getResearchFocusById($id, $conn)
    {
        try {
            $query = "SELECT * FROM research_focus WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get research focus by ID error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create new research focus
     */
    public static function createResearchFocus($data, $conn)
    {
        try {
            $query = "INSERT INTO research_focus (
                        title, focus_description, examples, sort_order, is_active, created_by, created_on
                      ) VALUES (
                        :title, :focus_description, :examples, :sort_order, :is_active, :created_by, NOW()
                      )";

            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                'title' => $data['title'],
                'focus_description' => $data['focus_description'],
                'examples' => $data['examples'],
                'sort_order' => $data['sort_order'] ?? 0,
                'is_active' => $data['is_active'] ?? true,
                'created_by' => $_SESSION['user_name'] ?? 'system'
            ]);

            if ($result) {
                return $conn->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Create research focus error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update research focus
     */
    public static function updateResearchFocus($id, $data, $conn)
    {
        try {
            $query = "UPDATE research_focus SET 
                        title = :title,
                        focus_description = :focus_description,
                        examples = :examples,
                        sort_order = :sort_order,
                        is_active = :is_active,
                        modified_by = :modified_by,
                        modified_on = NOW()
                      WHERE id = :id";

            $stmt = $conn->prepare($query);
            return $stmt->execute([
                'id' => $id,
                'title' => $data['title'],
                'focus_description' => $data['focus_description'],
                'examples' => $data['examples'],
                'sort_order' => $data['sort_order'] ?? 0,
                'is_active' => $data['is_active'] ? 'true' : 'false',
                'modified_by' => $_SESSION['user_name'] ?? 'system'
            ]);
        } catch (PDOException $e) {
            error_log("Update research focus error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete research focus
     */
    public static function deleteResearchFocus($id, $conn)
    {
        try {
            $query = "DELETE FROM research_focus WHERE id = :id";
            $stmt = $conn->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Delete research focus error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get next sort order
     */
    public static function getNextSortOrder($conn)
    {
        try {
            $query = "SELECT COALESCE(MAX(sort_order), 0) + 1 as next_order FROM research_focus";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['next_order'];
        } catch (PDOException $e) {
            error_log("Get next sort order error: " . $e->getMessage());
            return 1;
        }
    }
}