<?php
/**
 * Halaman Tentang Lab (Visi, Misi & Roadmap)
 * File: app/profile/views/tentang_lab.php
 */

// Base URL KHUSUS laragon + nama folder project kamu
$base_url = "http://localhost/LAB-BA";

// Include navbar
include __DIR__ . '/layout/navbar.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Lab | Laboratorium Business Analytics</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/tentang_lab.css?v=1">
</head>

<body>
    <!-- ===================== VISI & MISI ===================== -->
    <section class="visi-misi-section">
        <div class="container-vm">

            <div class="visi-misi-wrapper">
                <div class="vm-inner-container">

                    <!-- VISI -->
                    <div class="vm-box">
                        <h2 class="section-title">VISI</h2>
                        <div class="box-content">
                            <p>
                                Menjadi laboratorium unggul rujukan nasional sebagai inkubator solusi cerdas berbasis data,
                                yang berfungsi sebagai mitra strategis industri untuk mengakselerasi transformasi bisnis dan
                                pengambilan keputusan yang berdampak.
                            </p>
                        </div>
                    </div>

                    <!-- MISI -->
                    <div class="vm-box">
                        <h2 class="section-title">MISI</h2>
                        <div class="box-content">
                            <ol>
                                <li>Mengembangkan riset terapan berbasis kebutuhan industri dan masyarakat.</li>
                                <li>Mengintegrasikan berbagai disiplin ilmu dalam solusi berbasis data.</li>
                                <li>Membangun kemitraan strategis dengan berbagai sektor industri.</li>
                                <li>Mengembangkan talenta dosen dan mahasiswa di bidang analitik bisnis.</li>
                                <li>Menjalankan tata kelola laboratorium yang profesional, etis, dan berkelanjutan.</li>
                            </ol>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- ===================== SEPARATOR ===================== -->
    <div class="section-separator"></div>

    <!-- ===================== ROADMAP ===================== -->
    <section class="roadmap-section">

        <div class="roadmap-header">
            <h2>ROADMAP</h2>
        </div>

        <div class="roadmap-container">

            <div class="roadmap-card">
                <h3>Jangka Pendek (1–5 Tahun)</h3>
                <p><strong>Kualitas lulusan:</strong> Penguatan praktikum end-to-end (data → model → insight → aksi).</p>
                <p><strong>Ilmu:</strong> Fondasi riset terapan & repositori yang dapat diuji ulang.</p>
                <p><strong>Masy/Industri:</strong> Studi kasus awal & pendampingan ringan.</p>
            </div>

            <div class="roadmap-card">
                <h3>Jangka Menengah (6–10 Tahun)</h3>
                <p><strong>Kualitas lulusan:</strong> Konsistensi asesmen & sertifikasi; proyek lintas mata kuliah.</p>
                <p><strong>Ilmu:</strong> Pembentukan klaster riset & dataset rujukan.</p>
                <p><strong>Masy/Industri:</strong> Kemitraan multi-tahun & magang terstruktur.</p>
            </div>

            <div class="roadmap-card">
                <h3>Jangka Panjang (&gt;10 Tahun)</h3>
                <p><strong>Kualitas lulusan:</strong> Pengakuan nasional hingga internasional.</p>
                <p><strong>Ilmu:</strong> Pusat keunggulan & kurasi data tematik regional.</p>
                <p><strong>Masy/Industri:</strong> Layanan solusi siap pakai & konsultasi keputusan berbasis data.</p>
            </div>

        </div>

    </section>

    <?php include __DIR__ . '/layout/footer.php'; ?>

</body>
</html>
