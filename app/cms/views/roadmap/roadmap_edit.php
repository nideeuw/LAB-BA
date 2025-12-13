<?php
$page_title = 'Edit Roadmap';
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
                        <h5 class="mb-0">Edit Roadmap: <?php echo htmlspecialchars($roadmap['title']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/roadmap/update/<?php echo $roadmap['id']; ?>" method="POST" id="roadmapForm">

                            <div class="row">
                                <div class="col-md-8 mb-4">
                                    <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" required value="<?php echo htmlspecialchars($roadmap['title']); ?>" placeholder="e.g., Jangka Pendek (1–5 Tahun)">
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="sort_order" class="form-label fw-semibold">Sort Order <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?php echo $roadmap['sort_order']; ?>" required min="1">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="content" class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="content" name="content" rows="10" required placeholder="Enter roadmap content..."><?php echo htmlspecialchars($roadmap['content']); ?></textarea>
                                <div class="form-text">Use HTML formatting. Example: &lt;p&gt;&lt;strong&gt;Label:&lt;/strong&gt; Description&lt;/p&gt;</div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?php echo $roadmap['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Roadmap
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/roadmap" class="btn btn-outline-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                                <a href="<?php echo $base_url; ?>/cms/roadmap/delete/<?php echo $roadmap['id']; ?>"
                                    class="btn btn-danger ms-auto"
                                    onclick="return confirm('Delete this roadmap?')">
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