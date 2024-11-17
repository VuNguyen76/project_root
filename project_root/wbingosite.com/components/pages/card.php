<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giỏ Hàng</title>
  <link rel="stylesheet" href="http://localhost/project_root/wbingosite.com/resources/css/card.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
  <section class="container-card">
    <div class="container-card-mini">
      <div class="card-title">
        <h5><a href="http://localhost/project_root/webPhone.php"><i class="fas fa-arrow-circle-left"></i> Continue shopping</a></h5>
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
                echo "<div>";
                echo "<div class='quantity-container'>";
                echo "<label for='quantity_" . $product['id'] . "'>Số lượng:</label>";
                echo "<input type='number' class='quantity' id='quantity_" . $product['id'] . "' data-price='" . $product['price'] . "' value='1' min='1'>";
                echo "</div>";
                echo "<div class='dis-flex'>";
                echo "<p>Giá:</p>";
                echo "<p>" . number_format($product['price'], 0) . " VND</p>";
                echo "</div>";
                echo "</div>";

                echo "<a href='../acsion/delete_from_cart.php?product_id=" . $product['id'] . "'><i class='fas fa-trash-alt pad-5'></i></a>";
                echo "</div>";
              }
            } else {
              echo "<p>Không có sản phẩm nào trong giỏ hàng.</p>";
            }
          } else {
            echo "<p>Giỏ hàng trống.</p>";
          }

          $conn->close();
          ?>
        </div>
      </div>
    </div>

    <div class="container-checkpay">
      <div class="b3 pad-5">
        <div class="title-checkpay dis-flex">
          <h5>Card details</h5>
          <img src="https://th.bing.com/th/id/OIP.HcH5UgkgVyznnnVyDWoSMAHaHa?rs=1&pid=ImgDetMain" alt="Avatar">
        </div>
        <form method="POST" action="../acsion/process_checkout.php" id="checkoutForm">
          <div class="form-group">
            <label for="address">Địa chỉ giao hàng:</label>
            <input type="text" name="address" id="address" placeholder="Nhập địa chỉ giao hàng của bạn" required>
          </div>
          <input type="hidden" name="selected_products" id="selected_products">
          <input type="hidden" name="total_amount" id="total_amount">
          <hr>
          <div class="tongphu">
            <p>Tổng Tiền Hàng</p>
            <p id="subtotal">0 VND</p>
          </div>
          <div class="vanchuyen">
            <p>Phí Vận Chuyển</p>
            <p>20,000 VND</p>
          </div>
          <div class="tongcong">
            <p>Tổng Tiền</p>
            <p id="total">20,000 VND</p>
          </div>
          <button type="submit" class="btn btn-primary">Đặt hàng</button>
        </form>
      </div>
    </div>
  </section>

</body>
<script>
  $(document).ready(function () {
    function calculateTotal() {
      let subtotal = 0;
      let selectedProducts = [];

      $('.chon:checked').each(function () {
        const productId = $(this).data('product-id');
        const price = parseFloat($(this).val());
        const quantity = parseInt($('#quantity_' + productId).val()) || 1;
        subtotal += price * quantity;
        selectedProducts.push({ id: productId, quantity: quantity });
      });

      let shipping = 20000;
      let total = subtotal + shipping;

      $('#subtotal').text(new Intl.NumberFormat('vi-VN').format(subtotal) + ' VND');
      $('#total').text(new Intl.NumberFormat('vi-VN').format(total) + ' VND');
      $('#total_amount').val(total);
      $('#selected_products').val(JSON.stringify(selectedProducts));
    }

    $('.chon, .quantity').change(calculateTotal);

    $('#checkoutForm').submit(function (event) {
      var address = $('#address').val().trim();
      if (address === "") {
        alert("Vui lòng nhập địa chỉ giao hàng trước khi đặt hàng.");
        event.preventDefault();
        return false;
      }
      calculateTotal();
    });
  });
</script>

</html>
