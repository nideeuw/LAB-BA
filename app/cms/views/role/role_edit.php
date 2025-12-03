<?php

/**
 * Role Edit View
 * File: app/cms/views/role/role_edit.php
 */

// SET PAGE TITLE
$page_title = 'Edit Role';

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
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Edit Role: <?php echo htmlspecialchars($role['role_name']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/role/update/<?php echo $role['id']; ?>" method="POST" id="roleForm">

                            <!-- Role Code -->
                            <div class="mb-3">
                                <label for="role_code" class="form-label">
                                    Role Code <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control text-uppercase"
                                    id="role_code"
                                    name="role_code"
                                    value="<?php echo htmlspecialchars($role['role_code']); ?>"
                                    required
                                    maxlength="50"
                                    style="text-transform: uppercase;">
                                <small class="text-muted">Unique code for the role (will be converted to uppercase)</small>
                            </div>

                            <!-- Role Name -->
                            <div class="mb-3">
                                <label for="role_name" class="form-label">
                                    Role Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control"
                                    id="role_name"
                                    name="role_name"
                                    value="<?php echo htmlspecialchars($role['role_name']); ?>"
                                    required
                                    maxlength="100">
                                <small class="text-muted">Descriptive name for the role</small>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        <?php echo $role['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                                <small class="text-muted">Inactive roles cannot be assigned to users</small>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Role
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/role" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                                <a href="<?php echo $base_url; ?>/cms/role/delete/<?php echo $role['id']; ?>"
                                    class="btn btn-danger ms-auto"
                                    onclick="return confirm('Are you sure you want to delete this role? This action cannot be undone!')">
                                    <i class="ti ti-trash"></i> Delete Role
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Role Info Card -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="mb-3">Role Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Role ID:</strong> <?php echo $role['id']; ?></p>
                                <p class="mb-2"><strong>Created By:</strong>
                                    <?php echo !empty($role['created_by']) ? htmlspecialchars($role['created_by']) : '-'; ?>
                                </p>
                                <p class="mb-2"><strong>Created At:</strong>
                                    <?php echo !empty($role['created_on']) ? date('d M Y H:i', strtotime($role['created_on'])) : '-'; ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Modified By:</strong>
                                    <?php echo !empty($role['modified_by']) ? htmlspecialchars($role['modified_by']) : '-'; ?>
                                </p>
                                <p class="mb-2"><strong>Modified At:</strong>
                                    <?php echo !empty($role['modified_on']) ? date('d M Y H:i', strtotime($role['modified_on'])) : '-'; ?>
                                </p>
                                <p class="mb-2"><strong>Status:</strong>
                                    <?php echo $role['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="col-lg-4">
                <div class="card bg-light-warning">
                    <div class="card-body">
                        <h5 class="mb-3">
                            <i class="ti ti-alert-triangle"></i> Important Notes
                        </h5>

                        <ul class="mb-0">
                            <li>Changing role code may affect existing user assignments</li>
                            <li>Deactivating role will prevent assignment to new users</li>
                            <li>Cannot delete roles that are currently assigned to users</li>
                            <li>Role changes take effect immediately</li>
                            <li>Consider impact on system permissions before modifying</li>
                        </ul>
                    </div>
                </div>

                <!-- Usage Info Card -->
                <div class="card mt-3 bg-light-info">
                    <div class="card-body">
                        <h6 class="mb-2">
                            <i class="ti ti-users"></i> Role Usage
                        </h6>
                        <p class="mb-0">
                            <small>Check user management to see which users are assigned to this role before making changes.</small>
                        </p>
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
<script>
$(document).ready(function() {
    // Auto uppercase role code
    $("#role_code").on("input", function() {
        this.value = this.value.toUpperCase();
    });

    // Form validation
    $("#roleForm").on("submit", function(e) {
        let roleCode = $("#role_code").val().trim();
        let roleName = $("#role_name").val().trim();

        if (!roleCode || !roleName) {
            e.preventDefault();
            alert("Role code and role name are required!");
            return false;
        }

        // Check for spaces in role code
        if (roleCode.includes(" ")) {
            e.preventDefault();
            alert("Role code cannot contain spaces! Use underscore (_) instead.");
            return false;
        }

        // Validate role code format (only letters, numbers, underscore)
        if (!/^[A-Z0-9_]+$/.test(roleCode)) {
            e.preventDefault();
            alert("Role code can only contain uppercase letters, numbers, and underscores!");
            return false;
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>