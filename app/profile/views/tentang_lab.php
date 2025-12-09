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

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/tentang_lab.css?v=3">
</head>


<body>
    <section class="visi-misi-section">
        <div class="container-vm">

            <div class="visi-misi-wrapper">
                <div class="vm-inner-container">

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

    <div class="section-separator"></div>

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
                <h3>Jangka Panjang (>10 Tahun)</h3>
                <p><strong>Kualitas lulusan:</strong> Pengakuan nasional hingga internasional.</p>
                <p><strong>Ilmu:</strong> Pusat keunggulan & kurasi data tematik regional.</p>
                <p><strong>Masy/Industri:</strong> Layanan solusi siap pakai & konsultasi keputusan berbasis data.</p>
            </div>

        </div>

    </section>

    <div class="wrapper-box">
        <div class="inner-box" style="text-align:center;">
            <h2 class="section-title">Lingkup Penelitian</h2>
            <img src="<?= $base_url; ?>/assets/img/Lingkup_Penelitian.png" 
                alt="Lingkup Penelitian" 
                style="width:100%; max-width:1000px; margin-top:20px; border-radius:12px;">
        </div>
    </div>

    <div class="wrapper-box">
        <div class="inner-box">
            <h2 class="section-title" style="text-align:center;">Contoh Fokus Penelitian</h2>

            <div class="accordion-item">
                <button class="accordion-btn">INTELIJEN PROSES BISNIS & KEUNGGULAN OPERASIONAL</button>
                <div class="accordion-content">
                    <p><strong>Fokus:</strong><br>
                    Mengoptimalkan proses bisnis internal (manufaktur, logistik, layanan) melalui process mining, peramalan, dan analisis operasional.</p>

                    <p><strong>Contoh:</strong></p>
                    <ul>
                        <li>Penerapan Process Mining untuk Analisis dan Rekomendasi Perbaikan Alur Proses Pengadaan Barang.</li>
                        <li>Pengembangan Sistem Prediksi Kebutuhan Perawatan Mesin Produksi Menggunakan Metode Support Vector Machine untuk Mengurangi Downtime.</li>
                        <li>Implementasi Model Peramalan Time Series (ARIMA/LSTM) untuk Optimasi Manajemen Stok Produk Cepat Laku (Studi Kasus: Distributor Ritel di Malang).</li>
                        <li>Rancang Bangun Dasbor Interaktif untuk Monitoring Kinerja Rantai Pasok (Supply Chain) Secara Real-time Menggunakan Power BI.</li>
                    </ul>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-btn">INTELIJEN PELANGGAN & ANALITIK PEMASARAN</button>
                <div class="accordion-content">
                    <p><strong>Fokus:</strong><br>
                    Memahami pelanggan untuk meningkatkan strategi pemasaran dan penjualan.</p>

                    <p><strong>Contoh:</strong></p>
                    <ul>
                        <li>Implementasi Algoritma K-Means untuk Segmentasi Pelanggan Berdasarkan Perilaku Transaksi Guna Personalisasi Kampanye Pemasaran pada E-commerce Kopi Lokal.</li>
                        <li>Pengembangan Model Klasifikasi untuk Memprediksi Potensi Customer Churn pada Layanan Berlangganan Berbasis Algoritma Random Forest.</li>
                        <li>Analisis Sentimen pada Ulasan Online Menggunakan NLP untuk Mengidentifikasi Faktor Kepuasan Pelanggan Hotel di Kawasan Wisata Batu.</li>
                        <li>Rancang Bangun Sistem Rekomendasi Produk dengan Metode Collaborative Filtering untuk Meningkatkan Cross-Selling pada Aplikasi Toko Online.</li>
                    </ul>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-btn">ANALITIK PRODUK DIGITAL & PLATFORM</button>
                <div class="accordion-content">
                    <p><strong>Fokus:</strong><br>
                    Menganalisis data dari produk digital (aplikasi, website, IoT) untuk inovasi.</p>

                    <p><strong>Contoh:</strong></p>
                    <ul>
                        <li>Analisis Perilaku Pengguna (User Journey) pada Aplikasi Mobile Banking untuk Mengidentifikasi Titik Henti (Drop-off Point) dan Memberikan Rekomendasi Perbaikan UI/UX.</li>
                        <li>Penerapan Uji A/B (A/B Testing) untuk Meningkatkan Tingkat Konversi (Conversion Rate) pada Halaman Pendaftaran Platform Kursus Online.</li>
                        <li>Pengembangan Purwarupa Sistem Monitoring Konsumsi Listrik Berbasis Data Sensor IoT untuk Mendukung Gerakan Efisiensi Energi di Lingkungan Kampus Polinema.</li>
                        <li>Implementasi Dasbor Analitik untuk Memvisualisasikan Metrik Keterlibatan (Engagement Metrics) Pengguna pada Platform Konten Digital.</li>
                    </ul>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-btn">ANALITIK TEKS & NATURAL LANGUAGE PROCESSING (NLP) TERAPAN</button>
                <div class="accordion-content">
                    <p><strong>Fokus:</strong><br>
                    Mengembangkan solusi cerdas dari data tidak terstruktur seperti teks.</p>

                    <p><strong>Contoh:</strong></p>
                    <ul>
                        <li>Rancang Bangun Chatbot Layanan Informasi Penerimaan Mahasiswa Baru (PMB) Politeknik Negeri Malang Menggunakan Arsitektur Berbasis Retrieval.</li>
                        <li>Implementasi Model Klasifikasi Teks untuk Sistem Pendeteksi Ujaran Kebencian pada Komentar Media Sosial Berbahasa Indonesia.</li>
                        <li>Penerapan Topic Modeling untuk Mengekstrak Topik Utama dari Dokumen Laporan Keluhan Pelanggan (Studi Kasus: Perusahaan Telekomunikasi).</li>
                        <li>Pengembangan Sistem Peringkas Dokumen Otomatis untuk Notulensi Rapat Berbasis Metode Ekstraktif.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const accordionBtns = document.querySelectorAll('.accordion-btn');

            accordionBtns.forEach(button => {
                button.addEventListener('click', function() {
                    // Toggle class 'active' pada tombol
                    this.classList.toggle('active');

                    // Ambil elemen konten yang terkait (konten berada setelah tombol)
                    const content = this.nextElementSibling;

                    // Toggle visibility konten
                    if (content.style.maxHeight) {
                        // Jika sudah terbuka, tutup (reset max-height dan padding)
                        content.style.maxHeight = null;
                        content.style.paddingTop = '0';
                        content.style.paddingBottom = '0';
                    } else {
                        // Jika tertutup, buka (set max-height ke nilai scrollHeight)
                        content.style.maxHeight = content.scrollHeight + 'px';
                        content.style.paddingTop = '15px';
                        content.style.paddingBottom = '20px';
                    }

                    // (Opsional) Tutup accordion lain saat satu dibuka
                    accordionBtns.forEach(otherButton => {
                        if (otherButton !== this && otherButton.classList.contains('active')) {
                            otherButton.classList.remove('active');
                            const otherContent = otherButton.nextElementSibling;
                            otherContent.style.maxHeight = null;
                            otherContent.style.paddingTop = '0';
                            otherContent.style.paddingBottom = '0';
                        }
                    });
                });
            });
        });
    </script>
    
    <?php include __DIR__ . '/layout/footer.php'; ?>

</body>
</html>