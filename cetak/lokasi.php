<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_lokasi'] == "Yes") {

?>
<html>
<head>
<title>:: Laporan Data Lokasi - Inventory Kantor ( Aset Barang )</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> LAPORAN DATA LOKASI </h2>
<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="44" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="317" bgcolor="#F5F5F5"><b>Nama Lokasi </b></td>
    <td width="293" bgcolor="#F5F5F5"><b>Departemen </b></td>
  </tr>
  <?php
	  // Menampilkan data Lokasi, dilengkapi informasi nama Departemen dari tabel relasi
	$mySql = "SELECT lokasi.*, departemen.nm_departemen FROM lokasi 
				LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
				ORDER BY kd_lokasi ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_lokasi'];
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_lokasi']; ?></td>
    <td><?php echo $myData['nm_lokasi']; ?></td>
    <td><?php echo $myData['nm_departemen']; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
