<?php
// views/admin/logs.php
use vohoq\Bai01QuanlySv\Core\FlashMessage;

require_once __DIR__ . '/../../views/layout/header.php';
// <-- NẠP HEADER ĐÃ TẠO Ở BÀI 19
?>
<h1>Log Hoạt Động Của Người Dùng</h1>
<table style="margin-top: 20px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Thời gian</th>
            <th>User ID</th>
            <th>User Name</th>
            <th>Hành động</th>
            <th>Chi tiết</th>
            <th>Địa chỉ IP</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($logs)): ?>
            <tr>
                <td colspan="7">Không có log nào.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?php echo $log['id']; ?></td>
                    <td><?php echo $log['timestamp']; ?></td>
                    <td><?php echo $log['user_id'] ?? 'N/A'; ?></td>
                    <td><?php echo htmlspecialchars($log['user_name']
                            ?? 'System'); ?></td>
                    <td><strong><?php echo
                                htmlspecialchars($log['action']); ?></strong></td>
                    <td><?php echo htmlspecialchars($log['details']);
                        ?></td>
                    <td><?php echo $log['ip_address']; ?></td>
                </tr>
            <?php endforeach; ?>

        <?php endif; ?>
    </tbody>
</table>
<div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?action=logs&page=<?php echo $i; ?>"
            class="<?php echo ($i == $currentPage) ? 'active' : '';
                    ?>">
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
</div>
<?php
// NẠP FOOTER
require_once __DIR__ . '/../../views/layout/footer.php';
?>