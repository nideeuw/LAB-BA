<link rel="stylesheet" href="/PBL/assets/css/navbar.css">

<div class="scroll-progress" id="scrollProgress"></div>

<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');

$menu_items = [
    'home' => ['label' => 'HOME', 'url' => 'app/views/home.php'],
    'profile' => [
        'label' => 'PROFILE',
        'url' => '#',
        'submenu' => [
            'tentang-lab' => ['label' => 'Tentang Lab', 'url' => 'app/views/tentang_lab.php'],
            'members' => ['label' => 'Members', 'url' => 'app/views/members.php']
        ]
    ],
    'news' => ['label' => 'NEWS & ACTIVITY', 'url' => 'app/views/news.php'],
    'gallery' => ['label' => 'GALLERY', 'url' => 'app/views/gallery.php'],
    'peminjaman-lab' => ['label' => 'PEMINJAMAN LAB', 'url' => 'app/views/peminjaman-lab.php']
];

function isActive($page, $current) { return $page === $current ? 'active' : ''; }

function isParentActive($submenu, $current) {
    foreach ($submenu as $key => $item) {
        if ($key === $current) return 'active';
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
            <span></span><span></span><span></span>
        </div>

        <ul class="nav-menu" id="navMenu">
            <?php foreach ($menu_items as $key => $item): ?>
                <?php if (isset($item['submenu'])): ?>
                    <li class="dropdown">
                        <a href="<?= $item['url']; ?>"
                           class="dropdown-toggle <?= isParentActive($item['submenu'], $current_page); ?>"
                           onclick="toggleDropdown(event)">
                           <?= $item['label']; ?>
                        </a>

                        <ul class="dropdown-menu">
                            <?php foreach ($item['submenu'] as $subkey => $subitem): ?>
                                <li>
                                    <a href="<?= $subitem['url']; ?>"
                                       class="<?= isActive($subkey, $current_page); ?>">
                                       <?= $subitem['label']; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?= $item['url']; ?>" class="<?= isActive($key, $current_page); ?>">
                            <?= $item['label']; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>

        <div class="search-container">
            <div class="search-box" id="searchBox">
                <input type="text" id="searchInput" placeholder="Cari..." onkeyup="handleSearch(event)">
                <button class="search-close" onclick="closeSearch()">&times;</button>
            </div>

            <div class="search-icon" onclick="toggleSearch()"></div>

            <div class="search-results" id="searchResults"></div>
        </div>
    </div>
</nav>

<script>
/* (JS tetap sama) */
</script>
