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
$kodeKategori	= isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';

// PILIH KATEGORI
if ($kodeKategori =="Semua") {
	$filterSQL = "";
	$namaKategori= "Semua";
}
else {
	// SQL filter data
	$filterSQL = "WHERE barang.kd_kategori='$kodeKategori'";
	
	// Mendapatkan informasi nama kategori
	$infoSql = "SELECT nm_kategori FROM kategori WHERE kd_kategori='$kodeKategori'";
	$infoQry = mysql_query($infoSql, $koneksidb);
	$infoData= mysql_fetch_array($infoQry);
	$namaKategori= $infoData['nm_kategori'];
}
?>
<html>
<head>
<title> :: Daftar Barang per Kategori - Inventory Kantor ( Aset Barang )</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN  DATA BARANG PER KATEGORI </h2>
<table width="450" border="0"  class="table-list">
<tr>
  <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN </strong></td>
</tr>
<tr>
  <td width="99"><b>Nama Kategori </b></td>
  <td width="15"><b>:</b></td>
  <td width="322"><?php echo $namaKategori; ?></td>
</tr>
</table>
  
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="54" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="298" bgcolor="#F5F5F5"><strong>Nama Barang</strong></td>
    <td width="165" bgcolor="#F5F5F5"><strong>Merek</strong></td>
    <td width="73" align="right" bgcolor="#F5F5F5"><strong>Jumlah</strong></td>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong> Tersedia </strong></td>
    <td width="85" align="right" bgcolor="#F5F5F5"><strong>Ditempatkan</strong></td>
    <td width="81" align="right" bgcolor="#F5F5F5"><strong>Dipinjam</strong></td>
  </tr>
  <?php
	// Skrip menampilkan data Barang dengan filter Kategori
	$mySql 	= "SELECT * FROM barang $filterSQL ORDER BY barang.kd_barang ASC";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];
		
		// Membuat variabel akan diisi angka
		$jumTersedia =0;
		$jumDitempatkan =0; 
		$jumDipinjam =0;
		
		// Query menampilkan data Inventaris per Kode barang
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
    <td><?php echo $myData['merek']; ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo $jumTersedia; ?></td>
    <td align="right"><?php echo $jumDitempatkan; ?></td>
    <td align="right"><?php echo $jumDipinjam; ?></td>
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
