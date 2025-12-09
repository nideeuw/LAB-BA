<?php

/**
 * Gallery Create View - FIXED CHECKBOX
 * File: app/cms/views/gallery/gallery_create.php
 */

// SET PAGE TITLE
$page_title = 'Add Gallery';

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
                        <h5 class="mb-0">Add New Gallery Image</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/gallery/store" method="POST" enctype="multipart/form-data" id="galleryForm">

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
                                    placeholder="Enter image title">
                            </div>

                            <!-- Date -->
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date"
                                    class="form-control"
                                    id="date"
                                    name="date"
                                    value="<?php echo date('Y-m-d'); ?>">
                                <small class="text-muted">Date when photo was taken</small>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control"
                                    id="description"
                                    name="description"
                                    rows="4"
                                    placeholder="Enter description (optional)"></textarea>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <!-- Hidden input: always sends value -->
                                    <input type="hidden" name="is_active" value="0">

                                    <!-- Checkbox with value="1" -->
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        value="1"
                                        checked>
                                    <label class="form-check-label" for="is_active">
                                        Active (Visible on public gallery)
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-upload"></i> Upload Image
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/gallery" class="btn btn-secondary">
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
                            <li>Use descriptive titles</li>
                            <li>Add detailed descriptions</li>
                            <li>Set correct date</li>
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
                        <p class="mb-0 small">Images are stored in <code>assets/uploads/gallery/</code> directory. Make sure this folder is writable.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->

    </div>
</div>

<?php
// Page specific scripts - NO JQUERY NEEDED!
$page_scripts = '
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Image preview
    const imageInput = document.getElementById("image");
    if (imageInput) {
        imageInput.addEventListener("change", function(e) {
            let file = e.target.files[0];
            
            if (file) {
                // Check file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert("File size must be less than 5MB!");
                    this.value = "";
                    document.getElementById("imagePreview").style.display = "none";
                    return;
                }

                // Show preview
                let reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("previewImg").src = e.target.result;
                    document.getElementById("imagePreview").style.display = "block";
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById("imagePreview").style.display = "none";
            }
        });
    }

    // Form validation
    const form = document.getElementById("galleryForm");
    if (form) {
        form.addEventListener("submit", function(e) {
            let image = document.getElementById("image").files[0];
            let title = document.getElementById("title").value.trim();

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
    }
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>