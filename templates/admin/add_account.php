<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /project_root/templates/auth/login.php');
    exit();
}

include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Thêm tài khoản mới
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Lấy mật khẩu từ form
    $role = $_POST['role']; // Lấy vai trò từ form

    // Mã hóa mật khẩu
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Kiểm tra xem tên người dùng hoặc email đã tồn tại chưa
    $checkQuery = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('Tên người dùng hoặc email đã tồn tại.');</script>";
    } else {
        // Chèn tài khoản mới vào cơ sở dữ liệu với role
        $insertQuery = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashedPassword', '$role')";
        if ($conn->query($insertQuery) === TRUE) {
            header('Location: manage_accounts.php'); // Quay lại trang quản lý tài khoản
            exit();
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }
}

include '../../includes/header.php';  // Bao gồm header
include '../../includes/navbar.php';  // Bao gồm navbar
?>

<!-- Nội dung chính của trang thêm tài khoản -->
<div class="well">
    <h1>Thêm tài khoản</h1>
    <form method="POST" action="add_account.php">
        <div class="form-group">
            <label for="username">Tên người dùng:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="role">Vai trò:</label>
            <select class="form-control" id="role" name="role" required>
                <option value="user">Người dùng</option>
                <option value="admin">Quản trị viên</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Thêm tài khoản</button>
    </form>
</div>

<?php include '../../includes/footer.php';  // Bao gồm footer 
?>

<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>