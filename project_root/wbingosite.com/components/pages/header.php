<?php
// Kiểm tra xem session đã được khởi tạo hay chưa
include $_SERVER['DOCUMENT_ROOT'] . '/project_root/config/db.php'; // Đảm bảo đường dẫn đến db.php là chính xác

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Khởi tạo biến cho kết quả tìm kiếm
$searchResults = "";

// Kiểm tra nếu người dùng gửi form tìm kiếm
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchKeyword = $_GET['search'];

    // Chuẩn bị truy vấn SQL để tìm kiếm các brand chứa từ khóa
    $stmt = $conn->prepare("
        SELECT p.*, b.id AS brand_id 
        FROM products AS p
        JOIN brands AS b ON p.brand_id = b.id
        WHERE b.name LIKE ?
    ");
    $searchPattern = '%' . $searchKeyword . '%';
    $stmt->bind_param("s", $searchPattern);

    // Thực thi truy vấn
    $stmt->execute();
    $result = $stmt->get_result();

    // Xử lý kết quả tìm kiếm
    $brandIds = [];  // Mảng chứa các brand_id
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $brand =  $row['brand_id'];
            // Thêm brand_id vào mảng
            $brandIds[] = $brand;
        }

        // Chuyển hướng sau khi xử lý xong tất cả kết quả
        if (!empty($brandIds)) {
            $brandQuery = implode("&brand%5B%5D=", $brandIds); 
            // Chuyển mảng thành chuỗi
            header("Location: http://localhost/project_root/webPhone.php?brand%5B%5D=$brandQuery#sanpham");
            exit; // Đảm bảo dừng script sau khi chuyển hướng
        }
    } else {
        $searchResults = "<p>Không tìm thấy sản phẩm nào.</p>";
    }

    // Đóng kết nối
    $stmt->close();
   
}

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.14.0/dist/css/uikit.min.css" />

<header class="pc-header">
    <div class="header-upper">
        <div class="uk-container uk-container-1440">
            <div class="uk-flex uk-flex-between">
                <div class="header-contact">
                    <a class="header-contact__item contact-link" href="https://maps.app.goo.gl/uM34i8D48cWq3qmG8"
                        title="">
                        <span class="uk-icon" uk-icon="location"></span>
                        <span> Find Store</span>
                    </a>
                    <a class="header-contact__item contact-link" href="mailto:shopwbingstore@gmail.com" title="">
                        <span class="uk-icon" uk-icon="mail"></span>
                        <span>shopwbingstore@gmail.com</span>
                    </a>
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
                        <img src="wbingosite.com/resources/images/logo.png" alt="">
                    </a>
                </div>
                <div class="header-search">
                    <form action="" method="GET" class="uk-form">
                        <div class="form-row">
                            <input type="text" class="input-text" name="search" id="search" placeholder="Nhập tên sản phẩm ..."
                                autocapitalize="off">
                        </div>
                        <button type="submit" value="Search" name="submit" class="btn-search">
                            <span class="uk-icon" uk-icon="search"></span>
                        </button>
                    </form>

<!-- Hiển thị kết quả tìm kiếm -->
<div class="search-results">
    <?php echo $searchResults; ?>
</div>
                    <div class="most-searched">
                        <span class="search-item">Most Searched: </span>
                        
                        <!-- HTML Links -->
                        <a href="http://localhost/project_root/webPhone.php?brand%5B%5D=1#sanpham"
                            title="Iphone" class="search-item">Iphone</a>
                        <a href="http://localhost/project_root/webPhone.php?brand%5B%5D=1#sanpham"
                            title="Xiaomi" class="search-item">Xiaomi</a>
                        <a href="http://localhost/project_root/webPhone.php?brand%5B%5D=1#sanpham"
                            title="Vivo" class="search-item">Vivo</a>
                        <a href="http://localhost/project_root/webPhone.php?brand%5B%5D=1#sanpham"
                            title="Realme" class="search-item">Realme</a>
                        <a href="http://localhost/project_root/webPhone.php?brand%5B%5D=1#sanpham"
                            title="SamSung" class="search-item">SamSung</a>

                    </div>
                </div>
                <div class="header-widget">
                    <div class="uk-flex">

                        <a href="wbingosite.com/components/pages/card.php" class="widget-item">
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
                                    <span>Chào mừng,<br> <?php echo $_SESSION['username']; ?>!</span> <br>
                                    <a href="wbingosite.com/components/user/logout.php" class="btn-logout">Đăng xuất</a>
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
                                <span onclick="window.location.href='http://localhost/project_root/webPhone.php';"
                                    style="cursor: pointer;">All Department </span>
                        </div>
                        <nav class="navigation">
                            <ul class="clear-list uk-clearfix uk-flex main-menu">

                                <!-- Menu Shop với submenu -->
                                <li>
                                    <a href="#">Shop<i class="uk-icon" uk-icon="chevron-down"></i></a>
                                    <div class="uk-navbar-dropdown" uk-dropdown="mode: click; pos: bottom-left">
                                        <ul class="uk-nav uk-navbar-dropdown-nav">
                                            <li><a href="#sanpham">Sản phẩm mới</a></li>
                                            <li><a href="#sanpham">Khuyến mãi</a></li>
                                            <li><a href="#sanpham">Bán chạy</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <a href="" title="">Blog<i class="uk-icon" uk-icon="chevron-down"></i></a>
                                    <div class="uk-navbar-dropdown" uk-dropdown="mode: click; pos: bottom-left">
                                        <ul class="uk-nav uk-navbar-dropdown-nav">
                                            <li><a href="https://www.vivo.com/vn/products">Tin tức mới</a></li>
                                            <li><a href="https://www.mi.com/vn/">Tin tức nổi bật </a></li>
                                        </ul>
                                    </div>
                                </li>

                                <li>
                                    <a href="" title="">Page<i class="uk-icon" uk-icon="chevron-down"></i></a>
                                    <div class="uk-navbar-dropdown" uk-dropdown="mode: click; pos: bottom-left">
                                        <ul class="uk-nav uk-navbar-dropdown-nav">
                                            <li><a href="wbingosite.com/quanlynoidung/Gioithieu.php">Giới thiệu</a></li>
                                            <li><a href="wbingosite.com/quanlynoidung/chinhsach.php">Chính sách</a></li>
                                        </ul>
                                    </div>
                                </li>

                                <li>
                                    <a href="" title="">Vender<i class="uk-icon" uk-icon="chevron-down"></i></a>
                                    <div class="uk-navbar-dropdown" uk-dropdown="mode: click; pos: bottom-left">
                                        <ul class="uk-nav uk-navbar-dropdown-nav">
                                            <li><a href="#sanpham">Các sản phẩm</a></li>
                                            <li><a href="wbingosite.com/quanlynoidung/nhacungcap.php">Nhà cung cấp</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li>
                                    <a href="" title="">Contact<i class="uk-icon" uk-icon="chevron-down"></i></a>
                                    <div class="uk-navbar-dropdown" uk-dropdown="mode: click; pos: bottom-left">
                                        <ul class="uk-nav uk-navbar-dropdown-nav">
                                            <li><a href="#footer">Thông tin liên hệ</a></li>
                                            <li><a href="#footer">Hỗ trợ khách hàng</a></li>
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