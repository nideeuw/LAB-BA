<?php

class AuthController extends Controller
{
    public function login($conn)
    {
        if (isset($_SESSION['user_id'])) {
            redirect('/cms/dashboard');
        }

        $viewPath = 'cms/views/auth/login';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $user = UserModel::login($username, $password, $conn);

            if ($user) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['username'];
                $_SESSION['user_email'] = $user['email'] ?? '';
                
                // Redirect pakai helper
                redirect('/cms/dashboard');
            } else {
                $error = "Username atau password salah!";
                $this->view($viewPath, [
                    'error' => $error,
                    'base_url' => getBaseUrl()
                ]);
            }
        } else {
            $this->view($viewPath, [
                'base_url' => getBaseUrl()
            ]);
        }
    }

    public function logout($conn)
    {
        // HAPUS: session_start(); ← JANGAN PAKAI INI!
        
        session_unset();
        session_destroy();
        
        // Redirect pakai helper
        redirect('/cms/login'); // ← PAKAI INI
    }
}
?>