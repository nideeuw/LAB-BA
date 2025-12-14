<?php
$page_title = 'Contact Management';
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
                        <h5 class="mb-0">Contact Information List</h5>
                        <a href="<?php echo $base_url; ?>/cms/contact/add" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add New Contact
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="ti ti-info-circle"></i>
                            <strong>Note:</strong> Only ONE contact can be active at a time. The active contact will be displayed in the footer.
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($contacts)): ?>
                                        <?php foreach ($contacts as $contact): ?>
                                            <tr <?php echo $contact['is_active'] ? 'class="table-success"' : ''; ?>>
                                                <td><?php echo $contact['id']; ?></td>
                                                <td>
                                                    <i class="ti ti-mail"></i>
                                                    <?php echo htmlspecialchars($contact['email']); ?>
                                                </td>
                                                <td>
                                                    <i class="ti ti-map-pin"></i>
                                                    <div style="max-width: 300px;">
                                                        <?php echo htmlspecialchars($contact['alamat']); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <i class="ti ti-phone"></i>
                                                    <?php echo htmlspecialchars($contact['no_telp']); ?>
                                                </td>
                                                <td>
                                                    <?php if ($contact['is_active']): ?>
                                                        <span class="badge bg-success">
                                                            <i class="ti ti-check"></i> Active
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <small>
                                                        <?php echo htmlspecialchars($contact['created_by'] ?? '-'); ?><br>
                                                        <span class="text-muted">
                                                            <?php echo !empty($contact['created_on']) ? date('d M Y', strtotime($contact['created_on'])) : '-'; ?>
                                                        </span>
                                                    </small>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group">
                                                        <?php if (!$contact['is_active']): ?>
                                                            <a href="<?php echo $base_url; ?>/cms/contact/set-active/<?php echo $contact['id']; ?>"
                                                                class="btn btn-sm btn-success"
                                                                onclick="return confirm('Set this contact as active? This will deactivate other contacts.')"
                                                                title="Set Active">
                                                                <i class="ti ti-check"></i>
                                                            </a>
                                                        <?php endif; ?>

                                                        <a href="<?php echo $base_url; ?>/cms/contact/edit/<?php echo $contact['id']; ?>"
                                                            class="btn btn-sm btn-info"
                                                            title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>

                                                        <a href="<?php echo $base_url; ?>/cms/contact/delete/<?php echo $contact['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Delete this contact?')"
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
                                                    <i class="ti ti-address-book f-40"></i>
                                                    <p class="mt-2">No contact information found</p>
                                                    <a href="<?php echo $base_url; ?>/cms/contact/add" class="btn btn-primary mt-2">
                                                        <i class="ti ti-plus"></i> Add First Contact
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