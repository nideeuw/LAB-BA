<?php

/**
 * Home Page - Complete with all sections
 * Includes: Banner, About, Visi Misi, Roadmap, Research Scope, Research Focus
 */

// Include navbar
include __DIR__ . '/layout/navbar.php';
?>

<main class="main-content">
    <?php
    // Include banner
    include __DIR__ . '/layout/banner.php';

    // Prepare About Us data
    $title = $aboutUs['title'] ?? 'About Us';
    $description = $aboutUs['description'] ?? 'Laboratorium Business Analyst merupakan sarana pengembangan kompetensi mahasiswa di Bidang Teknologi Informasi yang berfokus pada analisis, perancangan, dan peningkatan proses bisnis.';
    $imagePath = !empty($aboutUs['image']) ? $base_url . '/assets/' . $aboutUs['image'] : $base_url . '/assets/img/maskot.png';
    ?>

    <!-- ========== SECTION: ABOUT US ========== -->
    <section id="about" class="about-container fade-in-section">
        <div class="about-content">
            <div class="mascot-section">
                <img src="<?php echo htmlspecialchars($imagePath); ?>"
                    alt="LAB-BA Mascot"
                    class="mascot-image"
                    onerror="this.onerror=null; this.src='<?php echo $base_url; ?>/assets/img/maskot.png';">
            </div>

            <div class="text-section">
                <h2 class="about-title"><?php echo htmlspecialchars($title); ?></h2>
                <div class="title-underline"></div>
                <p class="about-description">
                    <?php echo nl2br(htmlspecialchars($description)); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- ========== SECTION: VISI & MISI ========== -->
    <section class="visi-misi-section">
        <div class="container-vm">
            <div class="visi-misi-wrapper">
                <div class="vm-inner-container">

                    <?php if (!empty($visiMisi)): ?>
                        <!-- VISI -->
                        <div class="vm-box">
                            <h2 class="section-title">VISI</h2>
                            <div class="box-content">
                                <p><?php echo nl2br(htmlspecialchars($visiMisi['visi'])); ?></p>
                            </div>
                        </div>

                        <!-- MISI -->
                        <div class="vm-box">
                            <h2 class="section-title">MISI</h2>
                            <div class="box-content">
                                <?php
                                $misiText = $visiMisi['misi'];

                                // Just display as ordered list without checking pattern
                                $misiLines = preg_split('/\n|\r\n/', $misiText);
                                echo '<ol>';
                                foreach ($misiLines as $line) {
                                    $line = trim($line);
                                    if (!empty($line)) {
                                        // Remove number prefix if exists (1., 2., etc)
                                        $line = preg_replace('/^\d+\.\s*/', '', $line);
                                        echo '<li>' . htmlspecialchars($line) . '</li>';
                                    }
                                }
                                echo '</ol>';
                                ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- DEFAULT JIKA TIDAK ADA DATA -->
                        <div class="vm-box">
                            <h2 class="section-title">VISI</h2>
                            <div class="box-content">
                                <p>Menjadi laboratorium unggul rujukan nasional sebagai inkubator solusi cerdas berbasis data...</p>
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
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>

    <div class="section-separator"></div>

    <!-- ========== SECTION: ROADMAP ========== -->
    <section id="roadmap" class="roadmap-section">
        <div class="roadmap-header">
            <h2>ROADMAP</h2>
        </div>

        <div class="roadmap-container">
            <?php if (!empty($roadmapItems)): ?>
                <?php foreach ($roadmapItems as $roadmap): ?>
                    <div class="roadmap-card">
                        <h3><?php echo htmlspecialchars($roadmap['title']); ?></h3>
                        <?php
                        // Auto-convert plain text to formatted HTML
                        $content = trim($roadmap['content']);

                        // Split by line breaks
                        $lines = preg_split('/\r\n|\r|\n/', $content);

                        foreach ($lines as $line) {
                            $line = trim($line);

                            // Skip empty lines
                            if (empty($line)) {
                                continue;
                            }

                            // Decode HTML entities FIRST
                            $line = html_entity_decode($line, ENT_QUOTES, 'UTF-8');

                            // Check if line has pattern "Label: Description"
                            if (preg_match('/^([^:]+):\s*(.*)$/', $line, $matches)) {
                                $label = trim($matches[1]);
                                $description = trim($matches[2]);

                                if (!empty($description)) {
                                    echo '<p><strong>' . htmlspecialchars($label) . ':</strong> ' . htmlspecialchars($description) . '</p>' . "\n";
                                } else {
                                    // Label only, no description on same line
                                    echo '<p><strong>' . htmlspecialchars($label) . ':</strong></p>' . "\n";
                                }
                            } else {
                                // Plain paragraph
                                echo '<p>' . htmlspecialchars($line) . '</p>' . "\n";
                            }
                        }
                        ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback -->
                <div class="roadmap-card">
                    <h3>Jangka Pendek (1–5 Tahun)</h3>
                    <p><strong>Kualitas lulusan:</strong> Penguatan praktikum end-to-end (data → model → insight → aksi).</p>
                    <p><strong>Ilmu:</strong> Fondasi riset terapan & repositori yang dapat diuji ulang.</p>
                    <p><strong>Masy/Industri:</strong> Studi kasus awal & pendampingan ringan.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ========== SECTION: RESEARCH SCOPE ========== -->
    <div id="research-focus" class="wrapper-box">
        <div class="inner-box" style="text-align:center;">
            <h2 class="section-title">
                <?php
                if (!empty($researchScope) && !empty($researchScope['title'])) {
                    echo htmlspecialchars($researchScope['title']);
                } else {
                    echo 'Lingkup Penelitian';
                }
                ?>
            </h2>

            <?php if (!empty($researchScope) && !empty($researchScope['image'])): ?>
                <img src="<?php echo $base_url; ?>/assets/<?php echo htmlspecialchars($researchScope['image']); ?>"
                    alt="<?php echo htmlspecialchars($researchScope['title']); ?>"
                    style="width:100%; max-width:1000px; margin-top:20px; border-radius:12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"
                    onerror="this.src='<?php echo $base_url; ?>/assets/img/Lingkup_Penelitian.png'">

                <?php if (!empty($researchScope['description'])): ?>
                    <p class="text-muted mt-3" style="font-size: 0.95rem; max-width: 800px; margin: 20px auto 0;">
                        <?php echo nl2br(htmlspecialchars($researchScope['description'])); ?>
                    </p>
                <?php endif; ?>
            <?php else: ?>
                <!-- DEFAULT IMAGE -->
                <img src="<?php echo $base_url; ?>/assets/img/Lingkup_Penelitian.png"
                    alt="Lingkup Penelitian"
                    style="width:100%; max-width:1000px; margin-top:20px; border-radius:12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <?php endif; ?>
        </div>
    </div>

    <!-- ========== SECTION: FOKUS PENELITIAN (ACCORDION) ========== -->
    <div class="wrapper-box">
        <div class="inner-box">
            <h2 class="section-title" style="text-align:center;">Research Focus</h2>

            <?php if (!empty($researchFocus)): ?>
                <?php foreach ($researchFocus as $focus): ?>
                    <div class="accordion-item">
                        <button class="accordion-btn"><?php echo htmlspecialchars($focus['title']); ?></button>
                        <div class="accordion-content">
                            <p><strong>Fokus:</strong><br>
                                <?php echo nl2br(htmlspecialchars($focus['focus_description'])); ?></p>

                            <p><strong>Contoh:</strong></p>
                            <ul>
                                <?php
                                // Parse examples
                                $examples = $focus['examples'];

                                // Decode HTML entities FIRST
                                $examples = html_entity_decode($examples, ENT_QUOTES, 'UTF-8');

                                // Remove "Contoh:" prefix if exists
                                $examples = preg_replace('/^Contoh:\s*/i', '', $examples);

                                // Split by period followed by space/newline or by newline
                                $exampleList = preg_split('/\.\s+|\n/', $examples);

                                foreach ($exampleList as $example) {
                                    $example = trim($example);
                                    if (!empty($example)) {
                                        echo '<li>' . htmlspecialchars($example) . '.</li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- DEFAULT JIKA TIDAK ADA DATA -->
                <div class="accordion-item">
                    <button class="accordion-btn">INTELIJEN PROSES BISNIS & KEUNGGULAN OPERASIONAL</button>
                    <div class="accordion-content">
                        <p><strong>Fokus:</strong><br>
                            Mengoptimalkan proses bisnis internal (manufaktur, logistik, layanan) melalui process mining, peramalan, dan analisis operasional.</p>

                        <p><strong>Contoh:</strong></p>
                        <ul>
                            <li>Penerapan Process Mining untuk Analisis dan Rekomendasi Perbaikan Alur Proses Pengadaan Barang.</li>
                            <li>Pengembangan Sistem Prediksi Kebutuhan Perawatan Mesin Produksi Menggunakan Metode Support Vector Machine untuk Mengurangi Downtime.</li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <?php
    // Include footer
    include __DIR__ . '/layout/footer.php';
    ?>
</main>

<script>
    // Accordion functionality
    document.addEventListener('DOMContentLoaded', function() {
        const accordionBtns = document.querySelectorAll('.accordion-btn');

        accordionBtns.forEach(button => {
            button.addEventListener('click', function() {
                // Toggle class 'active' pada tombol
                this.classList.toggle('active');

                // Ambil elemen konten yang terkait
                const content = this.nextElementSibling;

                // Toggle visibility konten
                if (content.style.maxHeight) {
                    content.style.maxHeight = null;
                    content.style.paddingTop = '0';
                    content.style.paddingBottom = '0';
                } else {
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