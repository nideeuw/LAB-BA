<?php

/**
 * Menu Edit View
 * File: app/cms/views/menu/edit.php
 */

// SET PAGE TITLE (WAJIB!)
$page_title = 'Edit Menu';

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
                        <h5 class="mb-0">Edit Menu: <?php echo htmlspecialchars($menu['menu_name']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/menu/update/<?php echo $menu['id']; ?>" method="POST" id="menuForm">

                            <!-- Menu Name -->
                            <div class="mb-3">
                                <label for="menu_name" class="form-label">
                                    Menu Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control"
                                    id="menu_name"
                                    name="menu_name"
                                    value="<?php echo htmlspecialchars($menu['menu_name']); ?>"
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
                                            <?php if ($parentMenu['id'] != $menu['id']): // Prevent self-parent 
                                            ?>
                                                <option value="<?php echo $parentMenu['id']; ?>"
                                                    <?php echo ($menu['parent_id'] == $parentMenu['id']) ? 'selected' : ''; ?>>
                                                    <?php
                                                    echo str_repeat('— ', $parentMenu['menu_level'] - 1) .
                                                        htmlspecialchars($parentMenu['menu_name']);
                                                    ?>
                                                </option>
                                            <?php endif; ?>
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
                                            <option value="single" <?php echo ($menu['type'] == 'single') ? 'selected' : ''; ?>>
                                                Single (Direct Link)
                                            </option>
                                            <option value="parent" <?php echo ($menu['type'] == 'parent') ? 'selected' : ''; ?>>
                                                Parent (Has Sub-menus)
                                            </option>
                                            <option value="child" <?php echo ($menu['type'] == 'child') ? 'selected' : ''; ?>>
                                                Child (Sub-menu Item)
                                            </option>
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
                                            min="0"
                                            value="<?php echo $menu['menu_level']; ?>"
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
                                            value="<?php echo $menu['order_no']; ?>"
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
                                            value="<?php echo htmlspecialchars($menu['menu_icon'] ?? ''); ?>"
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
                                    value="<?php echo htmlspecialchars($menu['slug']); ?>"
                                    placeholder="e.g., users-management">
                                <small class="text-muted">Use lowercase and hyphens only.</small>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        <?php echo $menu['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                                <small class="text-muted">Inactive menus will not appear in the navigation</small>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Menu
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/menu" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                                <a href="<?php echo $base_url; ?>/cms/menu/delete/<?php echo $menu['id']; ?>"
                                    class="btn btn-danger ms-auto"
                                    onclick="return confirm('Are you sure you want to delete this menu?')">
                                    <i class="ti ti-trash"></i> Delete Menu
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Menu Info Card -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="mb-3">Menu Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Created By:</strong> <?php echo htmlspecialchars($menu['created_by'] ?? '-'); ?></p>
                                <p class="mb-0"><strong>Created On:</strong> <?php echo date('d M Y H:i', strtotime($menu['created_on'])); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Modified By:</strong> <?php echo htmlspecialchars($menu['modified_by'] ?? '-'); ?></p>
                                <p class="mb-0"><strong>Modified On:</strong> <?php echo !empty($menu['modified_on']) ? date('d M Y H:i', strtotime($menu['modified_on'])) : '-'; ?></p>
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
                            <li>Changing menu structure may affect navigation</li>
                            <li>Deactivating a parent menu will hide all its sub-menus</li>
                            <li>Deleting a menu with sub-menus is not allowed</li>
                            <li>Slug changes may break existing links</li>
                        </ul>
                    </div>
                </div>

                <!-- Icon Preview Card -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="mb-3">Icon Preview</h6>
                        <div class="d-flex align-items-center justify-content-center p-4 border rounded">
                            <i id="iconPreview"
                                class="<?php echo $menu['menu_icon'] ? htmlspecialchars($menu['menu_icon']) : 'ti ti-help'; ?>"
                                style="font-size: 48px;"></i>
                        </div>
                        <p class="text-center text-muted mt-2 mb-0" id="iconName">
                            <?php echo $menu['menu_icon'] ? htmlspecialchars($menu['menu_icon']) : 'No icon selected'; ?>
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
    // Auto-adjust level based on parent selection
    $("#parent_id").on("change", function() {
        if ($(this).val()) {
            let parentOption = $(this).find("option:selected");
            let parentText = parentOption.text();
            let parentLevel = (parentText.match(/—/g) || []).length;
            $("#menu_level").val(parentLevel + 2);
        } else {
            $("#menu_level").val(1);
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