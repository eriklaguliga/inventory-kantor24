<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html>
<head>
<title> ::  Laporan Data Barang - Inventory Kantor ( Aset Barang )</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN DATA BARANG </h2>
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="51" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="320" bgcolor="#F5F5F5"><strong>Nama Barang</strong></td>
    <td width="166" bgcolor="#F5F5F5"><strong>Kategori</strong></td>
    <td width="71" align="right" bgcolor="#F5F5F5"><strong>Jumlah</strong></td>
    <td width="72" align="right" bgcolor="#F5F5F5"><strong> Tersedia </strong></td>
    <td width="83" align="right" bgcolor="#F5F5F5"><strong>Ditempatkan</strong></td>
    <td width="71" align="right" bgcolor="#F5F5F5"><strong>Dipinjam</strong></td>
  </tr>
  <?php
	// Skrip menampilkan data Barang, dilengkapi dengan informasi Kategori dari tabel relasi
	$mySql 	= "SELECT barang.*, kategori.nm_kategori FROM barang 
				LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
				ORDER BY barang.kd_barang ASC";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];
		
		// Membuat variabel akan diisi angka
		$jumTersedia =0;
		$jumDitempatkan =0; 
		$jumDipinjam =0;
		
		// Skrip membaca data Inventaris per Kode barang
		$my2Sql = "SELECT * FROM barang_inventaris WHERE kd_barang='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		while($my2Data = mysql_fetch_array($my2Qry)) {
			if($my2Data['status_barang']=="Tersedia") {
				$jumTersedia++;
			}
			
			if($my2Data['status_barang']=="Ditempatkan") {
				$jumDitempatkan++;
			}
			
			if($my2Data['status_barang']=="Dipinjam") {
				$jumDipinjam++;
			}			
		}
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo $jumTersedia; ?></td>
    <td align="right"><?php echo $jumDitempatkan; ?></td>
    <td align="right"><?php echo $jumDipinjam; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>