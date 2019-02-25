<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_barang'] == "Yes") {

// Menampilkan data Barang, dilengkapi informasi Kategori dari tabel relasi
$Kode	= isset($_GET['Kode']) ? $_GET['Kode'] : '-';
$infoSql= "SELECT barang.*, kategori.nm_kategori FROM barang 
			LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
			WHERE barang.kd_barang='$Kode'";
$infoQry= mysql_query($infoSql, $koneksidb);
$infoData= mysql_fetch_array($infoQry);
?>
<html>
<head>
<title>::  Detil Barang - Inventory Kantor ( Aset Barang )</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>VIEW DETIL BARANG  </h2>
<table width="800" border="0" cellpadding="2" cellspacing="1" class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><b>DATA BARANG </b></td>
  </tr>
  <tr>
    <td width="186"><strong>Kode</strong></td>
    <td width="5"><b>:</b></td>
    <td width="1007"><?php echo $infoData['kd_barang']; ?></td>
  </tr>
  <tr>
    <td><strong>Nama Barang </strong></td>
    <td><b>:</b></td>
    <td><?php echo $infoData['nm_barang']; ?></td>
  </tr>
  <tr>
    <td><strong>Kategori</strong></td>
    <td><b>:</b></td>
    <td><?php echo $infoData['nm_kategori']; ?></td>
  </tr>
  <tr>
    <td><strong>Jumlah</strong></td>
    <td><b>:</b></td>
    <td><?php echo format_angka($infoData['jumlah']); ?></td>
  </tr>
  <tr>
    <td><strong>Merek</strong></td>
    <td><b>:</b></td>
    <td><?php echo $infoData['merek']; ?></td>
  </tr>
  <tr>
    <td><strong>Tipe</strong></td>
    <td><b>:</b></td>
    <td><?php echo $infoData['tipe']; ?></td>
  </tr>
  <tr>
    <td><strong>Satuan</strong></td>
    <td><b>:</b></td>
    <td><?php echo $infoData['satuan']; ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td><?php echo $infoData['keterangan']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="7"><strong>DAFTAR INVENTARIS</strong> </td>
  </tr>
  <tr>
    <td width="21" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="123" bgcolor="#F5F5F5"><strong>Kode Inventaris</strong></td>
    <td width="150" bgcolor="#F5F5F5"><strong>Nomor Seri </strong></td>
    <td width="50" bgcolor="#F5F5F5"><strong>Th. Dtg</strong> </td>
    <td width="50" bgcolor="#F5F5F5"><strong>Th. Dgn </strong></td>
    <td width="90" bgcolor="#F5F5F5"><strong>Status</strong></td>
    <td width="180" bgcolor="#F5F5F5"><strong>Lokasi</strong></td>
  </tr>
  <?php
	// Skrip menampilkan daftar Inventaris Aset Barang per Barang
	$mySql = "SELECT * FROM barang_inventaris WHERE kd_barang='$Kode'";  
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$KodeInventory = $myData['kd_inventaris'];
		
		$infoLokasi	= "";
		
		// Mencari lokasi Penempatan Barang
		if($myData['status_barang']=="Ditempatkan") {
			$my2Sql = "SELECT lokasi.nm_lokasi FROM penempatan_item as PI
						LEFT JOIN penempatan ON PI.no_penempatan=penempatan.no_penempatan
						LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
						WHERE PI.status_aktif='Yes' AND PI.kd_inventaris='$KodeInventory'";  
			$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
			$my2Data = mysql_fetch_array($my2Qry);
			$infoLokasi	= $my2Data['nm_lokasi'];
		}
		
		// Mencari Siapa Penempatan Barang
		if($myData['status_barang']=="Dipinjam") {
			$my3Sql = "SELECT pegawai.nm_pegawai FROM peminjaman_item as PI
						LEFT JOIN peminjaman ON PI.no_peminjaman=peminjaman.no_peminjaman
						LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
						WHERE peminjaman.status_kembali='Pinjam' AND PI.kd_inventaris='$KodeInventory'";  
			$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
			$my3Data = mysql_fetch_array($my3Qry);
			$infoLokasi	= $my3Data['nm_pegawai'];
		}
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_inventaris']; ?></td>
    <td><?php echo $myData['nomor_seri']; ?></td>
    <td><?php echo $myData['tahun_datang']; ?></td>
    <td><?php echo $myData['tahun_digunakan']; ?></td>
    <td><?php echo $myData['status_barang']; ?></td>
    <td><?php echo $infoLokasi; ?></td>
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
