<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_petugas'] == "Yes") {

?><h2> LAPORAN DATA PETUGAS </h2>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="21" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="46" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="301" bgcolor="#CCCCCC"><b>Nama Petugas </b></td>
    <td width="38" bgcolor="#CCCCCC"><strong>L/ P </strong></td>
    <td width="179" bgcolor="#CCCCCC"><b>No. Telepon </b></td>
    <td width="108" bgcolor="#CCCCCC"><b>Username</b></td>
    <td width="71" bgcolor="#CCCCCC"><b>Level</b></td>
  </tr>
	<?php
	// Menampilkan data Petugas
	$mySql 	= "SELECT * FROM petugas ORDER BY kd_petugas";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
			
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_petugas']; ?></td>
    <td><?php echo $myData['nm_petugas']; ?></td>
    <td><?php echo $myData['kelamin']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
    <td><?php echo $myData['username']; ?></td>
    <td><?php echo $myData['level']; ?></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/petugas.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>

<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
