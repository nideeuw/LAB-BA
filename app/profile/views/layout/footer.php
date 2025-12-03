<?php
/**
 * Footer Layout for Profile (Landing Page)
 * File: app/profile/views/layout/footer.php
 * 
 * Variable yang harus tersedia: $base_url
 */
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/home.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<footer>
    <div class="footer-container">
        <div class="footer-section">
            <h3>Information</h3>
            <ul class="contact-info">
                <li><i class="fas fa-map-marker-alt"></i><span>Jl. Soekarno Hatta Malang</span></li>
                <li><i class="fas fa-phone"></i><span>+62 12 3456 7890</span></li>
                <li><i class="fas fa-envelope"></i><span>laboratoriumBA@polinema.ac.id</span></li>
                <li><i class="fas fa-clock"></i><span>Senin - Jumat: 08.00 - 17.00 WIB</span></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>About</h3>
            <ul class="contact-info">
                <li>
                    <i class="fas fa-flask"></i>
                    <a href="<?php echo $base_url; ?>/" style="color: inherit; text-decoration: none;">
                        <span>Home</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Social Media</h3>
            <div class="social-links">
                <a href="#" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook"></i></a>
                <a href="#" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a>
                <a href="#" target="_blank" rel="noopener noreferrer"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> Laboratorium Bussines Analyst | POLITEKNIK NEGERI MALANG</p>
    </div>
</footer>