<?php
session_start();
include '../../../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form đăng ký
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Mã hóa mật khẩu bằng password_hash()
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Kiểm tra xem tên người dùng hoặc email đã tồn tại chưa
    $checkQuery = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Nếu tên người dùng hoặc email đã tồn tại, hiển thị thông báo lỗi
        echo "Tên người dùng hoặc email đã tồn tại!";
    } else {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $insertQuery = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashedPassword', 'user')";

        if ($conn->query($insertQuery) === TRUE) {
            // Đăng ký thành công, chuyển hướng đến trang đăng nhập
            echo "Đăng ký thành công!";
            header('Location: login.php');
            exit();
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
</head>

<body>
    <h1>Đăng ký</h1>
    <form method="POST" action="register.php">
        <div>
            <label for="username">Tên người dùng:</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit">Đăng ký</button>
    </form>

    <p>Bạn đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
</body>

</html>