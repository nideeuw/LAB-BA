<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAB-BA | Politeknik Negeri Malang</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/landing.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <a href="<?php echo $base_url; ?>/">
                    <img src="<?php echo $base_url; ?>/assets/img/logo.png" alt="Logo Lab BA">
                </a>
            </div>

            <div class="search-container">
                <button class="search-icon" onclick="toggleSearch()">
                    <i class="fas fa-search"></i>
                </button>

                <div class="search-box" id="searchBox">
                    <input type="text" id="searchInput" placeholder="Search all content..." onkeyup="handleSearch(event)">
                    <button class="search-close" onclick="closeSearch()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="search-results" id="searchResults"></div>
            </div>

            <div class="hamburger" onclick="toggleMenu()">
                <span></span><span></span><span></span>
            </div>

            <ul class="nav-menu" id="navMenu">
                <li>
                    <a href="<?php echo $base_url; ?>/"
                        class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' || $_SERVER['REQUEST_URI'] == $base_url . '/') ? 'active' : ''; ?>">
                        HOME
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url; ?>/members"
                        class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/members') !== false) ? 'active' : ''; ?>">
                        MEMBERS
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url; ?>/gallery"
                        class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/gallery') !== false) ? 'active' : ''; ?>">
                        GALLERY
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url; ?>/lab_bookings"
                        class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/lab_bookings') !== false) ? 'active' : ''; ?>">
                        LAB BOOKINGS
                    </a>
                </li>
                <li>
                    <a href="#footer-section" onclick="scrollToFooter(event)">CONTACT</a>
                </li>
            </ul>
        </div>
    </nav>

    <script>
        // Search timeout untuk debouncing
        let searchTimeout = null;

        function toggleMenu() {
            const navMenu = document.getElementById('navMenu');
            const hamburger = document.querySelector('.hamburger');
            navMenu.classList.toggle('active');
            hamburger.classList.toggle('active');
        }

        function toggleSearch() {
            const searchBox = document.getElementById('searchBox');
            const searchInput = document.getElementById('searchInput');
            const searchIcon = document.querySelector('.search-icon');

            searchBox.classList.toggle('active');
            searchIcon.classList.toggle('active');

            if (searchBox.classList.contains('active')) {
                setTimeout(() => {
                    searchInput.focus();
                }, 300);
            } else {
                searchInput.value = '';
                document.getElementById('searchResults').innerHTML = '';
            }
        }

        function closeSearch() {
            const searchBox = document.getElementById('searchBox');
            const searchIcon = document.querySelector('.search-icon');

            searchBox.classList.remove('active');
            searchIcon.classList.remove('active');
            document.getElementById('searchInput').value = '';
            document.getElementById('searchResults').innerHTML = '';
        }

        function scrollToFooter(event) {
            event.preventDefault();

            // Close mobile menu if open
            const navMenu = document.getElementById('navMenu');
            const hamburger = document.querySelector('.hamburger');
            if (navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
                hamburger.classList.remove('active');
            }

            // Smooth scroll to footer
            const footer = document.getElementById('footer-section');
            if (footer) {
                footer.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        function handleSearch(event) {
            const query = event.target.value.trim();
            const resultsDiv = document.getElementById('searchResults');

            // Clear previous timeout
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }

            if (query.length < 2) {
                resultsDiv.innerHTML = '';
                return;
            }

            // Show loading
            resultsDiv.innerHTML = '<p style="padding: 1rem; text-align: center;"><i class="fas fa-spinner fa-spin"></i> Searching...</p>';

            // Debounce search - wait 500ms after user stops typing
            searchTimeout = setTimeout(() => {
                performSearch(query);
            }, 500);
        }

        function performSearch(query) {
            const resultsDiv = document.getElementById('searchResults');
            const baseUrl = '<?php echo $base_url; ?>';

            fetch(`${baseUrl}/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.results.length > 0) {
                        let html = '<ul>';

                        data.results.forEach(item => {
                            html += `
                        <li>
                            <a href="${baseUrl}${item.url}" onclick="closeSearch()">
                                <i class="${item.icon}"></i>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #0F3057; margin-bottom: 3px;">
                                        ${highlightText(item.title, query)}
                                    </div>
                                    <div style="font-size: 0.85rem; color: #666;">
                                        <span style="color: #1e88e5; font-weight: 500;">${item.type}</span>
                                        ${item.preview ? ' - ' + highlightText(item.preview, query) : ''}
                                    </div>
                                </div>
                            </a>
                        </li>
                    `;
                        });

                        html += '</ul>';
                        html += `<div style="padding: 0.75rem; text-align: center; border-top: 1px solid #e0e0e0; font-size: 0.85rem; color: #666;">
                    Found ${data.count} result${data.count > 1 ? 's' : ''}
                </div>`;

                        resultsDiv.innerHTML = html;
                    } else {
                        resultsDiv.innerHTML = '<p style="padding: 1rem; text-align: center; color: #666;"><i class="fas fa-search"></i> No results found for "' + escapeHtml(query) + '"</p>';
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                    resultsDiv.innerHTML = '<p style="padding: 1rem; text-align: center; color: #d32f2f;"><i class="fas fa-exclamation-circle"></i> Search error. Please try again.</p>';
                });
        }

        function highlightText(text, query) {
            if (!text || !query) return text;

            const regex = new RegExp(`(${escapeRegex(query)})`, 'gi');
            return text.replace(regex, '<mark style="background: #fff9c4; padding: 2px 4px; border-radius: 2px; font-weight: 600;">$1</mark>');
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function escapeRegex(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        // Close search when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.search-container')) {
                const searchBox = document.getElementById('searchBox');
                const searchIcon = document.querySelector('.search-icon');
                if (searchBox && searchBox.classList.contains('active')) {
                    searchBox.classList.remove('active');
                    searchIcon.classList.remove('active');
                    document.getElementById('searchInput').value = '';
                    document.getElementById('searchResults').innerHTML = '';
                }
            }
        });

        // Close mobile menu when clicking on links
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768 && !this.getAttribute('onclick')) {
                    toggleMenu();
                }
            });
        });

        // Scroll to top button visibility
        window.addEventListener('scroll', function() {
            const scrollBtn = document.querySelector('.scroll-to-top');
            if (scrollBtn) {
                if (window.scrollY > 300) {
                    scrollBtn.classList.add('show');
                } else {
                    scrollBtn.classList.remove('show');
                }
            }
        });
    </script>