<?php
// Kết nối đến cơ sở dữ liệu
include '../../config/db.php';

// Lấy ID đơn hàng từ URL
$orderId = $_GET['order_id'];

// Lấy thông tin chi tiết của đơn hàng
$orderDetailQuery = "SELECT products.name, order_items.quantity, order_items.price
                     FROM order_items
                     JOIN products ON order_items.product_id = products.id
                     WHERE order_items.order_id = $orderId";
$orderDetailResult = $conn->query($orderDetailQuery);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Đơn Hàng</title>
</head>

<body>
    <h1>Chi Tiết Đơn Hàng</h1>
    <?php
    if ($orderDetailResult->num_rows > 0) {
        while ($item = $orderDetailResult->fetch_assoc()) {
            echo "<div class='order-item-detail'>";
            echo "<p>Sản phẩm: " . htmlspecialchars($item['name']) . "</p>";
            echo "<p>Số lượng: " . $item['quantity'] . "</p>";
            echo "<p>Giá: " . number_format($item['price'], 2) . " VND</p>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>Không có sản phẩm nào trong đơn hàng này.</p>";
    }
    ?>

    <form method="POST" action="update_payment_status.php">
        <input type="hidden" name="order_id" value="<?php echo $orderId; ?>">
        <label for="status">Trạng thái thanh toán:</label>
        <select name="status" id="status">
            <option value="pending">Chưa thanh toán</option>
            <option value="completed">Đã thanh toán</option>
            <option value="cancelled">Bị hủy</option>
        </select>
        <button type="submit">Cập nhật</button>
    </form>
</body>

</html>

<?php
$conn->close();
?>