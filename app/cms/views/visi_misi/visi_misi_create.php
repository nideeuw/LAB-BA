<?php
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Add New Visi Misi</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/visi_misi/store" method="POST" id="visiMisiForm">

                            <div class="mb-4">
                                <label for="visi" class="form-label fw-semibold">Visi <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="visi" name="visi" rows="4" required placeholder="Enter vision statement (2-3 sentences in paragraph form)"></textarea>
                                <div class="form-text">Write vision in paragraph form without numbering</div>
                            </div>

                            <div class="mb-4">
                                <label for="misi" class="form-label fw-semibold">Misi <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="misi" name="misi" rows="8" required placeholder="Enter mission statements (one per line, without numbering)"></textarea>
                                <div class="form-text">Enter each mission point on a new line. Do not add numbers - they will be added automatically when displayed.</div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                    <label class="form-check-label" for="is_active">Active (Display on frontend)</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Save Visi Misi
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/visi_misi" class="btn btn-outline-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                            </div>

                        </form>
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