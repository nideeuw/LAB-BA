<?php
$page_title = 'Add Research Focus';
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
                        <h5 class="mb-0">Add New Research Focus</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/research_focus/store" method="POST" id="researchFocusForm">

                            <div class="row">
                                <div class="col-md-8 mb-4">
                                    <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" required placeholder="e.g., INTELIJEN PROSES BISNIS & KEUNGGULAN OPERASIONAL">
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="sort_order" class="form-label fw-semibold">Sort Order <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?php echo $nextOrder ?? 1; ?>" required min="1">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="focus_description" class="form-label fw-semibold">Focus Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="focus_description" name="focus_description" rows="4" required placeholder="Enter the main focus or goal of this research area..."></textarea>
                                <div class="form-text">Describe the focus of this research area (2-3 sentences)</div>
                            </div>

                            <div class="mb-4">
                                <label for="examples" class="form-label fw-semibold">Examples <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="examples" name="examples" rows="8" required placeholder="Enter example research topics, separated by line breaks."></textarea>
                                <div class="form-text">List 3-5 example research topics, one per line</div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Create Research Focus
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/research_focus" class="btn btn-outline-secondary">
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
$("#researchFocusForm").on("submit", function(e) {
    let title = $("#title").val().trim();
    let focusDescription = $("#focus_description").val().trim();
    let examples = $("#examples").val().trim();
    if (!title || !focusDescription || !examples) {
        e.preventDefault();
        alert("All fields are required!");
        return false;
    }
});
</script>
';
include __DIR__ . '/../layout/footer.php';
?>