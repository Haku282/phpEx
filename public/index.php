<?php 
// public/index.php 
// Nạp file autoload của Composer 
require_once __DIR__ . '/../vendor/autoload.php'; 
use Vohoq\Bai01QuanlySv\Controllers\SinhvienController; 
// Simple Router 
$action = $_GET['action'] ?? 'index'; 
$controller = new SinhvienController(); 
switch ($action) { 
case 'add': 
$controller->add(); 
break; 
case 'index': 
default: 
$controller->index(); 
break; 
}