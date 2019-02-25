<?php
include_once "library/inc.seslogin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pengadaan";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<h2>LAPORAN DATA PENGADAAN </h2>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="72" rowspan="2" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="108" rowspan="2" bgcolor="#CCCCCC"><strong>No. Pengadaan</strong></td>  
    <td width="170" rowspan="2" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="161" rowspan="2" bgcolor="#CCCCCC"><strong>Supplier </strong></td>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Total  </strong></td>
    <td width="37" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <tr>
    <td width="82" align="right" bgcolor="#CCCCCC"><strong>Barang</strong></td>
    <td width="104" align="right" bgcolor="#CCCCCC"><strong>Belanja (Rp) </strong></td>
  </tr>
<?php
	# Perintah untuk menampilkan Semua Daftar Transaksi pengadaan
	$mySql = "SELECT pengadaan.*, supplier.nm_supplier FROM pengadaan 
				LEFT JOIN supplier ON pengadaan.kd_supplier=supplier.kd_supplier 
				ORDER BY pengadaan.no_pengadaan DESC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		# Membaca Kode pengadaan/ Nomor transaksi
		$noNota = $myData['no_pengadaan'];
		
		# Menghitung Total pengadaan (belanja) setiap nomor transaksi
		$my2Sql = "SELECT SUM(jumlah) AS total_barang,  
						  SUM(harga_beli * jumlah) AS total_belanja 
				   FROM pengadaan_item WHERE no_pengadaan='$noNota'";
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
    <td align="center"><a href="cetak/pengadaan_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><b>Jumlah Data :</b> <?php echo $jml; ?></td>
    <td colspan="5" align="right"><b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=Laporan-Pengadaan&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table> 
<br />
<a href="cetak/pengadaan.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>