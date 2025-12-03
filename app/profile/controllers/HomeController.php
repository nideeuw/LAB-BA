<?php

class HomeController extends Controller
{
    public function index($conn, $params = [])
    {
        // Get base URL from koneksi.php function
        $base_url = getBaseUrl();

        // Data yang akan dikirim ke view
        $data = [
            'page_title' => 'Home - LAB-BA',
            'base_url' => $base_url,
            'conn' => $conn
        ];

        // Load view
        // Path: app/profile/views/home.php
        $this->view('profile/views/home', $data);
    }
}
