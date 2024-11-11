<?php
// Kiểm tra xem session đã được khởi tạo hay chưa
include $_SERVER['DOCUMENT_ROOT'] . '/project_root/config/db.php'; // Đảm bảo đường dẫn đến db.php là chính xác

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.14.0/dist/css/uikit.min.css" />

<header class="pc-header">
    <div class="header-upper">
        <div class="uk-container uk-container-1440">
            <div class="uk-flex uk-flex-between">
                <div class="header-contact">
                    <a class="header-contact__item contact-link" href="" title="">
                        <span class="uk-icon" uk-icon="location"></span>
                        <span> Find Store</span>
                    </a>
                    <a class="header-contact__item contact-link" href="" title="">
                        <span class="uk-icon" uk-icon="mail"></span>
                        <span>shopwbingstore@gmail.com</span>
                    </a>
                </div>
                <div class="header-menu">
                    <a class="header-menu__item contact-link" title="" href="">Contract Us</a>
                    <a class="header-menu__item contact-link" title="" href="">Track Your Order</a>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="uk-container uk-container-1440">
            <div class="uk-flex uk-flex-between">
                <div class="logo">
                    <a href="/project_root/templates/auth/login.php" title="admin">
                        <!--Chỗ này thêm logo -->
                        <img src="resources/images/icon/the-gioi-di-dong-logo.png" alt="">
                    </a>
                </div>
                <div class="header-search">
                    <form action="" class="uk-form">
                        <div class="form-row">
                            <input type="text" class="input-text" value="" placeholder="Search Product..."
                                autocapitalize="off">
                        </div>
                        <div class="search-dropdown">
                            <div class="search-category-title">
                                <span>All Category</span>
                                <span class="uk-icon" uk-icon="chevron-down"></span>
                            </div>
                            <ul></ul>
                        </div>
                        <button class="btn-search">
                            <span class="uk-icon" uk-icon="search"></span>
                        </button>

                    </form>
                    <div class="most-searched">
                        <span class="search-item">Most Searched: </span>
                        <?php 
// Truy vấn lấy tất cả sản phẩm
$sql = "SELECT id FROM products ORDER BY RAND() LIMIT 1"; // Lấy một sản phẩm ngẫu nhiên
$result = $conn->query($sql);

// Kiểm tra nếu có sản phẩm
if ($result->num_rows > 0) {
    $random_product = $result->fetch_assoc();
    $iphone_product_id = $random_product['id']; // ID của sản phẩm ngẫu nhiên cho Iphone
} else {
    // Nếu không có sản phẩm, có thể đặt id mặc định hoặc thông báo lỗi
    $iphone_product_id = 1; // ID mặc định
}

// Lặp lại tương tự cho các thương hiệu khác
$sql_xiaomi = "SELECT id FROM products ORDER BY RAND() LIMIT 1";
$result_xiaomi = $conn->query($sql_xiaomi);
if ($result_xiaomi->num_rows > 0) {
    $random_product_xiaomi = $result_xiaomi->fetch_assoc();
    $xiaomi_product_id = $random_product_xiaomi['id'];
} else {
    $xiaomi_product_id = 1; // ID mặc định
}

$sql_nokia = "SELECT id FROM products ORDER BY RAND() LIMIT 1";
$result_nokia = $conn->query($sql_nokia);
if ($result_nokia->num_rows > 0) {
    $random_product_nokia = $result_nokia->fetch_assoc();
    $nokia_product_id = $random_product_nokia['id'];
} else {
    $nokia_product_id = 1; // ID mặc định
}

$sql_realme = "SELECT id FROM products ORDER BY RAND() LIMIT 1";
$result_realme = $conn->query($sql_realme);
if ($result_realme->num_rows > 0) {
    $random_product_realme = $result_realme->fetch_assoc();
    $realme_product_id = $random_product_realme['id'];
} else {
    $realme_product_id = 1; // ID mặc định
}

$sql_samsung = "SELECT id FROM products ORDER BY RAND() LIMIT 1";
$result_samsung = $conn->query($sql_samsung);
if ($result_samsung->num_rows > 0) {
    $random_product_samsung = $result_samsung->fetch_assoc();
    $samsung_product_id = $random_product_samsung['id'];
} else {
    $samsung_product_id = 1; // ID mặc định
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>

<!-- HTML Links -->
<a href="components/ProductDetails.php?id=<?php echo $iphone_product_id; ?>" title="Iphone" class="search-item">Iphone</a>
<a href="components/ProductDetails.php?id=<?php echo $xiaomi_product_id; ?>" title="Xiaomi" class="search-item">Xiaomi</a>
<a href="components/ProductDetails.php?id=<?php echo $nokia_product_id; ?>" title="Nokia" class="search-item">Nokia</a>
<a href="components/ProductDetails.php?id=<?php echo $realme_product_id; ?>" title="Realme" class="search-item">Realme</a>
<a href="components/ProductDetails.php?id=<?php echo $samsung_product_id; ?>" title="SamSung" class="search-item">SamSung</a>

                    </div>
                </div>
                <div class="header-widget">
                    <div class="uk-flex">

                        <a href="components\card.php" class="widget-item">
                            <span class="uk-icon" uk-icon="cart"></span>
                            <span class="number">0</span>
                        </a>
                        <a href="javascript:void(0);" class="widget-item" onclick="toggleAuthOptions()">
                            <span class="uk-icon" uk-icon="user"></span></a>
                        <!-- Menu thả xuống cho Đăng nhập/Đăng ký -->
                        <span class="widget-login">
                            <!-- Hiển thị khi người dùng đã đăng nhập -->
                            <?php if (isset($_SESSION['username'])): ?>
                                <div class="user-info">
                                    <span>Chào mừng, <?php echo $_SESSION['username']; ?>!</span>
                                    <a href="wbingosite.com/components/user/logout.php"
                                        class="btn-logout">Đăng xuất</a>
                                </div>
                            <?php else: ?>
                                <div id="authOptions" class="uk-dropdown uk-dropdown-bottom-left" uk-dropdown="mode: click; 
                                        pos: bottom-left" style="display: none;">
                                    <ul class="uk-nav uk-dropdown-nav">
                                        <!-- <li><a href="/project_root/templates/auth/login.php">Đăng nhập addmin</a></li> -->
                                        <li><a href="wbingosite.com/components/user/login.php">Đăng nhập</a>
                                        </li>
                                        <li><a href="wbingosite.com/components/user/register.php">Đăng ký</a>
                                        </li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-lower">
        <div class="uk-container uk-container-1440">
            <div class="uk-flex uk-flex-middle uk-flex-between">
                <div class="header-categories">
                    <div class="uk-flex uk-flex-middle">
                        <div class="department-wrapper">
                            <span>
                                <span
                                    onclick="window.location.href='http://localhost/project_root/home.php';"
                                    style="cursor: pointer;">All Department <i class="uk-icon"
                                        uk-icon="chevron-down"></i> </span>
                            </span>
                        </div>
                        <nav class="navigation">
                            <ul class="clear-list uk-clearfix uk-flex main-menu">
                                <li>
                                    <a href="" title="">Home<i class="uk-icon" uk-icon="chevron-down"></i></a>
                                </li>
                                <!-- Menu Shop với submenu -->
                                <li>
                                    <a href="#">Shop<i class="uk-icon" uk-icon="chevron-down"></i></a>
                                    <div class="uk-navbar-dropdown" uk-dropdown="mode: click; pos: bottom-left">
                                        <ul class="uk-nav uk-navbar-dropdown-nav">
                                            <li><a href="#">Sản phẩm mới</a></li>
                                            <li><a href="#">Khuyến mãi</a></li>
                                            <li><a href="#">Bán chạy</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <a href="" title="">Blog<i class="uk-icon" uk-icon="chevron-down"></i></a>
                                    <div class="uk-navbar-dropdown" uk-dropdown="mode: click; pos: bottom-left">
                                        <ul class="uk-nav uk-navbar-dropdown-nav">
                                            <li><a href="#">Tin tức mới</a></li>
                                            <li><a href="#">Chia sẻ kinh nghiệm</a></li>
                                        </ul>
                                    </div>
                                </li>

                                <li>
                                    <a href="" title="">Page<i class="uk-icon" uk-icon="chevron-down"></i></a>
                                    <div class="uk-navbar-dropdown" uk-dropdown="mode: click; pos: bottom-left">
                                        <ul class="uk-nav uk-navbar-dropdown-nav">
                                            <li><a href="#">Giới thiệu</a></li>
                                            <li><a href="#">Dịch vụ</a></li>
                                            <li><a href="#">Chính sách</a></li>
                                        </ul>
                                    </div>
                                </li>

                                <li>
                                    <a href="" title="">Vender<i class="uk-icon" uk-icon="chevron-down"></i></a>
                                    <div class="uk-navbar-dropdown" uk-dropdown="mode: click; pos: bottom-left">
                                        <ul class="uk-nav uk-navbar-dropdown-nav">
                                            <li><a href="#">Các sản phẩm</a></li>
                                            <li><a href="#">Nhà cung cấp</a></li>
                                        </ul>
                                    </div>
                                </li>

                                <li>
                                    <a href="" title="">Contact<i class="uk-icon" uk-icon="chevron-down"></i></a>
                                    <div class="uk-navbar-dropdown" uk-dropdown="mode: click; pos: bottom-left">
                                        <ul class="uk-nav uk-navbar-dropdown-nav">
                                            <li><a href="#">Thông tin liên hệ</a></li>
                                            <li><a href="#">Hỗ trợ khách hàng</a></li>
                                        </ul>
                                    </div>
                                </li>

                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="header-notice">
                    <div class="uk-flex uk-flex-middle">
                        <span class="icon uk-icon" uk-icon="check"></span>
                        <span>Free Shipping on Orders $300</span>
                    </div>
                </div>
            </div>
        </div>
</header>

<!-- <header class="mobile-header">
    <div class="header-upper">

    </div>
    <div class="header-middle"></div>
    <div class="header-lower"></div>
</header>
-->
<!-- JavaScript để hiện/ẩn menu -->
<script>
    function toggleAuthOptions() {
        var authOptions = document.getElementById("authOptions");
        authOptions.style.display = (authOptions.style.display === "none" || authOptions.style.display === "") ? "contents" : "none";
    }
</script>
<!-- Script UIkit -->
<script src="https://cdn.jsdelivr.net/npm/uikit@3.14.0/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.14.0/dist/js/uikit-icons.min.js"></script>