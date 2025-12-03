<?php

class BannerController extends Controller
{
    public function index($conn)
    {
        checkLogin();

        $banner = BannerModel::getAllBanner($conn);

        $data = [
            'page_title' => 'Banner Management',
            'active_page' => 'banner',
            'base_url' => getBaseUrl(),
            'banner' => $banner,
            'conn' => $conn
        ];

        $this->view('cms/views/banner/banner_index', $data);
    }

    public function add($conn)
    {
        checkLogin();

        $data = [
            'page_title' => 'Add Banner',
            'active_page' => 'banner',
            'base_url' => getBaseUrl(),
            'conn' => $conn
        ];

        $this->view('cms/views/banner/banner_create', $data);
    }

    public function store($conn)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/banner');
        }

        $errors = [];

        if (empty($_POST['title'])) {
            $errors[] = 'Title is required';
        }

        // Validate image upload
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = BannerModel::uploadImage($_FILES['image']);
            if (!$imagePath) {
                $errors[] = 'Failed to upload image. Please check file type and size (max 5MB)';
            }
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/banner/add');
        }

        $bannerData = [
            'image' => $imagePath,
            'is_active' => isset($_POST['is_active']) ? true : false
        ];

        $result = BannerModel::createBanner($bannerData, $conn);

        if ($result) {
            setFlash('success', 'Banner item created successfully!');
            redirect('/cms/banner');
        } else {
            setFlash('danger', 'Failed to create banner item');
            redirect('/cms/banner/add');
        }
    }

    public function edit($conn, $id)
    {
        checkLogin();

        $banner = BannerModel::getBannerById($id, $conn);

        if (!$banner) {
            setFlash('danger', 'Banner item not found');
            redirect('/cms/banner');
        }

        $data = [
            'page_title' => 'Edit Banner',
            'active_page' => 'banner',
            'base_url' => getBaseUrl(),
            'banner' => $banner,
            'conn' => $conn
        ];

        $this->view('cms/views/banner/banner_edit', $data);
    }

    public function update($conn, $id)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/banner');
        }

        $errors = [];

        if (empty($_POST['title'])) {
            $errors[] = 'Title is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/banner/edit/' . $id);
        }

        $bannerData = [
            'is_active' => isset($_POST['is_active']) ? true : false
        ];

        // Handle image upload if new image provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = BannerModel::uploadImage($_FILES['image']);
            if ($imagePath) {
                // Delete old image
                $oldBanner = BannerModel::getBannerById($id, $conn);
                if (!empty($oldBanner['image'])) {
                    $oldImagePath = ROOT_PATH . 'public/' . $oldBanner['image'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $bannerData['image'] = $imagePath;
            }
        }

        $result = BannerModel::updateBanner($id, $bannerData, $conn);

        if ($result) {
            setFlash('success', 'Banner item updated successfully!');
            redirect('/cms/banner');
        } else {
            setFlash('danger', 'Failed to update banner item');
            redirect('/cms/banner/edit/' . $id);
        }
    }

    public function delete($conn, $id)
    {
        checkLogin();

        $result = BannerModel::deleteBanner($id, $conn);

        if ($result) {
            setFlash('success', 'Banner item deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete banner item');
        }

        redirect('/cms/banner');
    }
}
