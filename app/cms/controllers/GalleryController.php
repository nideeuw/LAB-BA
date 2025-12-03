<?php

class GalleryController extends Controller
{
    public function index($conn)
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

    public function add($conn)
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

    public function store($conn)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/gallery');
        }

        $errors = [];

        if (empty($_POST['title'])) {
            $errors[] = 'Title is required';
        }

        // Validate image upload
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
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
            'is_active' => isset($_POST['is_active']) ? true : false
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

    public function edit($conn, $id)
    {
        checkLogin();

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

    public function update($conn, $id)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/gallery');
        }

        $errors = [];

        if (empty($_POST['title'])) {
            $errors[] = 'Title is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/gallery/edit/' . $id);
        }

        $galleryData = [
            'title' => trim($_POST['title']),
            'date' => !empty($_POST['date']) ? $_POST['date'] : null,
            'description' => trim($_POST['description'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? true : false
        ];

        // Handle image upload if new image provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = GalleryModel::uploadImage($_FILES['image']);
            if ($imagePath) {
                // Delete old image
                $oldGallery = GalleryModel::getGalleryById($id, $conn);
                if (!empty($oldGallery['image'])) {
                    $oldImagePath = ROOT_PATH . 'public/' . $oldGallery['image'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $galleryData['image'] = $imagePath;
            }
        }

        $result = GalleryModel::updateGallery($id, $galleryData, $conn);

        if ($result) {
            setFlash('success', 'Gallery item updated successfully!');
            redirect('/cms/gallery');
        } else {
            setFlash('danger', 'Failed to update gallery item');
            redirect('/cms/gallery/edit/' . $id);
        }
    }

    public function delete($conn, $id)
    {
        checkLogin();

        $result = GalleryModel::deleteGallery($id, $conn);

        if ($result) {
            setFlash('success', 'Gallery item deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete gallery item');
        }

        redirect('/cms/gallery');
    }
}
