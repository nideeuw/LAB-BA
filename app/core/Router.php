<?php
// app/core/Router.php

class Router {
    protected $routes = [];
    protected $conn; // Menyimpan koneksi database

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function add($uri, $controller) {
        $this->routes['/' . trim($uri, '/')] = $controller;
    }

    public function dispatch($uri) {
        $uri = '/' . trim($uri, '/');

        // Jika URI tidak ada di rute yang terdaftar, cek apakah itu root '/'
        if ($uri === '/' && isset($this->routes['/'])) {
            $target = $this->routes['/'];
        } elseif (array_key_exists($uri, $this->routes)) {
            $target = $this->routes[$uri];
        } else {
            // Logika 404
            header("HTTP/1.0 404 Not Found");
            die("404 - Halaman tidak ditemukan: " . htmlspecialchars($uri));
        }
        
        // Memecah target (misal: cms/Auth/login)
        $parts = explode('/', $target);
        $modul = array_shift($parts); // cms
        $controllerName = ucfirst(array_shift($parts)) . 'Controller'; // AuthController
        $methodName = array_shift($parts); // login
        
        // Panggil Controller
        if (class_exists($controllerName)) {
            $controllerInstance = new $controllerName();
            
            if (method_exists($controllerInstance, $methodName)) {
                // Panggil method, kirim $conn (WAJIB KARENA AuthController::login MEMERLUKANNYA)
                call_user_func_array([$controllerInstance, $methodName], [$this->conn]); 
                return;
            }
        }

        // Logika 404 jika Controller/Method tidak ada
        header("HTTP/1.0 404 Not Found");
        die("404 - Controller/Method tidak ditemukan.");
    }
}
?>