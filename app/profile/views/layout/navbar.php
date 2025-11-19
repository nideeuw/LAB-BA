<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorium Business Analyst</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ffffff;
            min-height: 100vh;
        }

        .navbar {
            background: #202740ff;
            backdrop-filter: blur(10px);
            padding: 0.1rem 2.5rem;
            box-shadow: none;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo img {
            height: 100px;
            width: auto;
            object-fit: contain;
            max-width: 500px;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            align-items: center;
        }

        .nav-menu li a {
            color: #ffffff;
            text-decoration: none;
            padding: 0.75rem 1rem;
            display: block;
            font-size: 0.95rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border-radius: 4px;
        }

        .nav-menu li a:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .nav-menu li a.active {
            background: rgba(255, 255, 255, 0.15);
            border-bottom: 2px solid #4a9eff;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-toggle {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .dropdown-toggle::after {
            content: '▼';
            font-size: 0.7rem;
            transition: transform 0.3s ease;
        }

        .dropdown:hover .dropdown-toggle::after {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: #20274080;
            min-width: 200px;
            border-radius: 4px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            opacity: 70;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            margin-top: 0.5rem;
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu li {
            width: 100%;
        }

        .dropdown-menu li a {
            padding: 0.75rem 1.5rem;
            width: 100%;
            border-radius: 0;
            white-space: nowrap;
        }

        .dropdown-menu li a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 5px;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background: white;
            transition: 0.3s;
        }
        .content {
            padding: 3rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
            color: white;
        }

        .content h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #2a5298;
        }

        .content p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #333;
        }

        .section {
            margin-bottom: 3rem;
            padding: 2rem;
            background: #0a2036ff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .section h2 {
            color: #deeaffff;
            margin-bottom: 1rem;
        }

        .section p {
            color: #ffffff;
        }

        .scroll-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #2a5298;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            z-index: 999;
            font-size: 1.5rem;
        }

        .scroll-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .scroll-to-top:hover {
            background: #1e3c72;
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
        }

        .scroll-to-top::before {
            content: '↑';
        }

        html {
            scroll-behavior: smooth;
        }

        .scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 4px;
            background: linear-gradient(90deg, #4a9eff, #2a5298);
            z-index: 1001;
            transition: width 0.1s ease;
        }
    </style>
</head>

<body>
    <div class="scroll-progress" id="scrollProgress"></div>

    <?php
    // Dapatkan nama file saat ini tanpa ekstensi
    $current_page = basename($_SERVER['PHP_SELF'], '.php');

    // Definisi menu
    $menu_items = [
        'home' => ['label' => 'HOME', 'url' => 'app/views/home.php'],
        'profile' => [
            'label' => 'PROFILE',
            'url' => '#',
            'submenu' => [
                'visi-misi' => ['label' => 'Visi & Misi', 'url' => 'app/views/visi-misi.php'],
                'struktur-organisasi' => ['label' => 'Structure Organization', 'url' => 'app/views/struktur-organisasi.php']
            ]
        ],
        'news' => ['label' => 'NEWS & ACTIVITY', 'url' => 'app/views/news.php'],
        'gallery' => ['label' => 'GALLERY', 'url' => 'app/views/gallery.php'],
        'peminjaman-lab' => ['label' => 'PEMINJAMAN LAB', 'url' => 'app/views/peminjaman-lab.php']
    ];

    // Fungsi untuk cek apakah menu aktif
    function isActive($page, $current)
    {
        return $page === $current ? 'active' : '';
    }

    // Fungsi untuk cek apakah submenu parent aktif
    function isParentActive($submenu, $current)
    {
        if (isset($submenu)) {
            foreach ($submenu as $key => $item) {
                if ($key === $current) {
                    return 'active';
                }
            }
        }
        return '';
    }
    ?>

    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <img src="/PBL/assets/img/logo.png" alt="Logo Lab BA">
            </div>

            <div class="hamburger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <ul class="nav-menu" id="navMenu">
                <?php foreach ($menu_items as $key => $item): ?>
                    <?php if (isset($item['submenu'])): ?>
                        <!-- Menu dengan Dropdown -->
                        <li class="dropdown">
                            <a href="<?php echo $item['url']; ?>"
                                class="dropdown-toggle <?php echo isParentActive($item['submenu'], $current_page); ?>"
                                onclick="toggleDropdown(event)">
                                <?php echo $item['label']; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php foreach ($item['submenu'] as $subkey => $subitem): ?>
                                    <li>
                                        <a href="<?php echo $subitem['url']; ?>"
                                            class="<?php echo isActive($subkey, $current_page); ?>">
                                            <?php echo $subitem['label']; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Menu Biasa -->
                        <li>
                            <a href="<?php echo $item['url']; ?>" class="<?php echo isActive($key, $current_page); ?>">
                                <?php echo $item['label']; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>

    <div class="content">
        <h1>Selamat Datang di Lab Business Analyst</h1>
        <p> <strong><?php echo ucwords(str_replace('-', ' ', $current_page)); ?></strong></p>
        <div class="section">
            <h2>Halo</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat.
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                laborum.</p>
        </div>

        <div class="section">
            <h2>Halo</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat.
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                laborum.</p>
        </div>

        <div class="section">
            <h2>Halo</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat.
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                laborum.</p>
        </div>
        <div class="section">
            <h2>Halo</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat.
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                laborum.</p>
        </div>
    </div>

    <div class="scroll-to-top" id="scrollToTop" onclick="scrollToTop()"></div>

    <script>
        function toggleMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.toggle('active');
        }

        function toggleDropdown(event) {
            if (window.innerWidth <= 768) {
                event.preventDefault();
                const dropdown = event.target.closest('.dropdown');
                dropdown.classList.toggle('active');
            }
        }

        document.addEventListener('click', function (event) {
            const navMenu = document.getElementById('navMenu');

            if (!event.target.closest('.nav-container')) {
                navMenu.classList.remove('active');
                document.querySelectorAll('.dropdown').forEach(dropdown => {
                    dropdown.classList.remove('active');
                });
            }
        });

        const scrollToTopBtn = document.getElementById('scrollToTop');
        window.addEventListener('scroll', function () {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.add('show');
            } else {
                scrollToTopBtn.classList.remove('show');
            }
            updateScrollProgress();
        });
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>