<?php

/**
 * Publication Edit View (CMS)
 * File: app/cms/views/publications/publications_edit.php
 */

// SET PAGE TITLE
$page_title = 'Edit Publication';

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
                        <h5 class="mb-0">Edit Publication</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/publications/update/<?php echo $publication['id']; ?>" method="POST" id="publicationForm">

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
                                                <?php echo ($publication['id_members'] == $member['id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars(MembersModel::getFullName($member)); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <!-- Title (Required) -->
                            <div class="mb-3">
                                <label for="title" class="form-label">
                                    Publication Title <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control"
                                    id="title"
                                    name="title"
                                    rows="3"
                                    required><?php echo htmlspecialchars($publication['title']); ?></textarea>
                            </div>

                            <!-- Journal Name -->
                            <div class="mb-3">
                                <label for="journal_name" class="form-label">Journal Name</label>
                                <input type="text"
                                    class="form-control"
                                    id="journal_name"
                                    name="journal_name"
                                    value="<?php echo htmlspecialchars($publication['journal_name'] ?? ''); ?>"
                                    placeholder="e.g., IEEE Transactions, Nature, etc.">
                            </div>

                            <!-- Year (Required) -->
                            <div class="mb-3">
                                <label for="year" class="form-label">
                                    Year <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                    class="form-control"
                                    id="year"
                                    name="year"
                                    required
                                    min="1900"
                                    max="<?php echo date('Y') + 1; ?>"
                                    value="<?php echo $publication['year']; ?>">
                            </div>

                            <!-- Journal Link -->
                            <div class="mb-3">
                                <label for="journal_link" class="form-label">Journal Link</label>
                                <input type="url"
                                    class="form-control"
                                    id="journal_link"
                                    name="journal_link"
                                    value="<?php echo htmlspecialchars($publication['journal_link'] ?? ''); ?>"
                                    placeholder="https://doi.org/...">
                                <small class="text-muted">Full URL to the publication</small>
                            </div>

                            <!-- Category -->
                            <div class="mb-3">
                                <label for="kategori_publikasi" class="form-label">Publication Category</label>
                                <input type="text"
                                    class="form-control"
                                    id="kategori_publikasi"
                                    name="kategori_publikasi"
                                    value="<?php echo htmlspecialchars($publication['kategori_publikasi'] ?? ''); ?>"
                                    placeholder="e.g., Journal, Conference, Book Chapter">
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
                                        <?php echo $publication['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">
                                        Active (Visible on public page)
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Publication
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/publications" class="btn btn-secondary">
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
                            <i class="ti ti-info-circle"></i> Publication Information
                        </h5>

                        <h6 class="mb-2">Publication ID:</h6>
                        <p class="mb-3"><?php echo $publication['id']; ?></p>

                        <h6 class="mb-2">Created:</h6>
                        <p class="mb-3">
                            <?php echo !empty($publication['created_by']) ? htmlspecialchars($publication['created_by']) : '-'; ?><br>
                            <small class="text-muted">
                                <?php echo !empty($publication['created_on']) ? date('d M Y H:i', strtotime($publication['created_on'])) : '-'; ?>
                            </small>
                        </p>

                        <?php if (!empty($publication['modified_on'])): ?>
                            <h6 class="mb-2">Last Modified:</h6>
                            <p class="mb-0">
                                <?php echo !empty($publication['modified_by']) ? htmlspecialchars($publication['modified_by']) : '-'; ?><br>
                                <small class="text-muted">
                                    <?php echo date('d M Y H:i', strtotime($publication['modified_on'])); ?>
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
    $("#publicationForm").on("submit", function(e) {
        let member = $("#id_members").val();
        let title = $("#title").val().trim();
        let year = $("#year").val();

        if (!member) {
            e.preventDefault();
            alert("Please select a member!");
            return false;
        }

        if (!title) {
            e.preventDefault();
            alert("Publication title is required!");
            return false;
        }

        if (!year) {
            e.preventDefault();
            alert("Year is required!");
            return false;
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>