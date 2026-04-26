<?php
// src/Models/LogModel.php
namespace vohoq\Bai01QuanlySv\Models;

use vohoq\Bai01QuanlySv\Database;
use PDO;

class LogModel
{
    private $conn;
    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }
    /**
     * Lấy log có phân trang
     * (Logic này giống hệt SinhvienModel::getStudents)
     */
    public function getLogs($limit = 10, $offset = 0)
    {
        // --- BƯỚC 1: ĐẾM TỔNG SỐ BẢN GHI ---
        $stmtCount = $this->conn->prepare("SELECT COUNT(*) FROM activity_logs");

        $stmtCount->execute();
        $totalRecords = $stmtCount->fetchColumn();
        // --- BƯỚC 2: LẤY DỮ LIỆU LOG THEO PHÂN TRANG ---
        $sqlData = "SELECT * FROM activity_logs ORDER BY timestamp DESC LIMIT :limit OFFSET :offset";
        $stmtData = $this->conn->prepare($sqlData);
        $stmtData->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmtData->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmtData->execute();
        $logs = $stmtData->fetchAll(PDO::FETCH_ASSOC);
        // --- BƯỚC 3: TRẢ VỀ KẾT QUẢ ---
        return [
            'data' => $logs,
            'total' => $totalRecords

        ];
    }
}
