-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2017 at 10:06 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_kantor24db`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kd_barang` char(5) NOT NULL,
  `nm_barang` varchar(100) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `merek` varchar(100) NOT NULL,
  `tipe` varchar(100) NOT NULL,
  `jumlah` int(6) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `kd_kategori` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kd_barang`, `nm_barang`, `keterangan`, `merek`, `tipe`, `jumlah`, `satuan`, `kd_kategori`) VALUES
('B0001', 'TOSHIBA Satellite C800D-1003 - Black ', 'Notebook / Laptop 13 inch - 14 inch AMD Dual Core E1-1200, 2GB DDR3, 320GB HDD, DVD±RW, WiFi, Bluetooth, VGA AMD Radeon HD 7000 Series, Camera, 14', 'TOSHIBA', 'SS', 2, 'Unit', 'K002'),
('B0002', 'TOSHIBA Satellite C40-A106 - Black', 'Notebook / Laptop 13 inch - 14 inch Intel Core i3-2348M, 2GB DDR3, 500GB HDD, DVD±RW, WiFi, Bluetooth, VGA Intel HD Graphics, Camera, 14', 'TOSHIBA', '', 3, 'Unit', 'K002'),
('B0003', 'Printer Canon LBP 5100 Laser Jet', 'Canon LBP 5100 Laser Jet', 'Canon', '', 2, 'Unit', 'K003'),
('B0004', 'Printer Canon IP 2770', 'Canon IP 2770', 'Canon', '', 6, 'Unit', 'K003'),
('B0005', 'Printer Brother Colour Laser HL-2150N Mono', 'Brother Colour Laser HL-2150N Mono Laser Printer, Networking', 'Brother', '', 4, 'Unit', 'K003'),
('B0006', 'UPS Prolink Pro 700', 'Prolink Pro 700', 'Prolink', '', 2, 'Unit', 'K004'),
('B0007', 'UPS Prolink IPS 500i Inverter 500VA', 'Prolink IPS 500i Inverter 500VA', 'Prolink', '', 7, 'Unit', 'K004'),
('B0008', 'Meja Komputer Crystal Grace 101', 'Crystal Grace 101 (100x45x70)', 'Crystal Grace', '', 7, 'Unit', 'K005'),
('B0009', 'Komputer Kantor - Paket 1', 'Motherboard PCP+ 790Gx Baby Raptor\r\nProcessor AMD Athlon II 64 X2 250\r\nMemory 1 GB DDR2 PC6400 800 MHz\r\nHarddisk WDC 320 GB Sata\r\nDVD±RW/RAM 24x Sata\r\nKeyboard + Mouse SPC\r\nCasing Libera Series 500 Wa', 'Rakitan', '', 12, 'Unit', 'K001'),
('B0010', 'Komputer Kantor - Paket 2', 'Dual Core (2.6 Ghz) TRAY\r\nMainboard ASUS P5 KPL AM-SE ( Astrindo )\r\nMemory DDR2 V-gen 2 Gb PC 5300\r\nHarddisk 250 Gb Seagate/WDC/Maxtor SATA\r\nKeyboard + Mouse Logitech\r\nCasing SPC 350w + 1 FAN CPU\r\nLCD', 'Rakitan', 'sss', 5, 'Unit', 'K001'),
('B0011', 'LCD LG 19 Inch', 'LG 19 Inch L1942S (Square)', 'LG', '', 7, 'Unit', 'K006');

-- --------------------------------------------------------

--
-- Table structure for table `barang_inventaris`
--

CREATE TABLE `barang_inventaris` (
  `kd_inventaris` char(12) NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `no_pengadaan` char(7) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `tahun_datang` varchar(4) NOT NULL,
  `tahun_digunakan` varchar(4) NOT NULL,
  `nomor_seri` varchar(30) NOT NULL,
  `masa_habis_kalibrasi` varchar(10) NOT NULL,
  `no_sertifikat_kalibrasi` varchar(30) NOT NULL,
  `pembuat_sertifikat` varchar(100) NOT NULL,
  `asal_barang` varchar(100) NOT NULL,
  `harga_barang` int(12) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `status_barang` enum('Tersedia','Ditempatkan','Dipinjam') NOT NULL DEFAULT 'Tersedia'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_inventaris`
--

INSERT INTO `barang_inventaris` (`kd_inventaris`, `kd_barang`, `no_pengadaan`, `tgl_masuk`, `tahun_datang`, `tahun_digunakan`, `nomor_seri`, `masa_habis_kalibrasi`, `no_sertifikat_kalibrasi`, `pembuat_sertifikat`, `asal_barang`, `harga_barang`, `keterangan`, `status_barang`) VALUES
('B0001.000001', 'B0001', 'BB00002', '2015-08-06', '2016', '2017', '435345345435', '12/11/2019', '34343434', 'Soho', 'Solo', 3500000, 'Oke banged', 'Ditempatkan'),
('B0001.000002', 'B0001', 'BB00002', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0002.000003', 'B0002', 'BB00002', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Ditempatkan'),
('B0002.000004', 'B0002', 'BB00002', '2015-08-06', '2016', '2016', '343434343', '2020', '34343432323', 'POM RI', 'Semarang', 5000000, 'Barang jaminan spesial', 'Ditempatkan'),
('B0002.000005', 'B0002', 'BB00002', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0003.000006', 'B0003', 'BB00003', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0003.000007', 'B0003', 'BB00003', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0004.000008', 'B0004', 'BB00003', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Ditempatkan'),
('B0004.000009', 'B0004', 'BB00003', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Ditempatkan'),
('B0004.000010', 'B0004', 'BB00003', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Ditempatkan'),
('B0004.000011', 'B0004', 'BB00003', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0004.000012', 'B0004', 'BB00003', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0004.000013', 'B0004', 'BB00003', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0005.000014', 'B0005', 'BB00003', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0005.000015', 'B0005', 'BB00003', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0005.000016', 'B0005', 'BB00003', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0005.000017', 'B0005', 'BB00003', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0006.000018', 'B0006', 'BB00004', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0006.000019', 'B0006', 'BB00004', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0007.000020', 'B0007', 'BB00004', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Ditempatkan'),
('B0007.000021', 'B0007', 'BB00004', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0007.000022', 'B0007', 'BB00004', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0007.000023', 'B0007', 'BB00004', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0007.000024', 'B0007', 'BB00004', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0007.000025', 'B0007', 'BB00004', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0007.000026', 'B0007', 'BB00004', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0008.000027', 'B0008', 'BB00005', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Ditempatkan'),
('B0008.000028', 'B0008', 'BB00005', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0008.000029', 'B0008', 'BB00005', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0008.000030', 'B0008', 'BB00005', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0008.000031', 'B0008', 'BB00005', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0008.000032', 'B0008', 'BB00005', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0008.000033', 'B0008', 'BB00005', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0009.000034', 'B0009', 'BB00001', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Ditempatkan'),
('B0009.000035', 'B0009', 'BB00001', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0009.000036', 'B0009', 'BB00001', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0009.000037', 'B0009', 'BB00001', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0010.000038', 'B0010', 'BB00001', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0010.000039', 'B0010', 'BB00001', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0011.000040', 'B0011', 'BB00006', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0011.000041', 'B0011', 'BB00006', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0011.000042', 'B0011', 'BB00006', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0011.000043', 'B0011', 'BB00006', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0011.000044', 'B0011', 'BB00006', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0011.000045', 'B0011', 'BB00006', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0011.000046', 'B0011', 'BB00006', '2015-08-06', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0009.000049', 'B0009', 'BB00007', '2016-07-28', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0009.000048', 'B0009', 'BB00007', '2016-07-28', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0009.000047', 'B0009', 'BB00007', '2016-07-28', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0009.000050', 'B0009', 'BB00007', '2016-07-28', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0009.000051', 'B0009', 'BB00007', '2016-07-28', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0010.000052', 'B0010', 'BB00008', '2016-07-28', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0010.000053', 'B0010', 'BB00008', '2016-07-28', '', '', '', '', '', '', '', 0, '', 'Tersedia'),
('B0010.000054', 'B0010', 'BB00008', '2016-07-28', '', '', '', '', '', '', '', 0, '', 'Tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `kd_departemen` char(4) NOT NULL,
  `nm_departemen` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`kd_departemen`, `nm_departemen`, `keterangan`) VALUES
('D001', 'Prodi TI', 'Teknik Informatika'),
('D002', 'Prodi SI', 'Sistem Informasi'),
('D003', 'Prodi MI', 'Manajemen Informatika'),
('D004', 'Prodi KA', 'Komputer Akuntansi'),
('D005', 'Prodi TK', 'Teknik Komputer'),
('D006', 'Pengajaran', 'Pengajaran'),
('D007', 'Perpustakaan', 'Perpustakaan'),
('D008', 'Ruang Kelas - Gedung S', 'Ruang Kelas Gedung Selatan'),
('D009', 'Ruang Kelas - Gedung U', 'Ruang Kelas Gedung Utara');

-- --------------------------------------------------------

--
-- Table structure for table `hak_akses`
--

CREATE TABLE `hak_akses` (
  `id` int(4) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  `mu_data_petugas` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_data_supplier` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_data_pegawai` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_data_departemen` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_data_kategori` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_data_lokasi` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_data_barang` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_data_inventaris` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_pencarian` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_barcode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_trans_pengadaan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_trans_penempatan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_trans_mutasi` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_trans_peminjaman` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_trans_pemeliharaan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_laporan_cetak` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_backup_restore` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_export_import` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_export_barang` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_export_pegawai` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_import_barang` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_import_pegawai` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_petugas` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_supplier` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_pegawai` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_departemen` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_kategori` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_lokasi` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_barang_kategori` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_barang_lokasi` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_inventaris_barang_1` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_inventaris_barang_2` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_pengadaan_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_pengadaan_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_pengadaan_supplier` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_pengadaan_barang_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_pengadaan_barang_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_pengadaan_barang_kategori` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_pengadaan_barang_supplier` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_penempatan_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_penempatan_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_penempatan_lokasi` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_mutasi_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_mutasi_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_mutasi_lokasi` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_peminjaman_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_peminjaman_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_peminjaman_pegawai` enum('No','Yes') NOT NULL DEFAULT 'No'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hak_akses`
--

INSERT INTO `hak_akses` (`id`, `kd_petugas`, `mu_data_petugas`, `mu_data_supplier`, `mu_data_pegawai`, `mu_data_departemen`, `mu_data_kategori`, `mu_data_lokasi`, `mu_data_barang`, `mu_data_inventaris`, `mu_pencarian`, `mu_barcode`, `mu_trans_pengadaan`, `mu_trans_penempatan`, `mu_trans_mutasi`, `mu_trans_peminjaman`, `mu_trans_pemeliharaan`, `mu_laporan_cetak`, `mu_backup_restore`, `mu_export_import`, `mu_export_barang`, `mu_export_pegawai`, `mu_import_barang`, `mu_import_pegawai`, `mlap_petugas`, `mlap_supplier`, `mlap_pegawai`, `mlap_departemen`, `mlap_kategori`, `mlap_lokasi`, `mlap_barang_kategori`, `mlap_barang_lokasi`, `mlap_inventaris_barang_1`, `mlap_inventaris_barang_2`, `mlap_pengadaan_periode`, `mlap_pengadaan_bulan`, `mlap_pengadaan_supplier`, `mlap_pengadaan_barang_periode`, `mlap_pengadaan_barang_bulan`, `mlap_pengadaan_barang_kategori`, `mlap_pengadaan_barang_supplier`, `mlap_penempatan_periode`, `mlap_penempatan_bulan`, `mlap_penempatan_lokasi`, `mlap_mutasi_periode`, `mlap_mutasi_bulan`, `mlap_mutasi_lokasi`, `mlap_peminjaman_periode`, `mlap_peminjaman_bulan`, `mlap_peminjaman_pegawai`) VALUES
(1, 'P001', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes'),
(2, 'P002', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(3, 'P003', 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(5, 'P004', 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes'),
(7, 'P005', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kd_kategori` char(4) NOT NULL,
  `nm_kategori` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kd_kategori`, `nm_kategori`) VALUES
('K001', 'Komputer'),
('K002', 'Laptop'),
('K003', 'Printer'),
('K004', 'UPS Power Suply'),
('K005', 'Meja Komputer'),
('K006', 'Monitor');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `kd_lokasi` char(5) NOT NULL,
  `nm_lokasi` varchar(100) NOT NULL,
  `kd_departemen` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`kd_lokasi`, `nm_lokasi`, `kd_departemen`) VALUES
('L0001', 'Kepala Prodi TI', 'D001'),
('L0002', 'Ruang Dosen TI', 'D001'),
('L0003', 'Kepala Prodi SI', 'D002'),
('L0004', 'Ruang Dosen SI', 'D002'),
('L0005', 'Kepala Prodi MI', 'D003'),
('L0006', 'Ruang Dosen MI', 'D003'),
('L0007', 'Kepala Prodi KA', 'D004'),
('L0008', 'Ruang Dosen KA', 'D004'),
('L0009', 'Kepala Prodi TK', 'D005'),
('L0010', 'Ruang Dosen TK', 'D005'),
('L0011', 'Kepala Pengajaran', 'D006'),
('L0012', 'Ruang Pengajaran', 'D006'),
('L0013', 'Kepala Perpustakaan', 'D007'),
('L0014', 'Ruang Perpustakaan', 'D007'),
('L0015', 'Kelas S.1.1', 'D008');

-- --------------------------------------------------------

--
-- Table structure for table `mutasi`
--

CREATE TABLE `mutasi` (
  `no_mutasi` char(7) NOT NULL,
  `tgl_mutasi` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mutasi`
--

INSERT INTO `mutasi` (`no_mutasi`, `tgl_mutasi`, `keterangan`, `kd_petugas`) VALUES
('MB00001', '2017-01-26', 'Salah tempat', 'P001'),
('MB00002', '2017-01-26', 'Salah tempat', 'P001');

-- --------------------------------------------------------

--
-- Table structure for table `mutasi_asal`
--

CREATE TABLE `mutasi_asal` (
  `id` int(4) NOT NULL,
  `no_mutasi` char(7) NOT NULL,
  `no_penempatan` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mutasi_asal`
--

INSERT INTO `mutasi_asal` (`id`, `no_mutasi`, `no_penempatan`, `kd_inventaris`) VALUES
(4, 'MB00002', 'PB00005', 'B0002.000004'),
(3, 'MB00001', 'PB00003', 'B0004.000009');

-- --------------------------------------------------------

--
-- Table structure for table `mutasi_tujuan`
--

CREATE TABLE `mutasi_tujuan` (
  `no_mutasi` char(7) NOT NULL,
  `no_penempatan` char(7) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mutasi_tujuan`
--

INSERT INTO `mutasi_tujuan` (`no_mutasi`, `no_penempatan`, `keterangan`) VALUES
('MB00001', 'PB00004', 'Untuk membuat laporan'),
('MB00002', 'PB00006', 'Untuk dipakai pada Prodi MI');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `kd_pegawai` char(5) NOT NULL,
  `nm_pegawai` varchar(100) NOT NULL,
  `jns_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `kelamin` enum('L','P') NOT NULL DEFAULT 'L',
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`kd_pegawai`, `nm_pegawai`, `jns_kelamin`, `kelamin`, `alamat`, `no_telepon`, `foto`) VALUES
('P0001', 'Juwanto', '', 'L', 'Jl. Manggarawan, 130, Labuhan Ratu 7', '081911818188', 'P0001.bunafit 2.png'),
('P0002', 'Riswantoro', 'Laki-laki', 'L', 'Jl. Suhada, Way Jepara, Lampung Timur', '021511881818', ''),
('P0003', 'Sardi Sudrajad', 'Laki-laki', 'L', 'Jl. Margahayu 120, Labuhan Ratu baru, Way Jepara', '081921341111', ''),
('P0004', 'Atika Lusiana', 'Perempuan', 'L', 'Jl. Margahayu 120, Labuhan Ratu baru, Way Jepara', '08192223333', 'P0004.indah.png'),
('P0005', 'Septi Susanti', 'Perempuan', 'L', 'Jl. Maguwo, Yogyakarta', '0819223345', ''),
('P0006', 'Umi Rahayu', 'Perempuan', 'L', 'Jl. Way Jepara, Lampung Timur', '081911118181', '');

-- --------------------------------------------------------

--
-- Table structure for table `pemeliharaan`
--

CREATE TABLE `pemeliharaan` (
  `no_pemeliharaan` varchar(7) NOT NULL,
  `tgl_pemeliharaan` date NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  `biaya` int(12) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemeliharaan`
--

INSERT INTO `pemeliharaan` (`no_pemeliharaan`, `tgl_pemeliharaan`, `kd_inventaris`, `biaya`, `keterangan`, `kd_petugas`) VALUES
('PB00001', '2017-02-04', 'B0002.000004', 200000, 'Memperbaiki Keyboard yang error, dan instal Sistem Operasi\r\ndi Toko Mega Buana', 'P001'),
('PB00002', '2017-02-05', 'B0001.000001', 100000, 'Penginstalan ulang', 'P001');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `no_peminjaman` char(7) NOT NULL,
  `tgl_peminjaman` date NOT NULL,
  `tgl_akan_kembali` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `kd_pegawai` char(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `status_kembali` enum('Pinjam','Kembali') NOT NULL DEFAULT 'Pinjam',
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_item`
--

CREATE TABLE `peminjaman_item` (
  `no_peminjaman` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penempatan`
--

CREATE TABLE `penempatan` (
  `no_penempatan` char(7) NOT NULL,
  `tgl_penempatan` date NOT NULL,
  `kd_lokasi` char(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `jenis` enum('Baru','Mutasi') NOT NULL DEFAULT 'Baru',
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penempatan`
--

INSERT INTO `penempatan` (`no_penempatan`, `tgl_penempatan`, `kd_lokasi`, `keterangan`, `jenis`, `kd_petugas`) VALUES
('PB00003', '2017-01-26', 'L0003', 'Printer', 'Baru', 'P001'),
('PB00004', '2017-01-26', 'L0004', 'Untuk membuat laporan', 'Mutasi', 'P001'),
('PB00005', '2017-01-26', 'L0003', 'Penempatan laptop dan printer', 'Baru', 'P001'),
('PB00006', '2017-01-26', 'L0005', 'Untuk dipakai pada Prodi MI', 'Mutasi', 'P001'),
('PB00001', '2017-01-26', 'L0001', 'Penempatan Laptop', 'Baru', 'P001'),
('PB00002', '2017-01-26', 'L0002', 'Komputer satu set', 'Baru', 'P001');

-- --------------------------------------------------------

--
-- Table structure for table `penempatan_item`
--

CREATE TABLE `penempatan_item` (
  `no_penempatan` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  `status_aktif` enum('Yes','No') NOT NULL DEFAULT 'Yes'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penempatan_item`
--

INSERT INTO `penempatan_item` (`no_penempatan`, `kd_inventaris`, `status_aktif`) VALUES
('PB00001', 'B0002.000003', 'Yes'),
('PB00001', 'B0001.000001', 'Yes'),
('PB00002', 'B0009.000034', 'Yes'),
('PB00002', 'B0004.000008', 'Yes'),
('PB00002', 'B0008.000027', 'Yes'),
('PB00002', 'B0007.000020', 'Yes'),
('PB00003', 'B0004.000009', 'No'),
('PB00004', 'B0004.000009', 'Yes'),
('PB00005', 'B0004.000010', 'Yes'),
('PB00005', 'B0002.000004', 'No'),
('PB00006', 'B0002.000004', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `pengadaan`
--

CREATE TABLE `pengadaan` (
  `no_pengadaan` char(7) NOT NULL,
  `tgl_pengadaan` date NOT NULL,
  `kd_supplier` char(4) NOT NULL,
  `jenis_pengadaan` varchar(100) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengadaan`
--

INSERT INTO `pengadaan` (`no_pengadaan`, `tgl_pengadaan`, `kd_supplier`, `jenis_pengadaan`, `keterangan`, `kd_petugas`) VALUES
('BB00001', '2015-06-04', 'S001', 'Pembelian', 'Pembelian dari Khas Kantor', 'P001'),
('BB00002', '2015-07-07', 'S002', 'Pembelian', 'Pengadaan dari uang Kas', 'P001'),
('BB00003', '2015-07-22', 'S002', 'Sumbangan', 'Sumbangan Uang dari Pemda', 'P001'),
('BB00004', '2015-08-06', 'S002', 'Pembelian', 'Pembelian dari Kas Kantor', 'P001'),
('BB00005', '2015-08-06', 'S004', 'Pembelian', 'Pembelian dari Kas Kantor', 'P001'),
('BB00006', '2015-08-06', 'S001', 'Pembelian', 'Pembelian dari Kas Kantor', 'P001'),
('BB00007', '2016-07-28', 'S001', 'Pembelian', 'pembelian', 'P001'),
('BB00008', '2016-07-28', 'S001', 'Pembelian', 'pembelian', 'P001');

-- --------------------------------------------------------

--
-- Table structure for table `pengadaan_item`
--

CREATE TABLE `pengadaan_item` (
  `no_pengadaan` char(7) NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `harga_beli` int(12) NOT NULL,
  `jumlah` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengadaan_item`
--

INSERT INTO `pengadaan_item` (`no_pengadaan`, `kd_barang`, `deskripsi`, `harga_beli`, `jumlah`) VALUES
('BB00001', 'B0010', 'Komputer Rakitan Core 2 Duwo CPU Komplit', 3200000, 2),
('BB00001', 'B0009', 'Komputer Rakitan Dual Core CPU Komplit', 3000000, 4),
('BB00002', 'B0001', 'Toshiba Satellite C800D-1003 Black', 7300000, 2),
('BB00002', 'B0002', 'Toshiba Satelite C40-A106 Black baru', 5800000, 3),
('BB00003', 'B0004', 'Printer Canon IP 2770', 470000, 6),
('BB00003', 'B0005', 'Printer Brother Colour Laser HL-2150N Mono', 1200000, 4),
('BB00003', 'B0003', 'Printer Canon LBP 5100 Laser Jet', 1350000, 2),
('BB00004', 'B0006', 'UPS Prolink Pro 700', 450000, 2),
('BB00004', 'B0007', 'UPS Prolink IPS 500i Inverter 500VA', 680000, 7),
('BB00005', 'B0008', 'Meja Komputer Crystal Grace 101', 270000, 7),
('BB00006', 'B0011', 'LCD LG 19 Inch', 1250000, 7),
('BB00007', 'B0009', 'Beli komputer lagi', 3500000, 5),
('BB00008', 'B0010', 'Pembelian lagi', 2500000, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `no_pengembalian` char(7) NOT NULL,
  `tgl_pengembalian` date NOT NULL,
  `no_peminjaman` char(7) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `kd_petugas` char(4) NOT NULL,
  `nm_petugas` varchar(100) NOT NULL,
  `kelamin` enum('L','P') NOT NULL DEFAULT 'L',
  `alamat` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` varchar(20) NOT NULL DEFAULT 'Kasir'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`kd_petugas`, `nm_petugas`, `kelamin`, `alamat`, `no_telepon`, `foto`, `username`, `password`, `level`) VALUES
('P001', 'Bunafit Nugroho', 'L', 'Jl. Suhada, No 12, Way Jepara, Lampung Timur', '081911111111111', 'P001.bunafit 2.png', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin'),
('P002', 'Fitria Prasetya', 'L', '', '081911111111', '', 'fitria', 'ef208a5dfcfc3ea9941d7a6c43841784', 'Petugas'),
('P003', 'Septi Suhesti', 'L', '', '081911111111', '', 'septi', 'd58d8a16aa666d48fbcc30bd3217fb17', 'Petugas'),
('P004', 'Riska Dwisaputra', 'L', '', '082133456', '', 'riska', 'fb059ad1c514876b15b3ec40df1acdac', 'Petugas'),
('P005', 'sfsfsdf', 'L', '', '343434', '', 'ssss', '9f6e6800cfae7749eb6c486619254b9c', 'Petugas');

-- --------------------------------------------------------

--
-- Table structure for table `resume_inventaris`
--

CREATE TABLE `resume_inventaris` (
  `id` int(11) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  `hasil_resume` varchar(100) NOT NULL,
  `kondisi_barang` varchar(100) NOT NULL,
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resume_inventaris`
--

INSERT INTO `resume_inventaris` (`id`, `kd_inventaris`, `hasil_resume`, `kondisi_barang`, `kd_petugas`) VALUES
(1, 'B0002.000004', 'Harus cepat diperbaiki', 'Buruk', 'P001'),
(2, 'B0002.000004', 'Harus cepat cepat diperbaiki', 'Buruk sekali', 'P001');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `kd_supplier` char(4) NOT NULL,
  `nm_supplier` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`kd_supplier`, `nm_supplier`, `alamat`, `no_telepon`) VALUES
('S001', 'ELS Computer', 'Jl. Adisucipto, Yogyakarta', '02741111111'),
('S002', 'ALNECT Computer', 'Jl. Janti, Jembatan Layang, Yogyakarta', '08191010101'),
('S003', 'MAKRO Gudang Rabat', 'Jl. Maguwo Yogyakarta', '081912121212'),
('S004', 'Gondang Jaya Mebel', 'Jl. Adisucipto, Yogyakarta', '027412121212'),
('S005', 'PROGO Toserba', 'Jl. Malioboro, Yogyakarta', '0819111199911');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_mutasi`
--

CREATE TABLE `tmp_mutasi` (
  `id` int(4) NOT NULL,
  `no_penempatan` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_peminjaman`
--

CREATE TABLE `tmp_peminjaman` (
  `id` int(4) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  `kd_inventaris` char(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_penempatan`
--

CREATE TABLE `tmp_penempatan` (
  `id` int(4) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  `kd_inventaris` char(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_pengadaan`
--

CREATE TABLE `tmp_pengadaan` (
  `id` int(4) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `harga_beli` int(12) NOT NULL,
  `jumlah` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kd_barang`),
  ADD UNIQUE KEY `kd_buku` (`kd_barang`);

--
-- Indexes for table `barang_inventaris`
--
ALTER TABLE `barang_inventaris`
  ADD PRIMARY KEY (`kd_inventaris`);

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`kd_departemen`);

--
-- Indexes for table `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kd_kategori`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`kd_lokasi`);

--
-- Indexes for table `mutasi`
--
ALTER TABLE `mutasi`
  ADD PRIMARY KEY (`no_mutasi`);

--
-- Indexes for table `mutasi_asal`
--
ALTER TABLE `mutasi_asal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`kd_pegawai`);

--
-- Indexes for table `pemeliharaan`
--
ALTER TABLE `pemeliharaan`
  ADD PRIMARY KEY (`no_pemeliharaan`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`no_peminjaman`);

--
-- Indexes for table `penempatan`
--
ALTER TABLE `penempatan`
  ADD PRIMARY KEY (`no_penempatan`);

--
-- Indexes for table `pengadaan`
--
ALTER TABLE `pengadaan`
  ADD PRIMARY KEY (`no_pengadaan`);

--
-- Indexes for table `pengadaan_item`
--
ALTER TABLE `pengadaan_item`
  ADD KEY `nomor_penjualan_tamu` (`no_pengadaan`,`kd_barang`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`no_pengembalian`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`kd_petugas`);

--
-- Indexes for table `resume_inventaris`
--
ALTER TABLE `resume_inventaris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`kd_supplier`);

--
-- Indexes for table `tmp_mutasi`
--
ALTER TABLE `tmp_mutasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_peminjaman`
--
ALTER TABLE `tmp_peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_penempatan`
--
ALTER TABLE `tmp_penempatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_pengadaan`
--
ALTER TABLE `tmp_pengadaan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hak_akses`
--
ALTER TABLE `hak_akses`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `mutasi_asal`
--
ALTER TABLE `mutasi_asal`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `resume_inventaris`
--
ALTER TABLE `resume_inventaris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tmp_mutasi`
--
ALTER TABLE `tmp_mutasi`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tmp_peminjaman`
--
ALTER TABLE `tmp_peminjaman`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tmp_penempatan`
--
ALTER TABLE `tmp_penempatan`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tmp_pengadaan`
--
ALTER TABLE `tmp_pengadaan`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
