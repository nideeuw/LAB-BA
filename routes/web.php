<?php

/**
 * Routes Configuration
 * File: routes/web.php
 */

// ========== Rute Publik (Profile/Landing Page) ==========
$router->add('/', 'profile/Home/index');
$router->add('search', 'profile/search/index');
$router->add('/members', 'profile/Members/index');
$router->add('/members/detail/{id}', 'profile/Members/detail');
$router->add('/gallery', 'profile/Gallery/index');
$router->add('/lab_bookings', 'profile/LabBookings/index');
$router->add('/lab_bookings/create', 'profile/LabBookings/create');
$router->add('/lab_bookings/store', 'profile/LabBookings/store');
$router->add('/lab_bookings/bookings', 'profile/LabBookings/bookings');
$router->add('/lab_bookings/register', 'profile/LabBookings/register');
$router->add('/lab_bookings/register-store', 'profile/LabBookings/registerStore');
$router->add('/lab_bookings/cancel', 'profile/LabBookings/cancel');

// ========== Rute CMS (Admin Panel) ==========

// Authentication
$router->add('/cms/login', 'cms/Auth/login');
$router->add('/cms/logout', 'cms/Auth/logout');

// Search
$router->add('cms/search', 'cms/search/index');

// Dashboard
$router->add('/cms/dashboard', 'cms/Dashboard/index');

// Banner Management
$router->add('/cms/banner', 'cms/Banner/index');
$router->add('/cms/banner/add', 'cms/Banner/add');
$router->add('/cms/banner/store', 'cms/Banner/store');
$router->add('/cms/banner/edit/{id}', 'cms/Banner/edit');
$router->add('/cms/banner/update/{id}', 'cms/Banner/update');
$router->add('/cms/banner/delete/{id}', 'cms/Banner/delete');

// Profile Lab (About Us)
$router->add('/cms/profile_lab', 'cms/ProfileLab/index');
$router->add('/cms/profile_lab/add', 'cms/ProfileLab/add');
$router->add('/cms/profile_lab/store', 'cms/ProfileLab/store');
$router->add('/cms/profile_lab/edit/{id}', 'cms/ProfileLab/edit');
$router->add('/cms/profile_lab/update/{id}', 'cms/ProfileLab/update');
$router->add('/cms/profile_lab/delete/{id}', 'cms/ProfileLab/delete');
$router->add('/cms/profile_lab/set-active/{id}', 'cms/ProfileLab/setActive');

// Visi & Misi
$router->add('/cms/visi_misi', 'cms/VisiMisi/index');
$router->add('/cms/visi_misi/add', 'cms/VisiMisi/add');
$router->add('/cms/visi_misi/store', 'cms/VisiMisi/store');
$router->add('/cms/visi_misi/edit/{id}', 'cms/VisiMisi/edit');
$router->add('/cms/visi_misi/update/{id}', 'cms/VisiMisi/update');
$router->add('/cms/visi_misi/delete/{id}', 'cms/VisiMisi/delete');

// Roadmap
$router->add('/cms/roadmap', 'cms/Roadmap/index');
$router->add('/cms/roadmap/add', 'cms/Roadmap/add');
$router->add('/cms/roadmap/store', 'cms/Roadmap/store');
$router->add('/cms/roadmap/edit/{id}', 'cms/Roadmap/edit');
$router->add('/cms/roadmap/update/{id}', 'cms/Roadmap/update');
$router->add('/cms/roadmap/delete/{id}', 'cms/Roadmap/delete');

// Research Focus
$router->add('/cms/research_focus', 'cms/ResearchFocus/index');
$router->add('/cms/research_focus/add', 'cms/ResearchFocus/add');
$router->add('/cms/research_focus/store', 'cms/ResearchFocus/store');
$router->add('/cms/research_focus/edit/{id}', 'cms/ResearchFocus/edit');
$router->add('/cms/research_focus/update/{id}', 'cms/ResearchFocus/update');
$router->add('/cms/research_focus/delete/{id}', 'cms/ResearchFocus/delete');

// Research Scope
$router->add('cms/research_scope', 'cms/ResearchScope/index');
$router->add('cms/research_scope/add', 'cms/ResearchScope/add');
$router->add('cms/research_scope/store', 'cms/ResearchScope/store');
$router->add('cms/research_scope/edit/{id}', 'cms/ResearchScope/edit');
$router->add('cms/research_scope/update/{id}', 'cms/ResearchScope/update');
$router->add('cms/research_scope/delete/{id}', 'cms/ResearchScope/delete');

// Gallery Management
$router->add('/cms/gallery', 'cms/Gallery/index');
$router->add('/cms/gallery/add', 'cms/Gallery/add');
$router->add('/cms/gallery/store', 'cms/Gallery/store');
$router->add('/cms/gallery/edit/{id}', 'cms/Gallery/edit');
$router->add('/cms/gallery/update/{id}', 'cms/Gallery/update');
$router->add('/cms/gallery/delete/{id}', 'cms/Gallery/delete');

// Members Management
$router->add('/cms/members', 'cms/Members/index');
$router->add('/cms/members/add', 'cms/Members/add');
$router->add('/cms/members/store', 'cms/Members/store');
$router->add('/cms/members/edit/{id}', 'cms/Members/edit');
$router->add('/cms/members/update/{id}', 'cms/Members/update');
$router->add('/cms/members/delete/{id}', 'cms/Members/delete');


// Publications Management
$router->add('/cms/publications', 'cms/Publications/index');
$router->add('/cms/publications/add', 'cms/Publications/add');
$router->add('/cms/publications/store', 'cms/Publications/store');
$router->add('/cms/publications/edit/{id}', 'cms/Publications/edit');
$router->add('/cms/publications/update/{id}', 'cms/Publications/update');
$router->add('/cms/publications/delete/{id}', 'cms/Publications/delete');

// Researches Management
$router->add('/cms/researches', 'cms/Researches/index');
$router->add('/cms/researches/add', 'cms/Researches/add');
$router->add('/cms/researches/store', 'cms/Researches/store');
$router->add('/cms/researches/edit/{id}', 'cms/Researches/edit');
$router->add('/cms/researches/update/{id}', 'cms/Researches/update');
$router->add('/cms/researches/delete/{id}', 'cms/Researches/delete');

// Lab Bookings Management
$router->add('/cms/lab_bookings', 'cms/LabBookings/index');
$router->add('/cms/lab_bookings/add', 'cms/LabBookings/add');
$router->add('/cms/lab_bookings/store', 'cms/LabBookings/store');
$router->add('/cms/lab_bookings/edit/{id}', 'cms/LabBookings/edit');
$router->add('/cms/lab_bookings/update/{id}', 'cms/LabBookings/update');
$router->add('/cms/lab_bookings/delete/{id}', 'cms/LabBookings/delete');
$router->add('/cms/lab_bookings/approve/{id}', 'cms/LabBookings/approve');
$router->add('/cms/lab_bookings/reject', 'cms/LabBookings/reject');

// User Bookings Management
$router->add('/cms/user_bookings', 'cms/UserBookings/index');
$router->add('/cms/user_bookings/add', 'cms/UserBookings/add');
$router->add('/cms/user_bookings/store', 'cms/UserBookings/store');
$router->add('/cms/user_bookings/edit/{id}', 'cms/UserBookings/edit');
$router->add('/cms/user_bookings/update/{id}', 'cms/UserBookings/update');
$router->add('/cms/user_bookings/delete/{id}', 'cms/UserBookings/delete');

// Contact Management
$router->add('/cms/contact', 'cms/Contact/index');
$router->add('/cms/contact/add', 'cms/Contact/add');
$router->add('/cms/contact/store', 'cms/Contact/store');
$router->add('/cms/contact/edit/{id}', 'cms/Contact/edit');
$router->add('/cms/contact/update/{id}', 'cms/Contact/update');
$router->add('/cms/contact/delete/{id}', 'cms/Contact/delete');
$router->add('/cms/contact/set-active/{id}', 'cms/Contact/setActive');

// Users Management
$router->add('/cms/users', 'cms/Users/index');
$router->add('/cms/users/create', 'cms/Users/create');
$router->add('/cms/users/store', 'cms/Users/store');
$router->add('/cms/users/edit/{id}', 'cms/Users/edit');
$router->add('/cms/users/update/{id}', 'cms/Users/update');
$router->add('/cms/users/delete/{id}', 'cms/Users/delete');

// Role Management
$router->add('/cms/role', 'cms/Role/index');
$router->add('/cms/role/create', 'cms/Role/create');
$router->add('/cms/role/edit/{id}', 'cms/Role/edit');
$router->add('/cms/role/delete/{id}', 'cms/Role/delete');
$router->add('/cms/role/toggle/{id}', 'cms/Role/toggle');

// Menu Management
$router->add('/cms/menu', 'cms/Menu/index');
$router->add('/cms/menu/create', 'cms/Menu/create');
$router->add('/cms/menu/store', 'cms/Menu/store');
$router->add('/cms/menu/edit/{id}', 'cms/Menu/edit');
$router->add('/cms/menu/update/{id}', 'cms/Menu/update');
$router->add('/cms/menu/delete/{id}', 'cms/Menu/delete');
$router->add('/cms/menu/toggle/{id}', 'cms/Menu/toggle');