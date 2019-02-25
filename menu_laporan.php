<?php
if(isset($_SESSION['SES_LOGIN'])){
# JIKA YANG LOGIN LEVEL ADMIN, menu di bawah yang dijalankan
	include_once "library/inc.hakakses.php";
?>
<ul>
	<?php if($aksesData['mlap_petugas'] == "Yes") { ?>
	<li><a href="?open=Laporan-Petugas" target="_blank">Laporan Data Petugas</a></li>
	
	<?php } if($aksesData['mlap_supplier'] == "Yes") { ?>
	<li><a href="?open=Laporan-Supplier" target="_blank">Laporan Data Supplier</a></li>
	
	<?php } if($aksesData['mlap_pegawai'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pegawai" target="_blank">Laporan Data Pegawai</a></li>
	
	<?php } if($aksesData['mlap_departemen'] == "Yes") { ?>
	<li><a href="?open=Laporan-Departemen" target="_blank">Laporan Data Departemen</a></li>
	
	<?php } if($aksesData['mlap_lokasi'] == "Yes") { ?>
	<li><a href="?open=Laporan-Lokasi" target="_blank">Laporan Data Lokasi</a></li>
	
	<?php } if($aksesData['mlap_kategori'] == "Yes") { ?>
	<li><a href="?open=Laporan-Kategori" target="_blank">Laporan Data Kategori</a></li>
	
	<?php } if($aksesData['mlap_barang_kategori'] == "Yes") { ?>
	<li><a href="?open=Laporan-Barang-Kategori" target="_blank">Laporan Barang per Kategori</a></li>
	
	<?php } if($aksesData['mlap_barang_lokasi'] == "Yes") { ?>
	<li><a href="?open=Laporan-Barang-Lokasi" target="_blank">Laporan Barang per Lokasi</a></li>
	
	
	<?php } if($aksesData['mlap_inventaris_barang_1'] == "Yes") { ?>
	<li><a href="?open=Laporan-Inventaris-Barang-1" target="_blank">Laporan Inventaris Barang 1</a></li>
	
	<?php } if($aksesData['mlap_inventaris_barang_2'] == "Yes") { ?>
	<li><a href="?open=Laporan-Inventaris-Barang-2" target="_blank">Laporan Inventaris Barang 2</a></li>
	
	
	<?php } if($aksesData['mlap_pengadaan_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pengadaan-Periode" target="_blank">Laporan Pengadaan per Periode</a></li>
	
	<?php } if($aksesData['mlap_pengadaan_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pengadaan-Bulan" target="_blank">Laporan Pengadaan per Bulan</a></li>
	
	<?php } if($aksesData['mlap_pengadaan_supplier'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pengadaan-Supplier" target="_blank">Laporan Pengadaan per Supplier</a></li>

	
	<?php } if($aksesData['mlap_pengadaan_barang_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pengadaan-Barang-Periode" target="_blank">Laporan Pengadaan Barang Per Periode </a></li>
	
	<?php } if($aksesData['mlap_pengadaan_barang_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pengadaan-Barang-Bulan" target="_blank">Laporan Pengadaan Barang Per Bulan </a></li>
	
	<?php } if($aksesData['mlap_pengadaan_barang_kategori'] == "Yes") { ?>
    <li><a href="?open=Laporan-Pengadaan-Barang-Kategori" target="_blank">Laporan Pengadaan Barang Per Kategori</a></li>
	
	<?php } if($aksesData['mlap_pengadaan_barang_supplier'] == "Yes") { ?>
    <li><a href="?open=Laporan-Pengadaan-Barang-Supplier" target="_blank">Laporan Pengadaan Barang  Per Supplier </a></li>

	
	<?php } if($aksesData['mlap_penempatan_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Penempatan-Periode" target="_blank">Laporan Penempatan per Periode</a></li>
	
	<?php } if($aksesData['mlap_penempatan_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Penempatan-Bulan" target="_blank">Laporan Penempatan per Bulan</a></li>
	
	<?php } if($aksesData['mlap_penempatan_lokasi'] == "Yes") { ?>
	<li><a href="?open=Laporan-Penempatan-Lokasi" target="_blank">Laporan Penempatan per Lokasi</a></li>
	
	
	<?php } if($aksesData['mlap_mutasi_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Mutasi-Periode" target="_blank">Laporan Mutasi per Periode</a></li>
	
	<?php } if($aksesData['mlap_mutasi_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Mutasi-Bulan" target="_blank">Laporan Mutasi per Bulan</a></li>
	
	<?php } if($aksesData['mlap_supplier'] == "Yes") { ?>
    <li><a href="?open=Laporan-Mutasi-Lokasi" target="_blank">Laporan Mutasi Per Lokasi </a></li>

	
	<?php } if($aksesData['mlap_peminjaman_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Peminjaman-Periode" target="_blank">Laporan Peminjaman per Periode</a></li>
	
	<?php } if($aksesData['mlap_peminjaman_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Peminjaman-Bulan" target="_blank">Laporan Peminjaman per Bulan</a></li>
	
	<?php } if($aksesData['mlap_peminjaman_pegawai'] == "Yes") { ?>
	<li><a href="?open=Laporan-Peminjaman-Pegawai" target="_blank">Laporan Peminjaman per Pegawai</a></li>

	<?php } ?>
</ul>
<?php
}
?>