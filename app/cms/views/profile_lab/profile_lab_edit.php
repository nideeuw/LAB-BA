<?php

/**
 * Profile Lab Edit View
 * File: app/cms/views/profile_lab/profile_lab_edit.php
 */

// SET PAGE TITLE
$page_title = 'Edit Profile Lab';

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
                        <h5 class="mb-0">Edit Profile Lab: <?php echo htmlspecialchars($profile['title']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/profile_lab/update/<?php echo $profile['id']; ?>" method="POST" enctype="multipart/form-data" id="profileLabForm">

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
                                    value="<?php echo htmlspecialchars($profile['title']); ?>">
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
                                    required><?php echo htmlspecialchars($profile['description']); ?></textarea>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Image (Mascot)</label>

                                <!-- Current Image -->
                                <?php if (!empty($profile['image'])): ?>
                                    <div class="mb-2">
                                        <img src="<?php echo $base_url; ?>/assets/<?php echo htmlspecialchars($profile['image']); ?>"
                                            alt="Current image"
                                            class="rounded"
                                            style="max-width: 200px; height: auto;">
                                        <p class="text-muted small mt-1">Current image</p>
                                    </div>
                                <?php endif; ?>

                                <input type="file"
                                    class="form-control"
                                    id="image"
                                    name="image"
                                    accept="image/*">
                                <small class="text-muted">Leave empty to keep current image. Max 2MB. Accepted: JPG, PNG, WEBP.</small>

                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="rounded" style="max-width: 200px; height: auto;">
                                </div>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        value="1"
                                        <?php echo $profile['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">
                                        Set as Active (Only one can be active at a time)
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Profile Lab
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/profile_lab" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="col-lg-4">
                <div class="card bg-light-info">
                    <div class="card-body">
                        <h5 class="mb-3">
                            <i class="ti ti-info-circle"></i> Edit Information
                        </h5>

                        <h6 class="mb-2">Profile Lab ID:</h6>
                        <p class="mb-3"><?php echo $profile['id']; ?></p>

                        <h6 class="mb-2">Created:</h6>
                        <p class="mb-3">
                            <?php echo !empty($profile['created_by']) ? htmlspecialchars($profile['created_by']) : '-'; ?><br>
                            <small class="text-muted">
                                <?php echo !empty($profile['created_on']) ? date('d M Y H:i', strtotime($profile['created_on'])) : '-'; ?>
                            </small>
                        </p>

                        <h6 class="mb-2">Last Modified:</h6>
                        <p class="mb-0">
                            <?php echo !empty($profile['modified_by']) ? htmlspecialchars($profile['modified_by']) : '-'; ?><br>
                            <small class="text-muted">
                                <?php echo !empty($profile['modified_on']) ? date('d M Y H:i', strtotime($profile['modified_on'])) : '-'; ?>
                            </small>
                        </p>
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
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>