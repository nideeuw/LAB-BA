<?php

/**
 * Gallery Landing Page - COMPLETE FIXED
 * File: app/profile/views/gallery.php
 */
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_title ?? 'Gallery - Laboratorium Business Analytics'; ?></title>

  <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/landing.css">
  <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/gallery.css">
</head>

<body>
  <?php include __DIR__ . '/layout/navbar.php'; ?>

  <!-- Main Content -->
  <div class="gallery-container">
    <h1 class="gallery-page-title">Gallery</h1>

    <?php if (!empty($galleryItems)): ?>
      <div class="gallery-grid">
        <?php foreach ($galleryItems as $item): ?>
          <div class="gallery-card"
            onclick="openGalleryModal('<?php echo htmlspecialchars($item['image']); ?>', '<?php echo htmlspecialchars($item['title']); ?>')">
            <div class="gallery-card-image">
              <?php if (!empty($item['image'])): ?>
                <img src="<?php echo $base_url; ?>/assets/<?php echo htmlspecialchars($item['image']); ?>"
                  alt="<?php echo htmlspecialchars($item['title']); ?>"
                  onerror="this.src='<?php echo $base_url; ?>/assets/img/default-gallery.jpg'">
              <?php else: ?>
                <span class="gallery-placeholder-icon">🖼️</span>
              <?php endif; ?>
            </div>
            <div class="gallery-card-content">
              <h3 class="gallery-card-title"><?php echo htmlspecialchars($item['title']); ?></h3>
              <?php if (!empty($item['date'])): ?>
                <p class="gallery-card-date"><?php echo date('d F Y', strtotime($item['date'])); ?></p>
              <?php endif; ?>
              <?php if (!empty($item['description'])): ?>
                <p class="gallery-card-description"><?php echo htmlspecialchars($item['description']); ?></p>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="gallery-empty-state">
        <div class="gallery-empty-icon">📷</div>
        <h3>No Photos Yet</h3>
        <p>Check back soon for updates!</p>
      </div>
    <?php endif; ?>
  </div>

  <!-- Modal untuk melihat gambar lebih besar -->
  <div id="galleryImageModal" class="gallery-modal">
    <span class="gallery-modal-close" onclick="closeGalleryModal()">&times;</span>
    <img class="gallery-modal-content" id="galleryModalImage" alt="">
    <div id="galleryModalCaption" class="gallery-modal-caption"></div>
  </div>

  <?php include __DIR__ . '/layout/footer.php'; ?>

  <!-- Gallery Scripts -->
  <script>
    // Fungsi untuk membuka modal
    function openGalleryModal(imageSrc, title) {
      const modal = document.getElementById('galleryImageModal');
      const modalImg = document.getElementById('galleryModalImage');
      const caption = document.getElementById('galleryModalCaption');

      modal.style.display = "block";
      modalImg.src = "<?php echo $base_url; ?>/assets/" + imageSrc;
      caption.innerHTML = title;
    }

    // Fungsi untuk menutup modal
    function closeGalleryModal() {
      document.getElementById('galleryImageModal').style.display = "none";
    }

    // Tutup modal jika klik di luar gambar
    window.onclick = function(event) {
      const modal = document.getElementById('galleryImageModal');
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

    // Tutup modal dengan tombol ESC
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        closeGalleryModal();
      }
    });
  </script>
</body>

</html>