<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /templates/auth/login.php');
    exit();
}

include '../../config/db.php';

// Lấy danh sách sản phẩm từ database với các cột tương ứng
$productQuery = "SELECT p.name, p.description, p.price, p.ram, p.rom, p.battery, b.name as brand_name 
                 FROM products p 
                 JOIN brands b ON p.brand_id = b.id";
$products = $conn->query($productQuery);

// Đếm tổng số lượng sản phẩm
$totalProducts = $products->num_rows;
?>

<link rel="stylesheet" type="text/css" href="/project_root/wbingosite.com/resources/product.css">
<div class="container">
    <div class="add-product">
        <div class="heading-1 t-left"><span>Danh sách sản phẩm</span></div>

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
                            <!-- Hiển thị hình ảnh sản phẩm -->
                            <img src="https://tse1.mm.bing.net/th?id=OIP.vz3cycLecmyDwRm64tRxUgHaHa&pid=Api&P=0&h=180" alt="Product Image">
                        </a>
                        <div class=" t20">
                            <div class="product-name">
                                <a href="" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>
                            </div>
                            <div class="product-brand">
                                Thương hiệu: <?php echo $product['brand_name']; ?>
                            </div>
                            <div class="product-description">
                                Mô tả: <?php echo $product['description']; ?>
                            </div>
                            <div class="product-specs">
                                <p>RAM: <?php echo $product['ram']; ?> GB</p>
                                <p>ROM: <?php echo $product['rom']; ?> GB</p>
                                <p>Pin: <?php echo $product['battery']; ?> mAh</p>
                            </div>
                            <div class="product-price t-red">
                                <div class="price-sale"><?php echo number_format($product['price']); ?> đ</div>
                            </div>
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