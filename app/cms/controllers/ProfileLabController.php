<?php

class ProfileLabController extends Controller
{
    public function index($conn, $params = [])
    {
        checkLogin();

        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $total = ProfileLabModel::getTotalProfileLabs($conn);
        $profiles = ProfileLabModel::getProfileLabsPaginated($conn, $page, $pageSize);
        $dataLength = count($profiles);

        $data = [
            'page_title' => 'Profile Lab Management',
            'active_page' => 'profile_lab',
            'base_url' => getBaseUrl(),
            'profiles' => $profiles,
            'page' => $page,
            'pageSize' => $pageSize,
            'total' => $total,
            'dataLength' => $dataLength,
            'conn' => $conn
        ];

        $this->view('cms/views/profile_lab/profile_lab_index', $data);
    }

    public function add($conn, $params = [])
    {
        checkLogin();

        $data = [
            'page_title' => 'Add Profile Lab',
            'active_page' => 'profile_lab',
            'base_url' => getBaseUrl(),
            'conn' => $conn
        ];

        $this->view('cms/views/profile_lab/profile_lab_create', $data);
    }

    public function store($conn, $params = [])
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/profile_lab');
        }

        $errors = [];

        if (empty($_POST['title'])) {
            $errors[] = 'Title is required';
        }

        if (empty($_POST['description'])) {
            $errors[] = 'Description is required';
        }

        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = ProfileLabModel::uploadImage($_FILES['image']);
            if (!$imagePath) {
                $errors[] = 'Failed to upload image. Please check file type and size (max 2MB)';
            }
        } else {
            $errors[] = 'Image is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/profile_lab/add');
        }

        $profileData = [
            'title' => trim($_POST['title']),
            'description' => trim($_POST['description']),
            'image' => $imagePath,
            'is_active' => isset($_POST['is_active']) && $_POST['is_active'] == '1'
        ];

        if ($profileData['is_active']) {
            ProfileLabModel::setActiveProfileLab(0, $conn);
        }

        $result = ProfileLabModel::createProfileLab($profileData, $conn);

        if ($result) {
            setFlash('success', 'Profile Lab created successfully!');
            redirect('/cms/profile_lab');
        } else {
            setFlash('danger', 'Failed to create Profile Lab');
            redirect('/cms/profile_lab/add');
        }
    }

    public function edit($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $profile = ProfileLabModel::getProfileLabById($id, $conn);

        if (!$profile) {
            setFlash('danger', 'Profile Lab not found');
            redirect('/cms/profile_lab');
            return;
        }

        $data = [
            'page_title' => 'Edit Profile Lab',
            'active_page' => 'profile_lab',
            'base_url' => getBaseUrl(),
            'profile' => $profile,
            'conn' => $conn
        ];

        $this->view('cms/views/profile_lab/profile_lab_edit', $data);
    }

    public function update($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/profile_lab');
        }

        $errors = [];

        if (empty($_POST['title'])) {
            $errors[] = 'Title is required';
        }

        if (empty($_POST['description'])) {
            $errors[] = 'Description is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/profile_lab/edit/' . $id);
        }

        $profileData = [
            'title' => trim($_POST['title']),
            'description' => trim($_POST['description']),
            'is_active' => isset($_POST['is_active']) && $_POST['is_active'] == '1'
        ];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = ProfileLabModel::uploadImage($_FILES['image']);
            if ($imagePath) {
                $oldProfile = ProfileLabModel::getProfileLabById($id, $conn);
                if (!empty($oldProfile['image'])) {
                    $oldImagePath = ROOT_PATH . 'assets/' . $oldProfile['image'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $profileData['image'] = $imagePath;
            }
        }

        if ($profileData['is_active']) {
            ProfileLabModel::setActiveProfileLab($id, $conn);
        }

        $result = ProfileLabModel::updateProfileLab($id, $profileData, $conn);

        if ($result) {
            setFlash('success', 'Profile Lab updated successfully!');
            redirect('/cms/profile_lab');
        } else {
            setFlash('danger', 'Failed to update Profile Lab');
            redirect('/cms/profile_lab/edit/' . $id);
        }
    }

    public function delete($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $result = ProfileLabModel::deleteProfileLab($id, $conn);

        if ($result) {
            setFlash('success', 'Profile Lab deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete Profile Lab');
        }

        redirect('/cms/profile_lab');
    }

    public function setActive($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $result = ProfileLabModel::setActiveProfileLab($id, $conn);

        if ($result) {
            setFlash('success', 'Profile Lab set as active successfully!');
        } else {
            setFlash('danger', 'Failed to set Profile Lab as active');
        }

        redirect('/cms/profile_lab');
    }
}