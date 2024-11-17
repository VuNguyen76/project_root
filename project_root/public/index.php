<?php
session_start();
include '../config/db.php'; // Đảm bảo rằng bạn có file kết nối database tại đây

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Tìm người dùng trong cơ sở dữ liệu
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Kiểm tra mật khẩu đã mã hóa
        if (password_verify($password, $user['password'])) {
            // Đăng nhập thành công
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Phân quyền dựa trên role (admin hoặc user)

            if ($user['role'] == 'admin') {
                header('Location: /public/admin_dashboard.php'); // Nếu là admin, chuyển hướng đến admin dashboard
            } else {
                header('Location: /wbingsite.com/home.php'); // Nếu là user, chuyển hướng đến trang home của người dùng
            }
            exit();
        } else {
            $error = "Sai mật khẩu!";
        }
    } else {
        $error = "Tên người dùng không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="/assets/css/styles.css"> <!-- Đảm bảo rằng bạn có file CSS tại đây -->
</head>

<body>
    <div class="login-container">
        <h2>Đăng nhập</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div>
                <label for="username">Tên người dùng</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Đăng nhập</button>
        </form>
    </div>
</body>

</html>