<?php
// Include file kết nối cơ sở dữ liệu
include '../../config/db.php';


// Kiểm tra xem tên sản phẩm đã được truyền qua URL chưa
if (isset($_GET['name'])) {
    $product_name = $_GET['name'];

    // Thực hiện câu lệnh SQL để xóa sản phẩm theo tên
    $sql = "DELETE FROM products WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $product_name);

    if ($stmt->execute()) {
        // Nếu xóa thành công, chuyển hướng về trang danh sách sản phẩm
        header('Location: product.php?msg=Sản phẩm đã được xóa thành công');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Tên sản phẩm không hợp lệ.";
}
?>
