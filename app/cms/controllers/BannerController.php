<?php

class BannerController extends Controller
{
    public function index($conn, $params = [])
    {
        checkLogin();

        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $total = BannerModel::getTotalBanner($conn);
        $banner = BannerModel::getBannerPaginated($conn, $page, $pageSize);
        $dataLength = count($banner);

        $data = [
            'page_title' => 'Banner Management',
            'active_page' => 'banner',
            'base_url' => getBaseUrl(),
            'banner' => $banner,
            'page' => $page,
            'pageSize' => $pageSize,
            'total' => $total,
            'dataLength' => $dataLength,
            'conn' => $conn
        ];

        $this->view('cms/views/banner/banner_index', $data);
    }

    public function add($conn, $params = [])
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

    public function store($conn, $params = [])
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/banner');
        }

        $errors = [];

        $imagePath = null;
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Image is required';
        } else {
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
            setFlash('success', 'Banner created successfully!');
            redirect('/cms/banner');
        } else {
            setFlash('danger', 'Failed to create banner');
            redirect('/cms/banner/add');
        }
    }

    public function edit($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $banner = BannerModel::getBannerById($id, $conn);

        if (!$banner) {
            setFlash('danger', 'Banner not found');
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

    public function update($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/banner');
        }

        $bannerData = [
            'is_active' => isset($_POST['is_active']) ? true : false
        ];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = BannerModel::uploadImage($_FILES['image']);
            if ($imagePath) {
                $oldBanner = BannerModel::getBannerById($id, $conn);
                if (!empty($oldBanner['image'])) {
                    $oldImagePath = ROOT_PATH . 'assets/' . $oldBanner['image'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $bannerData['image'] = $imagePath;
            }
        }

        $result = BannerModel::updateBanner($id, $bannerData, $conn);

        if ($result) {
            setFlash('success', 'Banner updated successfully!');
            redirect('/cms/banner');
        } else {
            setFlash('danger', 'Failed to update banner');
            redirect('/cms/banner/edit/' . $id);
        }
    }

    public function delete($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $result = BannerModel::deleteBanner($id, $conn);

        if ($result) {
            setFlash('success', 'Banner deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete banner');
        }

        redirect('/cms/banner');
    }
}
