<?php

/**
 * Users List View
 * File: app/cms/views/users/users_index.php
 */

// SET PAGE TITLE
$page_title = 'User Management';

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
                        <h5 class="mb-0">User List</h5>
                        <a href="<?php echo $base_url; ?>/cms/users/create" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add New User
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="usersTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Last Login</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($users)): ?>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td><?php echo $user['id']; ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <div class="avtar avtar-s bg-light-primary">
                                                                <i class="ti ti-user"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if (!empty($user['email'])): ?>
                                                        <?php echo htmlspecialchars($user['email']); ?>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($user['is_active']): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($user['created_at'])): ?>
                                                        <small><?php echo date('d M Y H:i', strtotime($user['created_at'])); ?></small>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($user['last_login'])): ?>
                                                        <small><?php echo date('d M Y H:i', strtotime($user['last_login'])); ?></small>
                                                    <?php else: ?>
                                                        <span class="text-muted">Never</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group">
                                                        <!-- Edit -->
                                                        <a href="<?php echo $base_url; ?>/cms/users/edit/<?php echo $user['id']; ?>"
                                                            class="btn btn-sm btn-info"
                                                            title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>

                                                        <!-- Delete -->
                                                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                            <a href="<?php echo $base_url; ?>/cms/users/delete/<?php echo $user['id']; ?>"
                                                                class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure you want to delete this user?')"
                                                                title="Delete">
                                                                <i class="ti ti-trash"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <button class="btn btn-sm btn-secondary" disabled title="Cannot delete yourself">
                                                                <i class="ti ti-lock"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="ti ti-users f-40"></i>
                                                    <p class="mt-2">No users found</p>
                                                    <a href="<?php echo $base_url; ?>/cms/users/create" class="btn btn-primary mt-2">
                                                        <i class="ti ti-plus"></i> Add First User
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
    $("#usersTable").DataTable({
        order: [[0, "desc"]], // Sort by ID descending
        pageLength: 25,
        language: {
            search: "Search users:",
            lengthMenu: "Show _MENU_ users per page",
            info: "Showing _START_ to _END_ of _TOTAL_ users",
            infoEmpty: "No users found",
            infoFiltered: "(filtered from _MAX_ total users)",
            zeroRecords: "No matching users found"
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>