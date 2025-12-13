<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <?php if (!empty($bannerItems)): ?>
            <?php foreach ($bannerItems as $index => $banner): ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <img class="d-block w-100"
                        src="<?php echo $base_url; ?>/assets/<?php echo htmlspecialchars($banner['image']); ?>"
                        alt="<?php echo htmlspecialchars($banner['title'] ?? 'Banner ' . ($index + 1)); ?>"
                        onerror="this.src='<?php echo $base_url; ?>/assets/img/default-banner.jpg'">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Default banners jika database kosong -->
            <div class="carousel-item active">
                <img class="d-block w-100" src="<?php echo $base_url; ?>/assets/img/images_1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="<?php echo $base_url; ?>/assets/img/images_2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="<?php echo $base_url; ?>/assets/img/images_3.jpg" alt="Third slide">
            </div>
        <?php endif; ?>
    </div>

    <!-- Carousel Controls -->
    <button class="carousel-control-prev" type="button" onclick="prevSlide()">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" onclick="nextSlide()">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>

    <!-- Carousel Indicators -->
    <div class="carousel-indicators">
        <?php 
        $itemCount = !empty($bannerItems) ? count($bannerItems) : 3;
        for ($i = 0; $i < $itemCount; $i++): 
        ?>
            <button type="button" 
                    class="<?php echo $i === 0 ? 'active' : ''; ?>" 
                    aria-current="<?php echo $i === 0 ? 'true' : 'false'; ?>" 
                    aria-label="Slide <?php echo $i + 1; ?>"
                    onclick="goToSlide(<?php echo $i; ?>)"></button>
        <?php endfor; ?>
    </div>

    <!-- Hero Overlay with Content -->
    <div class="hero-overlay">
        <!-- Floating Particles -->
        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>

        <!-- Main Hero Content -->
        <div class="hero-content">
            <h1 class="hero-title">Welcome to Laboratorium Business Analytics</h1>
            <p class="hero-subtitle">Empowering Future Business Analysts Through Innovation & Excellence</p>
            
            <div class="hero-cta">
                <a href="#about" class="cta-button cta-primary" onclick="scrollToSection(event, 'about')">
                    <span>Explore More</span>
                    <i class="fas fa-arrow-down"></i>
                </a>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="scroll-indicator" onclick="scrollToSection(event, 'about')">
            <div class="scroll-line"></div>
            <i class="fas fa-chevron-down"></i>
        </div>
    </div>

    <!-- Modern Divider -->
    <div class="modern-divider">
        <div class="divider-shape shape-1"></div>
        <div class="divider-shape shape-2"></div>
        <div class="divider-shape shape-3"></div>
    </div>
</div>

<script>
    // Page Loader
    window.addEventListener('load', function() {
        setTimeout(() => {
            const loader = document.querySelector('.page-loader');
            if (loader) {
                loader.classList.add('hidden');
            }
        }, 800);
    });

    // Smooth scroll to section
    function scrollToSection(event, sectionId) {
        event.preventDefault();
        const section = document.getElementById(sectionId);
        if (section) {
            section.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    // Carousel Manual Controls
    let currentIndex = 0;
    const slides = document.querySelectorAll('.carousel-item');
    const indicators = document.querySelectorAll('.carousel-indicators button');

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove('active');
            if (indicators[i]) {
                indicators[i].classList.remove('active');
            }
        });
        
        if (slides[index]) {
            slides[index].classList.add('active');
            if (indicators[index]) {
                indicators[index].classList.add('active');
            }
        }
        currentIndex = index;
    }

    function nextSlide() {
        let newIndex = (currentIndex + 1) % slides.length;
        showSlide(newIndex);
    }

    function prevSlide() {
        let newIndex = (currentIndex - 1 + slides.length) % slides.length;
        showSlide(newIndex);
    }

    function goToSlide(index) {
        showSlide(index);
    }

    // Auto slide every 5 seconds
    if (slides.length > 1) {
        setInterval(() => {
            nextSlide();
        }, 5000);
    }

    // Navbar Scroll Effect
    let lastScroll = 0;
    window.addEventListener('scroll', () => {
        const navbar = document.querySelector('.navbar');
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > 100) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        lastScroll = scrollTop;
    });

    // Fade in sections on scroll
    const fadeInObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    // Observe all fade-in sections
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.fade-in-section').forEach(section => {
            fadeInObserver.observe(section);
        });
    });

    // Scroll to Top Button
    const scrollTopBtn = document.querySelector('.scroll-to-top');
    
    window.addEventListener('scroll', () => {
        if (scrollTopBtn) {
            if (window.pageYOffset > 500) {
                scrollTopBtn.classList.add('show');
            } else {
                scrollTopBtn.classList.remove('show');
            }
        }
    });

    if (scrollTopBtn) {
        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Smooth scroll for all anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href !== '#footer-section') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Parallax effect for hero images
    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const scrolled = window.pageYOffset;
                const parallaxElements = document.querySelectorAll('.carousel-item.active img');
                
                parallaxElements.forEach(element => {
                    const speed = 0.5;
                    const yPos = -(scrolled * speed);
                    element.style.transform = `translateY(${yPos}px) scale(1.1)`;
                });
                
                ticking = false;
            });
            ticking = true;
        }
    });
</script>