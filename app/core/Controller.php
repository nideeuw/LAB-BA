<?php
// app/core/Controller.php

class Controller
{
    // Definisikan properti untuk BASE_PATH dan APP_PATH
    protected $basePath;
    protected $appPath;

    public function __construct()
    {
        // Ambil nilai dari constant global.
        // Asumsi APP_PATH sudah didefinisikan di index.php
        if (defined('APP_PATH')) {
            $this->appPath = APP_PATH;
        } else {
            // Ini akan memastikan APP_PATH tersedia bahkan jika index.php tidak dijalankan
            // Anda perlu memastikan path ini benar relatif dari Controller.php
            $this->appPath = __DIR__ . '/../';
        }
    }

    // Fungsi helper untuk memuat View
    protected function view($viewPath, $data = [])
    {
        // Ubah data array menjadi variabel (agar $data['user'] menjadi $user)
        extract($data);

        // Memuat View dari path yang benar
        $fullPath = $this->appPath . $viewPath . '.php';

        if (file_exists($fullPath)) {
            include $fullPath;
        } else {
            // Error handling jika View tidak ditemukan
            die("View not found: " . $fullPath);
        }
    }
}
