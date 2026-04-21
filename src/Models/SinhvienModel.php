<?php
// src/Models/SinhvienModel.php 
namespace vohoq\Bai01QuanlySv\Models;

use vohoq\Bai01QuanlySv\Database;

use PDO;

class SinhvienModel
{
    private $conn;
    private $avatarColumn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
        $this->avatarColumn = null;
    }

    private function getAvatarColumnName()
    {
        if ($this->avatarColumn !== null) {
            return $this->avatarColumn;
        }

        $stmt = $this->conn->query("SHOW COLUMNS FROM students");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach (['avatar', 'avatars', 'avatas'] as $candidate) {
            if (in_array($candidate, $columns, true)) {
                $this->avatarColumn = $candidate;
                return $this->avatarColumn;
            }
        }

        $this->avatarColumn = false;
        return $this->avatarColumn;
    }

    private function normalizeAvatarField(array $student)
    {
        if (!isset($student['avatar'])) {
            $avatarColumn = $this->getAvatarColumnName();
            if ($avatarColumn && isset($student[$avatarColumn])) {
                $student['avatar'] = $student[$avatarColumn];
            } else {
                $student['avatar'] = null;
            }
        }

        return $student;
    }

    // Lấy tất cả sinh viên 
    public function getStudents($keyword = null, $limit = 5, $offset = 0, $sortby = 'id', $order = 'desc')
    {
        // --- BƯỚC 1: ĐẾM TỔNG SỐ BẢN GHI ---
        $sqlCount = "SELECT COUNT(*) FROM students";
        $params = [];
        if ($keyword) {
            $sqlCount .= " WHERE name LIKE :keyword_like OR email LIKE :keyword_like OR phone LIKE :keyword_phone";
            $params[':keyword_like'] = "%{$keyword}%";
            $params[':keyword_phone'] = "{$keyword}%";
        }
        $stmtCount = $this->conn->prepare($sqlCount);
        $stmtCount->execute($params);
        $totalRecords = $stmtCount->fetchColumn();
        // --- BƯỚC 2: LẤY DỮ LIỆU SINH VIÊN THEO PHÂN TRANG ---
        $sqlData = "SELECT * FROM  students";
        if ($keyword) {
            $sqlData .= " WHERE name LIKE :keyword_like OR email LIKE :keyword_like OR phone LIKE :keyword_phone";
        }

        // THÊM LOGIC ORDER BY (PHẦN MỚI)
        // Chúng ta đã validate $sortby và $order ở Controller
        // nên ở đây có thể nối chuỗi an toàn.
        $sqlData .= " ORDER BY " . $sortby . " " . $order;
        // Thêm LIMIT và OFFSET
        $sqlData .= " LIMIT :limit OFFSET :offset";

        $stmtData = $this->conn->prepare($sqlData);
        // Gán các tham số cho câu lệnh lấy dữ liệu
        if ($keyword) {
            $stmtData->bindParam(':keyword_like', $params[':keyword_like']);
            $stmtData->bindParam(':keyword_phone', $params[':keyword_phone']);
        }
        $stmtData->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmtData->bindParam(
            ':offset',
            $offset,
            PDO::PARAM_INT
        );
        $stmtData->execute();
        $students = $stmtData->fetchAll(PDO::FETCH_ASSOC);
        foreach ($students as &$student) {
            $student = $this->normalizeAvatarField($student);
        }
        unset($student);
        return [
            'data' => $students,
            'total' => $totalRecords
        ];
    }
    // Thêm sinh viên mới (bổ sung avatar)
    public function addStudent($name, $email, $phone, $course = null, $class_name = null, $major = null, $avatar = null)
    {
        $avatarColumn = $this->getAvatarColumnName();
        if ($avatarColumn) {
            $stmt = $this->conn->prepare("INSERT INTO students (name, email, phone, course, class_name, major, {$avatarColumn}) VALUES (:name, :email, :phone, :course, :class_name, :major, :avatar)");
        } else {
            $stmt = $this->conn->prepare("INSERT INTO students (name, email, phone, course, class_name, major) VALUES (:name, :email, :phone, :course, :class_name, :major)");
        }

        // Làm sạch dữ liệu 
        $name = htmlspecialchars(strip_tags($name));
        $email = htmlspecialchars(strip_tags($email));
        $phone = htmlspecialchars(strip_tags($phone));
        $course = $course ? htmlspecialchars(strip_tags($course)) : null;
        $class_name = $class_name ? htmlspecialchars(strip_tags($class_name)) : null;
        $major = $major ? htmlspecialchars(strip_tags($major)) : null;
        $avatar = $avatar ? htmlspecialchars(strip_tags($avatar)) : null;

        // Gán dữ liệu vào câu lệnh 
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':course', $course);
        $stmt->bindParam(':class_name', $class_name);
        $stmt->bindParam(':major', $major);
        if ($avatarColumn) {
            $stmt->bindValue(':avatar', $avatar, $avatar === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        }

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // HÀM THÊM MỚI: Lấy thông tin một sinh viên theo ID (bài 03)
    public function getStudentById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE id = :id");

        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$student) {
            return false;
        }
        return $this->normalizeAvatarField($student);
    }
    // HÀM THÊM MỚI: Cập nhật thông tin sinh viên (bài 03)
    public function updateStudent($id, $name, $email, $phone, $course = null, $class_name = null, $major = null, $avatar = null)
    {
        $avatarColumn = $this->getAvatarColumnName();
        // Nếu có avatar mới, cập nhật cả trường avatar; nếu không, giữ nguyên avatar cũ
        if ($avatar !== null && $avatarColumn) {
            $stmt = $this->conn->prepare(
                "UPDATE students SET name = :name, email = :email, phone = :phone, course = :course, class_name = :class_name, major = :major, {$avatarColumn} = :avatar WHERE id = :id"
            );
        } else {
            $stmt = $this->conn->prepare(
                "UPDATE students SET name = :name, email = :email, phone = :phone, course = :course, class_name = :class_name, major = :major WHERE id = :id"
            );
        }

        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $email = htmlspecialchars(strip_tags($email));
        $phone = htmlspecialchars(strip_tags($phone));
        $course = $course ? htmlspecialchars(strip_tags($course)) : null;
        $class_name = $class_name ? htmlspecialchars(strip_tags($class_name)) : null;
        $major = $major ? htmlspecialchars(strip_tags($major)) : null;
        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':course', $course);
        $stmt->bindParam(':class_name', $class_name);
        $stmt->bindParam(':major', $major);
        if ($avatar !== null && $avatarColumn) {
            $avatarClean = htmlspecialchars(strip_tags($avatar));
            $stmt->bindParam(':avatar', $avatarClean);
        }

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
    public function getStatistics()
    {
        $sql = "
                SELECT
                COUNT(*) AS total_students,
                SUM(CASE WHEN email LIKE '%@tdu.edu.vn' THEN 1 ELSE 0 END) AS edu_emails,
                SUM(CASE WHEN phone LIKE '09%' THEN 1 ELSE 0 END)
                AS sdt_09 FROM students";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getStudentsForExport($keyword = null)
    {

        $sql = "SELECT * FROM students";
        $params = [];
        if ($keyword) {
            $sql .= " WHERE name LIKE :keyword_like OR email LIKE :keyword_like OR phone LIKE :keyword_phone";
            $params[':keyword_like'] = "%{$keyword}%";
            $params[':keyword_phone'] = "{$keyword}%";
        }
        $sql .= " ORDER BY id ASC"; // Sắp xếp theo ID tăng dần cho file xuất

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
