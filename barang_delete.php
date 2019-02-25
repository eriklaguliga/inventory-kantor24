<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_barang'] == "Yes") {

	// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
	if(isset($_GET['Kode'])){
		// Kode
		$Kode	 = $_GET['Kode'];
		
		// Hapus data sesuai Kode yang didapat di URL
		$mySql = "DELETE FROM barang WHERE kd_barang='$Kode'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
		if($myQry){
			// Hapus data pada tabel Inventaris
			$my2Sql = "DELETE FROM barang_inventaris WHERE kd_barang='$Kode'";
			mysql_query($my2Sql, $koneksidb) or die ("Eror hapus data".mysql_error());
	
			// Refresh halaman
			echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
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
