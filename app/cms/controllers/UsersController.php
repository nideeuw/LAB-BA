<?php

class UsersController extends Controller
{
    public function index($conn)
    {
        checkLogin();

        $users = UserModel::getAllUsers($conn);

        $data = [
            'page_title' => 'User Management',
            'active_page' => 'users',
            'base_url' => getBaseUrl(),
            'users' => $users,
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

        if (empty($_POST['username'])) {
            $errors[] = 'Username is required';
        }
        if (empty($_POST['password'])) {
            $errors[] = 'Password is required';
        }
        if (strlen($_POST['password']) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/users/create');
        }

        $result = UserModel::register(
            trim($_POST['username']),
            $_POST['password'],
            $conn
        );

        if ($result) {
            setFlash('success', 'User created successfully!');
            redirect('/cms/users');
        } else {
            setFlash('danger', 'Failed to create user. Username might already exist.');
            redirect('/cms/users/create');
        }
    }

    public function edit($conn, $id)
    {
        checkLogin();

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

    public function update($conn, $id)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/users');
        }

        $errors = [];

        if (empty($_POST['username'])) {
            $errors[] = 'Username is required';
        }

        // Password optional saat update
        if (!empty($_POST['password']) && strlen($_POST['password']) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/users/edit/' . $id);
        }

        $userData = [
            'username' => trim($_POST['username'])
        ];

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

    public function delete($conn, $id)
    {
        checkLogin();

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
