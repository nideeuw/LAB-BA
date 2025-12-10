<?php

/**
 * Profile Lab Create View
 * File: app/cms/views/profile_lab/profile_lab_create.php
 */

// SET PAGE TITLE
$page_title = 'Add Profile Lab';

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
                        <h5 class="mb-0">Add New Profile Lab (About Us)</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/profile_lab/store" method="POST" enctype="multipart/form-data" id="profileLabForm">

                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">
                                    Title <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control"
                                    id="title"
                                    name="title"
                                    required
                                    placeholder="e.g., About Us">
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">
                                    Description <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control"
                                    id="description"
                                    name="description"
                                    rows="6"
                                    required
                                    placeholder="Enter profile lab description"></textarea>
                                <small class="text-muted">Describe your laboratory's profile and mission</small>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-3">
                                <label for="image" class="form-label">
                                    Image (Mascot) <span class="text-danger">*</span>
                                </label>
                                <input type="file"
                                    class="form-control"
                                    id="image"
                                    name="image"
                                    accept="image/*"
                                    required>
                                <small class="text-muted">Max 2MB. Accepted: JPG, PNG, WEBP. Recommended: 500x500px</small>

                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="rounded" style="max-width: 200px; height: auto;">
                                </div>
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
                                        Set as Active (Only one can be active at a time)
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Create Profile Lab
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/profile_lab" class="btn btn-secondary">
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
                            <i class="ti ti-info-circle"></i> Profile Lab Guidelines
                        </h5>

                        <h6 class="mb-2">Image Requirements:</h6>
                        <ul class="mb-3">
                            <li>Max size: 2MB</li>
                            <li>Format: JPG, PNG, WEBP</li>
                            <li>Recommended: 500x500px</li>
                            <li>Use mascot or lab logo</li>
                        </ul>

                        <h6 class="mb-2">Description Tips:</h6>
                        <ul class="mb-3">
                            <li>Keep it concise (2-3 paragraphs)</li>
                            <li>Highlight lab's mission</li>
                            <li>Mention key focus areas</li>
                        </ul>

                        <h6 class="mb-2">Active Status:</h6>
                        <ul class="mb-0">
                            <li>Only ONE profile can be active</li>
                            <li>Active profile shows on home page</li>
                            <li>Others will be deactivated automatically</li>
                        </ul>
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

    // Form validation
    $("#profileLabForm").on("submit", function(e) {
        let title = $("#title").val().trim();
        let description = $("#description").val().trim();
        let image = $("#image").val();

        if (!title) {
            e.preventDefault();
            alert("Title is required!");
            return false;
        }

        if (!description) {
            e.preventDefault();
            alert("Description is required!");
            return false;
        }

        if (!image) {
            e.preventDefault();
            alert("Image is required!");
            return false;
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>