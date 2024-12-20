-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 20, 2024 lúc 06:04 AM
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
-- Cơ sở dữ liệu: `phonestore_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_attribute_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `price` decimal(15,2) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `status`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Điện thoại', 'Điện thoại', 'active', NULL, '2024-12-18 20:59:07', NULL),
(2, 'iPhone', 'iPhone', 'active', 1, '2024-12-18 20:59:20', NULL),
(3, 'Sam Sung', 'Sam Sung', 'active', 1, '2024-12-18 20:59:30', NULL),
(4, 'OPPO', 'OPPO', 'active', 1, '2024-12-19 21:25:17', NULL),
(5, 'Realme', 'Realme', 'active', 1, '2024-12-19 21:43:42', NULL),
(6, 'Xiaomi', 'Xiaomi', 'active', 1, '2024-12-19 21:50:12', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_12_11_014939_create_categories_table', 1),
(6, '2024_12_11_014950_create_products_table', 1),
(7, '2024_12_11_014958_create_product_attributes_table', 1),
(8, '2024_12_11_015018_create_carts_table', 1),
(9, '2024_12_11_015038_create_product_images_table', 1),
(10, '2024_12_11_015100_create_orders_table', 1),
(11, '2024_12_11_015116_create_order_items_table', 1),
(12, '2024_12_11_015133_create_payments_table', 1),
(13, '2024_12_11_015148_create_shipping_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `status` enum('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 0.00, 'pending', '2024-12-19 06:14:38', '2024-12-19 06:14:38'),
(2, 2, 0.00, 'pending', '2024-12-19 06:15:53', '2024-12-19 06:15:53');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` enum('credit_card','paypal','cash_on_delivery') NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` enum('pending','completed','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(6, 'App\\Models\\User', 2, 'auth_token', '7f378966beda835d06efbba785e513ef51cf1763924507e8872b0c41f3aa82ec', '[\"read\"]', NULL, '2024-12-19 06:50:48', '2024-12-19 06:20:48', '2024-12-19 06:20:48'),
(7, 'App\\Models\\User', 2, 'auth_token', '68dc5b9291f41ea3edf488db006aec16128180fb055e5679482443e3b5bc73dc', '[\"read\"]', NULL, '2024-12-19 06:51:12', '2024-12-19 06:21:12', '2024-12-19 06:21:12'),
(8, 'App\\Models\\User', 2, 'auth_token', '24a4ef86cbf1ad2daaf40022c996cb74bab06dc07f2e78885e8b443f5917d05d', '[\"read\"]', NULL, '2024-12-19 21:51:42', '2024-12-19 21:21:42', '2024-12-19 21:21:42'),
(9, 'App\\Models\\User', 1, 'auth_token', '67649ea6a91e198c19fcee2cb4bba26596aeca7d785e0a15526ca2b8ec30f92f', '[\"*\"]', NULL, '2024-12-19 21:53:00', '2024-12-19 21:23:00', '2024-12-19 21:23:00'),
(10, 'App\\Models\\User', 1, 'auth_token', '229d3ea2b167a6235d78e312172e825d11338383c2703edfbd224f5dc2d69812', '[\"*\"]', NULL, '2024-12-19 21:53:06', '2024-12-19 21:23:06', '2024-12-19 21:23:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `description_detail` text DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('available','out_of_stock') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `description_detail`, `price`, `discount`, `quantity`, `category_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Samsung Galaxy S24 Ultra 5G 256GB', 'Điện thoại Android với kích thước màn hình lớn, từ 6,5 inch đến 6,8 inch, mang lại trải nghiệm hình ảnh rộng rãi và sắc nét. Những chiếc điện thoại này thích hợp cho việc xem phim, chơi game và sử dụng các ứng dụng đa phương tiện. Màn hình lớn cũng cung cấp không gian làm việc thoải mái hơn khi soạn thảo văn bản, chỉnh sửa ảnh và duyệt web, tạo cảm giác thoải mái và tiện lợi.', 'Xuất xứ\r\nViệt Nam / Trung Quốc\r\n\r\nThời điểm ra mắt\r\n01/2024\r\nThời gian bảo hành\r\n12 tháng\r\nHướng dẫn bảo quản\r\nĐể nơi khô ráo, nhẹ tay, dễ vỡ.\r\nHướng dẫn sử dụng\r\nXem trong sách hướng dẫn sử dụng\r\nThiết kế & Trọng lượng\r\nKích thước\r\n79 x 162.3 x 8.6 mm\r\nTrọng lượng sản phẩm\r\n232 g\r\n\r\nChuẩn kháng nước / Bụi bẩn\r\nIP68\r\nChất liệu\r\nKhung máy: Titan\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nSnapdragon 8 Gen 3\r\nCPU\r\n1 x 3.39 GHz + 2 x 3.1 GHz + 3 x 2.9 GHz + 2 x 2.2 GHz\r\nSố nhân\r\n8\r\nTốc độ tối đa\r\n3.39 GHz\r\nRAM\r\nRAM\r\n12 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.8 inch\r\nCông nghệ màn hình\r\nQHD+\r\nChuẩn màn hình\r\nDynamic AMOLED 2X\r\nĐộ phân giải\r\n3120 x 1440 Pixels\r\n\r\nMàu màn hình\r\n16 Triệu\r\nTần số quét\r\n120\r\nChất liệu mặt kính\r\nCorning Gorilla Glass Victus\r\nĐộ sáng\r\n2600 nits\r\nĐồ họa\r\nChip đồ hoạ (GPU)\r\nAdreno750\r\nLưu trữ\r\nDung lượng (ROM)\r\n256 GB\r\nDanh bạ lưu trữ\r\nKhông giới hạn\r\n\r\nThẻ nhớ ngoài\r\nKhông\r\nCamera sau\r\nSố camera sau\r\nQuad rear camera\r\nCamera\r\nWide\r\nResolution\r\n200.0 MP\r\nAperture\r\nƒ/1.7\r\nPixel size\r\n2.40 µm\r\nCamera\r\nTelephoto\r\nResolution\r\n50.0 MP\r\nAperture\r\nƒ/3.4\r\nPixel Size\r\n1.40 µm\r\nCamera\r\nTelephoto\r\nResolution\r\n10.0 MP\r\nAperture\r\nƒ/2.4\r\nPixel size\r\n1.12 µm\r\nCamera\r\nUltra Wide\r\nResolution\r\n12.0 MP\r\nAperture\r\nƒ/2.2\r\nQuay phim camera sau\r\nUHD 8K (7680 x 4320)@30fps\r\n\r\nTính năng\r\nZoom quang học 3x\r\n\r\nZoom kĩ thuật số 30x\r\n\r\nChống rung kỹ thuật số AI VDIS và quang học OIS\r\n\r\nChụp hình & quay phim với Portrait AI\r\n\r\nChế độ Super HDR\r\n\r\nTrợ lí Chỉnh ảnh (Gợi ý chỉnh sửa, Hậu kì sáng tạo)\r\n\r\nChụp chân dung\r\n\r\nChụp góc rộng (Wide)\r\n\r\nHDR\r\n\r\nTrôi nhanh thời gian (Time Lapse)\r\n\r\nTự động lấy nét (AF)\r\n\r\nBan đêm (Night Mode)\r\n\r\nChụp góc siêu rộng (Ultrawide)\r\n\r\nChống rung quang học (OIS)\r\n\r\nZoom kĩ thuật số 100x\r\n\r\nZoom quang học 10x\r\n\r\nToàn cảnh (Panorama)\r\n\r\nXóa phông\r\n\r\nQuay siêu chậm (Super Slow Motion)\r\n\r\nCamera Selfie\r\nSố Camera Selfie\r\nSingle selfie camera\r\nResolution\r\n12.0 MP\r\nAperture\r\nƒ/2.2\r\nPixel size\r\n1.12 µm\r\nQuay phim camera selfie\r\nQuay film chân dung\r\n\r\nTính năng\r\nChụp bằng cử chỉ\r\n\r\nBan đêm (Night Mode)\r\n\r\nLàm đẹp (Beautify)\r\n\r\nChế độ chân dung\r\n\r\nBảo mật\r\nBảo mật\r\nMở khóa vân tay dưới màn hình\r\n\r\nMở khóa khuôn mặt\r\n\r\nOthers\r\nThông báo LED\r\nCó\r\nTính năng đặc biệt\r\nThu nhỏ màn hình sử dụng một tay\r\n\r\nSamsung Wallet (Samsung Pay)\r\n\r\nPhiên dịch Trực tiếp\r\n\r\nTrợ lý Chỉnh ảnh\r\n\r\nTrợ lý Chat thông minh\r\n\r\nKhoanh Vùng Search Đa năng\r\n\r\nSamsung DeX\r\n\r\nCông nghệ NFC\r\n\r\nĐa cửa sổ (chia đôi màn hình)\r\n\r\nChạm 2 lần sáng màn hình\r\n\r\nSạc nhanh 45W\r\n\r\nTích hợp S-Pen trong thân máy\r\n\r\nTrợ lý Note Quyền năng\r\n\r\nAKG Dolby\r\n\r\nChặn tin nhắn\r\n\r\nChặn cuộc gọi\r\n\r\nMàn hình luôn bật (Alway on display)\r\n\r\nGiao tiếp và kết nối\r\nSố khe SIM\r\n1\r\nThẻ SIM\r\n1 eSIM, 1 Nano SIM\r\nHỗ trợ mạng\r\n4G\r\n\r\n5G\r\n\r\nCổng giao tiếp\r\n1 Type C\r\n\r\nWifi\r\n802.11 a/b/g/n/ac/ax, 2x2 MIMO\r\n\r\nWi-Fi Direct\r\n\r\nGPS\r\nGALILEO\r\n\r\nGLONASS\r\n\r\nGPS\r\n\r\nBEIDOU\r\n\r\nQZSS\r\n\r\nBluetooth\r\nv5.3\r\n\r\nKết nối khác\r\nNFC\r\n\r\nBluetooth\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium-ion\r\nDung lượng pin\r\n5000 mAh\r\n\r\nThông tin thêm\r\nSạc ngược cho thiết bị khác\r\n\r\nSạc pin nhanh\r\n\r\nHỗ trợ sạc không dây\r\n\r\nTiết kiệm pin\r\n\r\nHệ điều hành\r\nOS\r\nAndroid\r\n\r\nVersion\r\nAndroid 14\r\nPhụ kiện trong hộp\r\nPhụ kiện trong hộp\r\nQue lấy SIM\r\n\r\nCáp Type C\r\n\r\nSách HDSD', 25490000.00, 25000000.00, 1, 3, 'available', '2024-12-18 21:08:30', '2024-12-18 21:10:19'),
(2, 'Samsung Galaxy S24 Ultra 5G 256GB', 'Điện thoại Android với kích thước màn hình lớn, từ 6,5 inch đến 6,8 inch, mang lại trải nghiệm hình ảnh rộng rãi và sắc nét. Những chiếc điện thoại này thích hợp cho việc xem phim, chơi game và sử dụng các ứng dụng đa phương tiện. Màn hình lớn cũng cung cấp không gian làm việc thoải mái hơn khi soạn thảo văn bản, chỉnh sửa ảnh và duyệt web, tạo cảm giác thoải mái và tiện lợi.', 'Xuất xứ\r\nViệt Nam / Trung Quốc\r\n\r\nThời điểm ra mắt\r\n01/2024\r\nThời gian bảo hành\r\n12 tháng\r\nHướng dẫn bảo quản\r\nĐể nơi khô ráo, nhẹ tay, dễ vỡ.\r\nHướng dẫn sử dụng\r\nXem trong sách hướng dẫn sử dụng\r\nThiết kế & Trọng lượng\r\nKích thước\r\n79 x 162.3 x 8.6 mm\r\nTrọng lượng sản phẩm\r\n232 g\r\n\r\nChuẩn kháng nước / Bụi bẩn\r\nIP68\r\nChất liệu\r\nKhung máy: Titan\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nSnapdragon 8 Gen 3\r\nCPU\r\n1 x 3.39 GHz + 2 x 3.1 GHz + 3 x 2.9 GHz + 2 x 2.2 GHz\r\nSố nhân\r\n8\r\nTốc độ tối đa\r\n3.39 GHz\r\nRAM\r\nRAM\r\n12 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.8 inch\r\nCông nghệ màn hình\r\nQHD+\r\nChuẩn màn hình\r\nDynamic AMOLED 2X\r\nĐộ phân giải\r\n3120 x 1440 Pixels\r\n\r\nMàu màn hình\r\n16 Triệu\r\nTần số quét\r\n120\r\nChất liệu mặt kính\r\nCorning Gorilla Glass Victus\r\nĐộ sáng\r\n2600 nits\r\nĐồ họa\r\nChip đồ hoạ (GPU)\r\nAdreno750\r\nLưu trữ\r\nDung lượng (ROM)\r\n256 GB\r\nDanh bạ lưu trữ\r\nKhông giới hạn\r\n\r\nThẻ nhớ ngoài\r\nKhông\r\nCamera sau\r\nSố camera sau\r\nQuad rear camera\r\nCamera\r\nWide\r\nResolution\r\n200.0 MP\r\nAperture\r\nƒ/1.7\r\nPixel size\r\n2.40 µm\r\nCamera\r\nTelephoto\r\nResolution\r\n50.0 MP\r\nAperture\r\nƒ/3.4\r\nPixel Size\r\n1.40 µm\r\nCamera\r\nTelephoto\r\nResolution\r\n10.0 MP\r\nAperture\r\nƒ/2.4\r\nPixel size\r\n1.12 µm\r\nCamera\r\nUltra Wide\r\nResolution\r\n12.0 MP\r\nAperture\r\nƒ/2.2\r\nQuay phim camera sau\r\nUHD 8K (7680 x 4320)@30fps\r\n\r\nTính năng\r\nZoom quang học 3x\r\n\r\nZoom kĩ thuật số 30x\r\n\r\nChống rung kỹ thuật số AI VDIS và quang học OIS\r\n\r\nChụp hình & quay phim với Portrait AI\r\n\r\nChế độ Super HDR\r\n\r\nTrợ lí Chỉnh ảnh (Gợi ý chỉnh sửa, Hậu kì sáng tạo)\r\n\r\nChụp chân dung\r\n\r\nChụp góc rộng (Wide)\r\n\r\nHDR\r\n\r\nTrôi nhanh thời gian (Time Lapse)\r\n\r\nTự động lấy nét (AF)\r\n\r\nBan đêm (Night Mode)\r\n\r\nChụp góc siêu rộng (Ultrawide)\r\n\r\nChống rung quang học (OIS)\r\n\r\nZoom kĩ thuật số 100x\r\n\r\nZoom quang học 10x\r\n\r\nToàn cảnh (Panorama)\r\n\r\nXóa phông\r\n\r\nQuay siêu chậm (Super Slow Motion)\r\n\r\nCamera Selfie\r\nSố Camera Selfie\r\nSingle selfie camera\r\nResolution\r\n12.0 MP\r\nAperture\r\nƒ/2.2\r\nPixel size\r\n1.12 µm\r\nQuay phim camera selfie\r\nQuay film chân dung\r\n\r\nTính năng\r\nChụp bằng cử chỉ\r\n\r\nBan đêm (Night Mode)\r\n\r\nLàm đẹp (Beautify)\r\n\r\nChế độ chân dung\r\n\r\nBảo mật\r\nBảo mật\r\nMở khóa vân tay dưới màn hình\r\n\r\nMở khóa khuôn mặt\r\n\r\nOthers\r\nThông báo LED\r\nCó\r\nTính năng đặc biệt\r\nThu nhỏ màn hình sử dụng một tay\r\n\r\nSamsung Wallet (Samsung Pay)\r\n\r\nPhiên dịch Trực tiếp\r\n\r\nTrợ lý Chỉnh ảnh\r\n\r\nTrợ lý Chat thông minh\r\n\r\nKhoanh Vùng Search Đa năng\r\n\r\nSamsung DeX\r\n\r\nCông nghệ NFC\r\n\r\nĐa cửa sổ (chia đôi màn hình)\r\n\r\nChạm 2 lần sáng màn hình\r\n\r\nSạc nhanh 45W\r\n\r\nTích hợp S-Pen trong thân máy\r\n\r\nTrợ lý Note Quyền năng\r\n\r\nAKG Dolby\r\n\r\nChặn tin nhắn\r\n\r\nChặn cuộc gọi\r\n\r\nMàn hình luôn bật (Alway on display)\r\n\r\nGiao tiếp và kết nối\r\nSố khe SIM\r\n1\r\nThẻ SIM\r\n1 eSIM, 1 Nano SIM\r\nHỗ trợ mạng\r\n4G\r\n\r\n5G\r\n\r\nCổng giao tiếp\r\n1 Type C\r\n\r\nWifi\r\n802.11 a/b/g/n/ac/ax, 2x2 MIMO\r\n\r\nWi-Fi Direct\r\n\r\nGPS\r\nGALILEO\r\n\r\nGLONASS\r\n\r\nGPS\r\n\r\nBEIDOU\r\n\r\nQZSS\r\n\r\nBluetooth\r\nv5.3\r\n\r\nKết nối khác\r\nNFC\r\n\r\nBluetooth\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium-ion\r\nDung lượng pin\r\n5000 mAh\r\n\r\nThông tin thêm\r\nSạc ngược cho thiết bị khác\r\n\r\nSạc pin nhanh\r\n\r\nHỗ trợ sạc không dây\r\n\r\nTiết kiệm pin\r\n\r\nHệ điều hành\r\nOS\r\nAndroid\r\n\r\nVersion\r\nAndroid 14\r\nPhụ kiện trong hộp\r\nPhụ kiện trong hộp\r\nQue lấy SIM\r\n\r\nCáp Type C\r\n\r\nSách HDSD', 26490000.00, 0.00, 1, 3, 'available', '2024-12-18 21:11:21', '2024-12-18 21:13:52'),
(3, 'Samsung Galaxy A06 4GB 128GB', 'Điện thoại Android với kích thước màn hình lớn, từ 6,5 inch đến 6,8 inch, mang lại trải nghiệm hình ảnh rộng rãi và sắc nét. Những chiếc điện thoại này thích hợp cho việc xem phim, chơi game và sử dụng các ứng dụng đa phương tiện. Màn hình lớn cũng cung cấp không gian làm việc thoải mái hơn khi soạn thảo văn bản, chỉnh sửa ảnh và duyệt web, tạo cảm giác thoải mái và tiện lợi.', 'Xuất xứ\r\nViệt Nam\r\n\r\nThời điểm ra mắt\r\n09/2024\r\nThời gian bảo hành\r\n12 tháng\r\nHướng dẫn bảo quản\r\nĐể nơi khô ráo, nhẹ tay, dễ vỡ.\r\nHướng dẫn sử dụng\r\nXem trong sách hướng dẫn sử dụng\r\nThiết kế & Trọng lượng\r\nKích thước\r\n167.3 x 77.3 x 8 mm\r\nTrọng lượng sản phẩm\r\n189 g\r\n\r\nChất liệu\r\nNhựa nguyên khối\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nHelio G85\r\nSố nhân\r\n8\r\nRAM\r\nRAM\r\n4 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.7 inch\r\nCông nghệ màn hình\r\nPLS LCD\r\nChuẩn màn hình\r\nHD+\r\nĐộ phân giải\r\n720 x 1600 Pixels\r\n\r\nMàu màn hình\r\n16 Triệu\r\nĐộ sáng\r\n576 nits\r\nĐồ họa\r\nChip đồ hoạ (GPU)\r\nMali-G52\r\nLưu trữ\r\nDung lượng (ROM)\r\n128 GB\r\nDanh bạ lưu trữ\r\nKhông giới hạn\r\n\r\nHỗ trợ thẻ nhớ tối đa\r\n1 TB\r\nCamera sau\r\nSố camera sau\r\nDouble rear camera\r\nResolution\r\n50 MP\r\nResolution\r\n2.0 MP\r\nQuay phim camera sau\r\nHD 720p@120fps\r\n\r\nFullHD 1080p@60fps\r\n\r\nTính năng\r\nZoom kỹ thuật số\r\n\r\nXóa phông\r\n\r\nTự động lấy nét (AF)\r\n\r\nToàn cảnh (Panorama)\r\n\r\nQuay chậm (Slow Motion)\r\n\r\nChuyên nghiệp (Pro)\r\n\r\nBan đêm (Night Mode)\r\n\r\nCamera Selfie\r\nResolution\r\n8.0 MP\r\nTính năng\r\nLàm đẹp (Beautify)\r\n\r\nXóa phông\r\n\r\nBảo mật\r\nBảo mật\r\nMở khoá vân tay cạnh viền\r\n\r\nMở khóa khuôn mặt\r\n\r\nOthers\r\nTính năng đặc biệt\r\nSạc nhanh 25 W\r\n\r\nGiao tiếp và kết nối\r\nSố khe SIM\r\n2\r\nThẻ SIM\r\n2 Nano SIM\r\nHỗ trợ mạng\r\n4G\r\n\r\nCổng giao tiếp\r\nType C\r\n\r\nWifi\r\n802.11 a/b/g/n/ac\r\n\r\nDual-band (2.4 GHz/ 5 GHz)\r\n\r\nWi-Fi Hotspot\r\n\r\nWi-Fi Direct\r\n\r\nGPS\r\nGPS\r\n\r\nGLONASS\r\n\r\nGALILEO\r\n\r\nBEIDOU\r\n\r\nQZSS\r\n\r\nBluetooth\r\nv5.3\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium polymer\r\nDung lượng pin\r\n5000 mAh\r\n\r\nHệ điều hành\r\nOS\r\nAndroid\r\n\r\nVersion\r\nAndroid 14\r\nPhụ kiện trong hộp\r\nPhụ kiện trong hộp\r\nSách HDSD\r\n\r\nCáp\r\n\r\nQue lấy SIM', 3490000.00, 0.00, 1, 3, 'available', '2024-12-18 21:16:00', NULL),
(4, 'Samsung Galaxy A06 4GB 128GB', 'Điện thoại Android với kích thước màn hình lớn, từ 6,5 inch đến 6,8 inch, mang lại trải nghiệm hình ảnh rộng rãi và sắc nét. Những chiếc điện thoại này thích hợp cho việc xem phim, chơi game và sử dụng các ứng dụng đa phương tiện. Màn hình lớn cũng cung cấp không gian làm việc thoải mái hơn khi soạn thảo văn bản, chỉnh sửa ảnh và duyệt web, tạo cảm giác thoải mái và tiện lợi.', 'Xuất xứ\r\nViệt Nam\r\n\r\nThời điểm ra mắt\r\n09/2024\r\nThời gian bảo hành\r\n12 tháng\r\nHướng dẫn bảo quản\r\nĐể nơi khô ráo, nhẹ tay, dễ vỡ.\r\nHướng dẫn sử dụng\r\nXem trong sách hướng dẫn sử dụng\r\nThiết kế & Trọng lượng\r\nKích thước\r\n167.3 x 77.3 x 8 mm\r\nTrọng lượng sản phẩm\r\n189 g\r\n\r\nChất liệu\r\nNhựa nguyên khối\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nHelio G85\r\nSố nhân\r\n8\r\nRAM\r\nRAM\r\n4 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.7 inch\r\nCông nghệ màn hình\r\nPLS LCD\r\nChuẩn màn hình\r\nHD+\r\nĐộ phân giải\r\n720 x 1600 Pixels\r\n\r\nMàu màn hình\r\n16 Triệu\r\nĐộ sáng\r\n576 nits\r\nĐồ họa\r\nChip đồ hoạ (GPU)\r\nMali-G52\r\nLưu trữ\r\nDung lượng (ROM)\r\n128 GB\r\nDanh bạ lưu trữ\r\nKhông giới hạn\r\n\r\nHỗ trợ thẻ nhớ tối đa\r\n1 TB\r\nCamera sau\r\nSố camera sau\r\nDouble rear camera\r\nResolution\r\n50 MP\r\nResolution\r\n2.0 MP\r\nQuay phim camera sau\r\nHD 720p@120fps\r\n\r\nFullHD 1080p@60fps\r\n\r\nTính năng\r\nZoom kỹ thuật số\r\n\r\nXóa phông\r\n\r\nTự động lấy nét (AF)\r\n\r\nToàn cảnh (Panorama)\r\n\r\nQuay chậm (Slow Motion)\r\n\r\nChuyên nghiệp (Pro)\r\n\r\nBan đêm (Night Mode)\r\n\r\nCamera Selfie\r\nResolution\r\n8.0 MP\r\nTính năng\r\nLàm đẹp (Beautify)\r\n\r\nXóa phông\r\n\r\nBảo mật\r\nBảo mật\r\nMở khoá vân tay cạnh viền\r\n\r\nMở khóa khuôn mặt\r\n\r\nOthers\r\nTính năng đặc biệt\r\nSạc nhanh 25 W\r\n\r\nGiao tiếp và kết nối\r\nSố khe SIM\r\n2\r\nThẻ SIM\r\n2 Nano SIM\r\nHỗ trợ mạng\r\n4G\r\n\r\nCổng giao tiếp\r\nType C\r\n\r\nWifi\r\n802.11 a/b/g/n/ac\r\n\r\nDual-band (2.4 GHz/ 5 GHz)\r\n\r\nWi-Fi Hotspot\r\n\r\nWi-Fi Direct\r\n\r\nGPS\r\nGPS\r\n\r\nGLONASS\r\n\r\nGALILEO\r\n\r\nBEIDOU\r\n\r\nQZSS\r\n\r\nBluetooth\r\nv5.3\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium polymer\r\nDung lượng pin\r\n5000 mAh\r\n\r\nHệ điều hành\r\nOS\r\nAndroid\r\n\r\nVersion\r\nAndroid 14\r\nPhụ kiện trong hộp\r\nPhụ kiện trong hộp\r\nSách HDSD\r\n\r\nCáp\r\n\r\nQue lấy SIM', 4490000.00, 3490000.00, 1, 3, 'available', '2024-12-18 21:17:02', NULL),
(5, 'Samsung Galaxy A06 4GB 128GB', 'Điện thoại Android với kích thước màn hình lớn, từ 6,5 inch đến 6,8 inch, mang lại trải nghiệm hình ảnh rộng rãi và sắc nét. Những chiếc điện thoại này thích hợp cho việc xem phim, chơi game và sử dụng các ứng dụng đa phương tiện. Màn hình lớn cũng cung cấp không gian làm việc thoải mái hơn khi soạn thảo văn bản, chỉnh sửa ảnh và duyệt web, tạo cảm giác thoải mái và tiện lợi.', 'Xuất xứ\r\nViệt Nam\r\n\r\nThời điểm ra mắt\r\n09/2024\r\nThời gian bảo hành\r\n12 tháng\r\nHướng dẫn bảo quản\r\nĐể nơi khô ráo, nhẹ tay, dễ vỡ.\r\nHướng dẫn sử dụng\r\nXem trong sách hướng dẫn sử dụng\r\nThiết kế & Trọng lượng\r\nKích thước\r\n167.3 x 77.3 x 8 mm\r\nTrọng lượng sản phẩm\r\n189 g\r\n\r\nChất liệu\r\nNhựa nguyên khối\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nHelio G85\r\nSố nhân\r\n8\r\nRAM\r\nRAM\r\n4 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.7 inch\r\nCông nghệ màn hình\r\nPLS LCD\r\nChuẩn màn hình\r\nHD+\r\nĐộ phân giải\r\n720 x 1600 Pixels\r\n\r\nMàu màn hình\r\n16 Triệu\r\nĐộ sáng\r\n576 nits\r\nĐồ họa\r\nChip đồ hoạ (GPU)\r\nMali-G52\r\nLưu trữ\r\nDung lượng (ROM)\r\n128 GB\r\nDanh bạ lưu trữ\r\nKhông giới hạn\r\n\r\nHỗ trợ thẻ nhớ tối đa\r\n1 TB\r\nCamera sau\r\nSố camera sau\r\nDouble rear camera\r\nResolution\r\n50 MP\r\nResolution\r\n2.0 MP\r\nQuay phim camera sau\r\nHD 720p@120fps\r\n\r\nFullHD 1080p@60fps\r\n\r\nTính năng\r\nZoom kỹ thuật số\r\n\r\nXóa phông\r\n\r\nTự động lấy nét (AF)\r\n\r\nToàn cảnh (Panorama)\r\n\r\nQuay chậm (Slow Motion)\r\n\r\nChuyên nghiệp (Pro)\r\n\r\nBan đêm (Night Mode)\r\n\r\nCamera Selfie\r\nResolution\r\n8.0 MP\r\nTính năng\r\nLàm đẹp (Beautify)\r\n\r\nXóa phông\r\n\r\nBảo mật\r\nBảo mật\r\nMở khoá vân tay cạnh viền\r\n\r\nMở khóa khuôn mặt\r\n\r\nOthers\r\nTính năng đặc biệt\r\nSạc nhanh 25 W\r\n\r\nGiao tiếp và kết nối\r\nSố khe SIM\r\n2\r\nThẻ SIM\r\n2 Nano SIM\r\nHỗ trợ mạng\r\n4G\r\n\r\nCổng giao tiếp\r\nType C\r\n\r\nWifi\r\n802.11 a/b/g/n/ac\r\n\r\nDual-band (2.4 GHz/ 5 GHz)\r\n\r\nWi-Fi Hotspot\r\n\r\nWi-Fi Direct\r\n\r\nGPS\r\nGPS\r\n\r\nGLONASS\r\n\r\nGALILEO\r\n\r\nBEIDOU\r\n\r\nQZSS\r\n\r\nBluetooth\r\nv5.3\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium polymer\r\nDung lượng pin\r\n5000 mAh\r\n\r\nHệ điều hành\r\nOS\r\nAndroid\r\n\r\nVersion\r\nAndroid 14\r\nPhụ kiện trong hộp\r\nPhụ kiện trong hộp\r\nSách HDSD\r\n\r\nCáp\r\n\r\nQue lấy SIM', 3590000.00, 0.00, 1, 3, 'available', '2024-12-18 21:17:54', '2024-12-18 21:18:42'),
(6, 'iPhone 12 64GB', 'Sản phẩm này\r\nCác dòng iPhone có màn hình kích thước vừa, dưới hoặc bằng 6.3 inch, mang lại sự cân đối giữa kích thước và trải nghiệm người dùng. Với màn hình này, người dùng có thể dễ dàng cầm nắm và thao tác một tay mà vẫn có được trải nghiệm hình ảnh tốt.', 'Xuất xứ\r\nTrung Quốc\r\n\r\nThời điểm ra mắt\r\n10/2020\r\nThời gian bảo hành (tháng)\r\n12\r\nThiết kế & Trọng lượng\r\nKích thước\r\n71.5 x 7.4 x 146.7 mm\r\nTrọng lượng sản phẩm\r\n164 g\r\n\r\nChuẩn kháng nước / Bụi bẩn\r\nIP68\r\nChất liệu\r\nMặt lưng máy: Kính\r\n\r\nViền máy: Nhôm\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nApple A14 Bionic\r\nLoại CPU\r\nHexa-Core\r\nCPU\r\n2 x Firestorm 3.1 GHz + 4 x Icestorm 1.8 GHz\r\nSố nhân\r\n6\r\nTốc độ tối đa\r\n3.1 GHz\r\n64 Bits\r\nCó\r\nRAM\r\nRAM\r\n4 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.1 inch\r\nCông nghệ màn hình\r\nOLED\r\nChuẩn màn hình\r\nSuper Retina XDR\r\nĐộ phân giải\r\n2532 x 1170 Pixels\r\n\r\nMàu màn hình\r\n16 Triệu\r\nTần số quét\r\n60 Hz\r\nChất liệu mặt kính\r\nPhủ Ceramic\r\nLoại cảm ứng\r\nĐiện dung đa điểm\r\nTỷ lệ màn hình\r\n19.5:9\r\nLưu trữ\r\nDung lượng (ROM)\r\n64 GB\r\nDanh bạ lưu trữ\r\nTùy bộ nhớ\r\n\r\nThẻ nhớ ngoài\r\nKhông\r\nCamera sau\r\nSố camera sau\r\nDouble rear camera\r\nCamera\r\nWide\r\nResolution\r\n12.0 MP\r\nCamera\r\nUltra Wide\r\nResolution\r\n12.0 MP\r\nQuay phim camera sau\r\nFullHD 1080p@240fps\r\n\r\n4K 2160p@24fps\r\n\r\nFullHD 1080p@60fps\r\n\r\nFullHD 1080p@120fps\r\n\r\n4K 2160p@30fps\r\n\r\nFullHD 1080p@30fps\r\n\r\nHD 720p@30fps\r\n\r\n4K 2160p@60fps\r\n\r\nTính năng\r\nTự động lấy nét (AF)\r\n\r\nBan đêm (Night Mode)\r\n\r\nFlash LED\r\n\r\nTrôi nhanh thời gian (Time Lapse)\r\n\r\nA.I Camera\r\n\r\nHDR\r\n\r\nChụp chân dung\r\n\r\nXóa phông\r\n\r\nChạm lấy nét\r\n\r\nChụp góc rộng (Wide)\r\n\r\nChụp góc siêu rộng (Ultrawide)\r\n\r\nToàn cảnh (Panorama)\r\n\r\nQuay chậm (Slow Motion)\r\n\r\nNhận diện khuôn mặt\r\n\r\nCamera Selfie\r\nSố Camera Selfie\r\nSingle selfie camera\r\nResolution\r\n12.0 MP\r\nAperture\r\nƒ/2.2\r\nQuay phim camera seflie\r\nQuay phim FullHD\r\n\r\nQuay phim HD\r\n\r\nQuay phim 4K\r\n\r\nTính năng\r\nTự động lấy nét (AF)\r\n\r\nXoá phông\r\n\r\nHDR\r\n\r\nChụp góc rộng (Wide)\r\n\r\nNhận diện khuôn mặt\r\n\r\nCảm biến\r\nCảm biến\r\nCảm biến tiệm cận\r\n\r\nCon quay hồi chuyển\r\n\r\nCảm biến trọng lực\r\n\r\nCảm biến ánh sáng\r\n\r\nCảm biến la bàn\r\n\r\nBảo mật\r\nBảo mật\r\nMở khóa bằng mật mã\r\n\r\nMở khóa khuôn mặt\r\n\r\nOthers\r\nLàm mát\r\nCó\r\nThông báo LED\r\nKhông\r\nGiao tiếp và kết nối\r\nThẻ SIM\r\n1 eSIM, 1 Nano SIM\r\nSố khe SIM\r\n1\r\nHỗ trợ mạng\r\n5G\r\n\r\n4G\r\n\r\nCổng giao tiếp\r\nAudio Jack: Lightning\r\n\r\nCổng sạc: Lightning\r\n\r\nWifi\r\n802.11 ax\r\n\r\nGPS\r\nA-GPS\r\n\r\nGLONASS\r\n\r\nQZSS\r\n\r\nGALILEO\r\n\r\nBluetooth\r\nv5.0\r\n\r\nKết nối khác\r\nRadio FM\r\n\r\nNFC\r\n\r\nComputer sync\r\n\r\nOTG\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium-ion\r\nDung lượng pin\r\n2815 mAh\r\n\r\nThông tin thêm\r\nHỗ trợ sạc không dây\r\n\r\nHệ điều hành\r\nOS\r\niOS\r\n\r\nVersion\r\niOS 14\r\nPhụ kiện trong hộp\r\nPhụ kiện trong hộp\r\nCáp\r\n\r\nQue lấy SIM\r\n\r\nSách HDSD', 18999000.00, 0.00, 1, 2, 'available', '2024-12-18 21:20:05', NULL),
(7, 'iPhone 13 128GB', 'Sản phẩm này\r\nCác dòng iPhone có màn hình kích thước vừa, dưới hoặc bằng 6.3 inch, mang lại sự cân đối giữa kích thước và trải nghiệm người dùng. Với màn hình này, người dùng có thể dễ dàng cầm nắm và thao tác một tay mà vẫn có được trải nghiệm hình ảnh tốt.', 'Xuất xứ\r\nTrung Quốc\r\n\r\nThời điểm ra mắt\r\n01/2022\r\nThời gian bảo hành (tháng)\r\n12\r\nHướng dẫn bảo quản\r\nĐể nơi khô ráo, nhẹ tay, dễ vỡ.\r\nHướng dẫn sử dụng\r\nXem trong sách hướng dẫn sử dụng\r\nThiết kế & Trọng lượng\r\nKích thước\r\n71.5 x 7.4 x 146.7 mm\r\nTrọng lượng sản phẩm\r\n164 g\r\n\r\nChất liệu\r\nMặt lưng máy: Kính\r\n\r\nViền máy: Nhôm\r\n\r\nNhôm nguyên khối\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nApple A15 Bionic\r\nSố nhân\r\n6\r\nTốc độ tối đa\r\n3.22 GHz\r\nRAM\r\nRAM\r\n4 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.1 inch\r\nCông nghệ màn hình\r\nOLED\r\nChuẩn màn hình\r\nSuper Retina XDR\r\nĐộ phân giải\r\n2532 x 1170 Pixels\r\n\r\nMàu màn hình\r\n16 Triệu\r\nTần số quét\r\n60 Hz\r\nChất liệu mặt kính\r\nPhủ Ceramic\r\nLoại cảm ứng\r\nĐiện dung đa điểm\r\nTỷ lệ màn hình\r\n19.5:9\r\nĐồ họa\r\nChip đồ hoạ (GPU)\r\nApple GPU 5 nhân\r\nLưu trữ\r\nDung lượng (ROM)\r\n128 GB\r\nDanh bạ lưu trữ\r\nTùy bộ nhớ\r\n\r\nThẻ nhớ ngoài\r\nKhông\r\nCamera sau\r\nSố camera sau\r\nDouble rear camera\r\nCamera\r\nWide\r\nResolution\r\n12.0 MP\r\nCamera\r\nUltra Wide\r\nResolution\r\n12.0 MP\r\nQuay phim camera sau\r\nFullHD 1080p@240fps\r\n\r\nFullHD 1080p@60fps\r\n\r\nHD 720p@30fps\r\n\r\nFullHD 1080p@30fps\r\n\r\n4K 2160p@60fps\r\n\r\n4K 2160p@30fps\r\n\r\n4K 2160p@24fps\r\n\r\nFullHD 1080p@120fps\r\n\r\nTính năng\r\nQuay siêu chậm (Super Slow Motion)\r\n\r\nFlash LED\r\n\r\nToàn cảnh (Panorama)\r\n\r\nBan đêm (Night Mode)\r\n\r\nChụp góc rộng (Wide)\r\n\r\nHDR\r\n\r\nNhận diện khuôn mặt\r\n\r\nChạm lấy nét\r\n\r\nA.I Camera\r\n\r\nXóa phông\r\n\r\nTự động lấy nét (AF)\r\n\r\nTrôi nhanh thời gian (Time Lapse)\r\n\r\nChụp góc siêu rộng (Ultrawide)\r\n\r\nChụp chân dung\r\n\r\nCamera Selfie\r\nSố Camera Selfie\r\nSingle selfie camera\r\nResolution\r\n12.0 MP\r\nAperture\r\nƒ/2.2\r\nQuay phim camera seflie\r\nQuay phim FullHD\r\n\r\nQuay phim HD\r\n\r\nQuay phim 4K\r\n\r\nTính năng\r\nTự động lấy nét (AF)\r\n\r\nChụp góc rộng (Wide)\r\n\r\nXoá phông\r\n\r\nNhận diện khuôn mặt\r\n\r\nHDR\r\n\r\nBảo mật\r\nBảo mật\r\nMở khóa khuôn mặt\r\n\r\nMở khóa bằng mật mã\r\n\r\nGiao tiếp và kết nối\r\nThẻ SIM\r\n1 eSIM, 1 Nano SIM\r\nSố khe SIM\r\n1\r\nHỗ trợ mạng\r\n5G\r\n\r\nCổng giao tiếp\r\nCổng sạc: Lightning\r\n\r\nAudio Jack: Lightning\r\n\r\nWifi\r\n802.11 ax\r\n\r\nGPS\r\nGALILEO\r\n\r\nA-GPS\r\n\r\nQZSS\r\n\r\nGLONASS\r\n\r\nBluetooth\r\nv5.0\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium-ion\r\nDung lượng pin\r\n3225 mAh\r\n\r\nThông tin thêm\r\nHỗ trợ sạc không dây\r\n\r\nHệ điều hành\r\nOS\r\niOS\r\n\r\nVersion\r\niOS 15\r\nPhụ kiện trong hộp\r\nPhụ kiện trong hộp\r\nSách HDSD\r\n\r\nQue lấy SIM\r\n\r\nCáp', 22450000.00, 22350000.00, 1, 2, 'available', '2024-12-18 21:21:39', NULL),
(8, 'iPhone 15 128GB', 'A16 Bionic\r\nSản phẩm này\r\nA16 Bionic là phiên bản nâng cấp của A15, được tích hợp trong các mẫu iPhone mới nhất. Với kiến trúc tiên tiến và hiệu suất cải thiện, A16 Bionic có 6 nhân CPU, 6 nhân GPU và 16 nhân Neural Engine, đem lại khả năng xử lý mạnh mẽ hơn và tiết kiệm pin tốt hơn. Con chip này tối ưu hóa hiệu suất cho các ứng dụng đòi hỏi cao, cung cấp trải nghiệm chơi game, xử lý đồ họa và AI nhanh chóng và hiệu quả.\r\nVừa\r\nSản phẩm này\r\nCác dòng iPhone có màn hình kích thước vừa, dưới hoặc bằng 6.3 inch, mang lại sự cân đối giữa kích thước và trải nghiệm người dùng. Với màn hình này, người dùng có thể dễ dàng cầm nắm và thao tác một tay mà vẫn có được trải nghiệm hình ảnh tốt.\r\nVừa\r\nSản phẩm này\r\nCác mẫu iPhone có thời lượng pin vừa cho phép người dùng xem video liên tục dưới 20 giờ. Đây là mức pin phù hợp cho nhu cầu sử dụng thông thường trong ngày như lướt web, nghe nhạc, và xem video với thời gian vừa phải.', 'Xuất xứ\r\nTrung Quốc\r\n\r\nThời điểm ra mắt\r\n09/2023\r\nThời gian bảo hành (tháng)\r\n12\r\nThiết kế & Trọng lượng\r\nKích thước\r\n147.6 x 71.6 x 7.8 mm\r\nTrọng lượng sản phẩm\r\n171 g\r\n\r\nChuẩn kháng nước / Bụi bẩn\r\nIP68\r\nChất liệu\r\nKhung máy: Nhôm nguyên khối\r\n\r\nMặt lưng máy: Kính\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nApple A16 Bionic\r\nLoại CPU\r\n6 - Core\r\nSố nhân\r\n6\r\nRAM\r\nRAM\r\n6 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.1 inch\r\nCông nghệ màn hình\r\nOLED\r\nChuẩn màn hình\r\nSuper Retina XDR\r\nĐộ phân giải\r\n2556 x 1179 Pixels\r\n\r\nChất liệu mặt kính\r\nPhủ Ceramic\r\nLoại cảm ứng\r\nĐiện dung đa điểm\r\nĐộ sáng tối đa\r\n2000 nits\r\nĐộ tương phản\r\n2.000.000:1\r\nĐồ họa\r\nChip đồ hoạ (GPU)\r\nApple GPU 5 nhân\r\nLưu trữ\r\nDung lượng (ROM)\r\n128 GB\r\nDanh bạ lưu trữ\r\nKhông giới hạn\r\n\r\nThẻ nhớ ngoài\r\nKhông\r\nCamera sau\r\nSố camera sau\r\nDouble rear camera\r\nCamera\r\nStandard\r\nResolution\r\n48.0 MP\r\nCamera\r\nUltra Wide\r\nResolution\r\n12.0 MP\r\nQuay phim camera sau\r\n4K 4320p@24fps\r\n\r\n4K 2160p@25fps\r\n\r\n4K 4230p@30fps\r\n\r\n4K 4230p@60fps\r\n\r\nHD 720p@30fps\r\n\r\nFullHD 1080p@25fps\r\n\r\nFullHD 1080p@60fps\r\n\r\nFullHD 1080p@30fps\r\n\r\nTính năng\r\nQuay chậm (Slow Motion)\r\n\r\nChụp chân dung\r\n\r\nChụp góc rộng (Wide)\r\n\r\nHDR\r\n\r\nChống rung quang học (OIS)\r\n\r\nTự động lấy nét (AF)\r\n\r\nChạm lấy nét\r\n\r\nFlash LED\r\n\r\nCamera Selfie\r\nSố Camera Selfie\r\nSingle selfie camera\r\nResolution\r\n12.0 MP\r\nQuay phim camera seflie\r\nQuay phim 4K\r\n\r\nQuay phim FullHD\r\n\r\nQuay phim Slow Motion\r\n\r\nTính năng\r\nTự động lấy nét (AF)\r\n\r\nHDR\r\n\r\nNhận diện khuôn mặt\r\n\r\nChế độ chân dung\r\n\r\nỔn định hình ảnh quang học\r\n\r\nFlash màn hình\r\n\r\nCảm biến\r\nCảm biến\r\nCảm biến khí áp kế\r\n\r\nCon quay hồi chuyển\r\n\r\nCảm biến ánh sáng\r\n\r\nCảm biến gia tốc\r\n\r\nCảm biến tiệm cận\r\n\r\nBảo mật\r\nBảo mật\r\nMở khóa bằng mật mã\r\n\r\nMở khóa khuôn mặt\r\n\r\nGiao tiếp và kết nối\r\nThẻ SIM\r\n1 eSIM, 1 Nano SIM\r\nSố khe SIM\r\n1\r\nHỗ trợ mạng\r\n5G\r\n\r\nCổng giao tiếp\r\nCổng sạc: Type C\r\n\r\nAudio Jack: Type C\r\n\r\nWifi\r\nWifi 6\r\n\r\nGPS\r\nGLONASS\r\n\r\nGALILEO\r\n\r\nQZSS\r\n\r\nBEIDOU\r\n\r\nBluetooth\r\nv5.3\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium-ion\r\nDung lượng pin\r\n20 Giờ\r\n\r\nThông tin thêm\r\nHỗ trợ sạc không dây\r\n\r\nSạc pin nhanh\r\n\r\nSạc ngược cho thiết bị khác\r\n\r\nHệ điều hành\r\nOS\r\niOS\r\n\r\nVersion\r\niOS 17\r\nPhụ kiện trong hộp\r\nPhụ kiện trong hộp\r\nCáp USB-C to USB-C\r\n\r\nQue lấy SIM\r\n\r\nSách HDSD', 28990000.00, 0.00, 1, 2, 'available', '2024-12-18 21:23:38', NULL),
(9, 'OPPO Find X8 5G 16GB 512GB', 'Điện thoại Android với kích thước màn hình lớn, từ 6,5 inch đến 6,8 inch, mang lại trải nghiệm hình ảnh rộng rãi và sắc nét. Những chiếc điện thoại này thích hợp cho việc xem phim, chơi game và sử dụng các ứng dụng đa phương tiện. Màn hình lớn cũng cung cấp không gian làm việc thoải mái hơn khi soạn thảo văn bản, chỉnh sửa ảnh và duyệt web, tạo cảm giác thoải mái và tiện lợi.', 'Xuất xứ\r\nTrung Quốc\r\n\r\nThời điểm ra mắt\r\n11/2024\r\nThời gian bảo hành\r\n12 tháng\r\nThiết kế & Trọng lượng\r\nKích thước\r\n157.35 x 74.33 x 7.85 mm\r\nTrọng lượng sản phẩm\r\n193 g\r\n\r\nChuẩn kháng nước / Bụi bẩn\r\nIP68\r\nChất liệu\r\nMặt lưng máy: Kính cường lực\r\n\r\nKhung máy: Kim loại\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nDimensity 9400 5G\r\nSố nhân\r\n8\r\nTốc độ tối đa\r\n3.6 GHz\r\nRAM\r\nRAM\r\n16 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.59 inch\r\nCông nghệ màn hình\r\nAMOLED\r\nChuẩn màn hình\r\n1.5K\r\nĐộ phân giải\r\n1256 x 2760 Pixels\r\n\r\nMàu màn hình\r\n1 Tỷ\r\nTần số quét\r\n120\r\nChất liệu mặt kính\r\nGorilla Glass 7i\r\nLoại cảm ứng\r\nĐiện dung đa điểm\r\nĐộ sáng\r\n1600 nits\r\nĐồ họa\r\nChip đồ hoạ (GPU)\r\nImmortalis G925 MC12\r\nLưu trữ\r\nDung lượng (ROM)\r\n512 GB\r\nDanh bạ lưu trữ\r\nKhông giới hạn\r\n\r\nThẻ nhớ ngoài\r\nMicroSD\r\nCamera sau\r\nCamera\r\nStandard\r\nResolution\r\n50.0 MP\r\nAperture\r\nƒ/1.8\r\nCamera\r\nWide\r\nResolution\r\n50.0 MP\r\nAperture\r\nƒ/2.0\r\nCamera\r\nTelephoto\r\nResolution\r\n50.0 MP\r\nAperture\r\nƒ/2.6\r\nQuay phim camera sau\r\n1080p@240fps\r\n\r\n1080p@60fps\r\n\r\n1080p@30fps\r\n\r\n4K 2160p@60fps\r\n\r\n4K 2160p@30fps\r\n\r\nTính năng\r\nQuay chậm (Slow Motion)\r\n\r\nZoom kỹ thuật số\r\n\r\nChống rung quang học (OIS)\r\n\r\nCamera Selfie\r\nResolution\r\n32.0 MP\r\nAperture\r\nƒ/2.4\r\nQuay phim camera selfie\r\n1080p@60fps\r\n\r\n1080p@30fps\r\n\r\n4K 2160p@60fps\r\n\r\n4K 2160p@30fps\r\n\r\nTính năng\r\nTự động lấy nét (AF)\r\n\r\nCảm biến\r\nCảm biến\r\nCảm biến la bàn\r\n\r\nCảm biến gia tốc\r\n\r\nCảm biến ánh sáng\r\n\r\nCảm biến tiệm cận\r\n\r\nCảm biến vân tay (dưới màn hình)\r\n\r\nBảo mật\r\nBảo mật\r\nMở khóa khuôn mặt\r\n\r\nMật khẩu\r\n\r\nMở khóa vân tay\r\n\r\nMở khóa bằng mật mã\r\n\r\nOthers\r\nTính năng đặc biệt\r\nCamera AI\r\n\r\nĐộ bền chuẩn quân đội\r\n\r\nCảm ứng kháng nước\r\n\r\nGiao tiếp và kết nối\r\nSố khe SIM\r\n2\r\nThẻ SIM\r\n2 Nano SIM hoặc 1 eSIM, 1 Nano SIM\r\nHỗ trợ mạng\r\n5G\r\n\r\nCổng giao tiếp\r\nCổng sạc: Type C\r\n\r\nWifi\r\nWifi 6\r\n\r\nGPS\r\nNavIC\r\n\r\nQZSS\r\n\r\nGALILEO\r\n\r\nBDS\r\n\r\nGLONASS\r\n\r\nGPS\r\n\r\nBluetooth\r\nv5.3 BLE\r\n\r\nKết nối khác\r\nNFC\r\n\r\nOTG\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium polymer\r\nDung lượng pin\r\n5630 mAh\r\n\r\nCủ sạc kèm máy\r\nSuperVOOC 80W\r\nThông tin thêm\r\nHỗ trợ sạc không dây\r\n\r\nSạc siêu nhanh SuperVOOC\r\n\r\nHệ điều hành\r\nOS\r\nAndroid\r\n\r\nVersion\r\nAndroid 15 (ColorOS 15)\r\nPhụ kiện trong hộp\r\nPhụ kiện trong hộp\r\nQue lấy SIM\r\n\r\nSách HDSD\r\n\r\nỐp lưng\r\n\r\nCủ sạc\r\n\r\nCáp USB Type C', 22990000.00, 0.00, 1, 4, 'available', '2024-12-19 21:29:36', '2024-12-19 21:30:55'),
(14, 'OPPO Find X8 5G 16GB 512GB', 'Điện thoại Android với kích thước màn hình lớn, từ 6,5 inch đến 6,8 inch, mang lại trải nghiệm hình ảnh rộng rãi và sắc nét. Những chiếc điện thoại này thích hợp cho việc xem phim, chơi game và sử dụng các ứng dụng đa phương tiện. Màn hình lớn cũng cung cấp không gian làm việc thoải mái hơn khi soạn thảo văn bản, chỉnh sửa ảnh và duyệt web, tạo cảm giác thoải mái và tiện lợi.', 'Xuất xứ\r\nTrung Quốc\r\n\r\nThời điểm ra mắt\r\n11/2024\r\nThời gian bảo hành\r\n12 tháng\r\nThiết kế & Trọng lượng\r\nKích thước\r\n157.35 x 74.33 x 7.85 mm\r\nTrọng lượng sản phẩm\r\n193 g\r\n\r\nChuẩn kháng nước / Bụi bẩn\r\nIP68\r\nChất liệu\r\nMặt lưng máy: Kính cường lực\r\n\r\nKhung máy: Kim loại\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nDimensity 9400 5G\r\nSố nhân\r\n8\r\nTốc độ tối đa\r\n3.6 GHz\r\nRAM\r\nRAM\r\n16 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.59 inch\r\nCông nghệ màn hình\r\nAMOLED\r\nChuẩn màn hình\r\n1.5K\r\nĐộ phân giải\r\n1256 x 2760 Pixels\r\n\r\nMàu màn hình\r\n1 Tỷ\r\nTần số quét\r\n120\r\nChất liệu mặt kính\r\nGorilla Glass 7i\r\nLoại cảm ứng\r\nĐiện dung đa điểm\r\nĐộ sáng\r\n1600 nits\r\nĐồ họa\r\nChip đồ hoạ (GPU)\r\nImmortalis G925 MC12\r\nLưu trữ\r\nDung lượng (ROM)\r\n512 GB\r\nDanh bạ lưu trữ\r\nKhông giới hạn\r\n\r\nThẻ nhớ ngoài\r\nMicroSD\r\nCamera sau\r\nCamera\r\nStandard\r\nResolution\r\n50.0 MP\r\nAperture\r\nƒ/1.8\r\nCamera\r\nWide\r\nResolution\r\n50.0 MP\r\nAperture\r\nƒ/2.0\r\nCamera\r\nTelephoto\r\nResolution\r\n50.0 MP\r\nAperture\r\nƒ/2.6\r\nQuay phim camera sau\r\n1080p@240fps\r\n\r\n1080p@60fps\r\n\r\n1080p@30fps\r\n\r\n4K 2160p@60fps\r\n\r\n4K 2160p@30fps\r\n\r\nTính năng\r\nQuay chậm (Slow Motion)\r\n\r\nZoom kỹ thuật số\r\n\r\nChống rung quang học (OIS)\r\n\r\nCamera Selfie\r\nResolution\r\n32.0 MP\r\nAperture\r\nƒ/2.4\r\nQuay phim camera selfie\r\n1080p@60fps\r\n\r\n1080p@30fps\r\n\r\n4K 2160p@60fps\r\n\r\n4K 2160p@30fps\r\n\r\nTính năng\r\nTự động lấy nét (AF)\r\n\r\nCảm biến\r\nCảm biến\r\nCảm biến la bàn\r\n\r\nCảm biến gia tốc\r\n\r\nCảm biến ánh sáng\r\n\r\nCảm biến tiệm cận\r\n\r\nCảm biến vân tay (dưới màn hình)\r\n\r\nBảo mật\r\nBảo mật\r\nMở khóa khuôn mặt\r\n\r\nMật khẩu\r\n\r\nMở khóa vân tay\r\n\r\nMở khóa bằng mật mã\r\n\r\nOthers\r\nTính năng đặc biệt\r\nCamera AI\r\n\r\nĐộ bền chuẩn quân đội\r\n\r\nCảm ứng kháng nước\r\n\r\nGiao tiếp và kết nối\r\nSố khe SIM\r\n2\r\nThẻ SIM\r\n2 Nano SIM hoặc 1 eSIM, 1 Nano SIM\r\nHỗ trợ mạng\r\n5G\r\n\r\nCổng giao tiếp\r\nCổng sạc: Type C\r\n\r\nWifi\r\nWifi 6\r\n\r\nGPS\r\nNavIC\r\n\r\nQZSS\r\n\r\nGALILEO\r\n\r\nBDS\r\n\r\nGLONASS\r\n\r\nGPS\r\n\r\nBluetooth\r\nv5.3 BLE\r\n\r\nKết nối khác\r\nNFC\r\n\r\nOTG\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium polymer\r\nDung lượng pin\r\n5630 mAh\r\n\r\nCủ sạc kèm máy\r\nSuperVOOC 80W\r\nThông tin thêm\r\nHỗ trợ sạc không dây\r\n\r\nSạc siêu nhanh SuperVOOC\r\n\r\nHệ điều hành\r\nOS\r\nAndroid\r\n\r\nVersion\r\nAndroid 15 (ColorOS 15)\r\nPhụ kiện trong hộp\r\nPhụ kiện trong hộp\r\nQue lấy SIM\r\n\r\nSách HDSD\r\n\r\nỐp lưng\r\n\r\nCủ sạc\r\n\r\nCáp USB Type C', 22940000.00, 0.00, 1, 4, 'available', '2024-12-19 21:32:59', NULL),
(15, 'OPPO A3 6GB 128GB', 'Điện thoại Android với kích thước màn hình lớn, từ 6,5 inch đến 6,8 inch, mang lại trải nghiệm hình ảnh rộng rãi và sắc nét. Những chiếc điện thoại này thích hợp cho việc xem phim, chơi game và sử dụng các ứng dụng đa phương tiện. Màn hình lớn cũng cung cấp không gian làm việc thoải mái hơn khi soạn thảo văn bản, chỉnh sửa ảnh và duyệt web, tạo cảm giác thoải mái và tiện lợi.', 'Xuất xứ\r\nTrung Quốc\r\n\r\nThời điểm ra mắt\r\n08/2024\r\nThời gian bảo hành\r\n12 tháng\r\nThiết kế & Trọng lượng\r\nKích thước\r\n165.7 x 76 x 7.68 mm\r\nTrọng lượng sản phẩm\r\n186 g\r\n\r\nChuẩn kháng nước / Bụi bẩn\r\nIP54\r\nChất liệu\r\nKhung máy: Nhựa cao cấp\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nSnapdragon 6s 4G Gen1\r\nLoại CPU\r\nOcta-Core\r\nSố nhân\r\n8\r\nTốc độ tối đa\r\n2.1 GHz\r\nRAM\r\nRAM\r\n6 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.67 inch\r\nCông nghệ màn hình\r\nLCD\r\nChuẩn màn hình\r\nHD+\r\nĐộ phân giải\r\n720 x 1600 Pixels\r\n\r\nTần số quét\r\n90\r\nChất liệu mặt kính\r\nKính cường lực Panda\r\nLoại cảm ứng\r\nĐiện dung đa điểm\r\nĐộ sáng\r\n1000 nits\r\nĐồ họa\r\nChip đồ hoạ (GPU)\r\nAdreno 610\r\nLưu trữ\r\nDung lượng (ROM)\r\n128 GB\r\nDanh bạ lưu trữ\r\nKhông giới hạn\r\n\r\nThẻ nhớ ngoài\r\nMicroSD\r\nHỗ trợ thẻ nhớ tối đa\r\n1 TB\r\nCamera sau\r\nCamera\r\nStandard\r\nResolution\r\n50 MP\r\nAperture\r\nƒ/1.8\r\nCamera Selfie\r\nResolution\r\n5.0 MP\r\nAperture\r\nƒ/2.2\r\nCảm biến\r\nCảm biến\r\nCảm biến vân tay\r\n\r\nCảm biến tiệm cận\r\n\r\nCảm biến ánh sáng\r\n\r\nCảm biến gia tốc\r\n\r\nCảm biến la bàn\r\n\r\nBảo mật\r\nBảo mật\r\nMở khóa bằng mật mã\r\n\r\nMở khoá vân tay cạnh viền\r\n\r\nMật khẩu\r\n\r\nGiao tiếp và kết nối\r\nSố khe SIM\r\n2\r\nThẻ SIM\r\n2 Nano SIM\r\nHỗ trợ mạng\r\n4G\r\n\r\nCổng giao tiếp\r\nCổng sạc: Type C\r\n\r\nWifi\r\n802.11 a/b/g/n/ac\r\n\r\nGPS\r\nGPS\r\n\r\nGLONASS\r\n\r\nBEIDOU\r\n\r\nGALILEO\r\n\r\nQZSS\r\n\r\nBluetooth\r\nv5.0\r\n\r\nKết nối khác\r\nOTG\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium polymer\r\nDung lượng pin\r\n5100 mAh\r\n\r\nCủ sạc kèm máy\r\nSạc nhanh 45 W\r\nHệ điều hành\r\nOS\r\nAndroid\r\n\r\nVersion\r\nAndroid 14 (ColorOS 14)\r\nPhụ kiện trong hộp\r\nPhụ kiện trong hộp\r\nCủ sạc\r\n\r\nCáp Type C\r\n\r\nỐp lưng\r\n\r\nSách HDSD\r\n\r\nQue lấy SIM', 4690000.00, 0.00, 1, 4, 'available', '2024-12-19 21:35:57', NULL),
(16, 'OPPO A18 4GB 64GB', 'Điện thoại Android với kích thước màn hình lớn, từ 6,5 inch đến 6,8 inch, mang lại trải nghiệm hình ảnh rộng rãi và sắc nét. Những chiếc điện thoại này thích hợp cho việc xem phim, chơi game và sử dụng các ứng dụng đa phương tiện. Màn hình lớn cũng cung cấp không gian làm việc thoải mái hơn khi soạn thảo văn bản, chỉnh sửa ảnh và duyệt web, tạo cảm giác thoải mái và tiện lợi.', 'Xuất xứ\r\nTrung Quốc\r\n\r\nThời điểm ra mắt\r\n11/2023\r\nThời gian bảo hành\r\n12 tháng\r\nHướng dẫn bảo quản\r\nĐể nơi khô ráo, nhẹ tay, dễ vỡ.\r\nHướng dẫn sử dụng\r\nXem trong sách hướng dẫn sử dụng\r\nThiết kế & Trọng lượng\r\nKích thước\r\n163.74 x 75.03 x 8.16 mm\r\nTrọng lượng sản phẩm\r\n188 g\r\n\r\nChuẩn kháng nước / Bụi bẩn\r\nIP54\r\nChất liệu\r\nNhựa\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nHelio G85\r\nSố nhân\r\n8\r\nTốc độ tối đa\r\n2 GHz\r\nRAM\r\nRAM\r\n4 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.56 inch\r\nCông nghệ màn hình\r\nLCD\r\nChuẩn màn hình\r\nHD+\r\nĐộ phân giải\r\n720 x 1612 Pixels\r\n\r\nMàu màn hình\r\n16 Triệu\r\nTần số quét\r\n90 Hz\r\nChất liệu mặt kính\r\nKính cường lực Panda\r\nLoại cảm ứng\r\nĐiện dung đa điểm\r\nĐồ họa\r\nChip đồ hoạ (GPU)\r\nMali-G52 MP2\r\nLưu trữ\r\nDung lượng (ROM)\r\n64 GB\r\nThẻ nhớ ngoài\r\nMicroSD\r\nHỗ trợ thẻ nhớ tối đa\r\n1 TB\r\nCamera sau\r\nSố camera sau\r\nDouble rear camera\r\nCamera\r\nStandard\r\nResolution\r\n8.0 MP\r\nAperture\r\nƒ/2.0\r\nCamera\r\nDepth\r\nResolution\r\n2.0 MP\r\nAperture\r\nƒ/2.4\r\nQuay phim camera sau\r\n1080p@30fps\r\n\r\n720p@30fps\r\n\r\nCamera Selfie\r\nSố Camera Selfie\r\nSingle selfie camera\r\nResolution\r\n5.0 MP\r\nAperture\r\nƒ/2.2\r\nCảm biến\r\nCảm biến\r\nCảm biến vân tay\r\n\r\nCảm biến tiệm cận\r\n\r\nCảm biến ánh sáng\r\n\r\nCảm biến gia tốc\r\n\r\nCảm biến la bàn\r\n\r\nBảo mật\r\nBảo mật\r\nMở khoá vân tay cạnh viền\r\n\r\nMở khóa bằng mật mã\r\n\r\nGiao tiếp và kết nối\r\nSố khe SIM\r\n2\r\nThẻ SIM\r\n2 Nano SIM\r\nHỗ trợ mạng\r\n4G\r\n\r\nCổng giao tiếp\r\nCổng sạc: Type C\r\n\r\nAudio Jack: Jack 3.5 mm\r\n\r\nWifi\r\n802.11 a/b/g/n/ac\r\n\r\nDual-band (2.4 GHz/ 5 GHz)\r\n\r\nGPS\r\nGPS\r\n\r\nBluetooth\r\nv5.3\r\n\r\nKết nối khác\r\nOTG\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium polymer\r\nDung lượng pin\r\n5000 mAh\r\n\r\nCủ sạc kèm máy\r\nSạc nhanh 10 W\r\nHệ điều hành\r\nOS\r\nAndroid\r\n\r\nVersion\r\nAndroid 13.0 (ColorOS 13.1)\r\nPhụ kiện trong hộp\r\nPhụ kiện trong hộp\r\nSạc\r\n\r\nCáp Type C\r\n\r\nQue lấy SIM\r\n\r\nỐp lưng\r\n\r\nSách HDSD', 2990000.00, 2490000.00, 1, 4, 'available', '2024-12-19 21:38:52', NULL),
(17, 'OPPO A18 4GB 64GB', 'Điện thoại Android với kích thước màn hình lớn, từ 6,5 inch đến 6,8 inch, mang lại trải nghiệm hình ảnh rộng rãi và sắc nét. Những chiếc điện thoại này thích hợp cho việc xem phim, chơi game và sử dụng các ứng dụng đa phương tiện. Màn hình lớn cũng cung cấp không gian làm việc thoải mái hơn khi soạn thảo văn bản, chỉnh sửa ảnh và duyệt web, tạo cảm giác thoải mái và tiện lợi.', 'Xuất xứ\r\nTrung Quốc\r\n\r\nThời điểm ra mắt\r\n11/2023\r\nThời gian bảo hành\r\n12 tháng\r\nHướng dẫn bảo quản\r\nĐể nơi khô ráo, nhẹ tay, dễ vỡ.\r\nHướng dẫn sử dụng\r\nXem trong sách hướng dẫn sử dụng\r\nThiết kế & Trọng lượng\r\nKích thước\r\n163.74 x 75.03 x 8.16 mm\r\nTrọng lượng sản phẩm\r\n188 g\r\n\r\nChuẩn kháng nước / Bụi bẩn\r\nIP54\r\nChất liệu\r\nNhựa\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nHelio G85\r\nSố nhân\r\n8\r\nTốc độ tối đa\r\n2 GHz\r\nRAM\r\nRAM\r\n4 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.56 inch\r\nCông nghệ màn hình\r\nLCD\r\nChuẩn màn hình\r\nHD+\r\nĐộ phân giải\r\n720 x 1612 Pixels\r\n\r\nMàu màn hình\r\n16 Triệu\r\nTần số quét\r\n90 Hz\r\nChất liệu mặt kính\r\nKính cường lực Panda\r\nLoại cảm ứng\r\nĐiện dung đa điểm\r\nĐồ họa\r\nChip đồ hoạ (GPU)\r\nMali-G52 MP2\r\nLưu trữ\r\nDung lượng (ROM)\r\n64 GB\r\nThẻ nhớ ngoài\r\nMicroSD\r\nHỗ trợ thẻ nhớ tối đa\r\n1 TB\r\nCamera sau\r\nSố camera sau\r\nDouble rear camera\r\nCamera\r\nStandard\r\nResolution\r\n8.0 MP\r\nAperture\r\nƒ/2.0\r\nCamera\r\nDepth\r\nResolution\r\n2.0 MP\r\nAperture\r\nƒ/2.4\r\nQuay phim camera sau\r\n1080p@30fps\r\n\r\n720p@30fps\r\n\r\nCamera Selfie\r\nSố Camera Selfie\r\nSingle selfie camera\r\nResolution\r\n5.0 MP\r\nAperture\r\nƒ/2.2\r\nCảm biến\r\nCảm biến\r\nCảm biến vân tay\r\n\r\nCảm biến tiệm cận\r\n\r\nCảm biến ánh sáng\r\n\r\nCảm biến gia tốc\r\n\r\nCảm biến la bàn\r\n\r\nBảo mật\r\nBảo mật\r\nMở khoá vân tay cạnh viền\r\n\r\nMở khóa bằng mật mã\r\n\r\nGiao tiếp và kết nối\r\nSố khe SIM\r\n2\r\nThẻ SIM\r\n2 Nano SIM\r\nHỗ trợ mạng\r\n4G\r\n\r\nCổng giao tiếp\r\nCổng sạc: Type C\r\n\r\nAudio Jack: Jack 3.5 mm\r\n\r\nWifi\r\n802.11 a/b/g/n/ac\r\n\r\nDual-band (2.4 GHz/ 5 GHz)\r\n\r\nGPS\r\nGPS\r\n\r\nBluetooth\r\nv5.3\r\n\r\nKết nối khác\r\nOTG\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium polymer\r\nDung lượng pin\r\n5000 mAh\r\n\r\nCủ sạc kèm máy\r\nSạc nhanh 10 W\r\nHệ điều hành\r\nOS\r\nAndroid\r\n\r\nVersion\r\nAndroid 13.0 (ColorOS 13.1)\r\nPhụ kiện trong hộp\r\nPhụ kiện trong hộp\r\nSạc\r\n\r\nCáp Type C\r\n\r\nQue lấy SIM\r\n\r\nỐp lưng\r\n\r\nSách HDSD', 2990000.00, 0.00, 1, 4, 'available', '2024-12-19 21:40:25', NULL),
(18, 'OPPO A3 8GB 256GB', 'Điện thoại Android với kích thước màn hình lớn, từ 6,5 inch đến 6,8 inch, mang lại trải nghiệm hình ảnh rộng rãi và sắc nét. Những chiếc điện thoại này thích hợp cho việc xem phim, chơi game và sử dụng các ứng dụng đa phương tiện. Màn hình lớn cũng cung cấp không gian làm việc thoải mái hơn khi soạn thảo văn bản, chỉnh sửa ảnh và duyệt web, tạo cảm giác thoải mái và tiện lợi.', 'Xuất xứ\r\nTrung Quốc\r\n\r\nThời điểm ra mắt\r\n08/2024\r\nThời gian bảo hành\r\n12 tháng\r\nThiết kế & Trọng lượng\r\nKích thước\r\n165.7 x 76 x 7.68 mm\r\nTrọng lượng sản phẩm\r\n186 g\r\n\r\nChuẩn kháng nước / Bụi bẩn\r\nIP54\r\nChất liệu\r\nKhung máy: Nhựa cao cấp\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nSnapdragon 6s 4G Gen1\r\nLoại CPU\r\nOcta-Core\r\nSố nhân\r\n8\r\nTốc độ tối đa\r\n2.1 GHz\r\nRAM\r\nRAM\r\n8 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.67 inch\r\nCông nghệ màn hình\r\nLCD\r\nChuẩn màn hình\r\nHD+\r\nĐộ phân giải\r\n720 x 1600 Pixels\r\n\r\nTần số quét\r\n90\r\nChất liệu mặt kính\r\nKính cường lực Panda\r\nLoại cảm ứng\r\nĐiện dung đa điểm\r\nĐộ sáng\r\n1000 nits\r\nĐồ họa\r\nChip đồ hoạ (GPU)\r\nAdreno 610\r\nLưu trữ\r\nDung lượng (ROM)\r\n256 GB\r\nDanh bạ lưu trữ\r\nKhông giới hạn\r\n\r\nThẻ nhớ ngoài\r\nMicroSD\r\nHỗ trợ thẻ nhớ tối đa\r\n1 TB\r\nCamera sau\r\nCamera\r\nStandard\r\nResolution\r\n50 MP\r\nAperture\r\nƒ/1.8\r\nCamera Selfie\r\nResolution\r\n5.0 MP\r\nAperture\r\nƒ/2.2\r\nCảm biến\r\nCảm biến\r\nCảm biến vân tay\r\n\r\nCảm biến tiệm cận\r\n\r\nCảm biến ánh sáng\r\n\r\nCảm biến gia tốc\r\n\r\nCảm biến la bàn\r\n\r\nBảo mật\r\nBảo mật\r\nMở khóa bằng mật mã\r\n\r\nMở khoá vân tay cạnh viền\r\n\r\nMật khẩu\r\n\r\nGiao tiếp và kết nối\r\nSố khe SIM\r\n2\r\nThẻ SIM\r\n2 Nano SIM\r\nHỗ trợ mạng\r\n4G\r\n\r\nCổng giao tiếp\r\nCổng sạc: Type C\r\n\r\nWifi\r\n802.11 a/b/g/n/ac\r\n\r\nGPS\r\nGPS\r\n\r\nGLONASS\r\n\r\nBEIDOU\r\n\r\nGALILEO\r\n\r\nQZSS\r\n\r\nBluetooth\r\nv5.0\r\n\r\nKết nối khác\r\nOTG\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium polymer\r\nDung lượng pin\r\n5100 mAh\r\n\r\nCủ sạc kèm máy\r\nSạc nhanh 45 W\r\nHệ điều hành\r\nOS\r\nAndroid\r\n\r\nVersion\r\nAndroid 14 (ColorOS 14)\r\nPhụ kiện trong hộp\r\nPhụ kiện trong hộp\r\nCủ sạc\r\n\r\nCáp Type C\r\n\r\nỐp lưng\r\n\r\nSách HDSD\r\n\r\nQue lấy SIM', 6490000.00, 0.00, 1, 4, 'available', '2024-12-19 21:43:04', NULL),
(19, 'Realme C60 4GB-64GB', 'Điện thoại Android với kích thước màn hình lớn, từ 6,5 inch đến 6,8 inch, mang lại trải nghiệm hình ảnh rộng rãi và sắc nét. Những chiếc điện thoại này thích hợp cho việc xem phim, chơi game và sử dụng các ứng dụng đa phương tiện. Màn hình lớn cũng cung cấp không gian làm việc thoải mái hơn khi soạn thảo văn bản, chỉnh sửa ảnh và duyệt web, tạo cảm giác thoải mái và tiện lợi.', 'Xuất xứ\r\nTrung Quốc\r\n\r\nThời điểm ra mắt\r\n03/2024\r\nThời gian bảo hành\r\n12 tháng\r\nHướng dẫn bảo quản\r\nĐể nơi khô ráo, nhẹ tay, dễ vỡ.\r\nThiết kế & Trọng lượng\r\nKích thước\r\n167.2 x 76.7 x 7.99 mm\r\nTrọng lượng sản phẩm\r\n186 g\r\n\r\nChuẩn kháng nước / Bụi bẩn\r\nIP54\r\nChất liệu\r\nKhung máy: Nhựa\r\n\r\nMặt lưng máy: Nhựa\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nUnisoc T612\r\nCPU\r\n2 x Cortex A75 1.8 GHz + 6 x Cortex A55 1.8 GHz\r\nRAM\r\nRAM\r\n4 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.74 inch\r\nCông nghệ màn hình\r\nIPS LCD\r\nChuẩn màn hình\r\nHD+\r\nĐộ phân giải\r\n720 x 1600 Pixels\r\n\r\nMàu màn hình\r\n16.7 Triệu\r\nTần số quét\r\n90\r\nChất liệu mặt kính\r\nKính cường lực Panda\r\nLoại cảm ứng\r\nĐiện dung đa điểm\r\nĐộ sáng\r\n550 nits\r\nĐồ họa\r\nChip đồ hoạ (GPU)\r\nAdreno 650\r\nLưu trữ\r\nDung lượng (ROM)\r\n64 GB\r\nCamera sau\r\nResolution\r\n13.0 MP\r\nResolution\r\n0.08 MP\r\nQuay phim camera sau\r\n1080p@30fps\r\n\r\nTính năng\r\nBan đêm (Night Mode)\r\n\r\nToàn cảnh (Panorama)\r\n\r\nTrôi nhanh thời gian (Time Lapse)\r\n\r\nChụp chân dung\r\n\r\nHDR\r\n\r\nNhận dạng cảnh AI\r\n\r\nBộ lọc màu\r\n\r\nCamera Selfie\r\nResolution\r\n5.0 MP\r\nTính năng\r\nQuay video HD\r\n\r\nChế độ chân dung\r\n\r\nHDR\r\n\r\nNhận diện khuôn mặt\r\n\r\nBộ lọc màu\r\n\r\nHiệu ứng Bokeh\r\n\r\nBảo mật\r\nBảo mật\r\nMở khoá vân tay cạnh viền\r\n\r\nGiao tiếp và kết nối\r\nWifi\r\n802.11 a/b/g\r\n\r\nGPS\r\nGPS\r\n\r\nGALILEO\r\n\r\nGLONASS\r\n\r\nBluetooth\r\nv5.0\r\n\r\nKết nối khác\r\nOTG\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium polymer\r\nDung lượng pin\r\n5000 mAh\r\n\r\nCủ sạc kèm máy\r\nSạc 10 W\r\nHệ điều hành\r\nOS\r\nAndroid\r\n\r\nVersion\r\nAndroid 13.0', 2790000.00, 0.00, 1, 5, 'available', '2024-12-19 21:46:12', NULL),
(20, 'realme C51 4GB-128GB', 'Điện thoại Android với kích thước màn hình lớn, từ 6,5 inch đến 6,8 inch, mang lại trải nghiệm hình ảnh rộng rãi và sắc nét. Những chiếc điện thoại này thích hợp cho việc xem phim, chơi game và sử dụng các ứng dụng đa phương tiện. Màn hình lớn cũng cung cấp không gian làm việc thoải mái hơn khi soạn thảo văn bản, chỉnh sửa ảnh và duyệt web, tạo cảm giác thoải mái và tiện lợi.', 'Xuất xứ\r\nTrung Quốc\r\n\r\nThời điểm ra mắt\r\n03/2024\r\nThời gian bảo hành\r\n12 tháng\r\nHướng dẫn bảo quản\r\nĐể nơi khô ráo, nhẹ tay, dễ vỡ.\r\nThiết kế & Trọng lượng\r\nKích thước\r\n167.2 x 76.7 x 7.99 mm\r\nTrọng lượng sản phẩm\r\n186 g\r\n\r\nChuẩn kháng nước / Bụi bẩn\r\nIP54\r\nChất liệu\r\nKhung máy: Nhựa\r\n\r\nMặt lưng máy: Nhựa\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nUnisoc T612\r\nCPU\r\n2 x Cortex A75 1.8 GHz + 6 x Cortex A55 1.8 GHz\r\nRAM\r\nRAM\r\n4 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.74 inch\r\nCông nghệ màn hình\r\nIPS LCD\r\nChuẩn màn hình\r\nHD+\r\nĐộ phân giải\r\n720 x 1600 Pixels\r\n\r\nMàu màn hình\r\n16.7 Triệu\r\nTần số quét\r\n90\r\nChất liệu mặt kính\r\nKính cường lực Panda\r\nLoại cảm ứng\r\nĐiện dung đa điểm\r\nĐộ sáng\r\n550 nits\r\nĐồ họa\r\nChip đồ hoạ (GPU)\r\nAdreno 650\r\nLưu trữ\r\nDung lượng (ROM)\r\n64 GB\r\nCamera sau\r\nResolution\r\n13.0 MP\r\nResolution\r\n0.08 MP\r\nQuay phim camera sau\r\n1080p@30fps\r\n\r\nTính năng\r\nBan đêm (Night Mode)\r\n\r\nToàn cảnh (Panorama)\r\n\r\nTrôi nhanh thời gian (Time Lapse)\r\n\r\nChụp chân dung\r\n\r\nHDR\r\n\r\nNhận dạng cảnh AI\r\n\r\nBộ lọc màu\r\n\r\nCamera Selfie\r\nResolution\r\n5.0 MP\r\nTính năng\r\nQuay video HD\r\n\r\nChế độ chân dung\r\n\r\nHDR\r\n\r\nNhận diện khuôn mặt\r\n\r\nBộ lọc màu\r\n\r\nHiệu ứng Bokeh\r\n\r\nBảo mật\r\nBảo mật\r\nMở khoá vân tay cạnh viền\r\n\r\nGiao tiếp và kết nối\r\nWifi\r\n802.11 a/b/g\r\n\r\nGPS\r\nGPS\r\n\r\nGALILEO\r\n\r\nGLONASS\r\n\r\nBluetooth\r\nv5.0\r\n\r\nKết nối khác\r\nOTG\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium polymer\r\nDung lượng pin\r\n5000 mAh\r\n\r\nCủ sạc kèm máy\r\nSạc 10 W\r\nHệ điều hành\r\nOS\r\nAndroid\r\n\r\nVersion\r\nAndroid 13.0', 2.89, 0.00, 1, 5, 'available', '2024-12-19 21:48:55', NULL),
(21, 'Xiaomi POCO X6 5G 16GB-256GB', 'Điện thoại Android với kích thước màn hình lớn, từ 6,5 inch đến 6,8 inch, mang lại trải nghiệm hình ảnh rộng rãi và sắc nét. Những chiếc điện thoại này thích hợp cho việc xem phim, chơi game và sử dụng các ứng dụng đa phương tiện. Màn hình lớn cũng cung cấp không gian làm việc thoải mái hơn khi soạn thảo văn bản, chỉnh sửa ảnh và duyệt web, tạo cảm giác thoải mái và tiện lợi.', 'Xuất xứ\r\nTrung Quốc\r\n\r\nThời điểm ra mắt\r\n03/2024\r\nThời gian bảo hành\r\n12 tháng\r\nHướng dẫn bảo quản\r\nĐể nơi khô ráo, nhẹ tay, dễ vỡ.\r\nThiết kế & Trọng lượng\r\nKích thước\r\n167.2 x 76.7 x 7.99 mm\r\nTrọng lượng sản phẩm\r\n186 g\r\n\r\nChuẩn kháng nước / Bụi bẩn\r\nIP54\r\nChất liệu\r\nKhung máy: Nhựa\r\n\r\nMặt lưng máy: Nhựa\r\n\r\nBộ xử lý\r\nPhiên bản CPU\r\nUnisoc T612\r\nCPU\r\n2 x Cortex A75 1.8 GHz + 6 x Cortex A55 1.8 GHz\r\nRAM\r\nRAM\r\n4 GB\r\nMàn hình\r\nKích thước màn hình\r\n6.74 inch\r\nCông nghệ màn hình\r\nIPS LCD\r\nChuẩn màn hình\r\nHD+\r\nĐộ phân giải\r\n720 x 1600 Pixels\r\n\r\nMàu màn hình\r\n16.7 Triệu\r\nTần số quét\r\n90\r\nChất liệu mặt kính\r\nKính cường lực Panda\r\nLoại cảm ứng\r\nĐiện dung đa điểm\r\nĐộ sáng\r\n550 nits\r\nĐồ họa\r\nChip đồ hoạ (GPU)\r\nAdreno 650\r\nLưu trữ\r\nDung lượng (ROM)\r\n64 GB\r\nCamera sau\r\nResolution\r\n13.0 MP\r\nResolution\r\n0.08 MP\r\nQuay phim camera sau\r\n1080p@30fps\r\n\r\nTính năng\r\nBan đêm (Night Mode)\r\n\r\nToàn cảnh (Panorama)\r\n\r\nTrôi nhanh thời gian (Time Lapse)\r\n\r\nChụp chân dung\r\n\r\nHDR\r\n\r\nNhận dạng cảnh AI\r\n\r\nBộ lọc màu\r\n\r\nCamera Selfie\r\nResolution\r\n5.0 MP\r\nTính năng\r\nQuay video HD\r\n\r\nChế độ chân dung\r\n\r\nHDR\r\n\r\nNhận diện khuôn mặt\r\n\r\nBộ lọc màu\r\n\r\nHiệu ứng Bokeh\r\n\r\nBảo mật\r\nBảo mật\r\nMở khoá vân tay cạnh viền\r\n\r\nGiao tiếp và kết nối\r\nWifi\r\n802.11 a/b/g\r\n\r\nGPS\r\nGPS\r\n\r\nGALILEO\r\n\r\nGLONASS\r\n\r\nBluetooth\r\nv5.0\r\n\r\nKết nối khác\r\nOTG\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium polymer\r\nDung lượng pin\r\n5000 mAh\r\n\r\nCủ sạc kèm máy\r\nSạc 10 W\r\nHệ điều hành\r\nOS\r\nAndroid\r\n\r\nVersion\r\nAndroid 13.0', 7.99, 0.00, 1, 6, 'available', '2024-12-19 21:52:50', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `ram` varchar(255) DEFAULT NULL,
  `rom` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `product_id`, `ram`, `rom`, `color`, `created_at`, `updated_at`) VALUES
(1, 1, '8GB', '256GB', 'black', '2024-12-18 21:08:30', '2024-12-18 21:10:19'),
(2, 2, '4GB', '256GB', 'vang', '2024-12-18 21:11:21', '2024-12-18 21:13:52'),
(3, 3, '4GB', '128GB', 'black', '2024-12-18 21:16:00', NULL),
(4, 4, '4GB', '128GB', 'xanhngoc', '2024-12-18 21:17:02', NULL),
(5, 5, '4GB', '128GB', 'white', '2024-12-18 21:17:54', '2024-12-18 21:18:42'),
(6, 6, '4GB', '64GB', 'tim', '2024-12-18 21:20:05', NULL),
(7, 7, '4GB', '128GB', 'white', '2024-12-18 21:21:39', NULL),
(8, 8, '4GB', '128GB', 'pink', '2024-12-18 21:23:38', NULL),
(9, 9, '8GB', '512GB', 'Xám', '2024-12-19 21:29:36', '2024-12-19 21:30:55'),
(14, 14, '16GB', '512GB', 'Đen', '2024-12-19 21:32:59', NULL),
(15, 15, '4GB', '128GB', 'Đen', '2024-12-19 21:35:57', NULL),
(16, 16, '4GB', '64GB', 'Đen', '2024-12-19 21:38:52', NULL),
(17, 17, '4GB', '64GB', 'Xanh ngọc', '2024-12-19 21:40:25', NULL),
(18, 18, '4GB', '256GB', 'Đen', '2024-12-19 21:43:04', NULL),
(19, 19, '4GB', '64GB', 'Xanh ngọc', '2024-12-19 21:46:12', NULL),
(20, 20, '4GB', '128GB', 'Xanh ngọc', '2024-12-19 21:48:55', NULL),
(21, 21, '16GB', '512GB', 'Đen', '2024-12-19 21:52:50', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `is_primary`, `created_at`, `updated_at`) VALUES
(1, 1, '/storage/uploads/2024/12/19/2024_1_15_638409395341919374_samsung-galaxy-s24-ultra-den-1.png', 0, '2024-12-18 21:08:30', NULL),
(2, 1, '/storage/uploads/2024/12/19/2024_1_27_638419497667721719_samsung-galaxy-s24-ultra-den-4.png', 0, '2024-12-18 21:08:53', NULL),
(3, 1, '/storage/uploads/2024/12/19/2024_1_27_638419497667877853_samsung-galaxy-s24-ultra-den-2.png', 0, '2024-12-18 21:08:53', NULL),
(4, 1, '/storage/uploads/2024/12/19/2024_1_27_638419497672098301_samsung-galaxy-s24-ultra-den-5.png', 0, '2024-12-18 21:08:53', NULL),
(5, 1, '/storage/uploads/2024/12/19/2024_1_27_638419497673667830_samsung-galaxy-s24-ultra-den-3.png', 0, '2024-12-18 21:08:53', NULL),
(6, 2, '/storage/uploads/2024/12/19/2024_1_15_638409395342231798_samsung-galaxy-s24-ultra-xam-1.png', 0, '2024-12-18 21:11:21', NULL),
(7, 2, '/storage/uploads/2024/12/19/2024_1_27_638419500119009687_samsung-galaxy-s24-ultra-xam-5.png', 0, '2024-12-18 21:14:07', NULL),
(8, 2, '/storage/uploads/2024/12/19/2024_1_27_638419500119634766_samsung-galaxy-s24-ultra-xam-3.png', 0, '2024-12-18 21:14:07', NULL),
(9, 2, '/storage/uploads/2024/12/19/2024_1_27_638419500119790990_samsung-galaxy-s24-ultra-xam-2.png', 0, '2024-12-18 21:14:07', NULL),
(10, 2, '/storage/uploads/2024/12/19/2024_1_27_638419500119790990_samsung-galaxy-s24-ultra-xam-4.png', 0, '2024-12-18 21:14:07', NULL),
(11, 3, '/storage/uploads/2024/12/19/samsung_galaxy_a06_blue_black_1_46d3694f11.png', 0, '2024-12-18 21:16:00', NULL),
(12, 3, '/storage/uploads/2024/12/19/samsung_galaxy_a06_blue_black_2_a3b9209953.png', 0, '2024-12-18 21:16:18', NULL),
(13, 3, '/storage/uploads/2024/12/19/samsung_galaxy_a06_blue_black_3_d377f49ae1.png', 0, '2024-12-18 21:16:18', NULL),
(14, 3, '/storage/uploads/2024/12/19/samsung_galaxy_a06_blue_black_4_260cfb94c9.png', 0, '2024-12-18 21:16:18', NULL),
(15, 3, '/storage/uploads/2024/12/19/samsung_galaxy_a06_blue_black_5_e96f65faac.png', 0, '2024-12-18 21:16:18', NULL),
(16, 4, '/storage/uploads/2024/12/19/samsung_galaxy_a06_light_green_1_74345bb624.png', 0, '2024-12-18 21:17:02', NULL),
(17, 4, '/storage/uploads/2024/12/19/samsung_galaxy_a06_light_green_2_6edfb5fd64.png', 0, '2024-12-18 21:17:24', NULL),
(18, 4, '/storage/uploads/2024/12/19/samsung_galaxy_a06_light_green_3_4f05a81cbe.png', 0, '2024-12-18 21:17:24', NULL),
(19, 4, '/storage/uploads/2024/12/19/samsung_galaxy_a06_light_green_4_83035c0a22.png', 0, '2024-12-18 21:17:24', NULL),
(20, 5, '/storage/uploads/2024/12/19/samsung_galaxy_a06_light_blue_1_5c64d81b65.png', 0, '2024-12-18 21:17:54', NULL),
(21, 5, '/storage/uploads/2024/12/19/samsung_galaxy_a06_light_blue_2_e4f7723b8b.png', 0, '2024-12-18 21:18:09', NULL),
(22, 5, '/storage/uploads/2024/12/19/samsung_galaxy_a06_light_blue_4_ccc507bd88.png', 0, '2024-12-18 21:18:09', NULL),
(23, 5, '/storage/uploads/2024/12/19/samsung_galaxy_a06_light_blue_5_e288e8b3f5.png', 0, '2024-12-18 21:18:09', NULL),
(24, 6, '/storage/uploads/2024/12/19/2021_4_21_637546100127716608_iphone-12-tim-1.jpg', 0, '2024-12-18 21:20:05', NULL),
(25, 6, '/storage/uploads/2024/12/19/2022_12_6_638059232363050040_iphone-12-tim-3.jpg', 0, '2024-12-18 21:20:21', NULL),
(26, 6, '/storage/uploads/2024/12/19/2022_12_6_638059232363674839_iphone-12-tim-2.jpg', 0, '2024-12-18 21:20:21', NULL),
(27, 6, '/storage/uploads/2024/12/19/2022_12_6_638059232363845825_iphone-12-tim-1.jpg', 0, '2024-12-18 21:20:21', NULL),
(28, 6, '/storage/uploads/2024/12/19/2022_12_6_638059232363845825_iphone-12-tim-4.jpg', 0, '2024-12-18 21:20:21', NULL),
(29, 6, '/storage/uploads/2024/12/19/2022_12_6_638059232363362296_iphone-12-tim-5.jpg', 0, '2024-12-18 21:20:25', NULL),
(30, 7, '/storage/uploads/2024/12/19/2021_9_15_637673230236322511_iphone-13-mini-trang-1.jpg', 0, '2024-12-18 21:21:39', NULL),
(31, 7, '/storage/uploads/2024/12/19/2022_4_25_637864949257126391_iphone-13-trang-3.jpg', 0, '2024-12-18 21:22:03', NULL),
(32, 7, '/storage/uploads/2024/12/19/2022_4_25_637864949258532597_iphone-13-trang-1.jpg', 0, '2024-12-18 21:22:03', NULL),
(33, 7, '/storage/uploads/2024/12/19/2022_4_25_637864949258532597_iphone-13-trang-4.jpg', 0, '2024-12-18 21:22:03', NULL),
(34, 7, '/storage/uploads/2024/12/19/2022_4_25_637864949259157858_iphone-13-trang-2.jpg', 0, '2024-12-18 21:22:03', NULL),
(35, 7, '/storage/uploads/2024/12/19/2022_4_25_637864949259157858_iphone-13-trang-5.jpg', 0, '2024-12-18 21:22:03', NULL),
(36, 7, '/storage/uploads/2024/12/19/2022_3_30_637842470241093594_unbox.jpg', 0, '2024-12-18 21:22:07', NULL),
(37, 8, '/storage/uploads/2024/12/19/2023_9_15_638303942321093007_iphone-15-hong-1.jpg', 0, '2024-12-18 21:23:38', NULL),
(40, 8, '/storage/uploads/2024/12/19/2023_9_15_638303942320468016_iphone-15-hong-2.jpg', 0, '2024-12-18 21:24:02', NULL),
(41, 8, '/storage/uploads/2024/12/19/2023_9_15_638303935657395275_iphone-15-8.jpg', 0, '2024-12-18 21:24:02', NULL),
(42, 8, '/storage/uploads/2024/12/19/2023_9_15_638303942320311782_iphone-15-hong-9.jpg', 0, '2024-12-18 21:24:02', NULL),
(46, 9, '/storage/uploads/2024/12/20/oppo_find_x8_star_gray_1_eac4c1a075.png', 0, '2024-12-19 21:29:36', NULL),
(51, 9, '/storage/uploads/2024/12/20/oppo_find_x8_star_gray_2_a0dbfaf4a0.png', 0, '2024-12-19 21:31:17', NULL),
(52, 9, '/storage/uploads/2024/12/20/oppo_find_x8_star_gray_3_64a300e117.png', 0, '2024-12-19 21:31:17', NULL),
(53, 9, '/storage/uploads/2024/12/20/oppo_find_x8_star_gray_4_e90f592b6e.png', 0, '2024-12-19 21:31:17', NULL),
(54, 9, '/storage/uploads/2024/12/20/oppo_find_x8_star_gray_5_1aad8f621f.png', 0, '2024-12-19 21:31:17', NULL),
(55, 9, '/storage/uploads/2024/12/20/oppo_find_x8_star_gray_6_382a6b1ad5.png', 0, '2024-12-19 21:31:17', NULL),
(56, 9, '/storage/uploads/2024/12/20/oppo_find_x8_star_gray_7_7ece35e77d.png', 0, '2024-12-19 21:31:17', NULL),
(57, 14, '/storage/uploads/2024/12/20/oppo_find_x8_space_black_1_6a9c3746b3.png', 0, '2024-12-19 21:32:59', NULL),
(58, 14, '/storage/uploads/2024/12/20/oppo_find_x8_space_black_2_d3eb7d99a3.png', 0, '2024-12-19 21:33:18', NULL),
(59, 14, '/storage/uploads/2024/12/20/oppo_find_x8_space_black_3_2945016997.png', 0, '2024-12-19 21:33:18', NULL),
(60, 14, '/storage/uploads/2024/12/20/oppo_find_x8_space_black_4_486e709fe7.png', 0, '2024-12-19 21:33:18', NULL),
(61, 14, '/storage/uploads/2024/12/20/oppo_find_x8_space_black_5_b81871490a.png', 0, '2024-12-19 21:33:18', NULL),
(62, 14, '/storage/uploads/2024/12/20/oppo_find_x8_space_black_6_4af51cb39e.png', 0, '2024-12-19 21:33:18', NULL),
(63, 14, '/storage/uploads/2024/12/20/oppo_find_x8_space_black_7_a6328af584.png', 0, '2024-12-19 21:33:18', NULL),
(64, 15, '/storage/uploads/2024/12/20/oppo_a3_den_5_1b29542df8.jpg', 0, '2024-12-19 21:35:57', NULL),
(65, 15, '/storage/uploads/2024/12/20/oppo_a3_den_1_60d31c4366.jpg', 0, '2024-12-19 21:35:57', NULL),
(66, 15, '/storage/uploads/2024/12/20/oppo_a3_den_2_83b299cb78.jpg', 0, '2024-12-19 21:35:57', NULL),
(67, 15, '/storage/uploads/2024/12/20/oppo_a3_den_3_270c46373a.jpg', 0, '2024-12-19 21:35:57', NULL),
(68, 15, '/storage/uploads/2024/12/20/oppo_a3_den_4_aadaa7e4ac.jpg', 0, '2024-12-19 21:35:57', NULL),
(69, 16, '/storage/uploads/2024/12/20/2023_10_31_638343389527239242_oppo-a18-den-5.jpg', 0, '2024-12-19 21:38:52', NULL),
(70, 16, '/storage/uploads/2024/12/20/2023_10_31_638343389526851003_oppo-a18-den-3.jpg', 0, '2024-12-19 21:39:13', NULL),
(71, 16, '/storage/uploads/2024/12/20/2023_10_31_638343389527538441_oppo-a18-den-1.jpg', 0, '2024-12-19 21:39:13', NULL),
(72, 16, '/storage/uploads/2024/12/20/2023_10_31_638343389527605292_oppo-a18-den-2.jpg', 0, '2024-12-19 21:39:13', NULL),
(73, 16, '/storage/uploads/2024/12/20/2023_10_31_638343389527605292_oppo-a18-den-4.jpg', 0, '2024-12-19 21:39:13', NULL),
(74, 17, '/storage/uploads/2024/12/20/2023_10_31_638343387237209076_oppo-a18-xanh-1.jpg', 0, '2024-12-19 21:40:25', NULL),
(75, 17, '/storage/uploads/2024/12/20/2023_10_31_638343387236418434_oppo-a18-xanh-4.jpg', 0, '2024-12-19 21:40:25', NULL),
(76, 17, '/storage/uploads/2024/12/20/2023_10_31_638343387236574731_oppo-a18-xanh-3.jpg', 0, '2024-12-19 21:40:25', NULL),
(77, 17, '/storage/uploads/2024/12/20/2023_10_31_638343387237051995_oppo-a18-xanh-5.jpg', 0, '2024-12-19 21:40:25', NULL),
(78, 17, '/storage/uploads/2024/12/20/2023_10_31_638343387237365361_oppo-a18-xanh-2.jpg', 0, '2024-12-19 21:40:25', NULL),
(79, 18, '/storage/uploads/2024/12/20/oppo_a3_den_5_1b29542df8.jpg', 0, '2024-12-19 21:43:04', NULL),
(80, 18, '/storage/uploads/2024/12/20/oppo_a3_den_1_60d31c4366.jpg', 0, '2024-12-19 21:43:04', NULL),
(81, 18, '/storage/uploads/2024/12/20/oppo_a3_den_2_83b299cb78.jpg', 0, '2024-12-19 21:43:04', NULL),
(82, 18, '/storage/uploads/2024/12/20/oppo_a3_den_3_270c46373a.jpg', 0, '2024-12-19 21:43:04', NULL),
(83, 18, '/storage/uploads/2024/12/20/oppo_a3_den_4_aadaa7e4ac.jpg', 0, '2024-12-19 21:43:04', NULL),
(84, 19, '/storage/uploads/2024/12/20/2024_2_23_638442955484667991_realme-c60-xanh-5.jpg', 0, '2024-12-19 21:46:12', NULL),
(85, 19, '/storage/uploads/2024/12/20/2024_2_23_638442955483259277_realme-c60-xanh-1.jpg', 0, '2024-12-19 21:46:12', NULL),
(86, 19, '/storage/uploads/2024/12/20/2024_2_23_638442955484043135_realme-c60-xanh-2.jpg', 0, '2024-12-19 21:46:12', NULL),
(87, 19, '/storage/uploads/2024/12/20/2024_2_23_638442955484511914_realme-c60-xanh-3.jpg', 0, '2024-12-19 21:46:12', NULL),
(88, 19, '/storage/uploads/2024/12/20/2024_2_23_638442955485720002_realme-c60-xanh-4.jpg', 0, '2024-12-19 21:46:12', NULL),
(89, 20, '/storage/uploads/2024/12/20/2023_8_23_638283977641921245_realme-c51-xanh-3.jpg', 0, '2024-12-19 21:48:55', NULL),
(90, 20, '/storage/uploads/2024/12/20/2023_8_23_638283977640920805_realme-c51-xanh-4.jpg', 0, '2024-12-19 21:48:55', NULL),
(91, 20, '/storage/uploads/2024/12/20/2023_8_23_638283977641607522_realme-c51-xanh-1.jpg', 0, '2024-12-19 21:48:55', NULL),
(92, 20, '/storage/uploads/2024/12/20/2023_8_23_638283977642077376_realme-c51-xanh-2.jpg', 0, '2024-12-19 21:48:55', NULL),
(93, 20, '/storage/uploads/2024/12/20/2023_8_23_638283977642233590_realme-c51-xanh-5.jpg', 0, '2024-12-19 21:48:55', NULL),
(94, 21, '/storage/uploads/2024/12/20/00909922_poco_x6_black_1_9139e71156.png', 0, '2024-12-19 21:52:50', NULL),
(95, 21, '/storage/uploads/2024/12/20/00909922_poco_x6_black_2_6e29891356.png', 0, '2024-12-19 21:52:50', NULL),
(96, 21, '/storage/uploads/2024/12/20/00909922_poco_x6_black_3_21f03da5b1.png', 0, '2024-12-19 21:52:50', NULL),
(97, 21, '/storage/uploads/2024/12/20/00909922_poco_x6_black_4_dff69f444d.png', 0, '2024-12-19 21:52:50', NULL),
(98, 21, '/storage/uploads/2024/12/20/00909922_poco_x6_black_5_379f3a1659.png', 0, '2024-12-19 21:52:50', NULL),
(99, 21, '/storage/uploads/2024/12/20/00909922_poco_x6_black_6_bb15c074bb.png', 0, '2024-12-19 21:52:50', NULL),
(100, 21, '/storage/uploads/2024/12/20/00909922_poco_x6_black_1205e4d2ba.png', 0, '2024-12-19 21:52:50', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shipping`
--

CREATE TABLE `shipping` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping_status` enum('pending','shipped','delivered') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$12$pP1YqMUFXuXQMMP/fzos.eLXL0F0SJ3ZzDUzjdl.oyP9HpC7Thsd.', NULL, NULL, 'admin', 'active', '2024-12-18 20:55:37', NULL),
(2, 'khach hang', 'kh@gmail.com', '$2y$12$s1xjSDxHJZQtF3fHiEBv6eWi7LcfK6Gn1RzoWekL9otKuy0NseyH6', '1234567890', 'asdas', 'user', 'active', '2024-12-19 04:41:44', '2024-12-19 06:43:23');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `carts_product_attribute_id_foreign` (`product_attribute_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_attributes_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_order_id_foreign` (`order_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT cho bảng `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_attribute_id_foreign` FOREIGN KEY (`product_attribute_id`) REFERENCES `product_attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD CONSTRAINT `product_attributes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `shipping`
--
ALTER TABLE `shipping`
  ADD CONSTRAINT `shipping_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
