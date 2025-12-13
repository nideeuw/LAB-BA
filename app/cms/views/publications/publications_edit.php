<?php
$page_title = 'Edit Publication';
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
                        <h5 class="mb-0">Edit Publication</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/publications/update/<?php echo $publication['id']; ?>" method="POST" id="publicationForm">

                            <div class="mb-4">
                                <label for="id_members" class="form-label fw-semibold">Member <span class="text-danger">*</span></label>
                                <select class="form-select" id="id_members" name="id_members" required>
                                    <option value="">-- Select Member --</option>
                                    <?php if (!empty($members)): ?>
                                        <?php foreach ($members as $member): ?>
                                            <option value="<?php echo $member['id']; ?>" <?php echo ($publication['id_members'] == $member['id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars(MembersModel::getFullName($member)); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="title" class="form-label fw-semibold">Publication Title <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="title" name="title" rows="3" required><?php echo htmlspecialchars($publication['title']); ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="journal_name" class="form-label fw-semibold">Journal Name</label>
                                <input type="text" class="form-control" id="journal_name" name="journal_name" value="<?php echo htmlspecialchars($publication['journal_name'] ?? ''); ?>">
                            </div>

                            <div class="mb-4">
                                <label for="year" class="form-label fw-semibold">Year <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="year" name="year" required min="1900" max="<?php echo date('Y') + 1; ?>" value="<?php echo $publication['year']; ?>">
                            </div>

                            <div class="mb-4">
                                <label for="journal_link" class="form-label fw-semibold">Journal Link</label>
                                <input type="url" class="form-control" id="journal_link" name="journal_link" value="<?php echo htmlspecialchars($publication['journal_link'] ?? ''); ?>">
                                <div class="form-text">Full URL to the publication</div>
                            </div>

                            <div class="mb-4">
                                <label for="kategori_publikasi" class="form-label fw-semibold">Publication Category</label>
                                <input type="text" class="form-control" id="kategori_publikasi" name="kategori_publikasi" value="<?php echo htmlspecialchars($publication['kategori_publikasi'] ?? ''); ?>">
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?php echo $publication['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">Active (Visible on public page)</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Publication
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/publications" class="btn btn-outline-secondary">
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
$("#publicationForm").on("submit", function(e) {
    let member = $("#id_members").val();
    let title = $("#title").val().trim();
    let year = $("#year").val();
    if (!member || !title || !year) {
        e.preventDefault();
        alert("Please fill all required fields!");
        return false;
    }
});
</script>
';
include __DIR__ . '/../layout/footer.php';
?>