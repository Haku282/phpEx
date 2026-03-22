<?php
// public/index.php 
session_start();
// Nạp file autoload của Composer 
require_once __DIR__ . '/../vendor/autoload.php';

use Vohoq\Bai01QuanlySv\Controllers\SinhvienController;
use Vohoq\Bai01QuanlySv\Controllers\UserController;
// Simple Router 
$action = $_GET['action'] ?? 'index';
// Danh sách các action không yêu cầu đăng nhập
$public_actions = ['login', 'register', 'do_login', 'do_register'];
// Khởi tạo controller dựa trên action
if (in_array($action, [
    'login',
    'register',
    'do_login',
    'do_register',
    'logout'
])) {
    $controller = new UserController();
} else {
    $controller = new SinhvienController();
}
switch ($action) {
    case 'add':
        $controller->add();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'update':
        $controller->update();
        break;
    // THÊM CASE MỚI
    case 'delete':
        $controller->delete();
        break;
    // Các action của UserController
    case 'login':
        $controller->showLoginForm();
        break;
    case 'do_login':
        $controller->login();
        break;
    case 'register':
        $controller->showRegisterForm();
        break;
    case 'do_register':
        $controller->register();
        break;
    case 'logout':
        $controller->logout();
        break;
    case 'index':
    default:
        $controller = new SinhvienController();
        $controller->index();
        break;
}
