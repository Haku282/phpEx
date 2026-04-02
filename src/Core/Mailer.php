<?php
// src/Core/Mailer.php
namespace vohoq\Bai01QuanlySv\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    /**
     * Gửi email
     * @param string $toEmail - Email người nhận
     * @param string $toName - Tên người nhận
     * @param string $subject - Tiêu đề email
     * @param string $body - Nội dung email (hỗ trợ HTML)
     * @return bool
     */
    public static function send($toEmail, $toName, $subject, $body)
    {
        // Nạp file cấu hình (vì nó không được autoload)
        require_once __DIR__ . '/../../config.php';
        $mail = new PHPMailer(true);
        try {
            // Cấu hình Server
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host = MAIL_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Hoặc ENCRYPTION_SMTPS
            $mail->Port = MAIL_PORT;
            // Người gửi và người nhận
            $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
            $mail->addAddress($toEmail, $toName); // Thêm người nhận
            // Nội dung
            $mail->isHTML(true); // Gửi email dạng HTML
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->AltBody = strip_tags($body); // Nội dung dạng text cho các trình duyệt mail không hỗ trợ HTML
            $mail->send();
            return true;
        } catch (Exception $e) {
            // Có thể ghi log lỗi ở đây
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }
}
