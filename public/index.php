<?php
// public/index.php 
session_start();
// Nạp file autoload của Composer 
require_once __DIR__ . '/../vendor/autoload.php';

use vohoq\Bai01QuanlySv\Controllers\SinhvienController;
use vohoq\Bai01QuanlySv\Controllers\UserController;
use vohoq\Bai01QuanlySv\Controllers\PageController;
// Simple Router 
$action = $_GET['action'] ?? 'index';
// Danh sách các action được bảo vệ (yêu cầu đăng nhập)
$protected_actions = [
    'index',
    'edit',
    'update',
    'delete',
    'add',
    'dashboard'
];
if (
    in_array($action, $protected_actions) &&
    !isset($_SESSION['user_id'])
) {
    header('Location: index.php?action=login');
    exit();
}
// Danh sách các action không yêu cầu đăng nhập
$public_actions = ['login', 'register', 'do_login', 'do_register', 'contact', 'submit_contact'];
// Khởi tạo controller dựa trên action
if (in_array($action, [
    'login',
    'register',
    'do_login',
    'do_register',
    'logout'
])) {
    $controller = new UserController();
} elseif (in_array($action, ['contact', 'submit_contact'])) { // <--THÊM ELSEIF
    $controller = new PageController();
} else {
    $controller = new SinhvienController();
}
switch ($action) {
    case 'dashboard':
        $controller->dashboard();
        break;
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
        $controller->index();
        break;
    case 'contact':
        $controller->showContactForm();
        break;
    case 'submit_contact':
        $controller->submitContact();
        break;
    default:
        $controller = new SinhvienController();
        $controller->index();
        break;
}
