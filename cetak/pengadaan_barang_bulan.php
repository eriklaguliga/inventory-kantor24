<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_pengadaan_barang_bulan'] == "Yes") {

// Membaca variabel dari URL
$dataTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataBulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');

// Daftar nama bulan
$listBulan = array("00" => "", "01" => "Januari", "02" => "Februari", "03" => "Maret",
			 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
			 "08" => "Agustus", "09" => "September", "10" => "Oktober",
			 "11" => "November", "12" => "Desember");

# MEMBUAT SQL FILTER PER BULAN & TAHUN
if($dataBulan and $dataTahun) {
	if($dataBulan=="00") {
		// Filter tahun
		$filterSQL	= "AND LEFT(pengadaan.tgl_pengadaan,4)='$dataTahun'";
		
		$infoBulan	= "";
	}
	else {
		// Filter bulan dan tahun
		$filterSQL = "AND MID(pengadaan.tgl_pengadaan,6,2)='$dataBulan' AND LEFT(pengadaan.tgl_pengadaan,4)='$dataTahun'";
		
		$infoBulan	= $listBulan[$dataBulan].", ";
	}
}
else {
	$filterSQL = "";
}
?>
<html>
<head>
<title>:: Laporan Pengadaan Barang Per Bulan - Inventory Kantor (Aset Barang)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body onLoad="window.print()">
<h2>LAPORAN PENGADAAN BARANG PER BULAN </h2>
<table width="500" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="134"><strong>Bulan Pengadaan</strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $infoBulan.$dataTahun; ?></td>
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
    <td colspan="6" align="right"><b> Grand Total   : </b></td>
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