<?php
/**
 * Member Edit View
 * File: app/cms/views/members/members_edit.php
 */

// SET PAGE TITLE
$page_title = 'Edit Member';

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
                        <h5 class="mb-0">Edit Member: <?php echo htmlspecialchars(MembersModel::getFullName($member)); ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>/cms/members/update/<?php echo $member['id']; ?>" method="POST" enctype="multipart/form-data" id="memberForm">

                            <!-- Photo Upload -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Photo</label>
                                
                                <!-- Current Photo -->
                                <?php if (!empty($member['image'])): ?>
                                    <div class="mb-2">
                                        <img src="<?php echo $base_url; ?>/public/<?php echo htmlspecialchars($member['image']); ?>" 
                                             alt="Current photo" 
                                             class="rounded-circle" 
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                        <p class="text-muted small mt-1">Current photo</p>
                                    </div>
                                <?php endif; ?>
                                
                                <input type="file"
                                    class="form-control"
                                    id="image"
                                    name="image"
                                    accept="image/*">
                                <small class="text-muted">Leave empty to keep current photo. Max 2MB. Accepted: JPG, PNG, WEBP.</small>

                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Name (Required) -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control"
                                    id="nama"
                                    name="nama"
                                    required
                                    value="<?php echo htmlspecialchars($member['nama']); ?>"
                                    placeholder="e.g., John Doe">
                            </div>

                            <!-- Academic Titles -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gelar_depan" class="form-label">Front Title</label>
                                        <input type="text"
                                            class="form-control"
                                            id="gelar_depan"
                                            name="gelar_depan"
                                            value="<?php echo htmlspecialchars($member['gelar_depan'] ?? ''); ?>"
                                            placeholder="e.g., Dr., Prof.">
                                        <small class="text-muted">Optional. e.g., Dr., Prof.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gelar_belakang" class="form-label">Back Title</label>
                                        <input type="text"
                                            class="form-control"
                                            id="gelar_belakang"
                                            name="gelar_belakang"
                                            value="<?php echo htmlspecialchars($member['gelar_belakang'] ?? ''); ?>"
                                            placeholder="e.g., S.Kom., M.Kom., Ph.D">
                                        <small class="text-muted">Optional. e.g., S.Kom., M.Kom.</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Position -->
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Position</label>
                                <input type="text"
                                    class="form-control"
                                    id="jabatan"
                                    name="jabatan"
                                    value="<?php echo htmlspecialchars($member['jabatan'] ?? ''); ?>"
                                    placeholder="e.g., Head of Laboratory, Lecturer">
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    value="<?php echo htmlspecialchars($member['email'] ?? ''); ?>"
                                    placeholder="member@example.com">
                            </div>

                            <!-- SINTA Link -->
                            <div class="mb-3">
                                <label for="sinta_link" class="form-label">SINTA Profile Link</label>
                                <input type="url"
                                    class="form-control"
                                    id="sinta_link"
                                    name="sinta_link"
                                    value="<?php echo htmlspecialchars($member['sinta_link'] ?? ''); ?>"
                                    placeholder="https://sinta.kemdikbud.go.id/authors/profile/...">
                                <small class="text-muted">Full URL to SINTA profile page</small>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="is_active"
                                        name="is_active"
                                        value="1"
                                        <?php echo $member['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">
                                        Active (Visible on public page)
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Member
                                </button>
                                <a href="<?php echo $base_url; ?>/cms/members" class="btn btn-secondary">
                                    <i class="ti ti-x"></i> Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="col-lg-4">
                <div class="card bg-light-info">
                    <div class="card-body">
                        <h5 class="mb-3">
                            <i class="ti ti-info-circle"></i> Edit Information
                        </h5>

                        <h6 class="mb-2">Photo:</h6>
                        <ul class="mb-3">
                            <li>Leave empty to keep current photo</li>
                            <li>Upload new to replace</li>
                            <li>Max size: 2MB</li>
                            <li>Format: JPG, PNG, WEBP</li>
                        </ul>

                        <h6 class="mb-2">Member ID:</h6>
                        <p class="mb-3"><?php echo $member['id']; ?></p>

                        <h6 class="mb-2">Created:</h6>
                        <p class="mb-0">
                            <?php echo !empty($member['created_by']) ? htmlspecialchars($member['created_by']) : '-'; ?><br>
                            <small class="text-muted">
                                <?php echo !empty($member['created_on']) ? date('d M Y H:i', strtotime($member['created_on'])) : '-'; ?>
                            </small>
                        </p>
                    </div>
                </div>

                <!-- Preview Card -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="mb-3">Name Preview</h6>
                        <div id="namePreview" class="text-center p-3 bg-light rounded">
                            <strong><?php echo htmlspecialchars(MembersModel::getFullName($member)); ?></strong>
                        </div>
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
    // Image preview
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
        } else {
            $("#imagePreview").hide();
        }
    });

    // Name preview update
    function updateNamePreview() {
        let gelarDepan = $("#gelar_depan").val().trim();
        let nama = $("#nama").val().trim();
        let gelarBelakang = $("#gelar_belakang").val().trim();
        
        let fullName = "";
        
        if (gelarDepan) fullName += gelarDepan + " ";
        fullName += nama;
        if (gelarBelakang) fullName += ", " + gelarBelakang;
        
        if (fullName) {
            $("#namePreview").html("<strong>" + fullName + "</strong>");
        } else {
            $("#namePreview").html("<em>Type to see preview...</em>");
        }
    }
    
    $("#gelar_depan, #nama, #gelar_belakang").on("input", updateNamePreview);

    // Form validation
    $("#memberForm").on("submit", function(e) {
        let nama = $("#nama").val().trim();
        let email = $("#email").val().trim();

        if (!nama) {
            e.preventDefault();
            alert("Name is required!");
            return false;
        }

        if (email && !validateEmail(email)) {
            e.preventDefault();
            alert("Invalid email format!");
            return false;
        }
    });

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
});
</script>
';

include __DIR__ . '/../layout/footer.php';
?>