<?php

/**
 * Menu Create View
 * File: app/cms/views/menu/create.php
 */

// SET PAGE TITLE (WAJIB!)
$page_title = 'Create Menu';

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
                        <h5 class="mb-0">Create New Menu</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/menu/store" method="POST" id="menuForm">

                            <!-- Menu Name -->
                            <div class="mb-3">
                                <label for="menu_name" class="form-label">
                                    Menu Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control"
                                    id="menu_name"
                                    name="menu_name"
                                    required
                                    placeholder="e.g., Dashboard, Users Management">
                                <small class="text-muted">The display name of the menu item</small>
                            </div>

                            <!-- Parent Menu -->
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent Menu</label>
                                <select class="form-select" id="parent_id" name="parent_id">
                                    <option value="">None (Top Level Menu)</option>
                                    <?php if (!empty($parent_menus)): ?>
                                        <?php foreach ($parent_menus as $parentMenu): ?>
                                            <option value="<?php echo $parentMenu['id']; ?>">
                                                <?php
                                                echo str_repeat('— ', $parentMenu['menu_level'] - 1) .
                                                    htmlspecialchars($parentMenu['menu_name']);
                                                ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <small class="text-muted">Select parent if this is a sub-menu</small>
                            </div>

                            <!-- Row: Type & Level -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">
                                            Menu Type <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="type" name="type" required>
                                            <option value="">Select Type</option>
                                            <option value="single">Single (Direct Link)</option>
                                            <option value="parent">Parent (Has Sub-menus)</option>
                                            <option value="child">Child (Sub-menu Item)</option>
                                        </select>
                                        <small class="text-muted">Defines menu behavior</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="menu_level" class="form-label">
                                            Menu Level <span class="text-danger">*</span>
                                        </label>
                                        <input type="number"
                                            class="form-control"
                                            id="menu_level"
                                            name="menu_level"
                                            min="1"
                                            value="1"
                                            required>
                                        <small class="text-muted">1 = Top level, 2 = Sub-menu, 3 = Sub-sub-menu</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Row: Order & Icon -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="order_no" class="form-label">
                                            Order Number <span class="text-danger">*</span>
                                        </label>
                                        <input type="number"
                                            class="form-control"
                                            id="order_no"
                                            name="order_no"
                                            min="0"
                                            value="0"
                                            required>
                                        <small class="text-muted">Display order (lower numbers appear first)</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="menu_icon" class="form-label">Menu Icon</label>
                                        <input type="text"
                                            class="form-control"
                                            id="menu_icon"
                                            name="menu_icon"
                                            placeholder="e.g., ti ti-dashboard">
                                        <small class="text-muted">
                                            <a href="https://tabler.io/icons" target="_blank">Browse Tabler Icons</a>
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Slug -->
                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug (URL)</label>
                                <input type="text"
                                    class="form-control"
                                    id="slug"
                                    name="slug"
                                    placeholder="e.g., users-management">
                                <small class="text-muted">Auto-generated if left empty. Use lowercase and hyphens only.</small>
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
                                <small class="text-muted">Inactive menus will not appear in the navigation</small>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Create Menu
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/menu" class="btn btn-secondary">
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
                            <i class="ti ti-info-circle"></i> Menu Guidelines
                        </h5>

                        <h6 class="mb-2">Menu Types:</h6>
                        <ul class="mb-3">
                            <li><strong>Single:</strong> Direct link menu without sub-menus</li>
                            <li><strong>Parent:</strong> Menu that contains sub-menus</li>
                            <li><strong>Child:</strong> Sub-menu item under a parent</li>
                        </ul>

                        <h6 class="mb-2">Menu Levels:</h6>
                        <ul class="mb-3">
                            <li><strong>1:</strong> Top-level menu</li>
                            <li><strong>2:</strong> First-level sub-menu</li>
                            <li><strong>3+:</strong> Nested sub-menus</li>
                        </ul>

                        <h6 class="mb-2">Best Practices:</h6>
                        <ul>
                            <li>Use clear, descriptive menu names</li>
                            <li>Keep menu structure shallow (max 2-3 levels)</li>
                            <li>Use consistent icon styles</li>
                            <li>Order menus logically</li>
                        </ul>
                    </div>
                </div>

                <!-- Icon Preview Card -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="mb-3">Icon Preview</h6>
                        <div class="d-flex align-items-center justify-content-center p-4 border rounded">
                            <i id="iconPreview" class="ti ti-help" style="font-size: 48px;"></i>
                        </div>
                        <p class="text-center text-muted mt-2 mb-0" id="iconName">No icon selected</p>
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
    // Auto-generate slug from menu name
    $("#menu_name").on("input", function() {
        let name = $(this).val();
        let slug = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, "")
            .replace(/\s+/g, "-")
            .replace(/-+/g, "-")
            .trim();
        $("#slug").val(slug);
    });

    // Auto-adjust level based on parent selection
    $("#parent_id").on("change", function() {
        if ($(this).val()) {
            let parentOption = $(this).find("option:selected");
            let parentText = parentOption.text();
            let parentLevel = (parentText.match(/—/g) || []).length;
            $("#menu_level").val(parentLevel + 2);
            
            // Auto-select type as child
            $("#type").val("child");
        } else {
            $("#menu_level").val(1);
            $("#type").val("single");
        }
    });

    // Icon preview
    $("#menu_icon").on("input", function() {
        let iconClass = $(this).val();
        if (iconClass) {
            $("#iconPreview").attr("class", iconClass);
            $("#iconName").text(iconClass);
        } else {
            $("#iconPreview").attr("class", "ti ti-help");
            $("#iconName").text("No icon selected");
        }
    });

    // Form validation
    $("#menuForm").on("submit", function(e) {
        let menuName = $("#menu_name").val().trim();
        let orderNo = $("#order_no").val();
        let menuLevel = $("#menu_level").val();
        let type = $("#type").val();

        if (!menuName || !orderNo || menuLevel === "" || !type) {
            e.preventDefault();
            alert("Please fill in all required fields!");
            return false;
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>