<?php 
// src/Controllers/SinhvienController.php 
namespace Vohoq\Bai01QuanlySv\Controllers; 
 
use Vohoq\Bai01QuanlySv\Models\SinhvienModel; 
 
class SinhvienController { 
    private $sinhvienModel; 
 
    public function __construct() { 
        $this->sinhvienModel = new SinhvienModel(); 
    } 
 
    // Hiển thị danh sách sinh viên 
    public function index() { 
        $students = $this->sinhvienModel->getAllStudents(); 
        // Nạp file view để hiển thị 
        require_once __DIR__ . '/../../views/sinhvien_list.php'; 
    } 
 
    // Xử lý thêm sinh viên 
    public function add() { 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            $name = $_POST['name'] ?? ''; 
            $email = $_POST['email'] ?? ''; 
            $phone = $_POST['phone'] ?? ''; 
 
            if (!empty($name) && !empty($email) && 
!empty($phone)) { 
                $this->sinhvienModel->addStudent($name, $email, 
$phone); 
            } 
        } 
        // Sau khi thêm, chuyển hướng về trang danh sách 
        header('Location: index.php'); 
        exit(); 
    } 
} 