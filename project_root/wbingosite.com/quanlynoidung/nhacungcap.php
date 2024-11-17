<link rel="stylesheet" href="resources/css/uikit.min.css" />
 <link rel="stylesheet" href="http://localhost/project_root/wbingosite.com/resources/style.css" />

 <script src="resources/js/uikit.min.js"></script>
 <script src="resources/js/uikit-icons.min.js"></script>
 <?php require_once '../components/pages/header.php' ?>
<style>
        .supplier-container {
            margin: 20px;
            text-align: center;
        }
        .supplier-card {
            display: inline-block;
            width: 200px;
            margin: 10px;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .supplier-card img {
            width: 150px;
            height: 150px;
            margin-bottom: 15px;
        }
        .supplier-card h3 {
            font-size: 1.2em;
            margin: 10px 0;
        }
        .supplier-card p {
            font-size: 1em;
            color: #555;
        }
        .supplier-card a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
        .supplier-card a:hover {
            text-decoration: underline;
        }
        .supplier-details {
            margin-top: 50px;
        }
        .supplier-details h3 {
            text-align: center;
            margin-top: 30px;
        }
        .supplier-details p {
            margin: 10px 0;
            font-size: 1.1em;
            color: #333;
        }
    </style>

<main >
    <div id="nhacungcap" class="supplier-container">
        <h2>Nhà Cung Cấp Sản Phẩm</h2>
        
        <!-- Nhà Cung Cấp A -->
        <div class="supplier-card" id="supplierA">
            <img src="images/supplier1.jpg" alt="Nhà cung cấp A">
            <h3>Nhà Cung Cấp A</h3>
            <p>Chuyên cung cấp các sản phẩm điện thoại di động, phụ kiện chính hãng.</p>
            <a href="#supplierA-details">Chi tiết</a>
        </div>

        <!-- Nhà Cung Cấp B -->
        <div class="supplier-card" id="supplierB">
            <img src="images/supplier2.jpg" alt="Nhà cung cấp B">
            <h3>Nhà Cung Cấp B</h3>
            <p>Cung cấp các sản phẩm công nghệ cao cấp như máy tính, laptop và thiết bị điện tử.</p>
            <a href="#supplierB-details">Chi tiết</a>
        </div>

        <!-- Nhà Cung Cấp C -->
        <div class="supplier-card" id="supplierC">
            <img src="images/supplier3.jpg" alt="Nhà cung cấp C">
            <h3>Nhà Cung Cấp C</h3>
            <p>Chuyên cung cấp phụ kiện điện thoại, sạc, tai nghe và các thiết bị nhỏ.</p>
            <a href="#supplierC-details">Chi tiết</a>
        </div>
    </div>

    <!-- Thông tin chi tiết về nhà cung cấp -->
    <div class="supplier-details" id="supplierA-details">
        <h3>Nhà Cung Cấp A - Chi Tiết</h3>
        <p><strong>Giới thiệu:</strong> Nhà Cung Cấp A là một trong những nhà cung cấp hàng đầu tại Việt Nam về các sản phẩm điện thoại di động, phụ kiện chính hãng. Với đội ngũ chuyên gia và hệ thống cửa hàng trải dài trên toàn quốc, chúng tôi cam kết mang đến cho khách hàng những sản phẩm chất lượng nhất.</p>
        <p><strong>Chính sách bảo hành:</strong> Chúng tôi cung cấp chính sách bảo hành 12 tháng cho tất cả các sản phẩm điện thoại và phụ kiện. Khách hàng có thể đổi trả trong vòng 7 ngày nếu sản phẩm có lỗi do nhà sản xuất.</p>
        <p><strong>Địa chỉ:</strong> 123 Đường ABC, Quận 1, TP.HCM, Việt Nam.</p>
    </div>

    <div class="supplier-details" id="supplierB-details">
        <h3>Nhà Cung Cấp B - Chi Tiết</h3>
        <p><strong>Giới thiệu:</strong> Nhà Cung Cấp B là đơn vị chuyên cung cấp các sản phẩm công nghệ cao cấp như máy tính xách tay, máy tính bảng, các thiết bị điện tử gia dụng và phần mềm. Chúng tôi luôn cập nhật những xu hướng công nghệ mới nhất để đáp ứng nhu cầu của khách hàng.</p>
        <p><strong>Chính sách bảo hành:</strong> Mọi sản phẩm đều được bảo hành 24 tháng, với dịch vụ hỗ trợ sửa chữa tại các trung tâm của chúng tôi trên toàn quốc.</p>
        <p><strong>Địa chỉ:</strong> 456 Đường XYZ, Quận 2, TP.HCM, Việt Nam.</p>
    </div>

    <div class="supplier-details" id="supplierC-details">
        <h3>Nhà Cung Cấp C - Chi Tiết</h3>
        <p><strong>Giới thiệu:</strong> Nhà Cung Cấp C chuyên cung cấp các loại phụ kiện điện thoại di động cao cấp như sạc, tai nghe, ốp lưng và các phụ kiện đi kèm khác. Với phương châm chất lượng là hàng đầu, chúng tôi mang đến cho khách hàng những sản phẩm bền bỉ và tiện lợi.</p>
        <p><strong>Chính sách bảo hành:</strong> Các sản phẩm của chúng tôi được bảo hành 6 tháng. Chúng tôi hỗ trợ đổi trả nếu sản phẩm gặp lỗi kỹ thuật trong vòng 7 ngày kể từ khi mua.</p>
        <p><strong>Địa chỉ:</strong> 789 Đường DEF, Quận 3, TP.HCM, Việt Nam.</p>
    </div>

    <footer>
        <p>© 2024 Website Bán Điện Thoại. Tất cả các quyền được bảo lưu.</p>
    </footer>
</main>

