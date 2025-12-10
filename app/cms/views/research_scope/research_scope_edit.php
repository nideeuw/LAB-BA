<?php

/**
 * Research Scope Edit View
 * File: app/cms/views/research_scope/research_scope_edit.php
 */

$page_title = 'Edit Research Scope';
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
                        <h5 class="mb-0">Edit Research Scope #<?php echo $researchScope['id']; ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/research_scope/update/<?php echo $researchScope['id']; ?>" method="POST" enctype="multipart/form-data" id="researchScopeForm">

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
                                    value="<?php echo htmlspecialchars($researchScope['title'] ?? ''); ?>">
                            </div>

                            <!-- Current Image -->
                            <?php if (!empty($researchScope['image'])): ?>
                                <div class="mb-3">
                                    <label class="form-label">Current Diagram</label>
                                    <div>
                                        <img src="<?php echo $base_url; ?>/assets/<?php echo htmlspecialchars($researchScope['image']); ?>"
                                            alt="Current Research Scope"
                                            class="img-thumbnail"
                                            style="max-width: 100%; max-height: 400px; object-fit: contain;">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Change Image -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Change Diagram/Image</label>
                                <input type="file"
                                    class="form-control"
                                    id="image"
                                    name="image"
                                    accept="image/*">
                                <small class="text-muted">Leave empty to keep current image. Max 5MB. Accepted: JPG, PNG, WEBP</small>

                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <label class="form-label">New Image Preview:</label>
                                    <div>
                                        <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 100%; max-height: 400px;">
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description (Optional)</label>
                                <textarea class="form-control"
                                    id="description"
                                    name="description"
                                    rows="3"><?php echo htmlspecialchars($researchScope['description'] ?? ''); ?></textarea>
                                <small class="text-muted">Brief caption for the diagram</small>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        <?php echo $researchScope['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">
                                        Active (Display on frontend)
                                    </label>
                                </div>
                                <small class="text-muted">Only one research scope should be active at a time</small>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Research Scope
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/research_scope" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                                <a href="<?php echo $base_url; ?>/cms/research_scope/delete/<?php echo $researchScope['id']; ?>"
                                    class="btn btn-danger ms-auto"
                                    onclick="return confirm('Delete this research scope? Image will be deleted too.')">
                                    <i class="ti ti-trash"></i> Delete
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="col-lg-4">
                <div class="card bg-light-warning">
                    <div class="card-body">
                        <h5 class="mb-3"><i class="ti ti-alert-triangle"></i> Important</h5>
                        <ul class="mb-0">
                            <li>Uploading new image will replace the current one</li>
                            <li>Old image will be deleted from server</li>
                            <li>Recommended size: 1200x800px</li>
                            <li>Keep only one active for frontend</li>
                        </ul>
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