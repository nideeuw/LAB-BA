<?php
// index.php (Root) - BARIS PALING ATAS
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Tentukan Base Path
define('ROOT_PATH', __DIR__ . '/');
define('APP_PATH', ROOT_PATH . 'app/');
define('ROUTES_PATH', ROOT_PATH . 'routes/');

// --- 1. Autoloading ---
// Memuat class dari folder core/, controllers/, dan models/
spl_autoload_register(function ($class) {
    $filename = $class . '.php';
    
    // Konvensi: Jika nama file adalah Controller atau Model, cari di folder yang sesuai
    $dirs = [
        'core/',
        'cms/controllers/', 
        'cms/models/',    // UserModel ada di sini
        'profile/controllers/',
        'profile/models/',
    ];
    
    foreach ($dirs as $dir) {
        $path = APP_PATH . $dir . $filename;
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});


// --- 2. Koneksi Database ---
// File koneksi.php akan membuat variabel $conn
require_once APP_PATH . 'config/koneksi.php'; 
// PASTIKAN koneksi.php TIDAK MENGANDUNG ECHO APAPUN!


// --- 3. Routing ---
$router = new Router($conn); // KIRIM $conn ke Router

// Muat definisi rute
require_once ROUTES_PATH . 'web.php';

// Ambil URI dari .htaccess
$uri = isset($_GET['url']) ? $_GET['url'] : '';

// Eksekusi Router
$router->dispatch($uri);
?>