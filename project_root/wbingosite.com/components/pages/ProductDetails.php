<?php
session_start();
include("../../../config/db.php");

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
<title>Chi tiết sản phẩm</title>
<link href="http://localhost/project_root/wbingosite.com/resources/css/ProductDetails.css" rel="stylesheet">

<form action="" method="POST"> <!-- Thay đổi URL theo yêu cầu -->
    <div class="product-container-details">
        <a href="http://localhost/project_root/webPhone.php">Quay lại</a>

        <!-- Khu vực hiển thị hình ảnh sản phẩm -->
        <div class="product-image-details">
            <img src="/project_root/uploads/<?php echo htmlspecialchars($product['image']); ?>" 
                 alt="<?php echo htmlspecialchars($product['name']); ?>">
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

            <!-- Nút thêm vào giỏ hàng và mua ngay -->
            <div class="purchase-buttons">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <button type="button" id="btngiohang" data-product-id="<?php echo $product['id']; ?>">Thêm Giỏ Hàng</button>
                <button type="button" id="btndatmua" data-product-id="<?php echo $product['id']; ?>">Mua hàng</button>
            </div>
        </div>
    </div>
</form>

<!-- JavaScript -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Hàm cập nhật số lượng giỏ hàng
        function updateCartCount() {
            fetch('wbingosite.com/components/acsion/cart_count.php')
                .then(response => response.json())
                .then(data => {
                    document.querySelector(".widget-item .number").textContent = data.count;
                })
                .catch(error => {
                    console.error("Lỗi khi cập nhật số lượng giỏ hàng:", error);
                });
        }

        // Gọi hàm cập nhật số lượng giỏ hàng khi tải trang
        updateCartCount();

        // Xử lý thêm sản phẩm vào giỏ hàng
        document.querySelectorAll("#btngiohang,#btndatmua").forEach(function (cartButton) {
        cartButton.addEventListener("click", function () {
            const productId = this.getAttribute("data-product-id");
            const listContainer = this.closest(".list");
            const quantityInput = listContainer ? listContainer.querySelector("#soluong") : null;
            const quantity = 1;

            if (!productId || !quantity) {
                console.error("Thông tin sản phẩm hoặc số lượng không hợp lệ.");
                alert("Có lỗi xảy ra: Thông tin sản phẩm hoặc số lượng không hợp lệ.");
                return;
            }

            fetch('wbingosite.com/components/acsion/add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Thêm vào giỏ hàng thành công!");
                        updateCartCount(); // Cập nhật số lượng giỏ hàng sau khi thêm sản phẩm
                    } else {
                        alert(data.message || "Có lỗi xảy ra khi thêm sản phẩm.");
                    }
                })
                .catch(error => {
                    console.error("Lỗi:", error);
                });
        });
    });
        // Xử lý mua hàng
        document.querySelector("#btndatmua").addEventListener("click", function () {
            const productId = this.getAttribute("data-product-id");

            if (!productId) {
                alert("Có lỗi xảy ra: Không có thông tin sản phẩm.");
                return;
            }

            // Chuyển hướng sang trang `card.php` với thông tin sản phẩm
            window.location.href = `card.php?product_id=${productId}&quantity=1`;
        });
    });
</script>
