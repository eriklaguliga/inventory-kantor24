<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_departemen'] == "Yes") {

?>
<html>
<head>
<title>:: Laporan Data Departemen - Inventory Kantor ( Aset Barang )</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> LAPORAN DATA DEPARTEMEN </h2>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="56" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="248" bgcolor="#F5F5F5"><b>Nama Departemen </b></td>
    <td width="369" bgcolor="#F5F5F5"><strong>Keterangan</strong></td>
    <td width="76" align="right" bgcolor="#F5F5F5"><b>Qty Lokasi </b> </td>
  </tr>
  <?php
	  // Menampilkan data Departemen
	$mySql = "SELECT * FROM departemen ORDER BY kd_departemen ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_departemen'];
		
		// Menghitung jumlah lokasi per departemen
		$my2Sql = "SELECT COUNT(*) As qty_lokasi FROM lokasi WHERE kd_departemen='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
  ?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_departemen']; ?></td>
    <td><?php echo $myData['nm_departemen']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo $my2Data['qty_lokasi']; ?></td>
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
