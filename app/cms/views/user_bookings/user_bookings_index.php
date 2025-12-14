<?php
$page_title = 'User Bookings Management';
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="pc-container">
    <div class="pc-content">
        <?php include __DIR__ . '/../layout/breadcrumb.php'; ?>

        <?php
        $flash = getFlash();
        if ($flash):
        ?>
            <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $flash['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">User Bookings List</h5>
                        <a href="<?php echo $base_url; ?>/cms/user_bookings/add" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add User
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>NIP</th>
                                        <th>Email</th>
                                        <th>No. HP</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($users)): ?>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td><?php echo $user['id']; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($user['nama']); ?></strong>
                                                </td>
                                                <td><?php echo htmlspecialchars($user['nip']); ?></td>
                                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                <td><?php echo htmlspecialchars($user['no_telp']); ?></td>
                                                <td>
                                                    <?php
                                                    $categoryColors = [
                                                        'mahasiswa' => 'primary',
                                                        'dosen' => 'success',
                                                        'staff' => 'info'
                                                    ];
                                                    $color = $categoryColors[$user['category']] ?? 'secondary';
                                                    ?>
                                                    <span class="badge bg-<?php echo $color; ?>">
                                                        <?php echo ucfirst($user['category']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($user['is_active']): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group">
                                                        <a href="<?php echo $base_url; ?>/cms/user_bookings/edit/<?php echo $user['id']; ?>"
                                                            class="btn btn-sm btn-info"
                                                            title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>
                                                        <a href="<?php echo $base_url; ?>/cms/user_bookings/delete/<?php echo $user['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Delete this user? This will also delete all their bookings!')"
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
                                                    <i class="ti ti-users-off f-40"></i>
                                                    <p class="mt-2">No users found</p>
                                                    <a href="<?php echo $base_url; ?>/cms/user_bookings/add" class="btn btn-primary mt-2">
                                                        <i class="ti ti-plus"></i> Add First User
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php include __DIR__ . '/../layout/pagination.php'; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include __DIR__ . '/../layout/footer.php';
?>