-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2017 at 03:11 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_kasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kode_barang` char(13) NOT NULL,
  `id_jenis_barang` char(4) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_merek` int(11) DEFAULT NULL,
  `id_kepemilikan` int(11) NOT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `stok_barang` int(11) DEFAULT NULL,
  `harga_barang` float DEFAULT NULL,
  `limit_stok` int(11) DEFAULT NULL,
  `status_barcode_awal` int(1) NOT NULL DEFAULT '0' COMMENT '0=belum ada, 1=sudah ada'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kode_barang`, `id_jenis_barang`, `id_user`, `id_merek`, `id_kepemilikan`, `nama_barang`, `stok_barang`, `harga_barang`, `limit_stok`, `status_barcode_awal`) VALUES
('80391912', '1001', 2, 3, 3, 'Asdasdsadasdasd', 20, 7000, 20, 1),
('891829182198', '1001', 2, 3, 1, 'Jumbo', 200, 51000, 10, 1),
('8991001000019', '1001', 2, 3, 1, 'Sabun Nuvo', 200, 4000, 10, 0),
('8991001000026', '1001', 2, 3, 1, 'Sabun Lux', 100, 3500, 10, 0),
('8991001000033', '1001', 2, 3, 1, 'Test', 12, 3000, 12, 0),
('8991001000040', '1001', 2, 3, 1, 'Asdasdad', 23, 6000, 21, 0),
('8991001000057', '1001', 2, 3, 1, 'Asdasda', 23, 2000, 23, 0),
('8991001000064', '1001', 2, 3, 1, 'Testt', 20, 2000, 20, 0),
('8991001000071', '1001', 2, 3, 1, 'Sabu Colek', 200, 20000, 20, 0),
('8991001000088', '1001', 2, 3, 1, 'Testttttt', 12, 20000, 12, 0),
('8991001000095', '1001', 2, 3, 3, 'Sabun Lx', 20, 10000, 10, 0),
('8991001000101', '1001', 2, 3, 3, 'Asdadasdasd', 2, 10000, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `detil_pembelian`
--

CREATE TABLE `detil_pembelian` (
  `id_pembelian` char(10) NOT NULL,
  `kode_barang` char(13) NOT NULL,
  `jumlah_beli` int(11) DEFAULT NULL,
  `harga_beli` float DEFAULT NULL,
  `id_satuan_barang` int(11) DEFAULT NULL,
  `jumlah_persatuan` int(11) DEFAULT NULL,
  `laba` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detil_pembelian`
--

INSERT INTO `detil_pembelian` (`id_pembelian`, `kode_barang`, `jumlah_beli`, `harga_beli`, `id_satuan_barang`, `jumlah_persatuan`, `laba`) VALUES
('TB17120001', '80391912', 1, 60000, 1, 12, 5);

-- --------------------------------------------------------

--
-- Table structure for table `detil_penjualan`
--

CREATE TABLE `detil_penjualan` (
  `id_penjualan` char(10) NOT NULL,
  `kode_barang` char(13) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `potongan_per_barang` float DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detil_penjualan`
--

INSERT INTO `detil_penjualan` (`id_penjualan`, `kode_barang`, `jumlah`, `harga`, `potongan_per_barang`) VALUES
('TJ17120001', '8991001000101', 1, 10000, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id_jenis_barang` char(4) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `nama_jenis_barang` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_barang`
--

INSERT INTO `jenis_barang` (`id_jenis_barang`, `id_kategori`, `nama_jenis_barang`) VALUES
('1001', 9, 'Sabun'),
('1002', 10, 'Penggorengan');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(2, 'Sembako'),
(9, 'Alat Mandi'),
(10, 'Perabotan');

-- --------------------------------------------------------

--
-- Table structure for table `kedudukan`
--

CREATE TABLE `kedudukan` (
  `id_kedudukan` int(11) NOT NULL,
  `nama_kedudukan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kedudukan`
--

INSERT INTO `kedudukan` (`id_kedudukan`, `nama_kedudukan`) VALUES
(28, 'Administrator'),
(29, 'Kasir'),
(30, 'Owner');

-- --------------------------------------------------------

--
-- Table structure for table `kepemilikan_barang`
--

CREATE TABLE `kepemilikan_barang` (
  `id_kepemilikan` int(1) NOT NULL,
  `nama_pemilik` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kepemilikan_barang`
--

INSERT INTO `kepemilikan_barang` (`id_kepemilikan`, `nama_pemilik`) VALUES
(1, 'Bapak Joko'),
(3, 'Susilo');

-- --------------------------------------------------------

--
-- Table structure for table `merek`
--

CREATE TABLE `merek` (
  `id_merek` int(11) NOT NULL,
  `nama_merek` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `merek`
--

INSERT INTO `merek` (`id_merek`, `nama_merek`) VALUES
(2, 'Indofood'),
(3, 'NUVO');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(60) DEFAULT NULL,
  `telpon_pelanggan` varchar(15) DEFAULT NULL,
  `alamat_pelanggan` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('P','W') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `telpon_pelanggan`, `alamat_pelanggan`, `jenis_kelamin`) VALUES
(1, 'aaaaa', '089333', 'asdasdsa', 'P'),
(2, 'Test', '08291829122', 'asdasdsad', 'P'),
(3, 'Asdadas', '12312323232', 'asdasdsa', 'P');

-- --------------------------------------------------------

--
-- Table structure for table `pemasok`
--

CREATE TABLE `pemasok` (
  `id_pemasok` int(11) NOT NULL,
  `nama_pemasok` varchar(100) DEFAULT NULL,
  `alamat_pemasok` varchar(150) DEFAULT NULL,
  `telpon_pemasok` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemasok`
--

INSERT INTO `pemasok` (`id_pemasok`, `nama_pemasok`, `alamat_pemasok`, `telpon_pemasok`) VALUES
(5, 'Test Pemasok', 'Jalan Sidoarjo', '0892819282912'),
(6, 'Test Pemasok 2', 'jalan surabaya', '0291829212');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` char(10) NOT NULL,
  `id_pemasok` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tanggal_pembelian` datetime DEFAULT NULL,
  `total_pembelian` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `id_pemasok`, `id_user`, `tanggal_pembelian`, `total_pembelian`) VALUES
('TB17120001', 6, 2, '2017-12-23 08:43:26', 60000),
('TB17120002', 6, 2, '2017-12-23 09:03:35', 120000);

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` int(11) NOT NULL,
  `jenis_pengeluaran` varchar(255) DEFAULT NULL,
  `keterangan` text,
  `tanggal` date DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nominal` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengeluaran`
--

INSERT INTO `pengeluaran` (`id_pengeluaran`, `jenis_pengeluaran`, `keterangan`, `tanggal`, `id_user`, `nominal`) VALUES
(1, 'Pembayaran Listrik', 'Pembayaran listrik', '2017-06-14', 2, 150000),
(2, 'Pembayaran Air', 'Pembayaran air', '2017-07-20', 2, 200000),
(4, 'Asdasd', 'asdasdadas', '2017-07-10', 2, 150000),
(5, 'Asdas', 'dasdasd', '2017-08-20', 2, 150000),
(6, 'Test Pengeluaran', 'test pengeluaran', '2017-06-28', 2, 125003);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` char(10) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tanggal_penjualan` datetime DEFAULT NULL,
  `total` float DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL COMMENT 'dalam persen',
  `bayar` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_pelanggan`, `id_user`, `tanggal_penjualan`, `total`, `diskon`, `bayar`) VALUES
('TJ17120001', 3, 2, '2017-12-05 07:10:16', 8100, 10, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `saldo_awal`
--

CREATE TABLE `saldo_awal` (
  `id_saldo_awal` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `saldo_awal_nominal` float NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saldo_awal`
--

INSERT INTO `saldo_awal` (`id_saldo_awal`, `tanggal`, `saldo_awal_nominal`, `id_user`) VALUES
(2, '2017-07-22', 200000, 3),
(4, '2017-07-23', 15000, 3),
(7, '2017-07-29', 100000, 3);

-- --------------------------------------------------------

--
-- Table structure for table `satuan_barang`
--

CREATE TABLE `satuan_barang` (
  `id_satuan_barang` int(11) NOT NULL,
  `nama_satuan_barang` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `satuan_barang`
--

INSERT INTO `satuan_barang` (`id_satuan_barang`, `nama_satuan_barang`) VALUES
(1, 'Kotak'),
(3, 'Kg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `id_kedudukan` int(11) DEFAULT NULL,
  `status` enum('A','T') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `username`, `password`, `id_kedudukan`, `status`) VALUES
(2, 'Administrator', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 28, 'A'),
(3, 'Muhammad', 'kasir', 'e10adc3949ba59abbe56e057f20f883e', 29, 'A'),
(4, 'Owner', 'owner', 'e10adc3949ba59abbe56e057f20f883e', 30, 'A'),
(5, 'Joko', 'kasir1', 'e10adc3949ba59abbe56e057f20f883e', 29, 'A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode_barang`),
  ADD KEY `barang_ibfk_2` (`id_user`),
  ADD KEY `barang_ibfk_3` (`id_merek`),
  ADD KEY `baran_ibfk_1` (`id_jenis_barang`);

--
-- Indexes for table `detil_pembelian`
--
ALTER TABLE `detil_pembelian`
  ADD PRIMARY KEY (`id_pembelian`,`kode_barang`),
  ADD KEY `detil_pembelian_ibfk_2` (`kode_barang`),
  ADD KEY `idx_satuan` (`id_satuan_barang`);

--
-- Indexes for table `detil_penjualan`
--
ALTER TABLE `detil_penjualan`
  ADD PRIMARY KEY (`id_penjualan`,`kode_barang`),
  ADD KEY `detil_penjualan_ibfk_2` (`kode_barang`);

--
-- Indexes for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id_jenis_barang`),
  ADD KEY `jenis_barang_ibfk_1` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kedudukan`
--
ALTER TABLE `kedudukan`
  ADD PRIMARY KEY (`id_kedudukan`);

--
-- Indexes for table `kepemilikan_barang`
--
ALTER TABLE `kepemilikan_barang`
  ADD PRIMARY KEY (`id_kepemilikan`);

--
-- Indexes for table `merek`
--
ALTER TABLE `merek`
  ADD PRIMARY KEY (`id_merek`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pemasok`
--
ALTER TABLE `pemasok`
  ADD PRIMARY KEY (`id_pemasok`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `id_pemasok` (`id_pemasok`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`),
  ADD KEY `pengeluaran_ibfk_1` (`id_user`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `penjualan_ibfk_1` (`id_pelanggan`),
  ADD KEY `penjualan_ibfk_2` (`id_user`) USING BTREE;

--
-- Indexes for table `saldo_awal`
--
ALTER TABLE `saldo_awal`
  ADD PRIMARY KEY (`id_saldo_awal`),
  ADD KEY `idx_user_id1` (`id_user`);

--
-- Indexes for table `satuan_barang`
--
ALTER TABLE `satuan_barang`
  ADD PRIMARY KEY (`id_satuan_barang`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `pegawai_ibfk_1` (`id_kedudukan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `kedudukan`
--
ALTER TABLE `kedudukan`
  MODIFY `id_kedudukan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `kepemilikan_barang`
--
ALTER TABLE `kepemilikan_barang`
  MODIFY `id_kepemilikan` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `merek`
--
ALTER TABLE `merek`
  MODIFY `id_merek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pemasok`
--
ALTER TABLE `pemasok`
  MODIFY `id_pemasok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `saldo_awal`
--
ALTER TABLE `saldo_awal`
  MODIFY `id_saldo_awal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `satuan_barang`
--
ALTER TABLE `satuan_barang`
  MODIFY `id_satuan_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `baran_ibfk_1` FOREIGN KEY (`id_jenis_barang`) REFERENCES `jenis_barang` (`id_jenis_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_ibfk_3` FOREIGN KEY (`id_merek`) REFERENCES `merek` (`id_merek`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detil_pembelian`
--
ALTER TABLE `detil_pembelian`
  ADD CONSTRAINT `detil_pembelian_ibfk_2` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pembelian_112` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_satuan_barang` FOREIGN KEY (`id_satuan_barang`) REFERENCES `satuan_barang` (`id_satuan_barang`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `detil_penjualan`
--
ALTER TABLE `detil_penjualan`
  ADD CONSTRAINT `detil_penjualan_ibfk_2` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_penjualan_11` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD CONSTRAINT `jenis_barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`id_pemasok`) REFERENCES `pemasok` (`id_pemasok`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembelian_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD CONSTRAINT `pengeluaran_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `saldo_awal`
--
ALTER TABLE `saldo_awal`
  ADD CONSTRAINT `fk_saldo_awal` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_kedudukan`) REFERENCES `kedudukan` (`id_kedudukan`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
