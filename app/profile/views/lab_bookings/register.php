<?php
include __DIR__ . '/../layout/navbar.php';

$formData = $_SESSION['form_data'] ?? [];
$errors = $_SESSION['form_errors'] ?? [];
unset($_SESSION['form_data'], $_SESSION['form_errors']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Lab Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/lab_bookings.css">
</head>

<body>
    <div class="container container-small">
        <h1>Register User Booking</h1>
        <p class="week-info">Daftar sebagai Dosen/Staff untuk bisa booking lab</p>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo $base_url; ?>/lab_bookings/register-store" id="registerForm">

            <div class="form-group">
                <label for="nama">Nama Lengkap <span>*</span></label>
                <input type="text"
                    id="nama"
                    name="nama"
                    required
                    placeholder="Masukkan nama lengkap"
                    value="<?php echo htmlspecialchars($formData['nama'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="nip">NIP <span>*</span></label>
                <input type="text"
                    id="nip"
                    name="nip"
                    required
                    placeholder="Masukkan NIP"
                    value="<?php echo htmlspecialchars($formData['nip'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="email">Email <span>*</span></label>
                <input type="email"
                    id="email"
                    name="email"
                    required
                    placeholder="email@example.com"
                    value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="no_telp">No. HP / WhatsApp <span>*</span></label>
                <input type="tel"
                    id="no_telp"
                    name="no_telp"
                    required
                    placeholder="08xxxxxxxxxx"
                    pattern="[0-9]{10,15}"
                    value="<?php echo htmlspecialchars($formData['no_telp'] ?? ''); ?>">
                <small style="color: #6b7280; font-size: 0.85rem;">Format: 08xxxxxxxxxx (10-15 digit)</small>
            </div>

            <div class="form-group">
                <label for="category">Kategori <span>*</span></label>
                <select id="category" name="category" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="dosen" <?php echo (($formData['category'] ?? '') == 'dosen') ? 'selected' : ''; ?>>Dosen</option>
                    <option value="staff" <?php echo (($formData['category'] ?? '') == 'staff') ? 'selected' : ''; ?>>Staff</option>
                </select>
                <small style="color: #6b7280; font-size: 0.85rem;">Hanya Dosen & Staff yang dapat booking lab</small>
            </div>

            <div class="row">
                <a href="<?php echo $base_url; ?>/lab_bookings" class="btn btn-cancel" style="text-align: center;">Cancel</a>
                <button type="submit" class="btn btn-primary" style="text-align: center;">Register</button>
            </div>
        </form>

        <div style="text-align: center; margin-top: 1.5rem; color: #6b7280;">
            Sudah punya akun? <a href="<?php echo $base_url; ?>/lab_bookings" style="color: #3b82f6; font-weight: 600;">Kembali ke Calendar</a>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const phone = document.getElementById('no_telp').value;
            const phonePattern = /^[0-9]{10,15}$/;

            if (!phonePattern.test(phone)) {
                e.preventDefault();
                alert('No. HP harus berupa angka 10-15 digit!');
                return false;
            }

            const email = document.getElementById('email').value;
            if (!email.includes('@')) {
                e.preventDefault();
                alert('Format email tidak valid!');
                return false;
            }
        });
    </script>

    <?php include __DIR__ . '/../layout/footer.php'; ?>
</body>

</html>