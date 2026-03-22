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
    public function getStudents($keyword = null, $limit = 5, $offset = 0)
    {
        // --- BƯỚC 1: ĐẾM TỔNG SỐ BẢN GHI ---
        $sqlCount = "SELECT COUNT(*) FROM students";
        $params = [];
        if ($keyword) {
            $sqlCount .= " WHERE name LIKE :keyword OR email LIKE :keyword OR phone LIKE :keyword";
            $params[':keyword'] = "%{$keyword}%";
        }
        $stmtCount = $this->conn->prepare($sqlCount);
        $stmtCount->execute($params);
        $totalRecords = $stmtCount->fetchColumn();
        // --- BƯỚC 2: LẤY DỮ LIỆU SINH VIÊN THEO PHÂN TRANG ---
        $sqlData = "SELECT * FROM  students";
        if ($keyword) {
            $sqlData .= " WHERE name LIKE :keyword OR email LIKE :keyword OR phone LIKE :keyword";
        }
        $sqlData .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmtData = $this->conn->prepare($sqlData);
        // Gán các tham số cho câu lệnh lấy dữ liệu
        if ($keyword) {
            $stmtData->bindParam(
                ':keyword',
                $params[':keyword']
            );
        }
        $stmtData->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmtData->bindParam(
            ':offset',
            $offset,
            PDO::PARAM_INT
        );
        $stmtData->execute();
        $students = $stmtData->fetchAll(PDO::FETCH_ASSOC);
        return [
            'data' => $students,
            'total' => $totalRecords
        ];
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
