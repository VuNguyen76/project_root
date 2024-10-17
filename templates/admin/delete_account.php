<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /project_root/templates/auth/login.php');
    exit();
}

include '../../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Bắt đầu xóa bản ghi có ID nhất định
    $deleteQuery = "DELETE FROM users WHERE id='$id'";

    if ($conn->query($deleteQuery) === TRUE) {
        // Cập nhật lại các ID sau bản ghi bị xóa
        $updateIdQuery = "UPDATE users SET id = id - 1 WHERE id > '$id'";
        if ($conn->query($updateIdQuery) === TRUE) {
            // Truy vấn giá trị MAX(id) để sử dụng trong ALTER TABLE
            $result = $conn->query("SELECT MAX(id) AS max_id FROM users");
            $row = $result->fetch_assoc();
            $maxId = $row['max_id'];

            // Đặt lại AUTO_INCREMENT thành giá trị hợp lý sau khi cập nhật ID
            $resetAutoIncrementQuery = "ALTER TABLE users AUTO_INCREMENT = " . ($maxId + 1);
            $conn->query($resetAutoIncrementQuery);
        }

        header('Location: manage_accounts.php'); // Quay lại trang quản lý tài khoản
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
