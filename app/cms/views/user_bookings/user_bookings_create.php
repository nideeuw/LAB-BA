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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Add New User Booking</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/user_bookings/store" method="POST">

                            <div class="mb-4">
                                <label for="nama" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" required placeholder="Masukkan nama lengkap">
                            </div>

                            <div class="mb-4">
                                <label for="nip" class="form-label fw-semibold">NIP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nip" name="nip" required placeholder="Masukkan NIP">
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="email@example.com">
                            </div>

                            <div class="mb-4">
                                <label for="no_telp" class="form-label fw-semibold">No. HP / WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp" required placeholder="08xxxxxxxxxx" pattern="[0-9]{10,15}">
                                <div class="form-text">Format: 08xxxxxxxxxx (10-15 digit)</div>
                            </div>

                            <div class="mb-4">
                                <label for="category" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">-- Select Category --</option>
                                    <option value="dosen">Dosen</option>
                                    <option value="staff">Staff</option>
                                </select>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Save User
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/user_bookings" class="btn btn-outline-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include __DIR__ . '/../layout/footer.php';
?>