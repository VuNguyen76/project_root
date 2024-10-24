<?php
session_start();

// Kiểm tra nếu người dùng là admin
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    // Hủy bỏ tất cả các session (xóa dữ liệu phiên người dùng)
    session_unset();
    session_destroy();

    // Chuyển hướng admin về trang login của admin
    header('Location: /project_root/templates/auth/login.php');
} else {
    // Hủy bỏ tất cả các session cho người dùng không phải admin
    session_unset();
    session_destroy();

    // Chuyển hướng người dùng không phải admin về trang login khác
    header('Location: http://localhost/project_root/wbingosite.com/components/pages/login.php');
}

exit();
