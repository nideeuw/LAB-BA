<?php

/**
 * User Edit View
 * File: app/cms/views/users/users_edit.php
 */

// SET PAGE TITLE
$page_title = 'Edit User';

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
                        <h5 class="mb-0">Edit User: <?php echo htmlspecialchars($user['username']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/users/update/<?php echo $user['id']; ?>" method="POST" id="userForm">

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    Username <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control"
                                    id="username"
                                    name="username"
                                    value="<?php echo htmlspecialchars($user['username']); ?>"
                                    required
                                    placeholder="Enter username">
                                <small class="text-muted">Unique username for login</small>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
                                    placeholder="user@example.com">
                                <small class="text-muted">Optional</small>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    New Password
                                </label>
                                <input type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    minlength="6"
                                    placeholder="Leave empty to keep current password">
                                <small class="text-muted">Leave empty to keep current password. Minimum 6 characters if changing.</small>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">
                                    Confirm New Password
                                </label>
                                <input type="password"
                                    class="form-control"
                                    id="confirm_password"
                                    name="confirm_password"
                                    minlength="6"
                                    placeholder="Re-enter new password">
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        <?php echo $user['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                                <small class="text-muted">Inactive users cannot login</small>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update User
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/users" class="btn btn-secondary">
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

                <!-- User Info Card -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="mb-3">User Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>User ID:</strong> <?php echo $user['id']; ?></p>
                                <p class="mb-2"><strong>Created At:</strong>
                                    <?php echo !empty($user['created_at']) ? date('d M Y H:i', strtotime($user['created_at'])) : '-'; ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Last Login:</strong>
                                    <?php echo !empty($user['last_login']) ? date('d M Y H:i', strtotime($user['last_login'])) : 'Never'; ?>
                                </p>
                                <p class="mb-2"><strong>Status:</strong>
                                    <?php echo $user['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'; ?>
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
                            <li>Changing username may affect user\'s ability to login</li>
                            <li>Leave password fields empty to keep current password</li>
                            <li>Deactivating user will prevent login immediately</li>
                            <li>You cannot delete your own account</li>
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
    // Form validation
    $("#userForm").on("submit", function(e) {
        let username = $("#username").val().trim();
        let password = $("#password").val();
        let confirmPassword = $("#confirm_password").val();

        if (!username) {
            e.preventDefault();
            alert("Username is required!");
            return false;
        }

        // Only validate password if user is changing it
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