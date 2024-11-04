<?php
session_start();
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; // Đặt ID người dùng mặc định nếu không có user_id trong session
    $selectedProducts = json_decode($_POST['selected_products'], true);
    $totalAmount = $_POST['total_amount'];
    $orderDate = date("Y-m-d H:i:s");

    if (empty($selectedProducts)) {
        die("Lỗi: Không có sản phẩm nào được chọn.");
    }

    // Thêm đơn hàng vào bảng orders
    $insertOrderQuery = "INSERT INTO orders (user_id, order_date, total_price) VALUES ('$userId', '$orderDate', '$totalAmount')";
    if ($conn->query($insertOrderQuery) === TRUE) {
        $orderId = $conn->insert_id; // Lấy ID của đơn hàng vừa tạo

        // Thêm các sản phẩm vào bảng order_items
        foreach ($selectedProducts as $productId) {
            $productQuery = "SELECT price FROM products WHERE id = $productId";
            $productResult = $conn->query($productQuery);
            if ($productResult->num_rows > 0) {
                $product = $productResult->fetch_assoc();
                $price = $product['price'];
                $quantity = 1;

                $insertOrderItemQuery = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$orderId', '$productId', '$quantity', '$price')";
                if (!$conn->query($insertOrderItemQuery)) {
                    echo "Lỗi khi thêm sản phẩm vào đơn hàng: " . $conn->error;
                    exit();
                }
            } else {
                echo "Lỗi: Không tìm thấy sản phẩm với ID $productId.";
                exit();
            }
        }

        // Thêm bản ghi thanh toán vào bảng payments
        $paymentStatus = 'pending'; // Trạng thái thanh toán ban đầu
        $insertPaymentQuery = "INSERT INTO payments (order_id, payment_date, amount, status, user_id) VALUES ('$orderId', '$orderDate', '$totalAmount', '$paymentStatus', '$userId')";
        if (!$conn->query($insertPaymentQuery)) {
            echo "Lỗi khi thêm thanh toán: " . $conn->error;
            exit();
        }

        // Chuyển hướng đến trang xác nhận thành công
        header("Location: checkout_success.php");
        exit();
    } else {
        echo "Có lỗi xảy ra khi tạo đơn hàng: " . $conn->error;
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
