<?php

class LabBookingsController extends Controller
{
    public function index($conn, $params = [])
    {
        $startDate = date('Y-m-d', strtotime('monday this week'));
        $bookings = LabBookingsModel::getWeeklySchedule($startDate, $conn);

        $data = [
            'page_title' => 'Lab Bookings',
            'base_url' => getBaseUrl(),
            'bookings' => $bookings,
            'startDate' => $startDate,
            'conn' => $conn
        ];

        $this->view('profile/views/lab_bookings/index', $data);
    }

    public function create($conn, $params = [])
    {
        $borrowers = LabBookingsModel::getAllBorrowers($conn);

        // Load ContactModel for guidelines modal
        $contactInfo = ContactModel::getActiveContact($conn);

        $data = [
            'page_title' => 'Book Lab',
            'base_url' => getBaseUrl(),
            'borrowers' => $borrowers,
            'contactInfo' => $contactInfo,
            'conn' => $conn
        ];

        $this->view('profile/views/lab_bookings/create', $data);
    }

    public function store($conn, $params = [])
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/lab_bookings');
        }

        $errors = [];

        if (empty($_POST['id_peminjam'])) {
            $errors[] = 'Pilih dosen peminjam';
        }
        if (empty($_POST['tanggal_mulai'])) {
            $errors[] = 'Tanggal mulai harus diisi';
        }
        if (empty($_POST['tanggal_selesai'])) {
            $errors[] = 'Tanggal selesai harus diisi';
        }
        if (empty($_POST['jam_mulai'])) {
            $errors[] = 'Jam mulai harus diisi';
        }
        if (empty($_POST['jam_selesai'])) {
            $errors[] = 'Jam selesai harus diisi';
        }
        if (empty($_POST['deskripsi'])) {
            $errors[] = 'Deskripsi harus diisi';
        }

        if (!empty($_POST['jam_mulai']) && !empty($_POST['jam_selesai'])) {
            if (strtotime($_POST['jam_selesai']) <= strtotime($_POST['jam_mulai'])) {
                $errors[] = 'Jam selesai harus setelah jam mulai';
            }
        }

        if (!empty($_POST['tanggal_mulai']) && !empty($_POST['tanggal_selesai'])) {
            if (strtotime($_POST['tanggal_selesai']) < strtotime($_POST['tanggal_mulai'])) {
                $errors[] = 'Tanggal selesai harus setelah atau sama dengan tanggal mulai';
            }
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            redirect('/lab_bookings/create');
        }

        $bookingData = [
            'id_peminjam' => intval($_POST['id_peminjam']),
            'tanggal_mulai' => $_POST['tanggal_mulai'],
            'tanggal_selesai' => $_POST['tanggal_selesai'],
            'jam_mulai' => $_POST['jam_mulai'] . ':00',
            'jam_selesai' => $_POST['jam_selesai'] . ':00',
            'deskripsi' => trim($_POST['deskripsi']),
            'status' => 'pending',
            'is_active' => true
        ];

        $result = LabBookingsModel::createBooking($bookingData, $conn);

        if ($result) {
            $_SESSION['success_message'] = 'Booking berhasil diajukan! Status: Pending approval.';
            redirect('/lab_bookings');
        } else {
            $_SESSION['form_errors'] = ['Booking gagal. Jam tersebut sudah dibooking.'];
            $_SESSION['form_data'] = $_POST;
            redirect('/lab_bookings/create');
        }
    }

    public function bookings($conn, $params = [])
    {
        // Get all borrowers for dropdown
        $allBorrowers = LabBookingsModel::getAllBorrowers($conn);

        // Get selected borrower from GET parameter
        $selectedBorrowerId = $_GET['id_peminjam'] ?? '';

        // Initialize variables
        $bookings = [];
        $selectedBorrower = null;

        // Get bookings if user selected
        if ($selectedBorrowerId) {
            $bookings = LabBookingsModel::getBookingsByBorrower($selectedBorrowerId, $conn);
            $selectedBorrower = LabBookingsModel::getUserBookingById($selectedBorrowerId, $conn);
        }

        $data = [
            'page_title' => 'Bookings',
            'base_url' => getBaseUrl(),
            'allBorrowers' => $allBorrowers,
            'selectedBorrowerId' => $selectedBorrowerId,
            'bookings' => $bookings,
            'selectedBorrower' => $selectedBorrower,
            'conn' => $conn
        ];

        $this->view('profile/views/lab_bookings/bookings', $data);
    }

    public function cancel($conn, $params = [])
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/lab_bookings/bookings');
        }

        $id = $_POST['id'] ?? 0;
        $reason = trim($_POST['cancel_reason'] ?? '');

        if (empty($reason)) {
            $_SESSION['error_message'] = 'Alasan pembatalan harus diisi';
            redirect('/lab_bookings/bookings?id_peminjam=' . ($_POST['id_peminjam'] ?? ''));
        }

        if (strlen($reason) < 10) {
            $_SESSION['error_message'] = 'Alasan pembatalan minimal 10 karakter';
            redirect('/lab_bookings/bookings?id_peminjam=' . ($_POST['id_peminjam'] ?? ''));
        }

        // Get booking details
        $booking = LabBookingsModel::getBookingById($id, $conn);

        if (!$booking) {
            $_SESSION['error_message'] = 'Booking tidak ditemukan';
            redirect('/lab_bookings/bookings');
        }

        // Only pending and approved can be canceled
        if (!in_array($booking['status'], ['pending', 'approved'])) {
            $_SESSION['error_message'] = 'Booking tidak bisa dibatalkan (status: ' . $booking['status'] . ')';
            redirect('/lab_bookings/bookings?id_peminjam=' . $booking['id_peminjam']);
        }

        $result = LabBookingsModel::cancelBooking($id, $reason, $conn);

        if ($result) {
            $_SESSION['success_message'] = 'Booking berhasil dibatalkan!';
        } else {
            $_SESSION['error_message'] = 'Gagal membatalkan booking';
        }

        redirect('/lab_bookings/bookings?id_peminjam=' . $booking['id_peminjam']);
    }

    // ============ REGISTER METHODS ============

    public function register($conn, $params = [])
    {
        $data = [
            'page_title' => 'Register User Booking',
            'base_url' => getBaseUrl(),
            'conn' => $conn
        ];

        $this->view('profile/views/lab_bookings/register', $data);
    }

    public function registerStore($conn, $params = [])
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/lab_bookings/register');
        }

        $errors = [];

        if (empty($_POST['nama'])) {
            $errors[] = 'Nama lengkap harus diisi';
        }
        if (empty($_POST['nip'])) {
            $errors[] = 'NIP harus diisi';
        }
        if (empty($_POST['email'])) {
            $errors[] = 'Email harus diisi';
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid';
        }
        if (empty($_POST['no_telp'])) {
            $errors[] = 'No. HP harus diisi';
        } elseif (!preg_match('/^[0-9]{10,15}$/', $_POST['no_telp'])) {
            $errors[] = 'No. HP harus 10-15 digit angka';
        }
        if (empty($_POST['category'])) {
            $errors[] = 'Kategori harus dipilih';
        }

        // Check if NIP already exists
        if (empty($errors)) {
            $existingUser = LabBookingsModel::getUserByNip($_POST['nip'], $conn);
            if ($existingUser) {
                $errors[] = 'NIP sudah terdaftar';
            }
        }

        // Check if email already exists
        if (empty($errors)) {
            $existingEmail = LabBookingsModel::getUserByEmail($_POST['email'], $conn);
            if ($existingEmail) {
                $errors[] = 'Email sudah terdaftar';
            }
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            redirect('/lab_bookings/register');
        }

        // Create user
        $userData = [
            'nama' => trim($_POST['nama']),
            'nip' => trim($_POST['nip']),
            'email' => trim($_POST['email']),
            'no_telp' => trim($_POST['no_telp']),
            'category' => $_POST['category']
        ];

        $result = LabBookingsModel::createUserBooking($userData, $conn);

        if ($result) {
            $_SESSION['success_message'] = 'Registrasi berhasil! Anda sekarang dapat melakukan booking lab.';
            redirect('/lab_bookings');
        } else {
            $_SESSION['form_errors'] = ['Registrasi gagal. Silakan coba lagi.'];
            $_SESSION['form_data'] = $_POST;
            redirect('/lab_bookings/register');
        }
    }
}
