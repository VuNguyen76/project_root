<?php
session_start();
include '../../config/db.php';

// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Kiểm tra ID sản phẩm hợp lệ
if ($product_id > 0) {
    // Truy vấn chi tiết sản phẩm
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra nếu sản phẩm tồn tại
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy sản phẩm.";
        exit;
    }
} else {
    echo "ID sản phẩm không hợp lệ.";
    exit;
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
<title>chi tiết sản phẩm</title>
<!-- Bootstrap CSS -->
<link href="../resources\css\ProductDetails.css" rel="stylesheet">
<form action="handlePurchase.php" method="POST"> <!-- Thay đổi URL theo yêu cầu của bạn -->
    <div class="product-container-details">
    <a href="http://localhost/project_root/home.php">Quay lại </a>

        <!-- Khu vực hiển thị hình ảnh sản phẩm -->
        <div class="product-image-details">
            <?php
                echo '<img src="/project_root/uploads/' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '">';
            ?>
        </div>

        <!-- Khu vực thông tin chi tiết sản phẩm -->
        <div class="product-info-details">
            <div class="product-details">
                <span class="product-name-details">Tên sản phẩm: <?php echo htmlspecialchars($product['name']); ?></span>
                <span class="product-price-details">Giá sản phẩm: <?php echo number_format($product['price'], 0); ?> VNĐ</span>
                <span class="product-rom-details">ROM: <?php echo htmlspecialchars($product['rom']); ?> GB</span>
                <span class="product-ram-details">RAM: <?php echo htmlspecialchars($product['ram']); ?> GB</span>
                <span class="product-battery-details">Pin: <?php echo htmlspecialchars($product['battery']); ?> mAh</span>
                <div class="product-description-details">
                    Mô tả sản phẩm: <?php echo htmlspecialchars($product['description']); ?>
                </div>
            </div>

            <!-- Khu vực quản lý số lượng và trạng thái mua hàng -->
            <div>
                <p class="stock-status">Còn hàng</p>
                <div class="product-quantity-actions flex">
                    
                    <!-- Điều khiển số lượng sản phẩm -->
                    <div class="quantity-controls">
                        <label for="qty" class="d-none">Số lượng:</label>
                        <div class="quantity-buttons">
                            <button type="button" onclick="decreaseQuantity()">–</button>
                            <input type="number" id="qty" name="quantity" value="1" min="1">
                            <button type="button" onclick="increaseQuantity()">+</button>
                        </div>
                    </div>

                    <!-- Truyền ID sản phẩm ẩn -->
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                    <!-- Nút thêm vào giỏ hàng và mua ngay -->
                    <div class="purchase-buttons">
                        <button type="button" class="add-to-cart-button" data-product-id="<?php echo $product['id']; ?>">Thêm vào giỏ hàng</button>
                        <button type="submit" class="buy-now-button">Mua ngay</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

<!-- JavaScript cho chức năng tăng/giảm số lượng sản phẩm -->
<script>
    function increaseQuantity() {
        const qtyInput = document.getElementById('qty');
        qtyInput.value = parseInt(qtyInput.value) + 1;
    }

    function decreaseQuantity() {
        const qtyInput = document.getElementById('qty');
        if (qtyInput.value > 1) {
            qtyInput.value = parseInt(qtyInput.value) - 1;
        }
    }
</script>
