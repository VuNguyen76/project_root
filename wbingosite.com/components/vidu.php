<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".add-to-cart-button").forEach(function (button) {
        button.addEventListener("click", function () {
            const productId = this.getAttribute("data-product-id");

            // Kiểm tra xem ID sản phẩm có hợp lệ không
            if (!productId) {
                console.error("ID sản phẩm không hợp lệ.");
                alert("Có lỗi xảy ra: ID sản phẩm không hợp lệ.");
                return;
            }

            // Gọi endpoint để kiểm tra xem người dùng đã đăng nhập hay chưa
            fetch('/project_root/wbingosite.com/components/check_login.php')
                .then(response => response.json())
                .then(loginData => {
                    if (loginData.logged_in) {
                        // Nếu đã đăng nhập, thực hiện thêm vào giỏ hàng
                        fetch('/project_root/wbingosite.com/components/add_to_cart.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ product_id: productId })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert("Đã thêm sản phẩm vào giỏ hàng!");
                                updateCartCount(); // Gọi hàm cập nhật số lượng giỏ hàng
                            } else {
                                alert(data.message || "Có lỗi xảy ra khi thêm sản phẩm.");
                            }
                        })
                        .catch(error => {
                            console.error("Lỗi:", error);
                        });
                    } 
                    else {
                        alert("Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.");
                        // Có thể điều hướng đến trang đăng nhập
                    }
                })
                .catch(error => {
                    console.error("Lỗi khi kiểm tra đăng nhập:", error);
                });
        });
    });

    // Hàm để cập nhật số lượng sản phẩm trong giỏ hàng
    function updateCartCount() {
        fetch('/project_root/wbingosite.com/components/cart_count.php')
            .then(response => response.json())
            .then(data => {
                document.querySelector(".widget-item .number").textContent = data.count;
            })
            .catch(error => {
                console.error("Lỗi khi cập nhật số lượng giỏ hàng:", error);
            });
    }

    // Gọi hàm này khi tải trang để hiển thị số lượng ban đầu
    updateCartCount();
});

</script>