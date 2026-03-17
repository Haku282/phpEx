<?php 
// src/Models/SinhvienModel.php 
namespace Vohoq\Bai01QuanlySv\Models; 
 
use Vohoq\Bai01QuanlySv\Database; 
 
use PDO; 
 
class SinhvienModel { 
    private $conn; 
 
    public function __construct() { 
        $this->conn = Database::getInstance()->getConnection(); 
    } 
 
    // Lấy tất cả sinh viên 
    public function getAllStudents() { 
        $stmt = $this->conn->prepare("SELECT * FROM students 
ORDER BY id DESC"); 
        $stmt->execute(); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    } 
 
    // Thêm sinh viên mới 
    public function addStudent($name, $email, $phone) { 
        $stmt = $this->conn->prepare("INSERT INTO students (name, 
email, phone) VALUES (:name, :email, :phone)"); 
         
        // Làm sạch dữ liệu 
        $name = htmlspecialchars(strip_tags($name)); 
        $email = htmlspecialchars(strip_tags($email)); 
        $phone = htmlspecialchars(strip_tags($phone)); 
 
        // Gán dữ liệu vào câu lệnh 
        $stmt->bindParam(':name', $name); 
        $stmt->bindParam(':email', $email); 
        $stmt->bindParam(':phone', $phone); 
 
        if ($stmt->execute()) { 
            return true; 
        } 
        return false; 
} 
}