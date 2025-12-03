<?php

/**
 * Role Create View
 * File: app/cms/views/role/role_create.php
 */

// SET PAGE TITLE
$page_title = 'Add Role';

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
                        <h5 class="mb-0">Add New Role</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/role/store" method="POST" id="roleForm">

                            <!-- Role Code -->
                            <div class="mb-3">
                                <label for="role_code" class="form-label">
                                    Role Code <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control text-uppercase"
                                    id="role_code"
                                    name="role_code"
                                    required
                                    maxlength="50"
                                    placeholder="e.g., ADMIN, STAFF, MEMBER"
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
                                    required
                                    maxlength="100"
                                    placeholder="e.g., Administrator, Staff Member">
                                <small class="text-muted">Descriptive name for the role</small>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        checked>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                                <small class="text-muted">Inactive roles cannot be assigned to users</small>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Create Role
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/role" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="col-lg-4">
                <div class="card bg-light-info">
                    <div class="card-body">
                        <h5 class="mb-3">
                            <i class="ti ti-info-circle"></i> Role Guidelines
                        </h5>

                        <h6 class="mb-2">Role Code:</h6>
                        <ul class="mb-3">
                            <li>Must be unique</li>
                            <li>Use uppercase letters</li>
                            <li>No spaces (use underscore)</li>
                            <li>Max 50 characters</li>
                        </ul>

                        <h6 class="mb-2">Common Role Examples:</h6>
                        <ul class="mb-3">
                            <li><strong>ADMIN</strong> - Full system access</li>
                            <li><strong>STAFF</strong> - Staff members</li>
                            <li><strong>MEMBER</strong> - Regular members</li>
                            <li><strong>GUEST</strong> - Limited access</li>
                        </ul>

                        <h6 class="mb-2">Best Practices:</h6>
                        <ul>
                            <li>Use clear, descriptive names</li>
                            <li>Plan role hierarchy</li>
                            <li>Keep role count minimal</li>
                            <li>Document role purposes</li>
                        </ul>
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