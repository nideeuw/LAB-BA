<?php

/**
 * Researches List View (CMS)
 * File: app/cms/views/researches/researches_index.php
 */

// SET PAGE TITLE
$page_title = 'Researches Management';

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
                        <h5 class="mb-0">Researches List</h5>
                        <a href="<?php echo $base_url; ?>/cms/researches/add" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add New Research
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="researchesTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Research Title</th>
                                        <th>Member</th>
                                        <th>Description</th>
                                        <th>Year</th>
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
                                                            <?php echo htmlspecialchars(ResearchesModel::getMemberFullName($research)); ?>
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
                                                    <?php if (!empty($research['year'])): ?>
                                                        <span class="badge bg-secondary"><?php echo $research['year']; ?></span>
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
                                                        <!-- Edit -->
                                                        <a href="<?php echo $base_url; ?>/cms/researches/edit/<?php echo $research['id']; ?>"
                                                            class="btn btn-sm btn-info"
                                                            title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>

                                                        <!-- Delete -->
                                                        <a href="<?php echo $base_url; ?>/cms/researches/delete/<?php echo $research['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this research?')"
                                                            title="Delete">
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
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
    $("#researchesTable").DataTable({
        order: [[1, "asc"]], // Sort by title
        pageLength: 25,
        language: {
            search: "Search researches:",
            lengthMenu: "Show _MENU_ researches per page",
            info: "Showing _START_ to _END_ of _TOTAL_ researches",
            infoEmpty: "No researches found",
            infoFiltered: "(filtered from _MAX_ total researches)",
            zeroRecords: "No matching researches found"
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>