<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_barcode'] == "Yes") {

$Kode	= isset($_GET['Kode']) ? $_GET['Kode'] : '-';
$infoSql= "SELECT barang.*, kategori.nm_kategori FROM barang 
			LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
			WHERE barang.kd_barang='$Kode'";
$infoQry= mysql_query($infoSql, $koneksidb);
$infoData= mysql_fetch_array($infoQry);
?>
<table width="800" border="0" cellpadding="2" cellspacing="1" class="table-list">
<tr>
  <td colspan="3" bgcolor="#CCCCCC"><b>DATA BARANG </b></td>
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
  <td><strong>Satuan</strong></td>
  <td><b>:</b></td>
  <td><?php echo $infoData['satuan']; ?></td>
</tr>
</table>

<form action="cetak_barcode_view_print.php" method="post" name="form2" target="_blank">
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="3" align="right"><input name="btnCetak" type="submit" id="btnCetak" value=" Cetak Label " /></td>
    </tr>
  <tr>
    <td width="24" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="699" bgcolor="#CCCCCC"><strong>Kode Label ( Inventaris )  
      <input name="txtKode" type="hidden" id="txtKode" value="<?php echo $Kode; ?>" />
    </strong></td>
    <td width="61" align="center" bgcolor="#CCCCCC"><strong>Pilih</strong></td>
    </tr>
  <?php
	// Menampilkan data Kode Label Inventaris
	$mySql = "SELECT * FROM barang_inventaris WHERE kd_barang='$Kode'";  
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_inventaris'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_inventaris']; ?></td>
    <td align="center"><input name="cbKode[]" type="checkbox" id="cbKode" value="<?php echo $Kode; ?>" /></td>
    </tr>
  <?php } ?>
  
  <tr>
    <td colspan="3" align="right"><input name="btnCetak" type="submit" value=" Cetak Label " /></td>
    </tr>
</table>
<p><strong>* Note:</strong> Centang dulu pada Kode Barang yang akan dibuat label ( klik <strong>Cek</strong> ), baru klik tombol  <strong>Cetak Barcode</strong></p>
</form><?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>

