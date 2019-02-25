<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang/ ditutup)
if($aksesData['mlap_mutasi_lokasi'] == "Yes") {

# Deklarasi variabel
$tglAwal	= ""; 
$tglAkhir	= "";
$filterSQL 	= "";
$filterPeriode	= ""; 

# Membaca Variabel filter yang dikirim Form Filter
$kodeLokasi= isset($_POST['cmbLokasi']) ? $_POST['cmbLokasi'] : 'Semua';
$tglAwal 	= isset($_POST['cmbTglAwal']) ? $_POST['cmbTglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_POST['cmbTglAkhir']) ? $_POST['cmbTglAkhir'] : date('d-m-Y');

// Sql untuk filter periode
$filterPeriode = " AND ( mutasi.tgl_mutasi BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";

# TOMBOL TAMPIL DIKLIK
if (isset($_POST['btnTampil'])) {
	
	// Jika lokasi dipilih
	if (trim($kodeLokasi)=="Semua") {
		//Query #1 (all)
		$filterSQL 	= $filterPeriode."";
	}
	else {
		//Query #2 (filter)
		$filterSQL 	= $filterPeriode." AND penempatan.kd_lokasi ='$kodeLokasi'";
	}
}
else {
	$filterSQL	= $filterPeriode."";
}
	
# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/mutasi_lokasi.php?kodeLokasi=$kodeLokasi&tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
		echo "</script>";
}
?>
<h2>  LAPORAN MUTASI BARANG - PER LOKASI </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="90"><strong> Lokasi  Lama</strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="391"><select name="cmbLokasi">
          <option value="Semua">- Semua -</option>
          <?php
	  $mySql = "SELECT * FROM lokasi ORDER BY kd_lokasi";
	  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($kolomData = mysql_fetch_array($myQry)) {
	  	if ($kodeLokasi == $kolomData['kd_lokasi']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$kolomData[kd_lokasi]' $cek>$kolomData[nm_lokasi]</option>";
	  }
	  $mySql ="";
	  ?>
        </select></td>
    </tr>
    <tr>
      <td><strong>Periode </strong></td>
      <td><strong>:</strong></td>
      <td><input name="cmbTglAwal" type="text" class="tcal" value="<?php echo $tglAwal; ?>" />
        s/d
        <input name="cmbTglAkhir" type="text" class="tcal" value="<?php echo $tglAkhir; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" value=" Tampilkan " />
        <input name="btnCetak" type="submit" id="btnCetak" value=" Cetak " /></td>
    </tr>
  </table>
</form>

<br />
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="26" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="63" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>No. Mutasi</strong></td>
    <td width="140" bgcolor="#CCCCCC"><strong>Lokasi Lama </strong></td>
    <td width="110" bgcolor="#CCCCCC"><strong>No. Penempatan </strong></td>
    <td width="154" bgcolor="#CCCCCC"><strong>Lokasi Baru </strong></td>
    <td width="139" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="82" align="right" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
    <td width="40" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
	// Skrip untuk menampilkan data Mutasi dengan filter Bulan dan Tahun, informasi dilengkapi data Lokasi
	$mySql = "SELECT mutasi.* FROM mutasi LEFT JOIN mutasi_asal ON mutasi.no_mutasi = mutasi_asal.no_mutasi 
				LEFT JOIN penempatan ON mutasi_asal.no_penempatan = penempatan.no_penempatan
				$filterSQL ORDER BY  mutasi.no_mutasi DESC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
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
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_mutasi']); ?></td>
    <td><?php echo $myData['no_mutasi']; ?></td>
    <td><?php echo $my3Data['nm_lokasi']; ?></td>
    <td><?php echo $my3Data['no_penempatan']; ?></td>
    <td><?php echo $my2Data['nm_lokasi']; ?></td>
    <td><?php echo $my3Data['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($my4Data['total_barang']); ?></td>
    <td align="center"><a href="cetak/mutasi_cetak.php?noMutasi=<?php echo $noMutasi; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
</table>
<a href="cetak/mutasi_lokasi.php?kodeLokasi=<?php echo $kodeLokasi; ?>&tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
