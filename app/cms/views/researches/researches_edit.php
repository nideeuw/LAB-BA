<?php
$page_title = 'Edit Research';
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
                        <h5 class="mb-0">Edit Research</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/researches/update/<?php echo $research['id']; ?>" method="POST" id="researchForm">

                            <div class="mb-4">
                                <label for="id_members" class="form-label fw-semibold">Member <span class="text-danger">*</span></label>
                                <select class="form-select" id="id_members" name="id_members" required>
                                    <option value="">-- Select Member --</option>
                                    <?php if (!empty($members)): ?>
                                        <?php foreach ($members as $member): ?>
                                            <option value="<?php echo $member['id']; ?>" <?php echo ($research['id_members'] == $member['id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars(MembersModel::getFullName($member)); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="title" class="form-label fw-semibold">Research Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" required value="<?php echo htmlspecialchars($research['title']); ?>" placeholder="e.g., Machine Learning, Natural Language Processing">
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fw-semibold">Description</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"><?php echo htmlspecialchars($research['deskripsi'] ?? ''); ?></textarea>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?php echo $research['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">Active (Visible on public page)</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Research
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/researches" class="btn btn-outline-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                                <a href="<?php echo $base_url; ?>/cms/researches/delete/<?php echo $research['id']; ?>"
                                    class="btn btn-danger ms-auto"
                                    onclick="return confirm('Delete this research?')">
                                    <i class="ti ti-trash"></i> Delete
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