<?php

/**
 * Visi Misi Create View
 * File: app/cms/views/visi_misi/visi_misi_create.php
 */

$page_title = 'Add Visi Misi';
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="pc-container">
    <div class="pc-content">
        <?php include __DIR__ . '/../layout/breadcrumb.php'; ?>

        <?php
        $flash = getFlash();
        if ($flash):
        ?>
            <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $flash['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Add New Visi Misi</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/visi_misi/store" method="POST" id="visiMisiForm">

                            <!-- Visi -->
                            <div class="mb-3">
                                <label for="visi" class="form-label">
                                    Visi <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control"
                                    id="visi"
                                    name="visi"
                                    rows="4"
                                    required
                                    placeholder="Enter vision statement (2-3 sentences in paragraph form)"></textarea>
                                <small class="text-muted">Write vision in paragraph form without numbering</small>
                            </div>

                            <!-- Misi -->
                            <div class="mb-3">
                                <label for="misi" class="form-label">
                                    Misi <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control"
                                    id="misi"
                                    name="misi"
                                    rows="8"
                                    required
                                    placeholder="Enter mission statements (one per line, without numbering)"></textarea>
                                <small class="text-muted">Enter each mission point on a new line. Do not add numbers - they will be added automatically when displayed.</small>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        checked>
                                    <label class="form-check-label" for="is_active">
                                        Active (Display on frontend)
                                    </label>
                                </div>
                                <small class="text-muted">Only one visi misi should be active at a time for frontend display</small>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Save Visi Misi
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/visi_misi" class="btn btn-secondary">
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

                        <h6 class="mb-2">Visi:</h6>
                        <ul class="mb-3">
                            <li>Write in paragraph form (no numbering)</li>
                            <li>Keep it concise (2-3 sentences)</li>
                            <li>Focus on future vision and goals</li>
                            <li>Use professional language</li>
                        </ul>

                        <h6 class="mb-2">Misi:</h6>
                        <ul class="mb-3">
                            <li>Write each mission on a new line</li>
                            <li>Do NOT add numbers (1., 2., etc.)</li>
                            <li>Numbers will be auto-generated</li>
                            <li>3-6 mission points recommended</li>
                        </ul>

                        <h6 class="mb-2">Example Misi Input:</h6>
                        <div class="bg-white p-2 rounded mb-3">
                            <small class="text-muted d-block">Mengembangkan riset terapan</small>
                            <small class="text-muted d-block">Mengintegrasikan berbagai disiplin ilmu</small>
                            <small class="text-muted d-block">Membangun kemitraan strategis</small>
                        </div>
                    </div>
                </div>

                <div class="card bg-light-warning mt-3">
                    <div class="card-body">
                        <h6 class="mb-2">
                            <i class="ti ti-alert-triangle"></i> Important Note
                        </h6>
                        <p class="mb-0 small">
                            Make sure only <strong>one visi misi is active</strong> at a time for frontend display. You can have multiple records but only activate the one you want to show.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$page_scripts = '
<script>
$(document).ready(function() {
    // Form validation
    $("#visiMisiForm").on("submit", function(e) {
        let visi = $("#visi").val().trim();
        let misi = $("#misi").val().trim();

        if (!visi) {
            e.preventDefault();
            alert("Visi is required!");
            $("#visi").focus();
            return false;
        }

        if (visi.length < 20) {
            e.preventDefault();
            alert("Visi too short! Please write at least 2-3 sentences.");
            $("#visi").focus();
            return false;
        }

        if (!misi) {
            e.preventDefault();
            alert("Misi is required!");
            $("#misi").focus();
            return false;
        }

        if (misi.length < 20) {
            e.preventDefault();
            alert("Misi too short! Please write at least 3 mission points.");
            $("#misi").focus();
            return false;
        }
    });
});
</script>
';
include __DIR__ . '/../layout/footer.php';
?>