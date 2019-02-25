<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_pengadaan_barang_supplier'] == "Yes") {

// Baca variabel filter dari URL
$dataSupplier 	= isset($_GET['kodeSupplier']) ? $_GET['kodeSupplier'] : 'Semua';
$dataTahun 		= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

# MEMBUAT SUB SQL FILTER
if(trim($dataSupplier)=="Semua") {
	// Semua Supplier
	$filterSQL 	= "AND LEFT(tgl_pengadaan,4)='$dataTahun'";
}
else {
	// Supplier terpilih, dan Tahun Terpilih
	$filterSQL 	= " AND pengadaan.kd_supplier ='$dataSupplier' AND LEFT(pengadaan.tgl_pengadaan,4)='$dataTahun'";

	# Baca nama Supplier
	$infoSql 	= "SELECT * FROM supplier WHERE kd_supplier='$dataSupplier'";
	$infoQry 	= mysql_query($infoSql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$kolomData 	= mysql_fetch_array($infoQry);
	$infoSupplier = $kolomData['nm_supplier'];
}
?>
<html>
<head>
<title>:: Laporan Pengadaan Barang Per Supplier - Inventory Kantor (Aset Kantor)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body onLoad="window.print()">
<h2>LAPORAN PENGADAAN BARANG PER SUPPLIER </h2>
<table width="500" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="138"><strong> Supplier </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="333"><?php echo $infoSupplier; ?></td>
  </tr>
  <tr>
    <td><strong>Tahun </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo  $dataTahun; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  
  <tr>
    <td width="29" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="73" bgcolor="#F5F5F5"><strong>Tanggal</strong></td>
    <td width="98" bgcolor="#F5F5F5"><strong>No. Pengadaan</strong></td>
    <td width="61" bgcolor="#F5F5F5"><strong>Kode </strong></td>
    <td width="338" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
    <td width="106" align="right" bgcolor="#F5F5F5"><b> Hrg. Beli (Rp)</b></td>
    <td width="48" align="right" bgcolor="#F5F5F5"><b>Jumlah</b></td>
    <td width="106" align="right" bgcolor="#F5F5F5"><strong> Tot. Harga(Rp)</strong></td>
  </tr>
  <?php
  	// deklarasi variabel
	$subTotal 		= 0; 
	$totalHarga 	= 0; 
	$totalBarang 	= 0;  
	
	//  Perintah SQL menampilkan data barang daftar pengadaan
	$mySql ="SELECT pengadaan_item.*, pengadaan.tgl_pengadaan, barang.nm_barang 
			 FROM pengadaan, pengadaan_item
			 	LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang 
			 WHERE pengadaan.no_pengadaan=pengadaan_item.no_pengadaan 
			 $filterSQL
			 ORDER BY pengadaan.tgl_pengadaan";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	$nomor  = 0;   
	while($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$subTotal 	= $myData['harga_beli'] * $myData['jumlah'];
		$totalHarga	= $totalHarga + $subTotal;
		$totalBarang= $totalBarang + $myData['jumlah'];
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pengadaan']); ?></td>
    <td><?php echo $myData['no_pengadaan']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subTotal); ?></td>
  </tr>
  <?php 
}?>
  <tr>
    <td colspan="6" align="right"><b> Grand Total  : </b></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#F5F5F5">Rp. <strong><?php echo format_angka($totalHarga); ?></strong></td>
  </tr>
</table>
</body>
</html><?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>