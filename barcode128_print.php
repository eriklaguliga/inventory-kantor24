<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/bar128.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_barcode'] == "Yes") {
?>
<html>
<head>
<title> :: Cetak Label Barcode</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body,td,th {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size:12px;
}
body {
	margin-top: 1px;
}
-->
</style>

</head>
<body>
<table class="table-list" width="200" border="0" cellspacing="40" cellpadding="4">
  <tr>
<?php
$Kode  = isset($_GET['Kode']) ?  $_GET['Kode'] : ''; 
$mySql = "SELECT IB.*, barang.nm_barang, kategori.nm_kategori FROM  barang_inventaris As IB 
			LEFT JOIN barang ON IB.kd_barang=barang.kd_barang
			LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
			WHERE barang.kd_barang='$Kode'";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
$no	= 0; $lebar = 3;
while($myData = mysql_fetch_array($myQry)) {
	$no++;
?>
	<td width="201" valign="top" align="center">
	<?php 
		echo strtoupper($myData['nm_kategori']);
		echo "<br>";
		if($myData['kd_inventaris'] !="") {
			  //echo $myData['nm_barang'];
			  echo bar128(stripslashes($myData['kd_inventaris'])); 
		} 
	?></td>
<?php
	// Membuat TR tabel
	if ($no == $lebar) { echo "</tr>"; $lebar = $lebar + 3; }

} // end for
?>
</table>
</body>
</html></form><?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
