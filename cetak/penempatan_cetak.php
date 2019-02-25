<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_penempatan'] == "Yes") {

if($_GET) {
	# Baca variabel URL
	$noNota = $_GET['noNota'];
	
	# Perintah untuk mendapatkan data dari tabel penempatan
	$mySql = "SELECT penempatan.*, lokasi.nm_lokasi, petugas.nm_petugas FROM penempatan 
				LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi 
				LEFT JOIN petugas ON penempatan.kd_petugas=petugas.kd_petugas 
				WHERE penempatan.no_penempatan='$noNota'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$myData = mysql_fetch_array($myQry);
}
else {
	echo "Nomor Transaksi Tidak Terbaca";
	exit;
}
?>
<html>
<head>
<title>:: Cetak Penempatan - Inventory Kantor ( Aset Barang )</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> PENEMPATAN BARANG </h2>
<table width="800" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="181"><b>No. Penempatan </b></td>
    <td width="10"><b>:</b></td>
    <td width="581" valign="top"><strong><?php echo $myData['no_penempatan']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Penempatan </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($myData['tgl_penempatan']); ?></td>
  </tr>
  <tr>
    <td><b>Lokasi </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['nm_lokasi']; ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td><strong>Petugas</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['nm_petugas']; ?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="5"><strong>DAFTAR BARANG</strong></td>
  </tr>
  
  <tr>
    <td width="29" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="95" bgcolor="#F5F5F5"><strong>Kode </strong></td>
    <td width="348" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
    <td width="196" bgcolor="#F5F5F5"><strong>Kategori</strong></td>
    <td width="106" bgcolor="#F5F5F5"><strong>Status </strong></td>
  </tr>
  <?php
$mySql ="SELECT penempatan_item.*, barang.nm_barang, barang.merek, kategori.nm_kategori FROM penempatan_item 
		 LEFT JOIN barang_inventaris ON penempatan_item.kd_inventaris=barang_inventaris.kd_inventaris 
		 LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
		 LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
		 WHERE penempatan_item.no_penempatan='$noNota'  ORDER BY penempatan_item.kd_inventaris";
$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0; 
while($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	
	// Status barang (masih pada lokasi tersebut atau sudah dipindah/mutasi)
	if($myData['status_aktif'] =="Yes") {
		$status	= "Aktif";
	}
	else {
		$status	= "Tidak Aktif";
	}
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_inventaris']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
    <td><?php echo $status; ?></td>
  </tr>
  <?php 
}?>
</table>
<p>&nbsp;</p>
<p><strong>KETERANGAN</strong></p>
<p>Pada <strong>Status</strong>, jika<strong> Yes (Aktif)</strong> berarti posisi barang masih ditempatkan pada Lokasi tersebut. Sedangkan jika <strong>No (Tidak Aktif)</strong>, maka poisisi barang sudah dipindahkan (mutasi). <br/>
  <img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</p>
</body>
</html><?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>