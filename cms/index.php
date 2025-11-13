<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../app/config/koneksi.php';
require_once '../app/cms/controllers/AuthController.php';

$authController = new AuthController();
$authController->login($conn);