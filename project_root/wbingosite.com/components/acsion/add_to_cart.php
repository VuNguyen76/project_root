<?php
session_start();
include("../../../config/db.php"); // Kết nối CSDL

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['product_id']) && !empty($data['product_id'])) {
    $productId = $data['product_id'];

    // Kiểm tra nếu giỏ hàng chưa tồn tại thì tạo mới
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (isset($_SESSION['user_id'])) {
    $customerId = $_SESSION['user_id']; // Lấy customer_id từ session nếu người dùng đã đăng nhập
} else {
    // Nếu chưa đăng nhập, tạo một guest_user_id (hoặc có thể để lại khách hàng ẩn danh)
    if (!isset($_SESSION['guest_user_id'])) {
        $_SESSION['guest_user_id'] = uniqid('guest_');
    }
    $customerId = $_SESSION['guest_user_id'];
}
// Lấy thông tin sản phẩm từ CSDL
$productQuery = "SELECT * FROM products WHERE id = $productId";
$productResult = $conn->query($productQuery);


    // Thêm sản phẩm vào giỏ hàng (nếu chưa có)
    if (!in_array($productId, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $productId;
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ.']);
}
?>