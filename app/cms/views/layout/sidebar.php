<?php
/**
 * Sidebar Layout
 * File: app/cms/views/layout/sidebar.php
 */
?>

<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="<?php echo $base_url; ?>/cms/dashboard" class="b-brand text-primary">
                <img src="<?php echo $base_url; ?>/assets/img/logo_black.png" alt="logo image" class="logo-lg">
                <img src="<?php echo $base_url; ?>/assets/img/logo_black.png" alt="logo icon" class="logo-sm">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">

                <?php
                $menus = MenuModel::getAllMenusHierarchical($conn);

                function renderMenu($items, $active_page, $base_url)
                {
                    foreach ($items as $item) {
                        // Label/Caption
                        if ($item['is_label']) {
                            echo '<li class="pc-item pc-caption">';
                            echo '<label>' . htmlspecialchars($item['menu_name']) . '</label>';
                            if (!empty($item['menu_icon'])) {
                                echo '<i class="' . htmlspecialchars($item['menu_icon']) . '"></i>';
                            }
                            echo '</li>';

                            if (!empty($item['children'])) {
                                renderMenu($item['children'], $active_page, $base_url);
                            }
                            continue;
                        }

                        // Regular menu
                        $hasChildren = !empty($item['children']);
                        $isActive = ($active_page == $item['slug']) ? 'active' : '';

                        // Generate URL
                        if ($hasChildren) {
                            // Dropdown - tidak ada URL, hanya toggle
                            $url = 'javascript:void(0);';
                        } elseif (!empty($item['menu_url'])) {
                            // Jika ada menu_url, cek apakah external atau internal
                            if (filter_var($item['menu_url'], FILTER_VALIDATE_URL)) {
                                // External URL (http/https)
                                $url = $item['menu_url'];
                            } else {
                                // Internal URL
                                $url = $base_url . '/' . ltrim($item['menu_url'], '/');
                            }
                        } elseif (!empty($item['slug'])) {
                            // Jika tidak ada menu_url tapi ada slug
                            $url = $base_url . '/cms/' . $item['slug'];
                        } else {
                            // Fallback: no link
                            $url = 'javascript:void(0);';
                        }

                        $liClass = 'pc-item';
                        if ($hasChildren) $liClass .= ' pc-hasmenu';
                        if ($isActive) $liClass .= ' active';

                        echo '<li class="' . $liClass . '">';
                        echo '<a href="' . htmlspecialchars($url) . '" class="pc-link">';

                        if (!empty($item['menu_icon'])) {
                            echo '<span class="pc-micon"><i class="' . htmlspecialchars($item['menu_icon']) . '"></i></span>';
                        }

                        echo '<span class="pc-mtext">' . htmlspecialchars($item['menu_name']) . '</span>';

                        if ($hasChildren) {
                            echo '<span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>';
                        }

                        echo '</a>';

                        if ($hasChildren) {
                            echo '<ul class="pc-submenu">';
                            renderMenu($item['children'], $active_page, $base_url);
                            echo '</ul>';
                        }

                        echo '</li>';
                    }
                }

                renderMenu($menus, $active_page ?? '', $base_url);
                ?>

            </ul>

            <!-- <div class="card nav-action-card bg-primary">
                <div class="card-body" style="background: url('<?php echo $base_url; ?>/assets/images/layout/nav-card-bg.svg')">
                    <h5 class="text-white">Help Center</h5>
                    <p class="text-white text-opacity-75">Contact us for support</p>
                    <a href="https://wa.me/628" target="_blank" class="btn btn-light-primary text-white">
                        <i class="ti ti-headset"></i> Support
                    </a>
                </div>
            </div> -->

        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end -->