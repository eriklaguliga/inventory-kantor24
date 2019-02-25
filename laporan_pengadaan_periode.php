<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_pengadaan_periode'] == "Yes") {

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
	$filterSQL = "WHERE ( tgl_pengadaan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	$filterSQL = "";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/pengadaan_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
	echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pengadaan $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$baris);
?>
<h2>LAPORAN DATA  PENGADAAN PER PERIODE </h2>
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
    <td width="21" rowspan="2" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="80" rowspan="2" bgcolor="#F5F5F5"><strong>Tanggal</strong></td>
    <td width="120" rowspan="2" bgcolor="#F5F5F5"><strong>No. Pengadaan</strong></td>
    <td width="201" rowspan="2" bgcolor="#F5F5F5"><strong>Keterangan</strong></td>
    <td width="200" rowspan="2" bgcolor="#F5F5F5"><strong>Supplier </strong></td>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>TOTAL </strong></td>
    <td width="37" rowspan="2" align="center" bgcolor="#F5F5F5"><strong>Tools</strong></td>
  </tr>
  <tr>
    <td width="80" align="right" bgcolor="#F5F5F5"><strong>Qty Barang</strong></td>
    <td width="120" align="right" bgcolor="#F5F5F5"><strong>Belanja (Rp) </strong></td>
  </tr>
  <?php
	# Perintah untuk menampilkan Semua Data Transaksi Pengadaan, menggunakan Filter Periode
	$mySql = "SELECT pengadaan.*, supplier.nm_supplier FROM pengadaan 
				LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier 
				$filterSQL
				ORDER BY pengadaan.no_pengadaan DESC LIMIT $hal, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query pengadaan salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		# Membaca Kode pengadaan/ Nomor transaksi
		$Kode = $myData['no_pengadaan'];
		
		# Menghitung Total pengadaan (belanja) setiap nomor transaksi
		$my2Sql = "SELECT SUM(jumlah) AS total_barang,  
						  SUM(harga_beli * jumlah) AS total_belanja 
				   FROM pengadaan_item WHERE no_pengadaan='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pengadaan']); ?></td>
    <td><?php echo $myData['no_pengadaan']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
    <td align="center"><a href="cetak/pengadaan_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><b>Jumlah Data :</b> <?php echo $jml; ?></td>
    <td colspan="5" align="right"><b>Halaman ke :</b>
        <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Pengadaan-Periode&hal=$list[$h]&tglAwal=$tglAwal&tglAkhir=$tglAkhir'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<br />
<a href="cetak/pengadaan_periode.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
