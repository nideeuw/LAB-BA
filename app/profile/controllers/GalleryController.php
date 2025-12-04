<?php

class GalleryController extends Controller
{
    /**
     * Display gallery page (landing page)
     */
    public function index($conn, $params = [])
    {
        // Get active gallery items from database
        $galleryItems = GalleryModel::getActiveGallery($conn);

        // Pass data to view
        $data = [
            'page_title' => 'Gallery - Laboratorium Business Analytics',
            'base_url' => getBaseUrl(),
            'galleryItems' => $galleryItems,
            'conn' => $conn
        ];

        $this->view('profile/views/gallery', $data);
    }
}