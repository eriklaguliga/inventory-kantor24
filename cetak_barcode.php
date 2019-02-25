<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_barcode'] == "Yes") {

$kategoriSQL= "";
$cariSQL 	= "";

# Temporary Variabel form
$kodeKategori	= isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : '';
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;

$keyWord		= isset($_GET['keyWord']) ? $_GET['keyWord'] : '';
$dataKataKunci	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';

# PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
if(isset($_POST['btnTampil'])) {
	# PILIH KATEGORI
	if (trim($_POST['cmbKategori']) =="BLANK") {
		$kategoriSQL = "";
	}
	else {
		$kategoriSQL = "AND barang.kd_kategori='$dataKategori'";
	}

}
else {
	//Query #1 (all)
	$supplierSQL= "";
	$kategoriSQL= "";
}


# PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
if(isset($_POST['btnCari'])) {
	$txtKataKunci	= trim($_POST['txtKataKunci']); 

	$cariSQL		= " AND barang_inventaris.kd_inventaris='$txtKataKunci' OR barang.nm_barang LIKE '%$txtKataKunci%' ";
	
	// Pencarian Multi String (beberapa kata)
	$keyWord 		= explode(" ", $txtKataKunci);
	if(count($keyWord) > 1) {
		foreach($keyWord as $kata) {
			$cariSQL	.= " OR barang.nm_barang LIKE '%$kata%'";
		} 
	}
}
else {
	//Query #1 (all)
	$cariSQL 	= "";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 100;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT barang.*, kategori.nm_kategori FROM barang_inventaris
					LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
					LEFT JOIN kategori ON  barang.kd_barang=kategori.kd_kategori 
				WHERE barang.jumlah >='1' $kategoriSQL $cariSQL
				GROUP BY barang.kd_barang";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<h1> CETAK LABEL BARCODE </h1>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-list">
<tr>
  <td colspan="3" bgcolor="#F5F5F5"><b>FILTER DATA  </b></td>
</tr>
<tr>
  <td width="186"><b>Nama Kategori </b></td>
  <td width="5"><b>:</b></td>
  <td width="1007">
  <select name="cmbKategori" onChange="javascript:submitform();">
	<option value="BLANK">....</option>
	<?php
	  $dataSql = "SELECT * FROM kategori ORDER BY kd_kategori";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
		if ($dataRow['kd_kategori'] == $dataKategori) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$dataRow[kd_kategori]' $cek>$dataRow[nm_kategori]</option>";
	  }
	  $sqlData ="";
	  ?>
	  </select>
  <input name="btnTampil" type="submit" value=" Tampilkan " /></td>
</tr>

<tr>
  <td><strong>Cari Barang </strong></td>
  <td><strong>:</strong></td>
  <td><input name="txtKataKunci" type="text" value="<?php echo $dataKataKunci; ?>" size="45" maxlength="100" />
      <input name="btnCari" type="submit" value=" Cari " /></td>
</tr>
</table>
</form>

<form action="cetak_barcode_print.php" method="post" name="form2" target="_blank">
<table class="table-list" width="935" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="8" align="right"><input name="btnCetak2" type="submit" id="btnCetak" value=" Cetak Label " /></td>
    </tr>
  <tr>
    <th width="21"><b>No</b></th>
    <th width="50"><strong>Kode</strong></th>
    <th width="402"><b>Nama Barang </b></th>
    <th width="247"><b>Kategori</b></th>
    <th width="50" align="right"><strong>Jumlah</strong></th>
    <th width="52">Satuan</th>
    <th width="35" align="center">Pilih</th>
    <th width="37" align="center"><strong>Tools</strong></th>
    </tr>
  <?php
	# MENJALANKAN QUERY , 
	$mySql = "SELECT barang.*, kategori.nm_kategori FROM barang_inventaris
					LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang
					LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
				WHERE barang.kd_barang !='' $kategoriSQL $cariSQL
				GROUP BY barang.kd_barang ORDER BY barang.kd_barang ASC LIMIT $hal, $row";  
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td><?php echo $myData['satuan']; ?></td>
    <td align="center"><input name="cbKode[]" type="checkbox" id="cbKode" value="<?php echo $Kode; ?>" /></td>
    <td align="center"><a href="?open=Cetak-Barcode-View&Kode=<?php echo $myData['kd_barang']; ?>" target="_blank">View</a></td>
    </tr>
  <?php } ?>
  <tr>
    <td colspan="4" bgcolor="#F5F5F5"><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td colspan="4" align="right" bgcolor="#F5F5F5"><b>Halaman ke :</b>
        <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?open=Cetak-Barcode&hal=$list[$h]&kodeKategori=$dataKategori&keyWord=dataKataKunci'>$h</a> ";
	}
	?></td>
  </tr>
  <tr>
    <td colspan="8" align="right"><input name="btnCetak" type="submit" value=" Cetak Label " /></td>
    </tr>
</table>
<p><strong>* Note:</strong> Centang dulu pada nama barang yang akan dibuat label ( klik <strong>Cek</strong> ), baru klik tombol  <strong>Cetak Barcode</strong></p>
</form><?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>

