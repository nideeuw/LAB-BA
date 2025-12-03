<?php
require_once __DIR__ . '/../../config/koneksi.php';

// Get member ID
$id_member = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_member === 0) {
  header('Location: members.php');
  exit;
}

// ===== DETAIL MEMBER =====
$query = "
    SELECT 
        m.id,
        TRIM(CONCAT(
            COALESCE(m.gelar_depan || ' ', ''),
            m.nama,
            COALESCE(', ' || m.gelar_belakang, '')
        )) AS nama_lengkap,
        m.nama,
        m.gelar_depan,
        m.gelar_belakang,
        m.email,
        m.jabatan,
        m.image AS foto,
        m.sinta_link,
        m.is_kepala_lab
    FROM members m
    WHERE m.id = $1 AND m.is_active = TRUE
";

$result = pg_query_params($conn, $query, [$id_member]);
$member = $result ? pg_fetch_assoc($result) : null;

if (!$member) {
  header('Location: members.php');
  exit;
}

// ===== BIDANG RISET =====
$query_riset = "
    SELECT title
    FROM researches
    WHERE id_members = $1 AND is_active = TRUE
    ORDER BY created_on DESC
";

$result_riset = pg_query_params($conn, $query_riset, [$id_member]);
$bidang_riset = [];

if ($result_riset) {
  while ($row = pg_fetch_assoc($result_riset)) {
    $bidang_riset[] = $row['title'];
  }
}

// ===== SEMUA PUBLIKASI (Diurutkan berdasarkan tahun terbaru) =====
$query_pub = "
    SELECT 
        id,
        title AS judul,
        journal_name,
        year AS tahun,
        journal_link,
        COALESCE(kategori_publikasi, '-') AS kategori
    FROM publications
    WHERE id_members = $1 AND is_active = TRUE
    ORDER BY year DESC, title ASC
";

$result_pub = pg_query_params($conn, $query_pub, [$id_member]);
$publikasi_list = $result_pub ? pg_fetch_all($result_pub) : [];
$total_publikasi = count($publikasi_list);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($member['nama_lengkap']) ?> - Profil</title>

  <!-- CSS Terpisah untuk Detail Member -->
  <link rel="stylesheet" href="../../../assets/css/members_detail.css?v=5">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js" defer></script>
</head>

<body>
  <div class="container detail-container">

    <a href="members.php" class="back-button">
      <i data-lucide="arrow-left"></i> Kembali ke Daftar Anggota
    </a>

    <!-- Banner Profil -->
    <div class="profile-banner">
      <div class="profile-banner-content">

        <!-- Foto -->
        <div class="profile-banner-photo">
          <?php if ($member['foto']): ?>
            <img src="../../../assets/img/<?= htmlspecialchars($member['foto']) ?>"
              alt="<?= htmlspecialchars($member['nama_lengkap']) ?>"
              onerror="this.src='../../../assets/img/default.jpg'">

          <?php else: ?>
            <img src="../../../assets/img/default.jpg" alt="Default">
          <?php endif; ?>
        </div>

        <!-- Info -->
        <div class="profile-banner-info">
          <h2 class="profile-banner-name"><?= htmlspecialchars($member['nama_lengkap']) ?></h2>

          <?php if ($member['jabatan']): ?>
            <p class="profile-banner-jabatan"><?= htmlspecialchars($member['jabatan']) ?></p>
          <?php endif; ?>

          <?php if (!empty($bidang_riset)): ?>
            <div class="profile-banner-riset">
              <?php foreach ($bidang_riset as $riset): ?>
                <span class="riset-tag"><?= htmlspecialchars($riset) ?></span>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>

        <!-- SINTA -->
        <?php if ($member['sinta_link']): ?>
          <div class="profile-banner-action">
            <a href="<?= htmlspecialchars($member['sinta_link']) ?>" target="_blank" class="sinta-btn">
              <i data-lucide="external-link"></i> SINTA Profile
            </a>
          </div>
        <?php endif; ?>

      </div>
    </div>

    <!-- Publikasi -->
    <div class="publications-card">
      <h3 class="publications-title">Publikasi (<?= $total_publikasi ?>)</h3>

      <?php if (!empty($publikasi_list)): ?>
        <div class="publications-table-wrapper">
          <table class="publications-table">
            <thead>
              <tr>
                <th class="col-no">No</th>
                <th class="col-judul">Judul Publikasi</th>
                <th class="col-tahun">Tahun</th>
                <th class="col-kategori">Kategori Publikasi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($publikasi_list as $index => $pub): ?>
                <tr>
                  <td class="col-no"><?= $index + 1 ?></td>
                  <td class="col-judul"><?= htmlspecialchars($pub['judul']) ?></td>
                  <td class="col-tahun"><?= $pub['tahun'] ?></td>
                  <td class="col-kategori">
                    <?php
                    if ($pub['kategori'] && $pub['kategori'] !== '-') {
                      $kategoris = array_map('trim', explode(',', $pub['kategori']));
                      foreach ($kategoris as $kat):
                        if ($kat && $kat !== '-'):
                    ?>
                          <span class="kategori-badge"><?= htmlspecialchars($kat) ?></span>
                    <?php
                        endif;
                      endforeach;
                    } else {
                      echo '<span style="color: #9ca3af;">-</span>';
                    }
                    ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="no-publications">
          <p>Belum ada publikasi</p>
        </div>
      <?php endif; ?>

    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => lucide.createIcons());
  </script>
</body>

</html>

<?php pg_close($conn); ?>