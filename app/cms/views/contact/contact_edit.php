<?php

/**
 * Contact Edit View (CMS)
 * File: app/cms/views/contact/contact_edit.php
 */

// SET PAGE TITLE
$page_title = 'Edit Contact';

// Include layout
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">

        <!-- [ breadcrumb ] start -->
        <?php include __DIR__ . '/../layout/breadcrumb.php'; ?>
        <!-- [ breadcrumb ] end -->

        <!-- Flash Message -->
        <?php
        $flash = getFlash();
        if ($flash):
        ?>
            <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $flash['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Edit Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/contact/update/<?php echo $contact['id']; ?>" method="POST" id="contactForm">

                            <!-- Email (Required) -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    required
                                    value="<?php echo htmlspecialchars($contact['email']); ?>"
                                    placeholder="laboratoriumBA@polinema.ac.id">
                                <small class="text-muted">Contact email to display in footer</small>
                            </div>

                            <!-- Address (Required) -->
                            <div class="mb-3">
                                <label for="alamat" class="form-label">
                                    Address <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control"
                                    id="alamat"
                                    name="alamat"
                                    rows="3"
                                    required><?php echo htmlspecialchars($contact['alamat']); ?></textarea>
                                <small class="text-muted">Full address to display in footer</small>
                            </div>

                            <!-- Phone (Required) -->
                            <div class="mb-3">
                                <label for="no_telp" class="form-label">
                                    Phone Number <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control"
                                    id="no_telp"
                                    name="no_telp"
                                    required
                                    value="<?php echo htmlspecialchars($contact['no_telp']); ?>"
                                    placeholder="+62 341 123456">
                                <small class="text-muted">Phone number to display in footer</small>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        value="1"
                                        <?php echo $contact['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">
                                        Active (Display in footer)
                                    </label>
                                </div>
                                <small class="text-muted">Only one contact can be active at a time</small>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Contact
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/contact" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="col-lg-4">
                <div class="card bg-light-info">
                    <div class="card-body">
                        <h5 class="mb-3">
                            <i class="ti ti-info-circle"></i> Contact Information
                        </h5>

                        <h6 class="mb-2">Contact ID:</h6>
                        <p class="mb-3"><?php echo $contact['id']; ?></p>

                        <h6 class="mb-2">Current Status:</h6>
                        <p class="mb-3">
                            <?php if ($contact['is_active']): ?>
                                <span class="badge bg-success">Active - Displayed in Footer</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>
                        </p>

                        <h6 class="mb-2">Created:</h6>
                        <p class="mb-3">
                            <?php echo !empty($contact['created_by']) ? htmlspecialchars($contact['created_by']) : '-'; ?><br>
                            <small class="text-muted">
                                <?php echo !empty($contact['created_on']) ? date('d M Y H:i', strtotime($contact['created_on'])) : '-'; ?>
                            </small>
                        </p>

                        <?php if (!empty($contact['modified_on'])): ?>
                            <h6 class="mb-2">Last Modified:</h6>
                            <p class="mb-0">
                                <?php echo !empty($contact['modified_by']) ? htmlspecialchars($contact['modified_by']) : '-'; ?><br>
                                <small class="text-muted">
                                    <?php echo date('d M Y H:i', strtotime($contact['modified_on'])); ?>
                                </small>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Preview Card -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="mb-3">Footer Preview</h6>
                        <div class="bg-light p-3 rounded">
                            <div class="mb-2">
                                <i class="ti ti-map-pin text-primary"></i>
                                <small id="previewAlamat"><?php echo htmlspecialchars($contact['alamat']); ?></small>
                            </div>
                            <div class="mb-2">
                                <i class="ti ti-phone text-primary"></i>
                                <small id="previewTelp"><?php echo htmlspecialchars($contact['no_telp']); ?></small>
                            </div>
                            <div>
                                <i class="ti ti-mail text-primary"></i>
                                <small id="previewEmail"><?php echo htmlspecialchars($contact['email']); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->

    </div>
</div>

<?php
// Page specific scripts
$page_scripts = '
<script>
$(document).ready(function() {
    // Live preview
    $("#alamat").on("input", function() {
        $("#previewAlamat").text($(this).val().trim());
    });

    $("#no_telp").on("input", function() {
        $("#previewTelp").text($(this).val().trim());
    });

    $("#email").on("input", function() {
        $("#previewEmail").text($(this).val().trim());
    });

    // Form validation
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
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>