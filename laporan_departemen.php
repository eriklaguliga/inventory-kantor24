<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_departemen'] == "Yes") {

?>
<h2> LAPORAN DATA DEPARTEMEN </h2>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="26" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="50" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="251" bgcolor="#CCCCCC"><b>Nama Departemen </b></td>
    <td width="372" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="75" align="right" bgcolor="#CCCCCC"><b>Qty Lokasi </b> </td>  
  </tr>
  <?php
	  // Menampilkan data Departemen
	$mySql = "SELECT * FROM departemen ORDER BY kd_departemen ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_departemen'];
		
		// Menghitung jumlah lokasi/lokasi per departemen
		$my2Sql = "SELECT COUNT(*) As qty_lokasi FROM lokasi WHERE kd_departemen='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_departemen']; ?></td>
    <td><?php echo $myData['nm_departemen']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $my2Data['qty_lokasi']; ?></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/departemen.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>

<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
