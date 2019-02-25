<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/bar128.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_barcode'] == "Yes") {
?>
<html>
<head>
<title> :: Cetak Label Barcode</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body,td,th {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size:11px;
}
body {
	margin-top: 1px;
}
-->
</style>

</head>
<body>
<table class="table-list" width="200" border="0" cellspacing="40" cellpadding="4">
  <tr>
<?php
# JIKA MENEMUKAN CBKODE, salah satu Cekbox dipilih dan klik tombol Cetak Barcode
if(isset($_POST['cbKode'])) {
	$cbKode = $_POST['cbKode'];
	$jum  = count($cbKode);
	if($jum==0) {
		echo "BELUM ADA KODE BARANG YANG DIPILIH";
		echo "<meta http-equiv='refresh' content='1; url=index.php?open=Cetak-Barcode'>";
	}
	else {
		$no = 0; $lebar = 3;
		foreach($_POST['cbKode'] as $indeks => $nilai) {
			$mySql = "SELECT * FROM barang_inventaris WHERE kd_barang='$nilai'";
			$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
			while($myData= mysql_fetch_array($myQry)) {
				$no++;
			?>
				<td width="201" valign="top" align="center">
				<br>
				<?php echo bar128_2(stripslashes($myData['kd_inventaris'])); ?></td>
			<?php
				// Membuat TR tabel
				if ($no == $lebar) { echo "</tr>"; $lebar = $lebar + 4; }
			
			} // end for
			
		 }  // End foreach
	}
}
else {
	echo "BELUM ADA KODE BARANG YANG DIPILIH";
	echo "<meta http-equiv='refresh' content='1; url=index.php?open=Cetak-Barcode'>";
}?>
</table>
* Selanjutnya, label barcode di atas dapat Anda cetak ke printer. Lalu, label dapat ditempel pada aset barang.
</body>
</html><?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
