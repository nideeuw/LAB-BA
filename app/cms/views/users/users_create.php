<?php

/**
 * User Create View
 * File: app/cms/views/users/users_create.php
 */

// SET PAGE TITLE
$page_title = 'Add User';

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
                        <h5 class="mb-0">Add New User</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/users/store" method="POST" id="userForm">

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    Username <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control"
                                    id="username"
                                    name="username"
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
                                    placeholder="user@example.com">
                                <small class="text-muted">Optional</small>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <input type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    required
                                    minlength="6"
                                    placeholder="Minimum 6 characters">
                                <small class="text-muted">Minimum 6 characters</small>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">
                                    Confirm Password <span class="text-danger">*</span>
                                </label>
                                <input type="password"
                                    class="form-control"
                                    id="confirm_password"
                                    name="confirm_password"
                                    required
                                    minlength="6"
                                    placeholder="Re-enter password">
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
                                <small class="text-muted">Inactive users cannot login</small>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Create User
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/users" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="col-lg-4">
                <div class="card bg-light-primary">
                    <div class="card-body">
                        <h5 class="mb-3">
                            <i class="ti ti-info-circle"></i> User Guidelines
                        </h5>

                        <h6 class="mb-2">Username Requirements:</h6>
                        <ul class="mb-3">
                            <li>Must be unique</li>
                            <li>No spaces allowed</li>
                            <li>Case-sensitive</li>
                        </ul>

                        <h6 class="mb-2">Password Requirements:</h6>
                        <ul class="mb-3">
                            <li>Minimum 6 characters</li>
                            <li>Use strong passwords</li>
                            <li>Mix letters and numbers</li>
                        </ul>

                        <h6 class="mb-2">Best Practices:</h6>
                        <ul>
                            <li>Use valid email addresses</li>
                            <li>Set appropriate permissions</li>
                            <li>Disable unused accounts</li>
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

        if (!username || !password) {
            e.preventDefault();
            alert("Username and password are required!");
            return false;
        }

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
    });

    // Show/Hide password
    $("#password, #confirm_password").after(\'<span class="input-group-text cursor-pointer toggle-password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none;"><i class="ti ti-eye"></i></span>\');
    
    $(".toggle-password").on("click", function() {
        let input = $(this).prev("input");
        let icon = $(this).find("i");
        
        if (input.attr("type") === "password") {
            input.attr("type", "text");
            icon.removeClass("ti-eye").addClass("ti-eye-off");
        } else {
            input.attr("type", "password");
            icon.removeClass("ti-eye-off").addClass("ti-eye");
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>