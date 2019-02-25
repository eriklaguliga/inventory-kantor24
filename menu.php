<?php
if(isset($_SESSION['SES_LOGIN'])){
# JIKA YANG LOGIN LEVEL ADMIN, menu di bawah yang dijalankan
	include_once "library/inc.hakakses.php";
?>
<ul>
	<li><a href='?open' title='Halaman Utama'>Home</a></li>
	
	<?php if($aksesData['mu_data_petugas'] == "Yes") { ?>
	<li><a href='?open=Petugas-Data' title='Petugas'>Data Petugas</a></li>
	
	<?php } if($aksesData['mu_data_pegawai'] == "Yes") { ?>
	<li><a href='?open=Pegawai-Data' title='Pegawai'>Data Pegawai</a></li>
	
	<?php } if($aksesData['mu_data_supplier'] == "Yes") { ?>
	<li><a href='?open=Supplier-Data' title='Supplier'>Data Supplier</a></li>
	
	<?php } if($aksesData['mu_data_departemen'] == "Yes") { ?>
	<li><a href='?open=Departemen-Data' title='Departemen'>Data Departemen</a></li>
	
	<?php } if($aksesData['mu_data_lokasi'] == "Yes") { ?>
	<li><a href='?open=Lokasi-Data' title='Lokasi'>Data Lokasi</a></li>
	
	<?php } if($aksesData['mu_data_kategori'] == "Yes") { ?>
	<li><a href='?open=Kategori-Data' title='Kategori'>Data Kategori</a></li>
	
	<?php } if($aksesData['mu_data_barang'] == "Yes") { ?>
	<li><a href='?open=Barang-Data' title='Barang'>Data Barang</a></li>
	
	<?php } if($aksesData['mu_data_inventaris'] == "Yes") { ?>
	<li><a href='?open=Inventaris-Data' title='Barang'>Data Inventaris</a></li>
	
	<?php } if($aksesData['mu_barcode'] == "Yes") { ?>
	<li><a href='?open=Cetak-Barcode' title='Cetak Barcode'>Tool Cetak Label</a></li>
	
	<?php } if($aksesData['mu_pencarian'] == "Yes") { ?>
	<li><a href='?open=Pencarian-Aset' title='Pencarian'>Tool Cari Aset </a></li>
	
	<?php } if($aksesData['mu_trans_pengadaan'] == "Yes") { ?>
	<li><a href='pengadaan/' title='Transaksi Pengadaan' target='_blank'>Transaksi Pengadaan</a> </li>
	
	<?php } if($aksesData['mu_trans_penempatan'] == "Yes") { ?>
	<li><a href='penempatan/' title='Transaksi Penempatan' target='_blank'>Transaksi Penempatan</a> </li>
	
	<?php } if($aksesData['mu_trans_mutasi'] == "Yes") { ?>
	<li><a href='mutasi/' title='Transaksi Mutasi' target='_blank'>Transaksi Mutasi</a> </li>
	
	<?php } if($aksesData['mu_trans_peminjaman'] == "Yes") { ?>
	<li><a href='peminjaman/' title='Transaksi Peminjaman' target='_blank'>Transaksi Peminjaman</a> </li>
	
	<?php } if($aksesData['mu_trans_pemeliharaan'] == "Yes") { ?>
	<li><a href='pemeliharaan/' title='Transaksi Pemeliharaan' target='_blank'>Transaksi Pemeliharaan</a> </li>
	
	<?php } if($aksesData['mu_laporan_cetak'] == "Yes") { ?>
	<li><a href='?open=Laporan-Cetak' title='Laporan'>Laporan & Cetak Data</a></li>
	
	<?php } if($aksesData['mu_backup_restore'] == "Yes") { ?>
	<li><a href='?open=Backup-Restore' title='Laporan'>Tools Backup & Restore</a></li>
	<?php } ?>
	<li><a href='?open=Logout' title='Logout (Exit)'>Logout</a></li>
</ul>
<?php
}
else {
# JIKA BELUM LOGIN (BELUM ADA SESION LEVEL YG DIBACA)
?>
<ul>
	<li><a href='?open=Login' title='Login System'>Login</a></li>	
</ul>
<?php
}
?>
