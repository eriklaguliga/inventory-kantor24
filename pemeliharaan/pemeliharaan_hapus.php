<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_pemeliharaan'] == "Yes") {

	// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
	if(isset($_GET['Kode'])){
		$Kode	= $_GET['Kode'];
	
		// Hapus data sesuai Kode yang didapat di URL
		$hapus2Sql = "DELETE FROM pemeliharaan WHERE no_pemeliharaan='$Kode'";
		mysql_query($hapus2Sql, $koneksidb) or die ("Error hapus data 2".mysql_error());
	
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Pemeliharaan-Tampil'>";
	}
	else {
		// Jika tidak ada data Kode ditemukan di URL
		echo "<b>Data yang dihapus tidak ada</b>";
	}
 
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>

