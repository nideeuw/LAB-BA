<?php

class UserBookingsController extends Controller
{
    public function index($conn)
    {
        checkLogin();

        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $total = LabBookingsModel::getTotalUserBookings($conn);
        $users = LabBookingsModel::getUserBookingsPaginated($conn, $page, $pageSize);
        $dataLength = count($users);

        $data = [
            'page_title' => 'User Bookings Management',
            'active_page' => 'user_bookings',
            'base_url' => getBaseUrl(),
            'users' => $users,
            'page' => $page,
            'pageSize' => $pageSize,
            'total' => $total,
            'dataLength' => $dataLength,
            'conn' => $conn
        ];

        $this->view('cms/views/user_bookings/user_bookings_index', $data);
    }

    public function add($conn)
    {
        checkLogin();

        $data = [
            'page_title' => 'Add User Booking',
            'active_page' => 'user_bookings',
            'base_url' => getBaseUrl(),
            'conn' => $conn
        ];

        $this->view('cms/views/user_bookings/user_bookings_create', $data);
    }

    public function store($conn)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/user_bookings');
        }

        $errors = [];

        if (empty($_POST['nama'])) {
            $errors[] = 'Nama is required';
        }
        if (empty($_POST['nip'])) {
            $errors[] = 'NIP is required';
        }
        if (empty($_POST['email'])) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }
        if (empty($_POST['no_telp'])) {
            $errors[] = 'Phone number is required';
        }
        if (empty($_POST['category'])) {
            $errors[] = 'Category is required';
        }

        if (empty($errors)) {
            $existingUser = LabBookingsModel::getUserByNip($_POST['nip'], $conn);
            if ($existingUser) {
                $errors[] = 'NIP already exists';
            }
        }

        if (empty($errors)) {
            $existingEmail = LabBookingsModel::getUserByEmail($_POST['email'], $conn);
            if ($existingEmail) {
                $errors[] = 'Email already exists';
            }
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/user_bookings/add');
        }

        $userData = [
            'nama' => trim($_POST['nama']),
            'nip' => trim($_POST['nip']),
            'email' => trim($_POST['email']),
            'no_telp' => trim($_POST['no_telp']),
            'category' => $_POST['category']
        ];

        $result = LabBookingsModel::createUserBooking($userData, $conn);

        if ($result) {
            setFlash('success', 'User booking created successfully!');
            redirect('/cms/user_bookings');
        } else {
            setFlash('danger', 'Failed to create user booking');
            redirect('/cms/user_bookings/add');
        }
    }

    public function edit($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;
        $user = LabBookingsModel::getUserBookingById($id, $conn);

        if (!$user) {
            setFlash('danger', 'User not found');
            redirect('/cms/user_bookings');
        }

        $data = [
            'page_title' => 'Edit User Booking',
            'active_page' => 'user_bookings',
            'base_url' => getBaseUrl(),
            'user' => $user,
            'conn' => $conn
        ];

        $this->view('cms/views/user_bookings/user_bookings_edit', $data);
    }

    public function update($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/user_bookings');
        }

        $errors = [];

        if (empty($_POST['nama'])) {
            $errors[] = 'Nama is required';
        }
        if (empty($_POST['nip'])) {
            $errors[] = 'NIP is required';
        }
        if (empty($_POST['email'])) {
            $errors[] = 'Email is required';
        }
        if (empty($_POST['no_telp'])) {
            $errors[] = 'Phone number is required';
        }
        if (empty($_POST['category'])) {
            $errors[] = 'Category is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/user_bookings/edit/' . $id);
        }

        $userData = [
            'nama' => trim($_POST['nama']),
            'nip' => trim($_POST['nip']),
            'email' => trim($_POST['email']),
            'no_telp' => trim($_POST['no_telp']),
            'category' => $_POST['category'],
            'is_active' => isset($_POST['is_active']) && $_POST['is_active'] == '1'
        ];

        $result = LabBookingsModel::updateUserBooking($id, $userData, $conn);

        if ($result) {
            setFlash('success', 'User booking updated successfully!');
            redirect('/cms/user_bookings');
        } else {
            setFlash('danger', 'Failed to update user booking');
            redirect('/cms/user_bookings/edit/' . $id);
        }
    }

    public function delete($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;
        $result = LabBookingsModel::deleteUserBooking($id, $conn);

        if ($result) {
            setFlash('success', 'User booking deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete user booking');
        }

        redirect('/cms/user_bookings');
    }
}
