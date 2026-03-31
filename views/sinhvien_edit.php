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
    <?php $studentData = $student ?? []; ?>
    <div class="container">
        <h1>Chỉnh sửa thông tin sinh viên</h1>
        <div>
            <p>Ảnh đại diện hiện tại:</p>
            <img src="upload/avatars/<?php echo $studentData['avatar'] ??
                                            'default-avatar.png'; ?>" alt="Current Avatar" width="100" height="100">
        </div>
        <form action="index.php?action=update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo

                                                    $studentData['id'] ?? ''; ?>">

            <label for="name">Họ và Tên:</label>
            <input type="text" id="name" name="name"
                value="<?php echo htmlspecialchars($studentData['name'] ?? ''); ?>"
                required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
                value="<?php echo htmlspecialchars($studentData['email'] ?? ''); ?>"
                required>

            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone"
                value="<?php echo htmlspecialchars($studentData['phone'] ?? ''); ?>"
                required>

            <label for="course">Khóa học:</label>
            <input type="text" id="course" name="course"
                value="<?php echo htmlspecialchars($studentData['course'] ?? ''); ?>">

            <label for="class_name">Lớp học:</label>
            <input type="text" id="class_name" name="class_name"
                value="<?php echo htmlspecialchars($studentData['class_name'] ?? ''); ?>">

            <label for="major">Ngành học:</label>
            <input type="text" id="major" name="major"
                value="<?php echo htmlspecialchars($studentData['major'] ?? ''); ?>">

            <label for="avatar">Thay đổi ảnh đại diện:</label>
            <input type="file" id="avatar" name="avatar" accept="image/*">

            <button type="submit">Lưu thay đổi</button>
        </form>
        <p><a href="index.php">Quay về danh sách</a></p>
    </div>
</body>

</html>