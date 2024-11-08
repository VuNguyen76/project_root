<?php
session_start();
include '../../config/db.php';

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
            echo "<div class='alert alert-danger text-center'>Sai mật khẩu!</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center'>Tài khoản không tồn tại!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        h1 {
            color: #007bff;
        }

        a {
            color: #007bff;
        }

        a:hover {
            color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <a href="http://localhost/project_root/wbingosite.com/home.php"><img src="../../wbingosite.com/resources/images/thoat.jpg" width="23px">Thoát</a>
        <h1 class="text-center">Đăng nhập</h1>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="username">Tên người dùng hoặc Email:</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
        </form>
        <div class="text-center mt-3">
            <a href="../../wbingosite.com/components/pages/forget.php">Quên mật khẩu?</a>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>