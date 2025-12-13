<?php
$page_title = 'Add Research';
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
                        <h5 class="mb-0">Add New Research</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/researches/store" method="POST" id="researchForm">

                            <div class="mb-4">
                                <label for="id_members" class="form-label fw-semibold">Member <span class="text-danger">*</span></label>
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

                            <div class="mb-4">
                                <label for="title" class="form-label fw-semibold">Research Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" required placeholder="e.g., Machine Learning, Natural Language Processing">
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fw-semibold">Description</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Brief description of the research area"></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="year" class="form-label fw-semibold">Year Started</label>
                                <input type="number" class="form-control" id="year" name="year" min="1900" max="<?php echo date('Y') + 1; ?>" placeholder="<?php echo date('Y'); ?>">
                                <div class="form-text">Optional. Year when research started.</div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="is_active">Active (Visible on public page)</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Create Research
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/researches" class="btn btn-outline-secondary">
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