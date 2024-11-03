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

// Lấy danh sách đơn hàng cùng với trạng thái thanh toán
$orderQuery = "
    SELECT orders.id, users.username, orders.order_date, orders.total_price, payments.status
    FROM orders
    JOIN users ON orders.user_id = users.id
    LEFT JOIN payments ON orders.id = payments.order_id
    ORDER BY orders.order_date DESC";
$orderResult = $conn->query($orderQuery);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh Sách Đơn Hàng</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Danh Sách Đơn Hàng</h1>
    <?php
    if ($orderResult->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Khách Hàng</th><th>Ngày Đặt</th><th>Trạng Thái Thanh Toán</th><th>Tổng Tiền</th><th>Chi Tiết</th></tr>";

        while ($row = $orderResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td>" . $row['order_date'] . "</td>";

            // Hiển thị trạng thái thanh toán với 3 trạng thái: Chưa thanh toán, Đã thanh toán, Bị hủy
            switch ($row['status']) {
                case 'completed':
                    echo "<td>Đã thanh toán</td>";
                    break;
                case 'cancelled':
                    echo "<td>Bị hủy</td>";
                    break;
                default:
                    echo "<td>Chưa thanh toán</td>";
                    break;
            }

            echo "<td>" . number_format($row['total_price'], 0) . " VND</td>";
            echo "<td><a href='order_detail.php?order_id=" . $row['id'] . "'>Xem chi tiết</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Không có đơn hàng nào.</p>";
    }

    $conn->close();
    ?>
</body>

</html>