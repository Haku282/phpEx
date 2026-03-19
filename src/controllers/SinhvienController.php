<?php
// src/Controllers/SinhvienController.php 
namespace Vohoq\Bai01QuanlySv\Controllers;

use Vohoq\Bai01QuanlySv\Models\SinhvienModel;

class SinhvienController
{
    private $sinhvienModel;

    public function __construct()
    {
        $this->sinhvienModel = new SinhvienModel();
    }

    // Hiển thị danh sách sinh viên 
    public function index()
    {
        $students = $this->sinhvienModel->getAllStudents();
        // Nạp file view để hiển thị 
        require_once __DIR__ . '/../../views/sinhvien_list.php';
    }

    // Xử lý thêm sinh viên 
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';

            if (
                !empty($name) && !empty($email) &&
                !empty($phone)
            ) {
                $this->sinhvienModel->addStudent(
                    $name,
                    $email,
                    $phone
                );
            }
        }
        // Sau khi thêm, chuyển hướng về trang danh sách 
        header('Location: index.php');
        exit();
    }
    // PHƯƠNG THỨC MỚI: Hiển thị form chỉnh sửa (bài 03)
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            // Nếu không có id, chuyển hướng về trang chủ
            header('Location: index.php');
            exit();
        }
        // Gọi model để lấy thông tin sinh viên
        $student = $this->sinhvienModel->getStudentById($id);
        // Nạp file view để hiển thị form
        require_once __DIR__ . '/../../views/sinhvien_edit.php';
    }
    // PHƯƠNG THỨC MỚI: Xử lý cập nhật dữ liệu (bài 03)
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            if (
                $id && !empty($name) && !empty($email) &&

                !empty($phone)
            ) {

                $this->sinhvienModel->updateStudent(
                    $id,
                    $name,

                    $email,
                    $phone
                );
            }
        }
        // Sau khi cập nhật, chuyển hướng về trang danh sách
        header('Location: index.php');
        exit();
    }
    // PHƯƠNG THỨC MỚI: Xử lý xóa sinh viên
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            // Nếu không có id, không làm gì cả và quay về trang chủ

            header('Location: index.php');
            exit();
        }
        // Gọi model để thực hiện xóa
        $this->sinhvienModel->deleteStudent($id);
        // Sau khi xóa, chuyển hướng người dùng về lại trang danh sách

        header('Location: index.php');
        exit();
    }
}
