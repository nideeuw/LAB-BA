<?php
$alamat = $contactInfo['alamat'] ?? 'Jl. Soekarno Hatta Malang';
$no_telp = $contactInfo['no_telp'] ?? '+62 12 3456 7890';
$email = $contactInfo['email'] ?? 'laboratoriumBA@polinema.ac.id';
?>

<footer id="footer-section">
    <div class="footer-main">
        <div class="footer-container">
            <!-- Information Section -->
            <div class="footer-section footer-info">
                <div class="footer-logo">
                    <a href="<?php echo $base_url; ?>/">
                        <img src="<?php echo $base_url; ?>/assets/img/logo.png" alt="Lab BA Logo">
                    </a>
                </div>
                <p class="footer-description">
                    Laboratorium Business Analyst - Politeknik Negeri Malang. 
                    Pusat pengembangan kompetensi analisis bisnis dan teknologi informasi.
                </p>
            </div>

            <!-- Contact Information -->
            <div class="footer-section">
                <h3><i class="fas fa-info-circle"></i> Information</h3>
                <ul class="contact-info">
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo htmlspecialchars($alamat); ?></span>
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        <a href="tel:<?php echo str_replace(' ', '', htmlspecialchars($no_telp)); ?>">
                            <?php echo htmlspecialchars($no_telp); ?>
                        </a>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:<?php echo htmlspecialchars($email); ?>">
                            <?php echo htmlspecialchars($email); ?>
                        </a>
                    </li>
                    <li>
                        <i class="fas fa-clock"></i>
                        <span>Senin - Jumat: 08.00 - 17.00 WIB</span>
                    </li>
                </ul>
            </div>

            <!-- Quick Links -->
            <div class="footer-section">
                <h3><i class="fas fa-link"></i> Quick Links</h3>
                <ul class="footer-links">
                    <li>
                        <a href="<?php echo $base_url; ?>/">
                            <i class="fas fa-chevron-right"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url; ?>/members">
                            <i class="fas fa-chevron-right"></i>
                            <span>Members</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url; ?>/gallery">
                            <i class="fas fa-chevron-right"></i>
                            <span>Gallery</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url; ?>/lab_bookings">
                            <i class="fas fa-chevron-right"></i>
                            <span>Lab Bookings</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Resources -->
            <div class="footer-section">
                <h3><i class="fas fa-book"></i> Resources</h3>
                <ul class="footer-links">
                    <li>
                        <a href="#about" onclick="scrollToSection(event, 'about')">
                            <i class="fas fa-chevron-right"></i>
                            <span>About Us</span>
                        </a>
                    </li>
                    <li>
                        <a href="#research-focus" onclick="scrollToSection(event, 'research-focus')">
                            <i class="fas fa-chevron-right"></i>
                            <span>Research Focus</span>
                        </a>
                    </li>
                    <li>
                        <a href="#roadmap" onclick="scrollToSection(event, 'roadmap')">
                            <i class="fas fa-chevron-right"></i>
                            <span>Roadmap</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://polinema.ac.id" target="_blank" rel="noopener">
                            <i class="fas fa-chevron-right"></i>
                            <span>Polinema Website</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-bottom-content">
            <p>&copy; <?php echo date('Y'); ?> Laboratorium Business Analyst | POLITEKNIK NEGERI MALANG</p>
            <p class="footer-tagline">
                <i class="fas fa-heart"></i> Empowering Future Business Analysts
            </p>
        </div>
    </div>
</footer>

<button class="scroll-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
    <i class="fas fa-arrow-up"></i>
</button>

<script>
function scrollToSection(e, sectionId) {
    e.preventDefault();
    
    // Cek apakah di halaman home
    if (window.location.pathname.includes('index.php') || window.location.pathname.endsWith('/') || window.location.pathname.endsWith('/LAB-BA') || window.location.pathname.endsWith('/LAB-BA/')) {
        const target = document.getElementById(sectionId);
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    } else {
        // Redirect ke home dengan hash
        window.location.href = '<?php echo $base_url; ?>/#' + sectionId;
    }
}
</script>

</body>
</html>