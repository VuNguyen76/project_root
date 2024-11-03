<?php
session_start();
include '../../config/db.php';

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
}

$conn->close();
