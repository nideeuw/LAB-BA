<?php
/**
 * Controller: HomeController (UPDATED)
 * Location: app/profile/controllers/HomeController.php
 * Purpose: Home page with dynamic About Us from profile_lab
 * 
 */

class HomeController extends Controller
{
    public function index($conn, $params = [])
    {
        // Get base URL
        $base_url = getBaseUrl();

        // Get active About Us data from profile_lab
        $aboutUs = ProfileLabModel::getActiveProfileLab($conn);

        // Data to pass to view
        $data = [
            'page_title' => 'Home - LAB-BA',
            'base_url' => $base_url,
            'aboutUs' => $aboutUs, // Add this for dynamic About Us
            'conn' => $conn
        ];

        // Load view
        $this->view('profile/views/home', $data);
    }
}