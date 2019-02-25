<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_pengadaan_barang_kategori'] == "Yes") {

// baca kategori filter dari URL
$dataKategori 	= isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
$dataTahun 		= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

# MEMBUAT SUB SQL FILTER
if(trim($dataKategori)=="Semua") {
	// Semua Kategori
	$filterSQL 	= "AND LEFT(tgl_pengadaan,4)='$dataTahun'";
}
else {
	// Kategori terpilih, dan Tahun Terpilih
	$filterSQL 	= " AND barang.kd_kategori ='$dataKategori' AND LEFT(pengadaan.tgl_pengadaan,4)='$dataTahun'";

	# Baca nama Kategori
	$infoSql 	= "SELECT * FROM kategori WHERE kd_kategori='$dataKategori'";
	$infoQry 	= mysql_query($infoSql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$kolomData 	= mysql_fetch_array($infoQry);
	$infoKategori = $kolomData['nm_kategori'];
}
?>
<html>
<head>
<title>:: Laporan pengadaan Barang Per Kategori - Inventory Kantor (Aset Barang)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body onLoad="window.print()">
<h2>LAPORAN PENGADAAN BARANG PER KATEGORI </h2>
<table width="500" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="110"><strong> Kategori  </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="361"><?php echo $infoKategori; ?></td>
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
    <td width="34" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="72" bgcolor="#F5F5F5"><strong>Tanggal</strong></td>
    <td width="94" bgcolor="#F5F5F5"><strong>No. Pengadaan</strong></td>
    <td width="61" bgcolor="#F5F5F5"><strong>Kode </strong></td>
    <td width="338" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
    <td width="106" align="right" bgcolor="#F5F5F5"><b> Hrg. Beli (Rp)</b></td>
    <td width="48" align="center" bgcolor="#F5F5F5"><b>Jumlah</b></td>
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
    <td align="center"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subTotal); ?></td>
  </tr>
  <?php 
}?>
  <tr>
    <td colspan="6" align="right"><b> GRAND TOTAL : </b></td>
    <td align="center" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBarang); ?></strong></td>
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