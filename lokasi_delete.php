<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_lokasi'] == "Yes") {

	// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
	if(isset($_GET['Kode'])){
		$Kode	= $_GET['Kode'];
		
		// Hapus data sesuai Kode yang didapat di URL
		$mySql = "DELETE FROM lokasi WHERE kd_lokasi='$Kode'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
		if($myQry){
			// Refresh halaman
			echo "<meta http-equiv='refresh' content='0; url=?open=Lokasi-Data'>";
		}
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
