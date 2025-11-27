<?php
// generate_hash.php

$password_plain = 'password'; // GANTI DENGAN PASSWORD YANG INGIN DIGUNAKAN
$hashed_password = password_hash($password_plain, PASSWORD_BCRYPT);

echo "Password Baru: " . $password_plain . "\n <br>";
echo "Hash (String Panjang): " . $hashed_password . "\n <br>";
?>