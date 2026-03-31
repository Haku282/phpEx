<?php

use vohoq\Bai01QuanlySv\Core\FlashMessage; ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Thống kê Sinh viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:

                #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background:
                #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .stats-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .stat-card {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 200px;
            margin: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .stat-card.green {
            background-color: #28a745;
        }

        .stat-card.orange {
            background-color: #ffc107;
            color:

                #333;
        }

        .stat-card .number {
            font-size: 2.5em;
            font-weight:

                bold;
            margin: 10px 0;
        }

        .stat-card .title {
            font-size: 1.1em;
        }

        .back-link {
            display: block;
            text-align: center;

            margin-top: 30px;
        }
    </style>

</head>

<body>
    <div class="container">
        <h1>Dashboard Thống kê</h1>
        <div class="stats-container">
            <div class="stat-card">
                <div class="number"><?php echo

                                    htmlspecialchars($stats['total_students'] ?? 0); ?></div>
                <div class="title">Tổng số sinh viên</div>
            </div>
            <div class="stat-card green">
                <div class="number"><?php echo

                                    htmlspecialchars($stats['edu_emails'] ?? 0); ?></div>

                <div class="title">SV có email @tdu.edu.vn</div>
            </div>
            <div class="stat-card orange">
                <div class="number"><?php echo
                                    htmlspecialchars($stats['sdt_09'] ?? 0); ?></div>

                <div class="title">SV có SĐT đầu 09</div>
            </div>
        </div>
        <a href="index.php" class="back-link">Quay về danh sách</a>
    </div>
</body>

</html>