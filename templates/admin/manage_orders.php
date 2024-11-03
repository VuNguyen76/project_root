<?php
// Kết nối đến database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop_db1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy danh sách đơn hàng và thanh toán
$paymentQuery = "SELECT orders.id AS order_id, users.username, orders.order_date, payments.status, payments.amount 
                 FROM payments
                 JOIN orders ON payments.order_id = orders.id
                 JOIN users ON orders.user_id = users.id
                 ORDER BY orders.order_date DESC";
$paymentResult = $conn->query($paymentQuery);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản Lý Thanh Toán</title>
    <style>
        /* Thêm CSS cho bảng hiển thị */
    </style>
</head>

<body>
    <h1>Quản Lý Thanh Toán</h1>
    <div class="container">
        <h2>Danh Sách Thanh Toán</h2>
        <?php
        if ($paymentResult->num_rows > 0) {
            echo "<table><tr><th>ID Đơn Hàng</th><th>Khách Hàng</th><th>Ngày Đặt</th><th>Trạng Thái Thanh Toán</th><th>Số Tiền</th></tr>";
            while ($row = $paymentResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['order_id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>" . $row['order_date'] . "</td>";
                echo "<td>" . ($row['status'] == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán') . "</td>";
                echo "<td>" . number_format($row['amount'], 0) . " VND</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Không có thanh toán nào.</p>";
        }
        ?>
    </div>
</body>

</html>

<?php
$conn->close();
?>