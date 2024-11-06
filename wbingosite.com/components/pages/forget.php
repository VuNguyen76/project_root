<?php
session_start();
include '../../../config/db.php';

$message = '';
$email_check = false; // Biến để kiểm tra xem email có tồn tại không

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        // Truy vấn để kiểm tra xem email có tồn tại trong cơ sở dữ liệu không
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $email_check = true; // Đánh dấu là email tồn tại
        } else {
            $message = "Email không tồn tại!"; // Thông báo nếu không tìm thấy email
        }
    }

    // Nếu email hợp lệ và người dùng đã nhập mật khẩu mới
    if (isset($_POST['new_password']) && $email_check) {
        $new_password = $_POST['new_password'];
        // Băm mật khẩu mới
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Cập nhật mật khẩu mới vào cơ sở dữ liệu thông qua email
        $update_query = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
        if ($conn->query($update_query) === TRUE) {
            $message = "Cập nhật mật khẩu thành công!"; // Thông báo thành công
        } else {
            $message = "Lỗi khi cập nhật mật khẩu: " . $conn->error; // Thông báo lỗi chi tiết
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu</title>
    <link rel="stylesheet" type="text/css" href="..\..\resources\css\login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-header">QUÊN MẬT KHẨU</div>

        <!-- Ẩn form nhập email khi tìm thấy email -->
        <?php if (!$email_check): ?>
            <form method="POST" action="forget.php">
                <div class="input-group">
                    <input type="email" name="email" required placeholder="Nhập email của bạn">
                </div>
                <button class="login-button" type="submit">Gửi Yêu Cầu</button>
            </form>
        <?php else: ?>
            <!-- Hiển thị form để người dùng nhập mật khẩu mới -->
            <form method="POST" action="forget.php">
                <div class="input-group">
                    <input type="password" name="new_password" required placeholder="Nhập mật khẩu mới">
                </div>
                <button class="login-button" type="submit">Cập Nhật Mật Khẩu</button>
                <input type="hidden" name="email" value="<?php echo $email; ?>"> <!-- Lưu lại email để sử dụng -->
            </form>
        <?php endif; ?>

        <!-- Hiển thị thông báo nếu có -->
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
            <?php // Chuyển hướng về trang đăng nhập sau 2 giây
            header("refresh:2; url=http://localhost/project_root/wbingosite.com/home.php");
           ?> 
            <?php endif; ?>
    </div>
</body>
</html>
