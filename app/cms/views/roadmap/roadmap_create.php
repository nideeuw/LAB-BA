<?php

/**
 * Roadmap Create View
 * File: app/cms/views/roadmap/roadmap_create.php
 */

// SET PAGE TITLE
$page_title = 'Add Roadmap';

// Include layout
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">

        <!-- [ breadcrumb ] start -->
        <?php include __DIR__ . '/../layout/breadcrumb.php'; ?>
        <!-- [ breadcrumb ] end -->

        <!-- Flash Message -->
        <?php
        $flash = getFlash();
        if ($flash):
        ?>
            <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $flash['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Add New Roadmap</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/roadmap/store" method="POST" id="roadmapForm">

                            <div class="row">
                                <!-- Title -->
                                <div class="col-md-8 mb-3">
                                    <label for="title" class="form-label">
                                        Title <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control"
                                        id="title"
                                        name="title"
                                        required
                                        placeholder="e.g., Jangka Pendek (1–5 Tahun)">
                                </div>

                                <!-- Sort Order -->
                                <div class="col-md-4 mb-3">
                                    <label for="sort_order" class="form-label">
                                        Sort Order <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                        class="form-control"
                                        id="sort_order"
                                        name="sort_order"
                                        value="<?php echo $nextOrder ?? 1; ?>"
                                        required
                                        min="1">
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="mb-3">
                                <label for="content" class="form-label">
                                    Content <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control"
                                    id="content"
                                    name="content"
                                    rows="10"
                                    required
                                    placeholder="Enter roadmap content. Separate each section with a blank line.
                                    Example
                                    Kualitas lulusan: Penguatan praktikum end-to-end (data → model → insight → aksi).
                                    Ilmu: Fondasi riset terapan & repositori yang dapat diuji ulang.
                                    Masy/Industri: Studi kasus awal & pendampingan ringan."></textarea>
                                <small class="text-muted">
                                    Each line will be displayed as a separate paragraph with formatted labels.
                                </small>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        value="1"
                                        checked>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Create Roadmap
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/roadmap" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="col-lg-4">
                <div class="card bg-light-primary">
                    <div class="card-body">
                        <h6 class="mb-3">
                            <i class="ti ti-info-circle"></i> Guidelines
                        </h6>

                        <h6 class="mb-2">Title Examples:</h6>
                        <ul class="mb-3">
                            <li>Jangka Pendek (1–5 Tahun)</li>
                            <li>Jangka Menengah (6–10 Tahun)</li>
                            <li>Jangka Panjang (&gt;10 Tahun)</li>
                        </ul>

                        <h6 class="mb-2">Content Format:</h6>
                        <ul class="mb-3">
                            <li>Use <code>&lt;p&gt;</code> for paragraphs</li>
                            <li>Use <code>&lt;strong&gt;</code> for bold</li>
                            <li>Keep it structured and clear</li>
                        </ul>

                        <h6 class="mb-2">📋 Copy This Template:</h6>
                        <pre class="bg-white p-2 rounded" style="font-size: 0.75rem; line-height: 1.4; max-height: 250px; overflow-y: auto;">&lt;p&gt;&lt;strong&gt;Kualitas lulusan:&lt;/strong&gt; Penguatan praktikum end-to-end (data → model → insight → aksi).&lt;/p&gt;

                            &lt;p&gt;&lt;strong&gt;Ilmu:&lt;/strong&gt; Fondasi riset terapan &amp; repositori yang dapat diuji ulang.&lt;/p&gt;

                            &lt;p&gt;&lt;strong&gt;Masy/Industri:&lt;/strong&gt; Studi kasus awal &amp; pendampingan ringan.&lt;/p&gt;</pre>
                        <button type="button" class="btn btn-sm btn-outline-primary w-100" onclick="copyTemplate()">
                            <i class="ti ti-copy"></i> Copy Template
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->

    </div>
</div>

<?php
// Page specific scripts
$page_scripts = '
<script>
function copyTemplate() {
    const template = `<p><strong>Kualitas lulusan:</strong> [Isi text di sini]</p>

<p><strong>Ilmu:</strong> [Isi text di sini]</p>

<p><strong>Masy/Industri:</strong> [Isi text di sini]</p>`;
    
    document.getElementById("content").value = template;
    alert("Template copied! Silakan edit text di dalam [ ]");
}

$(document).ready(function() {
    // Form validation
    $("#roadmapForm").on("submit", function(e) {
        let title = $("#title").val().trim();
        let content = $("#content").val().trim();

        if (!title) {
            e.preventDefault();
            alert("Title is required!");
            return false;
        }

        if (!content) {
            e.preventDefault();
            alert("Content is required!");
            return false;
        }
        
        // Check if contains HTML formatting
        if (!content.includes("<p>") || !content.includes("<strong>")) {
            if (!confirm("Content tidak menggunakan format HTML. Lanjutkan?")) {
                e.preventDefault();
                return false;
            }
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>