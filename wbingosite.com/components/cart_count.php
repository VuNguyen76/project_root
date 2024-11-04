<?php
session_start();

// Kiểm tra số lượng sản phẩm trong giỏ hàng từ session
$count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

// Trả về JSON chứa số lượng sản phẩm
echo json_encode(['count' => $count]);
