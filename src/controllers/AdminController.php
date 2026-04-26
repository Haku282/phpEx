<?php
// src/Controllers/AdminController.php
namespace vohoq\Bai01QuanlySv\Controllers;

use vohoq\Bai01QuanlySv\Models\LogModel;

class AdminController
{
    private $logModel;
    public function __construct()
    {
        $this->logModel = new LogModel();
    }
    /**
     * Hiển thị trang log hoạt động (giống SinhvienController::index)
     */
    public function showLogs()
    {
        // --- CÀI ĐẶT CÁC BIẾN PHÂN TRANG ---
        $recordsPerPage = 20; // Hiển thị 20 log mỗi trang
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($currentPage < 1) $currentPage = 1;
        $offset = ($currentPage - 1) * $recordsPerPage;
        // --- GỌI MODEL ---
        $result = $this->logModel->getLogs($recordsPerPage, $offset);
        $logs = $result['data'];
        $totalRecords = $result['total'];
        // --- TÍNH TOÁN SỐ TRANG ---
        $totalPages = ceil($totalRecords / $recordsPerPage);
        // --- NẠP VIEW VÀ TRUYỀN DỮ LIỆU ---
        require_once __DIR__ . '/../../views/admin/logs.php';
    }
}
