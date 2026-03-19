<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, 
initial-scale=1.0">
    <title>Quản lý sinh viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        form {
            margin-bottom: 20px;
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
                #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

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
    </style>
</head>

<body>
    <div class="container">
        <h1>Quản lý sinh viên</h1>

        <form action="index.php?action=add" method="POST">
            <h3>Thêm sinh viên mới</h3>
            <input type="text" name="name" placeholder="Họ và 
Tên" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Số điện 
thoại" required>
            <button type="submit">Thêm mới</button>
        </form>

        <h2>Danh sách sinh viên</h2>
        <!-- <table>
            <thead>
                <tr>
                    <th>ID</th>
                    Bài mẫu
                    <th>Họ và Tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo $student['id']; ?></td>
                        <td><?php echo
                            htmlspecialchars($student['name']); ?></td>
                        <td><?php echo
                            htmlspecialchars($student['email']); ?></td>
                        <td><?php echo
                            htmlspecialchars($student['phone']); ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($students)): ?>
                    <tr>
                        <td colspan="4">Chưa có sinh viên
                            nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table> -->
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ và Tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo $student['id']; ?></td>
                    <td><?php echo

                        htmlspecialchars($student['name']); ?></td>

                    <td><?php echo

                        htmlspecialchars($student['email']); ?></td>

                    <td><?php echo

                        htmlspecialchars($student['phone']); ?></td>
                    <td>
                    <a href="index.php?action=edit&id=<?php echo $student['id']; ?>">Sửa</a>

                    <a href="index.php?action=delete&id=<?php echo $student['id']; ?>"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này ra khỏi danh sách lớp K17 không?');">
                        Xóa
                    </a>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($students)): ?>
                <tr>
                    <td colspan="5">Chưa có sinh viên nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>