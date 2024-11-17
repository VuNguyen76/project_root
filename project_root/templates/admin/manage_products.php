<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /templates/auth/login.php');
    exit();
}
$pageTitle = "Quản lý Sản phẩm";
include '../../includes/header.php';
include '../../includes/navbar.php';
include '../../config/db.php';

// Lấy danh sách nhãn hiệu
$brandQuery = "SELECT * FROM brands";
$brands = $conn->query($brandQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $ram = $_POST['ram'];
    $rom = $_POST['rom'];
    $battery = $_POST['battery'];
    $brand_id = $_POST['brand_id'];

    // Xử lý upload hình ảnh
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/project_root/uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Tạo thư mục nếu chưa có
    }
    $image = $_FILES['image']['name'];
    $targetFilePath = $targetDir . basename($image);
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Kiểm tra định dạng file
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($imageFileType, $allowedTypes)) {
        // Upload file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            // Truy vấn thêm sản phẩm mới vào database với đường dẫn ảnh
            $query = "INSERT INTO products (name, description, price, ram, rom, battery, brand_id, image) 
                      VALUES ('$name', '$description', '$price', '$ram', '$rom', '$battery', '$brand_id', '$image')";
            if ($conn->query($query) === TRUE) {
                echo "<p class='success-message'>Sản phẩm đã được thêm thành công!</p>";
            } else {
                echo "<p class='error-message'>Lỗi: " . $conn->error . "</p>";
            }
        } else {
            echo "<p class='error-message'>Có lỗi xảy ra khi tải lên hình ảnh. Đường dẫn: $targetFilePath</p>";
            echo "<p class='error-message'>Lỗi: " . error_get_last()['message'] . "</p>";
        }
    } else {
        echo "<p class='error-message'>Chỉ cho phép tải lên các file JPG, JPEG, PNG, GIF.</p>";
    }
}
?>


<h2>Thêm sản phẩm mới</h2>
<form method="POST" enctype="multipart/form-data" class="product-form">
    <div class="form-group">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Mô tả:</label>
        <textarea name="description" id="description" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label for="price">Giá:</label>
        <input type="number" name="price" id="price" class="form-control" step="0.01" required>
    </div>
    <div class="form-group">
        <label for="ram">RAM:</label>
        <input type="text" name="ram" id="ram" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="rom">ROM:</label>
        <input type="text" name="rom" id="rom" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="battery">Pin:</label>
        <input type="text" name="battery" id="battery" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="brand_id">Nhãn hiệu:</label>
        <select name="brand_id" id="brand_id" class="form-control" required>
            <option value="">Chọn nhãn hiệu</option>
            <?php while ($brand = $brands->fetch_assoc()): ?>
                <option value="<?php echo $brand['id']; ?>"><?php echo $brand['name']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="image">Hình ảnh:</label>
        <input type="file" name="image" id="image" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
</form>

<!-- Nút xem danh sách sản phẩm nằm ở góc phải trên -->
<div class="view-products-button">
    <form action="http://localhost/project_root/templates/admin/product.php" method="get">
        <button type="submit" class="btn btn-secondary">Xem danh sách sản phẩm</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>

<!-- Thêm CSS tùy chỉnh -->
<style>
    .view-products-button {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        color: #fff;
        cursor: pointer;
        border-radius: 4px;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
    }

    h2 {
        color: #007bff;
        text-align: center;
        margin-bottom: 30px;
    }

    .product-form {
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
        max-width: 600px;
        margin: 0 auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-weight: bold;
        color: #007bff;
    }

    .form-control {
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px;
        width: 100%;
        box-sizing: border-box;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        color: #fff;
        cursor: pointer;
        border-radius: 4px;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .success-message {
        color: green;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
    }

    .error-message {
        color: red;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
    }
</style>