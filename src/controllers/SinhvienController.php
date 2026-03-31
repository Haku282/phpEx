<?php
// src/Controllers/SinhvienController.php 
namespace vohoq\Bai01QuanlySv\Controllers;

use vohoq\Bai01QuanlySv\Models\SinhvienModel;
use vohoq\Bai01QuanlySv\Core\FlashMessage;

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
        // --- CÀI ĐẶT CÁC BIẾN PHÂN TRANG ---
        $recordsPerPage = 5; // Số sinh viên mỗi trang
        $currentPage = isset($_GET['page']) ?
            (int)$_GET['page'] : 1;
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $offset = ($currentPage - 1) * $recordsPerPage;
        // --- XỬ LÝ TÌM KIẾM ---
        $keyword = $_GET['keyword'] ?? null;
        // --- GỌI MODEL ---
        $result = $this->sinhvienModel->getStudents(
            $keyword,
            $recordsPerPage,
            $offset
        );
        $students = $result['data'];
        $totalRecords = $result['total'];
        // --- TÍNH TOÁN SỐ TRANG ---
        $totalPages = ceil($totalRecords / $recordsPerPage);
        require_once __DIR__ . '/../../views/sinhvien_list.php';
    }

    // Xử lý thêm sinh viên 
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $course = $_POST['course'] ?? '';
            $class_name = $_POST['class_name'] ?? '';
            $major = $_POST['major'] ?? '';

            if (
                !empty($name) && !empty($email) &&

                !empty($phone)
            ) {

                // Xử lý upload avatar nếu có
                $avatarFilename = null;
                if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../../public/upload/avatars/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    $tmpName = $_FILES['avatar']['tmp_name'];
                    $origName = basename($_FILES['avatar']['name']);
                    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
                    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                    if (in_array($ext, $allowed) && is_uploaded_file($tmpName)) {
                        $avatarFilename = $origName;
                        $dest = $uploadDir . $avatarFilename;
                        if (!move_uploaded_file($tmpName, $dest)) {
                            $avatarFilename = null;
                        }
                    }
                }

                $this->sinhvienModel->addStudent($name, $email, $phone, $course, $class_name, $major, $avatarFilename);

                // Đặt thông báo thành công
                FlashMessage::set('student_action', 'Thêm sinh viên thành công!', 'success');
            } else {
                // Đặt thông báo lỗi
                FlashMessage::set('student_action', 'Thêm sinh viên thất bại!', 'error');
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
        if (!$student) {
            header('Location: index.php');
            exit();
        }
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
            $course = $_POST['course'] ?? '';
            $class_name = $_POST['class_name'] ?? '';
            $major = $_POST['major'] ?? '';
            if (
                $id && !empty($name) && !empty($email) &&

                !empty($phone)
            ) {

                // Lấy thông tin cũ để xóa file cũ nếu cần
                $existing = $this->sinhvienModel->getStudentById($id);

                $avatarFilename = null;
                if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../../public/upload/avatars/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    $tmpName = $_FILES['avatar']['tmp_name'];
                    $origName = basename($_FILES['avatar']['name']);
                    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
                    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                    if (in_array($ext, $allowed) && is_uploaded_file($tmpName)) {
                        $avatarFilename = $origName;
                        $dest = $uploadDir . $avatarFilename;
                        if (move_uploaded_file($tmpName, $dest)) {
                            // xóa file cũ nếu không phải default
                            if (!empty($existing['avatar']) && $existing['avatar'] !== 'default-avatar.png') {
                                $oldFile = $uploadDir . $existing['avatar'];
                                if (is_file($oldFile)) {
                                    @unlink($oldFile);
                                }
                            }
                        } else {
                            $avatarFilename = null;
                        }
                    }
                }

                $this->sinhvienModel->updateStudent($id, $name, $email, $phone, $course, $class_name, $major, $avatarFilename);

                FlashMessage::set('student_action', 'Cập nhật thông tin thành công!', 'success');
            } else {
                FlashMessage::set('student_action', 'Cập nhật thất bại!', 'error');
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
        if ($id) {
            // Xóa file avatar nếu tồn tại
            $existing = $this->sinhvienModel->getStudentById($id);
            $uploadDir = __DIR__ . '/../../public/upload/avatars/';
            if (!empty($existing['avatar']) && $existing['avatar'] !== 'default-avatar.png') {
                $file = $uploadDir . $existing['avatar'];
                if (is_file($file)) {
                    @unlink($file);
                }
            }

            if ($this->sinhvienModel->deleteStudent($id)) {
                FlashMessage::set('student_action', 'Xóa sinh viên thành công!', 'success');
            } else {
                FlashMessage::set('student_action', 'Xóa thất bại!', 'error');
            }
        }
        // Sau khi xóa, chuyển hướng người dùng về lại trang danh sách

        header('Location: index.php');
        exit();
    }
    public function detail()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            FlashMessage::set('student_action', 'ID sinh viên không hợp lệ.', 'error');
            header('Location: index.php');
            exit();
        }
        // Tái sử dụng hàm getStudentById đã có
        $student = $this->sinhvienModel->getStudentById($id);
        if (!$student) {
            FlashMessage::set('student_action', 'Không tìm thấy sinh viên.', 'error');
            header('Location: index.php');
            exit();
        }
        // Nạp file view chi tiết và truyền dữ liệu sinh viên
        require_once __DIR__ . '/../../views/detail.php';
    }
    public function dashboard()
    {
        // Gọi model để lấy dữ liệu thống kê
        $stats = $this->sinhvienModel->getStatistics();
        // Nạp file view và truyền biến $stats ra
        require_once __DIR__ . '/../../views/dashboard.php';
    }
}
