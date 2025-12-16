<?php

/**
 * Dashboard View - Enhanced
 * File: app/cms/views/dashboard.php
 */

$page_title = 'Dashboard';
include __DIR__ . '/layout/header.php';
include __DIR__ . '/layout/sidebar.php';
?>

<div class="pc-container">
    <div class="pc-content">
        <?php include __DIR__ . '/layout/breadcrumb.php'; ?>

        <?php
        $flash = getFlash();
        if ($flash):
        ?>
            <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $flash['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Main Statistics Cards -->
        <div class="row">
            <!-- Total Users -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-primary">
                                    <i class="ti ti-users f-20"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Total Users</h6>
                            </div>
                        </div>
                        <div class="bg-body p-3 mt-3 rounded">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h4 class="mb-0 f-w-500"><?php echo number_format($total_users ?? 0); ?></h4>
                                    <span class="badge bg-light-primary mt-1">System Users</span>
                                </div>
                                <div class="text-end">
                                    <a href="<?php echo $base_url; ?>/cms/users" class="btn btn-sm btn-link-primary">
                                        View <i class="ti ti-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Members -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-success">
                                    <i class="ti ti-user-check f-20"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Lab Members</h6>
                            </div>
                        </div>
                        <div class="bg-body p-3 mt-3 rounded">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h4 class="mb-0 f-w-500"><?php echo number_format($total_members ?? 0); ?></h4>
                                    <span class="badge bg-light-success mt-1">Active</span>
                                </div>
                                <div class="text-end">
                                    <a href="<?php echo $base_url; ?>/cms/members" class="btn btn-sm btn-link-success">
                                        View <i class="ti ti-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Publications -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-info">
                                    <i class="ti ti-book f-20"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Publications</h6>
                            </div>
                        </div>
                        <div class="bg-body p-3 mt-3 rounded">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h4 class="mb-0 f-w-500"><?php echo number_format($total_publications ?? 0); ?></h4>
                                    <span class="badge bg-light-info mt-1">Published</span>
                                </div>
                                <div class="text-end">
                                    <a href="<?php echo $base_url; ?>/cms/publications" class="btn btn-sm btn-link-info">
                                        View <i class="ti ti-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Gallery -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-warning">
                                    <i class="ti ti-photo f-20"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Gallery Items</h6>
                            </div>
                        </div>
                        <div class="bg-body p-3 mt-3 rounded">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h4 class="mb-0 f-w-500"><?php echo number_format($total_gallery ?? 0); ?></h4>
                                    <span class="badge bg-light-warning mt-1">Images</span>
                                </div>
                                <div class="text-end">
                                    <a href="<?php echo $base_url; ?>/cms/gallery" class="btn btn-sm btn-link-warning">
                                        View <i class="ti ti-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Statistics -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-light-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ti ti-flask text-primary" style="font-size: 32px;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 text-muted">Research Areas</h6>
                                <h4 class="mb-0 text-primary"><?php echo number_format($total_researches ?? 0); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-light-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ti ti-calendar-check text-success" style="font-size: 32px;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 text-muted">Total Bookings</h6>
                                <h4 class="mb-0 text-success"><?php echo number_format($total_bookings ?? 0); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-light-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ti ti-clock text-danger" style="font-size: 32px;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 text-muted">Pending Bookings</h6>
                                <h4 class="mb-0 text-danger"><?php echo number_format($pending_bookings ?? 0); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-light-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ti ti-photo-check text-info" style="font-size: 32px;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 text-muted">Active Banners</h6>
                                <h4 class="mb-0 text-info"><?php echo number_format($active_banner ?? 0); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Tables & Activity -->
        <div class="row">
            <!-- Recent Members -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0"><i class="ti ti-users me-2"></i>Recent Members</h5>
                        <a href="<?php echo $base_url; ?>/cms/members" class="btn btn-sm btn-primary">
                            View All <i class="ti ti-arrow-right"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Member</th>
                                        <th>Position</th>
                                        <th>Email</th>
                                        <th>Joined</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recent_members)): ?>
                                        <?php foreach ($recent_members as $member): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avtar avtar-s bg-light-primary me-2">
                                                            <i class="ti ti-user"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">
                                                                <?php
                                                                $fullName = '';
                                                                if (!empty($member['gelar_depan'])) $fullName .= $member['gelar_depan'] . ' ';
                                                                $fullName .= $member['nama'];
                                                                if (!empty($member['gelar_belakang'])) $fullName .= ', ' . $member['gelar_belakang'];
                                                                echo htmlspecialchars($fullName);
                                                                ?>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light-info">
                                                        <?php echo htmlspecialchars($member['jabatan'] ?? '-'); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars($member['email'] ?? '-'); ?></td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo date('M d, Y', strtotime($member['created_on'])); ?>
                                                    </small>
                                                </td>
                                                <td class="text-end">
                                                    <a href="<?php echo $base_url; ?>/cms/members/edit/<?php echo $member['id']; ?>"
                                                        class="btn btn-sm btn-link-info">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="ti ti-users f-40 text-muted d-block mb-2"></i>
                                                <p class="text-muted mb-0">No members found</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Publications -->
                <div class="card mt-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0"><i class="ti ti-book me-2"></i>Recent Publications</h5>
                        <a href="<?php echo $base_url; ?>/cms/publications" class="btn btn-sm btn-info">
                            View All <i class="ti ti-arrow-right"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Year</th>
                                        <th>Journal</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recent_publications)): ?>
                                        <?php foreach ($recent_publications as $pub): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-start">
                                                        <i class="ti ti-book text-info me-2 mt-1"></i>
                                                        <span><?php echo htmlspecialchars($pub['title']); ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php
                                                    $authorName = '';
                                                    if (!empty($pub['gelar_depan'])) $authorName .= $pub['gelar_depan'] . ' ';
                                                    $authorName .= $pub['nama'] ?? 'Unknown';
                                                    if (!empty($pub['gelar_belakang'])) $authorName .= ', ' . $pub['gelar_belakang'];
                                                    echo htmlspecialchars($authorName);
                                                    ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light-primary">
                                                        <?php echo htmlspecialchars($pub['year'] ?? '-'); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo htmlspecialchars($pub['journal_name'] ?? '-'); ?>
                                                    </small>
                                                </td>
                                                <td class="text-end">
                                                    <a href="<?php echo $base_url; ?>/cms/publications/edit/<?php echo $pub['id']; ?>"
                                                        class="btn btn-sm btn-link-info">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="ti ti-book-off f-40 text-muted d-block mb-2"></i>
                                                <p class="text-muted mb-0">No publications found</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="card mt-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0"><i class="ti ti-calendar-check me-2"></i>Recent Lab Bookings</h5>
                        <a href="<?php echo $base_url; ?>/cms/lab_bookings" class="btn btn-sm btn-warning">
                            View All <i class="ti ti-arrow-right"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Borrower</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recent_bookings)): ?>
                                        <?php foreach ($recent_bookings as $booking): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avtar avtar-s bg-light-warning me-2">
                                                            <i class="ti ti-user"></i>
                                                        </div>
                                                        <span><?php echo htmlspecialchars($booking['peminjam_name'] ?? 'Unknown'); ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <small>
                                                        <?php echo date('d M Y', strtotime($booking['tanggal_mulai'])); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo substr($booking['jam_mulai'], 0, 5); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <?php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'approved' => 'success',
                                                        'rejected' => 'danger',
                                                        'canceled' => 'secondary',
                                                        'completed' => 'info'
                                                    ];
                                                    $color = $statusColors[$booking['status']] ?? 'secondary';
                                                    ?>
                                                    <span class="badge bg-light-<?php echo $color; ?>">
                                                        <?php echo ucfirst($booking['status']); ?>
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="<?php echo $base_url; ?>/cms/lab_bookings/edit/<?php echo $booking['id']; ?>"
                                                        class="btn btn-sm btn-link-warning">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="ti ti-calendar-off f-40 text-muted d-block mb-2"></i>
                                                <p class="text-muted mb-0">No bookings found</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-activity me-2"></i>Recent Activity</h5>
                    </div>
                    <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                        <?php if (!empty($recent_activities)): ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($recent_activities as $activity): ?>
                                    <li class="list-group-item px-0 border-bottom">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <div class="avtar avtar-s bg-light-<?php echo $activity['color']; ?>">
                                                    <i class="<?php echo $activity['icon']; ?>"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <h6 class="mb-0"><?php echo htmlspecialchars($activity['title']); ?></h6>
                                                    <small class="text-muted"><?php echo $activity['time']; ?></small>
                                                </div>
                                                <p class="text-muted mb-1 small">
                                                    <?php echo htmlspecialchars($activity['description']); ?>
                                                </p>
                                                <small class="text-muted">
                                                    <i class="ti ti-user-circle"></i>
                                                    <?php echo htmlspecialchars($activity['created_by']); ?>
                                                </small>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="ti ti-bell-off f-40 text-muted d-block mb-3"></i>
                                <p class="text-muted mb-0">No recent activities</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-bolt me-2"></i>Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <!-- View Website - Featured -->
                            <a href="<?php echo $base_url; ?>"
                                target="_blank"
                                class="btn btn-primary">
                                <i class="ti ti-world me-2"></i>
                                View Public Website
                            </a>
                            <hr class="my-2">
                            
                            <a href="<?php echo $base_url; ?>/cms/members/create" class="btn btn-light-primary">
                                <i class="ti ti-user-plus me-2"></i>
                                Add New Member
                            </a>
                            <a href="<?php echo $base_url; ?>/cms/publications/create" class="btn btn-light-info">
                                <i class="ti ti-table-plus me-2"></i>
                                Add Publication
                            </a>
                            <a href="<?php echo $base_url; ?>/cms/gallery/create" class="btn btn-light-success">
                                <i class="ti ti-photo-circle-plus me-2"></i>
                                Upload to Gallery
                            </a>
                            <a href="<?php echo $base_url; ?>/cms/lab_bookings/create" class="btn btn-light-warning">
                                <i class="ti ti-calendar-plus me-2"></i>
                                Create Booking
                            </a>
                            <a href="<?php echo $base_url; ?>/cms/banner/create" class="btn btn-light-danger">
                                <i class="ti ti-photo me-2"></i>
                                Add Banner
                            </a>
                        </div>
                    </div>
                </div>

                <!-- System Info Card -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-info-circle me-2"></i>System Info</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span class="text-muted">PHP Version</span>
                                <span class="badge bg-light-primary"><?php echo PHP_VERSION; ?></span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span class="text-muted">Server Time</span>
                                <span class="badge bg-light-success"><?php echo date('H:i:s'); ?></span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span class="text-muted">Date</span>
                                <span class="badge bg-light-info"><?php echo date('d M Y'); ?></span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span class="text-muted">Current User</span>
                                <span class="badge bg-light-warning"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Overview Cards -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-layout-grid me-2"></i>Content Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                                <a href="<?php echo $base_url; ?>/cms/profile_lab" class="text-decoration-none">
                                    <div class="p-3 rounded bg-light-primary">
                                        <i class="ti ti-info-circle text-primary d-block mb-2" style="font-size: 32px;"></i>
                                        <h6 class="mb-0 text-primary">Profile Lab</h6>
                                        <small class="text-muted">About Information</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                                <a href="<?php echo $base_url; ?>/cms/visi_misi" class="text-decoration-none">
                                    <div class="p-3 rounded bg-light-success">
                                        <i class="ti ti-target text-success d-block mb-2" style="font-size: 32px;"></i>
                                        <h6 class="mb-0 text-success">Visi & Misi</h6>
                                        <small class="text-muted">Vision & Mission</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                                <a href="<?php echo $base_url; ?>/cms/research_focus" class="text-decoration-none">
                                    <div class="p-3 rounded bg-light-info">
                                        <i class="ti ti-focus-2 text-info d-block mb-2" style="font-size: 32px;"></i>
                                        <h6 class="mb-0 text-info">Research Focus</h6>
                                        <small class="text-muted">Focus Areas</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <a href="<?php echo $base_url; ?>/cms/roadmap" class="text-decoration-none">
                                    <div class="p-3 rounded bg-light-warning">
                                        <i class="ti ti-route text-warning d-block mb-2" style="font-size: 32px;"></i>
                                        <h6 class="mb-0 text-warning">Roadmap</h6>
                                        <small class="text-muted">Strategic Plan</small>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row text-center">
                            <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                                <a href="<?php echo $base_url; ?>/cms/researches" class="text-decoration-none">
                                    <div class="p-3 rounded bg-light-danger">
                                        <i class="ti ti-flask text-danger d-block mb-2" style="font-size: 32px;"></i>
                                        <h6 class="mb-0 text-danger">Researches</h6>
                                        <small class="text-muted"><?php echo $total_researches ?? 0; ?> Items</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                                <a href="<?php echo $base_url; ?>/cms/research_scope" class="text-decoration-none">
                                    <div class="p-3 rounded bg-light-primary">
                                        <i class="ti ti-globe text-primary d-block mb-2" style="font-size: 32px;"></i>
                                        <h6 class="mb-0 text-primary">Research Scope</h6>
                                        <small class="text-muted">Scope Definition</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                                <a href="<?php echo $base_url; ?>/cms/contact" class="text-decoration-none">
                                    <div class="p-3 rounded bg-light-success">
                                        <i class="ti ti-phone text-success d-block mb-2" style="font-size: 32px;"></i>
                                        <h6 class="mb-0 text-success">Contact Info</h6>
                                        <small class="text-muted">Contact Details</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <a href="<?php echo $base_url; ?>/cms/user_bookings" class="text-decoration-none">
                                    <div class="p-3 rounded bg-light-info">
                                        <i class="ti ti-user-plus text-info d-block mb-2" style="font-size: 32px;"></i>
                                        <h6 class="mb-0 text-info">User Bookings</h6>
                                        <small class="text-muted">Manage Users</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>