<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_pengadaan_supplier'] == "Yes") {

// Variabel SQL
$filterSQL= "";

// Temporary Variabel form
$kodeSupplier	= isset($_GET['kodeSupplier']) ? $_GET['kodeSupplier'] : 'Semua'; // dari URL
$dataSupplier	= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : $kodeSupplier; // dari Form

#  Tahun Terpilih
$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun


// Membuat filter SQL
if ($dataSupplier=="Semua") {
	// Semua Supplier, dan Tahun terpilih
	$filterSQL 	= "WHERE LEFT(pengadaan.tgl_pengadaan,4)='$dataTahun'";
}
else {
	// Supplier terpilih, dan Tahun Terpilih
	$filterSQL 	= " WHERE pengadaan.kd_supplier ='$dataSupplier' AND LEFT(pengadaan.tgl_pengadaan,4)='$dataTahun'";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/pengadaan_supplier.php?kodeSupplier=$dataSupplier&tahun=$dataTahun')";
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
<h2>LAPORAN DATA  PENGADAAN PER SUPPLIER </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="111"><strong> Supplier </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="770">
	  <select name="cmbSupplier">
        <option value="Semua"> ... </option>
        <?php
	  $tampilSql = "SELECT * FROM supplier ORDER BY kd_supplier";
	  $tampilQry = mysql_query($tampilSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($tampilData = mysql_fetch_array($tampilQry)) {
		if ($tampilData['kd_supplier'] == $dataSupplier) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$tampilData[kd_supplier]' $cek> $tampilData[nm_supplier]</option>";
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td><strong>Periode Tahun </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbTahun">
          <?php
		# Baca tahun terendah(kecil), dan tahun tertinggi(besar) di tabel Transaksi
		$thnSql = "SELECT MIN(LEFT(tgl_pengadaan,4)) As tahun_kecil, MAX(LEFT(tgl_pengadaan,4)) As tahun_besar FROM pengadaan";
		$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
		$thnRow	= mysql_fetch_array($thnQry);
		
		// Membaca tahun
		$thnKecil = $thnRow['tahun_kecil'];
		$thnBesar = $thnRow['tahun_besar'];
		
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		for($thn= $thnKecil; $thn <= $thnBesar; $thn++) {
			if ($thn == $dataTahun) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$thn' $cek>$thn</option>";
		}
	  ?>
        </select>
          <input name="btnTampil" type="submit" value=" Tampilkan " />
          <input name="btnCetak" type="submit" id="btnCetak" value=" Cetak " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  
  <tr>
    <td width="22" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="80" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="120" bgcolor="#CCCCCC"><strong>No. Pengadaan</strong></td>
    <td width="372" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="100" align="right" bgcolor="#CCCCCC"><strong>Total Barang</strong></td>
    <td width="130" align="right" bgcolor="#CCCCCC"><strong>Total Belanja (Rp) </strong></td>
    <td width="40" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
	# Skrip untuk menampilkan Data Trans Pengadaan, dilengkapi informasi Supplier dari tabel relasi
	$mySql = "SELECT pengadaan.*, supplier.nm_supplier FROM pengadaan 
				LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier 
				$filterSQL
				ORDER BY pengadaan.no_pengadaan DESC LIMIT $hal, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
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
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
    <td align="center"><a href="cetak/pengadaan_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><b>Jumlah Data :</b> <?php echo $jml; ?></td>
    <td colspan="4" align="right"><b>Halaman ke :</b>
        <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Pengadaan-Supplier&hal=$list[$h]&kodeSupplier=$dataSupplier&tahun=$dataTahun'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<br />
<a href="cetak/pengadaan_supplier.php?kodeSupplier=<?php echo $dataSupplier; ?>&tahun=<?php echo $dataTahun; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
