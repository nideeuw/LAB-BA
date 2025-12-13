<?php
$page_title = 'Edit Contact';
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
                        <h5 class="mb-0">Edit Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/contact/update/<?php echo $contact['id']; ?>" method="POST" id="contactForm">

                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($contact['email']); ?>">
                                <div class="form-text">Contact email to display in footer</div>
                            </div>

                            <div class="mb-4">
                                <label for="alamat" class="form-label fw-semibold">Address <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($contact['alamat']); ?></textarea>
                                <div class="form-text">Full address to display in footer</div>
                            </div>

                            <div class="mb-4">
                                <label for="no_telp" class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp" required value="<?php echo htmlspecialchars($contact['no_telp']); ?>">
                                <div class="form-text">Phone number to display in footer</div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?php echo $contact['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">Active (Display in footer)</label>
                                </div>
                                <div class="form-text">Only one contact can be active at a time</div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Contact
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/contact" class="btn btn-outline-secondary">
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
$page_scripts = '
<script>
$("#contactForm").on("submit", function(e) {
    let email = $("#email").val().trim();
    let alamat = $("#alamat").val().trim();
    let telp = $("#no_telp").val().trim();

    if (!email || !alamat || !telp) {
        e.preventDefault();
        alert("All fields are required!");
        return false;
    }

    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert("Please enter a valid email address!");
        return false;
    }
});
</script>
';
include __DIR__ . '/../layout/footer.php';
?>