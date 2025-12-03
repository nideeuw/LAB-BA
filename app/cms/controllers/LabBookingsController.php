<?php

/**
 * Lab Bookings Controller
 * File: app/cms/controllers/LabBookingsController.php
 */

class LabBookingsController extends Controller
{
    public function index($conn)
    {
        checkLogin();

        // Get all bookings from model
        $bookings = LabBookingsModel::getAllBookings($conn);

        $data = [
            'page_title' => 'Lab Bookings Management',
            'active_page' => 'lab_bookings',
            'base_url' => getBaseUrl(),
            'bookings' => $bookings,
            'conn' => $conn
        ];

        $this->view('cms/views/lab_bookings/lab_bookings_index', $data);
    }

    public function add($conn)
    {
        checkLogin();

        // Get borrowers list from model
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

        // Validation
        if (empty($_POST['id_peminjam'])) {
            $errors[] = 'Borrower is required';
        }
        if (empty($_POST['tanggal_mulai'])) {
            $errors[] = 'Start date is required';
        }
        if (empty($_POST['tanggal_selesai'])) {
            $errors[] = 'End date is required';
        }

        // Validate date range
        if (!empty($_POST['tanggal_mulai']) && !empty($_POST['tanggal_selesai'])) {
            if (strtotime($_POST['tanggal_selesai']) < strtotime($_POST['tanggal_mulai'])) {
                $errors[] = 'End date must be after start date';
            }
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/lab_bookings/add');
        }

        $bookingData = [
            'id_peminjam' => trim($_POST['id_peminjam']),
            'tanggal_mulai' => $_POST['tanggal_mulai'],
            'tanggal_selesai' => $_POST['tanggal_selesai'],
            'tanggal_dikembalikan' => !empty($_POST['tanggal_dikembalikan']) ? $_POST['tanggal_dikembalikan'] : null,
            'deskripsi' => trim($_POST['deskripsi'] ?? ''),
            'status' => $_POST['status'] ?? 'pending',
            'is_active' => isset($_POST['is_active']) ? true : false
        ];

        $result = LabBookingsModel::createBooking($bookingData, $conn);

        if ($result) {
            setFlash('success', 'Lab booking created successfully!');
            redirect('/cms/lab_bookings');
        } else {
            setFlash('danger', 'Failed to create lab booking');
            redirect('/cms/lab_bookings/add');
        }
    }

    public function edit($conn, $id)
    {
        checkLogin();

        // Get booking data from model
        $booking = LabBookingsModel::getBookingById($id, $conn);

        if (!$booking) {
            setFlash('danger', 'Lab booking not found');
            redirect('/cms/lab_bookings');
        }

        // Get borrowers list from model
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

    public function update($conn, $id)
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

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/lab_bookings/edit/' . $id);
        }

        $bookingData = [
            'id_peminjam' => trim($_POST['id_peminjam']),
            'tanggal_mulai' => $_POST['tanggal_mulai'],
            'tanggal_selesai' => $_POST['tanggal_selesai'],
            'tanggal_dikembalikan' => !empty($_POST['tanggal_dikembalikan']) ? $_POST['tanggal_dikembalikan'] : null,
            'deskripsi' => trim($_POST['deskripsi'] ?? ''),
            'status' => $_POST['status'] ?? 'pending',
            'is_active' => isset($_POST['is_active']) ? true : false
        ];

        $result = LabBookingsModel::updateBooking($id, $bookingData, $conn);

        if ($result) {
            setFlash('success', 'Lab booking updated successfully!');
            redirect('/cms/lab_bookings');
        } else {
            setFlash('danger', 'Failed to update lab booking');
            redirect('/cms/lab_bookings/edit/' . $id);
        }
    }

    public function delete($conn, $id)
    {
        checkLogin();

        $result = LabBookingsModel::deleteBooking($id, $conn);

        if ($result) {
            setFlash('success', 'Lab booking deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete lab booking');
        }

        redirect('/cms/lab_bookings');
    }

    public function updateStatus($conn, $id)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/lab_bookings');
        }

        $status = $_POST['status'] ?? 'pending';
        $result = LabBookingsModel::updateStatus($id, $status, $conn);

        if ($result) {
            setFlash('success', 'Booking status updated successfully!');
        } else {
            setFlash('danger', 'Failed to update booking status');
        }

        redirect('/cms/lab_bookings');
    }
}
