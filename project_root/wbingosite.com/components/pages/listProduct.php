<?php
include("config/db.php");

// Lấy các giá trị từ form lọc
$brands = isset($_GET['brand']) ? $_GET['brand'] : [];
$priceRange = isset($_GET['price']) ? $_GET['price'] : '';

// Xây dựng câu lệnh SQL tùy thuộc vào các giá trị filter
$sql = "SELECT * FROM products WHERE 1";

// Lọc theo thương hiệu (brand)
if (!empty($brands)) {
    $brand_ids = implode(",", array_map('intval', $brands));
    $sql .= " AND brand_id IN ($brand_ids)";
}

// Lọc theo giá (price)
if (!empty($priceRange)) {
    switch ($priceRange) {
        case '0-100':
            $sql .= " AND price < 100";
            break;
        case '100-500':
            $sql .= " AND price BETWEEN 100 AND 500";
            break;
        case '500-1000':
            $sql .= " AND price BETWEEN 500 AND 1000";
            break;
        case '1000+':
            $sql .= " AND price > 1000";
            break;
    }
}

// Thực hiện truy vấn
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang sản phẩm</title>
</head>
<body>
    <div class="flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>Danh mục sản phẩm </h3>
            <form id="form_danhmuc" name="form_danhmuc" method="get">
                <h3>Theo Brand</h3>
                <?php
                // Lấy dữ liệu từ bảng brands:
                $sl = "SELECT id, name FROM brands";
                $kqloai = $conn->query($sl);

                // Hiển thị các brand dưới dạng checkbox
                while ($dloai = mysqli_fetch_array($kqloai)) {
                    ?>
                    <label>
                        <input type="checkbox" name="brand[]" value="<?php echo $dloai['id']; ?>" 
                               <?php echo in_array($dloai['id'], $brands) ? 'checked' : ''; ?>>
                        <?php echo htmlspecialchars($dloai['name']); ?>
                    </label><br>
                <?php } ?>

                <h3>Theo Giá</h3>
                <label><input type="radio" name="price" value="0-100" <?php echo $priceRange == '0-100' ? 'checked' : ''; ?>> Dưới 100K</label><br>
                <label><input type="radio" name="price" value="100-500" <?php echo $priceRange == '100-500' ? 'checked' : ''; ?>> 100K - 500K</label><br>
                <label><input type="radio" name="price" value="500-1000" <?php echo $priceRange == '500-1000' ? 'checked' : ''; ?>> 500K - 1M</label><br>
                <label><input type="radio" name="price" value="1000+" <?php echo $priceRange == '1000+' ? 'checked' : ''; ?>> Trên 1M</label><br>

                <button type="submit">Lọc sản phẩm</button>
            </form>
        </div>

        <!-- Danh sách sản phẩm -->
            <?php if ($result->num_rows > 0): ?>
                <?php while ($kqsp = $result->fetch_assoc()): ?>
                <div class="list">            
                    <div class="list-image">
                        <a href="ProductDetails.php?id=<?php echo $kqsp['id']; ?>">
                            <img src="/project_root/uploads/<?php echo htmlspecialchars($kqsp['image']); ?>" alt="Product Image">
                        </a>
                    </div>
                    <div class="list-specs">
                        <a href="ProductDetails.php?id=<?php echo $kqsp['id']; ?>" title="<?php echo htmlspecialchars($kqsp['name']); ?>">
                            <h3><?php echo htmlspecialchars($kqsp['name']); ?></h3>
                        </a>
                        <p><strong>RAM: </strong><?php echo htmlspecialchars($kqsp['ram']); ?> GB</p>
                        <p><strong>ROM: </strong><?php echo htmlspecialchars($kqsp['rom']); ?> GB</p>
                        <p><strong>Pin: </strong><?php echo htmlspecialchars($kqsp['battery']); ?> mAh</p>
                        <p><strong>Giá: <?php echo htmlspecialchars($kqsp['price']); ?> </strong></p>
                        <input type="number" id="soluong" name="soluong" value="1" min="1" max="100">
                    </div>
                    <div class="action">
                        <button id="btngiohang" name="btnmua"> Giỏ Hàng </button>
                        <button id="btnmua" name="btnmua"> Đặt mua </button>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Hiện không có sản phẩm nào</p>
            <?php endif; ?>
       
    </div>
</body>
</html>

<style>
        .flex {
            display: flex;
            margin-top: 20px;

        }

        .sidebar {
            width: 300px;
            background-color: antiquewhite;
            padding: 20px;
            margin-right: 10px;
        }

        .list {
            text-align: center;
            background-color: #ffffff;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            width: 200px;
            height: max-content;
            margin: 10px;
        }

        .list-image img {
            width: 150px;
            height: 150px;
        }

        .list-specs p {
            margin: 0;
        }
    </style>