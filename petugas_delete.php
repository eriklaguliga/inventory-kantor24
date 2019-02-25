<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_petugas'] == "Yes") {

	// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
	if(isset($_GET['Kode'])){
		$Kode	= $_GET['Kode'];
		
		// Hapus data sesuai Kode yang didapat di URL
		$mySql = "DELETE FROM petugas WHERE kd_petugas='$Kode' AND username !='admin'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Error hapus data 1".mysql_error());
		if($myQry){
			// Jika file lama ada, akan dihapus
			$fileData = $myData['foto'];
			if($fileData != "") {
				if(file_exists("foto/petugas/".$fileData)) {
					unlink("foto/petugas/".$fileData);	
				} 
			}
			
			// Skrip Hapus Hak Akses 
			$my2Sql = "DELETE FROM hak_akses WHERE kd_petugas='$Kode'";
			mysql_query($my2Sql, $koneksidb) or die ("Error hapus data 2".mysql_error());
		
			// Refresh halaman
			echo "<meta http-equiv='refresh' content='0; url=?open=Petugas-Data'>";
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
