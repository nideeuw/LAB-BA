<?php
$page_title = 'Add Member';
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
                        <h5 class="mb-0">Add New Member</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/members/store" method="POST" enctype="multipart/form-data" id="memberForm">

                            <div class="mb-4">
                                <label for="image" class="form-label fw-semibold">Photo</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="form-text">Maximum 2MB (JPG, PNG, WEBP). Recommended: 400x400px</div>

                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="nama" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" required placeholder="e.g., John Doe">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="gelar_depan" class="form-label fw-semibold">Front Title</label>
                                    <input type="text" class="form-control" id="gelar_depan" name="gelar_depan" placeholder="e.g., Dr., Prof.">
                                    <div class="form-text">Optional. e.g., Dr., Prof.</div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="gelar_belakang" class="form-label fw-semibold">Back Title</label>
                                    <input type="text" class="form-control" id="gelar_belakang" name="gelar_belakang" placeholder="e.g., S.Kom., M.Kom., Ph.D">
                                    <div class="form-text">Optional. e.g., S.Kom., M.Kom.</div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="jabatan" class="form-label fw-semibold">Position</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="e.g., Head of Laboratory, Lecturer">
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="member@example.com">
                            </div>

                            <div class="mb-4">
                                <label for="sinta_link" class="form-label fw-semibold">SINTA Profile Link</label>
                                <input type="url" class="form-control" id="sinta_link" name="sinta_link" placeholder="https://sinta.kemdikbud.go.id/authors/profile/...">
                                <div class="form-text">Full URL to SINTA profile page</div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="is_active">Active (Visible on public page)</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Create Member
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/members" class="btn btn-outline-secondary">
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
$("#image").on("change", function(e) {
    let file = e.target.files[0];
    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            alert("File size must be less than 2MB!");
            $(this).val("");
            $("#imagePreview").hide();
            return;
        }
        let reader = new FileReader();
        reader.onload = function(e) {
            $("#previewImg").attr("src", e.target.result);
            $("#imagePreview").show();
        };
        reader.readAsDataURL(file);
    }
});

$("#memberForm").on("submit", function(e) {
    let nama = $("#nama").val().trim();
    let email = $("#email").val().trim();
    if (!nama) {
        e.preventDefault();
        alert("Name is required!");
        return false;
    }
    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        e.preventDefault();
        alert("Invalid email format!");
        return false;
    }
});
</script>
';
include __DIR__ . '/../layout/footer.php';
?>