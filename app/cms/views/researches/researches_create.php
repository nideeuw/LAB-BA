<?php

/**
 * Research Create View (CMS)
 * File: app/cms/views/researches/researches_create.php
 */

// SET PAGE TITLE
$page_title = 'Add Research';

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
                        <h5 class="mb-0">Add New Research</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/researches/store" method="POST" id="researchForm">

                            <!-- Member (Required) -->
                            <div class="mb-3">
                                <label for="id_members" class="form-label">
                                    Member <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="id_members" name="id_members" required>
                                    <option value="">-- Select Member --</option>
                                    <?php if (!empty($members)): ?>
                                        <?php foreach ($members as $member): ?>
                                            <option value="<?php echo $member['id']; ?>">
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
                                    placeholder="e.g., Machine Learning, Natural Language Processing, IoT">
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Description</label>
                                <textarea class="form-control"
                                    id="deskripsi"
                                    name="deskripsi"
                                    rows="4"
                                    placeholder="Brief description of the research area"></textarea>
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
                                    placeholder="<?php echo date('Y'); ?>">
                                <small class="text-muted">Optional. Year when research started.</small>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        value="1"
                                        checked>
                                    <label class="form-check-label" for="is_active">
                                        Active (Visible on public page)
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Create Research
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/researches" class="btn btn-secondary">
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
                        <h5 class="mb-3">
                            <i class="ti ti-info-circle"></i> Research Guidelines
                        </h5>

                        <h6 class="mb-2">Required Fields:</h6>
                        <ul class="mb-3">
                            <li>Member (Researcher)</li>
                            <li>Research Title</li>
                        </ul>

                        <h6 class="mb-2">Research Title Examples:</h6>
                        <ul class="mb-3">
                            <li>Machine Learning</li>
                            <li>Natural Language Processing</li>
                            <li>Computer Vision</li>
                            <li>Internet of Things</li>
                            <li>Data Science</li>
                            <li>Artificial Intelligence</li>
                        </ul>

                        <h6 class="mb-2">Notes:</h6>
                        <ul class="mb-0">
                            <li>Members can have multiple research areas</li>
                            <li>Research areas will be displayed on member profiles</li>
                            <li>Active researches appear in filters</li>
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