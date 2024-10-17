<?php
session_start();
include '../../../config/db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // Mật khẩu người dùng nhập vào

    // Truy vấn để lấy thông tin người dùng từ cơ sở dữ liệu
    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Sử dụng password_verify() để so sánh mật khẩu đã hash
        if (password_verify($password, $user['password'])) {
            // Đặt giá trị cho session
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Giả sử bạn có cột role trong bảng users

            // Chuyển hướng đến trang admin hoặc người dùng
            if ($user['role'] == 'admin') {
                header('Location: /project_root/public/admin_dashboard.php');
            } else {
                header('Location: /project_root/wbingosite.com/home.php'); // Chuyển hướng đến trang người dùng
            }
            exit();
        } else {
            echo "Sai mật khẩu!";
        }
    } else {
        echo "Tài khoản không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
</head>

<body>
    <h1>Đăng nhập</h1>
    <form method="POST" action="login.php">
        <div>
            <label for="username">Tên người dùng hoặc Email:</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div>
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit">Đăng nhập</button>
    </form>
    <p>Bạn đã chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
</body>

</html>