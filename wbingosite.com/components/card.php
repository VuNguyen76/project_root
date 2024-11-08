<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giỏ Hàng</title>
  <link rel="stylesheet" href="../resources/css/card.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
  <section class="container-card">
    <div class="container-card-mini">
      <div class="card-title">
        <h5><a href="http://localhost/project_root/wbingosite.com/home.php"><i class="fas fa-arrow-circle-left"></i> Continue shopping</a></h5>
        <hr>
        <div class="container-card-product">
          <?php
          session_start();
          $servername = "localhost";
          $username = "root";
          $password = "";
          $dbname = "shop_db1";

          $conn = new mysqli($servername, $username, $password, $dbname);
          if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
          }

          // Kiểm tra nếu giỏ hàng có sản phẩm
          if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            $productIds = implode(",", array_map('intval', $_SESSION['cart'])); // Lấy danh sách ID sản phẩm

            $productQuery = "SELECT * FROM products WHERE id IN ($productIds)";
            $productResult = $conn->query($productQuery);

            if ($productResult->num_rows > 0) {
              while ($product = $productResult->fetch_assoc()) {
                // Tạo liên kết đến trang chi tiết sản phẩm
                $productLink = 'http://localhost/project_root/wbingosite.com/components/ProductDetails.php?id=' . htmlspecialchars($product['id']);
                  // Thêm liên kết vào phần chi tiết sản phẩm (chút thích)
                echo "<a href='" . $productLink . "' class='product-link'>";

                  echo "<div class='card-product-item b2'>";                 
                  echo "<div class='item-image pad-20'>";                
                  echo "<input type='checkbox' class='chon' value='" . $product['price'] . "' data-product-id='" . $product['id'] . "'>";
                  echo "<div class='border-soild'><img src='/project_root/uploads/" . htmlspecialchars($product['image']) . "' alt='" . htmlspecialchars($product['name']) . "'></div>";
                  echo "<div class='item-info'>";
                  echo "<p>" . htmlspecialchars($product['name']) . "</p>";
                  echo "<p>" . htmlspecialchars($product['ram']) . " RAM, " . htmlspecialchars($product['rom']) . " ROM</p>";
                  echo "<p>" . htmlspecialchars($product['battery']) . " mAh</p>";
                  echo "</div>"; 
                  echo "</div>";
                  echo "<div class='dis-flex'>";
                  echo "<p>Giá:</p>";
                  echo "<p>" . number_format($product['price'], 0) . " VND</p>";
                  echo "</div>";
                  
                  // Liên kết để xóa sản phẩm khỏi giỏ hàng
                  echo "<a href='delete_from_cart.php?product_id=" . $product['id'] . "'><i class='fas fa-trash-alt pad-5'></i></a>";                  
                  echo "</div>";
                echo "</a>";  // Kết thúc liên kết  
              }
          }
           else {
              echo "<p>Không có sản phẩm nào.</p>";
              echo "<a href='http://localhost/project_root/wbingosite.com/components/ProductDetails.php?id=". htmlspecialchars($product['id']) ."</a>";
            }
          } else {
            echo "<p>Giỏ hàng trống.</p>";
          }

          $conn->close();
          ?>
        </div>
      </div>
    </div>

    <!-- Phần thanh toán -->
    <div class="container-checkpay">
      <div class="b3 pad-5">
        <div class="title-checkpay dis-flex">
          <h5>Card details</h5>
          <img src="https://th.bing.com/th/id/OIP.HcH5UgkgVyznnnVyDWoSMAHaHa?rs=1&pid=ImgDetMain" alt="Avatar">
        </div>
        <p>Card type</p>
        <form method="POST" action="process_checkout.php" id="checkoutForm">
          <input type="hidden" name="selected_products" id="selected_products">
          <input type="hidden" name="total_amount" id="total_amount">
          <button type="submit" class="btn btn-primary">Checkout</button>
        </form>
        <hr>
        <div class="tongphu">
          <p>Subtotal</p>
          <p id="subtotal">0 VND</p>
        </div>
        <div class="vanchuyen">
          <p>Shipping</p>
          <p>20,000 VND</p>
        </div>
        <div class="tongcong">
          <p>Total (Incl. taxes)</p>
          <p id="total">20,000 VND</p>
        </div>
      </div>
    </div>

    <script>
      $(document).ready(function() {
        $('.chon').change(function() {
          let subtotal = 0;
          let selectedProducts = [];

          $('.chon:checked').each(function() {
            subtotal += parseFloat($(this).val());
            selectedProducts.push($(this).data('product-id'));
          });

          let shipping = 20000;
          let total = subtotal + shipping;

          $('#subtotal').text(new Intl.NumberFormat('vi-VN').format(subtotal) + ' VND');
          $('#total').text(new Intl.NumberFormat('vi-VN').format(total) + ' VND');
          $('#total_amount').val(total);
          $('#selected_products').val(JSON.stringify(selectedProducts));
        });

        $('#checkoutForm').submit(function() {
          let selectedProducts = [];
          $('.chon:checked').each(function() {
            selectedProducts.push($(this).data('product-id'));
          });
          $('#selected_products').val(JSON.stringify(selectedProducts));
        });
      });
    </script>
  </section>
</body>

</html>