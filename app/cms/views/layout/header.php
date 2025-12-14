<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $page_title ?? 'Dashboard'; ?> | Lab BA</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="icon" href="<?php echo $base_url; ?>/assets/img/logo.png" type="image/png">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/fonts/inter/inter.css" id="main-font-link">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/fonts/tabler-icons.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/fonts/feather.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/fonts/fontawesome.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/fonts/material.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css" id="main-style-link">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style-preset.css">
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">

    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <header class="pc-header">
        <div class="header-wrapper">
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="dropdown pc-h-item d-inline-flex d-md-none">
                        <a class="pc-head-link dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ti ti-search"></i>
                        </a>
                        <div class="dropdown-menu pc-h-dropdown drp-search">
                            <form class="px-3">
                                <div class="mb-0 d-flex align-items-center">
                                    <input type="search" class="form-control border-0 shadow-none" placeholder="Search...">
                                    <button class="btn btn-light-secondary btn-search">Search</button>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li class="pc-h-item d-none d-md-inline-flex cms-search-container">
                        <form class="form-search" onsubmit="return false;">
                            <i class="ti ti-search"></i>
                            <input type="search"
                                class="form-control"
                                placeholder="Search..."
                                id="cmsSearchInput"
                                onkeyup="handleCMSSearch(event)"
                                onfocus="handleCMSSearchFocus()"
                                autocomplete="off">
                        </form>
                        <div id="cmsSearchResults" class="cms-search-results"></div>
                    </li>
                </ul>
            </div>

            <div class="ms-auto">
                <ul class="list-unstyled">
                    <!-- View Website Button -->
                    <li class="pc-h-item d-none d-sm-inline-flex">
                        <a href="<?php echo $base_url; ?>" 
                           target="_blank" 
                           class="btn btn-sm btn-light-primary me-2"
                           title="View Public Website">
                            <i class="ti ti-world me-1"></i>
                            <span class="d-none d-md-inline-block">View Website</span>
                        </a>
                    </li>
                    
                    <li class="dropdown pc-h-item header-user-profile">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                            <?php 
                            $userProfile = UserModel::getUserById($_SESSION['user_id'], $conn);
                            $avatarUrl = !empty($userProfile['avatar']) 
                                ? $base_url . '/uploads/avatars/' . $userProfile['avatar']
                                : $base_url . '/assets/images/user/avatar-2.jpg';
                            ?>
                            <img src="<?php echo $avatarUrl; ?>" alt="user-image" class="user-avtar">
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                <h5 class="m-0">Profile</h5>
                            </div>
                            <div class="dropdown-body">
                                <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
                                    <div class="d-flex mb-1">
                                        <div class="flex-shrink-0">
                                            <img src="<?php echo $avatarUrl; ?>" alt="user-image" class="user-avtar wid-35">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1"><?php echo htmlspecialchars($userProfile['username'] ?? 'Admin User'); ?> 👋</h6>
                                            <span><?php echo htmlspecialchars($userProfile['email'] ?? 'No email'); ?></span>
                                        </div>
                                    </div>
                                    <hr class="border-secondary border-opacity-50">
                                    <div class="d-grid mb-3">
                                        <a href="<?php echo $base_url; ?>/cms/logout" class="btn btn-primary">
                                            <i class="ti ti-logout"></i> Logout
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <script>
        let cmsSearchTimeout = null;

        function handleCMSSearch(event) {
            const query = event.target.value.trim();
            const resultsDiv = document.getElementById('cmsSearchResults');

            if (cmsSearchTimeout) {
                clearTimeout(cmsSearchTimeout);
            }

            if (query.length < 2) {
                resultsDiv.classList.remove('show');
                resultsDiv.innerHTML = '';
                return;
            }

            resultsDiv.classList.add('show');
            resultsDiv.innerHTML = '<div style="padding: 1rem; text-align: center;"><i class="ti ti-loader"></i> Searching...</div>';

            cmsSearchTimeout = setTimeout(() => {
                fetch(`<?php echo $base_url; ?>/cms/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.results.length > 0) {
                            let html = '<ul>';

                            data.results.forEach(item => {
                                html += `
                            <li>
                                <a href="<?php echo $base_url; ?>${item.url}" onclick="closeCMSSearch()">
                                    <i class="${item.icon} search-icon"></i>
                                    <div class="search-content">
                                        <div class="search-title">${escapeHtml(item.title)}</div>
                                        <div class="search-meta">
                                            <span class="search-type">${item.type}</span>
                                            ${item.preview ? ' - ' + escapeHtml(item.preview) : ''}
                                        </div>
                                    </div>
                                </a>
                            </li>
                        `;
                            });

                            html += '</ul>';
                            html += `<div class="cms-search-footer">
                        Found ${data.count} result${data.count > 1 ? 's' : ''}
                    </div>`;

                            resultsDiv.innerHTML = html;
                        } else {
                            resultsDiv.innerHTML = '<div style="padding: 1rem; text-align: center; color: #666;"><i class="ti ti-search"></i> No results found</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        resultsDiv.innerHTML = '<div style="padding: 1rem; text-align: center; color: #d32f2f;"><i class="ti ti-alert-circle"></i> Search error</div>';
                    });
            }, 500);
        }

        function handleCMSSearchFocus() {
            const input = document.getElementById('cmsSearchInput');
            const resultsDiv = document.getElementById('cmsSearchResults');

            if (input.value.length >= 2 && resultsDiv.innerHTML) {
                resultsDiv.classList.add('show');
            }
        }

        function closeCMSSearch() {
            const resultsDiv = document.getElementById('cmsSearchResults');
            resultsDiv.classList.remove('show');
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        document.addEventListener('click', function(event) {
            const searchContainer = document.querySelector('.cms-search-container');
            const resultsDiv = document.getElementById('cmsSearchResults');

            if (searchContainer && !searchContainer.contains(event.target)) {
                if (resultsDiv) {
                    resultsDiv.classList.remove('show');
                }
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeCMSSearch();
            }
        });

        // Sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarHide = document.getElementById('sidebar-hide');
            const mobileCollapse = document.getElementById('mobile-collapse');
            const body = document.body;

            function isDesktop() {
                return window.innerWidth > 1024;
            }

            // Desktop toggle
            if (sidebarHide) {
                sidebarHide.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    if (isDesktop()) {
                        const isHidden = body.getAttribute('data-pc-sidebar-hide') === 'true';
                        body.setAttribute('data-pc-sidebar-hide', isHidden ? 'false' : 'true');
                        localStorage.setItem('sidebar-hide', isHidden ? 'false' : 'true');
                    } else {
                        body.classList.toggle('mob-sidebar-active');
                    }
                });
            }

            // Mobile toggle
            if (mobileCollapse) {
                mobileCollapse.addEventListener('click', function(e) {
                    e.preventDefault();
                    body.classList.toggle('mob-sidebar-active');
                });
            }

            // Load sidebar state hanya untuk desktop
            if (isDesktop()) {
                const sidebarState = localStorage.getItem('sidebar-hide');
                if (sidebarState === 'true') {
                    body.setAttribute('data-pc-sidebar-hide', 'true');
                } else {
                    body.setAttribute('data-pc-sidebar-hide', 'false');
                }
            } else {
                body.removeAttribute('data-pc-sidebar-hide');
            }

            // Close mobile sidebar when clicking outside
            document.addEventListener('click', function(e) {
                const sidebar = document.querySelector('.pc-sidebar');
                const trigger = document.getElementById('mobile-collapse');
                const desktopTrigger = document.getElementById('sidebar-hide');
                
                if (body.classList.contains('mob-sidebar-active')) {
                    if (!sidebar.contains(e.target) && e.target !== trigger && e.target !== desktopTrigger) {
                        body.classList.remove('mob-sidebar-active');
                    }
                }
            });

            // Handle resize - reset state
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (isDesktop()) {
                        body.classList.remove('mob-sidebar-active');
                        const sidebarState = localStorage.getItem('sidebar-hide');
                        if (sidebarState === 'true') {
                            body.setAttribute('data-pc-sidebar-hide', 'true');
                        } else {
                            body.setAttribute('data-pc-sidebar-hide', 'false');
                        }
                    } else {
                        body.classList.remove('mob-sidebar-active');
                        body.removeAttribute('data-pc-sidebar-hide');
                    }
                }, 250);
            });
        });
    </script>
</body>
</html>