<?php
$page_title = 'Banner Management';
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
                        <h5 class="mb-0">Banner List</h5>
                        <a href="<?php echo $base_url; ?>/cms/banner/add" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add New Banner
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Preview</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($banner)): ?>
                                        <?php foreach ($banner as $item): ?>
                                            <tr>
                                                <td><?php echo $item['id']; ?></td>
                                                <td>
                                                    <?php if (!empty($item['image'])): ?>
                                                        <img src="<?php echo $base_url; ?>/assets/<?php echo htmlspecialchars($item['image']); ?>"
                                                            class="img-thumbnail"
                                                            style="width: 120px; height: 80px; object-fit: cover; cursor: pointer;"
                                                            onclick="showImageModal('<?php echo $base_url; ?>/assets/<?php echo htmlspecialchars($item['image']); ?>')">
                                                    <?php else: ?>
                                                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 120px; height: 80px;">
                                                            <i class="ti ti-photo text-muted" style="font-size: 32px;"></i>
                                                        </div>
                                                    <?php endif; ?>
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
                                                        <a href="<?php echo $base_url; ?>/cms/banner/edit/<?php echo $item['id']; ?>"
                                                            class="btn btn-sm btn-info" title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>
                                                        <a href="<?php echo $base_url; ?>/cms/banner/delete/<?php echo $item['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Delete this banner?')" title="Delete">
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="ti ti-photo f-40 text-muted"></i>
                                                <p class="mt-2">No banners found</p>
                                                <a href="<?php echo $base_url; ?>/cms/banner/add" class="btn btn-primary mt-2">
                                                    <i class="ti ti-plus"></i> Add First Banner
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

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Banner Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="imageModalImg" src="" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<?php
$page_scripts = '
<script>
function showImageModal(imageUrl) {
    $("#imageModalImg").attr("src", imageUrl);
    $("#imageModal").modal("show");
}
</script>
';
include __DIR__ . '/../layout/footer.php';
?>