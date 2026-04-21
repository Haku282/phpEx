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
    /**
     * HÀM MỚI: Tìm người dùng bằng ID
     */
    public function findUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");

        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * HÀM MỚI: Cập nhật mật khẩu cho người dùng
     */
    public function updatePassword($id, $newPassword)
    {
        // Băm mật khẩu mới trước khi lưu
        $passwordHash = password_hash(
            $newPassword,

            PASSWORD_DEFAULT
        );

        $stmt = $this->conn->prepare(
            "UPDATE users SET password = :password WHERE id = :id"
        );
        $stmt->bindParam(':password', $passwordHash);

        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
