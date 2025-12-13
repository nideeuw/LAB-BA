<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title><?php echo $page_title ?? 'Dashboard'; ?> | Lab BA</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- [Favicon] icon -->
    <link rel="icon" href="<?php echo $base_url; ?>/assets/images/favicon.svg" type="image/x-icon">

    <!-- [Font] Family -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/fonts/inter/inter.css" id="main-font-link">

    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/fonts/tabler-icons.min.css">

    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/fonts/feather.css">

    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/fonts/fontawesome.css">

    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/fonts/material.css">

    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css" id="main-style-link">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style-preset.css">
</head>
<!-- [Head] end -->

<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">

    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ Header Topbar ] start -->
    <header class="pc-header">
        <div class="header-wrapper">
            <!-- [Mobile Media Block] start -->
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <!-- ======= Menu collapse Icon ======= -->
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <!-- ======= Menu popup Icon (Mobile) ======= -->
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <!-- ======= Search (Mobile) ======= -->
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
                    <!-- ======= Search (Desktop) ======= -->
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
            <!-- [Mobile Media Block end] -->

            <!-- [Header Right Block] start -->
            <div class="ms-auto">
                <ul class="list-unstyled">
                    <!-- ======= Notification Dropdown ======= -->
                    <li class="dropdown pc-h-item">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ti ti-bell"></i>
                            <span class="badge bg-success pc-h-badge">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                <h5 class="m-0">Notifications</h5>
                                <a href="#!" class="btn btn-link btn-sm">Mark all read</a>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-body text-wrap header-notification-scroll position-relative" style="max-height: calc(100vh - 235px)">
                                <p class="text-span">Today</p>
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <i class="ti ti-user-plus text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="float-end text-sm text-muted">2 min ago</span>
                                                <h6 class="text-body mb-2">New user registered</h6>
                                                <p class="mb-0">John Doe just created an account</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center py-2">
                                <a href="#!" class="link-primary">View all</a>
                            </div>
                        </div>
                    </li>

                    <!-- ======= User Profile Dropdown ======= -->
                    <li class="dropdown pc-h-item header-user-profile">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                            <img src="<?php echo $base_url; ?>/assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar">
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                <h5 class="m-0">Profile</h5>
                            </div>
                            <div class="dropdown-body">
                                <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
                                    <div class="d-flex mb-1">
                                        <div class="flex-shrink-0">
                                            <img src="<?php echo $base_url; ?>/assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1"><?php echo $_SESSION['user_name'] ?? 'Admin User'; ?> 👋</h6>
                                            <span><?php echo $_SESSION['user_email'] ?? 'admin@example.com'; ?></span>
                                        </div>
                                    </div>
                                    <hr class="border-secondary border-opacity-50">
                                    <!-- FIX: Pakai $base_url -->
                                    <a href="<?php echo $base_url; ?>/cms/profile" class="dropdown-item">
                                        <span><i class="ti ti-user"></i><span>My Profile</span></span>
                                    </a>
                                    <a href="<?php echo $base_url; ?>/cms/settings" class="dropdown-item">
                                        <span><i class="ti ti-settings"></i><span>Settings</span></span>
                                    </a>
                                    <hr class="border-secondary border-opacity-50">
                                    <div class="d-grid mb-3">
                                        <!-- FIX: Logout button yang benar -->
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
            <!-- [Header Right Block] end -->
        </div>
    </header>
    <!-- [ Header ] end -->

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
    </script>