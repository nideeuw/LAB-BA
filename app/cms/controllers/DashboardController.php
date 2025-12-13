<?php
/**
 * Dashboard Controller
 * File: app/cms/controllers/DashboardController.php
 */

class DashboardController extends Controller
{
    public function index($conn)
    {
        checkLogin();
        
        // Get comprehensive statistics
        $data = [
            'page_title' => 'Dashboard',
            'active_page' => 'dashboard',
            'base_url' => getBaseUrl(),
            'conn' => $conn,
            
            // Main Statistics Cards
            'total_users' => $this->getTotalUsers($conn),
            'total_members' => $this->getTotalMembers($conn),
            'total_publications' => $this->getTotalPublications($conn),
            'total_gallery' => $this->getTotalGallery($conn),
            
            // Additional Stats
            'total_researches' => $this->getTotalResearches($conn),
            'total_bookings' => $this->getTotalBookings($conn),
            'pending_bookings' => $this->getPendingBookings($conn),
            'active_banner' => $this->getActiveBannerCount($conn),
            
            // Recent data for tables
            'recent_members' => $this->getRecentMembers($conn, 5),
            'recent_publications' => $this->getRecentPublications($conn, 5),
            'recent_bookings' => $this->getRecentBookings($conn, 5),
            
            // Activity feed
            'recent_activities' => $this->getRecentActivities($conn, 10),
        ];
        
        $this->view('cms/views/dashboard', $data);
    }
    
    // === STATISTICS METHODS ===
    
    private function getTotalUsers($conn)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM users WHERE is_active = TRUE";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("Get total users error: " . $e->getMessage());
            return 0;
        }
    }
    
    private function getTotalMembers($conn)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM members WHERE is_active = TRUE";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
    
    private function getTotalPublications($conn)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM publications WHERE is_active = TRUE";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
    
    private function getTotalGallery($conn)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM gallery WHERE is_active = TRUE";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
    
    private function getTotalResearches($conn)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM researches WHERE is_active = TRUE";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
    
    private function getTotalBookings($conn)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM lab_bookings WHERE is_active = TRUE";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
    
    private function getPendingBookings($conn)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM lab_bookings WHERE status = 'pending' AND is_active = TRUE";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
    
    private function getActiveBannerCount($conn)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM banner WHERE is_active = TRUE";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
    
    // === RECENT DATA METHODS ===
    
    private function getRecentMembers($conn, $limit = 5)
    {
        try {
            $query = "SELECT id, nama, gelar_depan, gelar_belakang, email, jabatan, created_on 
                      FROM members 
                      ORDER BY created_on DESC 
                      LIMIT :limit";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
    
    private function getRecentPublications($conn, $limit = 5)
    {
        try {
            $query = "SELECT p.id, p.title, p.year, p.journal_name,
                             m.nama, m.gelar_depan, m.gelar_belakang
                      FROM publications p
                      LEFT JOIN members m ON p.id_members = m.id
                      WHERE p.is_active = TRUE
                      ORDER BY p.created_on DESC 
                      LIMIT :limit";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
    
    private function getRecentBookings($conn, $limit = 5)
    {
        try {
            $query = "SELECT lb.id, lb.tanggal_mulai, lb.jam_mulai, lb.status, lb.deskripsi,
                             ub.nama as peminjam_name
                      FROM lab_bookings lb
                      LEFT JOIN user_bookings ub ON lb.id_peminjam = ub.id
                      ORDER BY lb.created_on DESC 
                      LIMIT :limit";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
    
    // === ACTIVITY FEED METHOD ===
    
    private function getRecentActivities($conn, $limit = 10)
    {
        try {
            $activities = [];
            
            // Recent Members (last 3)
            $query = "SELECT 'member' as type, nama as title, created_on, created_by 
                      FROM members 
                      ORDER BY created_on DESC LIMIT 3";
            $stmt = $conn->query($query);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $activities[] = [
                    'type' => 'member',
                    'icon' => 'ti ti-user-plus',
                    'color' => 'primary',
                    'title' => 'New Member Added',
                    'description' => $row['title'],
                    'created_by' => $row['created_by'] ?? 'System',
                    'time' => $this->timeAgo($row['created_on']),
                    'timestamp' => strtotime($row['created_on'])
                ];
            }
            
            // Recent Publications (last 3)
            $query = "SELECT 'publication' as type, title, created_on, created_by 
                      FROM publications 
                      WHERE is_active = TRUE
                      ORDER BY created_on DESC LIMIT 3";
            $stmt = $conn->query($query);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $activities[] = [
                    'type' => 'publication',
                    'icon' => 'ti ti-book',
                    'color' => 'info',
                    'title' => 'New Publication',
                    'description' => $row['title'],
                    'created_by' => $row['created_by'] ?? 'System',
                    'time' => $this->timeAgo($row['created_on']),
                    'timestamp' => strtotime($row['created_on'])
                ];
            }
            
            // Recent Gallery (last 2)
            $query = "SELECT 'gallery' as type, title, created_on, created_by 
                      FROM gallery 
                      WHERE is_active = TRUE
                      ORDER BY created_on DESC LIMIT 2";
            $stmt = $conn->query($query);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $activities[] = [
                    'type' => 'gallery',
                    'icon' => 'ti ti-photo',
                    'color' => 'success',
                    'title' => 'Gallery Updated',
                    'description' => $row['title'],
                    'created_by' => $row['created_by'] ?? 'System',
                    'time' => $this->timeAgo($row['created_on']),
                    'timestamp' => strtotime($row['created_on'])
                ];
            }
            
            // Recent Bookings (last 2)
            $query = "SELECT lb.created_on, lb.created_by, ub.nama as title
                      FROM lab_bookings lb
                      LEFT JOIN user_bookings ub ON lb.id_peminjam = ub.id
                      ORDER BY lb.created_on DESC LIMIT 2";
            $stmt = $conn->query($query);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $activities[] = [
                    'type' => 'booking',
                    'icon' => 'ti ti-calendar-check',
                    'color' => 'warning',
                    'title' => 'Lab Booking',
                    'description' => 'Booking by ' . ($row['title'] ?? 'Unknown'),
                    'created_by' => $row['created_by'] ?? 'System',
                    'time' => $this->timeAgo($row['created_on']),
                    'timestamp' => strtotime($row['created_on'])
                ];
            }
            
            // Sort by timestamp DESC
            usort($activities, function($a, $b) {
                return $b['timestamp'] - $a['timestamp'];
            });
            
            // Remove timestamp field and limit
            $activities = array_slice($activities, 0, $limit);
            foreach ($activities as &$activity) {
                unset($activity['timestamp']);
            }
            
            return $activities;
            
        } catch (Exception $e) {
            error_log("Get activities error: " . $e->getMessage());
            return [];
        }
    }
    
    // === HELPER METHOD ===
    
    private function timeAgo($datetime)
    {
        if (!$datetime) return 'Unknown';
        
        $timestamp = strtotime($datetime);
        $diff = time() - $timestamp;
        
        if ($diff < 60) return 'Just now';
        if ($diff < 3600) return floor($diff / 60) . ' min ago';
        if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
        if ($diff < 604800) return floor($diff / 86400) . ' days ago';
        
        return date('M d, Y', $timestamp);
    }
}