<?php
session_start();
include("../../../config/db.php");

// Kiểm tra xem người dùng đã đăng nhập chưa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id']; // Lấy user_id từ session khi đã đăng nhập
    } else {
        // Nếu chưa đăng nhập, tạo user_id ngẫu nhiên
        if (!isset($_SESSION['guest_user_id'])) {
            $_SESSION['guest_user_id'] = uniqid('guest_'); // Tạo user_id ngẫu nhiên với tiền tố 'guest_'
        }
        $userId = $_SESSION['guest_user_id'];
    }
    $address = $conn->real_escape_string($_POST['address']);
    $totalAmount = (float)$_POST['total_amount'];
    $selectedProducts = json_decode($_POST['selected_products'], true);

    if (!is_array($selectedProducts) || empty($selectedProducts)) {
        die("Lỗi: Không có sản phẩm nào được chọn.");
    }

    $orderDate = date("Y-m-d H:i:s");
    $totalQuantity = 0; // Khởi tạo biến tổng số lượng

    // Thêm đơn hàng vào bảng orders
    $insertOrderQuery = "INSERT INTO orders (user_id, total_price, order_date, address, quantity) 
                         VALUES ('$userId', '$totalAmount', '$orderDate', '$address', '$totalQuantity')";
    if ($conn->query($insertOrderQuery) === TRUE) {
        $orderId = $conn->insert_id;

        // Thêm từng sản phẩm vào bảng order_items và tính tổng số lượng
        foreach ($selectedProducts as $item) {
            $productId = (int)$item['id'];
            $quantity = (int)$item['quantity'];
            $totalQuantity += $quantity; // Cộng dồn số lượng sản phẩm

            // Lấy giá của sản phẩm từ bảng products
            $productQuery = "SELECT price FROM products WHERE id = $productId";
            $productResult = $conn->query($productQuery);

            if ($productResult && $productResult->num_rows > 0) {
                $product = $productResult->fetch_assoc();
                $price = $product['price'];

                $insertOrderItemQuery = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                                         VALUES ('$orderId', '$productId', '$quantity', '$price')";
                if (!$conn->query($insertOrderItemQuery)) {
                    echo "Lỗi khi thêm sản phẩm vào đơn hàng: " . $conn->error;
                    exit();
                }
            } else {
                echo "Lỗi: Không tìm thấy sản phẩm với ID $productId.";
                exit();
            }
        }

        // Cập nhật lại tổng số lượng trong bảng orders
        $updateOrderQuery = "UPDATE orders SET quantity = '$totalQuantity' WHERE id = '$orderId'";
        if (!$conn->query($updateOrderQuery)) {
            echo "Lỗi khi cập nhật số lượng vào đơn hàng: " . $conn->error;
            exit();
        }

        // Thêm bản ghi thanh toán vào bảng payments
        $paymentStatus = 'pending'; // Trạng thái thanh toán ban đầu
        $insertPaymentQuery = "INSERT INTO payments (order_id, payment_date, amount, status, user_id) 
                               VALUES ('$orderId', '$orderDate', '$totalAmount', '$paymentStatus', '$userId')";
        if (!$conn->query($insertPaymentQuery)) {
            echo "Lỗi khi thêm thanh toán: " . $conn->error;
            exit();
        }

        // Lấy danh sách các sản phẩm đã mua từ bảng order_items
        $orderItemsQuery = "SELECT product_id FROM order_items WHERE order_id = '$orderId'";
        $orderItemsResult = $conn->query($orderItemsQuery);

        if ($orderItemsResult && $orderItemsResult->num_rows > 0) {
            $purchasedProductIds = [];
            while ($row = $orderItemsResult->fetch_assoc()) {
                $purchasedProductIds[] = $row['product_id']; // Lưu các product_id đã mua
            }

            if (!empty($purchasedProductIds)) {
                // Chuyển mảng thành chuỗi để sử dụng trong câu lệnh SQL
                $purchasedProductIdsStr = implode(',', $purchasedProductIds);

                // Xóa sản phẩm đã mua khỏi giỏ hàng
                if (isset($_SESSION['user_id'])) {
                    // Xóa các sản phẩm trong giỏ hàng của người dùng đã đăng nhập
                    $deleteCartQuery = "DELETE FROM cart WHERE customer_id = '$userId' AND product_id IN ($purchasedProductIdsStr)";
                } else {
                    // Xóa các sản phẩm trong giỏ hàng của khách
                    $deleteCartQuery = "DELETE FROM cart WHERE customer_id = '$userId' AND product_id IN ($purchasedProductIdsStr)";
                }

                // Thực thi câu lệnh xóa
                if (!$conn->query($deleteCartQuery)) {
                    echo "Lỗi khi xóa sản phẩm đã mua khỏi giỏ hàng: " . $conn->error;
                    exit();
                }
            }
        }

        // Chuyển hướng đến trang thành công
        header("Location: checkout_success.php");
        exit();
    } else {
        echo "Có lỗi xảy ra khi tạo đơn hàng: " . $conn->error;
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}

?>
