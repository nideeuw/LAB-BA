<?php

/**
 * Profile Lab List View
 * File: app/cms/views/profile_lab/profile_lab_index.php
 */

// SET PAGE TITLE
$page_title = 'Profile Lab Management';

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
                        <h5 class="mb-0">Profile Lab (About Us) List</h5>
                        <a href="<?php echo $base_url; ?>/cms/profile_lab/add" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add New
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="profileLabTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($profiles)): ?>
                                        <?php foreach ($profiles as $profile): ?>
                                            <tr>
                                                <td><?php echo $profile['id']; ?></td>
                                                <td>
                                                    <?php if (!empty($profile['image'])): ?>
                                                        <img src="<?php echo $base_url; ?>/assets/<?php echo htmlspecialchars($profile['image']); ?>"
                                                            alt="<?php echo htmlspecialchars($profile['title']); ?>"
                                                            class="rounded"
                                                            style="width: 60px; height: 60px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="bg-light-primary rounded d-flex align-items-center justify-content-center"
                                                            style="width: 60px; height: 60px;">
                                                            <i class="ti ti-photo text-primary" style="font-size: 24px;"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($profile['title']); ?></strong>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars(substr($profile['description'], 0, 100)) . '...'; ?>
                                                </td>
                                                <td>
                                                    <?php if ($profile['is_active']): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <small>
                                                        <?php echo htmlspecialchars($profile['created_by'] ?? '-'); ?><br>
                                                        <span class="text-muted">
                                                            <?php echo !empty($profile['created_on']) ? date('d M Y', strtotime($profile['created_on'])) : '-'; ?>
                                                        </span>
                                                    </small>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group">
                                                        <!-- Set Active (if not active) -->
                                                        <?php if (!$profile['is_active']): ?>
                                                            <a href="<?php echo $base_url; ?>/cms/profile_lab/set-active/<?php echo $profile['id']; ?>"
                                                                class="btn btn-sm btn-success"
                                                                onclick="return confirm('Set this as active profile lab?')"
                                                                title="Set Active">
                                                                <i class="ti ti-check"></i>
                                                            </a>
                                                        <?php endif; ?>

                                                        <!-- Edit -->
                                                        <a href="<?php echo $base_url; ?>/cms/profile_lab/edit/<?php echo $profile['id']; ?>"
                                                            class="btn btn-sm btn-info"
                                                            title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>

                                                        <!-- Delete -->
                                                        <a href="<?php echo $base_url; ?>/cms/profile_lab/delete/<?php echo $profile['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this profile lab?')"
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
                                                    <i class="ti ti-info-circle f-40"></i>
                                                    <p class="mt-2">No profile lab found</p>
                                                    <a href="<?php echo $base_url; ?>/cms/profile_lab/add" class="btn btn-primary mt-2">
                                                        <i class="ti ti-plus"></i> Add First Profile Lab
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
    $("#profileLabTable").DataTable({
        order: [[0, "desc"]], // Sort by ID descending
        pageLength: 25,
        language: {
            search: "Search profile lab:",
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