<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_pengadaan_barang_periode'] == "Yes") {

# Deklarasi variabel
$filterSQL = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";

# Set Tanggal skrg
$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
$tglAwal 	= isset($_POST['txtTanggalAwal']) ? $_POST['txtTanggalAwal'] : $tglAwal;

$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');
$tglAkhir 	= isset($_POST['txtTanggalAkhir']) ? $_POST['txtTanggalAkhir'] : $tglAkhir; 

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
	$filterSQL = "AND ( tgl_pengadaan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	$filterSQL = "";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/pengadaan_barang_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
	echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$barisData 	= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM pengadaan, pengadaan_item WHERE pengadaan.no_pengadaan = pengadaan_item.no_pengadaan $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumData	= mysql_num_rows($pageQry);
$maksData	= ceil($jumData/$barisData);
?>
<h2>  LAPORAN PENGADAAN BARANG PER PERIODE </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="111"><strong>Periode </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="770"><input name="txtTanggalAwal" type="text" class="tcal" value="<?php echo $tglAwal; ?>" />
        s/d
        <input name="txtTanggalAkhir" type="text" class="tcal" value="<?php echo $tglAkhir; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" value=" Tampilkan " />
          <input name="btnCetak" type="submit"  value=" Cetak " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="27" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="54" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="95" bgcolor="#CCCCCC"><strong>No. Pengadaan </strong></td>
    <td width="46" bgcolor="#CCCCCC"><strong>Kode </strong></td>
    <td width="369" bgcolor="#CCCCCC"><b>Nama Barang</b></td>
    <td width="110" align="right" bgcolor="#CCCCCC"><b> Hrg. Beli (Rp)</b></td>
    <td width="48" align="right" bgcolor="#CCCCCC"><b>Jumlah</b></td>
    <td width="110" align="right" bgcolor="#CCCCCC"><strong> Tot. Harga(Rp)</strong></td>
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
			 ORDER BY pengadaan.tgl_pengadaan LIMIT $halaman, $barisData";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	$nomor  = $halaman; 
	while($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$subTotal 	= $myData['harga_beli'] * $myData['jumlah'];
		$totalHarga	= $totalHarga + $subTotal;
		$totalBarang= $totalBarang + $myData['jumlah'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pengadaan']); ?></td>
    <td><?php echo $myData['no_pengadaan']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subTotal); ?></td>
  </tr>
  <?php 
}?>
  <tr>
    <td colspan="6" align="right"><b> GRAND TOTAL : </b></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC">Rp. <strong><?php echo format_angka($totalHarga); ?></strong></td>
  </tr>
  <tr>
    <td colspan="4"><b>Jumlah Data :</b> <?php echo $jumData; ?></td>
    <td colspan="4" align="right"><b>Halaman ke :</b>
        <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $barisData * $h - $barisData;
		echo " <a href='?open=Laporan-Pengadaan-Barang-Periode&hal=$list[$h]&tglAwal=$tglAwal&tglAkhir=$tglAkhir'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<a href="cetak/pengadaan_barang_periode.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
