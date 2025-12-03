<?php

/**
 * Lab Bookings Create View
 * File: app/cms/views/lab_bookings/lab_bookings_create.php
 */

$page_title = 'Add Lab Booking';
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
                        <h5 class="mb-0">Add New Lab Booking</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/lab_bookings/store" method="POST" id="bookingForm">

                            <!-- Borrower Selection -->
                            <div class="mb-3">
                                <label for="id_peminjam" class="form-label">
                                    Borrower <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="id_peminjam" name="id_peminjam" required>
                                    <option value="">-- Select Borrower --</option>
                                    <?php foreach ($borrowers as $borrower): ?>
                                        <option value="<?php echo $borrower['id']; ?>">
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
                                    value="<?php echo date('Y-m-d'); ?>"
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
                                    required>
                            </div>

                            <!-- Returned Date -->
                            <div class="mb-3">
                                <label for="tanggal_dikembalikan" class="form-label">Returned Date</label>
                                <input type="date"
                                    class="form-control"
                                    id="tanggal_dikembalikan"
                                    name="tanggal_dikembalikan">
                                <small class="text-muted">Leave empty if not yet returned</small>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Description</label>
                                <textarea class="form-control"
                                    id="deskripsi"
                                    name="deskripsi"
                                    rows="4"
                                    placeholder="Purpose of booking, equipment needed, etc..."></textarea>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="pending" selected>Pending</option>
                                    <option value="review">Review</option>
                                    <option value="approved">Approved</option>
                                    <option value="in_use">In Use</option>
                                    <option value="returned">Returned</option>
                                    <option value="canceled">Canceled</option>
                                </select>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        checked>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Save Booking
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/lab_bookings" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="col-lg-4">
                <div class="card bg-light-primary">
                    <div class="card-body">
                        <h5 class="mb-3">
                            <i class="ti ti-info-circle"></i> Booking Guidelines
                        </h5>

                        <h6 class="mb-2">Required Fields:</h6>
                        <ul class="mb-3">
                            <li>Select borrower from list</li>
                            <li>Set start date</li>
                            <li>Set end date</li>
                        </ul>

                        <h6 class="mb-2">Status Types:</h6>
                        <ul class="mb-3">
                            <li><strong>Pending:</strong> Waiting approval</li>
                            <li><strong>Review:</strong> Under review</li>
                            <li><strong>Approved:</strong> Booking approved</li>
                            <li><strong>In Use:</strong> Currently using</li>
                            <li><strong>Returned:</strong> Lab returned</li>
                            <li><strong>Canceled:</strong> Booking canceled</li>
                        </ul>

                        <h6 class="mb-2">Notes:</h6>
                        <ul>
                            <li>End date must be after start date</li>
                            <li>Add return date when returned</li>
                            <li>Inactive bookings won't show in reports</li>
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
    // Form validation
    $("#bookingForm").on("submit", function(e) {
        let startDate = new Date($("#tanggal_mulai").val());
        let endDate = new Date($("#tanggal_selesai").val());
        
        if (endDate < startDate) {
            e.preventDefault();
            alert("End date must be after start date!");
            return false;
        }
        
        if (!$("#id_peminjam").val()) {
            e.preventDefault();
            alert("Please select a borrower!");
            return false;
        }
    });
    
    // Auto-set end date if empty (default 1 day after start)
    $("#tanggal_mulai").on("change", function() {
        if (!$("#tanggal_selesai").val()) {
            let startDate = new Date($(this).val());
            startDate.setDate(startDate.getDate() + 1);
            let endDate = startDate.toISOString().split("T")[0];
            $("#tanggal_selesai").val(endDate);
        }
    });
});
</script>
';
include __DIR__ . '/../layout/footer.php';
?>