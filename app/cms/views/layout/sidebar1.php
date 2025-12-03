<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="/cms/dashboard" class="b-brand text-primary">
                <!-- Logo -->
                <img src="<?php echo $base_url; ?>/assets/img/logo_black.png" alt="logo image" class="logo-lg">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">

                <!-- ====== Navigation ====== -->
                <li class="pc-item pc-caption">
                    <label>Navigation</label>
                </li>
                <li class="pc-item <?php echo ($active_page == 'dashboard') ? 'active' : ''; ?>">
                    <a href="/cms/dashboard" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <!-- ====== Management ====== -->
                <li class="pc-item pc-caption">
                    <label>Management</label>
                    <i class="ti ti-chart-dots"></i>
                </li>

                <!-- Users -->
                <li class="pc-item <?php echo ($active_page == 'users') ? 'active' : ''; ?>">
                    <a href="/cms/users" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Users</span>
                    </a>
                </li>

                <!-- Members -->
                <li class="pc-item <?php echo ($active_page == 'members') ? 'active' : ''; ?>">
                    <a href="/cms/members" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-user-check"></i></span>
                        <span class="pc-mtext">Members</span>
                    </a>
                </li>

                <!-- ====== Content ====== -->
                <li class="pc-item pc-caption">
                    <label>Content</label>
                    <i class="ti ti-apps"></i>
                </li>

                <!-- Gallery -->
                <li class="pc-item <?php echo ($active_page == 'gallery') ? 'active' : ''; ?>">
                    <a href="/cms/gallery" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-photo"></i></span>
                        <span class="pc-mtext">Gallery</span>
                    </a>
                </li>

                <!-- News Activity -->
                <li class="pc-item <?php echo ($active_page == 'news_activity') ? 'active' : ''; ?>">
                    <a href="/cms/news-activity" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-news"></i></span>
                        <span class="pc-mtext">News Activity</span>
                    </a>
                </li>

                <!-- Menu -->
                <li class="pc-item <?php echo ($active_page == 'menu') ? 'active' : ''; ?>">
                    <a href="/cms/menu" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-menu-2"></i></span>
                        <span class="pc-mtext">Menu</span>
                    </a>
                </li>

                <!-- ====== Projects ====== -->
                <li class="pc-item pc-caption">
                    <label>Projects</label>
                    <i class="ti ti-folder"></i>
                </li>

                <!-- Peminjaman Lab -->
                <li class="pc-item <?php echo ($active_page == 'peminjaman_lab') ? 'active' : ''; ?>">
                    <a href="/cms/peminjaman-lab" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-briefcase"></i></span>
                        <span class="pc-mtext">Peminjaman Lab</span>
                    </a>
                </li>

                <!-- Visi Misi -->
                <li class="pc-item <?php echo ($active_page == 'visi_misi') ? 'active' : ''; ?>">
                    <a href="/cms/visi-misi" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-target"></i></span>
                        <span class="pc-mtext">Visi Misi</span>
                    </a>
                </li>

                <!-- ====== Communication ====== -->
                <li class="pc-item pc-caption">
                    <label>Communication</label>
                    <i class="ti ti-message"></i>
                </li>

                <!-- Contact -->
                <li class="pc-item <?php echo ($active_page == 'contact') ? 'active' : ''; ?>">
                    <a href="/cms/contact" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-mail"></i></span>
                        <span class="pc-mtext">Contact</span>
                    </a>
                </li>

                <!-- ====== Other ====== -->
                <li class="pc-item pc-caption">
                    <label>Other</label>
                </li>

                <!-- Authentication -->
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-key"></i></span>
                        <span class="pc-mtext">Authentication</span>
                        <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link" href="/cms/login">Login</a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link" href="/cms/logout">Logout</a>
                        </li>
                    </ul>
                </li>

            </ul>

            <!-- Sidebar Footer Card -->
            <div class="card nav-action-card bg-primary">
                <div class="card-body" style="background: url('<?php echo $base_url; ?>/assets/images/layout/nav-card-bg.svg')">
                    <h5 class="text-white">Help Center</h5>
                    <p class="text-white text-opacity-75">Contact us for support</p>
                    <a href="https://wa.me/628" target="_blank" class="btn btn-light-primary text-white">
                        <i class="ti ti-headset"></i> Support
                    </a>
                </div>
            </div>

        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end -->