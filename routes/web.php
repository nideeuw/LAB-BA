<?php
// Pastikan variabel $router sudah di-instantiate di index.php

// Rute Publik (Profile)
$router->add('/', 'profile/Home/index');
$router->add('/gallery', 'profile/Gallery/index');

// Rute CMS (Admin)
$router->add('/cms/login', 'cms/Auth/login');
$router->add('/cms/dashboard', 'cms/Dashboard/index');
$router->add('/cms/logout', 'cms/Auth/logout');

// Rute tambahan (jika ada)
// $router->add('/cms/users', 'cms/User/list');

?>