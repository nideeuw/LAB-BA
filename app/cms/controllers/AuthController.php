<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    public function login($conn)
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $user = UserModel::login($username, $password, $conn);

            if ($user) {
                $_SESSION['user'] = $user;

                header('Location: /LAB-BA/app/cms/views/dashboard.php');
                exit;
            } else {
                $error = "Username atau password salah!";
                include __DIR__ . '/../views/auth/login.php';
                
            }
        } else {
            include __DIR__ .'/../views/auth/login.php';
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /LAB-BA/cms/');
        exit;
    }
}
