<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sản Phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 600px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .product-details {
            text-align: left;
        }

        .product-name {
            font-weight: bold;
        }

        .product-price {
            color: #28a745;
            font-size: 16px;
            font-weight: bold;
        }

        .add-to-cart-btn {
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Danh Sách Sản Phẩm</h1>

        <!-- Hiển thị danh sách sản phẩm -->
        <?php
        // Kết nối tới database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "shop_db1";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        // Lấy danh sách sản phẩm từ bảng products
        $productQuery = "SELECT * FROM products";
        $productResult = $conn->query($productQuery);

        if ($productResult->num_rows > 0) {
            while ($row = $productResult->fetch_assoc()) {
                echo "<div class='product-item'>";
                echo "<div class='product-details'>";
                echo "<div class='product-name'>" . htmlspecialchars($row['name']) . "</div>";
                echo "<div>" . htmlspecialchars($row['description']) . "</div>";
                echo "<div class='product-price'>" . number_format($row['price'], 2) . " VND</div>";
                echo "</div>";
                echo "<form action='add_to_cart.php' method='POST'>";
                echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
                echo "<input type='number' name='quantity' value='1' min='1' style='width: 50px;'>";
                echo "<button type='submit' class='add-to-cart-btn'>Thêm vào giỏ</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>Không có sản phẩm nào.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>

</html>