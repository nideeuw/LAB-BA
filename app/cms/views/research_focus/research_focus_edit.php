<?php
$page_title = 'Edit Research Focus';
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
                        <h5 class="mb-0">Edit Research Focus: <?php echo htmlspecialchars($focus['title']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo $base_url; ?>/cms/research_focus/update/<?php echo $focus['id']; ?>">
                            
                            <div class="row">
                                <div class="col-md-8 mb-4">
                                    <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" required value="<?php echo htmlspecialchars($focus['title']); ?>">
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="sort_order" class="form-label fw-semibold">Sort Order <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?php echo $focus['sort_order']; ?>" required min="1">
                                    <div class="form-text">Lower numbers appear first</div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="focus_description" class="form-label fw-semibold">Focus Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="focus_description" name="focus_description" rows="4" required><?php echo htmlspecialchars($focus['focus_description']); ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="examples" class="form-label fw-semibold">Examples <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="examples" name="examples" rows="6" required><?php echo htmlspecialchars($focus['examples']); ?></textarea>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?php echo $focus['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">Active (Show on landing page)</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/research_focus" class="btn btn-outline-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                                <a href="<?php echo $base_url; ?>/cms/research_focus/delete/<?php echo $focus['id']; ?>"
                                    class="btn btn-danger ms-auto"
                                    onclick="return confirm('Delete this research focus?')">
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

<?php include __DIR__ . '/../layout/footer.php'; ?>