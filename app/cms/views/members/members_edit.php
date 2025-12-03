<?php

/**
 * Member Create View
 * File: app/cms/views/members/members_create.php
 */

// SET PAGE TITLE
$page_title = 'Add Member';

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
                        <h5 class="mb-0">Add New Member</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/members/store" method="POST" enctype="multipart/form-data" id="memberForm">

                            <!-- Photo Upload -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Photo</label>
                                <input type="file"
                                    class="form-control"
                                    id="image"
                                    name="image"
                                    accept="image/*">
                                <small class="text-muted">Max 2MB. Accepted: JPG, PNG, WEBP. Recommended: 400x400px</small>

                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Name (Required) -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control"
                                    id="nama"
                                    name="nama"
                                    required
                                    placeholder="e.g., John Doe">
                            </div>

                            <!-- Academic Titles -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gelar_depan" class="form-label">Front Title</label>
                                        <input type="text"
                                            class="form-control"
                                            id="gelar_depan"
                                            name="gelar_depan"
                                            placeholder="e.g., Dr., Prof.">
                                        <small class="text-muted">Optional. e.g., Dr., Prof.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gelar_belakang" class="form-label">Back Title</label>
                                        <input type="text"
                                            class="form-control"
                                            id="gelar_belakang"
                                            name="gelar_belakang"
                                            placeholder="e.g., S.Kom., M.Kom., Ph.D">
                                        <small class="text-muted">Optional. e.g., S.Kom., M.Kom.</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Position -->
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Position</label>
                                <input type="text"
                                    class="form-control"
                                    id="jabatan"
                                    name="jabatan"
                                    placeholder="e.g., Head of Laboratory, Lecturer">
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="member@example.com">
                            </div>

                            <!-- SINTA Link -->
                            <div class="mb-3">
                                <label for="sinta_link" class="form-label">SINTA Profile Link</label>
                                <input type="url"
                                    class="form-control"
                                    id="sinta_link"
                                    name="sinta_link"
                                    placeholder="https://sinta.kemdikbud.go.id/authors/profile/...">
                                <small class="text-muted">Full URL to SINTA profile page</small>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        checked>
                                    <label class="form-check-label" for="is_active">
                                        Active (Visible on public page)
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Create Member
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/members" class="btn btn-secondary">
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
                            <i class="ti ti-info-circle"></i> Member Guidelines
                        </h5>

                        <h6 class="mb-2">Photo Requirements:</h6>
                        <ul class="mb-3">
                            <li>Max size: 2MB</li>
                            <li>Format: JPG, PNG, WEBP</li>
                            <li>Recommended: 400x400px</li>
                            <li>Square aspect ratio</li>
                        </ul>

                        <h6 class="mb-2">Name Format:</h6>
                        <ul class="mb-3">
                            <li>Full name: First Last</li>
                            <li>Front title: Dr., Prof.</li>
                            <li>Back title: S.Kom., M.Kom., Ph.D</li>
                        </ul>

                        <h6 class="mb-2">Example:</h6>
                        <ul class="mb-0">
                            <li>Dr. John Doe, M.Kom., Ph.D</li>
                            <li>Prof. Jane Smith, S.T., M.T.</li>
                        </ul>
                    </div>
                </div>

                <!-- Preview Card -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="mb-3">Name Preview</h6>
                        <div id="namePreview" class="text-center p-3 bg-light rounded">
                            <p class="mb-0"><em>Type to see preview...</em></p>
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
    // Image preview
    $("#image").on("change", function(e) {
        let file = e.target.files[0];
        
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert("File size must be less than 2MB!");
                $(this).val("");
                $("#imagePreview").hide();
                return;
            }

            let reader = new FileReader();
            reader.onload = function(e) {
                $("#previewImg").attr("src", e.target.result);
                $("#imagePreview").show();
            };
            reader.readAsDataURL(file);
        } else {
            $("#imagePreview").hide();
        }
    });

    // Name preview
    function updateNamePreview() {
        let gelarDepan = $("#gelar_depan").val().trim();
        let nama = $("#nama").val().trim();
        let gelarBelakang = $("#gelar_belakang").val().trim();
        
        let fullName = "";
        
        if (gelarDepan) fullName += gelarDepan + " ";
        fullName += nama;
        if (gelarBelakang) fullName += ", " + gelarBelakang;
        
        if (fullName) {
            $("#namePreview").html("<strong>" + fullName + "</strong>");
        } else {
            $("#namePreview").html("<em>Type to see preview...</em>");
        }
    }
    
    $("#gelar_depan, #nama, #gelar_belakang").on("input", updateNamePreview);

    // Form validation
    $("#memberForm").on("submit", function(e) {
        let nama = $("#nama").val().trim();
        let email = $("#email").val().trim();

        if (!nama) {
            e.preventDefault();
            alert("Name is required!");
            return false;
        }

        if (email && !validateEmail(email)) {
            e.preventDefault();
            alert("Invalid email format!");
            return false;
        }
    });

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>