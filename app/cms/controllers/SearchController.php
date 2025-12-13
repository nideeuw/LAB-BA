<?php
/**
 * File: app/cms/controllers/SearchController.php
 */

class SearchController extends Controller
{
    public function index($conn, $params = [])
    {
        if (!isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized',
                'results' => [],
                'count' => 0
            ]);
            return;
        }

        header('Content-Type: application/json');
        
        $query = $_GET['q'] ?? '';
        
        if (strlen($query) < 2) {
            echo json_encode([
                'success' => false,
                'message' => 'Query too short',
                'results' => [],
                'count' => 0
            ]);
            return;
        }

        try {
            $results = SearchModel::searchAll($query, $conn, 'cms', 30);
            
            echo json_encode([
                'success' => true,
                'query' => $query,
                'results' => $results,
                'count' => count($results)
            ]);
        } catch (Exception $e) {
            error_log("CMS Search API error: " . $e->getMessage());
            
            echo json_encode([
                'success' => false,
                'message' => 'Search error',
                'results' => [],
                'count' => 0
            ]);
        }
    }
}