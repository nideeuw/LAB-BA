<?php
/**
 * Members List View
 * File: app/cms/views/members/members_index.php
 */

// SET PAGE TITLE
$page_title = 'Members Management';

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
                        <h5 class="mb-0">Members List</h5>
                        <a href="<?php echo $base_url; ?>/cms/members/add" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add New Member
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="membersTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Email</th>
                                        <th>SINTA</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($members)): ?>
                                        <?php foreach ($members as $member): ?>
                                            <tr>
                                                <td><?php echo $member['id']; ?></td>
                                                <td>
                                                    <?php if (!empty($member['image'])): ?>
                                                        <img src="<?php echo $base_url; ?>/assets/<?php echo htmlspecialchars($member['image']); ?>" 
                                                             alt="<?php echo htmlspecialchars($member['nama']); ?>"
                                                             class="rounded-circle"
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="bg-light-primary rounded-circle d-flex align-items-center justify-content-center" 
                                                             style="width: 50px; height: 50px;">
                                                            <i class="ti ti-user text-primary" style="font-size: 24px;"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong><?php echo htmlspecialchars(MembersModel::getFullName($member)); ?></strong>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if (!empty($member['jabatan'])): ?>
                                                        <span class="badge bg-light-info"><?php echo htmlspecialchars($member['jabatan']); ?></span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($member['email'])): ?>
                                                        <a href="mailto:<?php echo htmlspecialchars($member['email']); ?>">
                                                            <?php echo htmlspecialchars($member['email']); ?>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($member['sinta_link'])): ?>
                                                        <a href="<?php echo htmlspecialchars($member['sinta_link']); ?>" 
                                                           target="_blank" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            <i class="ti ti-external-link"></i> View
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($member['is_active']): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <small>
                                                        <?php echo htmlspecialchars($member['created_by'] ?? '-'); ?><br>
                                                        <span class="text-muted">
                                                            <?php echo !empty($member['created_on']) ? date('d M Y', strtotime($member['created_on'])) : '-'; ?>
                                                        </span>
                                                    </small>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group">
                                                        <!-- Edit -->
                                                        <a href="<?php echo $base_url; ?>/cms/members/edit/<?php echo $member['id']; ?>"
                                                            class="btn btn-sm btn-info"
                                                            title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>

                                                        <!-- Delete -->
                                                        <a href="<?php echo $base_url; ?>/cms/members/delete/<?php echo $member['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this member?')"
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
                                                    <i class="ti ti-users f-40"></i>
                                                    <p class="mt-2">No members found</p>
                                                    <a href="<?php echo $base_url; ?>/cms/members/add" class="btn btn-primary mt-2">
                                                        <i class="ti ti-plus"></i> Add First Member
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
    $("#membersTable").DataTable({
        order: [[2, "asc"]], // Sort by name
        pageLength: 25,
        language: {
            search: "Search members:",
            lengthMenu: "Show _MENU_ members per page",
            info: "Showing _START_ to _END_ of _TOTAL_ members",
            infoEmpty: "No members found",
            infoFiltered: "(filtered from _MAX_ total members)",
            zeroRecords: "No matching members found"
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>