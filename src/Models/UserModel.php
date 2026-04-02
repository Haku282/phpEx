<?php
// src/Models/UserModel.php
namespace vohoq\Bai01QuanlySv\Models;

use vohoq\Bai01QuanlySv\Database;
use PDO;

class UserModel
{
    private $conn;
    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }
    /**
     * Tìm người dùng bằng username
     */
    public function findUserByUsername($username)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");

        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * Tạo người dùng mới
     */
    public function createUser($name, $username, $password, $email)
    {
        // Kiểm tra xem username đã tồn tại chưa
        if ($this->findUserByUsername($username)) {
            return false; // Username đã tồn tại
        }
        // --- Băm mật khẩu - BƯỚC BẢO MẬT QUAN TRỌNG NHẤT ---
        $passwordHash = password_hash(
            $password,

            PASSWORD_DEFAULT
        );

        $stmt = $this->conn->prepare(

            "INSERT INTO users (name, username, password, email) VALUES (:name, :username, :password, :email)"

        );
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }
}
