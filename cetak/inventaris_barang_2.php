<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_inventaris_barang_2'] == "Yes") {

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
<title>:: Laporan Inventaris Barang 2</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN  INVENTARIS BARANG 2 </h2>
<table width="450" border="0"  class="table-list">
<tr>
  <td bgcolor="#F5F5F5"><strong>KETERANGAN </strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td width="97"><b>Kategori </b></td>
  <td width="15"><b>:</b></td>
  <td width="324"><?php echo $namaKategori; ?></td>
</tr>
</table>
  
<table class="table-list" width="1400" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="22" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="65" bgcolor="#F5F5F5"><strong>Kode ID </strong></td>
    <td width="180" bgcolor="#F5F5F5"><strong>Nama Barang </strong></td>
    <td width="80" bgcolor="#F5F5F5"><strong>Merek</strong></td>
    <td width="80" bgcolor="#F5F5F5"><strong>Tipe</strong></td>
    <td width="91" bgcolor="#F5F5F5"><strong>Serial <br />
      Number </strong></td>
    <td width="60" bgcolor="#F5F5F5"><strong>Th. Dtg </strong></td>
    <td width="60" bgcolor="#F5F5F5"><strong>Th. Dgn </strong></td>
    <td width="100" bgcolor="#F5F5F5"><strong>Ms. Kalibrasi </strong></td>
    <td width="110" bgcolor="#F5F5F5"><strong>No. Sertifikat <br />
      Kalibrasi</strong></td>
    <td width="110" bgcolor="#F5F5F5"><strong>Pembuat<br />
      Sertifikat</strong></td>
    <td width="89" bgcolor="#CCCCCC"><strong>Resume Barang </strong></td>
    <td width="70" bgcolor="#CCCCCC"><strong>Petugas</strong></td>
    <td width="212" bgcolor="#CCCCCC"><strong>Kondisi Barang </strong></td>
  </tr>
  <?php
	# MENAMPILKAN DATA ASET BARANG (INVENTARIS BARANG)
	$mySql = "SELECT barang_inventaris.*, barang.nm_barang, barang.merek, barang.tipe FROM barang_inventaris 
				LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
				$filterSQL ORDER BY kd_barang, kd_inventaris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$KodeInventaris = $myData['kd_inventaris'];
		
		$infoLokasi	= "";
		
		// Mencari lokasi Penempatan Barang
		if($myData['status_barang']=="Ditempatkan") {
			$my2Sql = "SELECT lokasi.nm_lokasi FROM penempatan_item as PI
						LEFT JOIN penempatan ON PI.no_penempatan=penempatan.no_penempatan
						LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
						WHERE PI.status_aktif='Yes' AND PI.kd_inventaris='$KodeInventaris'";  
			$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
			$my2Data = mysql_fetch_array($my2Qry);
			$infoLokasi	= $my2Data['nm_lokasi'];
		}
		
		// Mencari Siapa Penempatan Barang
		if($myData['status_barang']=="Dipinjam") {
			$my3Sql = "SELECT pegawai.nm_pegawai FROM peminjaman_item as PI
						LEFT JOIN peminjaman ON PI.no_peminjaman=peminjaman.no_peminjaman
						LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
						WHERE peminjaman.status_kembali='Pinjam' AND PI.kd_inventaris='$KodeInventaris'";  
			$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
			$my3Data = mysql_fetch_array($my3Qry);
			$infoLokasi	= $my3Data['nm_pegawai'];
		}
		
		// Menampilkan hasil Resume alat
		$my4Sql = "SELECT RI.*, petugas.nm_petugas FROM resume_inventaris as RI
					LEFT JOIN petugas ON RI.kd_petugas=petugas.kd_petugas
					WHERE RI.kd_inventaris='$KodeInventaris'";  
		$my4Qry = mysql_query($my4Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
		$my4Data = mysql_fetch_array($my4Qry);
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_inventaris']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['merek']; ?></td>
    <td><?php echo $myData['tipe']; ?></td>
    <td><?php echo $myData['nomor_seri']; ?></td>
    <td><?php echo $myData['tahun_datang']; ?></td>
    <td><?php echo $myData['tahun_digunakan']; ?></td>
    <td><?php echo $myData['masa_habis_kalibrasi']; ?></td>
    <td><?php echo $myData['no_sertifikat_kalibrasi']; ?></td>
    <td><?php echo $myData['pembuat_sertifikat']; ?></td>
    <td><?php echo $my4Data['hasil_resume']; ?></td>
    <td><?php echo $my4Data['nm_petugas']; ?></td>
    <td><?php echo $my4Data['kondisi_barang']; ?></td>
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
