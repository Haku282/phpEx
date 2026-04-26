<?php
// src/Core/Logger.php
namespace vohoq\Bai01QuanlySv\Core;

use vohoq\Bai01QuanlySv\Database;
use PDO;

class Logger
{
    /**
     * Ghi lại một hành động vào CSDL
     *
     * @param string $action Hành động (ví dụ: 'login_success')
     * @param string $details Chi tiết về hành động
     * @param int|null $userId ID của người dùng (nếu có)
     */
    public static function log(
        $action,
        $details = '',
        $userId = null,
        $userName = null
    ) {
        try {
            $db = Database::getInstance()->getConnection();
            // Tự động lấy thông tin nếu không được cung cấp
            if ($userId === null && isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
            }
            if ($userName === null && isset($_SESSION['user_name'])) {
                $userName = $_SESSION['user_name'];
            }
            // Lấy địa chỉ IP
            $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
            $stmt = $db->prepare(
                "INSERT INTO activity_logs (user_id, user_name, action,

details, ip_address)

VALUES (:user_id, :user_name, :action, :details,

:ip_address)"
            );
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':user_name', $userName);
            $stmt->bindParam(':action', $action);

            $stmt->bindParam(':details', $details);
            $stmt->bindParam(':ip_address', $ip_address);
            $stmt->execute();
        } catch (\Exception $e) {
            // Nếu ghi log thất bại, chúng ta không nên làm dừng ứng dụng
            // Có thể ghi vào file log dự phòng ở đây
            // error_log('Failed to write to DB logger: ' . $e->getMessage());

        }
    }
}
