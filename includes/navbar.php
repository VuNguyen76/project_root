<?php
// navbar.php
?>
<!-- Navbar cho các thiết bị nhỏ -->
<nav class="navbar navbar-inverse visible-xs">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Logo</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="../public/admin_dashboard.php">Dashboard</a></li>
                <li><a href="../templates/admin/manage_products.php">Quản lý sản phẩm</a></li>
                <li><a href="../templates/admin/manage_payments.php">Quản lý thanh toán</a></li>
                <li><a href="/project_root/templates/admin/manage_accounts.php">Quản lý tài khoản</a></li> <!-- Thêm liên kết -->
                <li><a href="/project_root/templates/admin/manage_reports.php">Thống kê doanh thu</a></li> <!-- Thống kê doanh thu -->
                <li><a href="../templates/auth/login.php">Đăng xuất</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar cho các thiết bị lớn -->
<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-3 sidenav hidden-xs">
            <ul class="nav nav-pills nav-stacked">
                <li><a href="/project_root/public/admin_dashboard.php">Dashboard</a></li> <!-- Đường dẫn tuyệt đối đến Dashboard -->
                <li><a href="/project_root/templates/admin/manage_products.php">Quản lý sản phẩm</a></li>
                <li><a href="/project_root/templates/admin/manage_payments.php">Quản lý thanh toán</a></li>
                <li><a href="/project_root/templates/admin/manage_accounts.php">Quản lý tài khoản</a></li> <!-- Thêm liên kết -->
                <li><a href="/project_root/templates/admin/manage_reports.php">Thống kê doanh thu</a></li> <!-- Thống kê doanh thu -->
                <li><a href="/project_root/templates/auth/logout.php">Đăng xuất</a></li> <!-- Nút đăng xuất -->
            </ul>
            <br>
        </div>
        <br>
        <!-- Bắt đầu phần nội dung chính -->
        <div class="col-sm-9">