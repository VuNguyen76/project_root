<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['product_id']) && !empty($data['product_id'])) {
    $productId = $data['product_id'];

    // Kiểm tra nếu giỏ hàng chưa tồn tại thì tạo mới
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Thêm sản phẩm vào giỏ hàng (nếu chưa có)
    if (!in_array($productId, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $productId;
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ.']);
}