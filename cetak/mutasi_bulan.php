<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_mutasi_bulan'] == "Yes") {

// Membuat daftar bulan
$listBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret",
				 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
				 "08" => "Agustus", "09" => "September", "10" => "Oktober",
				 "11" => "November", "12" => "Desember");

// Membaca data Bulan dan Tahun dari URL
$dataTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataBulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');

if($dataBulan and $dataTahun) {
	if($dataBulan=="00") {
		// Filter tahun
		$filterSQL	= "WHERE LEFT(tgl_mutasi,4)='$dataTahun'";
		
		$infoBulan	= "";
	}
	else {
		// Filter bulan dan tahun
		$filterSQL = "WHERE MID(tgl_mutasi,6,2)='$dataBulan' AND LEFT(tgl_mutasi,4)='$dataTahun'";
		
		$infoBulan	= $listBulan[$dataBulan].", ";
	}
}
else {
	$filterSQL = "";
}
?>
<html>
<head>
<title>:: Laporan Mutasi per Bulan & Tahun - Inventory Kantor (Aset Barang)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body >
<h2>LAPORAN MUTASI PER BULAN & TAHUN</h2>
<table width="500" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN </strong></td>
  </tr>
  <tr>
    <td width="132"><strong> Bulan Penempatan </strong></td>
    <td width="5"><strong>:</strong></td>
    <td width="349"><?php echo $infoBulan.$dataTahun; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="35" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="72" bgcolor="#F5F5F5"><strong>Tanggal</strong></td>
    <td width="106" bgcolor="#F5F5F5"><strong>No. Mutasi</strong></td>
    <td width="151" bgcolor="#F5F5F5"><strong>Lokasi Lama </strong></td>
    <td width="106" bgcolor="#F5F5F5"><strong>No. Penempatan </strong></td>
    <td width="145" bgcolor="#F5F5F5"><strong>Lokasi Baru </strong></td>
    <td width="168" bgcolor="#F5F5F5"><strong>Keterangan</strong></td>
    <td width="76" align="right" bgcolor="#F5F5F5"><strong>Qty Barang</strong></td>
  </tr>
  <?php
	// Skrip untuk menampilkan data Mutasi dengan filter Bulan dan Tahun, informasi dilengkapi data Lokasi
	$mySql = "SELECT * FROM mutasi $filterSQL ORDER BY  no_mutasi DESC ";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		# Membaca Kode mutasi/ Nomor transaksi
		$noMutasi = $myData['no_mutasi'];

		// Membaca informasi penempatan lama (Lama)
		$my2Sql	= "SELECT lokasi.nm_lokasi  FROM mutasi_asal 
					LEFT JOIN penempatan ON mutasi_asal.no_penempatan = penempatan.no_penempatan
					LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
					WHERE mutasi_asal.no_mutasi = '$noMutasi'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 3 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry); 


		// Membaca informasi penempatan baru (Tujuan)
		$my3Sql	= "SELECT mutasi_tujuan.*, lokasi.nm_lokasi FROM mutasi_tujuan 
					LEFT JOIN penempatan ON mutasi_tujuan.no_penempatan = penempatan.no_penempatan
					LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
					WHERE mutasi_tujuan.no_mutasi = '$noMutasi'";
		$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my3Data = mysql_fetch_array($my3Qry); 
		
		# Menghitung Total barang yang dimutasi setiap nomor transaksi
		$my4Sql = "SELECT COUNT(*) AS total_barang FROM mutasi_asal WHERE no_mutasi='$noMutasi'";
		$my4Qry = mysql_query($my4Sql, $koneksidb)  or die ("Query 4 salah : ".mysql_error());
		$my4Data = mysql_fetch_array($my4Qry);
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_mutasi']); ?></td>
    <td><?php echo $myData['no_mutasi']; ?></td>
    <td><?php echo $my3Data['nm_lokasi']; ?></td>
    <td><?php echo $my3Data['no_mutasi']; ?></td>
    <td><?php echo $my2Data['nm_lokasi']; ?></td>
    <td><?php echo $my3Data['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($my4Data['total_barang']); ?></td>
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
