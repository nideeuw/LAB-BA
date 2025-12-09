<?php
/**
 * Members List View - SIMPLIFIED for assets/uploads/members/
 * File: app/profile/views/members.php
 */

include __DIR__ . '/layout/navbar.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Tim Laboratorium'; ?></title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/members.css?v=5">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js" defer></script>
</head>

<body>
    <div class="container">

        <!-- Filter -->
        <div class="filter-container">
            <div class="filter-wrapper">
                <i data-lucide="filter" class="filter-icon"></i>

                <select id="filterRiset" class="filter-dropdown">
                    <option value="all" <?php echo (isset($filter_riset) && $filter_riset === 'all') ? 'selected' : ''; ?>>Semua Bidang</option>
                    <?php if (isset($riset_list) && !empty($riset_list)): ?>
                        <?php foreach ($riset_list as $r): ?>
                            <option value="<?php echo htmlspecialchars($r['title']); ?>"
                                <?php echo (isset($filter_riset) && $filter_riset === $r['title']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($r['title']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <svg class="dropdown-icon" data-lucide="chevron-down"></svg>
            </div>
        </div>

        <script>
            document.getElementById('filterRiset').addEventListener('change', function() {
                window.location = '<?php echo $base_url; ?>/members?riset=' + encodeURIComponent(this.value);
            });
        </script>

        <!-- Kepala Lab -->
        <?php if (isset($kepala_lab) && $kepala_lab): ?>
            <div class="kepala-lab-section">
                <a href="<?php echo $base_url; ?>/members/detail/<?php echo $kepala_lab['id']; ?>" class="card-kepala">
                    <div class="card-kepala-content">
                        <div class="card-kepala-photo">
                            <?php
                            $fotoPath = !empty($kepala_lab['foto']) ? $kepala_lab['foto'] : 'img/default.jpg';
                            ?>
                            <img src="<?php echo $base_url; ?>/assets/<?php echo htmlspecialchars($fotoPath); ?>"
                                alt="<?php echo htmlspecialchars($kepala_lab['nama_lengkap']); ?>"
                                onerror="this.src='<?php echo $base_url; ?>/assets/img/default.jpg'">
                        </div>

                        <div class="card-kepala-info">
                            <h3 class="member-name"><?php echo htmlspecialchars($kepala_lab['nama_lengkap']); ?></h3>
                            <?php if (!empty($kepala_lab['jabatan'])): ?>
                                <p class="member-title"><?php echo htmlspecialchars($kepala_lab['jabatan']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($kepala_lab['bidang_riset'])): ?>
                                <div class="tags">
                                    <?php foreach (explode(', ', $kepala_lab['bidang_riset']) as $b): ?>
                                        <span class="tag"><?php echo htmlspecialchars($b); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        <!-- Anggota -->
        <?php if (isset($anggota) && !empty($anggota)): ?>
            <div class="members-grid">
                <?php foreach ($anggota as $member): ?>
                    <a href="<?php echo $base_url; ?>/members/detail/<?php echo $member['id']; ?>" class="card-member">
                        <div class="member-photo">
                            <?php
                            $fotoPath = !empty($member['foto']) ? $member['foto'] : 'img/default.jpg';
                            ?>
                            <img src="<?php echo $base_url; ?>/assets/<?php echo htmlspecialchars($fotoPath); ?>"
                                alt="<?php echo htmlspecialchars($member['nama_lengkap']); ?>"
                                onerror="this.src='<?php echo $base_url; ?>/assets/img/default.jpg'">
                        </div>

                        <h3 class="member-name"><?php echo htmlspecialchars($member['nama_lengkap']); ?></h3>

                        <?php if (!empty($member['bidang_riset'])): ?>
                            <div class="tags">
                                <?php foreach (explode(', ', $member['bidang_riset']) as $b): ?>
                                    <span class="tag"><?php echo htmlspecialchars($b); ?></span>
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

    <?php include __DIR__ . '/layout/footer.php'; ?>

</body>

</html>