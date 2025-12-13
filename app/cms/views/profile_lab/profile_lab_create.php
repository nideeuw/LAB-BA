<?php
$page_title = 'Add Profile Lab';
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
                        <h5 class="mb-0">Add New Profile Lab (About Us)</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/profile_lab/store" method="POST" enctype="multipart/form-data" id="profileLabForm">

                            <div class="mb-4">
                                <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" required placeholder="e.g., About Us">
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="6" required placeholder="Enter profile lab description"></textarea>
                                <div class="form-text">Describe your laboratory's profile and mission</div>
                            </div>

                            <div class="mb-4">
                                <label for="image" class="form-label fw-semibold">Image (Mascot) <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                <div class="form-text">Maximum 2MB (JPG, PNG, WEBP). Recommended: 500x500px</div>

                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="img-fluid rounded border" style="max-width: 200px;">
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="is_active">Set as Active (Only one can be active at a time)</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Create Profile Lab
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/profile_lab" class="btn btn-outline-secondary">
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
    }
});

$("#profileLabForm").on("submit", function(e) {
    let title = $("#title").val().trim();
    let description = $("#description").val().trim();
    let image = $("#image").val();
    if (!title || !description || !image) {
        e.preventDefault();
        alert("All required fields must be filled!");
        return false;
    }
});
</script>
';
include __DIR__ . '/../layout/footer.php';
?>