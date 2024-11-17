<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /templates/auth/login.php');
    exit();
}

include '../../config/db.php';

// Lấy danh sách sản phẩm từ database với các cột tương ứng, bao gồm cả cột image
$productQuery = "SELECT p.name, p.description, p.price, p.ram, p.rom, p.battery, p.image, b.name as brand_name 
                 FROM products p 
                 JOIN brands b ON p.brand_id = b.id";
$products = $conn->query($productQuery);

// Đếm tổng số lượng sản phẩm
$totalProducts = $products->num_rows;
?>

<link rel="stylesheet" type="text/css" href="/project_root/assets/css/product.css">
<div class="container">
    <div class="add-product">
    <a class="t-left" href="manage_products.php">Trở về </a>
        <div class="heading-1">
            <span>Danh sách sản phẩm</span>
        </div>

        <!-- Hiển thị tổng số lượng sản phẩm -->
        <div class="product-count">
            <h3>Hiện có <?php echo $totalProducts; ?> sản phẩm trong kho</h3>
        </div>

        <?php if ($products->num_rows > 0): ?>
            <?php while ($product = $products->fetch_assoc()): ?>
                <!-- Hiển thị tất cả các thuộc tính của sản phẩm -->
                <div class="product-grid">
                    <div class="product-item t-center">
                        <a href="" class="image">
                            <!-- Hiển thị hình ảnh sản phẩm từ cột image trong cơ sở dữ liệu -->
                            <img src="/project_root/uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image">
                        </a>
                        <div class="t20">
                            <div class="product-name">
                                <a href="" title="<?php echo htmlspecialchars($product['name']); ?>"><?php echo htmlspecialchars($product['name']); ?></a>
                            </div>
                            <div class="product-brand">
                                Thương hiệu: <?php echo htmlspecialchars($product['brand_name']); ?>
                            </div>
                            <div class="product-specs">
                                <p>RAM: <?php echo htmlspecialchars($product['ram']); ?> GB</p>
                                <p>ROM: <?php echo htmlspecialchars($product['rom']); ?> GB</p>
                                <p>Pin: <?php echo htmlspecialchars($product['battery']); ?> mAh</p>
                            </div>
                            <div class="product-price t-red">
                                <div class="price-sale"><?php echo number_format($product['price']); ?> đ</div>
                            </div>
                            <button><a href="update_product.php?name=<?php echo urlencode($product['name']); ?>">Sửa</a>
                            </button>

                            <button><a href="delete_product.php?name=<?php echo urlencode($product['name']); ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm <?php echo htmlspecialchars($product['name']); ?> không?')">Xóa</a>
                            </button>

                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Hiện không có sản phẩm nào</p>
        <?php endif; ?>

        <div class="clear-list"></div>
    </div>
</div>