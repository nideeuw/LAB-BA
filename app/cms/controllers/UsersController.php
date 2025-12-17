<?php

class UsersController extends Controller
{
    public function index($conn)
    {
        checkLogin();

        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $total = UserModel::getTotalUsers($conn);
        $users = UserModel::getUsersPaginated($conn, $page, $pageSize);
        $dataLength = count($users);

        $data = [
            'page_title' => 'User Management',
            'active_page' => 'users',
            'base_url' => getBaseUrl(),
            'users' => $users,
            'page' => $page,
            'pageSize' => $pageSize,
            'total' => $total,
            'dataLength' => $dataLength,
            'conn' => $conn
        ];

        $this->view('cms/views/users/users_index', $data);
    }

    public function create($conn)
    {
        checkLogin();

        $data = [
            'page_title' => 'Add User',
            'active_page' => 'users',
            'base_url' => getBaseUrl(),
            'conn' => $conn
        ];

        $this->view('cms/views/users/users_create', $data);
    }

    public function store($conn)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/users');
        }

        $errors = [];

        // Validasi
        if (empty($_POST['username'])) {
            $errors[] = 'Username is required';
        }
        if (empty($_POST['email'])) {
            $errors[] = 'Email is required';
        }
        if (empty($_POST['password'])) {
            $errors[] = 'Password is required';
        }
        if (strlen($_POST['password']) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        }
        if ($_POST['password'] !== $_POST['confirm_password']) {
            $errors[] = 'Passwords do not match';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/users/create');
        }

        // Prepare data
        $userData = [
            'username' => trim($_POST['username']),
            'password' => $_POST['password'],
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'created_by' => $_SESSION['user_id'] ?? null
        ];

        // Add optional fields
        if (!empty($_POST['full_name'])) {
            $userData['full_name'] = trim($_POST['full_name']);
        }

        if (!empty($_POST['email'])) {
            $userData['email'] = trim($_POST['email']);
        }

        if (isset($_POST['role_id']) && $_POST['role_id'] !== '') {
            $userData['role_id'] = intval($_POST['role_id']);
        }

        $result = UserModel::register($userData, $conn);

        if ($result) {
            setFlash('success', 'User created successfully!');
            redirect('/cms/users');
        } else {
            setFlash('danger', 'Failed to create user. Username might already exist.');
            redirect('/cms/users/create');
        }
    }

    public function edit($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $user = UserModel::getUserById($id, $conn);

        if (!$user) {
            setFlash('danger', 'User not found');
            redirect('/cms/users');
        }

        $data = [
            'page_title' => 'Edit User',
            'active_page' => 'users',
            'base_url' => getBaseUrl(),
            'user' => $user,
            'conn' => $conn
        ];

        $this->view('cms/views/users/users_edit', $data);
    }

    public function update($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/users');
        }

        $errors = [];

        if (empty($_POST['username'])) {
            $errors[] = 'Username is required';
        }

        if (!empty($_POST['password']) && strlen($_POST['password']) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        }

        if (!empty($_POST['password']) && $_POST['password'] !== $_POST['confirm_password']) {
            $errors[] = 'Passwords do not match';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/users/edit/' . $id);
        }

        $userData = [
            'username' => trim($_POST['username']),
            'modified_by' => $_SESSION['user_id'] ?? null
        ];

        if (isset($_POST['full_name'])) {
            $userData['full_name'] = !empty($_POST['full_name']) ? trim($_POST['full_name']) : null;
        }

        if (isset($_POST['email'])) {
            $userData['email'] = !empty($_POST['email']) ? trim($_POST['email']) : null;
        }

        if (isset($_POST['role_id'])) {
            $userData['role_id'] = $_POST['role_id'] !== '' ? intval($_POST['role_id']) : null;
        }

        if (isset($_POST['is_active'])) {
            $userData['is_active'] = 1;
        } else {
            $userData['is_active'] = 0;
        }

        if (!empty($_POST['password'])) {
            $userData['password'] = $_POST['password'];
        }

        $result = UserModel::updateUser($id, $userData, $conn);

        if ($result) {
            setFlash('success', 'User updated successfully!');
            redirect('/cms/users');
        } else {
            setFlash('danger', 'Failed to update user');
            redirect('/cms/users/edit/' . $id);
        }
    }

    public function delete($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        // Prevent deleting yourself
        if ($id == $_SESSION['user_id']) {
            setFlash('danger', 'You cannot delete your own account!');
            redirect('/cms/users');
        }

        $result = UserModel::deleteUser($id, $conn);

        if ($result) {
            setFlash('success', 'User deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete user');
        }

        redirect('/cms/users');
    }
}