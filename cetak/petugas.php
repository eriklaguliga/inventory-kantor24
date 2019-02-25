<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_petugas'] == "Yes") {

?>
<html>
<head>
<title> :: Laporan Data Petugas - Inventory Kantor ( Aset Kantor )</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> LAPORAN DATA PETUGAS </h2>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="32" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="51" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="324" bgcolor="#F5F5F5"><strong>Nama Petugas</strong></td>
    <td width="51" bgcolor="#F5F5F5"><strong>L/ P </strong></td>
    <td width="119" bgcolor="#F5F5F5"><b>No. Telepon </b></td>
    <td width="112" bgcolor="#F5F5F5"><strong>Username</strong></td>
    <td width="75" bgcolor="#F5F5F5"><strong>Level</strong></td>
  </tr>
  <?php
  	// Menampilkan data Petugas
	$mySql = "SELECT * FROM petugas ORDER BY kd_petugas ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor	 = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_petugas']; ?></td>
    <td><?php echo $myData['nm_petugas']; ?></td>
    <td><?php echo $myData['kelamin']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
    <td><?php echo $myData['username']; ?></td>
    <td><?php echo $myData['level']; ?></td>
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