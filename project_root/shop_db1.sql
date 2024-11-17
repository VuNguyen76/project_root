-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 14, 2024 lúc 06:23 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shop_db1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`id`, `name`) VALUES
(1, 'Apple'),
(2, 'Oppo'),
(3, 'Vivo'),
(4, 'Samsung'),
(5, 'Redmi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `address` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--



-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(19, 24, 6, 1, 25000000.00),
(20, 25, 4, 1, 10000000.00),
(21, 25, 5, 1, 10000000.00),
(22, 26, 4, 1, 10000000.00),
(23, 26, 5, 1, 10000000.00),
(24, 27, 4, 1, 10000000.00),
(25, 27, 5, 1, 10000000.00),
(26, 27, 6, 1, 25000000.00),
(27, 28, 5, 1, 10000000.00),
(28, 29, 6, 1, 25000000.00),
(29, 30, 7, 1, 3999000.00),
(30, 31, 5, 1, 10000000.00),
(31, 32, 5, 1, 10000000.00),
(32, 33, 5, 1, 10000000.00),
(33, 34, 5, 1, 10000000.00),
(34, 35, 5, 1, 10000000.00),
(35, 36, 7, 1, 3999000.00),
(36, 37, 7, 1, 3999000.00),
(37, 38, 5, 1, 26700000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','cancelled') DEFAULT 'pending',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_date`, `amount`, `status`, `user_id`) VALUES
(15, 24, '2024-11-02 18:40:50', 25020000.00, 'completed', 1),
(16, 25, '2024-11-02 18:44:04', 20020000.00, 'completed', 1),
(17, 26, '2024-11-03 06:52:14', 20020000.00, 'pending', 1),
(18, 27, '2024-11-03 07:15:17', 45020000.00, 'pending', 1),
(19, 28, '2024-11-04 22:15:54', 10020000.00, 'pending', 1),
(20, 29, '2024-11-04 23:48:38', 25020000.00, 'pending', 1),
(21, 30, '2024-11-05 05:14:42', 4019000.00, 'pending', 1),
(22, 31, '2024-11-07 06:20:21', 10020000.00, 'pending', 1),
(23, 32, '2024-11-08 01:49:28', 10020000.00, 'pending', 1),
(24, 33, '2024-11-08 23:56:46', 10020000.00, 'pending', 1),
(25, 34, '2024-11-08 23:57:14', 0.00, 'pending', 1),
(26, 35, '2024-11-09 04:00:32', 10020000.00, 'pending', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,0) NOT NULL,
  `ram` varchar(50) DEFAULT NULL,
  `rom` varchar(50) DEFAULT NULL,
  `battery` varchar(50) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `Quality` int(255) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `ram`, `rom`, `battery`, `brand_id`, `created_at`, `image`, `Quality`) VALUES
(4, 'Iphone 15', 'Thiết kế bằng nhôm và kính pha màu bền bỉ 15,5 cm chú thích ◊ với mặt trước có Ceramic Shield\r\nDynamic Island hiển thị linh động các cảnh báo và Hoạt Động Trực Tiếp, nhờ đó bạn sẽ không bỏ lỡ thông tin khi đang làm việc khác\r\nCamera Chính 48MP với Telephoto 2x chụp rõ nét và tuyệt đẹp từng chi tiết cận cảnh hoặc từ xa\r\nChip A16 Bionic hỗ trợ nhiếp ảnh điện toán, cho hiệu năng chơi game mượt mà và tiết kiệm pin tuyệt vời với pin dùng cả ngày\r\nKết nối và sạc với USB-C', 10000000, '16', '512', '45000', 1, '2024-11-02 00:23:43', 'iphone-15-pink-1-650x650.jpg', 10),
(5, 'Iphone 15 Plus', '\r\nThiết kế bằng nhôm và kính pha màu bền bỉ 17 cm chú thích ◊ với mặt trước có Ceramic Shield\r\nDynamic Island hiển thị linh động các cảnh báo và Hoạt Động Trực Tiếp, nhờ đó bạn sẽ không bỏ lỡ thông tin khi đang làm việc khác\r\nCamera Chính 48MP với Telephoto 2x chụp rõ nét và tuyệt đẹp từng chi tiết cận cảnh hoặc từ xa\r\nChip A16 Bionic hỗ trợ nhiếp ảnh điện toán, cho hiệu năng chơi game mượt mà và tiết kiệm pin tuyệt vời với pin dùng cả ngày\r\nKết nối và sạc với USB-C', 10000000, '16', '512', '45000', 1, '2024-11-02 00:38:11', 'iphone-15-pink-1-650x650.jpg', 7),
(6, 'Oppo Find N3', 'Đặc điểm nổi bật của OPPO Find N3 16GB 512GB\r\nBậc thầy thiết kế, siêu mỏng nhe - Mỏng chỉ 239g, nhẹ chỉ 5.8mm với nếp gấp tàng hình\r\nRực rõ mọi màn hình hiển thị - Kích thước lên đến 7.8mm, độ phân giải 2K+ cùng tần số quét 120Hz mượt mà\r\nBậc thầy nhiếp ảnh - 3 camera hàng đầu đến 64MP kết hợp cùng đa dạng chế độ chụp hoàn hảo\r\nNâng cao hiệu suất sử dụng - Chip MediaTek Dimensity 9200 5G mạnh mẽ cùng hàng loạt tính năng đa nhiệm thông tinh\r\nOPPO Find N3 được chính thức ra mắt ngày 26/10 tại thị trường Việt Nam mang đến nhiều nâng cấp mới mẻ. Trên phiên bản điện thoại gập thế hệ thứ 3 này, OPPO tạo ra một mẫu flagship mạnh mẽ hơn với chip Qualcomm Snapdragon® 8 Gen 2 Mobile Platform, 16GB RAM, màn hình chính 7.82 inch, màn hinh ngoài 6.31 inch cùng hệ thống camera Hasselblad đầy ấn tượng.', 10000000, '16', '512', '4805', 2, '2024-11-02 10:56:15', 'oppo find n3.jpg', 5),
(7, 'Vivo Y19s', 'Pin Siêu Bền 4 Năm Hiệu Năng Ổn Định\r\nThân Máy Siêu Mỏng 8.1mm\r\nLoa Kép Âm Lượng Lớn 300%', 3999000, '4GB ', '128GB', '5500mAh', 3, '2024-11-05 11:13:51', 'vivo y19s.jpg', 2),
(8, 'Điện thoại iPhone 16 Pro Max 256GB', 'iPhone 16 Pro Max 256GB là một trong những mẫu điện thoại cao cấp nhất của Apple với nhiều tính năng nổi bật:\r\n\r\n- **Màn hình**: Super Retina XDR 6.9 inch, viền mỏng hơn, mang lại trải nghiệm hình ảnh tuyệt vời¹.\r\n- **Thiết kế**: Vỏ titan cấp 5 với lớp hoàn thiện vi điểm, bền bỉ và nhẹ nhàng².\r\n- **Camera**: Hệ thống camera Fusion 48MP và Ultra Wide 48MP, camera Telephoto 5x 12MP, và camera trước 12MP, hỗ trợ quay video 4K Dolby Vision tốc độ 120 fps².\r\n- **Hiệu năng**: Chip A18 Pro với 6 lõi CPU và 6 lõi GPU, cùng với Neural Engine 16 lõi, đảm bảo hiệu suất mạnh mẽ¹.\r\n- **Pin và sạc**: Dung lượng pin lớn, hỗ trợ sạc nhanh và cổng kết nối USB-C³.\r\n- **Hệ điều hành**: iOS 18, giao diện trực quan và nhiều tính năng hữu ích¹.\r\n', 10000000, '8', '256', '4500', 1, '2024-11-13 16:44:21', '16proxmax.jpg', 1),
(9, 'iPhone 16 Pro', 'Đặc điểm nổi bật của iPhone 16 Pro 128GB | Chính hãng VN/A\r\nMàn hình Super Retina XDR 6,3 inch lớn hơn có viền mỏng hơn, đem đến cảm giác tuyệt vời khi cầm trên tay.\r\nĐiều khiển Camera - Chỉ cần trượt ngón tay để điều chỉnh camera giúp chụp ảnh hoặc quay video đẹp hoàn hảo và siêu nhanh. \r\nTính năng quay video đẳng cấp với 4K Dolby Vision tốc độ 120 fps — độ phân giải và tốc độ khung hình cao nhất hiện nay của Apple.\r\niPhone 16 Pro được cài đặt sẵn hệ điều hành iOS 18, cho giao diện trực quan, dễ sử dụng và nhiều tính năng hữu ích.', 10000000, '8', '128', '3582', 1, '2024-11-13 16:49:53', '16protitan.png', 1),
(10, 'Samsung Galaxy S23 Ultra 12GB 512GB \r\n', 'Đặc điểm nổi bật của Samsung Galaxy S23 Ultra 12GB 512GB\r\nGalaxy AI tiện ích - Khoanh vùng search đa năng, là trợ lý chỉnh ảnh, note thông minh, phiên dịch trực tiếp\r\nThoả sức chụp ảnh, quay video chuyên nghiệp - Camera đến 200MP, chế độ chụp đêm cải tiến, bộ xử lí ảnh thông minh\r\nChiến game bùng nổ - chip Snapdragon 8 Gen 2 8 nhân tăng tốc độ xử lí, màn hình 120Hz, pin 5.000mAh\r\nNâng cao hiệu suất làm việc với Siêu bút S Pen tích hợp, dễ dàng đánh dấu sự kiện từ hình ảnh hoặc video\r\nThiết kế bền bỉ, thân thiện - Màu sắc lấy cảm hứng từ thiên nhiên, chất liệu kính và lớp phim phủ PET tái chế\r\nSamsung Galaxy S23 Ultra 12GB 512GB tạo nên đột phá mạnh mẽ về mặt hiệu năng khi được trang bị vi xử lý Snapdragon 8 Gen 2 vượt trội cùng 12GB bộ nhớ RAM. Chất lượng hiển thị siêu sắc nét trên S23 Ultra tới từ tầm nền Dynamic AMOLED 2X 120Hz thế hệ mới. Bên cạnh đó, smartphone này còn sở hữu cụm camera cao cấp với độ rõ nét đạt tới 200MP. Viên pin 5000mAh cùng sạc nhanh 45W giúp nâng cao thời lượng sử dụng lên một tầm cao mới. \r\n\r\nSamsung Galaxy S23 Ultra 12GB 512GB - Hiển thị sắc nét, cấu hình đỉnh cao\r\nSmartphone cao cấp nhất của tập đoàn Samsung trong năm 2023 được nhiều người bình chọn là phân khúc Samsung Galaxy S23 Ultra. Bứt phá mọi giới hạn hiệu năng với vi xử lý Snapdragon 8 Gen 2 đỉnh cao cùng khả năng hiển thị hình ảnh sắc nét trong từng chi tiết điểm ảnh, Galaxy S23 Ultra mang tới trải nghiệm sử dụng siêu mượt mà, dễ dàng làm hài lòng những người dùng khó tính nhất\r\n\r\nCụm camera 200MP cực khủng giúp nâng tầm trải nghiệm quay chụp', 10000000, '12', '512', '5000', 4, '2024-11-13 16:52:48', 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/s/a/samsung-s23-ulatra_2_.png', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sales_reports`
--

CREATE TABLE `sales_reports` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `report_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_revenue` decimal(10,2) DEFAULT NULL,
  `total_products_sold` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') DEFAULT 'user',
  `balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`, `role`, `balance`) VALUES
(1, 'admin', '$2y$10$TYmIPePnFy1aXSJEXhUSxeRgROncsy34WJmwnfsiAgFk786n9BXm6', 'admin@gmail.com', '2024-10-24 14:12:55', 'admin', 0.00),
(2, 'admin1', '$2y$10$utUFlTzL/rK76A31t1768.XsumjQOLNEhxNiHAh0LVfWkoDC5F4We', 'admin1@gmail.com', '2024-10-24 14:16:05', 'user', 0.00),
(3, 'admin2', '$2y$10$olRdPXnaRjKjNkSpxBKVbOl1fG5xaO6Z8xW.fiJ12MrfpXAjPFT4G', 'admin2@gmail.com', '2024-11-01 07:02:34', 'user', 0.00),
(4, 'admin3', '$2y$10$Qh48sXtHSOoWa76Qtp0hROFBgAtW92/.SZ4QTFXpiFphJ1PlnVd8y', 'admin3@gmail.com', '2024-11-03 13:00:54', 'user', 0.00),
(5, '2251120403', '$2y$10$dhUr4XuEol3iUPa5G7eq9eiRs12H45OtFT7f2eBhGeQlfo8L1tiDK', '2251120403@ut.edu.vn', '2024-11-05 05:36:31', 'user', 0.00),
(6, '2251330019', '$2y$10$dRxJg/5/rZg5csUIsYHnu.84dBGultM.ZQDnUtm7ou.zcFybovzZO', '2251120403@ut.edu', '2024-11-06 02:12:23', 'user', 0.00),
(7, '2251120444', '$2y$10$HpIk4xtv7jB3Ha3LlDndv.KrTH07DA98geC92m4omEr4S64cjj4Yq', '403@ut.edu', '2024-11-10 10:00:11', 'user', 0.00),
(8, '13435', '$2y$10$DLwx2B9o3ODZsv36wgSGpuhnxg4sRhrBrsHU.q.Stj2uEKRyOv8Ny', '13435@emil.com', '2024-11-10 10:07:10', 'user', 0.00);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer_id` (`customer_id`),
  ADD KEY `fk_cart_product_id` (`product_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_id` (`product_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_id` (`order_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_brand_id` (`brand_id`);

--
-- Chỉ mục cho bảng `sales_reports`
--
ALTER TABLE `sales_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_report_id` (`order_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `sales_reports`
--
ALTER TABLE `sales_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_brand_id` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `sales_reports`
--
ALTER TABLE `sales_reports`
  ADD CONSTRAINT `fk_order_report_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `sales_reports_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
