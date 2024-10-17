<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    header('Location: /project_root/templates/auth/login.php');
    exit();
}

$pageTitle = "Admin Dashboard"; // Tiêu đề trang

// Kết nối tới cơ sở dữ liệu
include '../config/db.php';

// Lấy số lượng người dùng từ database
$userQuery = "SELECT COUNT(*) as user_count FROM users"; // Câu truy vấn đếm số user
$userResult = $conn->query($userQuery);

if ($userResult->num_rows > 0) {
    $userData = $userResult->fetch_assoc();
    $userCount = $userData['user_count'];
} else {
    $userCount = 0; // Trường hợp không có người dùng
}

// Đường dẫn đúng đến thư mục includes
include '../includes/header.php';  // Bao gồm header
include '../includes/navbar.php';  // Bao gồm navbar
?>

<!-- Nội dung chính của admin dashboard -->
<div class="well">
    <h1>Chào mừng đến trang Admin Dashboard</h1>
    <p>Chọn các mục quản lý ở thanh điều hướng bên trên.</p>
</div>

<!-- Thêm các phần thống kê -->
<div class="row">
    <div class="col-sm-3">
        <div class="well">
            <h4>Users</h4>
            <p><?php echo $userCount; ?> <!-- Hiển thị số lượng user --> </p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="well">
            <h4>Pages</h4>
            <p>100 Million</p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="well">
            <h4>Sessions</h4>
            <p>10 Million</p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="well">
            <h4>Bounce</h4>
            <p>30%</p>
        </div>
    </div>
</div>

<?php include '../includes/footer.php';  // Bao gồm footer 
?>

<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>