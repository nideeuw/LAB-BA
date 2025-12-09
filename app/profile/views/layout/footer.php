<?php

/**
 * Footer with Dynamic Contact Info
 * File: app/profile/views/layout/footer.php
 */

// Get active contact info from database
$contactInfo = null;
if (isset($conn)) {
    $contactInfo = ContactModel::getActiveContact($conn);
}

// Default values if no contact found
$alamat = $contactInfo['alamat'] ?? 'Jl. Soekarno Hatta Malang';
$no_telp = $contactInfo['no_telp'] ?? '+62 12 3456 7890';
$email = $contactInfo['email'] ?? 'laboratoriumBA@polinema.ac.id';
?>

<footer>
    <div class="footer-container">
        <div class="footer-section">
            <h3>Information</h3>
            <ul class="contact-info">
                <li>
                    <i class="fas fa-map-marker-alt"></i>
                    <span><?php echo htmlspecialchars($alamat); ?></span>
                </li>
                <li>
                    <i class="fas fa-phone"></i>
                    <span><?php echo htmlspecialchars($no_telp); ?></span>
                </li>
                <li>
                    <i class="fas fa-envelope"></i>
                    <span><?php echo htmlspecialchars($email); ?></span>
                </li>
                <li>
                    <i class="fas fa-clock"></i>
                    <span>Senin - Jumat: 08.00 - 17.00 WIB</span>
                </li>
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
                <li>
                    <i class="fas fa-info-circle"></i>
                    <a href="<?php echo $base_url; ?>/tentang-lab" style="color: inherit; text-decoration: none;">
                        <span>Tentang Lab</span>
                    </a>
                </li>
                <li>
                    <i class="fas fa-users"></i>
                    <a href="<?php echo $base_url; ?>/members" style="color: inherit; text-decoration: none;">
                        <span>Members</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Social Media</h3>
            <div class="social-links">
                <a href="#" target="_blank" rel="noopener noreferrer" title="Facebook">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="#" target="_blank" rel="noopener noreferrer" title="YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="#" target="_blank" rel="noopener noreferrer" title="WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="#" target="_blank" rel="noopener noreferrer" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> Laboratorium Business Analyst | POLITEKNIK NEGERI MALANG</p>
    </div>
</footer>

<div class="scroll-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})"></div>

</body>

</html>