<?php
$page_title = 'Edit Gallery';
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
                        <h5 class="mb-0">Edit Gallery: <?php echo htmlspecialchars($gallery['title']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/gallery/update/<?php echo $gallery['id']; ?>" method="POST" enctype="multipart/form-data" id="galleryForm">

                            <?php if (!empty($gallery['image'])): ?>
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Current Image</label>
                                    <div>
                                        <img src="<?php echo $base_url; ?>/assets/<?php echo htmlspecialchars($gallery['image']); ?>"
                                            alt="<?php echo htmlspecialchars($gallery['title']); ?>"
                                            class="img-fluid rounded border"
                                            style="max-height: 300px;"
                                            onerror="this.src='<?php echo $base_url; ?>/assets/img/default-gallery.jpg'">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="mb-4">
                                <label for="image" class="form-label fw-semibold">Change Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="form-text">Leave empty to keep current image. Maximum 5MB</div>

                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <label class="form-label fw-semibold">New Preview:</label>
                                    <div>
                                        <img id="previewImg" src="" alt="Preview" class="img-fluid rounded border" style="max-height: 300px;">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($gallery['title']); ?>" required>
                            </div>

                            <div class="mb-4">
                                <label for="date" class="form-label fw-semibold">Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="<?php echo !empty($gallery['date']) ? date('Y-m-d', strtotime($gallery['date'])) : ''; ?>">
                                <div class="form-text">Date when photo was taken</div>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($gallery['description'] ?? ''); ?></textarea>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?php echo $gallery['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">Active (Visible on public gallery)</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Gallery
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/gallery" class="btn btn-outline-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                                <a href="<?php echo $base_url; ?>/cms/gallery/delete/<?php echo $gallery['id']; ?>"
                                    class="btn btn-danger ms-auto"
                                    onclick="return confirm('Delete this gallery item?')">
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
document.getElementById("image").addEventListener("change", function(e) {
    let file = e.target.files[0];
    
    if (file) {
        if (file.size > 5 * 1024 * 1024) {
            alert("File size must be less than 5MB!");
            this.value = "";
            document.getElementById("imagePreview").style.display = "none";
            return;
        }

        let allowedTypes = ["image/jpeg", "image/jpg", "image/png", "image/gif", "image/webp"];
        if (!allowedTypes.includes(file.type)) {
            alert("Invalid file type! Only JPG, PNG, GIF, and WEBP are allowed.");
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
</script>
';
include __DIR__ . '/../layout/footer.php';
?>