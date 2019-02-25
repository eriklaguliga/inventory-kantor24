<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_supplier'] == "Yes") {

?>
<h2> LAPORAN DATA SUPPLIER </h2>
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="24" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="51" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="200" bgcolor="#CCCCCC"><strong>Nama Supplier </strong></td>
    <td width="475" bgcolor="#CCCCCC"><strong>Alamat Lengkap  </strong></td>  
    <td width="124" bgcolor="#CCCCCC"><strong>No. Telepon </strong></td>
  </tr>
<?php
	// Menampilkan data Supplier
	$mySql = "SELECT * FROM supplier ORDER BY kd_supplier ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_supplier']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['alamat']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
  </tr>
<?php } ?>
</table>
<br />
<a href="cetak/supplier.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
