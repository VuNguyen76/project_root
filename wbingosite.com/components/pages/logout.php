<?php
session_start();

// Hủy bỏ tất cả các session (xóa dữ liệu phiên người dùng)
session_unset();
session_destroy();

// Chuyển hướng người dùng về trang chủ
header('Location: /project_root/wbingosite.com/home.php');
exit();
