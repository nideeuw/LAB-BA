<?php
require_once 'app/profile/controllers/ProfileController.php';

$controller = new ProfileController();

// routing sederhana berdasarkan parameter "page"
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        $controller->home();
        break;

    case 'about':
        $controller->about();
        break;

    case 'contact':
        $controller->contact();
        break;

    case 'gallery':
        $controller->gallery();
        break;

    case 'members':
        $controller->members();
        break;

    case 'visi_misi':
        $controller->visi_misi();
        break;

    default:
        echo "404 Not Found";
        break;
}
