<link rel="stylesheet" href="/PBL/assets/css/home.css">

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

        <div class="search-box">
            <input type="text" class="search-input" id="searchInput" placeholder="Search...">
            <button class="search-btn" onclick="performSearch()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
            </button>
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
    </div>
</nav>

<script>
function performSearch() {
    const searchInput = document.getElementById('searchInput');
    const query = searchInput.value.trim();
    
    if (query) {
        // Redirect ke halaman search dengan query parameter
        window.location.href = '/PBL/app/views/search.php?q=' + encodeURIComponent(query);
    }
}

// Allow Enter key to trigger search
document.getElementById('searchInput')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        performSearch();
    }
});
</script>