<?php
// src/Controllers/UserController.php
namespace vohoq\Bai01QuanlySv\Controllers;

use vohoq\Bai01QuanlySv\Models\UserModel;

class UserController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        require_once __DIR__ . '/../../views/dangky.php';
    }
    // Xử lý logic đăng ký
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            if (
                empty($name) || empty($username) ||

                empty($password)
            ) {

                $error = "Vui lòng điền đầy đủ thông tin.";
                require_once __DIR__ . '/../../views/dangky.php';
                return;
            }
            $result = $this->userModel->createUser(
                $name,

                $username,
                $password
            );
            if ($result) {
                // Đăng ký thành công, chuyển hướng đến trang đăng nhập

                header('Location: index.php?action=login');
                exit();
            } else {
                // Tên đăng nhập đã tồn tại

                $error = "Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.";

                require_once __DIR__ . '/../../views/dangky.php';
            }
        }
    }
    // HÀM MỚI: Hiển thị form đăng nhập
    public function showLoginForm()
    {
        require_once __DIR__ . '/../../views/dangnhap.php';
    }
    // HÀM MỚI: Xử lý logic đăng nhập
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            if (empty($username) || empty($password)) {
                $error = "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.";

                require_once __DIR__ . '/../../views/dangnhap.php';

                return;
            }
            // Tìm người dùng trong CSDL
            $user =

                $this->userModel->findUserByUsername($username);
            // --- BƯỚC BẢO MẬT QUAN TRỌNG NHẤT ---
            // So sánh mật khẩu người dùng nhập với mật khẩu đã băm trong CSDL

            if ($user && password_verify(
                $password,

                $user['password']
            )) {

                // Mật khẩu chính xác, đăng nhập thành công
                // Lưu thông tin người dùng vào Session để ghi nhớ

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                // Chuyển hướng đến trang quản lý sinh viên
                header('Location: index.php');
                exit();
            } else {
                // Tên đăng nhập hoặc mật khẩu không đúng
                $error = "Tên đăng nhập hoặc mật khẩu không chính xác.";

                require_once __DIR__ . '/../../views/dangnhap.php';
            }
        }
    }
    // HÀM MỚI: Xử lý đăng xuất
    public function logout()
    {
        // Hủy tất cả các biến session.
        $_SESSION = [];
        // Nếu muốn hủy session hoàn toàn, hãy xóa cả cookie session.

        // Lưu ý: Điều này sẽ phá hủy session, và không chỉ dữ liệu session!

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        // Cuối cùng, hủy session.
        session_destroy();
        // Chuyển hướng về trang đăng nhập
        header('Location: index.php?action=login');
        exit();
    }
}
