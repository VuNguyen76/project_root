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
                header('Location: http://localhost/project_root/wbingosite.com/home.php'); // Chuyển hướng đến trang người dùng
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
    <link rel="stylesheet" type="text/css" href="..\..\resources\css\login.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="login-container">
    <a href="http://localhost/project_root/wbingosite.com/home.php"><img src="../../resources/images/thoat.jpg" width="25px"></a>
        <div class="login-header">ĐĂNG NHẬP</div>
        <form method="POST" action="login.php">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" id="username" required placeholder="Tên người dùng ">
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" required placeholder="Mật khẩu">
            </div>
            <button class="login-button" type="submit">Log in</button>
            <div class="links">
                <p>Bạn đã chưa có tài khoản? <BR><a href="register.php">Đăng ký ngay</a> 
                <br><a href="forget.php">Quên Mật Khẩu</a>
            </p>
    </div>
</body>

</html>