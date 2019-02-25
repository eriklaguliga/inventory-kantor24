<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_barang_lokasi'] == "Yes") {

// Variabel SQL
$filterSQL	= "";

// Temporary Variabel form
$kodeLokasi	= isset($_GET['kodeLokasi']) ? $_GET['kodeLokasi'] : 'Semua';

// PILIH lokasi
if ($kodeLokasi =="Semua") {
	$filterSQL 		= "";
	$namaDepartemen	= "Semua";
	$namaLokasi		= "Semua";
}
else {
	// SQL filter data
	$filterSQL = " AND penempatan.kd_lokasi='$kodeLokasi'";
	
	// Mendapatkan informasi nama Departemen dan Lokasi
	$infoSql = "SELECT lokasi.nm_lokasi, departemen.nm_departemen FROM lokasi 
				LEFT JOIN departemen ON lokasi.kd_departemen = departemen.kd_departemen
				WHERE lokasi.kd_lokasi='$kodeLokasi'";
	$infoQry = mysql_query($infoSql, $koneksidb);
	$infoData= mysql_fetch_array($infoQry);
	
	// Informasi
	$namaDepartemen = $infoData['nm_departemen'];
	$namaLokasi		= $infoData['nm_lokasi'];
}
?>
<html>
<head>
<title> :: Daftar Barang Inventaris per Lokasi - Inventory Kantor ( Aset Barang )</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN  DATA BARANG INVENTARIS PER LOKASI </h2>
<table width="450" border="0"  class="table-list">
<tr>
  <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN </strong></td>
</tr>
<tr>
  <td><b>Departemen </b></td>
  <td><b>:</b></td>
  <td><?php echo $namaDepartemen; ?></td>
</tr>
<tr>
  <td width="97"><b>Lokasi </b></td>
  <td width="15"><b>:</b></td>
  <td width="324"><?php echo $namaLokasi; ?></td>
</tr>
</table>
  
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="27" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="91" bgcolor="#F5F5F5"><strong>Kode Label </strong></td>
    <td width="418" bgcolor="#F5F5F5"><strong>Nama Barang</strong></td>
    <td width="131" bgcolor="#F5F5F5"><strong>Kategori</strong></td>
    <td width="126" bgcolor="#F5F5F5"><strong>Merek</strong></td>
    <td width="76" bgcolor="#F5F5F5"><strong>Satuan</strong></td>
  </tr>
  <?php
	# Skrip enampilkan daftar nama barang yang ada di setiap Lokasi Penempatan
	$mySql 	= "SELECT Pi.kd_inventaris, barang.*, kategori.nm_kategori FROM penempatan_item as Pi
					LEFT JOIN penempatan ON Pi.no_penempatan=penempatan.no_penempatan 
					LEFT JOIN barang_inventaris ON Pi.kd_inventaris=barang_inventaris.kd_inventaris
					LEFT JOIN barang ON barang.kd_barang=barang_inventaris.kd_barang
					LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
				WHERE Pi.status_aktif='Yes' $filterSQL
				GROUP BY barang.kd_barang
				ORDER BY Pi.kd_inventaris ASC";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_inventaris']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
    <td><?php echo $myData['merek']; ?></td>
    <td><?php echo $myData['satuan']; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html><?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
