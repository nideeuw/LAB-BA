<?php

/**
 * Dashboard View
 * File: app/cms/views/dashboard.php
 */

// SET PAGE TITLE (WAJIB!)
$page_title = 'Dashboard';

// Include layout
include __DIR__ . '/layout/header.php';
include __DIR__ . '/layout/sidebar.php';
?>

<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">

        <!-- [ breadcrumb ] start - GANTI JADI INI! -->
        <?php include __DIR__ . '/layout/breadcrumb.php'; ?>
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

            <!-- [ Statistics Cards ] start -->
            <div class="col-sm-12">
                <div class="row">

                    <!-- Card 1: Total Users -->
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
                                            <h4 class="mb-0 f-w-500"><?php echo $total_users ?? '0'; ?></h4>
                                            <span class="text-success d-inline-flex align-items-center">
                                                <i class="ti ti-arrow-up"></i> +12.5%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Active Members -->
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
                                        <h6 class="mb-0">Active Members</h6>
                                    </div>
                                </div>
                                <div class="bg-body p-3 mt-3 rounded">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="mb-0 f-w-500"><?php echo $total_members ?? '0'; ?></h4>
                                            <span class="text-success d-inline-flex align-items-center">
                                                <i class="ti ti-arrow-up"></i> +8.2%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Lab Bookings -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-light-warning">
                                            <i class="ti ti-briefcase f-20"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">Lab Bookings</h6>
                                    </div>
                                </div>
                                <div class="bg-body p-3 mt-3 rounded">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="mb-0 f-w-500">42</h4>
                                            <span class="text-danger d-inline-flex align-items-center">
                                                <i class="ti ti-arrow-down"></i> -2.1%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: New Messages -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-light-danger">
                                            <i class="ti ti-mail f-20"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">New Messages</h6>
                                    </div>
                                </div>
                                <div class="bg-body p-3 mt-3 rounded">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="mb-0 f-w-500">89</h4>
                                            <span class="text-success d-inline-flex align-items-center">
                                                <i class="ti ti-arrow-up"></i> +15.3%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- [ Statistics Cards ] end -->

                <!-- [ Tables & Activity ] start -->
                <div class="row">

                    <!-- Recent Users Table -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h5 class="mb-0">Recent Users</h5>
                                <div class="dropdown">
                                    <a class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti ti-dots-vertical f-18"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">View All</a>
                                        <a class="dropdown-item" href="#">Export</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?php echo $base_url; ?>/assets/images/user/avatar-1.jpg" alt="user" class="img-radius wid-40 me-2">
                                                        <div>
                                                            <h6 class="mb-0">John Doe</h6>
                                                            <small class="text-muted">@johndoe</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>john@example.com</td>
                                                <td><span class="badge bg-light-primary">Admin</span></td>
                                                <td><span class="badge bg-light-success">Active</span></td>
                                                <td class="text-end">
                                                    <button class="btn btn-sm btn-link-primary"><i class="ti ti-eye"></i></button>
                                                    <button class="btn btn-sm btn-link-info"><i class="ti ti-pencil"></i></button>
                                                    <button class="btn btn-sm btn-link-danger"><i class="ti ti-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Feed -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Recent Activity</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <div class="avtar avtar-s bg-light-primary">
                                                    <i class="ti ti-user-plus"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-0"><strong>New user registered</strong></p>
                                                <p class="text-muted mb-0">John Doe joined</p>
                                                <small class="text-muted">2 minutes ago</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <div class="avtar avtar-s bg-light-success">
                                                    <i class="ti ti-file-text"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-0"><strong>Report generated</strong></p>
                                                <p class="text-muted mb-0">Monthly analytics ready</p>
                                                <small class="text-muted">1 hour ago</small>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- [ Tables & Activity ] end -->

            </div>

        </div>
        <!-- [ Main Content ] end -->

    </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>