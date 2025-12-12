<?php
include __DIR__ . '/../layout/navbar.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Bookings | LAB-BA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/lab_bookings.css">
</head>

<body>
    <div class="container">
        <h1>Lab Bookings Calendar</h1>
        <p class="week-info">Week: <?php echo date('d M', strtotime($startDate)); ?> - <?php echo date('d M Y', strtotime($startDate . ' +4 days')); ?></p>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="success-msg">
                <?php echo $_SESSION['success_message'];
                unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <div class="actions">
            <a href="<?php echo $base_url; ?>/lab_bookings/register" class="btn btn-secondary btn-purple">
                Register User
            </a>
            <a href="<?php echo $base_url; ?>/lab_bookings/create" class="btn btn-primary">Book Lab Now</a>
            <a href="<?php echo $base_url; ?>/lab_bookings/bookings?id_peminjam=1" class="btn btn-secondary">Bookings</a>
        </div>

        <!-- GRID CALENDAR -->
        <div class="calendar-scroll-wrapper">
            <div class="grid-calendar">
                <!-- Header Row -->
                <div class="grid-header time-header">Time</div>
                <?php
                for ($i = 0; $i < 5; $i++) {
                    $date = date('D, d M', strtotime($startDate . " +{$i} days"));
                    echo "<div class='grid-header'>{$date}</div>";
                }
                ?>

                <?php
                // Build booking data for positioning
                $bookingsByDate = [];
                foreach ($bookings as $booking) {
                    $bookingStart = date('Y-m-d', strtotime($booking['tanggal_mulai']));
                    $bookingEnd = date('Y-m-d', strtotime($booking['tanggal_selesai']));

                    $currentDate = $bookingStart;
                    while (strtotime($currentDate) <= strtotime($bookingEnd)) {
                        if (!isset($bookingsByDate[$currentDate])) {
                            $bookingsByDate[$currentDate] = [];
                        }
                        $bookingsByDate[$currentDate][] = $booking;
                        $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                    }
                }

                // Render time slots and day columns
                for ($hour = 7; $hour <= 16; $hour++) {
                    // Time label
                    echo "<div class='time-label'>" . sprintf('%02d:00', $hour) . "</div>";

                    // Day columns
                    for ($day = 0; $day < 5; $day++) {
                        $currentDate = date('Y-m-d', strtotime($startDate . " +{$day} days"));
                        $cellId = "cell-{$currentDate}-{$hour}";

                        echo "<div class='day-cell' id='{$cellId}' data-date='{$currentDate}' data-hour='{$hour}'>";

                        // Check if booking starts in this hour
                        if (isset($bookingsByDate[$currentDate])) {
                            foreach ($bookingsByDate[$currentDate] as $booking) {
                                $jamMulaiTime = strtotime($booking['jam_mulai']);
                                $jamSelesaiTime = strtotime($booking['jam_selesai']);

                                $jamMulai = (int)date('H', $jamMulaiTime);
                                $menitMulai = (int)date('i', $jamMulaiTime);
                                $jamSelesai = (int)date('H', $jamSelesaiTime);
                                $menitSelesai = (int)date('i', $jamSelesaiTime);

                                // Only render if this is the START hour
                                if ($jamMulai == $hour) {
                                    // Calculate position and height
                                    $startPercent = ($menitMulai / 60) * 100;

                                    // Calculate total minutes
                                    $startTotalMinutes = ($jamMulai * 60) + $menitMulai;
                                    $endTotalMinutes = ($jamSelesai * 60) + $menitSelesai;
                                    $durationMinutes = $endTotalMinutes - $startTotalMinutes;

                                    // Height in pixels (60px per hour)
                                    $heightPx = ($durationMinutes / 60) * 60;

                                    // Status class mapping
                                    $statusClass = $booking['status'];

                                    $title = htmlspecialchars($booking['peminjam_name'] ?? 'Unknown');
                                    $timeRange = date('H:i', $jamMulaiTime) . ' - ' . date('H:i', $jamSelesaiTime);

                                    // Status labels
                                    $statusLabels = [
                                        'pending' => 'PENDING',
                                        'approved' => 'APPROVED',
                                        'rejected' => 'REJECTED',
                                        'in_use' => 'IN USE',
                                        'canceled' => 'CANCELED'
                                    ];
                                    $statusLabel = $statusLabels[$booking['status']] ?? strtoupper($booking['status']);

                                    // Build JSON data for modal
                                    $bookingJson = htmlspecialchars(json_encode([
                                        'id' => $booking['id'],
                                        'nama' => $booking['peminjam_name'] ?? 'Unknown',
                                        'email' => $booking['peminjam_email'] ?? '-',
                                        'no_telp' => $booking['peminjam_no_telp'] ?? '-',
                                        'tanggal_mulai' => date('d M Y', strtotime($booking['tanggal_mulai'])),
                                        'tanggal_selesai' => date('d M Y', strtotime($booking['tanggal_selesai'])),
                                        'jam_mulai' => date('H:i', strtotime($booking['jam_mulai'])),
                                        'jam_selesai' => date('H:i', strtotime($booking['jam_selesai'])),
                                        'deskripsi' => $booking['deskripsi'] ?? '-',
                                        'status' => $booking['status'],
                                        'rejection_reason' => $booking['rejection_reason'] ?? null
                                    ]), ENT_QUOTES);

                                    echo "<div class='booking-event {$statusClass}' style='top: {$startPercent}%; height: {$heightPx}px;' data-booking='{$bookingJson}' onclick='showBookingDetail(this)'>";
                                    echo "<div class='booking-title'>{$title}</div>";
                                    echo "<div class='booking-time-range'>{$timeRange}</div>";
                                    echo "<div class='booking-badge'>{$statusLabel}</div>";
                                    echo "</div>";
                                }
                            }
                        }

                        echo "</div>";
                    }
                }
                ?>
            </div>
        </div>

        <div class="legend">
            <div class="legend-item">
                <div class="legend-box available"></div>
                <span>Available</span>
            </div>
            <div class="legend-item">
                <div class="legend-box pending"></div>
                <span>Pending</span>
            </div>
            <div class="legend-item">
                <div class="legend-box legend-approved"></div>
                <span>Approved</span>
            </div>
            <div class="legend-item">
                <div class="legend-box rejected"></div>
                <span>Rejected</span>
            </div>
            <div class="legend-item">
                <div class="legend-box in-use"></div>
                <span>In Use</span>
            </div>
            <div class="legend-item">
                <div class="legend-box canceled"></div>
                <span>Canceled</span>
            </div>
        </div>
    </div>

    <!-- BOOKING DETAIL MODAL -->
    <div class="booking-modal" id="bookingModal">
        <div class="booking-modal-content">
            <button class="booking-modal-close" onclick="closeBookingModal()">&times;</button>

            <div class="booking-modal-header">
                <div class="booking-modal-title" id="modalNama">-</div>
                <span class="booking-modal-status" id="modalStatus">-</span>
            </div>

            <div class="booking-modal-body">
                <div class="booking-detail-row">
                    <div class="booking-detail-label">Email:</div>
                    <div class="booking-detail-value" id="modalEmail">-</div>
                </div>
                <div class="booking-detail-row">
                    <div class="booking-detail-label">No. HP:</div>
                    <div class="booking-detail-value" id="modalNoTelp">-</div>
                </div>
                <div class="booking-detail-row">
                    <div class="booking-detail-label">Tanggal Mulai:</div>
                    <div class="booking-detail-value" id="modalTanggalMulai">-</div>
                </div>
                <div class="booking-detail-row">
                    <div class="booking-detail-label">Tanggal Selesai:</div>
                    <div class="booking-detail-value" id="modalTanggalSelesai">-</div>
                </div>
                <div class="booking-detail-row">
                    <div class="booking-detail-label">Jam:</div>
                    <div class="booking-detail-value">
                        <span id="modalJamMulai">-</span> - <span id="modalJamSelesai">-</span>
                    </div>
                </div>
                <div class="booking-detail-row">
                    <div class="booking-detail-label">Deskripsi:</div>
                    <div class="booking-detail-value" id="modalDeskripsi">-</div>
                </div>
                <div class="booking-detail-row" id="modalRejectionRow" style="display: none;">
                    <div class="booking-detail-label">Alasan:</div>
                    <div class="booking-detail-value" id="modalRejectionReason" style="color: #dc2626; font-style: italic;">-</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show booking detail modal
        function showBookingDetail(element) {
            const bookingData = JSON.parse(element.getAttribute('data-booking'));

            document.getElementById('modalNama').textContent = bookingData.nama;
            document.getElementById('modalEmail').textContent = bookingData.email;
            document.getElementById('modalNoTelp').textContent = bookingData.no_telp;
            document.getElementById('modalTanggalMulai').textContent = bookingData.tanggal_mulai;
            document.getElementById('modalTanggalSelesai').textContent = bookingData.tanggal_selesai;
            document.getElementById('modalJamMulai').textContent = bookingData.jam_mulai;
            document.getElementById('modalJamSelesai').textContent = bookingData.jam_selesai;
            document.getElementById('modalDeskripsi').textContent = bookingData.deskripsi;

            const statusEl = document.getElementById('modalStatus');
            const statusLabels = {
                'pending': 'PENDING',
                'approved': 'APPROVED',
                'rejected': 'REJECTED',
                'in_use': 'IN USE',
                'canceled': 'CANCELED'
            };
            statusEl.textContent = statusLabels[bookingData.status] || bookingData.status.toUpperCase();
            statusEl.className = 'booking-modal-status ' + bookingData.status;

            // Show/hide rejection reason
            const rejectionRow = document.getElementById('modalRejectionRow');
            if ((bookingData.status === 'rejected' || bookingData.status === 'canceled') && bookingData.rejection_reason) {
                document.getElementById('modalRejectionReason').textContent = bookingData.rejection_reason;
                rejectionRow.style.display = 'flex';
            } else {
                rejectionRow.style.display = 'none';
            }

            document.getElementById('bookingModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Close modal
        function closeBookingModal() {
            document.getElementById('bookingModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close on background click
        document.getElementById('bookingModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBookingModal();
            }
        });

        // Click handler for day cells (quick book)
        document.querySelectorAll('.day-cell').forEach(cell => {
            cell.addEventListener('click', function(e) {
                // Don't trigger if clicking on booking
                if (e.target.closest('.booking-event')) return;

                const date = this.dataset.date;
                const hour = this.dataset.hour;
                const time = String(hour).padStart(2, '0') + ':00';
                const endHour = parseInt(hour) + 1;
                const endTime = String(endHour).padStart(2, '0') + ':00';

                window.location.href = '<?php echo $base_url; ?>/lab_bookings/create?date=' + date + '&start=' + time + '&end=' + endTime;
            });
        });
    </script>

    <?php include __DIR__ . '/../layout/footer.php'; ?>
</body>

</html>