<?php
// views/layout/header.php
// Lấy action hiện tại từ URL để xác định trang active
$current_action = $_GET['action'] ?? 'index';
/**
 * Hàm trợ giúp để kiểm tra và gán class 'active'
 */
function isActive($action, $current_action)
{
    if ($action === $current_action) {
        return 'active';
    }
    // Trường hợp đặc biệt: 'index' cũng là trang chủ
    if ($action === 'index' && in_array($current_action, [
        'add',
        'edit',
        'update',
        'delete'
    ])) {
        return 'active';
    }
    return '';
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sinh viên</title>
    <style>
        /* Toàn bộ CSS của dự án sẽ được tập trung về đây */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding-top: 60px;
            /* Thêm padding_top để nội dung không bị nav che */
        }

        /* --- Thanh Navigation Bar --- */
        .navbar {
            background-color: #333;
            color: white;
            padding: 0 20px;
            position: fixed;
            /* Cố định menu */
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .navbar .nav-links {
            list-style: none;
            margin: 0;

            padding: 0;
            display: flex;
        }

        .navbar .nav-links li a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 20px 15px;
            transition: background-color 0.3s;
        }

        .navbar .nav-links li a:hover,
        .navbar .nav-links li a.active {
            background-color: #555;
        }

        /* --- Menu User (Dropdown) --- */
        .navbar .user-menu {
            position: relative;
        }

        .navbar .user-menu .user-name {
            cursor: pointer;
            padding: 20px;
        }

        .navbar .user-menu .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            right: 0;
        }

        .navbar .user-menu .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .navbar .user-menu .dropdown-content a:hover {
            background-color: #ddd;
        }

        /* JS sẽ được dùng để bật/tắt menu này */
        .navbar .user-menu.show .dropdown-content {
            display: block;
        }

        /* --- Nội dung chính --- */
        .container {
            max-width: 900px;
            /* Tăng chiều rộng để dễ nhìn hơn */
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* --- Style chung (từ các bài trước) --- */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        th a {
            text-decoration: none;
            color: #333;
        }

        form {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width:
                95%;
            padding: 8px;
            margin-bottom: 10px;
        }

        button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        /* ... (Thêm bất kỳ style chung nào bạn đã có ở đây) ... */
    </style>
</head>

<body>
    <nav class="navbar">
        <ul class="nav-links">
            <li>
                <a href="index.php" class="<?php echo isActive(
                                                'index',

                                                $current_action
                                            ); ?>">Danh sách Sinh viên</a>

            </li>
            <li>
                <a href="index.php?action=dashboard" class="<?php echo

                                                            isActive('dashboard', $current_action); ?>">Dashboard</a>

            </li>
            <li>
                <a href="index.php?action=logs" class="<?php echo
                                                        isActive('logs', $current_action); ?>">Log Hoạt Động</a>

            </li>
            <li>
                <a href="index.php?action=contact" class="<?php echo

                                                            isActive('contact', $current_action); ?>">Liên hệ</a>

            </li>
        </ul>
        <div class="user-menu" id="user-menu-dropdown">
            <span class="user-name">
                Chào, <strong><?php echo htmlspecialchars($_SESSION['user_name']);

                                ?></strong>! ▼
            </span>
            <div class="dropdown-content">
                <a href="index.php?action=change_password">Đổi mật khẩu</a>
                <a href="index.php?action=logout">Đăng xuất</a>
            </div>
        </div>
    </nav>
    <div class="container">