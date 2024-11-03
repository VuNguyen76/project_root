<?php
// Kết nối đến cơ sở dữ liệu
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];

    // Cập nhật trạng thái thanh toán trong bảng `payments`
    $updatePaymentQuery = "UPDATE payments SET status = '$newStatus' WHERE order_id = $orderId";
    if ($conn->query($updatePaymentQuery) === TRUE) {
        echo "Trạng thái thanh toán đã được cập nhật thành công!";
    } else {
        echo "Lỗi khi cập nhật trạng thái thanh toán: " . $conn->error;
    }

    // Chuyển hướng quay lại danh sách đơn hàng
    header("Location: order_list.php");
    exit();
}

$conn->close();
