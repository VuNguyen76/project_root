<?php
include("config/db.php");
// Lấy các giá trị từ form lọc
$brands = isset($_GET['brand']) ? $_GET['brand'] : [];
$priceRange = isset($_GET['price']) ? $_GET['price'] : '';
// Xây dựng câu lệnh SQL tùy thuộc vào các giá trị filter
$sql = "SELECT * FROM products WHERE 1";
// Lọc theo thương hiệu (brand)
if (!empty($brands)) {
    // Tách phần `id` trước dấu `#` trong các giá trị
    $brand_ids = implode(",", array_map(function ($val) {
        return intval(explode("#", $val)[0]); }, $brands));
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
<div id="sanpham" class="flex">
    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Danh mục sản phẩm </h4>
        <form id="form_danhmuc" name="form_danhmuc" method="get">
            <h3>Theo Brand</h3>
            <?php
            // Lấy dữ liệu từ bảng brands:
            $sl = "SELECT id, name FROM brands";
            $kqloai = $conn->query($sl);

            // Hiển thị các brand dưới dạng checkbox
            while ($dloai = mysqli_fetch_array($kqloai)) {
                ?>
               
                    <input type="checkbox" name="brand[]" value="<?php echo $dloai['id']; ?>" <?php echo in_array($dloai['id'], $brands) ? 'checked' : ''; ?>>
                    <?php echo htmlspecialchars($dloai['name']); ?>
               
                <br>
            <?php } ?>
            <h3>Theo Giá</h3>
            <label><input type="radio" name="price" value="0-100" <?php echo $priceRange == '0-100' ? 'checked' : ''; ?>>
                Dưới 100K</label><br>
            <label><input type="radio" name="price" value="100-500" <?php echo $priceRange == '100-500' ? 'checked' : ''; ?>> 100K - 500K</label><br>
            <label><input type="radio" name="price" value="500-1000" <?php echo $priceRange == '500-1000' ? 'checked' : ''; ?>> 500K - 1M</label><br>
            <label><input type="radio" name="price" value="1000+" <?php echo $priceRange == '1000+' ? 'checked' : ''; ?>>
                Trên 1M</label><br>

            <button type="submit">Lọc sản phẩm</button>
            <!-- Nút Xóa Lọc -->
            <button type="Reset" id="resetFilter">Xóa Lọc</button>
        </form>
    </div>
    <div class="danhsach">
        <!-- Danh sách sản phẩm -->
        <?php if ($result->num_rows > 0): ?>
            <?php while ($kqsp = $result->fetch_assoc()): ?>
                <div class="list">
                    <div class="list-image">
                        <a href="wbingosite.com/components/pages/ProductDetails.php?id=<?php echo $kqsp['id']; ?>">
                            <img src="/project_root/uploads/<?php echo htmlspecialchars($kqsp['image']); ?>"
                                alt="Product Image">
                        </a>
                    </div>
                    <div class="list-specs">
                        <span><a href="wbingosite.com/components/pages/ProductDetails.php?id=<?php echo $kqsp['id']; ?>"
                                title="<?php echo htmlspecialchars($kqsp['name']); ?>">
                                <?php echo htmlspecialchars($kqsp['name']); ?>
                            </a></span>
                        <p><strong>RAM: </strong><?php echo htmlspecialchars($kqsp['ram']); ?> GB</p>
                        <p><strong>ROM: </strong><?php echo htmlspecialchars($kqsp['rom']); ?> GB</p>
                        <p><strong>Pin: </strong><?php echo htmlspecialchars($kqsp['battery']); ?> mAh</p>
                        <p><strong>Giá: <?php echo number_format($kqsp['price'], 0, ',', '.') . ' VND'; ?> </strong></p>
                        <input type="number" id="soluong" name="soluong" value="1" min="1" max="100">
                        <button type="submit" id="btngiohang" data-product-id="<?php echo $kqsp['id']; ?>"> Thêm Giỏ
                            Hàng</button>
                        <button type="submit" id="btndatmua" data-product-id="<?php echo $kqsp['id']; ?>">Mua hàng</a></button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Hiện không có sản phẩm nào</p>
        <?php endif; ?>
    </div>
</div>

<!-- JavaScript to handle the cart button click event -->
<script>
   document.addEventListener("DOMContentLoaded", function () {
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

    // Gọi hàm này khi tải trang để hiển thị số lượng ban đầu
    updateCartCount();

    document.querySelectorAll("#btngiohang,#btndatmua").forEach(function (cartButton) {
        cartButton.addEventListener("click", function () {
            const productId = this.getAttribute("data-product-id");
            const listContainer = this.closest(".list");
            const quantityInput = listContainer ? listContainer.querySelector("#soluong") : null;
            const quantity = quantityInput ? quantityInput.value : null;

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
    document.querySelectorAll("#btndatmua").forEach(function (buyButton) {
        buyButton.addEventListener("click", function () {
            const productId = this.getAttribute("data-product-id");
            const quantityInput = this.closest(".list").querySelector("#soluong");
            const quantity = quantityInput ? quantityInput.value : 1;

            if (!productId || !quantity) {
                alert("Có lỗi xảy ra: Thông tin sản phẩm hoặc số lượng không hợp lệ.");
                return;
            }

            // Tạo mảng selectedProducts
            const selectedProducts = [
                { id: productId, quantity: quantity }
            ];

            // Chuyển mảng selectedProducts thành chuỗi query string
            const params = selectedProducts.map(product => 
                `product_id[]=${product.id}&quantity[]=${product.quantity}`
            ).join("&");
            // Chuyển hướng sang trang cart.php và truyền product_id qua query string
            if (productId) {
// Chuyển hướng sang cart.php và truyền thông tin qua GET
            window.location.href = `wbingosite.com/components/pages/card.php?${params}`;            } else {
                alert("Có lỗi xảy ra: Không có thông tin sản phẩm.");
            }

            
        });
    });
   
    // Thêm #sanpham vào URL sau khi form được gửi
    document.getElementById("form_danhmuc").addEventListener("submit", function (event) {
        event.preventDefault(); // Ngăn form gửi ngay lập tức
        const form = event.target;

        // Tạo URL mới từ form action và thêm #sanpham
        const url = new URL(form.action, window.location.origin);
        url.hash = "sanpham";

        // Gửi form theo phương thức GET tới URL mới
        const queryString = new URLSearchParams(new FormData(form)).toString();
        window.location.href = `${url.pathname}?${queryString}#sanpham`;
    });

    // Xóa bộ lọc khi nhấn nút "Xóa Lọc"
    document.getElementById("resetFilter").addEventListener("click", function () {
        // Reset tất cả các bộ lọc và reload trang
        const url = new URL(window.location.href);
        url.search = '';  // Xóa query string
        url.hash = "sanpham";  // Giữ lại phần hash #sanpham
        window.location.href = url.toString();
    });
});

</script>

</body>


</html>
<style>
    .flex {
        display: flex;
        margin-top: 20px;
    }

    .sidebar {
        width: 350px;
        background-color: antiquewhite;
        padding: 20px;
        margin: 5px 10px 0 50px;
        height: fit-content;
    }

    .list {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        text-align: center;
        background-color: #ffffff;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        width: 230px;
        height: auto;
        margin: 5px;
        transition: box-shadow 0.3s ease;
        /* Thêm hiệu ứng chuyển đổi */
    }

    .list:hover {
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        /* Hiệu ứng bóng khi di chuột */
    }

    .list-image {
        width: 200px;
        height: 200px;
        padding: 10px;
    }

    .list-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .list-specs {
        flex-grow: 1;
        height: fit-content;
    }

    .list-specs p {
        height: 5px;
        margin-top: 10px;
    }

    #btndatmua {
        margin-bottom: 10px;
    }

    .danhsach {
        display: flex;
        flex-wrap: wrap;
        /* Đảm bảo các phần tử sẽ xuống hàng nếu không đủ chỗ */
    }
</style>
