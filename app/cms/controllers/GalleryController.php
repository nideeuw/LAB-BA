<?php

class GalleryController extends Controller
{
    public function index($conn, $params = [])
    {
        checkLogin();

        $gallery = GalleryModel::getAllGallery($conn);

        $data = [
            'page_title' => 'Gallery Management',
            'active_page' => 'gallery',
            'base_url' => getBaseUrl(),
            'gallery' => $gallery,
            'conn' => $conn
        ];

        $this->view('cms/views/gallery/gallery_index', $data);
    }

    public function add($conn, $params = [])
    {
        checkLogin();

        $data = [
            'page_title' => 'Add Gallery',
            'active_page' => 'gallery',
            'base_url' => getBaseUrl(),
            'conn' => $conn
        ];

        $this->view('cms/views/gallery/gallery_create', $data);
    }

    public function store($conn, $params = [])
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/gallery');
        }

        $errors = [];

        if (empty($_POST['title'])) {
            $errors[] = 'Title is required';
        }

        // Validate image upload (REQUIRED for new gallery)
        $imagePath = null;
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Image is required';
        } else {
            $imagePath = GalleryModel::uploadImage($_FILES['image']);
            if (!$imagePath) {
                $errors[] = 'Failed to upload image. Please check file type and size (max 5MB)';
            }
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/gallery/add');
        }

        $galleryData = [
            'title' => trim($_POST['title']),
            'date' => !empty($_POST['date']) ? $_POST['date'] : date('Y-m-d'),
            'description' => trim($_POST['description'] ?? ''),
            'image' => $imagePath,
            'is_active' => ($_POST['is_active'] ?? '0') == '1'
        ];

        $result = GalleryModel::createGallery($galleryData, $conn);

        if ($result) {
            setFlash('success', 'Gallery item created successfully!');
            redirect('/cms/gallery');
        } else {
            setFlash('danger', 'Failed to create gallery item');
            redirect('/cms/gallery/add');
        }
    }

    public function edit($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $gallery = GalleryModel::getGalleryById($id, $conn);

        if (!$gallery) {
            setFlash('danger', 'Gallery item not found');
            redirect('/cms/gallery');
        }

        $data = [
            'page_title' => 'Edit Gallery',
            'active_page' => 'gallery',
            'base_url' => getBaseUrl(),
            'gallery' => $gallery,
            'conn' => $conn
        ];

        $this->view('cms/views/gallery/gallery_edit', $data);
    }

    public function update($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/gallery');
        }

        error_log("=== GALLERY UPDATE DEBUG ===");
        error_log("ID: " . $id);
        error_log("POST is_active: " . ($_POST['is_active'] ?? 'NOT SET'));
        error_log("POST data: " . print_r($_POST, true));

        $errors = [];

        if (empty($_POST['title'])) {
            $errors[] = 'Title is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/gallery/edit/' . $id);
        }

        $isActiveValue = ($_POST['is_active'] ?? '0') == '1';

        error_log("Processed is_active: " . ($isActiveValue ? 'TRUE' : 'FALSE'));

        $galleryData = [
            'title' => trim($_POST['title']),
            'date' => !empty($_POST['date']) ? $_POST['date'] : null,
            'description' => trim($_POST['description'] ?? ''),
            'is_active' => $isActiveValue
        ];

        error_log("Gallery data: " . print_r($galleryData, true));

        // Handle image upload if new image provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = GalleryModel::uploadImage($_FILES['image']);
            if ($imagePath) {
                // Delete old image
                $oldGallery = GalleryModel::getGalleryById($id, $conn);
                if (!empty($oldGallery['image'])) {
                    $oldImagePath = ROOT_PATH . 'assets/' . $oldGallery['image'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $galleryData['image'] = $imagePath;
            }
        }

        try {
            $result = GalleryModel::updateGallery($id, $galleryData, $conn);

            error_log("Update result: " . ($result ? 'SUCCESS' : 'FAILED'));

            if ($result) {
                setFlash('success', 'Gallery item updated successfully!');
                redirect('/cms/gallery');
            } else {
                setFlash('danger', 'Failed to update gallery item. Check error logs.');
                redirect('/cms/gallery/edit/' . $id);
            }
        } catch (Exception $e) {
            error_log("Update exception: " . $e->getMessage());
            setFlash('danger', 'Error: ' . $e->getMessage());
            redirect('/cms/gallery/edit/' . $id);
        }
    }

    public function delete($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $result = GalleryModel::deleteGallery($id, $conn);

        if ($result) {
            setFlash('success', 'Gallery item deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete gallery item');
        }

        redirect('/cms/gallery');
    }
}
