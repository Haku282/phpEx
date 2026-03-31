<?php
// src/Models/ContactModel.php
namespace vohoq\Bai01QuanlySv\Models;

use vohoq\Bai01QuanlySv\Database;
use PDO;

class ContactModel
{
    private $conn;
    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }
    /**
     * Lưu một liên hệ mới vào CSDL
     */
    public function saveContact($name, $email, $message)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO contacts (name, email, message) VALUES

(:name, :email, :message)"

        );
        $stmt->bindParam(
            ':name',
            htmlspecialchars(strip_tags($name))
        );
        $stmt->bindParam(
            ':email',
            htmlspecialchars(strip_tags($email))
        );
        $stmt->bindParam(
            ':message',
            htmlspecialchars(strip_tags($message))
        );

        return $stmt->execute();
    }
}
