<?php

/**
 * Lab Bookings Index View
 * File: app/cms/views/lab_bookings/lab_bookings_index.php
 */

$page_title = 'Lab Bookings Management';
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="pc-container">
    <div class="pc-content">
        <?php include __DIR__ . '/../layout/breadcrumb.php'; ?>

        <!-- Flash Message -->
        <?php
        $flash = getFlash();
        if ($flash):
        ?>
            <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $flash['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Main Content -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Lab Bookings List</h5>
                        <a href="<?php echo $base_url; ?>/cms/lab_bookings/add" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add New Booking
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="bookingsTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Borrower</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Returned</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Active</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($bookings)): ?>
                                        <?php foreach ($bookings as $booking): ?>
                                            <tr>
                                                <td><?php echo $booking['id']; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($booking['peminjam_name'] ?? 'Unknown'); ?></strong><br>
                                                    <small class="text-muted"><?php echo htmlspecialchars($booking['peminjam_email'] ?? '-'); ?></small>
                                                </td>
                                                <td><?php echo date('d M Y', strtotime($booking['tanggal_mulai'])); ?></td>
                                                <td><?php echo date('d M Y', strtotime($booking['tanggal_selesai'])); ?></td>
                                                <td>
                                                    <?php if (!empty($booking['tanggal_dikembalikan'])): ?>
                                                        <span class="badge bg-success">
                                                            <?php echo date('d M Y', strtotime($booking['tanggal_dikembalikan'])); ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($booking['deskripsi'])): ?>
                                                        <small><?php echo substr(htmlspecialchars($booking['deskripsi']), 0, 50); ?><?php echo strlen($booking['deskripsi']) > 50 ? '...' : ''; ?></small>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'review' => 'info',
                                                        'approved' => 'success',
                                                        'in_use' => 'primary',
                                                        'returned' => 'success',
                                                        'canceled' => 'danger'
                                                    ];
                                                    $color = $statusColors[$booking['status']] ?? 'secondary';
                                                    ?>
                                                    <span class="badge bg-<?php echo $color; ?>">
                                                        <?php echo ucfirst(str_replace('_', ' ', $booking['status'])); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($booking['is_active']): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group">
                                                        <a href="<?php echo $base_url; ?>/cms/lab_bookings/edit/<?php echo $booking['id']; ?>"
                                                            class="btn btn-sm btn-info" title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>
                                                        <a href="<?php echo $base_url; ?>/cms/lab_bookings/delete/<?php echo $booking['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this booking?')"
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
                                                    <i class="ti ti-calendar-off f-40"></i>
                                                    <p class="mt-2">No lab bookings found</p>
                                                    <a href="<?php echo $base_url; ?>/cms/lab_bookings/add" class="btn btn-primary mt-2">
                                                        <i class="ti ti-plus"></i> Add First Booking
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
    </div>
</div>

<?php
$page_scripts = '
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $("#bookingsTable").DataTable({
        order: [[0, "desc"]],
        pageLength: 25,
        language: {
            search: "Search bookings:",
            lengthMenu: "Show _MENU_ bookings per page",
            info: "Showing _START_ to _END_ of _TOTAL_ bookings",
            infoEmpty: "No bookings found",
            infoFiltered: "(filtered from _MAX_ total bookings)",
            zeroRecords: "No matching bookings found"
        }
    });
});
</script>
';
include __DIR__ . '/../layout/footer.php';
?>