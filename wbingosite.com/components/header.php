<?php
// Kiểm tra xem session đã được khởi tạo hay chưa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
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
                            <input
                                type="text"
                                class="input-text"
                                value=""
                                placeholder="Search Product..."
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
                        <a href="" title="" class="search-item">Iphone</a>
                        <a href="" title="" class="search-item">Flycam</a>
                        <a href="" title="" class="search-item">Xiaomi</a>
                        <a href="" title="" class="search-item">Nokia</a>
                        <a href="" title="" class="search-item">Realme</a>
                        <a href="" title="" class="search-item">SamSung</a>
                        <a href="" title="" class="search-item">Dell</a>
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
                                    <a href="/project_root/wbingosite.com/components/pages/logout.php" class="btn-logout">Đăng xuất</a>
                                </div>
                            <?php else: ?>
                                <div id="authOptions" class="uk-dropdown uk-dropdown-bottom-left" uk-dropdown="mode: click; 
                                        pos: bottom-left" style="display: none;">
                                    <ul class="uk-nav uk-dropdown-nav">
                                        <!-- <li><a href="/project_root/templates/auth/login.php">Đăng nhập addmin</a></li> -->
                                        <li><a href="/project_root/wbingosite.com/components/pages/login.php">Đăng nhập</a></li>
                                        <li><a href="/project_root/wbingosite.com/components/pages/register.php">Đăng ký</a></li>
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
                                <span>All Department <i class="uk-icon" uk-icon="chevron-down"></i> </span>
                            </span>
                        </div>
                        <nav class="navigation">
                            <ul class="clear-list uk-clearfix uk-flex main-menu">
                                <li>
                                    <a href="" title="">Home<i class="uk-icon" uk-icon="chevron-down"></i></a>
                                </li>
                                <li>
                                    <a href="" title="">Shop<i class="uk-icon" uk-icon="chevron-down"></i></a>
                                </li>
                                <li>
                                    <a href="" title="">Blog<i class="uk-icon" uk-icon="chevron-down"></i></a>
                                </li>
                                <li>
                                    <a href="" title="">Page<i class="uk-icon" uk-icon="chevron-down"></i></a>
                                </li>
                                <li>
                                    <a href="" title="">vender<i class="uk-icon" uk-icon="chevron-down"></i></a>
                                </li>
                                <li>
                                    <a href="" title="">Contact<i class="uk-icon" uk-icon="chevron-down"></i></a>
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