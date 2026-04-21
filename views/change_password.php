<?php

use vohoq\Bai01QuanlySv\Core\FlashMessage; ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đổi mật khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:
                #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px 0;
        }

        .container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width:
                400px;
        }

        h1 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing:
                border-box;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color:
                #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor:
                pointer;
        }

        .nav-link {
            text-align: center;
            margin-top: 15px;
        }

        /* Style cho Flash Message */
        .flash-message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
        }

        .flash-success {
            background-color: #28a745;
        }

        .flash-error {
            background-color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Đổi mật khẩu</h1>
        <?php FlashMessage::display(); // Hiển thị thông báo ở đây 
        ?>
        <form action="index.php?action=do_change_password"
            method="POST">
            <div class="form-group">
                <label for="old_password">Mật khẩu cũ:</label>
                <input type="password" id="old_password"
                    name="old_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">Mật khẩu mới:</label>
                <input type="password" id="new_password"
                    name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Xác nhận mật khẩu
                    mới:</label>
                <input type="password" id="confirm_password"
                    name="confirm_password" required>
            </div>
            <button type="submit">Cập nhật mật khẩu</button>
        </form>
        <div class="nav-link">
            <a href="index.php">Quay về trang chủ</a>
        </div>
    </div>
</body>

</html>