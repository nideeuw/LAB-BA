<?php
$page_title = 'Researches Management';
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
                        <h5 class="mb-0">Researches List</h5>
                        <a href="<?php echo $base_url; ?>/cms/researches/add" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add New Research
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Research Title</th>
                                        <th>Member</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($researches)): ?>
                                        <?php foreach ($researches as $research): ?>
                                            <tr>
                                                <td><?php echo $research['id']; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($research['title']); ?></strong>
                                                </td>
                                                <td>
                                                    <?php if (!empty($research['member_name'])): ?>
                                                        <span class="badge bg-light-info">
                                                            <?php echo htmlspecialchars($research['member_full_name']); ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($research['deskripsi'])): ?>
                                                        <div style="max-width: 300px;">
                                                            <?php
                                                            $desc = $research['deskripsi'];
                                                            echo strlen($desc) > 100 ? htmlspecialchars(substr($desc, 0, 100)) . '...' : htmlspecialchars($desc);
                                                            ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($research['is_active']): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <small>
                                                        <?php echo htmlspecialchars($research['created_by'] ?? '-'); ?><br>
                                                        <span class="text-muted">
                                                            <?php echo !empty($research['created_on']) ? date('d M Y', strtotime($research['created_on'])) : '-'; ?>
                                                        </span>
                                                    </small>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group">
                                                        <a href="<?php echo $base_url; ?>/cms/researches/edit/<?php echo $research['id']; ?>"
                                                            class="btn btn-sm btn-info"
                                                            title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>
                                                        <a href="<?php echo $base_url; ?>/cms/researches/delete/<?php echo $research['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Delete this research?')"
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
                                                    <i class="ti ti-search f-40"></i>
                                                    <p class="mt-2">No researches found</p>
                                                    <a href="<?php echo $base_url; ?>/cms/researches/add" class="btn btn-primary mt-2">
                                                        <i class="ti ti-plus"></i> Add First Research
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