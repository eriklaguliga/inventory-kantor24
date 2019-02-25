<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_mutasi'] == "Yes") {

if($_GET) {
	# Baca variabel URL
	$noMutasi = $_GET['noMutasi'];
	
	// Perintah untuk mendapatkan data dari tabel Mutasi
	$mySql = "SELECT mutasi.*, mutasi_tujuan.no_penempatan, petugas.nm_petugas FROM mutasi 
				LEFT JOIN mutasi_tujuan ON mutasi.no_mutasi = mutasi_tujuan.no_mutasi 
				LEFT JOIN petugas ON mutasi.kd_petugas = petugas.kd_petugas 
				WHERE mutasi.no_mutasi='$noMutasi'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$myData = mysql_fetch_array($myQry);
	
	# Perintah untuk mendapatkan data dari hasil Penempatan Baru
	$noPenempatan	= $myData['no_penempatan'];
	$my2Sql = "SELECT penempatan.*, lokasi.nm_lokasi FROM penempatan 
				LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi 
				WHERE penempatan.no_penempatan='$noPenempatan'";
	$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$my2Data = mysql_fetch_array($my2Qry);
}
else {
	$noMutasi	= "";
	echo "Nomor Transaksi Tidak Terbaca";
	exit;
}
?>
<html>
<head>
<title>:: Cetak Mutasi - Inventory Kantor (Aset Kantor)</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2> MUTASI BARANG </h2>
<table width="900" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td><strong>No. Mutasi </strong></td>
    <td><b>:</b></td>
    <td valign="top"><strong><?php echo $myData['no_mutasi']; ?></strong></td>
  </tr>
  <tr>
    <td><strong>Tgl. Mutasi </strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($myData['tgl_mutasi']); ?></td>
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
    <td bgcolor="#F5F5F5"><strong>PENEMPATAN</strong></td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="179"><b>No. Penempatan </b></td>
    <td width="10"><b>:</b></td>
    <td width="683" valign="top"><strong><?php echo $myData['no_penempatan']; ?></strong></td>
  </tr>
  <tr>
    <td><strong>Lokasi Baru </strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $my2Data['nm_lokasi']; ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="4"><strong>DATA BARANG</strong></td>
  </tr>
  
  <tr>
    <td width="26" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="106" bgcolor="#F5F5F5"><strong>Kode </strong></td>
    <td width="466" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
    <td width="181" bgcolor="#F5F5F5"><strong>Lokasi Lama </strong></td>
  </tr>
  <?php
  // Menampilkan data barang yang dimutasi (dipindah), lengkap dengan Lokasi lama sebelum dipindah
  $mySql = "SELECT barang.nm_barang, lokasi.nm_lokasi, mutasi_asal.* FROM mutasi_asal
  			LEFT JOIN penempatan ON mutasi_asal.no_penempatan = penempatan.no_penempatan
			LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
			LEFT JOIN barang_inventaris ON mutasi_asal.kd_inventaris = barang_inventaris.kd_inventaris
			LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
			WHERE mutasi_asal.no_mutasi ='$noMutasi' ";
$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0; 
while($myData = mysql_fetch_array($myQry)) {
	$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_inventaris']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_lokasi']; ?></td>
  </tr>
  <?php 
}?>
</table>
<br/>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html><?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
