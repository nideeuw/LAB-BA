<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Struktur Organisasi - Laboratorium</title>
  <link rel="stylesheet" href="../../../assets/css/gallery.css">
  <link rel="stylesheet" href="../../../assets/css/members.css">
</head>

<body>

  <div class="container">
    <h1>Struktur Organisasi</h1>

    <?php
    // Data Struktur Organisasi 
    $structure = [
      'Kepala Laboratorium' => [
        'name' => 'Dr. Risa Wijaya, M.Kom.',
        'title' => 'Kepala Laboratorium',
        'photo' => 'kepala_lab.jpeg'
      ],
      'Sekretaris' => [
        'name' => 'Santi Dewi, S.T.',
        'title' => 'Sekretaris',
        'photo' => 'sekretaris.jpg'
      ],
      'Bendahara' => [
        'name' => 'Bima Sakti, S.E.',
        'title' => 'Bendahara',
        'photo' => 'bendahara.jpg'
      ],
      'Koordinator' => [
        'Pengembangan Keilmuan' => [
          'name' => 'Fajar Pratama, M.TI.',
          'title' => 'Pengembangan Keilmuan',
          'photo' => 'koor_keilmuan.jpg'
        ],
        'Riset & PkM' => [
          'name' => 'Ayu Lestari, M.Kom.',
          'title' => 'Riset & PkM',
          'photo' => 'koor_riset.jpg'
        ],
        'Kemitraan' => [
          'name' => 'Joko Susilo, M.Kom.',
          'title' => 'Kemitraan',
          'photo' => 'koor_kemitraan.jpg'
        ],
        'Sarana & Prasarana' => [
          'name' => 'Rina Amelia, S.Kom.',
          'title' => 'Sarana & Prasarana',
          'photo' => 'koor_sarana.jpg'
        ],
        'Publikasi' => [
          'name' => 'Adi Nugroho, S.TI.',
          'title' => 'Publikasi',
          'photo' => 'koor_publikasi.jpg'
        ],
        'Pengelolaan Tugas Akhir' => [
          'name' => 'Tika Handayani, M.T.',
          'title' => 'Pengelolaan Tugas Akhir',
          'photo' => 'koor_ta.jpg'
        ]
      ]
    ];
    ?>

    <div class="org-chart">

      <div class="level level-1">
        <div class="org-card boss-card">
          <div class="card-image">
            <?php $img = $structure['Kepala Laboratorium']['photo'];
            $path = "../../../assets/img/" . $img; ?>
            <?php if (!empty($img) && file_exists($path)): ?>
              <img src="<?php echo $path; ?>" alt="<?php echo htmlspecialchars($structure['Kepala Laboratorium']['title']); ?>">
            <?php else: ?>
              <span class="placeholder-icon">👤</span>
            <?php endif; ?>
          </div>
          <div class="card-content">
            <h3 class="card-title"><?php echo htmlspecialchars($structure['Kepala Laboratorium']['title']); ?></h3>
            <p class="card-name"><?php echo htmlspecialchars($structure['Kepala Laboratorium']['name']); ?></p>
          </div>
        </div>
      </div>

      <div class="level level-2">
        <div class="card-group">
          <div class="org-card secretary-card">
            <div class="card-image">
              <?php $img = $structure['Sekretaris']['photo'];
              $path = "../../../assets/img/" . $img; ?>
              <?php if (!empty($img) && file_exists($path)): ?>
                <img src="<?php echo $path; ?>" alt="<?php echo htmlspecialchars($structure['Sekretaris']['title']); ?>">
              <?php else: ?>
                <span class="placeholder-icon">👤</span>
              <?php endif; ?>
            </div>
            <div class="card-content">
              <h3 class="card-title"><?php echo htmlspecialchars($structure['Sekretaris']['title']); ?></h3>
              <p class="card-name"><?php echo htmlspecialchars($structure['Sekretaris']['name']); ?></p>
            </div>
          </div>

          <div class="org-card treasurer-card">
            <div class="card-image">
              <?php $img = $structure['Bendahara']['photo'];
              $path = "../../../assets/img/" . $img; ?>
              <?php if (!empty($img) && file_exists($path)): ?>
                <img src="<?php echo $path; ?>" alt="<?php echo htmlspecialchars($structure['Bendahara']['title']); ?>">
              <?php else: ?>
                <span class="placeholder-icon">👤</span>
              <?php endif; ?>
            </div>
            <div class="card-content">
              <h3 class="card-title"><?php echo htmlspecialchars($structure['Bendahara']['title']); ?></h3>
              <p class="card-name"><?php echo htmlspecialchars($structure['Bendahara']['name']); ?></p>
            </div>
          </div>
        </div>
      </div>

      <div class="level level-3">
        <div class="koordinator-grid">
          <?php foreach ($structure['Koordinator'] as $key => $koor): ?>
            <div class="org-card koor-card">
              <div class="card-image">
                <?php $img = $koor['photo'];
                $path = "../../../assets/img/" . $img; ?>
                <?php if (!empty($img) && file_exists($path)): ?>
                  <img src="<?php echo $path; ?>" alt="<?php echo htmlspecialchars($koor['title']); ?>">
                <?php else: ?>
                  <span class="placeholder-icon">👥</span>
                <?php endif; ?>
              </div>
              <div class="card-content">
                <h3 class="card-title"><?php echo htmlspecialchars($koor['title']); ?></h3>
                <p class="card-name"><?php echo htmlspecialchars($koor['name']); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </div>
</body>

</html>