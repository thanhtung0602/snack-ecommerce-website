-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 28, 2026 lúc 01:00 PM
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
-- Cơ sở dữ liệu: `qlbh`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietgd`
--

CREATE TABLE `chitietgd` (
  `magd` int(11) NOT NULL,
  `masp` int(11) NOT NULL,
  `soluong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietgd`
--

INSERT INTO `chitietgd` (`magd`, `masp`, `soluong`) VALUES
(1, 1, 1),
(1, 4, 1),
(2, 5, 1),
(3, 4, 1),
(3, 7, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmucsp`
--

CREATE TABLE `danhmucsp` (
  `madm` int(11) NOT NULL,
  `tendm` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmucsp`
--

INSERT INTO `danhmucsp` (`madm`, `tendm`) VALUES
(1, 'Đồ ăn vật cay'),
(2, 'Bánh kẹo ngọt'),
(3, 'Các loại khô'),
(4, 'Đồ uống & Trà sữa');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giaodich`
--

CREATE TABLE `giaodich` (
  `magd` int(11) NOT NULL,
  `tinhtrang` int(11) NOT NULL DEFAULT 0,
  `user_id` varchar(50) DEFAULT NULL,
  `ten` varchar(255) NOT NULL,
  `quan` varchar(100) NOT NULL,
  `diachi` text NOT NULL,
  `sodt` varchar(20) NOT NULL,
  `tongtien` double NOT NULL,
  `ngaygd` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giaodich`
--

INSERT INTO `giaodich` (`magd`, `tinhtrang`, `user_id`, `ten`, `quan`, `diachi`, `sodt`, `tongtien`, `ngaygd`) VALUES
(1, 1, '3', 'Lê Thanh Tùng', 'ntl', '206 Phương Canh', '0908070605', 70000, '2026-03-15 16:48:05'),
(2, 1, '0', 'Lê Thanh Tùng', 'ntl', '206 Phương Canh', '22222222222', 35000, '2026-03-16 19:44:15'),
(3, 0, '0', 'Tùng', 'ntl', 'sadasd', '23232323', 53000, '2026-03-17 10:07:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `user_id` int(11) NOT NULL,
  `masp` int(11) NOT NULL,
  `soluong` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `masp` int(11) NOT NULL,
  `madm` int(11) NOT NULL,
  `tensp` varchar(255) NOT NULL,
  `gia` int(11) NOT NULL,
  `khuyenmai` int(11) NOT NULL DEFAULT 0,
  `xuatsu` varchar(255) DEFAULT NULL,
  `ngaysanxuat` date DEFAULT NULL,
  `hansudung` varchar(100) DEFAULT NULL,
  `anhchinh` varchar(255) NOT NULL,
  `luotmua` int(11) DEFAULT 0,
  `ngay_nhap` datetime NOT NULL,
  `trongluong` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `thanhphan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`masp`, `madm`, `tensp`, `gia`, `khuyenmai`, `xuatsu`, `ngaysanxuat`, `hansudung`, `anhchinh`, `luotmua`, `ngay_nhap`, `trongluong`, `thanhphan`) VALUES
(1, 1, 'Khô gà lá chanh', 45000, 0, 'Việt Nam', '2026-03-01', '6 tháng', 'images/kho-ga.jpg', 150, '2023-10-01 10:00:00', '500g', '100% Thịt gà tươi, lá chanh, ớt sấy'),
(2, 1, 'Bánh tráng trộn', 20000, 0, 'Tây Ninh, Việt Nam', '2026-03-10', '3 tháng', 'images/banh-trang.jpg', 300, '2023-10-02 11:30:00', '250g', 'Bánh tráng phơi sương, bò khô, ruốc, sa tế'),
(3, 2, 'Bánh gấu chùm ngây', 35000, 0, 'Việt Nam', '2026-02-15', '12 tháng', 'images/banh-gau.jpg', 80, '2023-10-03 14:00:00', '300g', 'Bột mì cao cấp, kem sữa, bột chùm ngây'),
(4, 4, 'Trà sữa trân châu', 25000, 0, 'Đài Loan', '2026-03-15', 'Trong ngày', 'images/tra-sua.jpg', 210, '2023-10-04 09:15:00', '500ml', 'Hồng trà thượng hạng, sữa tươi, trân châu đen'),
(5, 1, 'Nem chua rán Hà Nội', 35000, 5, 'Việt Nam', '2026-03-15', '3 ngày', 'images/nem-chua.jpg', 150, '2026-03-15 16:00:00', '300g', 'Thịt lợn, bì lợn sạch, thính, bột chiên xù'),
(6, 1, 'Xúc xích phô mai đút lò', 25000, 0, 'Việt Nam', '2026-03-15', 'Trong ngày', 'images/xuc-xich.jpg', 120, '2026-03-15 16:05:00', '200g', 'Xúc xích Đức, phô mai Mozzarella kéo sợi'),
(7, 2, 'Sữa chua trân châu cốt dừa', 28000, 10, 'Việt Nam', '2026-03-15', 'Trong ngày', 'images/sua-chua.jpg', 200, '2026-03-15 16:10:00', '400ml', 'Sữa chua nhà làm, cốt dừa béo ngậy, trân châu'),
(8, 1, 'Da heo mắm hành giòn rụm', 35000, 0, 'Việt Nam', '2026-03-15', '3 tháng', 'images/da-heo.jpg', 310, '2026-03-15 16:15:00', '250g', 'Da heo sấy giòn, nước mắm nhĩ, hành lá, ớt'),
(9, 3, 'Khô bò', 50000, 0, 'Việt Nam', '2026-03-17', '5 tháng', 'images/kho-bo', 78, '2026-03-17 02:06:59', '200', 'Bò tươi, tỏi,...'),
(10, 4, 'Nước cam', 10000, 0, 'Việt Nam', '2026-03-17', '12', 'images/knuoc-cam', 87, '2026-03-17 02:12:59', '200', 'Cam tươi, đường,...');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanphamyeuthich`
--

CREATE TABLE `sanphamyeuthich` (
  `user_id` int(11) NOT NULL,
  `masp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanhvien`
--

CREATE TABLE `thanhvien` (
  `id` int(11) NOT NULL,
  `ten` varchar(100) NOT NULL,
  `tentaikhoan` varchar(50) NOT NULL,
  `matkhau` varchar(255) NOT NULL,
  `diachi` varchar(255) NOT NULL,
  `sodt` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `quyen` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thanhvien`
--

INSERT INTO `thanhvien` (`id`, `ten`, `tentaikhoan`, `matkhau`, `diachi`, `sodt`, `email`, `date`, `quyen`) VALUES
(1, 'Quản Trị Viên', 'admin', '123456', 'Hà Nội', '0987654321', 'admin@anvat.com', '2023-10-01 00:00:00', 1),
(2, 'Khách Hàng', 'khachhang1', '123456', 'Hồ Chí Minh', '0123456789', 'khach@anvat.com', '2023-10-05 08:00:00', 0),
(3, 'Lê Thanh Tùng', 'tung123', '123456', '206 Phương Canh', '0908070605', 'lethanhtungdb01@gmail.com', '2026-03-15 01:22:46', 0),
(4, 'admin1', 'admin1', '123456', '', '', '', '0000-00-00 00:00:00', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitietgd`
--
ALTER TABLE `chitietgd`
  ADD PRIMARY KEY (`magd`,`masp`);

--
-- Chỉ mục cho bảng `danhmucsp`
--
ALTER TABLE `danhmucsp`
  ADD PRIMARY KEY (`madm`);

--
-- Chỉ mục cho bảng `giaodich`
--
ALTER TABLE `giaodich`
  ADD PRIMARY KEY (`magd`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`user_id`,`masp`),
  ADD KEY `masp` (`masp`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`masp`),
  ADD KEY `madm` (`madm`);

--
-- Chỉ mục cho bảng `sanphamyeuthich`
--
ALTER TABLE `sanphamyeuthich`
  ADD PRIMARY KEY (`user_id`,`masp`),
  ADD KEY `masp` (`masp`);

--
-- Chỉ mục cho bảng `thanhvien`
--
ALTER TABLE `thanhvien`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `danhmucsp`
--
ALTER TABLE `danhmucsp`
  MODIFY `madm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `giaodich`
--
ALTER TABLE `giaodich`
  MODIFY `magd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `masp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `thanhvien`
--
ALTER TABLE `thanhvien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `fk_giohang_sanpham` FOREIGN KEY (`masp`) REFERENCES `sanpham` (`masp`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_giohang_user` FOREIGN KEY (`user_id`) REFERENCES `thanhvien` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `fk_sanpham_danhmuc` FOREIGN KEY (`madm`) REFERENCES `danhmucsp` (`madm`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `sanphamyeuthich`
--
ALTER TABLE `sanphamyeuthich`
  ADD CONSTRAINT `fk_sptym_sanpham` FOREIGN KEY (`masp`) REFERENCES `sanpham` (`masp`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_sptym_user` FOREIGN KEY (`user_id`) REFERENCES `thanhvien` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
