<?php

/**
 * Research Focus Create View
 * File: app/cms/views/research_focus/research_focus_create.php
 */

// SET PAGE TITLE
$page_title = 'Add Research Focus';

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
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Add New Research Focus</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/research_focus/store" method="POST" id="researchFocusForm">

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
                                        placeholder="e.g., INTELIJEN PROSES BISNIS & KEUNGGULAN OPERASIONAL">
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

                            <!-- Focus Description -->
                            <div class="mb-3">
                                <label for="focus_description" class="form-label">
                                    Focus Description <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control"
                                    id="focus_description"
                                    name="focus_description"
                                    rows="4"
                                    required
                                    placeholder="Enter the main focus or goal of this research area..."></textarea>
                                <small class="text-muted">Describe the focus of this research area (2-3 sentences)</small>
                            </div>

                            <!-- Examples -->
                            <div class="mb-3">
                                <label for="examples" class="form-label">
                                    Examples <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control"
                                    id="examples"
                                    name="examples"
                                    rows="8"
                                    required
                                    placeholder="Enter example research topics, separated by line breaks.

Example format:
Penerapan Process Mining untuk Analisis dan Rekomendasi Perbaikan Alur Proses Pengadaan Barang.
Pengembangan Sistem Prediksi Kebutuhan Perawatan Mesin Produksi Menggunakan Metode Support Vector Machine untuk Mengurangi Downtime."></textarea>
                                <small class="text-muted">List 3-5 example research topics, one per line</small>
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
                                    <i class="ti ti-device-floppy"></i> Create Research Focus
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/research_focus" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="col-lg-3">
                <div class="card bg-light-primary">
                    <div class="card-body">
                        <h6 class="mb-3">
                            <i class="ti ti-info-circle"></i> Guidelines
                        </h6>

                        <h6 class="mb-2">Title Tips:</h6>
                        <ul class="mb-3">
                            <li>Use ALL CAPS for emphasis</li>
                            <li>Be descriptive and specific</li>
                            <li>Keep it concise (2-10 words)</li>
                        </ul>

                        <h6 class="mb-2">Focus Description:</h6>
                        <ul class="mb-3">
                            <li>Explain the research area</li>
                            <li>2-3 sentences recommended</li>
                            <li>Be clear and concise</li>
                        </ul>

                        <h6 class="mb-2">Examples:</h6>
                        <ul class="mb-0">
                            <li>One topic per line</li>
                            <li>List 3-5 specific topics</li>
                            <li>Be concrete and practical</li>
                            <li>End each with period (.)</li>
                        </ul>
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
$(document).ready(function() {
    // Form validation
    $("#researchFocusForm").on("submit", function(e) {
        let title = $("#title").val().trim();
        let focusDescription = $("#focus_description").val().trim();
        let examples = $("#examples").val().trim();

        if (!title) {
            e.preventDefault();
            alert("Title is required!");
            return false;
        }

        if (!focusDescription) {
            e.preventDefault();
            alert("Focus Description is required!");
            return false;
        }

        if (!examples) {
            e.preventDefault();
            alert("Examples are required!");
            return false;
        }
    });
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>