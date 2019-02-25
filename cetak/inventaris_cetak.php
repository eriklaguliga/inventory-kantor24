<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_inventaris'] == "Yes") {

// Menampilkan data Barang, dilengkapi informasi Kategori dari tabel relasi
$Kode		= isset($_GET['Kode']) ? $_GET['Kode'] : '-';
$infoSql 	= "SELECT IB.*, barang.nm_barang, barang.merek, barang.tipe FROM barang_inventaris As IB 
			LEFT JOIN barang ON IB.kd_barang = barang.kd_barang
			WHERE IB.kd_barang='$Kode'";  
$infoQry	= mysql_query($infoSql, $koneksidb);
$infoData	= mysql_fetch_array($infoQry);
?>
<html>
<head>
<title>::  Detil Barang - Inventory Kantor ( Aset Barang )</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>DETIL ASET </h2>
<table width="800" border="0" cellpadding="2" cellspacing="1" class="table-list">
  <tr>
    <td bgcolor="#F5F5F5"><b>DETIL  BARANG </b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Kode</strong></td>
    <td><b>:</b></td>
    <td><?php echo $infoData['kd_barang']; ?></td>
  </tr>
  <tr>
    <td width="184"><strong>Nama Barang </strong></td>
    <td width="5"><b>:</b></td>
    <td width="595"><?php echo $infoData['nm_barang']; ?></td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="184"><strong>Kode Aset </strong></td>
    <td width="5"><strong>:</strong></td>
    <td><?php echo $infoData['kd_inventaris']; ?></td>
  </tr>
  <tr>
    <td><b>Tahun Datang </b></td>
    <td><b>:</b></td>
    <td><?php echo $infoData['tahun_datang']; ?></td>
  </tr>
  <tr>
    <td><b>Tahun Digunakan</b></td>
    <td><b>:</b></td>
    <td><?php echo $infoData['tahun_digunakan']; ?></td>
  </tr>
  <tr>
    <td><b>Nomor Seri</b></td>
    <td><b>:</b></td>
    <td><?php echo $infoData['nomor_seri']; ?></td>
  </tr>
  <tr>
    <td><b>Masa Habis Kalibrasi </b></td>
    <td><strong>:</strong></td>
    <td><?php echo $infoData['masa_habis_kalibrasi']; ?></td>
  </tr>
  <tr>
    <td><b>No. Sertifikat  Kalibrasi </b></td>
    <td><strong>:</strong></td>
    <td><?php echo $infoData['no_sertifikat_kalibrasi']; ?></td>
  </tr>
  <tr>
    <td><b>Pembuat Sertifikat </b></td>
    <td><strong>:</strong></td>
    <td><?php echo $infoData['pembuat_sertifikat']; ?></td>
  </tr>
  <tr>
    <td><b>Harga Barang (Rp.) </b></td>
    <td><strong>:</strong></td>
    <td><?php echo format_angka($infoData['harga_barang']); ?></td>
  </tr>
  <tr>
    <td><b>Keterangan</b></td>
    <td><strong>:</strong></td>
    <td><?php echo $infoData['keterangan']; ?></td>
  </tr>
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
