<?php
/**
 * Dynamic About Us Section
 * File: app/profile/views/about.php
 * Data source: profile_lab table (from CMS)
 */

// Default values jika tidak ada data dari CMS
$defaultTitle = 'About Us';
$defaultDescription = 'Laboratorium Business Analyst merupakan sarana pengembangan kompetensi 
mahasiswa di Bidang Teknologi Informasi yang berfokus pada analisis, perancangan, 
dan peningkatan proses bisnis menggunakan data untuk membantu pengambilan 
keputusan yang lebih efektif';
$defaultImage = 'img/maskot.png'; // Default mascot path

// Ambil data dari CMS jika tersedia
$title = isset($aboutUs) && !empty($aboutUs['title']) ? $aboutUs['title'] : $defaultTitle;
$description = isset($aboutUs) && !empty($aboutUs['description']) ? $aboutUs['description'] : $defaultDescription;

// Handle image path
if (isset($aboutUs) && !empty($aboutUs['image'])) {
    // Jika ada image dari database, gunakan path dari uploads
    // Path di database: uploads/profile_lab/filename.jpg
    $imagePath = $base_url . '/assets/' . $aboutUs['image'];
} else {
    // Jika tidak ada, gunakan default mascot
    $imagePath = $base_url . '/assets/' . $defaultImage;
}
?>

<div class="about-container">
    <div class="about-content">
        <div class="mascot-section">
            <img src="<?php echo htmlspecialchars($imagePath); ?>"
                alt="LAB-BA Mascot"
                class="mascot-image"
                onerror="this.onerror=null; this.src='<?php echo $base_url; ?>/assets/img/maskot.png';">
        </div>

        <div class="text-section">
            <h1 class="about-title"><?php echo htmlspecialchars($title); ?></h1>
            <div class="title-underline"></div>
            <p class="about-description">
                <?php echo nl2br(htmlspecialchars($description)); ?>
            </p>
        </div>
    </div>
</div>