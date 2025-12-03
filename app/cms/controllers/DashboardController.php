<?php
/**
 * Dashboard Controller
 * File: app/cms/controllers/DashboardController.php
 */

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard
     * Route: /cms/dashboard
     */
    public function index($conn)
    {
        // Check login
        checkLogin();
        
        // Data untuk view
        $data = [
            'page_title' => 'Dashboard',
            'active_page' => 'dashboard',
            'base_url' => getBaseUrl(),
            'conn' => $conn
        ];
        
        // TODO: Ambil data statistik dari database
        // Contoh:
        // $data['total_users'] = $this->getTotalUsers($conn);
        // $data['total_members'] = $this->getTotalMembers($conn);
        
        // Load view
        $this->view('cms/views/dashboard', $data);
    }
    
    /**
     * Contoh method untuk ambil total users
     */
    private function getTotalUsers($conn)
    {
        try {
            $stmt = $conn->query("SELECT COUNT(*) as total FROM users");
            $result = $stmt->fetch();
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            return 0;
        }
    }
    
    /**
     * Contoh method untuk ambil total members
     */
    private function getTotalMembers($conn)
    {
        try {
            $stmt = $conn->query("SELECT COUNT(*) as total FROM members");
            $result = $stmt->fetch();
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            return 0;
        }
    }
}
?>