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
    $brand_id = $_POST['brand_id']; // Lấy ID của nhãn hiệu

    // Truy vấn thêm sản phẩm mới vào database
    $query = "INSERT INTO products (name, description, price, ram, rom, battery, brand_id) 
              VALUES ('$name', '$description', '$price', '$ram', '$rom', '$battery', '$brand_id')";
    if ($conn->query($query) === TRUE) {
        echo "Sản phẩm đã được thêm thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<h2>Thêm sản phẩm mới</h2>
<form method="POST">
    <div>
        <label for="name">Tên sản phẩm:</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div>
        <label for="description">Mô tả:</label>
        <textarea name="description" id="description"></textarea>
    </div>
    <div>
        <label for="price">Giá:</label>
        <input type="number" name="price" id="price" step="0.01" required>
    </div>
    <div>
        <label for="ram">RAM:</label>
        <input type="text" name="ram" id="ram" required>
    </div>
    <div>
        <label for="rom">ROM:</label>
        <input type="text" name="rom" id="rom" required>
    </div>
    <div>
        <label for="battery">Pin:</label>
        <input type="text" name="battery" id="battery" required>
    </div>
    <div>
        <label for="brand_id">Nhãn hiệu:</label>
        <select name="brand_id" id="brand_id" required>
            <option value="">Chọn nhãn hiệu</option>
            <?php while ($brand = $brands->fetch_assoc()): ?>
                <option value="<?php echo $brand['id']; ?>"><?php echo $brand['name']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <button type="submit">Thêm sản phẩm</button>
</form>

<?php include '../../includes/footer.php'; ?>