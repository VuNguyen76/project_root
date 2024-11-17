<?php
// Kết nối đến cơ sở dữ liệu
include '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';

// Lấy ID đơn hàng từ URL
$orderId = $_GET['order_id'];

// Lấy thông tin chi tiết của đơn hàng
$orderDetailQuery = "SELECT products.name, products.image, order_items.quantity, order_items.price
                     FROM order_items
                     JOIN products ON order_items.product_id = products.id
                     WHERE order_items.order_id = $orderId";
$orderDetailResult = $conn->query($orderDetailQuery);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng</title>
   
</head>

<body>
    <h1>Chi Tiết Đơn Hàng</h1>
    <a href="http://localhost/project_root/templates/admin/manage_payments.php">Trở về </a>
    <?php
    if ($orderDetailResult->num_rows > 0) {
        while ($item = $orderDetailResult->fetch_assoc()) {
            echo "<div class='order-item-detail'>";
            echo "<img src='/project_root/uploads/" . htmlspecialchars($item['image']) . "' alt='Ảnh sản phẩm'>";
            echo "<div>";
            echo "<p><strong>Sản phẩm:</strong> " . htmlspecialchars($item['name']) . "</p>";
            echo "<p><strong>Số lượng:</strong> " . $item['quantity'] . "</p>";
            echo "<p><strong>Giá:</strong> " . number_format($item['price'], 2) . " VND</p>";
            echo "</div>";
            echo "</div>";
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
 <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 28px;
        }

        .order-item-detail {
            display: flex;
            align-items: center;
            background: #fff;
            margin: 20px auto;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        .order-item-detail img {
            max-width: 100px;
            max-height: 100px;
            margin-right: 20px;
            border-radius: 8px;
            object-fit: cover;
        }

        .order-item-detail p {
            margin: 5px 0;
            font-size: 18px;
        }

        form {
            max-width: 800px;
            margin: 20px auto;
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-size: 18px;
            margin-right: 10px;
        }

        select {
            font-size: 16px;
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            font-size: 16px;
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }
    </style>