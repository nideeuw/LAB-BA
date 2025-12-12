<?php
include __DIR__ . '/../layout/navbar.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings | LAB-BA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/lab_bookings.css">
</head>

<body>
    <div class="container container-medium">
        <a href="<?php echo $base_url; ?>/lab_bookings" class="back-btn">← Back to Calendar</a>

        <h1>Bookings</h1>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="success-msg">
                <?php echo $_SESSION['success_message'];
                unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="error-box">
                <?php echo $_SESSION['error_message'];
                unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <!-- DROPDOWN SELECT USER -->
        <div style="margin-bottom: 2rem;">
            <form method="GET" action="<?php echo $base_url; ?>/lab_bookings/bookings">
                <div class="form-group" style="max-width: 500px; margin: 0;">
                    <label for="id_peminjam" style="font-weight: 600; margin-bottom: 0.5rem; display: block;">Pilih Dosen/Staff:</label>
                    <div style="display: flex; gap: 0.75rem;">
                        <select id="id_peminjam" name="id_peminjam" class="form-select" style="flex: 1; padding: 0.75rem; border: 2px solid #cbd5e0; border-radius: 8px; font-size: 1rem;" onchange="this.form.submit()">
                            <option value="">-- Pilih Dosen/Staff --</option>
                            <?php foreach ($allBorrowers as $borrower): ?>
                                <option value="<?php echo $borrower['id']; ?>" <?php echo ($selectedBorrowerId == $borrower['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($borrower['nama']) . ' (' . ucfirst($borrower['category']) . ')'; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary" style="padding: 0.75rem 1.5rem; white-space: nowrap;">Lihat</button>
                    </div>
                </div>
            </form>
        </div>

        <?php if ($selectedBorrower): ?>
            <div style="background: #f0f9ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-bottom: 1.5rem; border-radius: 8px;">
                <p style="margin: 0; color: #1e40af; font-weight: 600;">
                    Showing bookings for: <?php echo htmlspecialchars($selectedBorrower['nama']); ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if (!empty($bookings)): ?>
            <div class="table-scroll-wrapper">
                <table class="my-bookings">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td>
                                    <?php
                                    $start = date('d M Y', strtotime($booking['tanggal_mulai']));
                                    $end = date('d M Y', strtotime($booking['tanggal_selesai']));
                                    if ($start == $end) {
                                        echo $start;
                                    } else {
                                        echo $start . ' - ' . $end;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo date('H:i', strtotime($booking['jam_mulai'])); ?> -
                                    <?php echo date('H:i', strtotime($booking['jam_selesai'])); ?>
                                </td>
                                <td><?php echo htmlspecialchars(substr($booking['deskripsi'] ?? '-', 0, 50)) . (strlen($booking['deskripsi'] ?? '') > 50 ? '...' : ''); ?></td>
                                <td>
                                    <?php
                                    $statusClass = 'badge-' . $booking['status'];
                                    $statusLabels = [
                                        'pending' => 'Pending',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                        'in_use' => 'In Use',
                                        'canceled' => 'Canceled'
                                    ];
                                    $statusLabel = $statusLabels[$booking['status']] ?? ucfirst($booking['status']);
                                    echo "<span class='badge {$statusClass}'>{$statusLabel}</span>";

                                    if (in_array($booking['status'], ['rejected', 'canceled']) && !empty($booking['rejection_reason'])) {
                                        echo "<div class='rejection-reason'>Reason: " . htmlspecialchars($booking['rejection_reason']) . "</div>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if (in_array($booking['status'], ['pending', 'approved'])): ?>
                                        <button type="button"
                                            class="btn btn-cancel"
                                            style="padding: 0.5rem 1rem; font-size: 0.85rem;"
                                            onclick="showCancelModal(<?php echo $booking['id']; ?>, <?php echo $booking['id_peminjam']; ?>)">
                                            Cancel
                                        </button>
                                    <?php else: ?>
                                        <span style="color: #9ca3af; font-size: 0.85rem;">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif ($selectedBorrowerId): ?>
            <div class="no-data">
                <p style="font-size: 1.1rem; margin-bottom: 1rem;">No bookings found for this user</p>
                <a href="<?php echo $base_url; ?>/lab_bookings/create" class="btn btn-primary">Book Lab Now</a>
            </div>
        <?php else: ?>
            <div class="no-data">
                <p style="font-size: 1.1rem; margin-bottom: 1rem;">Please select a user to view bookings</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- CANCEL BOOKING MODAL -->
    <div class="booking-modal" id="cancelModal">
        <div class="booking-modal-content" style="max-width: 500px;">
            <button class="booking-modal-close" onclick="closeCancelModal()">&times;</button>

            <div class="booking-modal-header" style="border-bottom: 2px solid #fee2e2;">
                <h2 style="color: #dc2626; margin: 0; font-size: 1.3rem;">⚠️ Cancel Booking</h2>
            </div>

            <form method="POST" action="<?php echo $base_url; ?>/lab_bookings/cancel" id="cancelForm">
                <div class="booking-modal-body">
                    <input type="hidden" name="id" id="cancelBookingId">
                    <input type="hidden" name="id_peminjam" id="cancelBorrowerId">

                    <div style="background: #fef2f2; border-left: 4px solid #dc2626; padding: 1rem; margin-bottom: 1.5rem; border-radius: 8px;">
                        <p style="margin: 0; color: #991b1b; font-weight: 500;">
                            Apakah Anda yakin ingin membatalkan booking ini?
                        </p>
                    </div>

                    <div class="form-group">
                        <label for="cancel_reason" style="font-weight: 600; color: #374151;">Alasan Pembatalan <span style="color: #dc2626;">*</span></label>
                        <textarea
                            id="cancel_reason"
                            name="cancel_reason"
                            rows="4"
                            required
                            style="width: 100%; padding: 0.75rem; border: 2px solid #cbd5e0; border-radius: 8px; font-family: 'Poppins', sans-serif;"
                            placeholder="e.g., Acara dibatalkan karena ada keperluan mendadak"></textarea>
                        <small style="color: #6b7280; font-size: 0.85rem;">Minimal 10 karakter</small>
                    </div>
                </div>

                <div style="display: flex; gap: 0.75rem; padding: 1.5rem; border-top: 1px solid #e5e7eb;">
                    <button type="button" onclick="closeCancelModal()" class="btn btn-secondary" style="flex: 1; text-align: center;">Batal</button>
                    <button type="submit" class="btn btn-cancel" style="flex: 1; text-align: center; background: #dc2626; color: white;">Batalkan Booking</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showCancelModal(bookingId, borrowerId) {
            document.getElementById('cancelBookingId').value = bookingId;
            document.getElementById('cancelBorrowerId').value = borrowerId;
            document.getElementById('cancel_reason').value = '';
            document.getElementById('cancelModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeCancelModal() {
            document.getElementById('cancelModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('cancelModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCancelModal();
            }
        });

        document.getElementById('cancelForm').addEventListener('submit', function(e) {
            const reason = document.getElementById('cancel_reason').value.trim();
            if (reason.length < 10) {
                e.preventDefault();
                alert('Alasan pembatalan minimal 10 karakter!');
                return false;
            }
        });
    </script>

    <?php include __DIR__ . '/../layout/footer.php'; ?>
</body>

</html>