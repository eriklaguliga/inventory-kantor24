<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_pengadaan'] == "Yes") {

if($_GET) {
	# Baca variabel URL
	$Kode = $_GET['Kode'];
	
	# Perintah untuk mendapatkan data dari tabel pengadaan
	$mySql = "SELECT pengadaan.*, supplier.nm_supplier, petugas.nm_petugas FROM pengadaan 
				LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier 
				LEFT JOIN petugas ON pengadaan.kd_petugas=petugas.kd_petugas 
				WHERE pengadaan.no_pengadaan='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$myData = mysql_fetch_array($myQry);
}
else {
	echo "Nomor Transaksi Tidak Terbaca";
	exit;
}
?>
<html>
<head>
<title>:: Cetak Pengadaan - Inventory Kantor ( Aset Kantor )</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> PENGADAAN BARANG </h2>
<table width="500" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="160"><b>No. Pengadaan </b></td>
    <td width="10"><b>:</b></td>
    <td width="302" valign="top"><strong><?php echo $myData['no_pengadaan']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Pengadaan </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($myData['tgl_pengadaan']); ?></td>
  </tr>
  <tr>
    <td><b>Supplier</b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['nm_supplier']; ?></td>
  </tr>
  <tr>
    <td><strong>Jenis Pengadaan </strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['jenis_pengadaan']; ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td><strong>Petugas Input </strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['nm_petugas']; ?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="7"><strong>DATA BARANG</strong></td>
  </tr>
  
  <tr>
    <td width="28" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="50" bgcolor="#F5F5F5"><strong>Kode </strong></td>
    <td width="269" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
    <td width="247" bgcolor="#F5F5F5"><strong>Deskripsi</strong></td>
    <td width="114" align="center" bgcolor="#F5F5F5"><strong>Hrg. Beli(Rp)</strong></td>
    <td width="48" align="right" bgcolor="#F5F5F5"><b>Jumlah</b></td>
    <td width="108" align="center" bgcolor="#F5F5F5"><strong>Hrg. Total(Rp)</strong> </td>
  </tr>
  <?php
$subTotalBeli=0; 
$grandTotalBeli = 0; 
$totalBarang = 0; 

$mySql ="SELECT pengadaan_item.*, barang.nm_barang, kategori.nm_kategori FROM pengadaan_item 
		 LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang 
		 LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
		 WHERE pengadaan_item.no_pengadaan='$Kode' ORDER BY pengadaan_item.kd_barang";
$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0; 
while($myData = mysql_fetch_array($myQry)) {
	$totalBarang	= $totalBarang + $myData['jumlah'];
	$subTotalBeli	= $myData['harga_beli'] * $myData['jumlah']; // harga beli dari tabel pengadaan_item (harga terbaru dari supplier)
	$grandTotalBeli	= $grandTotalBeli + $subTotalBeli;
	$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['deskripsi']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subTotalBeli); ?></td>
  </tr>
  <?php 
}?>
  <tr>
    <td colspan="5" align="right"><b> GRAND TOTAL  : </b></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo $totalBarang; ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($grandTotalBeli); ?></strong></td>
  </tr>
</table>
<br/>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html><?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>