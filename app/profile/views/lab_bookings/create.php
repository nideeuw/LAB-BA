<?php
include __DIR__ . '/../layout/navbar.php';

$formData = $_SESSION['form_data'] ?? [];
$errors = $_SESSION['form_errors'] ?? [];
unset($_SESSION['form_data'], $_SESSION['form_errors']);

$prefillDate = $_GET['date'] ?? '';
$prefillStart = $_GET['start'] ?? '';
$prefillEnd = $_GET['end'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Lab | LAB-BA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/lab_bookings.css">
</head>
<body>
    <div class="container container-small">
        <h1>Book Lab</h1>

        <!-- INFO BOX WITH LINK TO GUIDELINES -->
        <div style="background: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-bottom: 1.5rem; border-radius: 8px;">
            <p style="margin: 0; color: #1e40af; font-weight: 500;">
                Pastikan Anda sudah membaca <a href="javascript:void(0)" onclick="showGuidelines()" style="color: #2563eb; text-decoration: underline; font-weight: 600;">Tata Cara Peminjaman Lab</a> sebelum booking.
            </p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo $base_url; ?>/lab_bookings/store" id="bookingForm">

            <div class="form-group">
                <label for="id_peminjam">Nama Dosen/Staff <span>*</span></label>
                <select id="id_peminjam" name="id_peminjam" required>
                    <option value="">-- Pilih Dosen/Staff --</option>
                    <?php foreach ($borrowers as $borrower): ?>
                        <option value="<?php echo $borrower['id']; ?>" <?php echo (isset($formData['id_peminjam']) && $formData['id_peminjam'] == $borrower['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($borrower['nama']) . ' (' . ucfirst($borrower['category'] ?? 'dosen') . ')'; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small style="color: #6b7280; font-size: 0.85rem;">Belum terdaftar? <a href="<?php echo $base_url; ?>/lab_bookings/register" style="color: #3b82f6; font-weight: 600;">Daftar di sini</a></small>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="tanggal_mulai">Tanggal Mulai <span>*</span></label>
                    <input type="date"
                        id="tanggal_mulai"
                        name="tanggal_mulai"
                        min="<?php echo date('Y-m-d'); ?>"
                        value="<?php echo $prefillDate ?: ($formData['tanggal_mulai'] ?? date('Y-m-d')); ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="tanggal_selesai">Tanggal Selesai <span>*</span></label>
                    <input type="date"
                        id="tanggal_selesai"
                        name="tanggal_selesai"
                        min="<?php echo date('Y-m-d'); ?>"
                        value="<?php echo $prefillDate ?: ($formData['tanggal_selesai'] ?? date('Y-m-d')); ?>"
                        required>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="jam_mulai">Jam Mulai <span>*</span></label>
                    <input type="time"
                        id="jam_mulai"
                        name="jam_mulai"
                        min="07:00"
                        max="16:00"
                        value="<?php echo $prefillStart ?: ($formData['jam_mulai'] ?? ''); ?>"
                        required>
                    <small style="color: #6b7280; font-size: 0.85rem;">Lab hours: 07:00 - 17:00</small>
                </div>
                <div class="form-group">
                    <label for="jam_selesai">Jam Selesai <span>*</span></label>
                    <input type="time"
                        id="jam_selesai"
                        name="jam_selesai"
                        min="08:00"
                        max="17:00"
                        value="<?php echo $prefillEnd ?: ($formData['jam_selesai'] ?? ''); ?>"
                        required>
                    <small style="color: #6b7280; font-size: 0.85rem;">Lab hours: 07:00 - 17:00</small>
                </div>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi <span>*</span></label>
                <textarea id="deskripsi" 
                    name="deskripsi" 
                    rows="4" 
                    required
                    placeholder="e.g., Praktikum Pemrograman Web"><?php echo htmlspecialchars($formData['deskripsi'] ?? ''); ?></textarea>
                <small style="color: #6b7280; font-size: 0.85rem;">Jelaskan tujuan peminjaman lab secara detail</small>
            </div>

            <div class="row">
                <a href="<?php echo $base_url; ?>/lab_bookings" class="btn btn-cancel" style="text-align: center;">Cancel</a>
                <button type="submit" class="btn btn-primary" style="text-align: center;">Submit Booking</button>
            </div>
        </form>
    </div>

    <!-- MODAL TATA CARA -->
    <div class="modal-overlay" id="guidelinesModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeGuidelines()">&times;</button>
            <h2>Tata Cara Peminjaman Lab</h2>

            <h3>🔹 Persyaratan Peminjaman</h3>
            <ul>
                <li><strong>Hanya Dosen & Staff</strong> yang dapat melakukan peminjaman lab</li>
                <li>Wajib terdaftar sebagai user booking terlebih dahulu</li>
                <li>Menyertakan deskripsi lengkap tujuan peminjaman</li>
                <li>Peminjaman minimal H-1 sebelum tanggal yang diinginkan</li>
            </ul>

            <h3>🔹 Jam Operasional Lab</h3>
            <ul>
                <li><strong>Senin - Jumat:</strong> 07:00 - 17:00 WIB</li>
                <li>Peminjaman dapat dilakukan per jam (bebas menit, contoh: 08:15, 09:45)</li>
                <li>Durasi maksimal: 8 jam per hari</li>
            </ul>

            <h3>🔹 Prosedur Booking</h3>
            <ul>
                <li><strong>Step 1:</strong> Daftar sebagai user booking (jika belum)</li>
                <li><strong>Step 2:</strong> Login dan pilih tanggal & jam di calendar</li>
                <li><strong>Step 3:</strong> Isi form booking dengan lengkap</li>
                <li><strong>Step 4:</strong> Submit dan tunggu approval dari admin</li>
                <li><strong>Step 5:</strong> Cek status booking di menu "Bookings"</li>
            </ul>

            <h3>🔹 Status Booking</h3>
            <ul>
                <li><strong>Pending:</strong> Menunggu approval admin</li>
                <li><strong>Approved:</strong> Booking disetujui, lab siap digunakan</li>
                <li><strong>Rejected:</strong> Booking ditolak (cek alasan penolakan)</li>
                <li><strong>In Use:</strong> Lab sedang digunakan</li>
                <li><strong>Canceled:</strong> Booking dibatalkan</li>
            </ul>

            <h3>🔹 Hal yang Tidak Diperbolehkan</h3>
            <ul>
                <li>❌ Double booking (bentrok dengan jadwal lain)</li>
                <li>❌ Booking di luar jam operasional</li>
                <li>❌ Booking tanpa deskripsi yang jelas</li>
                <li>❌ Membatalkan booking mendadak tanpa konfirmasi</li>
            </ul>

            <h3>🔹 Kontak</h3>
            <ul>
                <li>Jika ada pertanyaan, hubungi admin lab</li>
                <li><strong>Email:</strong> <?php echo htmlspecialchars($contactInfo['email'] ?? 'lab.ba@polinema.ac.id'); ?></li>
                <li><strong>WhatsApp:</strong> <?php echo htmlspecialchars($contactInfo['no_telp'] ?? '0812-3456-7890'); ?></li>
                <li><strong>Alamat:</strong> <?php echo htmlspecialchars($contactInfo['alamat'] ?? 'Jl. Soekarno Hatta Malang'); ?></li>
            </ul>

            <div style="margin-top: 2rem;">
                <button onclick="closeGuidelines()" class="btn btn-primary" style="width: 90%; justify-content: center;">Mengerti</button>
            </div>
        </div>
    </div>

    <script>
        function showGuidelines() {
            document.getElementById('guidelinesModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeGuidelines() {
            document.getElementById('guidelinesModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('guidelinesModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGuidelines();
            }
        });

        document.getElementById('tanggal_mulai').addEventListener('change', function() {
            document.getElementById('tanggal_selesai').setAttribute('min', this.value);
        });

        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            const start = document.getElementById('jam_mulai').value;
            const end = document.getElementById('jam_selesai').value;
            const startDate = document.getElementById('tanggal_mulai').value;
            const endDate = document.getElementById('tanggal_selesai').value;

            if (start && end && end <= start) {
                e.preventDefault();
                alert('Jam selesai harus setelah jam mulai!');
                return false;
            }

            if (startDate && endDate && endDate < startDate) {
                e.preventDefault();
                alert('Tanggal selesai harus setelah atau sama dengan tanggal mulai!');
                return false;
            }

            if (start < '07:00' || start > '16:00') {
                e.preventDefault();
                alert('Jam mulai harus antara 07:00 - 16:00');
                return false;
            }

            if (end < '08:00' || end > '17:00') {
                e.preventDefault();
                alert('Jam selesai harus antara 08:00 - 17:00');
                return false;
            }
        });
    </script>

    <?php include __DIR__ . '/../layout/footer.php'; ?>
</body>
</html>