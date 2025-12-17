<?php
$page_title = 'Lab Bookings Management';
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="pc-container">
    <div class="pc-content">
        <?php include __DIR__ . '/../layout/breadcrumb.php'; ?>

        <?php
        $flash = getFlash();
        if ($flash):
        ?>
            <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $flash['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Lab Bookings List</h5>
                        <a href="<?php echo $base_url; ?>/cms/lab_bookings/add" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add Booking
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Borrower</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($bookings)): ?>
                                        <?php foreach ($bookings as $booking): ?>
                                            <tr>
                                                <td><?php echo $booking['id']; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($booking['peminjam_name'] ?? 'Unknown'); ?></strong><br>
                                                    <small class="text-muted"><?php echo htmlspecialchars($booking['peminjam_email'] ?? '-'); ?></small>
                                                </td>
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
                                                <td>
                                                    <?php
                                                    $desc = htmlspecialchars($booking['deskripsi'] ?? '-');
                                                    echo (strlen($desc) > 50) ? substr($desc, 0, 50) . '...' : $desc;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'approved' => 'success',
                                                        'rejected' => 'danger',
                                                        'in_use' => 'primary',
                                                        'canceled' => 'secondary'
                                                    ];
                                                    $statusLabels = [
                                                        'pending' => 'Pending',
                                                        'approved' => 'Approved',
                                                        'rejected' => 'Rejected',
                                                        'in_use' => 'In Use',
                                                        'canceled' => 'Canceled'
                                                    ];
                                                    $color = $statusColors[$booking['status']] ?? 'secondary';
                                                    $label = $statusLabels[$booking['status']] ?? ucfirst($booking['status']);
                                                    ?>
                                                    <span class="badge bg-<?php echo $color; ?>">
                                                        <?php echo $label; ?>
                                                    </span>
                                                    <?php if (in_array($booking['status'], ['rejected', 'canceled']) && !empty($booking['rejection_reason'])): ?>
                                                        <br><small class="text-muted"><?php echo htmlspecialchars(substr($booking['rejection_reason'], 0, 30)); ?>...</small>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group">
                                                        <?php if ($booking['status'] == 'pending'): ?>
                                                            <a href="<?php echo $base_url; ?>/cms/lab_bookings/approve/<?php echo $booking['id']; ?>"
                                                                class="btn btn-sm btn-success"
                                                                onclick="return confirm('Approve this booking?')"
                                                                title="Approve">
                                                                <i class="ti ti-check"></i>
                                                            </a>
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger"
                                                                onclick="showRejectModal(<?php echo $booking['id']; ?>)"
                                                                title="Reject">
                                                                <i class="ti ti-x"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                        <a href="<?php echo $base_url; ?>/cms/lab_bookings/edit/<?php echo $booking['id']; ?>"
                                                            class="btn btn-sm btn-info"
                                                            title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>
                                                        <a href="<?php echo $base_url; ?>/cms/lab_bookings/delete/<?php echo $booking['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Delete this booking?')"
                                                            title="Delete">
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="ti ti-calendar-off f-40"></i>
                                                    <p class="mt-2">No bookings found</p>
                                                    <a href="<?php echo $base_url; ?>/cms/lab_bookings/add" class="btn btn-primary mt-2">
                                                        <i class="ti ti-plus"></i> Add First Booking
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php include __DIR__ . '/../layout/pagination.php'; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?php echo $base_url; ?>/cms/lab_bookings/reject">
                <div class="modal-body">
                    <input type="hidden" name="id" id="rejectBookingId">
                    <div class="alert alert-danger">
                        <i class="ti ti-alert-circle"></i> <strong>Reject</strong> = booking akan ditolak dan tidak disetujui
                    </div>
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control"
                            id="rejection_reason"
                            name="rejection_reason"
                            rows="4"
                            required
                            placeholder="e.g., Lab sudah ada kelas pada jam tersebut"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$page_scripts = '
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function showRejectModal(id) {
    $("#rejectBookingId").val(id);
    $("#rejection_reason").val("");
    var modal = new bootstrap.Modal(document.getElementById("rejectModal"));
    modal.show();
}
</script>
';
include __DIR__ . '/../layout/footer.php';
?>