<?php
session_start();
include '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';

echo "<h1>Danh Sách Đơn Hàng</h1>";

// Lấy danh sách đơn hàng và tổng tiền của từng đơn hàng
$orderQuery = "SELECT orders.id, users.username, orders.order_date, orders.total_price 
               FROM orders 
               JOIN users ON orders.user_id = users.id 
               ORDER BY orders.order_date DESC";
$orderResult = $conn->query($orderQuery);
if ($orderResult->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Khách Hàng</th><th>Ngày Đặt</th><th>Tổng Tiền</th><th>Chi Tiết</th></tr>";
    while ($order = $orderResult->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $order['id'] . "</td>";
        echo "<td>" . htmlspecialchars($order['username']) . "</td>";
        echo "<td>" . $order['order_date'] . "</td>";
        echo "<td>" . number_format($order['total_price'], 0) . " VND</td>";
        echo "<td><a href='order_detail.php?order_id=" . $order['id'] . "'>Xem chi tiết</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Không có đơn hàng nào.</p>";
    // Debug: In ra số lượng bản ghi trả về
    echo "<p>Số lượng đơn hàng: " . $orderResult->num_rows . "</p>";
}


$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Đơn Hàng</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 20px;
    }

    h1 {
        text-align: center;
        color: #333;
        font-size: 28px;
        margin-bottom: 20px;
    }

    .t-left {
        display: inline-block;
        margin-bottom: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }

    .t-left:hover {
        background-color: #0056b3;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        margin: 0 auto;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #007bff;
        color: white;
        text-transform: uppercase;
        font-size: 14px;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    td a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }

    td a:hover {
        text-decoration: underline;
        color: #0056b3;
    }

    p {
        text-align: center;
        color: #666;
        font-size: 18px;
    }
</style>
</head>

<body>
