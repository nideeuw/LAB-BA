<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function loadEnv($file) {
    $env = [];
 
    if (!file_exists($file)) {
        die("File .env tidak ditemukan di path: " . $file);
    }
    
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        $line = trim($line);
        
        if (strpos($line, '#') === 0 || empty($line)) continue;
        
        list($key, $value) = explode('=', $line, 2);
        
        $env[trim($key)] = trim($value);
        $_ENV[trim($key)] = trim($value);
    }
    
    return $env;
}

$envFilePath = __DIR__ . '/../../.env';

if (!file_exists($envFilePath)) {
    die("File .env tidak ditemukan di path: " . $envFilePath);
}

$env = loadEnv($envFilePath);

$dbHost = $env['DB_HOST'];
$dbPort = $env['DB_PORT'];
$dbName = $env['DB_NAME'];
$dbUser = $env['DB_USER'];
$dbPassword = $env['DB_PASSWORD'];

try {
    // Create PDO connection for PostgreSQL
    $dsn = "pgsql:host={$dbHost};port={$dbPort};dbname={$dbName}";
    $conn = new PDO($dsn, $dbUser, $dbPassword);
    
    // Set error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Set PostgreSQL to use UTF-8
    $conn->exec("SET NAMES 'UTF8'");
    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

date_default_timezone_set('Asia/Jakarta');

function redirect($url) {
    // Ambil base URL dari protokol dan host
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    
    // Ambil base path (nama folder root)
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $basePath = str_replace('/index.php', '', $scriptName);
    
    // Build full URL
    $fullUrl = $protocol . '://' . $host . $basePath . $url;
    
    header("Location: " . $fullUrl);
    exit();
}

function checkLogin() {
    if(!isset($_SESSION['user_id'])) {
        redirect('/cms/login');
    }
}

function setFlash($type, $message) {
    $_SESSION['flash_type'] = $type;
    $_SESSION['flash_message'] = $message;
}

function getFlash() {
    if(isset($_SESSION['flash_message'])) {
        $type = $_SESSION['flash_type'];
        $message = $_SESSION['flash_message'];
        
        unset($_SESSION['flash_type']);
        unset($_SESSION['flash_message']);
        
        return ['type' => $type, 'message' => $message];
    }
    return null;
}

function clean($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function formatTanggal($date) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    $timestamp = strtotime($date);
    $d = date('d', $timestamp);
    $m = date('n', $timestamp);
    $y = date('Y', $timestamp);
    
    return $d . ' ' . $bulan[$m] . ' ' . $y;
}

function generateToken($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

function getBaseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $basePath = str_replace('/index.php', '', $scriptName);
    
    return $protocol . '://' . $host . $basePath;
}

// Return connection
return $conn;
?>