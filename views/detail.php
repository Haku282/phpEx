<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết sinh viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height:
                100vh;
            padding: 20px;
        }

        .profile-card {
            width: 500px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .profile-header {
            background-color: #007bff;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
        }

        .profile-header h1 {
            margin: 10px 0 5px 0;
            font-size: 1.8em;

        }

        .profile-header p {
            margin: 0;
            font-size: 1.1em;
            color: #e0e0e0;
        }

        .profile-body {
            padding: 30px;
        }

        .info-group {
            margin-bottom: 20px;
        }

        .info-group label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        .info-group span {
            font-size: 1.1em;
            color: #333;
        }

        .back-link {
            display: block;
            text-align: center;
            padding: 15px;
            background: #f9f9f9;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            border-top: 1px solid #eee;
        }
    </style>
</head>

<body>
    <div class="profile-card">
        <div class="profile-header">
            <img src="uploads/avatars/<?php echo $student['avatar'] ??

                                            'default-avatar.png'; ?>" alt="Avatar">

            <h1><?php echo htmlspecialchars($student['name']); ?></h1>
            <p><?php echo htmlspecialchars($student['major'] ?? 'Chưa cập

nhật ngành học'); ?></p>

        </div>
        <div class="profile-body">
            <div class="info-group">
                <label>Email:</label>
                <span><?php echo htmlspecialchars($student['email']);

                        ?></span>

            </div>
            <div class="info-group">
                <label>Số điện thoại:</label>
                <span><?php echo htmlspecialchars($student['phone']);

                        ?></span>

            </div>

            <div class="info-group">
                <label>Khóa học:</label>
                <span><?php echo htmlspecialchars($student['course'] ??

                            'Chưa cập nhật'); ?></span>

            </div>
            <div class="info-group">
                <label>Lớp:</label>
                <span><?php echo htmlspecialchars($student['class_name']

                            ?? 'Chưa cập nhật'); ?></span>

            </div>
        </div>
        <a href="index.php" class="back-link">Quay về danh sách</a>
    </div>
</body>

</html>