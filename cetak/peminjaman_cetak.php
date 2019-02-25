<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_peminjaman'] == "Yes") {

if($_GET) {
	# Baca variabel URL
	$noNota = $_GET['noNota'];
	
	# Perintah untuk mendapatkan data dari tabel peminjaman
	$mySql = "SELECT peminjaman.*, pegawai.nm_pegawai, petugas.nm_petugas FROM peminjaman 
				LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai 
				LEFT JOIN petugas ON peminjaman.kd_petugas=petugas.kd_petugas 
				WHERE peminjaman.no_peminjaman='$noNota'";
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
<title>:: Cetak Peminjaman - Inventory Kantor ( Aset Barang )</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> PEMINJAMAN BARANG </h2>
<table width="550" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="185"><b>No. Peminjaman </b></td>
    <td width="10"><b>:</b></td>
    <td width="327" valign="top"><strong><?php echo $myData['no_peminjaman']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Peminjaman </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($myData['tgl_peminjaman']); ?></td>
  </tr>
  <tr>
    <td><b>Tgl. Akan Kembali </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($myData['tgl_akan_kembali']); ?></td>
  </tr>
  <tr>
    <td><b>Pegawai </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['kd_pegawai']." | ".$myData['nm_pegawai']; ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td><strong>Status Kembali </strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['status_kembali']; ?></td>
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
    <td colspan="4"><strong>DAFTAR BARANG</strong></td>
  </tr>
  
  <tr>
    <td width="30" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="121" bgcolor="#F5F5F5"><strong>Kode </strong></td>
    <td width="395" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
    <td width="233" bgcolor="#F5F5F5"><strong>Kategori</strong></td>
  </tr>
  <?php
$mySql ="SELECT peminjaman_item.*, barang.nm_barang, kategori.nm_kategori FROM peminjaman_item 
		 LEFT JOIN barang_inventaris ON peminjaman_item.kd_inventaris=barang_inventaris.kd_inventaris 
		 LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
		 LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
		 WHERE peminjaman_item.no_peminjaman='$noNota' ORDER BY peminjaman_item.kd_inventaris";
$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0; 
while($myData = mysql_fetch_array($myQry)) {
	$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_inventaris']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
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