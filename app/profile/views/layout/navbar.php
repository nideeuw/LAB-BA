<?php
/**
 * Navbar Layout for Profile (Landing Page)
 * File: app/profile/views/layout/navbar.php
 * 
 * Variable yang harus tersedia: $base_url
 */

// Get current page from URI
$current_uri = $_SERVER['REQUEST_URI'];
$current_page = basename(parse_url($current_uri, PHP_URL_PATH));

// Menu items dengan routing yang benar
$menu_items = [
    'home' => ['label' => 'HOME', 'url' => $base_url . '/'],
    'profile' => [
        'label' => 'PROFILE',
        'url' => '#',
        'submenu' => [
            'tentang-lab' => ['label' => 'Tentang Lab', 'url' => $base_url . '/tentang-lab'],
            'members' => ['label' => 'Members', 'url' => $base_url . '/members']
        ]
    ],
    'news' => ['label' => 'NEWS & ACTIVITY', 'url' => $base_url . '/news'],
    'gallery' => ['label' => 'GALLERY', 'url' => $base_url . '/gallery'],
    'peminjaman-lab' => ['label' => 'PEMINJAMAN LAB', 'url' => $base_url . '/peminjaman-lab']
];

function isActive($page, $current) { 
    return strpos($current, $page) !== false ? 'active' : ''; 
}

function isParentActive($submenu, $current, $base_url) {
    foreach ($submenu as $key => $item) {
        if (strpos($current, str_replace($base_url, '', $item['url'])) !== false) {
            return 'active';
        }
    }
    return '';
}
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/navbar.css">

<div class="scroll-progress" id="scrollProgress"></div>

<nav class="navbar">
    <div class="nav-container">
        <div class="logo">
            <a href="<?php echo $base_url; ?>/">
                <img src="<?php echo $base_url; ?>/assets/img/logo.png" alt="Logo Lab BA">
            </a>
        </div>

        <div class="hamburger" onclick="toggleMenu()">
            <span></span><span></span><span></span>
        </div>

        <ul class="nav-menu" id="navMenu">
            <?php foreach ($menu_items as $key => $item): ?>
                <?php if (isset($item['submenu'])): ?>
                    <li class="dropdown">
                        <a href="<?php echo $item['url']; ?>"
                           class="dropdown-toggle <?php echo isParentActive($item['submenu'], $current_uri, $base_url); ?>"
                           onclick="toggleDropdown(event)">
                           <?php echo $item['label']; ?>
                        </a>

                        <ul class="dropdown-menu">
                            <?php foreach ($item['submenu'] as $subkey => $subitem): ?>
                                <li>
                                    <a href="<?php echo $subitem['url']; ?>"
                                       class="<?php echo isActive($subkey, $current_uri); ?>">
                                       <?php echo $subitem['label']; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?php echo $item['url']; ?>" 
                           class="<?php echo isActive($key, $current_uri); ?>">
                            <?php echo $item['label']; ?>
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
// Toggle mobile menu
function toggleMenu() {
    const navMenu = document.getElementById('navMenu');
    const hamburger = document.querySelector('.hamburger');
    
    navMenu.classList.toggle('active');
    hamburger.classList.toggle('active');
}

// Toggle dropdown menu
function toggleDropdown(event) {
    event.preventDefault();
    const dropdown = event.target.parentElement;
    dropdown.classList.toggle('active');
}

// Toggle search box
function toggleSearch() {
    const searchBox = document.getElementById('searchBox');
    const searchInput = document.getElementById('searchInput');
    
    searchBox.classList.toggle('active');
    
    if (searchBox.classList.contains('active')) {
        searchInput.focus();
    } else {
        searchInput.value = '';
        document.getElementById('searchResults').innerHTML = '';
    }
}

// Close search box
function closeSearch() {
    document.getElementById('searchBox').classList.remove('active');
    document.getElementById('searchInput').value = '';
    document.getElementById('searchResults').innerHTML = '';
}

// Handle search
function handleSearch(event) {
    const query = event.target.value.toLowerCase();
    const resultsDiv = document.getElementById('searchResults');
    
    if (query.length < 2) {
        resultsDiv.innerHTML = '';
        return;
    }
    
    // Simple search simulation - you can implement actual search here
    const menuItems = <?php echo json_encode($menu_items); ?>;
    let results = [];
    
    for (let key in menuItems) {
        if (menuItems[key].label.toLowerCase().includes(query)) {
            results.push(menuItems[key]);
        }
        
        if (menuItems[key].submenu) {
            for (let subkey in menuItems[key].submenu) {
                if (menuItems[key].submenu[subkey].label.toLowerCase().includes(query)) {
                    results.push(menuItems[key].submenu[subkey]);
                }
            }
        }
    }
    
    if (results.length > 0) {
        let html = '<ul>';
        results.forEach(item => {
            html += `<li><a href="${item.url}">${item.label}</a></li>`;
        });
        html += '</ul>';
        resultsDiv.innerHTML = html;
    } else {
        resultsDiv.innerHTML = '<p>No results found</p>';
    }
}

// Scroll progress indicator
window.addEventListener('scroll', function() {
    const scrollProgress = document.getElementById('scrollProgress');
    const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (window.scrollY / scrollHeight) * 100;
    scrollProgress.style.width = scrolled + '%';
});

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown').forEach(dropdown => {
            dropdown.classList.remove('active');
        });
    }
    
    if (!event.target.closest('.search-container')) {
        closeSearch();
    }
});

// Close mobile menu when clicking menu item
document.querySelectorAll('.nav-menu a').forEach(link => {
    link.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
            toggleMenu();
        }
    });
});
</script>