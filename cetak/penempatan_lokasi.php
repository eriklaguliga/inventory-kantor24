<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_penempatan_lokasi'] == "Yes") {

// Variabel SQL
$filterSQL	= "";

// Temporary Variabel form
$kodeLokasi	= isset($_GET['kodeLokasi']) ? $_GET['kodeLokasi'] : 'SEMUA';

// PILIH KATEGORI
if ($kodeLokasi =="SEMUA") {
	$filterSQL = "";
	$namaLokasi= "SEMUA";
}
else {
	// SQL filter data
	$filterSQL = "WHERE penempatan.kd_lokasi='$kodeLokasi'";
	
	// Mendapatkan informasi nama lokasi
	$infoSql = "SELECT nm_lokasi FROM lokasi WHERE kd_lokasi='$kodeLokasi'";
	$infoQry = mysql_query($infoSql, $koneksidb);
	$infoData= mysql_fetch_array($infoQry);
	$namaLokasi= $infoData['nm_lokasi'];
}
?>
<html>
<head>
<title>:: Laporan Penempatan per Lokasi - INVENTORY BARANG</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body onLoad="window.print()">
<h2>LAPORAN PENEMPATAN LOKASI </h2>
<table width="500" border="0"  class="table-list">
  
  <tr>
    <td bgcolor="#F5F5F5"><strong>KETERANGAN </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="132"><b>Nama lokasi </b></td>
    <td width="5"><b>:</b></td>
    <td width="349"><?php echo $namaLokasi; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="35" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="91" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="132" bgcolor="#CCCCCC"><strong>No. Penempatan</strong></td>
    <td width="205" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="213" bgcolor="#CCCCCC"><strong>Lokasi</strong></td>
    <td width="93" align="right" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
  </tr>
  <?php
	# Perintah untuk menampilkan Semua Daftar Transaksi Penempatan
	$mySql = "SELECT penempatan.*, lokasi.nm_lokasi FROM penempatan 
				LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi 
				$filterSQL
				ORDER BY penempatan.no_penempatan DESC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		# Membaca Kode penempatan/ Nomor transaksi
		$noNota = $myData['no_penempatan'];
		
		# Menghitung Total Barang yang ditempatkan dilokasi terpilih
		$my2Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item WHERE AND no_penempatan='$noNota'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penempatan']); ?></td>
    <td><?php echo $myData['no_penempatan']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td><?php echo $myData['nm_lokasi']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
  </tr>
  <?php } ?>
</table>
</body>
</html><?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>