<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,
initial-scale=1.0">
    <title>Chỉnh sửa thông tin sinh viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        .container {
            max-width: 600px;
            margin: auto;
        }

        form {
            padding: 20px;
            border: 1px solid #ccc;

            border-radius: 5px;
        }

        form input {
            display: block;
            margin-bottom: 10px;
            width:

                95%;
            padding: 8px;
        }

        form button {
            padding: 10px 15px;
            background-color:
                #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Chỉnh sửa thông tin sinh viên</h1>
        <form action="index.php?action=update" method="POST">
            <input type="hidden" name="id" value="<?php echo

                                                    $student['id']; ?>">

            <label for="name">Họ và Tên:</label>
            <input type="text" id="name" name="name"
                value="<?php echo htmlspecialchars($student['name']); ?>"
                required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
                value="<?php echo htmlspecialchars($student['email']); ?>"
                required>

            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone"
                value="<?php echo htmlspecialchars($student['phone']); ?>"
                required>

            <button type="submit">Lưu thay đổi</button>
        </form>
        <p><a href="index.php">Quay về danh sách</a></p>
    </div>
</body>

</html>