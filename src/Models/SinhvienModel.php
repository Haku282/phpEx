<?php
// src/Models/SinhvienModel.php 
namespace Vohoq\Bai01QuanlySv\Models;

use Vohoq\Bai01QuanlySv\Database;

use PDO;

class SinhvienModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Lấy tất cả sinh viên 
    public function getAllStudents($keyword = null)
    {
        // Bắt đầu câu lệnh SQL
        $sql = "SELECT * FROM students";
        // Nếu có từ khóa tìm kiếm, thêm điều kiện WHERE
        if ($keyword) {
            // Sử dụng LIKE để tìm kiếm gần đúng
            $sql .= " WHERE name LIKE :keyword";
        }
        $sql .= " ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        // Nếu có từ khóa, gán giá trị cho tham số :keyword
        if ($keyword) {
            // Thêm dấu % vào hai bên từ khóa để tìm kiếm bất kỳ vị trí nào trong chuỗi

            $searchKeyword = "%{$keyword}%";
            $stmt->bindParam(':keyword', $searchKeyword);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm sinh viên mới 
    public function addStudent($name, $email, $phone)
    {
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
    // HÀM THÊM MỚI: Lấy thông tin một sinh viên theo ID (bài 03)
    public function getStudentById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM students

WHERE id = :id");

        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // HÀM THÊM MỚI: Cập nhật thông tin sinh viên (bài 03)
    public function updateStudent($id, $name, $email, $phone)
    {
        $stmt = $this->conn->prepare(
            "UPDATE students SET name = :name, email = :email,

phone = :phone WHERE id = :id"

        );
        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $email = htmlspecialchars(strip_tags($email));
        $phone = htmlspecialchars(strip_tags($phone));
        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // HÀM MỚI: Xóa một sinh viên theo ID (bài 4)
    public function deleteStudent($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM students WHERE id = :id");

        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
