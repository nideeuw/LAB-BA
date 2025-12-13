<?php
$page_title = 'Edit Role';
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Edit Role: <?php echo htmlspecialchars($role['role_name']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/role/update/<?php echo $role['id']; ?>" method="POST" id="roleForm">

                            <div class="mb-4">
                                <label for="role_code" class="form-label fw-semibold">Role Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control text-uppercase" id="role_code" name="role_code" value="<?php echo htmlspecialchars($role['role_code']); ?>" required maxlength="50" style="text-transform: uppercase;">
                                <div class="form-text">Unique code for the role (uppercase, no spaces)</div>
                            </div>

                            <div class="mb-4">
                                <label for="role_name" class="form-label fw-semibold">Role Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="role_name" name="role_name" value="<?php echo htmlspecialchars($role['role_name']); ?>" required maxlength="100">
                                <div class="form-text">Descriptive name for the role</div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" <?php echo $role['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Role
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/role" class="btn btn-outline-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                                <a href="<?php echo $base_url; ?>/cms/role/delete/<?php echo $role['id']; ?>"
                                    class="btn btn-danger ms-auto"
                                    onclick="return confirm('Delete this role?')">
                                    <i class="ti ti-trash"></i> Delete
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$page_scripts = '
<script>
$(document).ready(function() {
    $("#role_code").on("input", function() {
        this.value = this.value.toUpperCase();
    });

    $("#roleForm").on("submit", function(e) {
        let roleCode = $("#role_code").val().trim();
        let roleName = $("#role_name").val().trim();

        if (!roleCode || !roleName) {
            e.preventDefault();
            alert("Role code and role name are required!");
            return false;
        }

        if (roleCode.includes(" ")) {
            e.preventDefault();
            alert("Role code cannot contain spaces!");
            return false;
        }

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