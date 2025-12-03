<?php

/**
 * Banner Create View
 * File: app/cms/views/banner/banner_create.php
 */

// SET PAGE TITLE
$page_title = 'Add Banner';

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
                        <h5 class="mb-0">Add New Banner Image</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/banner/store" method="POST" enctype="multipart/form-data" id="bannerForm">

                            <!-- Image Upload -->
                            <div class="mb-3">
                                <label for="image" class="form-label">
                                    Image <span class="text-danger">*</span>
                                </label>
                                <input type="file"
                                    class="form-control"
                                    id="image"
                                    name="image"
                                    accept="image/*"
                                    required>
                                <small class="text-muted">Max 5MB. Accepted: JPG, PNG, GIF, WEBP</small>

                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px; max-height: 300px;">
                                </div>
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
                                        Active (Visible on public banner)
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-upload"></i> Upload Image
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/banner" class="btn btn-secondary">
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
                            <i class="ti ti-info-circle"></i> Upload Guidelines
                        </h5>

                        <h6 class="mb-2">Image Requirements:</h6>
                        <ul class="mb-3">
                            <li>Maximum file size: 5MB</li>
                            <li>Formats: JPG, PNG, GIF, WEBP</li>
                            <li>Recommended: 1920x1080px</li>
                        </ul>

                        <h6 class="mb-2">Best Practices:</h6>
                        <ul class="mb-3">
                            <li>Optimize image size</li>
                        </ul>

                        <h6 class="mb-2">Tips:</h6>
                        <ul>
                            <li>Compress images before upload</li>
                            <li>Use landscape orientation</li>
                            <li>Check image quality</li>
                        </ul>
                    </div>
                </div>

                <!-- File Size Info -->
                <div class="card mt-3 bg-light-warning">
                    <div class="card-body">
                        <h6 class="mb-2"><i class="ti ti-alert-triangle"></i> Important</h6>
                        <p class="mb-0 small">Images are stored in <code>/public/uploads/banner/</code> directory. Make sure this folder is writable.</p>
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
            // Check file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert("File size must be less than 5MB!");
                $(this).val("");
                $("#imagePreview").hide();
                return;
            }

            // Show preview
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
    $("#bannerForm").on("submit", function(e) {
        let image = $("#image")[0].files[0];
        let title = $("#title").val().trim();

        if (!image) {
            e.preventDefault();
            alert("Please select an image!");
            return false;
        }

        if (!title) {
            e.preventDefault();
            alert("Please enter a title!");
            return false;
        }

        // Check file type
        let allowedTypes = ["image/jpeg", "image/jpg", "image/png", "image/gif", "image/webp"];
        if (!allowedTypes.includes(image.type)) {
            e.preventDefault();
            alert("Invalid file type! Only JPG, PNG, GIF, and WEBP are allowed.");
            return false;
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>