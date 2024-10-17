<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /project_root/templates/auth/login.php');
    exit();
}

include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Cập nhật tài khoản
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Mã hóa mật khẩu nếu người dùng nhập mật khẩu mới
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE users SET username='$username', email='$email', password='$hashedPassword' WHERE id='$id'";
    } else {
        // Nếu không có mật khẩu mới, chỉ cập nhật tên người dùng và email
        $updateQuery = "UPDATE users SET username='$username', email='$email' WHERE id='$id'";
    }

    if ($conn->query($updateQuery) === TRUE) {
        header('Location: manage_accounts.php'); // Quay lại trang quản lý tài khoản
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    // Lấy thông tin tài khoản hiện tại
    $id = $_GET['id'];
    $accountQuery = "SELECT * FROM users WHERE id='$id'";
    $accountResult = $conn->query($accountQuery);
    $account = $accountResult->fetch_assoc();
}

include '../../includes/header.php';  // Bao gồm header
include '../../includes/navbar.php';  // Bao gồm navbar
?>

<!-- Nội dung chính của trang chỉnh sửa tài khoản -->
<div class="well">
    <h1>Chỉnh sửa tài khoản</h1>
    <form method="POST" action="edit_account.php">
        <input type="hidden" name="id" value="<?php echo $account['id']; ?>">
        <div class="form-group">
            <label for="username">Tên người dùng:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $account['username']; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $account['email']; ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu mới (để trống nếu không thay đổi):</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
</div>

<?php include '../../includes/footer.php';  // Bao gồm footer 
?>

<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>