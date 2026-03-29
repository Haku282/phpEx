<?php
// src/Core/FlashMessage.php
namespace vohoq\Bai01QuanlySv\Core;

class FlashMessage
{
    /**
     * Đặt một flash message mới.
     * @param string $key - Key để định danh message (ví dụ:'form_error', 'user_action')
     * @param string $message - Nội dung message
     * @param string $type - Loại message ('success' hoặc 'error')
     */
    public static function set($key, $message, $type = 'success')
    {

        if (!isset($_SESSION['flash_messages'])) {
            $_SESSION['flash_messages'] = [];
        }
        $_SESSION['flash_messages'][$key] = ['message' =>

        $message, 'type' => $type];
    }
    /**
     * Hiển thị tất cả các flash messages và xóa chúng khỏi session.
     */
    public static function display()
    {
        if (isset($_SESSION['flash_messages'])) {
            foreach (
                $_SESSION['flash_messages'] as $key =>

                $flash
            ) {

                $typeClass = ($flash['type'] === 'success') ?

                    'flash-success' : 'flash-error';

                echo "<div class='flash-message {$typeClass}'>" .

                    htmlspecialchars($flash['message']) . "</div>";
            }
            // Xóa tất cả các message sau khi đã hiển thị
            unset($_SESSION['flash_messages']);
        }
    }
}
