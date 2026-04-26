<?php
// src/Controllers/SinhvienController.php 
namespace vohoq\Bai01QuanlySv\Controllers;

use vohoq\Bai01QuanlySv\Models\SinhvienModel;
use vohoq\Bai01QuanlySv\Core\FlashMessage;
use vohoq\Bai01QuanlySv\Core\Logger; //<-- THÊM DÒNG NÀY

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
        // --- XỬ LÝ SẮP XẾP (PHẦN MỚI) ---
        // 1. Danh sách các cột được phép sắp xếp (để bảo mật)
        $allowedSortCols = ['id', 'name', 'email', 'phone'];
        // 2. Lấy cột sắp xếp từ URL, mặc định là 'id'
        $sortby = $_GET['sortby'] ?? 'id';
        if (!in_array($sortby, $allowedSortCols)) {
            $sortby = 'id'; // Nếu cột không hợp lệ, quay về mặc định
        }
        // 3. Lấy thứ tự sắp xếp, mặc định là 'desc' (mới nhất lên đầu)
        $order = $_GET['order'] ?? 'desc';
        $order = strtolower($order) === 'asc' ? 'asc' : 'desc'; // Chỉ cho phép 'asc' hoặc 'desc'

        // 4. Tính toán thứ tự đảo ngược (để dùng trong View)
        $nextOrder = ($order === 'asc' ? 'desc' : 'asc');
        // Truyền thêm $sortby và $order vào Model
        // --- GỌI MODEL ---
        $result = $this->sinhvienModel->getStudents(
            $keyword,
            $recordsPerPage,
            $offset,
            $sortby,
            $order
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
                Logger::log('create_student', "Student Name: " . $name); // <-- GHI LOG

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
                Logger::log('update_student', "Student ID: " . $id); // <-- GHI LOG
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
                Logger::log('delete_student', "Student ID: " . $id); // <-- GHI LOG
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
    /**
     * HÀM MỚI: Xử lý xuất danh sách sinh viên ra file CSV
     */
    public function exportCsv()
    {
        // 1. Lấy từ khóa tìm kiếm (nếu có)
        $keyword = $_GET['keyword'] ?? null;
        // 2. Lấy toàn bộ dữ liệu từ Model
        $students = $this->sinhvienModel->getStudentsForExport($keyword);
        // 3. Đặt tên file
        $filename = "danh-sach-sinh-vien-" . date('Y-m-d') . ".csv";
        // 4. Thiết lập HTTP Headers để trình duyệt hiểu là file tải về
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // 5. Mở luồng ghi "php://output"
        // Luồng này cho phép ghi dữ liệu trực tiếp vào body của response
        $output = fopen('php://output', 'w');
        // 6. (QUAN TRỌNG) Thêm UTF-8 BOM
        // Bước này rất cần thiết để Microsoft Excel đọc file CSV có tiếng Việt

        fputs($output, "\xEF\xBB\xBF");
        // 7. Ghi dòng tiêu đề (Header) của file CSV
        fputcsv($output, [
            'ID',
            'Họ và Tên',
            'Email',
            'Số điện thoại',
            'Khóa học',
            'Lớp',
            'Ngành học'
        ]);
        // 8. Lặp qua dữ liệu và ghi từng dòng

        foreach ($students as $student) {
            fputcsv($output, [
                $student['id'],
                $student['name'],
                $student['email'],
                $student['phone'],
                $student['course'] ?? '', // Dùng ?? '' để tránh lỗi nếu giá trị là NULL

                $student['class_name'] ?? '',
                $student['major'] ?? ''
            ]);
        }
        // 9. Đóng luồng
        fclose($output);
        // 10. Dừng chương trình
        // Rất quan trọng, để ngăn không cho bất kỳ mã HTML/View nào
        // bị chèn vào sau nội dung file CSV.
        exit();
    }
}
