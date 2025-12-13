<?php
/**
 * File: app/profile/controllers/SearchController.php
 */

class SearchController extends Controller
{
    public function index($conn, $params = [])
    {
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
            $results = SearchModel::searchAll($query, $conn, 'landing', 20);
            
            echo json_encode([
                'success' => true,
                'query' => $query,
                'results' => $results,
                'count' => count($results)
            ]);
        } catch (Exception $e) {
            error_log("Search API error: " . $e->getMessage());
            
            echo json_encode([
                'success' => false,
                'message' => 'Search error',
                'results' => [],
                'count' => 0
            ]);
        }
    }
}