<?php
require_once __DIR__ . '/../../config/koneksi.php';

// Filter
$filter_riset = $_GET['riset'] ?? 'all';

// Ambil daftar riset
$query_riset = "
    SELECT DISTINCT title 
    FROM researches 
    WHERE is_active = TRUE 
    ORDER BY title
";
$result_riset = pg_query($conn, $query_riset);
$riset_list = $result_riset ? pg_fetch_all($result_riset) : [];

// Query members dengan riset mereka
if ($filter_riset === 'all') {
  $query = "
        SELECT 
            m.id,
            m.nama,
            m.gelar_depan,
            m.gelar_belakang,
            TRIM(CONCAT(
                COALESCE(m.gelar_depan || ' ', ''),
                m.nama,
                COALESCE(', ' || m.gelar_belakang, '')
            )) as nama_lengkap,
            m.image as foto,
            m.jabatan,
            m.is_kepala_lab,
            STRING_AGG(DISTINCT r.title, ', ' ORDER BY r.title) as bidang_riset
        FROM members m
        LEFT JOIN researches r ON m.id = r.id_members AND r.is_active = TRUE
        WHERE m.is_active = TRUE
        GROUP BY m.id, m.nama, m.gelar_depan, m.gelar_belakang, m.image, m.jabatan, m.is_kepala_lab
        ORDER BY m.is_kepala_lab DESC, m.nama ASC
    ";
  $result = pg_query($conn, $query);
} else {
  $query = "
        SELECT 
            m.id,
            m.nama,
            m.gelar_depan,
            m.gelar_belakang,
            TRIM(CONCAT(
                COALESCE(m.gelar_depan || ' ', ''),
                m.nama,
                COALESCE(', ' || m.gelar_belakang, '')
            )) as nama_lengkap,
            m.image as foto,
            m.jabatan,
            m.is_kepala_lab,

            STRING_AGG(DISTINCT r.title, ', ' ORDER BY r.title) as bidang_riset
        FROM members m
        JOIN researches r ON m.id = r.id_members AND r.is_active = TRUE
        WHERE m.is_active = TRUE 
        AND r.title = $1
        GROUP BY m.id, m.nama, m.gelar_depan, m.gelar_belakang, m.image, m.jabatan, m.is_kepala_lab
        ORDER BY m.is_kepala_lab DESC, m.nama ASC
    ";
  $result = pg_query_params($conn, $query, [$filter_riset]);
}

$members = $result ? pg_fetch_all($result) : [];

// Pisahkan kepala lab & anggota
$kepala_lab = null;
$anggota = [];

if ($members) {
  foreach ($members as $m) {
    if ($m['is_kepala_lab'] === 't' || $m['is_kepala_lab'] === true) {
      $kepala_lab = $m;
    } else {
      $anggota[] = $m;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tim Laboratorium</title>
  <link rel="stylesheet" href="../../../assets/css/members.css?v=5">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js" defer></script>
</head>


<!-- Filter -->
<div class="filter-container">
  <div class="filter-wrapper">
    <i data-lucide="filter" class="filter-icon"></i>

    <select id="filterRiset" class="filter-dropdown">
      <option value="all" <?= $filter_riset === 'all' ? 'selected' : '' ?>>Semua Bidang</option>
      <?php if ($riset_list): ?>
        <?php foreach ($riset_list as $r): ?>
          <option value="<?= htmlspecialchars($r['title']) ?>"
            <?= $filter_riset === $r['title'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($r['title']) ?>
          </option>
        <?php endforeach; ?>
      <?php endif; ?>
    </select>

    <svg class="dropdown-icon" data-lucide="chevron-down"></svg>
  </div>
</div>

<script>
  document.getElementById('filterRiset').addEventListener('change', function() {
    window.location = '?riset=' + encodeURIComponent(this.value);
  });
</script>


<!-- Kepala Lab -->
<?php if ($kepala_lab): ?>
  <div class="kepala-lab-section">
    <a href="members_detail.php?id=<?= $kepala_lab['id'] ?>" class="card-kepala">
      <div class="card-kepala-content">
        <div class="card-kepala-photo">
          <?php if ($kepala_lab['foto']): ?>
            <img src="../../../assets/img/<?= htmlspecialchars($kepala_lab['foto']) ?>"
              alt="<?= htmlspecialchars($kepala_lab['nama_lengkap']) ?>"
              onerror="this.src='../../../assets/img/default.jpg'">

          <?php else: ?>
            <img src="../../../assets/img/default.jpg" alt="Default">
          <?php endif; ?>
        </div>

        <div class="card-kepala-info">
          <h3 class="member-name"><?= htmlspecialchars($kepala_lab['nama_lengkap']) ?></h3>
          <?php if ($kepala_lab['jabatan']): ?>
            <p class="member-title"><?= htmlspecialchars($kepala_lab['jabatan']) ?></p>
          <?php endif; ?>
          <?php if ($kepala_lab['bidang_riset']): ?>
            <div class="tags">
              <?php foreach (explode(', ', $kepala_lab['bidang_riset']) as $b): ?>
                <span class="tag"><?= htmlspecialchars($b) ?></span>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </a>
  </div>
<?php endif; ?>

<!-- Anggota -->
<?php if (!empty($anggota)): ?>
  <div class="members-grid">
    <?php foreach ($anggota as $member): ?>
      <a href="members_detail.php?id=<?= $member['id'] ?>" class="card-member">
        <div class="member-photo">
          <?php if ($member['foto']): ?>
            <img src="../../../assets/img/<?= htmlspecialchars($member['foto']) ?>" alt="<?= htmlspecialchars($member['nama_lengkap']) ?>" onerror="this.src='../../../assets/img/default.jpg'">
          <?php else: ?>
            <img src="../../../assets/img/default.jpg" alt="Default">
          <?php endif; ?>

        </div>

        <h3 class="member-name"><?= htmlspecialchars($member['nama_lengkap']) ?></h3>

        <?php if ($member['bidang_riset']): ?>
          <div class="tags">
            <?php foreach (explode(', ', $member['bidang_riset']) as $b): ?>
              <span class="tag"><?= htmlspecialchars($b) ?></span>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </a>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="no-results">
    <p>Tidak ada anggota ditemukan untuk bidang riset ini.</p>
  </div>
<?php endif; ?>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    lucide.createIcons();
  });
</script>
</body>

</html>

<?php pg_close($conn); ?>