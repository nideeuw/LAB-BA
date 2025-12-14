<?php
$page_title = 'Research Focus Management';
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
                        <h5 class="mb-0">Research Focus List</h5>
                        <a href="<?php echo $base_url; ?>/cms/research_focus/add" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add New Research Focus
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Focus Description</th>
                                        <th>Sort Order</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($focusItems)): ?>
                                        <?php foreach ($focusItems as $focus): ?>
                                            <tr>
                                                <td><?php echo $focus['id']; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($focus['title']); ?></strong>
                                                </td>
                                                <td>
                                                    <div style="max-width: 300px;">
                                                        <?php echo htmlspecialchars(substr(strip_tags($focus['focus_description']), 0, 60)) . '...'; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?php echo $focus['sort_order']; ?></span>
                                                </td>
                                                <td>
                                                    <?php if ($focus['is_active']): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <small>
                                                        <?php echo htmlspecialchars($focus['created_by'] ?? '-'); ?><br>
                                                        <span class="text-muted">
                                                            <?php echo !empty($focus['created_on']) ? date('d M Y', strtotime($focus['created_on'])) : '-'; ?>
                                                        </span>
                                                    </small>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group">
                                                        <a href="<?php echo $base_url; ?>/cms/research_focus/edit/<?php echo $focus['id']; ?>"
                                                            class="btn btn-sm btn-info"
                                                            title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>
                                                        <a href="<?php echo $base_url; ?>/cms/research_focus/delete/<?php echo $focus['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this research focus?')"
                                                            title="Delete">
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="ti ti-bulb f-40"></i>
                                                    <p class="mt-2">No research focus found</p>
                                                    <a href="<?php echo $base_url; ?>/cms/research_focus/add" class="btn btn-primary mt-2">
                                                        <i class="ti ti-plus"></i> Add First Research Focus
                                                    </a>
                                                </div>
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

<?php
include __DIR__ . '/../layout/footer.php';
?>