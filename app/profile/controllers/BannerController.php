<?php

class BannerController extends Controller
{
    /**
     * Display banner on landing page
     */
    public function index($conn, $params = [])
    {
        // Get active banner items from database
        $bannerItems = BannerModel::getActiveBanner($conn);

        // Pass data to view
        $data = [
            'page_title' => 'Banner - Laboratorium Business Analytics',
            'base_url' => getBaseUrl(),
            'bannerItems' => $bannerItems,
            'conn' => $conn
        ];

        $this->view('profile/views/banner', $data);
    }
}
