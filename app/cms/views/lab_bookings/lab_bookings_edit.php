<?php
$page_title = 'Edit Lab Booking';
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
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Edit Booking #<?php echo $booking['id']; ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/lab_bookings/update/<?php echo $booking['id']; ?>" method="POST" id="bookingForm">

                            <div class="mb-3">
                                <label for="id_peminjam" class="form-label">Borrower <span class="text-danger">*</span></label>
                                <select class="form-select" id="id_peminjam" name="id_peminjam" required>
                                    <option value="">-- Select Borrower --</option>
                                    <?php foreach ($borrowers as $borrower): ?>
                                        <option value="<?php echo $borrower['id']; ?>" <?php echo ($borrower['id'] == $booking['id_peminjam']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($borrower['nama']); ?> (<?php echo ucfirst($borrower['category']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_mulai" class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="date"
                                        class="form-control"
                                        id="tanggal_mulai"
                                        name="tanggal_mulai"
                                        value="<?php echo $booking['tanggal_mulai']; ?>"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_selesai" class="form-label">End Date <span class="text-danger">*</span></label>
                                    <input type="date"
                                        class="form-control"
                                        id="tanggal_selesai"
                                        name="tanggal_selesai"
                                        value="<?php echo $booking['tanggal_selesai']; ?>"
                                        required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jam_mulai" class="form-label">Start Time <span class="text-danger">*</span></label>
                                    <input type="time" 
                                        class="form-control" 
                                        id="jam_mulai" 
                                        name="jam_mulai" 
                                        min="07:00" 
                                        max="17:00"
                                        value="<?php echo substr($booking['jam_mulai'], 0, 5); ?>"
                                        required>
                                    <small class="text-muted">Lab hours: 07:00 - 17:00</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jam_selesai" class="form-label">End Time <span class="text-danger">*</span></label>
                                    <input type="time" 
                                        class="form-control" 
                                        id="jam_selesai" 
                                        name="jam_selesai" 
                                        min="07:00" 
                                        max="17:00"
                                        value="<?php echo substr($booking['jam_selesai'], 0, 5); ?>"
                                        required>
                                    <small class="text-muted">Lab hours: 07:00 - 17:00</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Description</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"><?php echo htmlspecialchars($booking['deskripsi'] ?? ''); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="pending" <?php echo ($booking['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="approved" <?php echo ($booking['status'] == 'approved') ? 'selected' : ''; ?>>Approved</option>
                                    <option value="rejected" <?php echo ($booking['status'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                    <option value="in_use" <?php echo ($booking['status'] == 'in_use') ? 'selected' : ''; ?>>In Use</option>
                                    <option value="canceled" <?php echo ($booking['status'] == 'canceled') ? 'selected' : ''; ?>>Canceled</option>
                                </select>
                            </div>

                            <!-- SHOW REJECTION REASON IF EXISTS -->
                            <?php if (in_array($booking['status'], ['rejected', 'canceled']) && !empty($booking['rejection_reason'])): ?>
                                <div class="mb-3">
                                    <label class="form-label">
                                        <?php echo ($booking['status'] == 'rejected') ? 'Rejection Reason' : 'Cancellation Reason'; ?>
                                    </label>
                                    <div class="alert alert-<?php echo ($booking['status'] == 'rejected') ? 'danger' : 'secondary'; ?>">
                                        <i class="ti ti-info-circle"></i> 
                                        <?php echo htmlspecialchars($booking['rejection_reason']); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?php echo $booking['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/lab_bookings" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                                <a href="<?php echo $base_url; ?>/cms/lab_bookings/delete/<?php echo $booking['id']; ?>"
                                    class="btn btn-danger ms-auto"
                                    onclick="return confirm('Delete this booking?')">
                                    <i class="ti ti-trash"></i> Delete
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card bg-light-info">
                    <div class="card-body">
                        <h6 class="mb-3"><i class="ti ti-info-circle"></i> Booking Info</h6>
                        <dl class="row mb-0">
                            <dt class="col-sm-5">Booking ID:</dt>
                            <dd class="col-sm-7">#<?php echo $booking['id']; ?></dd>

                            <dt class="col-sm-5">Current Status:</dt>
                            <dd class="col-sm-7">
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
                            </dd>

                            <dt class="col-sm-5">Created:</dt>
                            <dd class="col-sm-7"><?php echo date('d M Y', strtotime($booking['created_on'] ?? 'now')); ?></dd>

                            <?php if (!empty($booking['modified_on'])): ?>
                                <dt class="col-sm-5">Last Modified:</dt>
                                <dd class="col-sm-7"><?php echo date('d M Y H:i', strtotime($booking['modified_on'])); ?></dd>
                            <?php endif; ?>
                        </dl>
                    </div>
                </div>

                <?php if (in_array($booking['status'], ['rejected', 'canceled'])): ?>
                    <div class="card bg-light-<?php echo ($booking['status'] == 'rejected') ? 'danger' : 'secondary'; ?> mt-3">
                        <div class="card-body">
                            <h6 class="mb-3">
                                <i class="ti ti-alert-circle"></i> 
                                <?php echo ($booking['status'] == 'rejected') ? 'Rejection' : 'Cancellation'; ?> Info
                            </h6>
                            <p class="mb-2"><strong>Status:</strong> <?php echo ucfirst($booking['status']); ?></p>
                            <?php if (!empty($booking['rejection_reason'])): ?>
                                <p class="mb-2"><strong>Reason:</strong></p>
                                <p class="mb-0 small"><?php echo htmlspecialchars($booking['rejection_reason']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($booking['modified_by'])): ?>
                                <p class="mb-0 mt-2 small text-muted">
                                    <?php echo ($booking['status'] == 'rejected') ? 'Rejected' : 'Canceled'; ?> by: 
                                    <strong><?php echo htmlspecialchars($booking['modified_by']); ?></strong>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="card bg-light-warning mt-3">
                    <div class="card-body">
                        <h6 class="mb-3"><i class="ti ti-alert-circle"></i> Status Info</h6>
                        <ul class="mb-0 small">
                            <li><strong>Pending:</strong> Waiting for admin approval</li>
                            <li><strong>Approved:</strong> Approved by admin, ready to use</li>
                            <li><strong>Rejected:</strong> <span class="text-danger">Booking rejected by admin</span></li>
                            <li><strong>In Use:</strong> Currently being used</li>
                            <li><strong>Canceled:</strong> <span class="text-muted">Booking canceled</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$page_scripts = '
<script>
$(document).ready(function() {
    $("#bookingForm").on("submit", function(e) {
        let startTime = $("#jam_mulai").val();
        let endTime = $("#jam_selesai").val();
        
        if (endTime <= startTime) {
            e.preventDefault();
            alert("End time must be after start time!");
            return false;
        }
    });
});
</script>
';
include __DIR__ . '/../layout/footer.php';
?>