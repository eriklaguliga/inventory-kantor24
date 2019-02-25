<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang/ ditutup)
if($aksesData['mlap_lokasi'] == "Yes") {

?>
<h2> LAPORAN DATA LOKASI </h2>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="54" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="380" bgcolor="#CCCCCC"><b>Nama Lokasi </b></td>
    <td width="322" bgcolor="#CCCCCC"><b>Departemen </b></td>  
  </tr>
  <?php
	  // Menampilkan data Lokasi, dilengkapi dengan data Departemen dari tabel relasi
	$mySql = "SELECT lokasi.*, departemen.nm_departemen FROM lokasi 
				LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
				ORDER BY kd_lokasi ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_lokasi'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_lokasi']; ?></td>
    <td><?php echo $myData['nm_lokasi']; ?></td>
    <td><?php echo $myData['nm_departemen']; ?></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/lokasi.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
