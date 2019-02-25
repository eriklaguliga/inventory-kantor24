<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_penempatan'] == "Yes") {

//  Bulan Terpilih, dari URL dan Form
$bulan		= isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan; // Baca dari form Submit, jika tidak ada diisi dari $bulan

//  Tahun Terpilih, dari URL dan Form
$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# Membuat Filter Bulan
if($dataBulan and $dataTahun) {
	if($dataBulan == "00") {
		// Jika tidak memilih bulan
		$filterSQL = "WHERE LEFT(tgl_penempatan,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "WHERE LEFT(tgl_penempatan,4)='$dataTahun' AND MID(tgl_penempatan,6,2)='$dataBulan'";
	}
}
else {
	$filterSQL = "";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penempatan $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$baris);
?>
<h2>DAFTAR PENEMPATAN </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="138"><strong>Bulan &amp; Tahun </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="743"><select name="cmbBulan">
          <?php
		// Daftar nama bulan
		$listBulan = array("00" => "....", "01" => "Januari", "02" => "Februari", "03" => "Maret",
					 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
					 "08" => "Agustus", "09" => "September", "10" => "Oktober",
					 "11" => "November", "12" => "Desember");
		
		// Membuat daftar Bulan dari bulan 01 sampai 12, lalu menampilkan nama bulannya
		foreach($listBulan as $bulanke => $bulannm) {
			if ($bulanke == $dataBulan) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$bulanke' $cek>$bulannm</option>";
		}
	  ?>
        </select>
          <select name="cmbTahun">
            <?php
		$thnSql = "SELECT MIN(LEFT(tgl_penempatan,4)) As thn_kecil, MAX(LEFT(tgl_penempatan,4)) As thn_besar FROM penempatan";
		$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
		$thnData	= mysql_fetch_array($thnQry);
		
		// Tahun terbaca dalam tabel transaksi
		$thnKecil = $thnData['thn_kecil'];
		$thnBesar = $thnData['thn_besar'];
		
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		for($thn = $thnKecil; $thn <= $thnBesar; $thn++) {
			if ($thn == $dataTahun) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$thn' $cek> $thn</option>";
		}
	  ?>
        </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="70" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="120" bgcolor="#CCCCCC"><strong>No. Penempatan</strong></td>
    <td width="252" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="242" bgcolor="#CCCCCC"><strong>Departemen &amp; Lokasi</strong></td>
    <td width="70" align="right" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
    <td colspan="2" align="center" bgcolor="#F5F5F5"><strong>Tools</strong></td>
  </tr>
  <?php
	# Perintah untuk menampilkan data Transaksi penempatan, dilengkapi informasi Lokasi dan Departemen
	$mySql = "SELECT penempatan.*, departemen.nm_departemen, lokasi.nm_lokasi FROM penempatan 
				LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi 
				LEFT JOIN departemen ON lokasi.kd_departemen = departemen.kd_departemen
				$filterSQL
				ORDER BY penempatan.no_penempatan DESC LIMIT $hal, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		# Membaca Kode penempatan/ Nomor transaksi
		$noNota = $myData['no_penempatan'];
		
		# Menghitung Total penempatan (belanja) setiap nomor transaksi
		$my2Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item WHERE no_penempatan='$noNota'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penempatan']); ?></td>
    <td><?php echo $myData['no_penempatan']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td><?php echo $myData['nm_departemen'].", ".$myData['nm_lokasi']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td width="40" align="center"><a href="?open=Penempatan-Hapus&Kode=<?php echo $noNota; ?>&bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>" target="_self"
	onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENEMPATAN INI ... ?')" >Delete</a><a href="?open=Delete"></a></td>
    <td width="40" align="center"><a href="../cetak/penempatan_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><b>Jumlah Data :</b> <?php echo $jml; ?></td>
    <td colspan="5" align="right"><b>Halaman ke :</b>
        <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Penempatan-Tampil&hal=$list[$h]&bulan=$dataBulan&tahun=$dataTahun'>$h</a> ";
	}
	?></td>
  </tr>
</table>

<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>

