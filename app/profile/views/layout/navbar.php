<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAB-BA | Politeknik Negeri Malang</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/landing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    <input type="text" id="searchInput" placeholder="Search..." onkeyup="handleSearch(event)">
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
                    <a href="<?php echo $base_url; ?>/" class="active">HOME</a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" onclick="toggleDropdown(event)">
                        PROFILE
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $base_url; ?>/tentang_lab">Tentang Lab</a></li>
                        <li><a href="<?php echo $base_url; ?>/members">Members</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo $base_url; ?>/gallery">GALLERY</a>
                </li>
                <li>
                    <a href="<?php echo $base_url; ?>/lab_bookings">LAB BOOKINGS</a>
                </li>
                <li>
                    <a href="#footer-section" onclick="scrollToFooter(event)">CONTACT</a>
                </li>
            </ul>
        </div>
    </nav>

    <script>
        function toggleMenu() {
            const navMenu = document.getElementById('navMenu');
            const hamburger = document.querySelector('.hamburger');
            navMenu.classList.toggle('active');
            hamburger.classList.toggle('active');
        }

        function toggleDropdown(event) {
            event.preventDefault();
            const dropdown = event.target.parentElement;
            dropdown.classList.toggle('active');
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

            // Tutup menu mobile jika terbuka
            const navMenu = document.getElementById('navMenu');
            const hamburger = document.querySelector('.hamburger');
            if (navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
                hamburger.classList.remove('active');
            }

            // Scroll smooth ke footer
            const footer = document.getElementById('footer-section');
            if (footer) {
                footer.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        function handleSearch(event) {
            const query = event.target.value.toLowerCase();
            const resultsDiv = document.getElementById('searchResults');

            if (query.length < 2) {
                resultsDiv.innerHTML = '';
                return;
            }

            const menuItems = [{
                    label: 'HOME',
                    url: '<?php echo $base_url; ?>/'
                },
                {
                    label: 'Tentang Lab',
                    url: '<?php echo $base_url; ?>/tentang_lab'
                },
                {
                    label: 'Members',
                    url: '<?php echo $base_url; ?>/members'
                },
                {
                    label: 'GALLERY',
                    url: '<?php echo $base_url; ?>/gallery'
                },
                {
                    label: 'LAB BOOKINGS',
                    url: '<?php echo $base_url; ?>/lab_bookings'
                },
                {
                    label: 'CONTACT',
                    url: '#footer-section',
                    scroll: true
                }
            ];

            let results = menuItems.filter(item => item.label.toLowerCase().includes(query));

            if (results.length > 0) {
                let html = '<ul>';
                results.forEach(item => {
                    if (item.scroll) {
                        html += `<li><a href="${item.url}" onclick="scrollToFooter(event)">${item.label}</a></li>`;
                    } else {
                        html += `<li><a href="${item.url}">${item.label}</a></li>`;
                    }
                });
                html += '</ul>';
                resultsDiv.innerHTML = html;
            } else {
                resultsDiv.innerHTML = '<p>No results found</p>';
            }
        }

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown').forEach(dropdown => {
                    dropdown.classList.remove('active');
                });
            }

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

        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768 && !this.getAttribute('onclick')) {
                    toggleMenu();
                }
            });
        });

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