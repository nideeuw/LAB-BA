<?php
$page_title = 'Edit Banner';
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
                        <h5 class="mb-0">Edit Banner #<?php echo $banner['id']; ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/banner/update/<?php echo $banner['id']; ?>" method="POST" enctype="multipart/form-data">

                            <!-- Current Image -->
                            <?php if (!empty($banner['image'])): ?>
                                <div class="mb-3">
                                    <label class="form-label">Current Banner</label>
                                    <div>
                                        <img src="<?php echo $base_url; ?>/public/<?php echo htmlspecialchars($banner['image']); ?>"
                                            alt="Current Banner"
                                            class="img-thumbnail"
                                            style="max-width: 100%; max-height: 400px; object-fit: contain;">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- New Image Upload -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Change Banner Image</label>
                                <input type="file"
                                    class="form-control"
                                    id="image"
                                    name="image"
                                    accept="image/*">
                                <small class="text-muted">Leave empty to keep current image. Max 5MB.</small>

                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <label class="form-label">New Image Preview:</label>
                                    <div>
                                        <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 100%; max-height: 400px;">
                                    </div>
                                </div>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        <?php echo $banner['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">
                                        Active (Show on homepage)
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Banner
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/banner" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                                <a href="<?php echo $base_url; ?>/cms/banner/delete/<?php echo $banner['id']; ?>"
                                    class="btn btn-danger ms-auto"
                                    onclick="return confirm('Delete this banner?')">
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
$page_scripts = '
<script>
document.addEventListener("DOMContentLoaded", function() {
    const imageInput = document.getElementById("image");
    if (imageInput) {
        imageInput.addEventListener("change", function(e) {
            let file = e.target.files[0];
            
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    alert("File size must be less than 5MB!");
                    this.value = "";
                    document.getElementById("imagePreview").style.display = "none";
                    return;
                }

                let reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("previewImg").src = e.target.result;
                    document.getElementById("imagePreview").style.display = "block";
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
';
include __DIR__ . '/../layout/footer.php';
?>