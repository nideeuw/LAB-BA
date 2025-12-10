<?php

/**
 * Roadmap Edit View
 * File: app/cms/views/roadmap/roadmap_edit.php
 */

// SET PAGE TITLE
$page_title = 'Edit Roadmap';

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
                        <h5 class="mb-0">Edit Roadmap: <?php echo htmlspecialchars($roadmap['title']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/roadmap/update/<?php echo $roadmap['id']; ?>" method="POST" id="roadmapForm">

                            <div class="row">
                                <!-- Title -->
                                <div class="col-md-8 mb-3">
                                    <label for="title" class="form-label">
                                        Title <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control"
                                        id="title"
                                        name="title"
                                        required
                                        value="<?php echo htmlspecialchars($roadmap['title']); ?>"
                                        placeholder="e.g., Jangka Pendek (1–5 Tahun)">
                                </div>

                                <!-- Sort Order -->
                                <div class="col-md-4 mb-3">
                                    <label for="sort_order" class="form-label">
                                        Sort Order <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                        class="form-control"
                                        id="sort_order"
                                        name="sort_order"
                                        value="<?php echo $roadmap['sort_order']; ?>"
                                        required
                                        min="1">
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="mb-3">
                                <label for="content" class="form-label">
                                    Content <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control"
                                    id="content"
                                    name="content"
                                    rows="10"
                                    required
                                    placeholder="Enter roadmap content. Separate each section with a blank line."><?php echo htmlspecialchars($roadmap['content']); ?></textarea>
                                <small class="text-muted">
                                    Format example:<br>
                                    Kualitas lulusan: Penguatan praktikum...<br>
                                    Ilmu: Fondasi riset...<br>
                                    Masy/Industri: Studi kasus...
                                </small>
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
                                        <?php echo $roadmap['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Roadmap
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/roadmap" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                                <a href="<?php echo $base_url; ?>/cms/roadmap/delete/<?php echo $roadmap['id']; ?>"
                                    class="btn btn-danger ms-auto"
                                    onclick="return confirm('Are you sure you want to delete this roadmap?')"
                                    title="Delete">
                                    <i class="ti ti-trash"></i> Delete
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
                        <h6 class="mb-3">
                            <i class="ti ti-info-circle"></i> Edit Information
                        </h6>

                        <h6 class="mb-2">Roadmap ID:</h6>
                        <p class="mb-3"><?php echo $roadmap['id']; ?></p>

                        <h6 class="mb-2">Created:</h6>
                        <p class="mb-3">
                            <?php echo !empty($roadmap['created_by']) ? htmlspecialchars($roadmap['created_by']) : '-'; ?><br>
                            <small class="text-muted">
                                <?php echo !empty($roadmap['created_on']) ? date('d M Y H:i', strtotime($roadmap['created_on'])) : '-'; ?>
                            </small>
                        </p>

                        <h6 class="mb-2">Last Modified:</h6>
                        <p class="mb-0">
                            <?php echo !empty($roadmap['modified_by']) ? htmlspecialchars($roadmap['modified_by']) : '-'; ?><br>
                            <small class="text-muted">
                                <?php echo !empty($roadmap['modified_on']) ? date('d M Y H:i', strtotime($roadmap['modified_on'])) : '-'; ?>
                            </small>
                        </p>
                    </div>
                </div>

                <div class="card bg-light-primary mt-3">
                    <div class="card-body">
                        <h6 class="mb-3">
                            <i class="ti ti-help"></i> Content Guidelines
                        </h6>
                        <ul class="mb-0">
                            <li>Each line will be a new paragraph</li>
                            <li>Use format: <strong>Label:</strong> Description</li>
                            <li>Separate sections with blank lines</li>
                            <li>Example: Kualitas lulusan: Text...</li>
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
    // Form validation
    $("#roadmapForm").on("submit", function(e) {
        let title = $("#title").val().trim();
        let content = $("#content").val().trim();

        if (!title) {
            e.preventDefault();
            alert("Title is required!");
            return false;
        }

        if (!content) {
            e.preventDefault();
            alert("Content is required!");
            return false;
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>