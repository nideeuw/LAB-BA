<?php
$page_title = 'Research Scope Management';
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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Research Scope List</h5>
                        <a href="<?php echo $base_url; ?>/cms/research_scope/add" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add New Research Scope
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="20%">Title</th>
                                        <th width="30%">Preview</th>
                                        <th width="20%">Description</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Created</th>
                                        <th width="5%" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($researchScopes)): ?>
                                        <?php foreach ($researchScopes as $item): ?>
                                            <tr>
                                                <td><?php echo $item['id']; ?></td>
                                                <td><?php echo htmlspecialchars($item['title']); ?></td>
                                                <td>
                                                    <?php if (!empty($item['image'])): ?>
                                                        <img src="<?php echo $base_url; ?>/assets/<?php echo htmlspecialchars($item['image']); ?>"
                                                            class="img-thumbnail"
                                                            style="width: 150px; height: 100px; object-fit: cover; cursor: pointer;"
                                                            onclick="showImageModal('<?php echo $base_url; ?>/assets/<?php echo htmlspecialchars($item['image']); ?>')">
                                                    <?php else: ?>
                                                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 150px; height: 100px;">
                                                            <i class="ti ti-photo text-muted" style="font-size: 32px;"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 250px;" title="<?php echo htmlspecialchars($item['description'] ?? ''); ?>">
                                                        <?php
                                                        $desc = $item['description'] ?? '-';
                                                        echo htmlspecialchars(strlen($desc) > 80 ? substr($desc, 0, 80) . '...' : $desc);
                                                        ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if ($item['is_active']): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <small>
                                                        <?php echo htmlspecialchars($item['created_by'] ?? '-'); ?><br>
                                                        <span class="text-muted">
                                                            <?php echo !empty($item['created_on']) ? date('d M Y', strtotime($item['created_on'])) : '-'; ?>
                                                        </span>
                                                    </small>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group">
                                                        <a href="<?php echo $base_url; ?>/cms/research_scope/edit/<?php echo $item['id']; ?>"
                                                            class="btn btn-sm btn-warning" title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>
                                                        <a href="<?php echo $base_url; ?>/cms/research_scope/delete/<?php echo $item['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Delete this research scope? Image will be deleted too.')" title="Delete">
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <i class="ti ti-photo f-40 text-muted"></i>
                                                <p class="mt-2">No research scope found</p>
                                                <a href="<?php echo $base_url; ?>/cms/research_scope/add" class="btn btn-primary mt-2">
                                                    <i class="ti ti-plus"></i> Add First Research Scope
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php include __DIR__ . '/../layout/pagination.php'; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Research Scope Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="imageModalImg" src="" alt="" class="img-fluid" style="max-height: 80vh;">
            </div>
        </div>
    </div>
</div>

<?php
$page_scripts = '
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function showImageModal(imageUrl) {
    $("#imageModalImg").attr("src", imageUrl);
    $("#imageModal").modal("show");
}
</script>
';
include __DIR__ . '/../layout/footer.php';
?>