<?php
// Kết nối cơ sở dữ liệu
include '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';

// Lấy thông tin sản phẩm từ URL
if (isset($_GET['name'])) {
    $product_name = $_GET['name'];

    // Lấy thông tin sản phẩm
    $sql = "SELECT * FROM products WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $product_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        die("Không tìm thấy sản phẩm.");
    }
} else {
    die("Tên sản phẩm không hợp lệ.");
}

// Nếu form được submit, xử lý cập nhật
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_name = $_POST['name'];
    $description = $_POST['description'];
    $ram = intval($_POST['ram']);
    $rom = intval($_POST['rom']);
    $battery = intval($_POST['battery']);
    $price = intval($_POST['price']);

    if (empty($new_name) || empty($description) || $ram <= 0 || $rom <= 0 || $battery <= 0 || $price <= 0) {
        die("Dữ liệu nhập không hợp lệ.");
    }

    // Kiểm tra và xử lý tệp ảnh
    $image_path = $product['image']; // Đường dẫn ảnh hiện tại
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = ''; // Thư mục lưu trữ ảnh
        $image_name = basename($_FILES['image']['name']);
        $target_path = $upload_dir . $image_name;

        // Di chuyển tệp tải lên
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image_path = $target_path; // Cập nhật đường dẫn ảnh
        } else {
            die("Lỗi tải ảnh lên.");
        }
    }

    // Cập nhật thông tin sản phẩm
    $update_sql = "UPDATE products SET name = ?, description = ?, ram = ?, rom = ?, battery = ?, price = ?, image = ? WHERE name = ?";
    $update_stmt = $conn->prepare($update_sql);

    if (!$update_stmt) {
        die("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }

    $update_stmt->bind_param("sssiiiss", $new_name, $description, $ram, $rom, $battery, $price, $image_path, $product_name);

    if ($update_stmt->execute()) {
        header("Location: product.php?msg=Sản phẩm đã được cập nhật thành công");
        exit();
    } else {
        die("Lỗi cập nhật sản phẩm: " . $update_stmt->error);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật sản phẩm</title>
</head>
<body>
    <h1>Cập nhật sản phẩm</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <th>Tên sản phẩm</th>
                <td><input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required></td>
            </tr>
            <tr>
                <th>RAM</th>
                <td><input type="number" name="ram" value="<?php echo htmlspecialchars($product['ram']); ?>" required></td>
            </tr>
            <tr>
                <th>ROM</th>
                <td><input type="number" name="rom" value="<?php echo htmlspecialchars($product['rom']); ?>" required></td>
            </tr>
            <tr>
                <th>Pin</th>
                <td><input type="number" name="battery" value="<?php echo htmlspecialchars($product['battery']); ?>" required></td>
            </tr>
            <tr>
                <th>Giá</th>
                <td><input type="number" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required></td>
            </tr>
            <tr>
                <th>Mô tả</th>
                <td><textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea></td>
            </tr>
            <tr>
                <th>Ảnh sản phẩm</th>
                <td>
                    <input type="file" name="image">
                    <br>
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Ảnh sản phẩm" width="150">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <button type="submit">Cập nhật</button>
                    <a href="product.php"><button type="button">Hủy</button></a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
<style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #333;
            margin: 20px 0;
        }
        table {
            margin: 20px auto;
            width: 80%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        td input, td textarea {
            width: 90%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        textarea {
            resize: vertical;
            height: 100px;
        }
        td button {
            background: #28a745;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        td button:hover {
            background: #218838;
        }
        td a button {
            background: #dc3545;
        }
        td a button:hover {
            background: #c82333;
        }
    </style>