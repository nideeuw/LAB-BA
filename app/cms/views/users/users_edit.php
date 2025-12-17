<?php
$page_title = 'Edit User';
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
                        <h5 class="mb-0">Edit User: <?php echo htmlspecialchars($user['username']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/users/update/<?php echo $user['id']; ?>" method="POST" id="userForm">

                            <div class="mb-4">
                                <label for="username" class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required placeholder="Enter username">
                            </div>

                            <div class="mb-4">
                                <label for="full_name" class="form-label fw-semibold">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" placeholder="Enter full name">
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" placeholder="user@example.com">
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" minlength="6" placeholder="Leave empty to keep current password">
                                <div class="form-text">Leave empty to keep current password</div>
                            </div>

                            <div class="mb-4">
                                <label for="confirm_password" class="form-label fw-semibold">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="6" placeholder="Re-enter new password">
                            </div>

                            <div class="mb-4">
                                <label for="role_id" class="form-label fw-semibold">Role</label>
                                <select class="form-select" id="role_id" name="role_id">
                                    <option value="">Select Role (Optional)</option>
                                    <?php
                                    // Get active roles from database
                                    $activeRoles = RoleModel::getActiveRoles($conn);
                                    foreach ($activeRoles as $role):
                                        $selected = ($user['role_id'] == $role['id']) ? 'selected' : '';
                                    ?>
                                        <option value="<?php echo $role['id']; ?>" <?php echo $selected; ?>>
                                            <?php echo htmlspecialchars($role['role_name']); ?> (<?php echo htmlspecialchars($role['role_code']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">Leave empty to remove role assignment</small>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?php echo $user['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update User
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/users" class="btn btn-outline-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                    <a href="<?php echo $base_url; ?>/cms/users/delete/<?php echo $user['id']; ?>"
                                        class="btn btn-danger ms-auto"
                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="ti ti-trash"></i> Delete User
                                    </a>
                                <?php endif; ?>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $("#userForm").on("submit", function(e) {
        let username = $("#username").val().trim();
        let password = $("#password").val();
        let confirmPassword = $("#confirm_password").val();

        if (!username) {
            e.preventDefault();
            alert("Username is required!");
            return false;
        }

        if (password) {
            if (password.length < 6) {
                e.preventDefault();
                alert("Password must be at least 6 characters!");
                return false;
            }

            if (password !== confirmPassword) {
                e.preventDefault();
                alert("Passwords do not match!");
                return false;
            }
        }
    });
});
</script>
';
include __DIR__ . '/../layout/footer.php';
?>