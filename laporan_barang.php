<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_barang'] == "Yes") {

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<h2>LAPORAN DATA BARANG</h2>
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="50" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="261" bgcolor="#CCCCCC"><strong>Nama Barang</strong></td>
    <td width="155" bgcolor="#CCCCCC"><strong>Kategori</strong></td>
    <td width="67" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
    <td width="73" align="right" bgcolor="#CCCCCC"><strong> Tersedia </strong></td>
    <td width="92" align="right" bgcolor="#CCCCCC"><strong>Ditempatkan</strong></td>
    <td width="93" align="right" bgcolor="#CCCCCC"><strong>Dipinjam</strong></td>
    <td width="40" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
	# MENJALANKAN QUERY
	$mySql 	= "SELECT barang.*, kategori.nm_kategori FROM barang 
				LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
				ORDER BY barang.kd_barang ASC LIMIT $hal, $row";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];
		
		// Membuat variabel akan diisi angka
		$jumTersedia =0;
		$jumDitempatkan =0; 
		$jumDipinjam =0;
		
		// Query menampilkan data Inventaris per Kode barang
		$my2Sql = "SELECT * FROM barang_inventaris WHERE kd_barang='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		while($my2Data = mysql_fetch_array($my2Qry)) {
			if($my2Data['status_barang']=="Tersedia") {
				$jumTersedia++;
			}
			
			if($my2Data['status_barang']=="Ditempatkan") {
				$jumDitempatkan++;
			}
			
			if($my2Data['status_barang']=="Dipinjam") {
				$jumDipinjam++;
			}			
		}
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
    <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $myData['jumlah']; ?></td>
    <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $jumTersedia; ?></td>
    <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $jumDitempatkan; ?></td>
    <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $jumDipinjam; ?></td>
    <td align="center"><a href="cetak/barang_view.php?Kode=<?php echo $Kode; ?>" target="_blank">View</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3" bgcolor="#CCCCCC"><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td colspan="6" align="right" bgcolor="#CCCCCC"><b>Halaman ke :</b>
        <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=Laporan-Barang&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<p> <a href="cetak/barang.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
</p>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
