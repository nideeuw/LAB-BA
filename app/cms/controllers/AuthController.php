<?php
// require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller
{
    public function login($conn)
    {
        session_start();
        $viewPath = 'cms/views/auth/login';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $user = UserModel::login($username, $password, $conn);

            if ($user) {
                $_SESSION['user'] = $user;

                header('Location: /LAB-BA/cms/dashboard');
                exit;
            } else {
                $error = "Username atau password salah!";
                $this->view($viewPath, ['error' => $error]);
                
            }
        } else {
            $this->view($viewPath);
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /LAB-BA/cms/login');
        exit;
    }
}
?>