<?php
$page_title = 'Add User Booking';
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
                        <h5 class="mb-0">Add New User Booking</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/user_bookings/store" method="POST">

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" required placeholder="Masukkan nama lengkap">
                            </div>

                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nip" name="nip" required placeholder="Masukkan NIP">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="email@example.com">
                            </div>

                            <div class="mb-3">
                                <label for="no_telp" class="form-label">No. HP / WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp" required placeholder="08xxxxxxxxxx" pattern="[0-9]{10,15}">
                                <small class="text-muted">Format: 08xxxxxxxxxx (10-15 digit)</small>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">-- Select Category --</option>
                                    <option value="dosen">Dosen</option>
                                    <option value="staff">Staff</option>
                                </select>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Save User
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/user_bookings" class="btn btn-secondary">
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
                        <h6 class="mb-3"><i class="ti ti-info-circle"></i> Information</h6>
                        <ul class="mb-0">
                            <li>All fields with <span class="text-danger">*</span> are required</li>
                            <li>NIP must be unique</li>
                            <li>Email must be unique</li>
                            <li>Only <strong>Dosen & Staff</strong> can book lab</li>
                            <li>Phone number: 10-15 digits</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include __DIR__ . '/../layout/footer.php';
?>