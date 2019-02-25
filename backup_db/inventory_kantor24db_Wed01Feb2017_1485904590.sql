DROP TABLE IF EXISTS barang;

CREATE TABLE `barang` (
  `kd_barang` char(5) NOT NULL,
  `nm_barang` varchar(100) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `merek` varchar(100) NOT NULL,
  `tipe` varchar(100) NOT NULL,
  `jumlah` int(6) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `kd_kategori` char(4) NOT NULL,
  PRIMARY KEY (`kd_barang`),
  UNIQUE KEY `kd_buku` (`kd_barang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO barang VALUES("B0001","TOSHIBA Satellite C800D-1003 - Black ","Notebook / Laptop 13 inch - 14 inch AMD Dual Core E1-1200, 2GB DDR3, 320GB HDD, DVD±RW, WiFi, Bluetooth, VGA AMD Radeon HD 7000 Series, Camera, 14","TOSHIBA","SS","2","Unit","K002");
INSERT INTO barang VALUES("B0002","TOSHIBA Satellite C40-A106 - Black","Notebook / Laptop 13 inch - 14 inch Intel Core i3-2348M, 2GB DDR3, 500GB HDD, DVD±RW, WiFi, Bluetooth, VGA Intel HD Graphics, Camera, 14","TOSHIBA","","3","Unit","K002");
INSERT INTO barang VALUES("B0003","Printer Canon LBP 5100 Laser Jet","Canon LBP 5100 Laser Jet","Canon","","2","Unit","K003");
INSERT INTO barang VALUES("B0004","Printer Canon IP 2770","Canon IP 2770","Canon","","6","Unit","K003");
INSERT INTO barang VALUES("B0005","Printer Brother Colour Laser HL-2150N Mono","Brother Colour Laser HL-2150N Mono Laser Printer, Networking","Brother","","4","Unit","K003");
INSERT INTO barang VALUES("B0006","UPS Prolink Pro 700","Prolink Pro 700","Prolink","","2","Unit","K004");
INSERT INTO barang VALUES("B0007","UPS Prolink IPS 500i Inverter 500VA","Prolink IPS 500i Inverter 500VA","Prolink","","7","Unit","K004");
INSERT INTO barang VALUES("B0008","Meja Komputer Crystal Grace 101","Crystal Grace 101 (100x45x70)","Crystal Grace","","7","Unit","K005");
INSERT INTO barang VALUES("B0009","Komputer Kantor - Paket 1","Motherboard PCP+ 790Gx Baby Raptor\nProcessor AMD Athlon II 64 X2 250\nMemory 1 GB DDR2 PC6400 800 MHz\nHarddisk WDC 320 GB Sata\nDVD±RW/RAM 24x Sata\nKeyboard + Mouse SPC\nCasing Libera Series 500 Wa","Rakitan","","12","Unit","K001");
INSERT INTO barang VALUES("B0010","Komputer Kantor - Paket 2","Dual Core (2.6 Ghz) TRAY\nMainboard ASUS P5 KPL AM-SE ( Astrindo )\nMemory DDR2 V-gen 2 Gb PC 5300\nHarddisk 250 Gb Seagate/WDC/Maxtor SATA\nKeyboard + Mouse Logitech\nCasing SPC 350w + 1 FAN CPU\nLCD","Rakitan","sss","5","Unit","K001");
INSERT INTO barang VALUES("B0011","LCD LG 19 Inch","LG 19 Inch L1942S (Square)","LG","","7","Unit","K006");



DROP TABLE IF EXISTS barang_inventaris;

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
  `harga_barang` int(12) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `status_barang` enum('Tersedia','Ditempatkan','Dipinjam') NOT NULL DEFAULT 'Tersedia'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO barang_inventaris VALUES("B0001.000001","B0001","BB00002","2015-08-06","2016","2017","435345345435","12/11/2019","34343434","Soho","3500000","Oke banged","Ditempatkan");
INSERT INTO barang_inventaris VALUES("B0001.000002","B0001","BB00002","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0002.000003","B0002","BB00002","2015-08-06","","","","","","","0","","Ditempatkan");
INSERT INTO barang_inventaris VALUES("B0002.000004","B0002","BB00002","2015-08-06","","","","","","","0","","Ditempatkan");
INSERT INTO barang_inventaris VALUES("B0002.000005","B0002","BB00002","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0003.000006","B0003","BB00003","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0003.000007","B0003","BB00003","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0004.000008","B0004","BB00003","2015-08-06","","","","","","","0","","Ditempatkan");
INSERT INTO barang_inventaris VALUES("B0004.000009","B0004","BB00003","2015-08-06","","","","","","","0","","Ditempatkan");
INSERT INTO barang_inventaris VALUES("B0004.000010","B0004","BB00003","2015-08-06","","","","","","","0","","Ditempatkan");
INSERT INTO barang_inventaris VALUES("B0004.000011","B0004","BB00003","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0004.000012","B0004","BB00003","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0004.000013","B0004","BB00003","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0005.000014","B0005","BB00003","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0005.000015","B0005","BB00003","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0005.000016","B0005","BB00003","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0005.000017","B0005","BB00003","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0006.000018","B0006","BB00004","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0006.000019","B0006","BB00004","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0007.000020","B0007","BB00004","2015-08-06","","","","","","","0","","Ditempatkan");
INSERT INTO barang_inventaris VALUES("B0007.000021","B0007","BB00004","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0007.000022","B0007","BB00004","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0007.000023","B0007","BB00004","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0007.000024","B0007","BB00004","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0007.000025","B0007","BB00004","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0007.000026","B0007","BB00004","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0008.000027","B0008","BB00005","2015-08-06","","","","","","","0","","Ditempatkan");
INSERT INTO barang_inventaris VALUES("B0008.000028","B0008","BB00005","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0008.000029","B0008","BB00005","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0008.000030","B0008","BB00005","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0008.000031","B0008","BB00005","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0008.000032","B0008","BB00005","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0008.000033","B0008","BB00005","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0009.000034","B0009","BB00001","2015-08-06","","","","","","","0","","Ditempatkan");
INSERT INTO barang_inventaris VALUES("B0009.000035","B0009","BB00001","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0009.000036","B0009","BB00001","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0009.000037","B0009","BB00001","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0010.000038","B0010","BB00001","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0010.000039","B0010","BB00001","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0011.000040","B0011","BB00006","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0011.000041","B0011","BB00006","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0011.000042","B0011","BB00006","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0011.000043","B0011","BB00006","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0011.000044","B0011","BB00006","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0011.000045","B0011","BB00006","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0011.000046","B0011","BB00006","2015-08-06","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0009.000049","B0009","BB00007","2016-07-28","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0009.000048","B0009","BB00007","2016-07-28","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0009.000047","B0009","BB00007","2016-07-28","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0009.000050","B0009","BB00007","2016-07-28","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0009.000051","B0009","BB00007","2016-07-28","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0010.000052","B0010","BB00008","2016-07-28","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0010.000053","B0010","BB00008","2016-07-28","","","","","","","0","","Tersedia");
INSERT INTO barang_inventaris VALUES("B0010.000054","B0010","BB00008","2016-07-28","","","","","","","0","","Tersedia");



DROP TABLE IF EXISTS departemen;

CREATE TABLE `departemen` (
  `kd_departemen` char(4) NOT NULL,
  `nm_departemen` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  PRIMARY KEY (`kd_departemen`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO departemen VALUES("D001","Prodi TI","Teknik Informatika");
INSERT INTO departemen VALUES("D002","Prodi SI","Sistem Informasi");
INSERT INTO departemen VALUES("D003","Prodi MI","Manajemen Informatika");
INSERT INTO departemen VALUES("D004","Prodi KA","Komputer Akuntansi");
INSERT INTO departemen VALUES("D005","Prodi TK","Teknik Komputer");
INSERT INTO departemen VALUES("D006","Pengajaran","Pengajaran");
INSERT INTO departemen VALUES("D007","Perpustakaan","Perpustakaan");
INSERT INTO departemen VALUES("D008","Ruang Kelas - Gedung S","Ruang Kelas Gedung Selatan");
INSERT INTO departemen VALUES("D009","Ruang Kelas - Gedung U","Ruang Kelas Gedung Utara");



DROP TABLE IF EXISTS hak_akses;

CREATE TABLE `hak_akses` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
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
  `mlap_peminjaman_pegawai` enum('No','Yes') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO hak_akses VALUES("1","P001","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes");
INSERT INTO hak_akses VALUES("2","P002","No","No","No","No","No","No","No","Yes","No","No","No","No","No","No","Yes","No","Yes","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No");
INSERT INTO hak_akses VALUES("3","P003","No","Yes","Yes","Yes","Yes","Yes","Yes","No","Yes","Yes","No","No","No","No","Yes","No","Yes","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No","No");
INSERT INTO hak_akses VALUES("5","P004","No","Yes","Yes","Yes","Yes","Yes","Yes","No","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes","Yes");



DROP TABLE IF EXISTS kategori;

CREATE TABLE `kategori` (
  `kd_kategori` char(4) NOT NULL,
  `nm_kategori` varchar(100) NOT NULL,
  PRIMARY KEY (`kd_kategori`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO kategori VALUES("K001","Komputer");
INSERT INTO kategori VALUES("K002","Laptop");
INSERT INTO kategori VALUES("K003","Printer");
INSERT INTO kategori VALUES("K004","UPS Power Suply");
INSERT INTO kategori VALUES("K005","Meja Komputer");
INSERT INTO kategori VALUES("K006","Monitor");



DROP TABLE IF EXISTS lokasi;

CREATE TABLE `lokasi` (
  `kd_lokasi` char(5) NOT NULL,
  `nm_lokasi` varchar(100) NOT NULL,
  `kd_departemen` char(4) NOT NULL,
  PRIMARY KEY (`kd_lokasi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO lokasi VALUES("L0001","Kepala Prodi TI","D001");
INSERT INTO lokasi VALUES("L0002","Ruang Dosen TI","D001");
INSERT INTO lokasi VALUES("L0003","Kepala Prodi SI","D002");
INSERT INTO lokasi VALUES("L0004","Ruang Dosen SI","D002");
INSERT INTO lokasi VALUES("L0005","Kepala Prodi MI","D003");
INSERT INTO lokasi VALUES("L0006","Ruang Dosen MI","D003");
INSERT INTO lokasi VALUES("L0007","Kepala Prodi KA","D004");
INSERT INTO lokasi VALUES("L0008","Ruang Dosen KA","D004");
INSERT INTO lokasi VALUES("L0009","Kepala Prodi TK","D005");
INSERT INTO lokasi VALUES("L0010","Ruang Dosen TK","D005");
INSERT INTO lokasi VALUES("L0011","Kepala Pengajaran","D006");
INSERT INTO lokasi VALUES("L0012","Ruang Pengajaran","D006");
INSERT INTO lokasi VALUES("L0013","Kepala Perpustakaan","D007");
INSERT INTO lokasi VALUES("L0014","Ruang Perpustakaan","D007");
INSERT INTO lokasi VALUES("L0015","Kelas S.1.1","D008");



DROP TABLE IF EXISTS mutasi;

CREATE TABLE `mutasi` (
  `no_mutasi` char(7) NOT NULL,
  `tgl_mutasi` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`no_mutasi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO mutasi VALUES("MB00001","2017-01-26","Salah tempat","P001");
INSERT INTO mutasi VALUES("MB00002","2017-01-26","Salah tempat","P001");



DROP TABLE IF EXISTS mutasi_asal;

CREATE TABLE `mutasi_asal` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `no_mutasi` char(7) NOT NULL,
  `no_penempatan` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO mutasi_asal VALUES("4","MB00002","PB00005","B0002.000004");
INSERT INTO mutasi_asal VALUES("3","MB00001","PB00003","B0004.000009");



DROP TABLE IF EXISTS mutasi_tujuan;

CREATE TABLE `mutasi_tujuan` (
  `no_mutasi` char(7) NOT NULL,
  `no_penempatan` char(7) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO mutasi_tujuan VALUES("MB00001","PB00004","Untuk membuat laporan");
INSERT INTO mutasi_tujuan VALUES("MB00002","PB00006","Untuk dipakai pada Prodi MI");



DROP TABLE IF EXISTS pegawai;

CREATE TABLE `pegawai` (
  `kd_pegawai` char(5) NOT NULL,
  `nm_pegawai` varchar(100) NOT NULL,
  `jns_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  PRIMARY KEY (`kd_pegawai`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO pegawai VALUES("P0001","Juwanto","Laki-laki","Jl. Manggarawan, 130, Labuhan Ratu 7","081911818188");
INSERT INTO pegawai VALUES("P0002","Riswantoro","Laki-laki","Jl. Suhada, Way Jepara, Lampung Timur","021511881818");
INSERT INTO pegawai VALUES("P0003","Sardi Sudrajad","Laki-laki","Jl. Margahayu 120, Labuhan Ratu baru, Way Jepara","081921341111");
INSERT INTO pegawai VALUES("P0004","Atika Lusiana","Perempuan","Jl. Margahayu 120, Labuhan Ratu baru, Way Jepara","08192223333");
INSERT INTO pegawai VALUES("P0005","Septi Susanti","Perempuan","Jl. Maguwo, Yogyakarta","0819223345");
INSERT INTO pegawai VALUES("P0006","Umi Rahayu","Perempuan","Jl. Way Jepara, Lampung Timur","081911118181");



DROP TABLE IF EXISTS pemeliharaan;

CREATE TABLE `pemeliharaan` (
  `no_pemeliharaan` varchar(7) NOT NULL,
  `tgl_pemeliharaan` date NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `biaya` int(12) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`no_pemeliharaan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS peminjaman;

CREATE TABLE `peminjaman` (
  `no_peminjaman` char(7) NOT NULL,
  `tgl_peminjaman` date NOT NULL,
  `tgl_akan_kembali` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `kd_pegawai` char(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `status_kembali` enum('Pinjam','Kembali') NOT NULL DEFAULT 'Pinjam',
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`no_peminjaman`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS peminjaman_item;

CREATE TABLE `peminjaman_item` (
  `no_peminjaman` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS penempatan;

CREATE TABLE `penempatan` (
  `no_penempatan` char(7) NOT NULL,
  `tgl_penempatan` date NOT NULL,
  `kd_lokasi` char(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `jenis` enum('Baru','Mutasi') NOT NULL DEFAULT 'Baru',
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`no_penempatan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO penempatan VALUES("PB00003","2017-01-26","L0003","Printer","Baru","P001");
INSERT INTO penempatan VALUES("PB00004","2017-01-26","L0004","Untuk membuat laporan","Mutasi","P001");
INSERT INTO penempatan VALUES("PB00005","2017-01-26","L0003","Penempatan laptop dan printer","Baru","P001");
INSERT INTO penempatan VALUES("PB00006","2017-01-26","L0005","Untuk dipakai pada Prodi MI","Mutasi","P001");
INSERT INTO penempatan VALUES("PB00001","2017-01-26","L0001","Penempatan Laptop","Baru","P001");
INSERT INTO penempatan VALUES("PB00002","2017-01-26","L0002","Komputer satu set","Baru","P001");



DROP TABLE IF EXISTS penempatan_item;

CREATE TABLE `penempatan_item` (
  `no_penempatan` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  `status_aktif` enum('Yes','No') NOT NULL DEFAULT 'Yes'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO penempatan_item VALUES("PB00001","B0002.000003","Yes");
INSERT INTO penempatan_item VALUES("PB00001","B0001.000001","Yes");
INSERT INTO penempatan_item VALUES("PB00002","B0009.000034","Yes");
INSERT INTO penempatan_item VALUES("PB00002","B0004.000008","Yes");
INSERT INTO penempatan_item VALUES("PB00002","B0008.000027","Yes");
INSERT INTO penempatan_item VALUES("PB00002","B0007.000020","Yes");
INSERT INTO penempatan_item VALUES("PB00003","B0004.000009","No");
INSERT INTO penempatan_item VALUES("PB00004","B0004.000009","Yes");
INSERT INTO penempatan_item VALUES("PB00005","B0004.000010","Yes");
INSERT INTO penempatan_item VALUES("PB00005","B0002.000004","No");
INSERT INTO penempatan_item VALUES("PB00006","B0002.000004","Yes");



DROP TABLE IF EXISTS pengadaan;

CREATE TABLE `pengadaan` (
  `no_pengadaan` char(7) NOT NULL,
  `tgl_pengadaan` date NOT NULL,
  `kd_supplier` char(4) NOT NULL,
  `jenis_pengadaan` varchar(100) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`no_pengadaan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO pengadaan VALUES("BB00001","2015-06-04","S001","Pembelian","Pembelian dari Khas Kantor","P001");
INSERT INTO pengadaan VALUES("BB00002","2015-07-07","S002","Pembelian","Pengadaan dari uang Kas","P001");
INSERT INTO pengadaan VALUES("BB00003","2015-07-22","S002","Sumbangan","Sumbangan Uang dari Pemda","P001");
INSERT INTO pengadaan VALUES("BB00004","2015-08-06","S002","Pembelian","Pembelian dari Kas Kantor","P001");
INSERT INTO pengadaan VALUES("BB00005","2015-08-06","S004","Pembelian","Pembelian dari Kas Kantor","P001");
INSERT INTO pengadaan VALUES("BB00006","2015-08-06","S001","Pembelian","Pembelian dari Kas Kantor","P001");
INSERT INTO pengadaan VALUES("BB00007","2016-07-28","S001","Pembelian","pembelian","P001");
INSERT INTO pengadaan VALUES("BB00008","2016-07-28","S001","Pembelian","pembelian","P001");



DROP TABLE IF EXISTS pengadaan_item;

CREATE TABLE `pengadaan_item` (
  `no_pengadaan` char(7) NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `harga_beli` int(12) NOT NULL,
  `jumlah` int(4) NOT NULL,
  KEY `nomor_penjualan_tamu` (`no_pengadaan`,`kd_barang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO pengadaan_item VALUES("BB00001","B0010","Komputer Rakitan Core 2 Duwo CPU Komplit","3200000","2");
INSERT INTO pengadaan_item VALUES("BB00001","B0009","Komputer Rakitan Dual Core CPU Komplit","3000000","4");
INSERT INTO pengadaan_item VALUES("BB00002","B0001","Toshiba Satellite C800D-1003 Black","7300000","2");
INSERT INTO pengadaan_item VALUES("BB00002","B0002","Toshiba Satelite C40-A106 Black baru","5800000","3");
INSERT INTO pengadaan_item VALUES("BB00003","B0004","Printer Canon IP 2770","470000","6");
INSERT INTO pengadaan_item VALUES("BB00003","B0005","Printer Brother Colour Laser HL-2150N Mono","1200000","4");
INSERT INTO pengadaan_item VALUES("BB00003","B0003","Printer Canon LBP 5100 Laser Jet","1350000","2");
INSERT INTO pengadaan_item VALUES("BB00004","B0006","UPS Prolink Pro 700","450000","2");
INSERT INTO pengadaan_item VALUES("BB00004","B0007","UPS Prolink IPS 500i Inverter 500VA","680000","7");
INSERT INTO pengadaan_item VALUES("BB00005","B0008","Meja Komputer Crystal Grace 101","270000","7");
INSERT INTO pengadaan_item VALUES("BB00006","B0011","LCD LG 19 Inch","1250000","7");
INSERT INTO pengadaan_item VALUES("BB00007","B0009","Beli komputer lagi","3500000","5");
INSERT INTO pengadaan_item VALUES("BB00008","B0010","Pembelian lagi","2500000","3");



DROP TABLE IF EXISTS pengembalian;

CREATE TABLE `pengembalian` (
  `no_pengembalian` char(7) NOT NULL,
  `tgl_pengembalian` date NOT NULL,
  `no_peminjaman` char(7) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`no_pengembalian`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS petugas;

CREATE TABLE `petugas` (
  `kd_petugas` char(4) NOT NULL,
  `nm_petugas` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` varchar(20) NOT NULL DEFAULT 'Kasir'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO petugas VALUES("P001","Bunafit Nugroho","081911111111111","admin","21232f297a57a5a743894a0e4a801fc3","Admin");
INSERT INTO petugas VALUES("P002","Fitria Prasetya","081911111111","fitria","ef208a5dfcfc3ea9941d7a6c43841784","Petugas");
INSERT INTO petugas VALUES("P003","Septi Suhesti","081911111111","septi","d58d8a16aa666d48fbcc30bd3217fb17","Petugas");
INSERT INTO petugas VALUES("P004","Riska Dwisaputra","082133456","riska","fb059ad1c514876b15b3ec40df1acdac","Petugas");



DROP TABLE IF EXISTS supplier;

CREATE TABLE `supplier` (
  `kd_supplier` char(4) NOT NULL,
  `nm_supplier` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  PRIMARY KEY (`kd_supplier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO supplier VALUES("S001","ELS Computer","Jl. Adisucipto, Yogyakarta","02741111111");
INSERT INTO supplier VALUES("S002","ALNECT Computer","Jl. Janti, Jembatan Layang, Yogyakarta","08191010101");
INSERT INTO supplier VALUES("S003","MAKRO Gudang Rabat","Jl. Maguwo Yogyakarta","081912121212");
INSERT INTO supplier VALUES("S004","Gondang Jaya Mebel","Jl. Adisucipto, Yogyakarta","027412121212");
INSERT INTO supplier VALUES("S005","PROGO Toserba","Jl. Malioboro, Yogyakarta","0819111199911");



DROP TABLE IF EXISTS tmp_mutasi;

CREATE TABLE `tmp_mutasi` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `no_penempatan` char(7) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS tmp_peminjaman;

CREATE TABLE `tmp_peminjaman` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `kd_petugas` char(4) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS tmp_penempatan;

CREATE TABLE `tmp_penempatan` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `kd_petugas` char(4) NOT NULL,
  `kd_inventaris` char(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS tmp_pengadaan;

CREATE TABLE `tmp_pengadaan` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `kd_petugas` char(4) NOT NULL,
  `kd_barang` char(5) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `harga_beli` int(12) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




