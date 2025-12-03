<?php

/**
 * Gallery Edit View
 * File: app/cms/views/gallery/gallery_edit.php
 */

// SET PAGE TITLE
$page_title = 'Edit Gallery';

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
                        <h5 class="mb-0">Edit Gallery: <?php echo htmlspecialchars($gallery['title']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/gallery/update/<?php echo $gallery['id']; ?>" method="POST" enctype="multipart/form-data" id="galleryForm">

                            <!-- Current Image -->
                            <?php if (!empty($gallery['image'])): ?>
                                <div class="mb-3">
                                    <label class="form-label">Current Image</label>
                                    <div>
                                        <img src="<?php echo $base_url; ?>/public/<?php echo htmlspecialchars($gallery['image']); ?>"
                                            alt="<?php echo htmlspecialchars($gallery['title']); ?>"
                                            class="img-thumbnail"
                                            style="max-width: 300px; max-height: 300px; object-fit: contain;">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- New Image Upload -->
                            <div class="mb-3">
                                <label for="image" class="form-label">
                                    Change Image
                                </label>
                                <input type="file"
                                    class="form-control"
                                    id="image"
                                    name="image"
                                    accept="image/*">
                                <small class="text-muted">Leave empty to keep current image. Max 5MB. Accepted: JPG, PNG, GIF, WEBP</small>

                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <label class="form-label">New Image Preview:</label>
                                    <div>
                                        <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px; max-height: 300px;">
                                    </div>
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
                                    value="<?php echo htmlspecialchars($gallery['title']); ?>"
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
                                    value="<?php echo !empty($gallery['date']) ? date('Y-m-d', strtotime($gallery['date'])) : ''; ?>">
                                <small class="text-muted">Date when photo was taken</small>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control"
                                    id="description"
                                    name="description"
                                    rows="4"
                                    placeholder="Enter description (optional)"><?php echo htmlspecialchars($gallery['description'] ?? ''); ?></textarea>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        <?php echo $gallery['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">
                                        Active (Visible on public gallery)
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Gallery
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/gallery" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                                <a href="<?php echo $base_url; ?>/cms/gallery/delete/<?php echo $gallery['id']; ?>"
                                    class="btn btn-danger ms-auto"
                                    onclick="return confirm('Are you sure you want to delete this gallery item?')">
                                    <i class="ti ti-trash"></i> Delete
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Gallery Info -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="mb-3">Gallery Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>ID:</strong> <?php echo $gallery['id']; ?></p>
                                <p class="mb-2"><strong>Created By:</strong> <?php echo htmlspecialchars($gallery['created_by'] ?? '-'); ?></p>
                                <p class="mb-2"><strong>Created On:</strong>
                                    <?php echo !empty($gallery['created_on']) ? date('d M Y H:i', strtotime($gallery['created_on'])) : '-'; ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <?php if (!empty($gallery['image'])): ?>
                                    <p class="mb-2"><strong>Image Path:</strong>
                                        <code><?php echo htmlspecialchars($gallery['image']); ?></code>
                                    </p>
                                <?php endif; ?>
                                <p class="mb-2"><strong>Modified By:</strong>
                                    <?php echo htmlspecialchars($gallery['modified_by'] ?? '-'); ?>
                                </p>
                                <p class="mb-2"><strong>Modified On:</strong>
                                    <?php echo !empty($gallery['modified_on']) ? date('d M Y H:i', strtotime($gallery['modified_on'])) : '-'; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="col-lg-4">
                <div class="card bg-light-warning">
                    <div class="card-body">
                        <h5 class="mb-3">
                            <i class="ti ti-alert-triangle"></i> Important Notes
                        </h5>

                        <ul class="mb-0">
                            <li>Uploading new image will replace the current one</li>
                            <li>Old image will be deleted from server</li>
                            <li>Leave image field empty to keep current image</li>
                            <li>Deleting this item will also delete the image file</li>
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
            // Check file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert("File size must be less than 5MB!");
                $(this).val("");
                $("#imagePreview").hide();
                return;
            }

            // Check file type
            let allowedTypes = ["image/jpeg", "image/jpg", "image/png", "image/gif", "image/webp"];
            if (!allowedTypes.includes(file.type)) {
                alert("Invalid file type! Only JPG, PNG, GIF, and WEBP are allowed.");
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
    $("#galleryForm").on("submit", function(e) {
        let title = $("#title").val().trim();

        if (!title) {
            e.preventDefault();
            alert("Please enter a title!");
            return false;
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>