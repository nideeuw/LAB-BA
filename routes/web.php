<?php
/**
 * Routes Configuration
 * File: routes/web.php
 */

// Pastikan variabel $router sudah di-instantiate di index.php

// ========== Rute Publik (Profile/Landing Page) ==========
$router->add('/', 'profile/Home/index');
$router->add('/gallery', 'profile/Gallery/index');
$router->add('/members', 'profile/Members/index');
$router->add('/members/detail/{id}', 'profile/Members/detail');

// ========== Rute CMS (Admin Panel) ==========

// Authentication
$router->add('/cms/login', 'cms/Auth/login'); 
$router->add('/cms/logout', 'cms/Auth/logout'); 

// Dashboard
$router->add('/cms/dashboard', 'cms/Dashboard/index');

// Menu Management
$router->add('/cms/menu', 'cms/Menu/index');
$router->add('/cms/menu/create', 'cms/Menu/create');
$router->add('/cms/menu/store', 'cms/Menu/store');
$router->add('/cms/menu/edit/{id}', 'cms/Menu/edit');
$router->add('/cms/menu/update/{id}', 'cms/Menu/update');
$router->add('/cms/menu/delete/{id}', 'cms/Menu/delete');
$router->add('/cms/menu/toggle/{id}', 'cms/Menu/toggle');

// Users Management
$router->add('/cms/users', 'cms/Users/index');
$router->add('/cms/users/create', 'cms/Users/create');
$router->add('/cms/users/edit/{id}', 'cms/Users/edit');
$router->add('/cms/users/update/{id}', 'cms/Users/update');
$router->add('/cms/users/delete', 'cms/Users/delete');

// Role Management
$router->add('/cms/role', 'cms/Role/index');
$router->add('/cms/role/create', 'cms/Role/create');
$router->add('/cms/role/edit/{id}', 'cms/Role/edit');
$router->add('/cms/role/delete', 'cms/Role/delete');

// Members Management
$router->add('/cms/members', 'cms/Members/index');
$router->add('/cms/members/add', 'cms/Members/add');
$router->add('/cms/members/edit/{id}', 'cms/Members/edit');
$router->add('/cms/members/update/{id}', 'cms/Members/update');
$router->add('/cms/members/delete', 'cms/Members/delete');

// Gallery Management
$router->add('/cms/gallery', 'cms/Gallery/index');
$router->add('/cms/gallery/add', 'cms/Gallery/add');
$router->add('/cms/gallery/edit/{id}', 'cms/Gallery/edit');
$router->add('/cms/gallery/delete', 'cms/Gallery/delete');

// Banner Management
$router->add('/cms/banner', 'cms/Banner/index');
$router->add('/cms/banner/add', 'cms/Banner/add');
$router->add('/cms/banner/edit/{id}', 'cms/Banner/edit');
$router->add('/cms/banner/delete', 'cms/Banner/delete');

// News Activity Management
$router->add('/cms/news-activity', 'cms/NewsActivity/index');
$router->add('/cms/news-activity/add', 'cms/NewsActivity/add');
$router->add('/cms/news-activity/edit', 'cms/NewsActivity/edit');
$router->add('/cms/news-activity/delete', 'cms/NewsActivity/delete');

// Lab Booking Management
$router->add('/cms/lab_bookings', 'cms/LabBookings/index');
$router->add('/cms/lab_bookings/add', 'cms/LabBookings/add');
$router->add('/cms/lab_bookings/store', 'cms/LabBookings/store');
$router->add('/cms/lab_bookings/edit/{id}', 'cms/LabBookings/edit');
$router->add('/cms/lab_bookings/update/{id}', 'cms/LabBookings/update');
$router->add('/cms/lab_bookings/delete/{id}', 'cms/LabBookings/delete');
$router->add('/cms/lab_bookings/approve', 'cms/LabBookings/approve');
$router->add('/cms/lab_bookings/reject', 'cms/LabBookings/reject');

// Visi Misi Management
$router->add('/cms/visi-misi', 'cms/VisiMisi/index');
$router->add('/cms/visi-misi/edit/{id}', 'cms/VisiMisi/edit');

// Contact Management
$router->add('/cms/contact', 'cms/Contact/index');
$router->add('/cms/contact/view', 'cms/Contact/view');
$router->add('/cms/contact/reply', 'cms/Contact/reply');
$router->add('/cms/contact/delete', 'cms/Contact/delete');

// Profile & Settings
$router->add('/cms/profile', 'cms/Profile/index');
$router->add('/cms/profile/edit/{id}', 'cms/Profile/edit');
$router->add('/cms/settings', 'cms/Settings/index');

?>