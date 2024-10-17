<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /project_root/templates/auth/login.php');
    exit();
}

$pageTitle = "Quản lý tài khoản"; // Tiêu đề trang

// Kết nối tới cơ sở dữ liệu
include '../../config/db.php';

// Lấy danh sách tài khoản từ database
$accountQuery = "SELECT * FROM users"; // Truy vấn lấy tất cả tài khoản
$accountResult = $conn->query($accountQuery); // Gán kết quả truy vấn cho biến

include '../../includes/header.php';  // Bao gồm header
include '../../includes/navbar.php';  // Bao gồm navbar
?>

<!-- Nội dung chính của trang quản lý tài khoản -->
<div class="well">
    <h1>Danh sách tài khoản</h1>
    <a href="add_account.php" class="btn btn-primary">Thêm tài khoản</a> <!-- Nút thêm tài khoản -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên người dùng</th>
                <th>Email</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($accountResult && $accountResult->num_rows > 0): ?>
                <?php while ($account = $accountResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $account['id']; ?></td>
                        <td><?php echo $account['username']; ?></td>
                        <td><?php echo $account['email']; ?></td>
                        <td>
                            <a href="edit_account.php?id=<?php echo $account['id']; ?>" class="btn btn-primary">Chỉnh sửa</a>
                            <a href="delete_account.php?id=<?php echo $account['id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này không?');">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Không có tài khoản nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php';  // Bao gồm footer 
?>

<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>