<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_pelanggan'] == "Yes") {
?>
<html>
<head>
<title>:: Laporan Data Pelanggan - Inventory Kantor ( Aset Kantor )</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> LAPORAN DATA PELANGGAN </h2>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="150" bgcolor="#CCCCCC"><strong>Nama Pelanggan </strong></td>
    <td width="132" bgcolor="#CCCCCC"><strong>Nama Toko </strong></td>
    <td width="363" bgcolor="#CCCCCC"><strong>Alamat Lengkap </strong></td>
    <td width="104" bgcolor="#CCCCCC"><strong>No. Telepon </strong></td>
  </tr>
  <?php
  	// Menampilkan data Pelanggan
	$mySql = "SELECT * FROM pelanggan ORDER BY kd_pelanggan ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
  ?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['nm_pelanggan']; ?></td>
    <td><?php echo $myData['nm_toko']; ?></td>
    <td><?php echo $myData['alamat']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html><?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
