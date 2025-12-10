<?php

/**
 * Roadmap List View
 * File: app/cms/views/roadmap/roadmap_index.php
 */

// SET PAGE TITLE
$page_title = 'Roadmap Management';

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
                        <h5 class="mb-0">Roadmap List</h5>
                        <a href="<?php echo $base_url; ?>/cms/roadmap/add" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add New
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="roadmapTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Sort Order</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($roadmaps)): ?>
                                        <?php foreach ($roadmaps as $roadmap): ?>
                                            <tr>
                                                <td><?php echo $roadmap['id']; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($roadmap['title']); ?></strong>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars(substr(strip_tags($roadmap['content']), 0, 80)) . '...'; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?php echo $roadmap['sort_order']; ?></span>
                                                </td>
                                                <td>
                                                    <?php if ($roadmap['is_active']): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <small>
                                                        <?php echo htmlspecialchars($roadmap['created_by'] ?? '-'); ?><br>
                                                        <span class="text-muted">
                                                            <?php echo !empty($roadmap['created_on']) ? date('d M Y', strtotime($roadmap['created_on'])) : '-'; ?>
                                                        </span>
                                                    </small>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group">
                                                        <!-- Edit -->
                                                        <a href="<?php echo $base_url; ?>/cms/roadmap/edit/<?php echo $roadmap['id']; ?>"
                                                            class="btn btn-sm btn-info"
                                                            title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>

                                                        <!-- Delete -->
                                                        <a href="<?php echo $base_url; ?>/cms/roadmap/delete/<?php echo $roadmap['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this roadmap?')"
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
                                                    <i class="ti ti-timeline f-40"></i>
                                                    <p class="mt-2">No roadmap found</p>
                                                    <a href="<?php echo $base_url; ?>/cms/roadmap/add" class="btn btn-primary mt-2">
                                                        <i class="ti ti-plus"></i> Add First Roadmap
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
    $("#roadmapTable").DataTable({
        order: [[3, "asc"]], // Sort by sort_order ascending
        pageLength: 25,
        language: {
            search: "Search roadmap:",
            lengthMenu: "Show _MENU_ entries per page",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No entries found",
            infoFiltered: "(filtered from _MAX_ total entries)",
            zeroRecords: "No matching entries found"
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>