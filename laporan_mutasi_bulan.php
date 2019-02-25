<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang/ ditutup)
if($aksesData['mlap_mutasi_bulan'] == "Yes") {

// Variabel SQL
$filterSQL= "";

# Bulan dan Tahun Terpilih
$bulan		= isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan; // Baca dari form Submit, jika tidak ada diisi dari $bulan

$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# Membuat Filter Bulan
if($dataTahun and $dataBulan) {
	if($dataBulan == "00") {
		// Jika tidak memilih bulan
		$filterSQL = "WHERE LEFT(tgl_mutasi,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "WHERE LEFT(tgl_mutasi,4)='$dataTahun' AND MID(tgl_mutasi,6,2)='$dataBulan'";
	}
}
else {
	$filterSQL = "";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/mutasi_bulan.php?bulan=$dataBulan&tahun=$dataTahun')";
	echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM mutasi $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$baris);
?>
<h2>LAPORAN DATA MUTASI PER PERIODE</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="113"><strong>Periode Bulan </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="768"><select name="cmbBulan">
          <?php
		// Membuat daftar Nama Bulan
		$listBulan = array("00" => "....", "01" => "01. Januari", "02" => "02. Februari", "03" => "03. Maret",
						 "04" => "04. April", "05" => "05. Mei", "06" => "06. Juni", "07" => "07. Juli",
						 "08" => "08. Agustus", "09" => "09. September", "10" => "10. Oktober",
						 "11" => "11. November", "12" => "12. Desember");
						 
		// Menampilkan Nama Bulan ke ComboBox (List/Menu)
		foreach($listBulan as $bulanKe => $bulanNm) {
			if ($bulanKe == $dataBulan) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$bulanKe' $cek>$bulanNm</option>";
		}
	  ?>
        </select>
          <select name="cmbTahun">
            <?php
		# Baca tahun terendah(kecil), dan tahun tertinggi(besar) di tabel Transaksi
		$thnSql = "SELECT MIN(LEFT(tgl_mutasi,4)) As tahun_kecil, MAX(LEFT(tgl_mutasi,4)) As tahun_besar FROM mutasi";
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
        </select></td>
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
	$mySql = "SELECT * FROM mutasi $filterSQL ORDER BY  no_mutasi DESC LIMIT $hal, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
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
  <tr>
    <td colspan="3"><b>Jumlah Data :</b> <?php echo $jml; ?></td>
    <td colspan="6" align="right"><b>Halaman ke :</b>
        <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Mutasi-Bulan&hal=$list[$h]&bulan=$dataBulan&tahun=$dataTahun'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<br />
<a href="cetak/mutasi_bulan.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>

<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
