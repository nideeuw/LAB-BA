<?php

/**
 * Lab Bookings Edit View
 * File: app/cms/views/lab_bookings/lab_bookings_edit.php
 */

$page_title = 'Edit Lab Booking';
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="pc-container">
    <div class="pc-content">
        <?php include __DIR__ . '/../layout/breadcrumb.php'; ?>

        <!-- Flash Message -->
        <?php
        $flash = getFlash();
        if ($flash):
        ?>
            <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $flash['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Main Content -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Edit Lab Booking #<?php echo $booking['id']; ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/lab_bookings/update/<?php echo $booking['id']; ?>"
                            method="POST"
                            id="bookingForm">

                            <!-- Borrower Selection -->
                            <div class="mb-3">
                                <label for="id_peminjam" class="form-label">
                                    Borrower <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="id_peminjam" name="id_peminjam" required>
                                    <option value="">-- Select Borrower --</option>
                                    <?php foreach ($borrowers as $borrower): ?>
                                        <option value="<?php echo $borrower['id']; ?>"
                                            <?php echo ($borrower['id'] == $booking['id_peminjam']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($borrower['nama_lengkap']); ?>
                                            (<?php echo htmlspecialchars($borrower['email']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Start Date -->
                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">
                                    Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                    class="form-control"
                                    id="tanggal_mulai"
                                    name="tanggal_mulai"
                                    value="<?php echo date('Y-m-d', strtotime($booking['tanggal_mulai'])); ?>"
                                    required>
                            </div>

                            <!-- End Date -->
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">
                                    End Date <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                    class="form-control"
                                    id="tanggal_selesai"
                                    name="tanggal_selesai"
                                    value="<?php echo date('Y-m-d', strtotime($booking['tanggal_selesai'])); ?>"
                                    required>
                            </div>

                            <!-- Returned Date -->
                            <div class="mb-3">
                                <label for="tanggal_dikembalikan" class="form-label">Returned Date</label>
                                <input type="date"
                                    class="form-control"
                                    id="tanggal_dikembalikan"
                                    name="tanggal_dikembalikan"
                                    value="<?php echo !empty($booking['tanggal_dikembalikan']) ? date('Y-m-d', strtotime($booking['tanggal_dikembalikan'])) : ''; ?>">
                                <small class="text-muted">Leave empty if not yet returned</small>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Description</label>
                                <textarea class="form-control"
                                    id="deskripsi"
                                    name="deskripsi"
                                    rows="4"
                                    placeholder="Purpose of booking, equipment needed, etc..."><?php echo htmlspecialchars($booking['deskripsi'] ?? ''); ?></textarea>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="pending" <?php echo ($booking['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="review" <?php echo ($booking['status'] == 'review') ? 'selected' : ''; ?>>Review</option>
                                    <option value="approved" <?php echo ($booking['status'] == 'approved') ? 'selected' : ''; ?>>Approved</option>
                                    <option value="in_use" <?php echo ($booking['status'] == 'in_use') ? 'selected' : ''; ?>>In Use</option>
                                    <option value="returned" <?php echo ($booking['status'] == 'returned') ? 'selected' : ''; ?>>Returned</option>
                                    <option value="canceled" <?php echo ($booking['status'] == 'canceled') ? 'selected' : ''; ?>>Canceled</option>
                                </select>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        <?php echo $booking['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Booking
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/lab_bookings" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                                <a href="<?php echo $base_url; ?>/cms/lab_bookings/delete/<?php echo $booking['id']; ?>"
                                    class="btn btn-danger ms-auto"
                                    onclick="return confirm('Are you sure you want to delete this booking?')">
                                    <i class="ti ti-trash"></i> Delete
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Booking Information Card -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="mb-3">Booking Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Booking ID:</strong> <?php echo $booking['id']; ?></p>
                                <p class="mb-2"><strong>Borrower:</strong> <?php echo htmlspecialchars($booking['peminjam_name'] ?? '-'); ?></p>
                                <p class="mb-2"><strong>Created By:</strong> <?php echo htmlspecialchars($booking['created_by'] ?? '-'); ?></p>
                                <p class="mb-2"><strong>Created On:</strong>
                                    <?php echo !empty($booking['created_on']) ? date('d M Y H:i', strtotime($booking['created_on'])) : '-'; ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Current Status:</strong>
                                    <span class="badge bg-primary"><?php echo ucfirst(str_replace('_', ' ', $booking['status'])); ?></span>
                                </p>
                                <p class="mb-2"><strong>Modified By:</strong> <?php echo htmlspecialchars($booking['modified_by'] ?? '-'); ?></p>
                                <p class="mb-2"><strong>Modified On:</strong>
                                    <?php echo !empty($booking['modified_on']) ? date('d M Y H:i', strtotime($booking['modified_on'])) : '-'; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="col-lg-4">
                <div class="card bg-light-warning">
                    <div class="card-body">
                        <h5 class="mb-3">
                            <i class="ti ti-alert-triangle"></i> Status Guide
                        </h5>
                        <ul class="mb-0">
                            <li><strong>Pending:</strong> Waiting for approval</li>
                            <li><strong>Review:</strong> Under review by admin</li>
                            <li><strong>Approved:</strong> Booking has been approved</li>
                            <li><strong>In Use:</strong> Currently using the lab</li>
                            <li><strong>Returned:</strong> Lab has been returned</li>
                            <li><strong>Canceled:</strong> Booking was canceled</li>
                        </ul>
                    </div>
                </div>

                <div class="card mt-3 bg-light-info">
                    <div class="card-body">
                        <h6 class="mb-2"><i class="ti ti-info-circle"></i> Tips</h6>
                        <ul class="mb-0">
                            <li>Change status to "returned" when lab is returned</li>
                            <li>Add return date automatically when status is returned</li>
                            <li>Inactive bookings won't appear in reports</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$today = date('Y-m-d');
$page_scripts = '
<script>
$(document).ready(function() {
    // Form validation
    $("#bookingForm").on("submit", function(e) {
        let startDate = new Date($("#tanggal_mulai").val());
        let endDate = new Date($("#tanggal_selesai").val());
        
        if (endDate < startDate) {
            e.preventDefault();
            alert("End date must be after start date!");
            return false;
        }
    });

    // Auto-set returned date when status changed to "returned"
    $("#status").on("change", function() {
        if ($(this).val() === "returned" && !$("#tanggal_dikembalikan").val()) {
            $("#tanggal_dikembalikan").val("' . $today . '");
        }
    });
});
</script>
';
include __DIR__ . '/../layout/footer.php';
?>