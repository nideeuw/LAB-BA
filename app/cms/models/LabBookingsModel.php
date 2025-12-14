<?php

class LabBookingsModel
{
    /**
     * Get all bookings (for CMS)
     */
    public static function getAllBookings($conn)
    {
        try {
            $query = "SELECT lb.*, ub.nama as peminjam_name, ub.email as peminjam_email, ub.no_telp as peminjam_no_telp
                      FROM lab_bookings lb
                      LEFT JOIN user_bookings ub ON lb.id_peminjam = ub.id
                      ORDER BY lb.tanggal_mulai DESC, lb.jam_mulai DESC";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all bookings error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get bookings with pagination
     */
    public static function getBookingsPaginated($conn, $page = 1, $pageSize = 25)
    {
        try {
            $offset = ($page - 1) * $pageSize;

            $query = "SELECT lb.*, ub.nama as peminjam_name, ub.email as peminjam_email, ub.no_telp as peminjam_no_telp
                      FROM lab_bookings lb
                      LEFT JOIN user_bookings ub ON lb.id_peminjam = ub.id
                      ORDER BY lb.tanggal_mulai DESC, lb.jam_mulai DESC
                      LIMIT :limit OFFSET :offset";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get paginated bookings error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get total count of bookings
     */
    public static function getTotalBookings($conn)
    {
        try {
            $query = "SELECT COUNT(*) as total FROM lab_bookings";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Get total bookings error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get booking by ID
     */
    public static function getBookingById($id, $conn)
    {
        try {
            $query = "SELECT lb.*, ub.nama as peminjam_name, ub.email as peminjam_email, ub.no_telp as peminjam_no_telp
                      FROM lab_bookings lb
                      LEFT JOIN user_bookings ub ON lb.id_peminjam = ub.id
                      WHERE lb.id = :id";
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get booking by ID error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get weekly schedule
     */
    public static function getWeeklySchedule($startDate, $conn)
    {
        try {
            $endDate = date('Y-m-d', strtotime($startDate . ' +4 days'));

            $query = "SELECT lb.*, ub.nama as peminjam_name, ub.email as peminjam_email, ub.no_telp as peminjam_no_telp
                      FROM lab_bookings lb
                      LEFT JOIN user_bookings ub ON lb.id_peminjam = ub.id
                      WHERE lb.is_active = TRUE
                      AND lb.status IN ('pending', 'approved', 'in_use')
                      AND (
                          (lb.tanggal_mulai BETWEEN :start_date AND :end_date)
                          OR (lb.tanggal_selesai BETWEEN :start_date AND :end_date)
                          OR (lb.tanggal_mulai <= :start_date AND lb.tanggal_selesai >= :end_date)
                      )
                      ORDER BY lb.tanggal_mulai, lb.jam_mulai";

            $stmt = $conn->prepare($query);
            $stmt->execute([
                'start_date' => $startDate,
                'end_date' => $endDate
            ]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get weekly schedule error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get bookings by borrower
     */
    public static function getBookingsByBorrower($id_peminjam, $conn)
    {
        try {
            $query = "SELECT * FROM lab_bookings 
                      WHERE id_peminjam = :id_peminjam
                      ORDER BY tanggal_mulai DESC, jam_mulai DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute(['id_peminjam' => $id_peminjam]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get bookings by borrower error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Check time slot conflict
     */
    public static function checkConflict($conn, $tanggal_mulai, $tanggal_selesai, $jam_mulai, $jam_selesai, $excludeId = null)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM lab_bookings 
                      WHERE is_active = TRUE
                      AND status IN ('pending', 'approved', 'in_use')
                      AND (
                          (tanggal_mulai <= :tanggal_selesai AND tanggal_selesai >= :tanggal_mulai)
                      )
                      AND (
                          (jam_mulai < :jam_selesai AND jam_selesai > :jam_mulai)
                      )";

            if ($excludeId) {
                $query .= " AND id != :exclude_id";
            }

            $stmt = $conn->prepare($query);
            $params = [
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai,
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai
            ];

            if ($excludeId) {
                $params['exclude_id'] = $excludeId;
            }

            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Check conflict error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create new booking
     */
    public static function createBooking($data, $conn)
    {
        try {
            if (!in_array($data['status'] ?? 'pending', ['rejected', 'canceled'])) {
                if (self::checkConflict($conn, $data['tanggal_mulai'], $data['tanggal_selesai'], $data['jam_mulai'], $data['jam_selesai'])) {
                    return false;
                }
            }

            $query = "INSERT INTO lab_bookings (
                        id_peminjam, tanggal_mulai, tanggal_selesai, jam_mulai, jam_selesai, 
                        deskripsi, status, is_active, created_by, created_on
                      ) VALUES (
                        :id_peminjam, :tanggal_mulai, :tanggal_selesai, :jam_mulai, :jam_selesai,
                        :deskripsi, :status, :is_active, :created_by, NOW()
                      )";

            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                'id_peminjam' => $data['id_peminjam'],
                'tanggal_mulai' => $data['tanggal_mulai'],
                'tanggal_selesai' => $data['tanggal_selesai'],
                'jam_mulai' => $data['jam_mulai'],
                'jam_selesai' => $data['jam_selesai'],
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
     * Update booking
     */
    public static function updateBooking($id, $data, $conn)
    {
        try {
            if (!in_array($data['status'] ?? 'pending', ['rejected', 'canceled'])) {
                if (self::checkConflict($conn, $data['tanggal_mulai'], $data['tanggal_selesai'], $data['jam_mulai'], $data['jam_selesai'], $id)) {
                    return false;
                }
            }

            $query = "UPDATE lab_bookings SET 
                        id_peminjam = :id_peminjam,
                        tanggal_mulai = :tanggal_mulai,
                        tanggal_selesai = :tanggal_selesai,
                        jam_mulai = :jam_mulai,
                        jam_selesai = :jam_selesai,
                        deskripsi = :deskripsi,
                        status = :status,
                        is_active = :is_active,
                        modified_by = :modified_by,
                        modified_on = NOW()
                      WHERE id = :id";

            $stmt = $conn->prepare($query);
            return $stmt->execute([
                'id' => $id,
                'id_peminjam' => $data['id_peminjam'],
                'tanggal_mulai' => $data['tanggal_mulai'],
                'tanggal_selesai' => $data['tanggal_selesai'],
                'jam_mulai' => $data['jam_mulai'],
                'jam_selesai' => $data['jam_selesai'],
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
     * Delete booking
     */
    public static function deleteBooking($id, $conn)
    {
        try {
            $query = "DELETE FROM lab_bookings WHERE id = :id";
            $stmt = $conn->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Delete booking error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Approve booking
     */
    public static function approveBooking($id, $conn)
    {
        try {
            $query = "UPDATE lab_bookings SET 
                        status = 'approved',
                        modified_by = :modified_by,
                        modified_on = NOW()
                      WHERE id = :id";

            $stmt = $conn->prepare($query);
            return $stmt->execute([
                'id' => $id,
                'modified_by' => $_SESSION['user_name'] ?? 'admin'
            ]);
        } catch (PDOException $e) {
            error_log("Approve booking error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Reject booking
     */
    public static function rejectBooking($id, $reason, $conn)
    {
        try {
            $query = "UPDATE lab_bookings SET 
                        status = 'rejected',
                        rejection_reason = :reason,
                        modified_by = :modified_by,
                        modified_on = NOW()
                      WHERE id = :id";

            $stmt = $conn->prepare($query);
            return $stmt->execute([
                'id' => $id,
                'reason' => $reason,
                'modified_by' => $_SESSION['user_name'] ?? 'admin'
            ]);
        } catch (PDOException $e) {
            error_log("Reject booking error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cancel booking
     */
    public static function cancelBooking($id, $reason, $conn)
    {
        try {
            $query = "UPDATE lab_bookings SET 
                        status = 'canceled',
                        rejection_reason = :reason,
                        modified_by = :modified_by,
                        modified_on = NOW()
                      WHERE id = :id";

            $stmt = $conn->prepare($query);
            return $stmt->execute([
                'id' => $id,
                'reason' => $reason,
                'modified_by' => $_SESSION['user_name'] ?? 'admin'
            ]);
        } catch (PDOException $e) {
            error_log("Cancel booking error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all borrowers
     */
    public static function getAllBorrowers($conn)
    {
        try {
            $query = "SELECT id, nama, email, no_telp, category
                      FROM user_bookings 
                      WHERE category IN ('dosen', 'staff')
                      ORDER BY nama ASC";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get borrowers error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get all user bookings
     */
    public static function getAllUserBookings($conn)
    {
        try {
            $query = "SELECT * FROM user_bookings ORDER BY created_on DESC";
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all user bookings error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get user bookings with pagination
     */
    public static function getUserBookingsPaginated($conn, $page = 1, $pageSize = 25)
    {
        try {
            $offset = ($page - 1) * $pageSize;
            
            $query = "SELECT * FROM user_bookings ORDER BY created_on DESC LIMIT :limit OFFSET :offset";
            
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get paginated user bookings error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get total count of user bookings
     */
    public static function getTotalUserBookings($conn)
    {
        try {
            $query = "SELECT COUNT(*) as total FROM user_bookings";
            $stmt = $conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Get total user bookings error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get user booking by ID
     */
    public static function getUserBookingById($id, $conn)
    {
        try {
            $query = "SELECT * FROM user_bookings WHERE id = :id LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get user booking by ID error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user by NIP
     */
    public static function getUserByNip($nip, $conn)
    {
        try {
            $query = "SELECT * FROM user_bookings WHERE nip = :nip LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->execute(['nip' => $nip]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get user by NIP error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user by email
     */
    public static function getUserByEmail($email, $conn)
    {
        try {
            $query = "SELECT * FROM user_bookings WHERE email = :email LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->execute(['email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get user by email error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create user booking
     */
    public static function createUserBooking($data, $conn)
    {
        try {
            $query = "INSERT INTO user_bookings (
                        nama, nip, email, no_telp, category, is_active, created_by, created_on
                      ) VALUES (
                        :nama, :nip, :email, :no_telp, :category, TRUE, :created_by, NOW()
                      )";

            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                'nama' => $data['nama'],
                'nip' => $data['nip'],
                'email' => $data['email'],
                'no_telp' => $data['no_telp'],
                'category' => $data['category'],
                'created_by' => $data['created_by'] ?? 'self-register'
            ]);

            if ($result) {
                return $conn->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Create user booking error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update user booking
     */
    public static function updateUserBooking($id, $data, $conn)
    {
        try {
            $query = "UPDATE user_bookings SET 
                        nama = :nama,
                        nip = :nip,
                        email = :email,
                        no_telp = :no_telp,
                        category = :category,
                        is_active = :is_active,
                        modified_by = :modified_by,
                        modified_on = NOW()
                      WHERE id = :id";

            $stmt = $conn->prepare($query);
            return $stmt->execute([
                'id' => $id,
                'nama' => $data['nama'],
                'nip' => $data['nip'],
                'email' => $data['email'],
                'no_telp' => $data['no_telp'],
                'category' => $data['category'],
                'is_active' => $data['is_active'] ?? true,
                'modified_by' => $_SESSION['user_name'] ?? 'system'
            ]);
        } catch (PDOException $e) {
            error_log("Update user booking error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete user booking
     */
    public static function deleteUserBooking($id, $conn)
    {
        try {
            $query = "DELETE FROM user_bookings WHERE id = :id";
            $stmt = $conn->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Delete user booking error: " . $e->getMessage());
            return false;
        }
    }
}