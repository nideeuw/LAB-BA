<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gallery - Laboratorium Business Analytics</title>
  <link rel="stylesheet" href="/PBL/assets/css/gallery.css">
</head>

<body>
<?php include __DIR__ . '/layout/navbar.php'; ?>
  <!-- Main Content -->
  <div class="container">
    <h1>Gallery</h1>

    <?php
    // Data gallery 
    $galleryItems = [
      [
        'title' => 'Workshop Data Science Pemula',
        'date' => '15 Juni 2024',
        'description' => '',
        'image' => 'gallery1.jpg'
      ],
      [
        'title' => 'Kunjungan Industri ke Tech Startup',
        'date' => '12 Juli 2024',
        'description' => 'Hasil riset tentang kebutuhan bagi industri',
        'image' => 'gallery2.jpg'
      ],
      [
        'title' => 'Workshop Data Science Pemula',
        'date' => '20 Agustus 2024',
        'description' => '',
        'image' => 'gallery3.jpg'
      ],
      [
        'title' => 'Kunjungan Industri ke Tech Startup',
        'date' => '12 Juli 2024',
        'description' => 'Hasil riset tentang kebutuhan bagi industri',
        'image' => 'gallery2.jpg'
      ],
      [
        'title' => 'Workshop Data Science Pemula',
        'date' => '20 Agustus 2024',
        'description' => '',
        'image' => 'gallery3.jpg'
      ]

    ];

    ?>

    <div class="gallery-grid">
      <?php foreach ($galleryItems as $item): ?>
        <div class="gallery-card" onclick="openModal('<?php echo htmlspecialchars($item['image']); ?>', '<?php echo htmlspecialchars($item['title']); ?>')">
          <div class="card-image">
            <?php
            $imagePath = "../../../assets/img/" . $item['image'];
            if (!empty($item['image']) && file_exists($imagePath)):
            ?>
              <img src="<?php echo $imagePath; ?>"
                alt="<?php echo htmlspecialchars($item['title']); ?>">
            <?php else: ?>
              <span class="placeholder-icon">🖼</span>
            <?php endif; ?>
          </div>
          <div class="card-content">
            <h3 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h3>
            <p class="card-date"><?php echo htmlspecialchars($item['date']); ?></p>
            <?php if (!empty($item['description'])): ?>
              <p class="card-description"><?php echo htmlspecialchars($item['description']); ?></p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Modal untuk melihat gambar lebih besar -->
  <div id="imageModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImage">
    <div id="caption"></div>
  </div>

  <script>
    // Fungsi untuk membuka modal
    function openModal(imageSrc, title) {
      const modal = document.getElementById('imageModal');
      const modalImg = document.getElementById('modalImage');
      const caption = document.getElementById('caption');

      modal.style.display = "block";
      modalImg.src = "../../../assets/img/" + imageSrc;
      caption.innerHTML = title;
    }

    // Fungsi untuk menutup modal
    function closeModal() {
      document.getElementById('imageModal').style.display = "none";
    }

    // Tutup modal jika klik di luar gambar
    window.onclick = function(event) {
      const modal = document.getElementById('imageModal');
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

    // Tutup modal dengan tombol ESC
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        closeModal();
      }
    });
  </script>
</body>
<?php 
include __DIR__ . '/layout/footer.php'; 
?>
</html>