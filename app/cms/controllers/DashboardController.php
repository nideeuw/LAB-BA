<?php
// app/cms/controllers/DashboardController.php

class DashboardController extends Controller
{
    // Method ini tidak memerlukan $conn, jadi method di Router hanya mengirimnya jika diperlukan
    public function index() {
        session_start();
        
        if (!isset($_SESSION['user'])) {
            header('Location: /LAB-BA/cms/login'); 
            exit;
        }

        // Gunakan $this->appPath (dari Base Controller)
        // Gunakan helper view() jika sudah diimplementasikan
        
        // Muat layout (header, sidebar)
        include $this->appPath . 'cms/views/layout/header.php'; 
        include $this->appPath . 'cms/views/layout/sidebar.php'; 
        
        // Muat konten dashboard
        include $this->appPath . 'cms/views/dashboard.php';
        
        include $this->appPath . 'cms/views/layout/footer.php'; 
    }
}