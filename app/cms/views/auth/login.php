<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LAB-BA | Login</title>
  <!-- Style -->
  <link href="/LAB-BA/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/LAB-BA/assets/css/login.css" rel="stylesheet">
</head>

<body>
  <div class="container-fluid login-container d-flex">
    <div class="row">
      <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
      <!-- Left side: Login Form -->
      <div class="col-6 login-form-section">
        <form action="" method="POST">
          <div class="text-center">
            <img src="/LAB-BA/assets/img/logo_black.png" alt="LAB-BA Logo" class="img-fluid" style="max-width: 250px;">
          </div>

          <div class="form-group mb-3">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
          </div>

          <div class="form-group mb-4">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          </div>

          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>

      <!-- Right side: Image -->
      <div class="col-6 login-image-section">
        <img src="/LAB-BA/assets/img/maskot.png" alt="Login Image" class="img-fluid">
      </div>
    </div>
  </div>
  </div>
</body>

</html>