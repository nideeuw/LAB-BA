<?php
$page_title = 'Add Banner';
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
                        <h5 class="mb-0">Add New Banner</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/banner/store" method="POST" enctype="multipart/form-data" id="bannerForm">

                            <div class="mb-4">
                                <label for="image" class="form-label fw-semibold">Banner Image <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                <div class="form-text">Maximum 5MB (JPG, PNG, GIF, WEBP). Recommended size: 1920x1080px</div>

                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="img-fluid rounded border" style="max-height: 400px;">
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                    <label class="form-check-label" for="is_active">Active (Show on homepage)</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-upload"></i> Upload Banner
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/banner" class="btn btn-outline-secondary">
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
document.getElementById("image").addEventListener("change", function(e) {
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
</script>
';
include __DIR__ . '/../layout/footer.php';
?>