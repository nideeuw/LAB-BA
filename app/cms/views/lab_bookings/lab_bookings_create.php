<?php
$page_title = 'Add Lab Booking';
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
                        <h5 class="mb-0">Add New Lab Booking</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/lab_bookings/store" method="POST" id="bookingForm">

                            <div class="mb-3">
                                <label for="id_peminjam" class="form-label">Borrower (Dosen/Staff) <span class="text-danger">*</span></label>
                                <select class="form-select" id="id_peminjam" name="id_peminjam" required>
                                    <option value="">-- Select Borrower --</option>
                                    <?php foreach ($borrowers as $borrower): ?>
                                        <option value="<?php echo $borrower['id']; ?>">
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
                                        value="<?php echo date('Y-m-d'); ?>"
                                        min="<?php echo date('Y-m-d'); ?>"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_selesai" class="form-label">End Date <span class="text-danger">*</span></label>
                                    <input type="date"
                                        class="form-control"
                                        id="tanggal_selesai"
                                        name="tanggal_selesai"
                                        value="<?php echo date('Y-m-d'); ?>"
                                        min="<?php echo date('Y-m-d'); ?>"
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
                                        value="08:00"
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
                                        value="10:00"
                                        required>
                                    <small class="text-muted">Lab hours: 07:00 - 17:00</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Description</label>
                                <textarea class="form-control"
                                    id="deskripsi"
                                    name="deskripsi"
                                    rows="4"
                                ></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="pending" selected>Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="in_use">In Use</option>
                                    <option value="canceled">Canceled</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>

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

            <div class="col-lg-4">
                <div class="card bg-light-info">
                    <div class="card-body">
                        <h6 class="mb-3"><i class="ti ti-info-circle"></i> Booking Rules</h6>
                        <ul class="mb-0">
                            <li>Lab hours: 07:00 - 17:00</li>
                            <li>Dosen & Staff can book</li>
                            <li>End time must be after start time</li>
                            <li>End date must be after or equal start date</li>
                            <li>System will check for conflicts</li>
                            <li>You can set any time (e.g., 08:15, 09:45)</li>
                        </ul>
                    </div>
                </div>

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
    $("#tanggal_mulai").on("change", function() {
        $("#tanggal_selesai").attr("min", $(this).val());
    });

    $("#bookingForm").on("submit", function(e) {
        let startTime = $("#jam_mulai").val();
        let endTime = $("#jam_selesai").val();
        let startDate = $("#tanggal_mulai").val();
        let endDate = $("#tanggal_selesai").val();
        
        if (startTime && endTime && endTime <= startTime) {
            e.preventDefault();
            alert("End time must be after start time!");
            return false;
        }

        if (startDate && endDate && endDate < startDate) {
            e.preventDefault();
            alert("End date must be after or equal start date!");
            return false;
        }
    });
});
</script>
';
include __DIR__ . '/../layout/footer.php';
?>