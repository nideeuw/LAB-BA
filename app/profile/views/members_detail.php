<?php

include __DIR__ . '/layout/navbar.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($member['nama_lengkap']) ? htmlspecialchars($member['nama_lengkap']) . ' - Profil' : 'Member Profile'; ?></title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/members_detail.css?v=7">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js" defer></script>
</head>

<body>
    <?php if (isset($member) && $member): ?>
        <div class="container detail-container">

            <a href="<?php echo $base_url; ?>/members" class="back-button">
                <i data-lucide="arrow-left"></i> Kembali ke Daftar Anggota
            </a>

            <!-- Banner Profil -->
            <div class="profile-banner">
                <div class="profile-banner-content">

                    <!-- Foto -->
                    <div class="profile-banner-photo">
                        <?php
                        $fotoPath = !empty($member['foto']) ? $member['foto'] : 'img/default.jpg';
                        ?>
                        <img src="<?php echo $base_url; ?>/assets/<?php echo htmlspecialchars($fotoPath); ?>"
                            alt="<?php echo htmlspecialchars($member['nama_lengkap']); ?>"
                            onerror="this.src='<?php echo $base_url; ?>/assets/img/default.jpg'">
                    </div>

                    <!-- Info -->
                    <div class="profile-banner-info">
                        <h2 class="profile-banner-name"><?php echo htmlspecialchars($member['nama_lengkap']); ?></h2>

                        <?php if (!empty($member['jabatan'])): ?>
                            <p class="profile-banner-jabatan"><?php echo htmlspecialchars($member['jabatan']); ?></p>
                        <?php endif; ?>

                        <?php if (isset($bidang_riset) && !empty($bidang_riset)): ?>
                            <div class="profile-banner-riset">
                                <?php foreach ($bidang_riset as $riset): ?>
                                    <span class="riset-tag"><?php echo htmlspecialchars($riset); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- SINTA -->
                    <?php if (!empty($member['sinta_link'])): ?>
                        <div class="profile-banner-action">
                            <a href="<?php echo htmlspecialchars($member['sinta_link']); ?>" target="_blank" class="sinta-btn">
                                <i data-lucide="external-link"></i> SINTA Profile
                            </a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Publikasi -->
            <div class="publications-card">
                <div class="publications-header">
                    <h3 class="publications-title">Publikasi</h3>
                    <?php if (isset($total_publikasi) && $total_publikasi > 0): ?>
                        <span class="publications-count"><?php echo $total_publikasi; ?> publikasi</span>
                    <?php endif; ?>
                </div>

                <?php if (isset($publikasi_list) && !empty($publikasi_list)): ?>
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
                                <?php
                                $startNumber = isset($page) && isset($pageSize) ? (($page - 1) * $pageSize + 1) : 1;
                                foreach ($publikasi_list as $index => $pub):
                                ?>
                                    <tr>
                                        <td class="col-no"><?php echo $startNumber + $index; ?></td>
                                        <td class="col-judul">
                                            <?php if (!empty($pub['journal_link'])): ?>
                                                <a href="<?php echo htmlspecialchars($pub['journal_link']); ?>"
                                                    target="_blank"
                                                    class="publication-link">
                                                    <?php echo !empty($pub['judul']) ? htmlspecialchars($pub['judul']) : '-'; ?>
                                                    <i data-lucide="external-link" class="link-icon"></i>
                                                </a>
                                            <?php else: ?>
                                                <?php echo !empty($pub['judul']) ? htmlspecialchars($pub['judul']) : '-'; ?>
                                            <?php endif; ?>

                                            <?php if (!empty($pub['journal_name'])): ?>
                                                <div class="journal-name">
                                                    <i data-lucide="book-open" class="journal-icon"></i>
                                                    <?php echo htmlspecialchars($pub['journal_name']); ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="col-tahun">
                                            <?php echo !empty($pub['tahun']) ? htmlspecialchars((string)$pub['tahun']) : '-'; ?>
                                        </td>
                                        <td class="col-kategori">
                                            <?php
                                            if (!empty($pub['kategori']) && $pub['kategori'] !== '-') {
                                                $kategoris = array_map('trim', explode(',', $pub['kategori']));
                                                foreach ($kategoris as $kat):
                                                    if ($kat && $kat !== '-'):
                                            ?>
                                                        <span class="kategori-badge"><?php echo htmlspecialchars($kat); ?></span>
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

                    <?php if (isset($totalPages) && $totalPages > 1): ?>
                        <div class="pagination-container">
                            <div class="pagination-info">
                                Menampilkan <?php echo $startNumber; ?>-<?php echo min($startNumber + count($publikasi_list) - 1, $total_publikasi); ?>
                                dari <?php echo $total_publikasi; ?> publikasi
                            </div>

                            <div class="pagination">
                                <?php if ($page > 1): ?>
                                    <a href="?page=<?php echo $page - 1; ?>" class="pagination-btn">
                                        <i data-lucide="chevron-left"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="pagination-btn disabled">
                                        <i data-lucide="chevron-left"></i>
                                    </span>
                                <?php endif; ?>

                                <?php
                                $startPage = max(1, $page - 2);
                                $endPage = min($totalPages, $page + 2);

                                if ($startPage > 1): ?>
                                    <a href="?page=1" class="pagination-number">1</a>
                                    <?php if ($startPage > 2): ?>
                                        <span class="pagination-dots">...</span>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                    <?php if ($i == $page): ?>
                                        <span class="pagination-number active"><?php echo $i; ?></span>
                                    <?php else: ?>
                                        <a href="?page=<?php echo $i; ?>" class="pagination-number"><?php echo $i; ?></a>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <?php if ($endPage < $totalPages): ?>
                                    <?php if ($endPage < $totalPages - 1): ?>
                                        <span class="pagination-dots">...</span>
                                    <?php endif; ?>
                                    <a href="?page=<?php echo $totalPages; ?>" class="pagination-number"><?php echo $totalPages; ?></a>
                                <?php endif; ?>

                                <?php if ($page < $totalPages): ?>
                                    <a href="?page=<?php echo $page + 1; ?>" class="pagination-btn">
                                        <i data-lucide="chevron-right"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="pagination-btn disabled">
                                        <i data-lucide="chevron-right"></i>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="no-publications">
                        <i data-lucide="file-text"></i>
                        <p>Belum ada publikasi</p>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    <?php else: ?>
        <div class="container">
            <div class="alert alert-danger">
                <h4>Member tidak ditemukan</h4>
                <p><a href="<?php echo $base_url; ?>/members">Kembali ke daftar members</a></p>
            </div>
        </div>
    <?php endif; ?>

    <script>
        document.addEventListener("DOMContentLoaded", () => lucide.createIcons());
    </script>

    <?php include __DIR__ . '/layout/footer.php'; ?>

</body>

</html>