<?php
include $_SERVER['DOCUMENT_ROOT'] . '/project_root/config/db.php'; // Đảm bảo đường dẫn đến db.php là chính xác

// Hàm lấy sản phẩm theo thương hiệu
function getProductsByBrand($brand_id, $conn)
{
    $query = "SELECT products.*, brands.name AS brand_name 
              FROM products 
              JOIN brands ON products.brand_id = brands.id 
              WHERE products.brand_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $brand_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="/project_root/wbingosite.com/resources/css/pannel_product.css" />
<!--Biển quảng cáo đầu trang-->
<div class="panel-baner">
    <div class="banner-container">
        <div class="container-mini">
            <div uk-slideshow="animation: face; autoplay: true; autoplay-interval: 5000">
                <div class="  uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
                    <div class="uk-slideshow-items">
                        <div>
                            <img src="https://i.ytimg.com/vi/vMVwdSp489E/maxresdefault.jpg" alt="" uk-cover>
                        </div>
                        <div>
                            <img src="https://cdn.sforum.vn/sforum/wp-content/uploads/2021/11/Vivo-V23e-banner.jpg" alt="" uk-cover>
                        </div>
                        <div>
                            <img src="https://cdn.tgdd.vn/hoi-dap/1355217/banner-tgdd-800x300.jpg" alt="" uk-cover>
                        </div>
                    </div>
                    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href uk-slidenav-previous uk-slideshow-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href uk-slidenav-next uk-slideshow-item="next"></a>
                    <ul class="uk-slideshow-nav uk-dotnav uk-flex-center uk-position-bottom uk-position-medium"></ul>
                    <ul>
                        <li class="uk-position-bottom"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Các cam kết :vận chuyển ,trả hàng , thanh toán , hỗ trợ  -->
<div class="panel-commit">
    <div class="uk-child-width-1-4" uk-grid>
        <div class="commit">
            <i class="fas fa-truck red"></i>
            <p class="icon-text">Miễn phí vận chuyển <br> cho đơn hàng trên 500.000đ</p>
        </div>
        <div class="commit">
            <i class="fas fa-sync red"></i>
            <p class="icon-text">Đổi trả dễ dàng trong 7 ngày</p>
        </div>
        <div class="commit">
            <i class="fab fa-cc-amazon-pay red"></i>
            <p class="icon-text">Thanh toán an toàn bảo mật</p>
        </div>
        <div class="commit">
            <i class="fab fa-napster red"></i>
            <p class="icon-text">Hỗ trợ khách hàng 24/7</p>
        </div>
    </div>

</div>
<div class="t28"> Các danh mục hànng đầu </div>

<div class="panel-Categories">
    <div class="uk-child-width-1-3@m uk-child-width-1-2@s" uk-grid>
        <div class="Categories">
            <div class="Categories-image">
                <img src="https://tse3.mm.bing.net/th?id=OIP.k0f4hzMAhDdOR_tLKgmIKgHaEK&pid=Api&P=0&h=180">
            </div>
            <ul class="uk-text-middle">
                <b>Samsung</b>
                <li><a href="">Samsung Galaxy S23 Ultra</a></li>
                <li><a href="">Samsung Galaxy Z Fold5</a></li>
                <li><a href="">Samsung Galaxy Z Flip5</a></li>
                <li><a href="">Samsung Galaxy A54</a></li>
            </ul>
        </div>
        <div class="Categories">
            <div class="Categories-image">
                <img src="https://tse2.mm.bing.net/th?id=OIP.qpK3uezauc3qf-V1KTC_nAHaEK&pid=Api&P=0&h=180">
            </div>
            <ul class="uk-text-middle">
                <b>Oppo</b>
                <li><a href="">OPPO Find X6 Pro</a></li>
                <li><a href="">OPPO Find N2</a></li>
                <li><a href="">OPPO Reno10 Pro+</a></li>
                <li><a href="">OPPO Find X5 Pro</a></li>
            </ul>
        </div>
        <div class="Categories">
            <div class="Categories-image">
                <img src="https://tse4.mm.bing.net/th?id=OIP._cvEaEmrSyJ0JALpqSC7ngHaEK&pid=Api&P=0&h=180">
            </div>
            <ul class="uk-text-middle">
                <b>Redmi</b>
                <li><a href="">Redmi Note 12 Pro+</a></li>
                <li><a href="">Redmi K60 Pro</a></li>
                <li><a href="">Redmi Note 12 Turbo</a></li>
                <li><a href="">Redmi K50 Ultra</a></li>
            </ul>
        </div>
    </div>
</div>
<!--  quảng cáo thứ 2(2 sản phẩm nổi bật nhất) -->
<div class="panel-baner2">
    <div class="uk-child-width-1-2@m uk-child-width-1-2" uk-grid>
        <div class="banner2-image">
            <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                <img src="https://didongviet.vn/dchannel/wp-content/uploads/2023/11/x_1200x630.png" alt="">
                <img class="uk-transition-scale-up uk-position-cover" src="https://tse4.mm.bing.net/th?id=OIP.YwWU1m6y23R8sP8XXNZGmAHaD4&pid=Api&P=0&h=180" alt="">
            </div>
        </div>
        <div class="banner2-image">
            <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                <img src="http://ngocthoshop.vn/uploads/images/Banners%20-%20Slide/Banner%201-%20Dien%20thoai%20-%20Phu%20kien.jpg" alt="">
                <img class="uk-transition-scale-up uk-position-cover" src="https://kinhtehaiphong.vn/wp-content/uploads/2023/02/1-2.jpg" alt="">
            </div>
        </div>
    </div>
</div>
<div class="panel-product">
    <div class="uk-section uk-section-muted">

        <!-- Panel sản phẩm -->
        <div class="panel-product">
            <div class="uk-section uk-section-muted">
                <div class="pannel-product-container">
                    <h3>iPhone</h3>
                    <div class="uk-grid-match uk-child-width-1-5@m uk-child-width-1-3@s uk-child-width-1-2@xs" uk-grid>
                        <?php
                        $products = getProductsByBrand(1, $conn); // Giả sử brand_id = 1 là iPhone
                        while ($product = $products->fetch_assoc()) {
                            echo '<div class="uk-card uk-card-default">';
                            echo '<div class="uk-card-body">';

                            // Hiển thị hình ảnh sản phẩm
                            echo '<div class="product-image">';
                            echo '<a href="#"><img src="/project_root/uploads/' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '"></a>';
                            echo '</div>';

                            // Hiển thị tên sản phẩm và thương hiệu
                            echo '<div class="product-name"><a href="#" title="' . htmlspecialchars($product['name']) . '"><h2>' . htmlspecialchars($product['name']) . '</h2></a></div>';
                            echo '<div class="product-brand"><strong>Thương hiệu:</strong> ' . htmlspecialchars($product['brand_name']) . '</div>';

                            // Hiển thị mô tả sản phẩm
                            echo '<div class="product-description"><strong>Mô tả:</strong> ' . htmlspecialchars($product['description']) . '</div>';

                            // Hiển thị thông tin RAM, ROM và pin
                            echo '<div class="product-specs">';
                            echo '<p><strong>RAM:</strong> ' . htmlspecialchars($product['ram']) . '</p>';
                            echo '<p><strong>ROM:</strong> ' . htmlspecialchars($product['rom']) . '</p>';
                            echo '<p><strong>Pin:</strong> ' . htmlspecialchars($product['battery']) . '</p>';
                            echo '</div>';

                            // Hiển thị giá bán
                            echo '<div class="product-price"><div class="price-sale">' . number_format($product['price'], 0) . ' đ</div></div>';

                            // Nút giỏ hàng và trạng thái với thẻ <a> chứa data-product-id
                            echo '<div class="product-sold color-2">
                            <a href="javascript:void(0);" class="fas fa-shopping-cart red" data-product-id="' . htmlspecialchars($product['id']) . '"></a>
                            <div class="status"><span>Còn hàng</span></div>
                          </div>';

                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Sản phẩm iPhone -->
                <div class="pannel-product-container">
                    <h3>Oppo</h3>
                    <div class="uk-grid-match uk-child-width-1-5@m uk-child-width-1-3@s uk-child-width-1-2@xs" uk-grid>
                        <?php
                        $products = getProductsByBrand(2, $conn); // Giả sử brand_id = 2 là iPhone
                        while ($product = $products->fetch_assoc()) {
                            echo '<div class="uk-card uk-card-default">';
                            echo '<div class="uk-card-body">';

                            // Hiển thị hình ảnh sản phẩm
                            echo '<div class="product-image">';
                            echo '<a href="#"><img src="/project_root/uploads/' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '"></a>';
                            echo '</div>';

                            // Hiển thị tên sản phẩm và thương hiệu
                            echo '<div class="product-name"><a href="#" title="' . htmlspecialchars($product['name']) . '"><h2>' . htmlspecialchars($product['name']) . '</h2></a></div>';
                            echo '<div class="product-brand"><strong>Thương hiệu:</strong> ' . htmlspecialchars($product['brand_name']) . '</div>';

                            // Hiển thị mô tả sản phẩm
                            echo '<div class="product-description"><strong>Mô tả:</strong> ' . htmlspecialchars($product['description']) . '</div>';

                            // Hiển thị thông tin RAM, ROM và pin
                            echo '<div class="product-specs">';
                            echo '<p><strong>RAM:</strong> ' . htmlspecialchars($product['ram']) . '</p>';
                            echo '<p><strong>ROM:</strong> ' . htmlspecialchars($product['rom']) . '</p>';
                            echo '<p><strong>Pin:</strong> ' . htmlspecialchars($product['battery']) . '</p>';
                            echo '</div>';

                            // Hiển thị giá bán
                            echo '<div class="product-price"><div class="price-sale">' . number_format($product['price'], 0) . ' đ</div></div>';

                            // Nút giỏ hàng và trạng thái
                            // Nút giỏ hàng và trạng thái
                            echo '<div class="product-sold color-2">
        <a href="javascript:void(0);" class="fas fa-shopping-cart red" data-product-id="' . htmlspecialchars($product['id']) . '"></a>
        <div class="status"><span>Còn hàng</span></div>
      </div>';



                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Sản phẩm Redmi -->
                <div class="pannel-product-container">
                    <h3>Redmi</h3>
                    <div class="uk-grid-match uk-child-width-1-5@m uk-child-width-1-3@s uk-child-width-1-2@xs" uk-grid>
                        <?php
                        $products = getProductsByBrand(3, $conn); // Giả sử brand_id = 3 là Redmi
                        while ($product = $products->fetch_assoc()) {
                            echo '<div class="uk-card uk-card-default">';
                            echo '<div class="uk-card-body">';

                            // Hiển thị hình ảnh sản phẩm
                            echo '<div class="product-image">';
                            echo '<a href="#"><img src="/project_root/uploads/' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '"></a>';
                            echo '</div>';

                            // Hiển thị tên sản phẩm và thương hiệu
                            echo '<div class="product-name"><a href="#" title="' . htmlspecialchars($product['name']) . '"><h2>' . htmlspecialchars($product['name']) . '</h2></a></div>';
                            echo '<div class="product-brand"><strong>Thương hiệu:</strong> ' . htmlspecialchars($product['brand_name']) . '</div>';

                            // Hiển thị mô tả sản phẩm
                            echo '<div class="product-description"><strong>Mô tả:</strong> ' . htmlspecialchars($product['description']) . '</div>';

                            // Hiển thị thông tin RAM, ROM và pin
                            echo '<div class="product-specs">';
                            echo '<p><strong>RAM:</strong> ' . htmlspecialchars($product['ram']) . '</p>';
                            echo '<p><strong>ROM:</strong> ' . htmlspecialchars($product['rom']) . '</p>';
                            echo '<p><strong>Pin:</strong> ' . htmlspecialchars($product['battery']) . '</p>';
                            echo '</div>';

                            // Hiển thị giá bán
                            echo '<div class="product-price"><div class="price-sale">' . number_format($product['price'], 0) . ' đ</div></div>';

                            // Nút giỏ hàng và trạng thái
                            // Nút giỏ hàng và trạng thái
                            echo '<div class="product-sold color-2">
        <a href="javascript:void(0);" class="fas fa-shopping-cart red" data-product-id="' . htmlspecialchars($product['id']) . '"></a>
        <div class="status"><span>Còn hàng</span></div>
      </div>';



                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>


        <?php
        $conn->close();
        ?>
        <!-- JavaScript để xử lý sự kiện bấm vào giỏ hàng -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".fas.fa-shopping-cart.red").forEach(function(cartIcon) {
                    cartIcon.addEventListener("click", function() {
                        const productId = this.getAttribute("data-product-id");

                        if (!productId) {
                            console.error("ID sản phẩm không hợp lệ.");
                            alert("Có lỗi xảy ra: ID sản phẩm không hợp lệ.");
                            return;
                        }

                        fetch('/project_root/wbingosite.com/components/add_to_cart.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    product_id: productId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert("Đã thêm sản phẩm vào giỏ hàng!");
                                    updateCartCount(); // Gọi hàm cập nhật số lượng giỏ hàng
                                } else {
                                    alert(data.message || "Có lỗi xảy ra khi thêm sản phẩm.");
                                }
                            })
                            .catch(error => {
                                console.error("Lỗi:", error);
                            });
                    });
                });

                // Hàm để cập nhật số lượng sản phẩm trong giỏ hàng
                function updateCartCount() {
                    fetch('/project_root/wbingosite.com/components/cart_count.php')
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
            });
        </script>