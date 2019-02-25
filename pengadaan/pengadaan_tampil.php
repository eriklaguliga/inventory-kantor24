<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_pengadaan'] == "Yes") {

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
		$filterSQL = "WHERE LEFT(tgl_pengadaan,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "WHERE LEFT(tgl_pengadaan,4)='$dataTahun' AND MID(tgl_pengadaan,6,2)='$dataBulan'";
	}
}
else {
	$filterSQL = "";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pengadaan $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$baris);
?>
<h2>TAMPIL DATA PENGADAAN </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="136"><strong>Bulan &amp; Tahun </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="745">
	  <select name="cmbBulan">
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
		$thnSql = "SELECT MIN(LEFT(tgl_pengadaan,4)) As thn_kecil, MAX(LEFT(tgl_pengadaan,4)) As thn_besar FROM pengadaan";
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
    <td width="20" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="60" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="110" bgcolor="#CCCCCC"><strong>No. Pengadaan</strong></td>
    <td width="229" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="154" bgcolor="#CCCCCC"><strong>Supplier </strong></td>
    <td width="81" align="right" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
    <td width="120" align="right" bgcolor="#CCCCCC"><strong>Total Biaya (Rp) </strong></td>
    <td colspan="2" align="center" bgcolor="#F5F5F5"><strong>Tools</strong></td>
  </tr>
  <?php
	# Perintah untuk menampilkan Semua Daftar Transaksi pengadaan
	$mySql = "SELECT pengadaan.*, supplier.nm_supplier FROM pengadaan 
				LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier 
				$filterSQL
				ORDER BY pengadaan.no_pengadaan DESC LIMIT $hal, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
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
    <td width="40" align="center"><a href="?open=Pengadaan-Hapus&Kode=<?php echo $Kode; ?>&bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>" target="_self"
	onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENGADAAN INI ... ?')" >Delete</a></td>
    <td width="40" align="center"><a href="../cetak/pengadaan_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><b>Jumlah Data :</b> <?php echo $jml; ?></td>
    <td colspan="6" align="right" bgcolor="#F5F5F5"><b>Halaman ke :</b>
        <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Pengadaan&hal=$list[$h]&bulan=$dataBulan&tahun=$dataTahun'>$h</a> ";
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
