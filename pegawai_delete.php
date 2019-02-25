<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_pegawai'] == "Yes") {

	// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
	if(isset($_GET['Kode'])){
		$Kode	= $_GET['Kode'];
	
		// Membaca data File Foto
		$mySql	 = "SELECT foto FROM pegawai WHERE kd_pegawai='$Kode'";
		$myQry	 = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
		$myData	 = mysql_fetch_array($myQry);
		
		// Jika file lama ada, akan dihapus
		$fileData = $myData['foto'];
		if($fileData != "") {
			if(file_exists("foto/pegawai/".$fileData)) {
				unlink("foto/pegawai/".$fileData);	
			} 
		}
	
		// Hapus data sesuai Kode yang didapat di URL
		$mySql = "DELETE FROM pegawai WHERE kd_pegawai='$Kode'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
		if($myQry){
			// Refresh halaman
			echo "<meta http-equiv='refresh' content='0; url=?open=Pegawai-Data'>";
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
