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
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Sản Phẩm - Cửa Hàng Điện Tử</title> <!-- Thêm tiêu đề cho trang -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="http://localhost/project_root/wbingosite.com/resources/css/pannel_product.css" />

</head>
<body>

<!-- Biển quảng cáo đầu trang -->
<!-- 
<div class="panel-baner">
    <div class="banner-container">
        <div class="container-mini">
            <div uk-slideshow="animation: face; autoplay: true; autoplay-interval: 5000">
                <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
                    <div class="uk-slideshow-items">
                        <div><img src="https://i.ytimg.com/vi/vMVwdSp489E/maxresdefault.jpg" alt="" uk-cover></div>
                        <div><img src="https://cdn.sforum.vn/sforum/wp-content/uploads/2021/11/Vivo-V23e-banner.jpg" alt="" uk-cover></div>
                        <div><img src="https://cdn.tgdd.vn/hoi-dap/1355217/banner-tgdd-800x300.jpg" alt="" uk-cover></div>
                    </div>
                    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href uk-slidenav-previous uk-slideshow-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href uk-slidenav-next uk-slideshow-item="next"></a>
                    <ul class="uk-slideshow-nav uk-dotnav uk-flex-center uk-position-bottom uk-position-medium"></ul>
                </div>
            </div>
        </div>
    </div>
</div> -->

 
<!-- Các cam kết : vận chuyển, trả hàng, thanh toán, hỗ trợ -->


<!-- Quảng cáo thứ 2 -->
<div class="panel-baner2">
    <div class="uk-child-width-1-2@m uk-child-width-1-2" uk-grid>
        <div class="banner2-image">
            <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                <img src="wbingosite.com/resources/images/Baner3.png" alt="">
                <img class="uk-transition-scale-up uk-position-cover" 
                src="wbingosite.com/resources/images/Baner2.jpg" alt="">
            </div>
        </div>
        <div class="banner2-image">
            <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                <img src="wbingosite.com/resources/images/Banner1.jpg" alt="">
                <img class="uk-transition-scale-up uk-position-cover" 
                src="wbingosite.com/resources/images/banner.jpg" alt="">
            </div>
        </div>
    </div>
</div>
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

<!-- Các danh mục sản phẩm -->
<div class="panel-Categories">
    <div class="uk-child-width-1-3@m uk-child-width-1-2@s" uk-grid>
        <div class="Categories">
            <div class="Categories-image">
                <img src="https://tse3.mm.bing.net/th?id=OIP.k0f4hzMAhDdOR_tLKgmIKgHaEK&pid=Api&P=0&h=180">
            </div>
            <ul class="uk-text-middle">
                <b>Samsung</b>
                <li><a href=""> Galaxy S23 Ultra</a></li>
                <li><a href=""> Galaxy Z Fold5</a></li>
                <li><a href=""> Galaxy Z Flip5</a></li>
                <li><a href=""> Galaxy A54</a></li>
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


<div class="ma5">
    <?php require_once 'wbingosite.com/components/pages/listProduct.php' ?>
</div>
</body>
</html>
