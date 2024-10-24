<?php

?>
<style>
    /* Đảm bảo toàn bộ trang có chiều cao tối thiểu là 100vh */
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    /* Thiết lập container-fluid bao phủ toàn bộ chiều cao */
    .container-fluid {
        min-height: 100%;
        display: flex;
        flex-direction: column;
    }

    /* Nội dung chính sẽ chiếm toàn bộ không gian trống */
    .content {
        flex: 1;
    }

    /* Sticky footer */
    .footer {
        background-color: #007bff;
        color: #fff;
        padding: 20px 0;
        text-align: center;
        width: 100%;
        box-shadow: 0px -4px 8px rgba(0, 0, 0, 0.1);
    }

    .footer p {
        margin: 0;
        font-size: 14px;
    }

    .footer a {
        color: #ffffff;
        text-decoration: none;
    }

    .footer a:hover {
        text-decoration: underline;
    }
</style>


<footer class="footer bg-primary text-white text-center py-3">
    <div class="container">
        <p>&copy; 2024 Admin Dashboard. All Rights Reserved.</p>
        <p>Powered by YourCompany</p>
    </div>
</footer>
</div> <!-- Kết thúc nội dung chính -->
</div> <!-- Kết thúc row content -->
</div> <!-- Kết thúc container-fluid -->
</body>

</html>