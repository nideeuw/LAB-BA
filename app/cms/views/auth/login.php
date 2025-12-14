<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LAB-BA | Login</title>
  <link href="<?php echo $base_url; ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo $base_url; ?>/assets/css/login.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="animated-bg">
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
  </div>

  <div class="container-fluid login-container">
    <div class="row h-100 g-0 w-100">

      <div class="col-md-6 login-form-section">
        <div class="login-form-wrapper">
          
          <div class="logo-container animate-fade-in">
            <img src="<?php echo $base_url; ?>/assets/img/logo_black.png" alt="LAB-BA Logo" class="img-fluid logo-img">
            <h2 class="welcome-text">Welcome!</h2>
            <p class="subtitle">Sign in to continue to your dashboard</p>
          </div>

          <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show animate-shake" role="alert">
              <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <form action="" method="POST" class="login-form animate-slide-up" id="loginForm">
            
            <div class="form-group mb-3">
              <label for="username" class="form-label">
                <i class="fas fa-user me-2"></i>Username
              </label>
              <div class="input-group">
                <span class="input-group-text bg-white">
                  <i class="fas fa-user text-primary"></i>
                </span>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
              </div>
            </div>

            <div class="form-group mb-4">
              <label for="password" class="form-label">
                <i class="fas fa-lock me-2"></i>Password
              </label>
              <div class="input-group">
                <span class="input-group-text bg-white">
                  <i class="fas fa-lock text-primary"></i>
                </span>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                  <i class="fas fa-eye" id="eyeIcon"></i>
                </button>
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-login mb-3" id="loginBtn">
              <span class="btn-text">Login</span>
              <span class="spinner-border spinner-border-sm d-none" role="status">
                <span class="visually-hidden">Loading...</span>
              </span>
            </button>

          </form>

          <div class="login-footer animate-fade-in">
            <p class="mb-0 text-muted">
              <i class="fas fa-shield-alt me-2"></i>
              Secured by LAB-BA © <?php echo date('Y'); ?>
            </p>
          </div>

        </div>
      </div>

      <div class="col-md-6 login-image-section">
        <div class="mascot-container animate-float">
          <img src="<?php echo $base_url; ?>/assets/img/maskot.png" alt="LAB-BA Mascot" class="img-fluid mascot-img">
        </div>
        
        <div class="decorative-circle circle-1"></div>
        <div class="decorative-circle circle-2"></div>
        <div class="decorative-circle circle-3"></div>
      </div>

    </div>
  </div>

  <script src="<?php echo $base_url; ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function() {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      
      if (type === 'password') {
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
      } else {
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
      }
    });

    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    const btnText = loginBtn.querySelector('.btn-text');
    const spinner = loginBtn.querySelector('.spinner-border');

    loginForm.addEventListener('submit', function(e) {
      loginBtn.disabled = true;
      btnText.classList.add('d-none');
      spinner.classList.remove('d-none');
    });

    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('username').focus();
    });
  </script>

</body>
</html>