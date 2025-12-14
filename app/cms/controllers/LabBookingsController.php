<?php

class LabBookingsController extends Controller
{
    public function index($conn)
    {
        checkLogin();

        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $total = LabBookingsModel::getTotalBookings($conn);
        $bookings = LabBookingsModel::getBookingsPaginated($conn, $page, $pageSize);
        $dataLength = count($bookings);

        $data = [
            'page_title' => 'Lab Bookings Management',
            'active_page' => 'lab_bookings',
            'base_url' => getBaseUrl(),
            'bookings' => $bookings,
            'page' => $page,
            'pageSize' => $pageSize,
            'total' => $total,
            'dataLength' => $dataLength,
            'conn' => $conn
        ];

        $this->view('cms/views/lab_bookings/lab_bookings_index', $data);
    }

    public function add($conn)
    {
        checkLogin();

        $borrowers = LabBookingsModel::getAllBorrowers($conn);

        $data = [
            'page_title' => 'Add Lab Booking',
            'active_page' => 'lab_bookings',
            'base_url' => getBaseUrl(),
            'borrowers' => $borrowers,
            'conn' => $conn
        ];

        $this->view('cms/views/lab_bookings/lab_bookings_create', $data);
    }

    public function store($conn)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/lab_bookings');
        }

        $errors = [];

        if (empty($_POST['id_peminjam'])) {
            $errors[] = 'Borrower is required';
        }
        if (empty($_POST['tanggal_mulai'])) {
            $errors[] = 'Start date is required';
        }
        if (empty($_POST['tanggal_selesai'])) {
            $errors[] = 'End date is required';
        }
        if (empty($_POST['jam_mulai'])) {
            $errors[] = 'Start time is required';
        }
        if (empty($_POST['jam_selesai'])) {
            $errors[] = 'End time is required';
        }

        if (!empty($_POST['jam_mulai']) && !empty($_POST['jam_selesai'])) {
            if (strtotime($_POST['jam_selesai']) <= strtotime($_POST['jam_mulai'])) {
                $errors[] = 'End time must be after start time';
            }
        }

        if (!empty($_POST['tanggal_mulai']) && !empty($_POST['tanggal_selesai'])) {
            if (strtotime($_POST['tanggal_selesai']) < strtotime($_POST['tanggal_mulai'])) {
                $errors[] = 'End date must be after or equal start date';
            }
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/lab_bookings/add');
        }

        $bookingData = [
            'id_peminjam' => intval($_POST['id_peminjam']),
            'tanggal_mulai' => $_POST['tanggal_mulai'],
            'tanggal_selesai' => $_POST['tanggal_selesai'],
            'jam_mulai' => $_POST['jam_mulai'],
            'jam_selesai' => $_POST['jam_selesai'],
            'deskripsi' => trim($_POST['deskripsi'] ?? ''),
            'status' => $_POST['status'] ?? 'pending',
            'is_active' => isset($_POST['is_active']) && $_POST['is_active'] == '1'
        ];

        $result = LabBookingsModel::createBooking($bookingData, $conn);

        if ($result) {
            setFlash('success', 'Lab booking created successfully!');
            redirect('/cms/lab_bookings');
        } else {
            setFlash('danger', 'Failed to create booking. Time slot might be already booked.');
            redirect('/cms/lab_bookings/add');
        }
    }

    public function edit($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;
        $booking = LabBookingsModel::getBookingById($id, $conn);

        if (!$booking) {
            setFlash('danger', 'Booking not found');
            redirect('/cms/lab_bookings');
        }

        $borrowers = LabBookingsModel::getAllBorrowers($conn);

        $data = [
            'page_title' => 'Edit Lab Booking',
            'active_page' => 'lab_bookings',
            'base_url' => getBaseUrl(),
            'booking' => $booking,
            'borrowers' => $borrowers,
            'conn' => $conn
        ];

        $this->view('cms/views/lab_bookings/lab_bookings_edit', $data);
    }

    public function update($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/lab_bookings');
        }

        $errors = [];

        if (empty($_POST['id_peminjam'])) {
            $errors[] = 'Borrower is required';
        }
        if (empty($_POST['tanggal_mulai'])) {
            $errors[] = 'Start date is required';
        }
        if (empty($_POST['tanggal_selesai'])) {
            $errors[] = 'End date is required';
        }
        if (empty($_POST['jam_mulai'])) {
            $errors[] = 'Start time is required';
        }
        if (empty($_POST['jam_selesai'])) {
            $errors[] = 'End time is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/lab_bookings/edit/' . $id);
        }

        $bookingData = [
            'id_peminjam' => intval($_POST['id_peminjam']),
            'tanggal_mulai' => $_POST['tanggal_mulai'],
            'tanggal_selesai' => $_POST['tanggal_selesai'],
            'jam_mulai' => $_POST['jam_mulai'],
            'jam_selesai' => $_POST['jam_selesai'],
            'deskripsi' => trim($_POST['deskripsi'] ?? ''),
            'status' => $_POST['status'] ?? 'pending',
            'is_active' => isset($_POST['is_active']) && $_POST['is_active'] == '1'
        ];

        $result = LabBookingsModel::updateBooking($id, $bookingData, $conn);

        if ($result) {
            setFlash('success', 'Booking updated successfully!');
            redirect('/cms/lab_bookings');
        } else {
            setFlash('danger', 'Failed to update booking. Time slot might be already booked.');
            redirect('/cms/lab_bookings/edit/' . $id);
        }
    }

    public function delete($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;
        $result = LabBookingsModel::deleteBooking($id, $conn);

        if ($result) {
            setFlash('success', 'Booking deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete booking');
        }

        redirect('/cms/lab_bookings');
    }

    public function approve($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;
        $result = LabBookingsModel::approveBooking($id, $conn);

        if ($result) {
            setFlash('success', 'Booking approved successfully!');
        } else {
            setFlash('danger', 'Failed to approve booking');
        }

        redirect('/cms/lab_bookings');
    }

    public function reject($conn, $params = [])
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/lab_bookings');
        }

        $id = $_POST['id'] ?? 0;
        $reason = trim($_POST['rejection_reason'] ?? 'No reason provided');

        $result = LabBookingsModel::rejectBooking($id, $reason, $conn);

        if ($result) {
            setFlash('success', 'Booking rejected successfully!');
        } else {
            setFlash('danger', 'Failed to reject booking');
        }

        redirect('/cms/lab_bookings');
    }
}
