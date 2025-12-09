<?php

/**
 * Research Edit View (CMS)
 * File: app/cms/views/researches/researches_edit.php
 */

// SET PAGE TITLE
$page_title = 'Edit Research';

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
                        <h5 class="mb-0">Edit Research</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/researches/update/<?php echo $research['id']; ?>" method="POST" id="researchForm">

                            <!-- Member (Required) -->
                            <div class="mb-3">
                                <label for="id_members" class="form-label">
                                    Member <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="id_members" name="id_members" required>
                                    <option value="">-- Select Member --</option>
                                    <?php if (!empty($members)): ?>
                                        <?php foreach ($members as $member): ?>
                                            <option value="<?php echo $member['id']; ?>"
                                                <?php echo ($research['id_members'] == $member['id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars(MembersModel::getFullName($member)); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <!-- Research Title (Required) -->
                            <div class="mb-3">
                                <label for="title" class="form-label">
                                    Research Title <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control"
                                    id="title"
                                    name="title"
                                    required
                                    value="<?php echo htmlspecialchars($research['title']); ?>"
                                    placeholder="e.g., Machine Learning, Natural Language Processing">
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Description</label>
                                <textarea class="form-control"
                                    id="deskripsi"
                                    name="deskripsi"
                                    rows="4"><?php echo htmlspecialchars($research['deskripsi'] ?? ''); ?></textarea>
                            </div>

                            <!-- Year -->
                            <div class="mb-3">
                                <label for="year" class="form-label">Year Started</label>
                                <input type="number"
                                    class="form-control"
                                    id="year"
                                    name="year"
                                    min="1900"
                                    max="<?php echo date('Y') + 1; ?>"
                                    value="<?php echo $research['year'] ?? ''; ?>">
                                <small class="text-muted">Optional. Year when research started.</small>
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
                                        <?php echo $research['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">
                                        Active (Visible on public page)
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Research
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/researches" class="btn btn-secondary">
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
                            <i class="ti ti-info-circle"></i> Research Information
                        </h5>

                        <h6 class="mb-2">Research ID:</h6>
                        <p class="mb-3"><?php echo $research['id']; ?></p>

                        <h6 class="mb-2">Created:</h6>
                        <p class="mb-3">
                            <?php echo !empty($research['created_by']) ? htmlspecialchars($research['created_by']) : '-'; ?><br>
                            <small class="text-muted">
                                <?php echo !empty($research['created_on']) ? date('d M Y H:i', strtotime($research['created_on'])) : '-'; ?>
                            </small>
                        </p>

                        <?php if (!empty($research['modified_on'])): ?>
                            <h6 class="mb-2">Last Modified:</h6>
                            <p class="mb-0">
                                <?php echo !empty($research['modified_by']) ? htmlspecialchars($research['modified_by']) : '-'; ?><br>
                                <small class="text-muted">
                                    <?php echo date('d M Y H:i', strtotime($research['modified_on'])); ?>
                                </small>
                            </p>
                        <?php endif; ?>
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
    $("#researchForm").on("submit", function(e) {
        let member = $("#id_members").val();
        let title = $("#title").val().trim();

        if (!member) {
            e.preventDefault();
            alert("Please select a member!");
            return false;
        }

        if (!title) {
            e.preventDefault();
            alert("Research title is required!");
            return false;
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>