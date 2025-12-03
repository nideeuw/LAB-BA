<?php
/**
 * Lab Bookings Model
 * File: app/cms/models/LabBookingsModel.php
 */

class LabBookingsModel
{
    /**
     * Get all lab bookings with borrower info
     */
    public static function getAllBookings($conn)
    {
        try {
            $query = 'SELECT lb.*, up.nama_lengkap as peminjam_name, up.email as peminjam_email
                      FROM peminjaman_lab lb
                      LEFT JOIN user_peminjam up ON lb.id_peminjam = up.id
                      ORDER BY lb.tanggal_mulai DESC, lb.created_on DESC';
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all bookings error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get active bookings only
     */
    public static function getActiveBookings($conn)
    {
        try {
            $query = 'SELECT lb.*, up.nama_lengkap as peminjam_name, up.email as peminjam_email
                      FROM peminjaman_lab lb
                      LEFT JOIN user_peminjam up ON lb.id_peminjam = up.id
                      WHERE lb.is_active = TRUE 
                      ORDER BY lb.tanggal_mulai DESC';
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get active bookings error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get single booking by ID
     */
    public static function getBookingById($id, $conn)
    {
        try {
            $query = 'SELECT lb.*, up.nama_lengkap as peminjam_name, up.email as peminjam_email
                      FROM peminjaman_lab lb
                      LEFT JOIN user_peminjam up ON lb.id_peminjam = up.id
                      WHERE lb.id = :id';
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get booking by ID error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create new lab booking
     */
    public static function createBooking($data, $conn)
    {
        try {
            $query = 'INSERT INTO peminjaman_lab (
                        id_peminjam, tanggal_mulai, tanggal_selesai, 
                        tanggal_dikembalikan, deskripsi, status, is_active,
                        created_by, created_on
                      ) VALUES (
                        :id_peminjam, :tanggal_mulai, :tanggal_selesai,
                        :tanggal_dikembalikan, :deskripsi, :status, :is_active,
                        :created_by, NOW()
                      )';

            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                'id_peminjam' => $data['id_peminjam'],
                'tanggal_mulai' => $data['tanggal_mulai'],
                'tanggal_selesai' => $data['tanggal_selesai'],
                'tanggal_dikembalikan' => $data['tanggal_dikembalikan'] ?? null,
                'deskripsi' => $data['deskripsi'] ?? null,
                'status' => $data['status'] ?? 'pending',
                'is_active' => $data['is_active'] ?? true,
                'created_by' => $_SESSION['user_name'] ?? 'system'
            ]);

            if ($result) {
                return $conn->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Create booking error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update lab booking
     */
    public static function updateBooking($id, $data, $conn)
    {
        try {
            $query = 'UPDATE peminjaman_lab SET 
                        id_peminjam = :id_peminjam,
                        tanggal_mulai = :tanggal_mulai,
                        tanggal_selesai = :tanggal_selesai,
                        tanggal_dikembalikan = :tanggal_dikembalikan,
                        deskripsi = :deskripsi,
                        status = :status,
                        is_active = :is_active,
                        modified_by = :modified_by,
                        modified_on = NOW()
                      WHERE id = :id';

            $stmt = $conn->prepare($query);
            return $stmt->execute([
                'id' => $id,
                'id_peminjam' => $data['id_peminjam'],
                'tanggal_mulai' => $data['tanggal_mulai'],
                'tanggal_selesai' => $data['tanggal_selesai'],
                'tanggal_dikembalikan' => $data['tanggal_dikembalikan'] ?? null,
                'deskripsi' => $data['deskripsi'] ?? null,
                'status' => $data['status'] ?? 'pending',
                'is_active' => $data['is_active'] ?? true,
                'modified_by' => $_SESSION['user_name'] ?? 'system'
            ]);
        } catch (PDOException $e) {
            error_log("Update booking error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete lab booking
     */
    public static function deleteBooking($id, $conn)
    {
        try {
            $query = 'DELETE FROM peminjaman_lab WHERE id = :id';
            $stmt = $conn->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Delete booking error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update booking status only
     */
    public static function updateStatus($id, $status, $conn)
    {
        try {
            $query = 'UPDATE peminjaman_lab SET 
                        status = :status,
                        modified_by = :modified_by,
                        modified_on = NOW()
                      WHERE id = :id';
            
            $stmt = $conn->prepare($query);
            return $stmt->execute([
                'id' => $id,
                'status' => $status,
                'modified_by' => $_SESSION['user_name'] ?? 'system'
            ]);
        } catch (PDOException $e) {
            error_log("Update status error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all borrowers (user_peminjam) for dropdown
     */
    public static function getAllBorrowers($conn)
    {
        try {
            $query = 'SELECT id, nama_lengkap, email, no_hp 
                      FROM user_peminjam 
                      ORDER BY nama_lengkap ASC';
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get borrowers error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get bookings by status
     */
    public static function getBookingsByStatus($status, $conn)
    {
        try {
            $query = 'SELECT lb.*, up.nama_lengkap as peminjam_name
                      FROM peminjaman_lab lb
                      LEFT JOIN user_peminjam up ON lb.id_peminjam = up.id
                      WHERE lb.status = :status
                      ORDER BY lb.tanggal_mulai DESC';
            $stmt = $conn->prepare($query);
            $stmt->execute(['status' => $status]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get bookings by status error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get bookings by date range
     */
    public static function getBookingsByDateRange($startDate, $endDate, $conn)
    {
        try {
            $query = 'SELECT lb.*, up.nama_lengkap as peminjam_name
                      FROM peminjaman_lab lb
                      LEFT JOIN user_peminjam up ON lb.id_peminjam = up.id
                      WHERE lb.tanggal_mulai >= :start_date 
                      AND lb.tanggal_selesai <= :end_date
                      ORDER BY lb.tanggal_mulai DESC';
            $stmt = $conn->prepare($query);
            $stmt->execute([
                'start_date' => $startDate,
                'end_date' => $endDate
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get bookings by date range error: " . $e->getMessage());
            return [];
        }
    }
}