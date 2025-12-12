<?php
$page_title = 'Edit User Booking';
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
                        <h5 class="mb-0">Edit User #<?php echo $user['id']; ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/user_bookings/update/<?php echo $user['id']; ?>" method="POST">

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" required value="<?php echo htmlspecialchars($user['nama']); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nip" name="nip" required value="<?php echo htmlspecialchars($user['nip']); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($user['email']); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="no_telp" class="form-label">No. HP / WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp" required value="<?php echo htmlspecialchars($user['no_telp']); ?>" pattern="[0-9]{10,15}">
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="dosen" <?php echo ($user['category'] == 'dosen') ? 'selected' : ''; ?>>Dosen</option>
                                    <option value="staff" <?php echo ($user['category'] == 'staff') ? 'selected' : ''; ?>>Staff</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?php echo $user['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/user_bookings" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                                <a href="<?php echo $base_url; ?>/cms/user_bookings/delete/<?php echo $user['id']; ?>"
                                    class="btn btn-danger ms-auto"
                                    onclick="return confirm('Delete this user? This will also delete all their bookings!')">
                                    <i class="ti ti-trash"></i> Delete
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