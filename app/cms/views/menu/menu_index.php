<?php

/**
 * Menu List View
 * File: app/cms/views/menu/menu_index.php
 */

// SET PAGE TITLE (WAJIB!)
$page_title = 'Menu Management';

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
                        <h5 class="mb-0">Menu List</h5>
                        <!-- FIX: Pakai $base_url -->
                        <a href="<?php echo $base_url; ?>/cms/menu/create" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add New Menu
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="menuTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Menu Name</th>
                                        <th>Parent</th>
                                        <th>Level</th>
                                        <th>Type</th>
                                        <th>Icon</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th>Last Modified</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($menus)): ?>
                                        <?php foreach ($menus as $menu): ?>
                                            <tr>
                                                <td><?php echo $menu['order_no']; ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php if (!empty($menu['menu_icon'])): ?>
                                                            <i class="<?php echo htmlspecialchars($menu['menu_icon']); ?> me-2"></i>
                                                        <?php endif; ?>
                                                        <strong><?php echo htmlspecialchars($menu['menu_name']); ?></strong>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if (!empty($menu['parent_name'])): ?>
                                                        <span class="badge bg-light-info">
                                                            <?php echo htmlspecialchars($menu['parent_name']); ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light-secondary">
                                                        Level <?php echo $menu['menu_level']; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php
                                                    $typeColors = [
                                                        'single' => 'primary',
                                                        'parent' => 'warning',
                                                        'child' => 'info'
                                                    ];
                                                    $color = $typeColors[$menu['type']] ?? 'secondary';
                                                    ?>
                                                    <span class="badge bg-light-<?php echo $color; ?>">
                                                        <?php echo ucfirst($menu['type']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if (!empty($menu['menu_icon'])): ?>
                                                        <code><?php echo htmlspecialchars($menu['menu_icon']); ?></code>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($menu['slug'])): ?>
                                                        <code><?php echo htmlspecialchars($menu['slug']); ?></code>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($menu['is_active']): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($menu['modified_on'])): ?>
                                                        <small>
                                                            <?php echo date('d M Y H:i', strtotime($menu['modified_on'])); ?><br>
                                                            <span class="text-muted">by <?php echo htmlspecialchars($menu['modified_by'] ?? '-'); ?></span>
                                                        </small>
                                                    <?php else: ?>
                                                        <small>
                                                            <?php echo date('d M Y H:i', strtotime($menu['created_on'])); ?><br>
                                                            <span class="text-muted">by <?php echo htmlspecialchars($menu['created_by'] ?? '-'); ?></span>
                                                        </small>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group">
                                                        <!-- Toggle Status -->
                                                        <!-- FIX: Pakai $base_url -->
                                                        <a href="<?php echo $base_url; ?>/cms/menu/toggle/<?php echo $menu['id']; ?>"
                                                            class="btn btn-sm btn-<?php echo $menu['is_active'] ? 'warning' : 'success'; ?>"
                                                            onclick="return confirm('Toggle menu status?')"
                                                            title="Toggle Status">
                                                            <i class="ti ti-power"></i>
                                                        </a>

                                                        <!-- Edit -->
                                                        <!-- FIX: Pakai $base_url -->
                                                        <a href="<?php echo $base_url; ?>/cms/menu/edit/<?php echo $menu['id']; ?>"
                                                            class="btn btn-sm btn-info"
                                                            title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>

                                                        <!-- Delete -->
                                                        <!-- FIX: Pakai $base_url -->
                                                        <a href="<?php echo $base_url; ?>/cms/menu/delete/<?php echo $menu['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this menu?')"
                                                            title="Delete">
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="10" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="ti ti-menu-2 f-40"></i>
                                                    <p class="mt-2">No menus found</p>
                                                    <!-- FIX: Pakai $base_url -->
                                                    <a href="<?php echo $base_url; ?>/cms/menu/create" class="btn btn-primary mt-2">
                                                        <i class="ti ti-plus"></i> Add First Menu
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
    $("#menuTable").DataTable({
        order: [[0, "asc"]], // Sort by order_no
        pageLength: 25,
        language: {
            search: "Search menus:",
            lengthMenu: "Show _MENU_ menus per page",
            info: "Showing _START_ to _END_ of _TOTAL_ menus",
            infoEmpty: "No menus found",
            infoFiltered: "(filtered from _MAX_ total menus)",
            zeroRecords: "No matching menus found"
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>