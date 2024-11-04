<?php
session_start();

if (isset($_GET['product_id']) && in_array($_GET['product_id'], $_SESSION['cart'])) {
    $_SESSION['cart'] = array_diff($_SESSION['cart'], [$_GET['product_id']]);
}

header("Location: card.php"); // Điều hướng lại giỏ hàng sau khi xóa
exit;
