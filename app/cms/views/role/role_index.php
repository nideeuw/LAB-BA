<?php

/**
 * Roles List View
 * File: app/cms/views/role/role_index.php
 */

// SET PAGE TITLE
$page_title = 'Role Management';

// Include layout
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">

        <!-- [ breadcrumb ] start -->
        <?php include __DIR__ . '/../layout/breadcrumb.php'; ?>
        <!-- [ breadcrumb ] end -->

        <!-- Flash Message -->
        <?php
        $flash = getFlash();
        if ($flash):
        ?>
            <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $flash['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Role List</h5>
                        <a href="<?php echo $base_url; ?>/cms/role/create" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add New Role
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="rolesTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Role Code</th>
                                        <th>Role Name</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($roles)): ?>
                                        <?php foreach ($roles as $role): ?>
                                            <tr>
                                                <td><?php echo $role['id']; ?></td>
                                                <td>
                                                    <span class="badge bg-dark">
                                                        <?php echo htmlspecialchars($role['role_code']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <div class="avtar avtar-s bg-light-info">
                                                                <i class="ti ti-shield"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <strong><?php echo htmlspecialchars($role['role_name']); ?></strong>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if ($role['is_active']): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($role['created_by'])): ?>
                                                        <small><?php echo htmlspecialchars($role['created_by']); ?></small>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($role['created_on'])): ?>
                                                        <small><?php echo date('d M Y H:i', strtotime($role['created_on'])); ?></small>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group">
                                                        <!-- Toggle Status -->
                                                        <a href="<?php echo $base_url; ?>/cms/role/toggle/<?php echo $role['id']; ?>"
                                                            class="btn btn-sm btn-<?php echo $role['is_active'] ? 'warning' : 'success'; ?>"
                                                            onclick="return confirm('Are you sure you want to change the status?')"
                                                            title="Toggle Status">
                                                            <i class="ti ti-toggle-<?php echo $role['is_active'] ? 'left' : 'right'; ?>"></i>
                                                        </a>

                                                        <!-- Edit -->
                                                        <a href="<?php echo $base_url; ?>/cms/role/edit/<?php echo $role['id']; ?>"
                                                            class="btn btn-sm btn-info"
                                                            title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>

                                                        <!-- Delete -->
                                                        <a href="<?php echo $base_url; ?>/cms/role/delete/<?php echo $role['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this role? This action cannot be undone!')"
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
                                                    <i class="ti ti-shield-off f-40"></i>
                                                    <p class="mt-2">No roles found</p>
                                                    <a href="<?php echo $base_url; ?>/cms/role/create" class="btn btn-primary mt-2">
                                                        <i class="ti ti-plus"></i> Add First Role
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->

    </div>
</div>

<?php
// Page specific scripts
$page_scripts = '
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $("#rolesTable").DataTable({
        order: [[0, "desc"]], // Sort by ID descending
        pageLength: 25,
        language: {
            search: "Search roles:",
            lengthMenu: "Show _MENU_ roles per page",
            info: "Showing _START_ to _END_ of _TOTAL_ roles",
            infoEmpty: "No roles found",
            infoFiltered: "(filtered from _MAX_ total roles)",
            zeroRecords: "No matching roles found"
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>