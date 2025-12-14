<?php
$page_title = 'Publications Management';
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
                        <h5 class="mb-0">Publications List</h5>
                        <a href="<?php echo $base_url; ?>/cms/publications/add" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add New Publication
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Member</th>
                                        <th>Journal</th>
                                        <th>Year</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($publications)): ?>
                                        <?php foreach ($publications as $pub): ?>
                                            <tr>
                                                <td><?php echo $pub['id']; ?></td>
                                                <td>
                                                    <div style="max-width: 300px;">
                                                        <strong><?php echo htmlspecialchars($pub['title']); ?></strong>
                                                        <?php if (!empty($pub['journal_link'])): ?>
                                                            <br><a href="<?php echo htmlspecialchars($pub['journal_link']); ?>"
                                                                target="_blank"
                                                                class="text-primary small">
                                                                <i class="ti ti-external-link"></i> View Journal
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if (!empty($pub['member_name'])): ?>
                                                        <span class="badge bg-light-info">
                                                            <?php echo htmlspecialchars($pub['member_full_name']); ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php echo !empty($pub['journal_name']) ? htmlspecialchars($pub['journal_name']) : '<span class="text-muted">-</span>'; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary"><?php echo $pub['year']; ?></span>
                                                </td>
                                                <td>
                                                    <?php if (!empty($pub['kategori_publikasi']) && $pub['kategori_publikasi'] !== '-'): ?>
                                                        <span class="badge bg-light-success">
                                                            <?php echo htmlspecialchars($pub['kategori_publikasi']); ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($pub['is_active']): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <small>
                                                        <?php echo htmlspecialchars($pub['created_by'] ?? '-'); ?><br>
                                                        <span class="text-muted">
                                                            <?php echo !empty($pub['created_on']) ? date('d M Y', strtotime($pub['created_on'])) : '-'; ?>
                                                        </span>
                                                    </small>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group">
                                                        <a href="<?php echo $base_url; ?>/cms/publications/edit/<?php echo $pub['id']; ?>"
                                                            class="btn btn-sm btn-info"
                                                            title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>
                                                        <a href="<?php echo $base_url; ?>/cms/publications/delete/<?php echo $pub['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this publication?')"
                                                            title="Delete">
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="ti ti-file-text f-40"></i>
                                                    <p class="mt-2">No publications found</p>
                                                    <a href="<?php echo $base_url; ?>/cms/publications/add" class="btn btn-primary mt-2">
                                                        <i class="ti ti-plus"></i> Add First Publication
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