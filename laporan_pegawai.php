<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang/ ditutup)
if($aksesData['mlap_pegawai'] == "Yes") {

?>
<h2> LAPORAN DATA PEGAWAI </h2>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="50" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="210" bgcolor="#CCCCCC"><strong>Nama Pegawai </strong></td>
    <td width="45" bgcolor="#CCCCCC"><strong>L/ P </strong></td>
    <td width="341" bgcolor="#CCCCCC"><strong>Alamat Tinggal  </strong></td>  
    <td width="100" bgcolor="#CCCCCC"><strong>No. Telepon </strong></td>
  </tr>
<?php
	// Menampilkan data Pegawai
	$mySql = "SELECT * FROM pegawai ORDER BY kd_pegawai ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_pegawai']; ?></td>
    <td><?php echo $myData['nm_pegawai']; ?></td>
    <td><?php echo $myData['kelamin']; ?></td>
    <td><?php echo $myData['alamat']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
  </tr>
<?php } ?>
</table>
<br />
<a href="cetak/pegawai.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>

<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
