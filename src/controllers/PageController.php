<?php
// src/Controllers/PageController.php
namespace vohoq\Bai01QuanlySv\Controllers;

use vohoq\Bai01QuanlySv\Models\ContactModel;
use vohoq\Bai01QuanlySv\Core\FlashMessage;

class PageController
{
    private $contactModel;
    public function __construct()
    {
        $this->contactModel = new ContactModel();
    }
    /**
     * Hiển thị form liên hệ
     */
    public function showContactForm()
    {
       require_once __DIR__ . '/../../views/contact.php';
    }
    /**
     * Xử lý dữ liệu từ form liên hệ
     */
    public function submitContact()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $message = $_POST['message'] ?? '';
            if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {

                FlashMessage::set('contact_form', 'Vui lòng điền đầy đủ và đúng định dạng thông tin.', 'error');
            } else {
                if ($this->contactModel->saveContact($name, $email, $message)) {

                    FlashMessage::set('contact_form', 'Tin nhắn của bạn đã được gửi thành công!', 'success');
                } else {
                    FlashMessage::set('contact_form', 'Đã có lỗi xảy ra. Vui lòng thử lại.', 'error');
                }
            }
        }
        // Chuyển hướng trở lại chính trang liên hệ để hiển thị thông báo

        header('Location: index.php?action=contact');

        exit();
    }
}
