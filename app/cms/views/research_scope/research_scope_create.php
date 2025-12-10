<?php

/**
 * Research Scope Create View
 * File: app/cms/views/research_scope/research_scope_create.php
 */

$page_title = 'Add Research Scope';
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
                        <h5 class="mb-0">Add New Research Scope</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/research_scope/store" method="POST" enctype="multipart/form-data" id="researchScopeForm">

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
                                    placeholder="e.g., Lingkup Penelitian">
                                <small class="text-muted">Title that will appear on frontend</small>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-3">
                                <label for="image" class="form-label">
                                    Diagram/Image <span class="text-danger">*</span>
                                </label>
                                <input type="file"
                                    class="form-control"
                                    id="image"
                                    name="image"
                                    accept="image/*"
                                    required>
                                <small class="text-muted">Max 5MB. Accepted: JPG, PNG, WEBP. Recommended: 1200x800px</small>

                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 100%; max-height: 400px;">
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description (Optional)</label>
                                <textarea class="form-control"
                                    id="description"
                                    name="description"
                                    rows="3"
                                    placeholder="Brief caption for the diagram"></textarea>
                                <small class="text-muted">Optional caption that appears below the image</small>
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
                                        Active (Display on frontend)
                                    </label>
                                </div>
                                <small class="text-muted">Only one research scope should be active at a time</small>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Save Research Scope
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/research_scope" class="btn btn-secondary">
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
                        <h6 class="mb-3">
                            <i class="ti ti-info-circle"></i> Upload Guidelines
                        </h6>
                        <ul class="mb-0">
                            <li>Maximum file size: 5MB</li>
                            <li>Formats: JPG, PNG, WEBP</li>
                            <li>Recommended: 1200x800px (landscape)</li>
                            <li>Use clear, high-quality diagrams</li>
                            <li>Compress images before upload</li>
                        </ul>
                    </div>
                </div>

                <div class="card bg-light-warning mt-3">
                    <div class="card-body">
                        <h6 class="mb-2">
                            <i class="ti ti-alert-triangle"></i> Important
                        </h6>
                        <p class="mb-0 small">
                            Make sure only <strong>one research scope is active</strong> at a time for frontend display. You can have multiple records but only activate the one you want to show.
                        </p>
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

    // Form validation
    document.getElementById("researchScopeForm").addEventListener("submit", function(e) {
        let title = document.getElementById("title").value.trim();
        let image = document.getElementById("image").files[0];

        if (!title) {
            e.preventDefault();
            alert("Title is required!");
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