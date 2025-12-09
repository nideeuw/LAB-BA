<?php

/**
 * Contact Create View (CMS)
 * File: app/cms/views/contact/contact_create.php
 */

// SET PAGE TITLE
$page_title = 'Add Contact';

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
                        <h5 class="mb-0">Add New Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/contact/store" method="POST" id="contactForm">

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
                                    required
                                    placeholder="Jl. Soekarno Hatta No. 9 Malang, Jawa Timur 65141"></textarea>
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
                                    placeholder="+62 341 123456">
                                <small class="text-muted">Phone number to display in footer</small>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        value="1"
                                        checked>
                                    <label class="form-check-label" for="is_active">
                                        Active (Display in footer)
                                    </label>
                                </div>
                                <small class="text-muted">Only one contact can be active at a time</small>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Create Contact
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/contact" class="btn btn-secondary">
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
                            <i class="ti ti-info-circle"></i> Contact Guidelines
                        </h5>

                        <h6 class="mb-2">Required Information:</h6>
                        <ul class="mb-3">
                            <li>Email address</li>
                            <li>Full address</li>
                            <li>Phone number</li>
                        </ul>

                        <h6 class="mb-2">Where it appears:</h6>
                        <ul class="mb-3">
                            <li>Footer on all pages</li>
                            <li>Contact page (if available)</li>
                        </ul>

                        <h6 class="mb-2">Active Status:</h6>
                        <ul class="mb-0">
                            <li>Only ONE contact can be active</li>
                            <li>Setting this active will deactivate others</li>
                            <li>Active contact displays in footer</li>
                        </ul>
                    </div>
                </div>

                <!-- Preview Card -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="mb-3">Footer Preview</h6>
                        <div class="bg-light p-3 rounded">
                            <div class="mb-2">
                                <i class="ti ti-map-pin text-primary"></i>
                                <small id="previewAlamat" class="text-muted">Address will appear here...</small>
                            </div>
                            <div class="mb-2">
                                <i class="ti ti-phone text-primary"></i>
                                <small id="previewTelp" class="text-muted">Phone will appear here...</small>
                            </div>
                            <div>
                                <i class="ti ti-mail text-primary"></i>
                                <small id="previewEmail" class="text-muted">Email will appear here...</small>
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
        let val = $(this).val().trim();
        $("#previewAlamat").text(val || "Address will appear here...");
    });

    $("#no_telp").on("input", function() {
        let val = $(this).val().trim();
        $("#previewTelp").text(val || "Phone will appear here...");
    });

    $("#email").on("input", function() {
        let val = $(this).val().trim();
        $("#previewEmail").text(val || "Email will appear here...");
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

        // Email validation
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