<?php

class AuthController extends Controller
{
    /**
     * Login method - SIMPLE VERSION untuk tugas kuliah
     * Security: Basic tapi sudah cukup aman
     */
    public function login($conn)
    {
        // Redirect jika sudah login
        if (isset($_SESSION['user_id'])) {
            redirect('/cms/dashboard');
        }

        $viewPath = 'cms/views/auth/login';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // ====================================
            // 1. AMBIL INPUT DARI FORM
            // ====================================
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            // ====================================
            // 2. VALIDASI SEDERHANA
            // ====================================
            
            // Cek username tidak kosong
            if (empty($username)) {
                $error = "Username tidak boleh kosong!";
                $this->view($viewPath, [
                    'error' => $error,
                    'base_url' => getBaseUrl()
                ]);
                return;
            }

            // Cek password tidak kosong
            if (empty($password)) {
                $error = "Password tidak boleh kosong!";
                $this->view($viewPath, [
                    'error' => $error,
                    'base_url' => getBaseUrl()
                ]);
                return;
            }

            // ====================================
            // 3. CEK KE DATABASE
            // ====================================
            // UserModel sudah pakai prepared statement (aman dari SQL Injection)
            // UserModel sudah pakai password_verify (aman, password di-hash)
            $user = UserModel::login($username, $password, $conn);

            if ($user) {
                // ====================================
                // 4. LOGIN BERHASIL
                // ====================================
                
                // Regenerate session ID (security basic)
                // Ini penting untuk mencegah session fixation
                session_regenerate_id(true);

                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['username'];
                $_SESSION['user_email'] = $user['email'] ?? '';
                
                // Redirect ke dashboard
                redirect('/cms/dashboard');
                
            } else {
                // ====================================
                // 5. LOGIN GAGAL
                // ====================================
                $error = "Username atau password salah!";
                $this->view($viewPath, [
                    'error' => $error,
                    'base_url' => getBaseUrl()
                ]);
            }
            
        } else {
            // GET request - tampilkan form login
            $this->view($viewPath, [
                'base_url' => getBaseUrl()
            ]);
        }
    }

    /**
     * Logout method
     */
    public function logout($conn)
    {
        // Hapus semua data session
        session_unset();
        
        // Destroy session
        session_destroy();
        
        // Redirect ke login
        redirect('/cms/login');
    }
}
?>