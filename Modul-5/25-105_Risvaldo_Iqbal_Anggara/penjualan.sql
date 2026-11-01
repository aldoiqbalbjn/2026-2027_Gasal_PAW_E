CREATE DATABASE IF NOT EXISTS db_penjualan;
USE db_penjualan;

DROP TABLE IF EXISTS pembayaran;
DROP TABLE IF EXISTS transaksi_detail;
DROP TABLE IF EXISTS transaksi;
DROP TABLE IF EXISTS barang;
DROP TABLE IF EXISTS supplier;
DROP TABLE IF EXISTS pelanggan;
DROP TABLE IF EXISTS user;

CREATE TABLE pelanggan (
    id VARCHAR(20) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L','P') NOT NULL,
    telp VARCHAR(12),
    alamat TEXT,
    PRIMARY KEY (id)
);

CREATE TABLE supplier (
    id INT NOT NULL AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    telp VARCHAR(12),
    alamat TEXT,
    PRIMARY KEY (id)
);

CREATE TABLE barang (
    id INT NOT NULL AUTO_INCREMENT,
    kode_barang VARCHAR(10) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL,
    supplier_id INT NOT NULL,
    PRIMARY KEY (id),
    INDEX idx_supplier_id (supplier_id),
    CONSTRAINT fk_barang_supplier
        FOREIGN KEY (supplier_id)
        REFERENCES supplier(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE user (
    id_user TINYINT(2) NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(35) NOT NULL,
    nama VARCHAR(50) NOT NULL,
    alamat VARCHAR(150),
    hp VARCHAR(20),
    level TINYINT(1),
    PRIMARY KEY (id_user)
);

CREATE TABLE transaksi (
    id INT NOT NULL AUTO_INCREMENT,
    waktu_transaksi DATE NOT NULL,
    keterangan TEXT,
    total INT NOT NULL,
    pelanggan_id VARCHAR(20) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
);

CREATE TABLE transaksi_detail (
    transaksi_id INT NOT NULL,
    barang_id INT NOT NULL,
    harga INT NOT NULL,
    qty INT NOT NULL,
    PRIMARY KEY (transaksi_id, barang_id),
    INDEX idx_barang_id (barang_id),
    CONSTRAINT fk_detail_transaksi
        FOREIGN KEY (transaksi_id)
        REFERENCES transaksi(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_detail_barang
        FOREIGN KEY (barang_id)
        REFERENCES barang(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE pembayaran (
    id INT NOT NULL AUTO_INCREMENT,
    waktu_bayar DATETIME NOT NULL,
    total INT NOT NULL,
    metode ENUM('TUNAI','TRANSFER','EDC') NOT NULL,
    transaksi_id INT NOT NULL,
    PRIMARY KEY (id),
    INDEX idx_pembayaran_transaksi (transaksi_id),
    CONSTRAINT fk_pembayaran_transaksi
        FOREIGN KEY (transaksi_id)
        REFERENCES transaksi(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

INSERT INTO pelanggan
(id, nama, jenis_kelamin, telp, alamat)
VALUES
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

INSERT INTO supplier
(nama, telp, alamat)
VALUES
('PT Sumber Makmur', '081111111101', 'Surabaya'),
('CV Jaya Abadi', '081111111102', 'Sidoarjo'),
('PT Maju Bersama', '081111111103', 'Gresik'),
('CV Berkah Sentosa', '081111111104', 'Malang'),
('PT Sejahtera', '081111111105', 'Mojokerto'),
('CV Sinar Jaya', '081111111106', 'Surabaya'),
('PT Mitra Usaha', '081111111107', 'Pasuruan'),
('CV Lancar Jaya', '081111111108', 'Lamongan'),
('PT Indo Makmur', '081111111109', 'Surabaya'),
('CV Nusantara', '081111111110', 'Sidoarjo');

INSERT INTO barang
(kode_barang, nama_barang, harga, stok, supplier_id)
VALUES
('BRG001', 'Keyboard', 150000, 20, 1),
('BRG002', 'Mouse', 75000, 30, 2),
('BRG003', 'Monitor 24 Inch', 1800000, 10, 3),
('BRG004', 'Flashdisk 32GB', 80000, 25, 4),
('BRG005', 'Headset', 125000, 15, 5),
('BRG006', 'Webcam', 250000, 12, 6),
('BRG007', 'Mousepad', 40000, 40, 7),
('BRG008', 'Kabel HDMI', 60000, 20, 8),
('BRG009', 'Speaker', 200000, 10, 9),
('BRG010', 'USB Hub', 90000, 18, 10);

INSERT INTO `user`
(username, password, nama, alamat, hp, level)
VALUES
('admin01', 'admin123', 'Admin Satu', 'Surabaya', '082111111101', 1),
('admin02', 'admin123', 'Admin Dua', 'Sidoarjo', '082111111102', 1),
('kasir01', 'kasir123', 'Kasir Satu', 'Surabaya', '082111111103', 2),
('kasir02', 'kasir123', 'Kasir Dua', 'Gresik', '082111111104', 2),
('kasir03', 'kasir123', 'Kasir Tiga', 'Malang', '082111111105', 2),
('user01', 'user123', 'User Satu', 'Surabaya', '082111111106', 3),
('user02', 'user123', 'User Dua', 'Sidoarjo', '082111111107', 3),
('user03', 'user123', 'User Tiga', 'Mojokerto', '082111111108', 3),
('user04', 'user123', 'User Empat', 'Gresik', '082111111109', 3),
('user05', 'user123', 'User Lima', 'Surabaya', '082111111110', 3);

INSERT INTO transaksi
(waktu_transaksi, keterangan, total, pelanggan_id)
VALUES
('2026-10-01', 'Pembelian keyboard', 150000, 'PLG001'),
('2026-10-02', 'Pembelian mouse', 75000, 'PLG002'),
('2026-10-03', 'Pembelian monitor', 1800000, 'PLG003'),
('2026-10-04', 'Pembelian flashdisk', 80000, 'PLG004'),
('2026-10-05', 'Pembelian headset', 125000, 'PLG005'),
('2026-10-06', 'Pembelian webcam', 250000, 'PLG006'),
('2026-10-07', 'Pembelian mousepad', 40000, 'PLG007'),
('2026-10-08', 'Pembelian kabel HDMI', 60000, 'PLG008'),
('2026-10-09', 'Pembelian speaker', 200000, 'PLG009'),
('2026-10-10', 'Pembelian USB Hub', 90000, 'PLG010');

INSERT INTO transaksi_detail
(transaksi_id, barang_id, harga, qty)
VALUES
(1, 1, 150000, 1),
(2, 2, 75000, 1),
(3, 3, 1800000, 1),
(4, 4, 80000, 1),
(5, 5, 125000, 1),
(6, 6, 250000, 1),
(7, 7, 40000, 1),
(8, 8, 60000, 1),
(9, 9, 200000, 1),
(10, 10, 90000, 1);

INSERT INTO pembayaran
(waktu_bayar, total, metode, transaksi_id)
VALUES
('2026-10-01 10:00:00', 150000, 'TUNAI', 1),
('2026-10-02 10:15:00', 75000, 'TRANSFER', 2),
('2026-10-03 11:00:00', 1800000, 'EDC', 3),
('2026-10-04 11:30:00', 80000, 'TUNAI', 4),
('2026-10-05 12:00:00', 125000, 'TRANSFER', 5),
('2026-10-06 13:00:00', 250000, 'EDC', 6),
('2026-10-07 13:30:00', 40000, 'TUNAI', 7),
('2026-10-08 14:00:00', 60000, 'TRANSFER', 8),
('2026-10-09 15:00:00', 200000, 'EDC', 9),
('2026-10-10 16:00:00', 90000, 'TUNAI', 10);