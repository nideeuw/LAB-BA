<?php

class ProfileController
{
    public function home()
    {
        require_once __DIR__ . '/../views/home.php';
    }

    public function about()
    {
        require_once __DIR__ . '/../views/about.php';
    }

    public function contact()
    {
        require_once __DIR__ . '/../views/contact.php';
    }

    public function gallery()
    {
        require_once __DIR__ . '/../views/gallery.php';
    }

    public function members()
    {
        require_once __DIR__ . '/../views/members.php';
    }

    public function visi_misi()
    {
        require_once __DIR__ . '/../views/visi_misi.php';
    }
}
