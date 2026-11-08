-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 08, 2026 at 04:17 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjualan`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga` int NOT NULL,
  `stok` int NOT NULL,
  `supplier_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`, `supplier_id`) VALUES
(2, 'BRG002', 'Mouse', 75000, 30, 2),
(3, 'BRG003', 'Monitor 24 Inch', 1800000, 10, 3),
(4, 'BRG004', 'Flashdisk 32GB', 80000, 25, 4),
(5, 'BRG005', 'Headset', 125000, 15, 5),
(6, 'BRG006', 'Webcam', 250000, 12, 6),
(7, 'BRG007', 'Mousepad', 40000, 40, 7),
(8, 'BRG008', 'Kabel HDMI', 60000, 20, 8),
(9, 'BRG009', 'Speaker', 200000, 10, 9),
(10, 'BRG010', 'USB Hub', 90000, 18, 10);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
('PLG001', 'Andi Saputra', 'L', '081234567801', 'Surabaya'),
('PLG002', 'Budi Santoso', 'L', '081234567802', 'Sidoarjo'),
('PLG003', 'Citra Lestari', 'P', '081234567803', 'Malang'),
('PLG004', 'Dewi Anggraini', 'P', '081234567804', 'Surabaya'),
('PLG005', 'Eko Prasetyo', 'L', '081234567805', 'Gresik'),
('PLG006', 'Fajar Ramadhan', 'L', '081234567806', 'Mojokerto'),
('PLG007', 'Gina Maharani', 'P', '081234567807', 'Surabaya'),
('PLG008', 'Hana Putri', 'P', '081234567808', 'Sidoarjo'),
('PLG009', 'Ilham Maulana', 'L', '081234567809', 'Lamongan'),
('PLG010', 'Jihan Permata', 'P', '081234567810', 'Surabaya');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int NOT NULL,
  `waktu_bayar` datetime NOT NULL,
  `total` int NOT NULL,
  `metode` enum('TUNAI','TRANSFER','EDC') NOT NULL,
  `transaksi_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `waktu_bayar`, `total`, `metode`, `transaksi_id`) VALUES
(1, '2026-10-01 10:00:00', 150000, 'TUNAI', 1),
(2, '2026-10-02 10:15:00', 75000, 'TRANSFER', 2),
(3, '2026-10-03 11:00:00', 1800000, 'EDC', 3),
(4, '2026-10-04 11:30:00', 80000, 'TUNAI', 4),
(5, '2026-10-05 12:00:00', 125000, 'TRANSFER', 5),
(6, '2026-10-06 13:00:00', 250000, 'EDC', 6),
(7, '2026-10-07 13:30:00', 40000, 'TUNAI', 7),
(8, '2026-10-08 14:00:00', 60000, 'TRANSFER', 8),
(9, '2026-10-09 15:00:00', 200000, 'EDC', 9),
(10, '2026-10-10 16:00:00', 90000, 'TUNAI', 10);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(2, 'CV Jaya Abadi', '081111111102', 'Sidoarjo'),
(3, 'PT Maju Bersama', '081111111103', 'Gresik'),
(4, 'CV Berkah Sentosa', '081111111104', 'Malang'),
(5, 'PT Sejahtera', '081111111105', 'Mojokerto'),
(6, 'CV Sinar Jaya', '081111111106', 'Surabaya'),
(7, 'PT Mitra Usaha', '081111111107', 'Pasuruan'),
(8, 'CV Lancar Jaya', '081111111108', 'Lamongan'),
(9, 'PT Indo Makmur', '081111111109', 'Surabaya'),
(10, 'CV Nusantara', '081111111110', 'Sidoarjo');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `waktu_transaksi` date NOT NULL,
  `keterangan` text,
  `total` int NOT NULL,
  `pelanggan_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2026-10-01', 'Pembelian keyboard', 150000, 'PLG001'),
(2, '2026-10-02', 'Pembelian mouse', 700000, 'PLG002'),
(3, '2026-10-03', 'Pembelian monitor', 1800000, 'PLG003'),
(4, '2026-10-04', 'Pembelian flashdisk', 140000, 'PLG004'),
(5, '2026-10-05', 'Pembelian headset', 200000, 'PLG005'),
(6, '2026-10-06', 'Pembelian webcam', 250000, 'PLG006'),
(7, '2026-10-07', 'Pembelian mousepad', 40000, 'PLG007'),
(8, '2026-10-08', 'Pembelian kabel HDMI', 60000, 'PLG008'),
(9, '2026-10-09', 'Pembelian speaker', 200000, 'PLG009'),
(10, '2026-10-10', 'Pembelian USB Hub', 90000, 'PLG010'),
(11, '2026-11-07', 'Pembelian keyboard', 150000, 'PLG002'),
(12, '2026-11-07', 'Pembelian keyboard', 150000, 'PLG005'),
(13, '2026-11-07', 'pembelian', 0, 'PLG001');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `transaksi_id` int NOT NULL,
  `barang_id` int NOT NULL,
  `harga` int NOT NULL,
  `qty` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
(2, 2, 75000, 1),
(2, 5, 125000, 1),
(2, 6, 250000, 2),
(3, 3, 1800000, 1),
(4, 4, 80000, 1),
(4, 8, 60000, 1),
(5, 2, 75000, 1),
(5, 5, 125000, 1),
(6, 6, 250000, 1),
(7, 7, 40000, 1),
(8, 8, 60000, 1),
(9, 9, 200000, 1),
(10, 10, 90000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` tinyint NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `alamat`, `hp`, `level`) VALUES
(1, 'admin01', 'admin123', 'Admin Satu', 'Surabaya', '082111111101', 1),
(2, 'admin02', 'admin123', 'Admin Dua', 'Sidoarjo', '082111111102', 1),
(3, 'kasir01', 'kasir123', 'Kasir Satu', 'Surabaya', '082111111103', 2),
(4, 'kasir02', 'kasir123', 'Kasir Dua', 'Gresik', '082111111104', 2),
(5, 'kasir03', 'kasir123', 'Kasir Tiga', 'Malang', '082111111105', 2),
(6, 'user01', 'user123', 'User Satu', 'Surabaya', '082111111106', 3),
(7, 'user02', 'user123', 'User Dua', 'Sidoarjo', '082111111107', 3),
(8, 'user03', 'user123', 'User Tiga', 'Mojokerto', '082111111108', 3),
(9, 'user04', 'user123', 'User Empat', 'Gresik', '082111111109', 3),
(10, 'user05', 'user123', 'User Lima', 'Surabaya', '082111111110', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_supplier_id` (`supplier_id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pembayaran_transaksi` (`transaksi_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`transaksi_id`,`barang_id`),
  ADD KEY `idx_barang_id` (`barang_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `fk_barang_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pembayaran_transaksi` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`);

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `fk_detail_barang` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_transaksi` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
