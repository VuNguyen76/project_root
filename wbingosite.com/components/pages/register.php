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
  <title>Đăng ký </title>
  <link rel="stylesheet" type="text/css" href="../resources/css/register.css" >
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div class="register-container">
  <div class="register-header">ĐĂNG KÝ</div>
      <form method="POST" action="register.php">
      <div class="input-group">
          <i class="fas fa-user"></i>
          <input type="text" name="username" id="username" require placeholder="Tên người dùng ">
      </div>
      <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="email" name="email" id="email" required  placeholder="Email">
      </div>
      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" id="password" required placeholder="Mật khẩu">
      </div>
      <button class="register-button" type="submit">Đăng ký </button>
      </form>
      <div class="links">
      <p>Bạn đã có tài khoản? <BR> <a href="login.php">Đăng nhập ngay</a></p>
    </div>
  </div>
</body>
</html>
