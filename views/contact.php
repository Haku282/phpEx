<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Liên hệ với chúng tôi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height:
                100vh;
            margin: 0;
            padding: 20px 0;
        }

        .container {
            background: #fff;
            padding: 20px 30px;
            border-radius:

                5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 400px;
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

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #17a2b8;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .nav-link {
            text-align: center;
            margin-top: 15px;
        }

        /* Style cho Flash Message */
        .flash-message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius:

                5px;
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
        <h1>Form Liên hệ</h1>

        <?php \vohoq\Bai01QuanlySv\Core\FlashMessage::display(); // Hiển thị thông báo ở đây 
        ?>

        <form action="index.php?action=submit_contact" method="POST">
            <div class="form-group">
                <label for="name">Họ và Tên:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Nội dung:</label>
                <textarea id="message" name="message" required></textarea>
            </div>
            <button type="submit">Gửi tin nhắn</button>
        </form>
        <div class="nav-link">
            <a href="index.php">Quay về trang chủ</a>
        </div>
    </div>
</body>

</html>