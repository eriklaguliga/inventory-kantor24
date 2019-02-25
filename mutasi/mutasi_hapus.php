<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_mutasi'] == "Yes") {

	// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
	if(isset($_GET['Kode'])){
		$Kode	= $_GET['Kode'];
	
		# Membaca Nomor Penempatan pada data Mutasi Tujuan
		$bacaSql = "SELECT * FROM mutasi_tujuan WHERE no_mutasi='$Kode'";
		$bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query baca data mutasi_tujuan : ".mysql_error());
		while($bacaData = mysql_fetch_array($bacaQry)) {
			$kodePenempatan	= $bacaData['no_penempatan'];
			
			// Skrip Menghapus data Penempatan Baru (Item barang) yang sudah dibuat
			$hapusSql = "DELETE FROM penempatan_item WHERE no_penempatan='$kodePenempatan'";
			mysql_query($hapusSql, $koneksidb) or die ("Gagal Query Edit Status".mysql_error());
			
			// Skrip Menghapus data Penempatan Baru (Utama) yang sudah dibuat
			$hapus2Sql = "DELETE FROM penempatan WHERE no_penempatan='$kodePenempatan'";
			mysql_query($hapus2Sql, $koneksidb) or die ("Gagal Query Edit Status".mysql_error());
		}
	
		# Baca data Posisi Asal Barang sebelum dipindah
		$bacaSql = "SELECT * FROM mutasi_asal WHERE no_mutasi='$Kode'";
		$bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query baca data mutasi_asal : ".mysql_error());
		while($bacaData = mysql_fetch_array($bacaQry)) {
			$kodePenempatan	= $bacaData['no_penempatan'];
			$kodeBarang		= $bacaData['no_penempatan'];
			
			// Skrip Kembalikan Status aktif pada posisi Penempatan yang lama
			$stokSql = "UPDATE penempatan_item SET status_aktif ='Yes' WHERE no_penempatan='$kodePenempatan' AND kd_inventaris='$kodeBarang'";
			mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Status".mysql_error());
		}
	
		// Hapus data pada tabel Mutasi Asal
		$hapusSql = "DELETE FROM mutasi_asal WHERE no_mutasi='$Kode'";
		mysql_query($hapusSql, $koneksidb) or die ("Error hapus data mutasi_asal : ".mysql_error());
	
		// Hapus data pada tabel Mutasi Tujuan
		$hapus2Sql = "DELETE FROM mutasi_tujuan WHERE no_mutasi='$Kode'";
		mysql_query($hapus2Sql, $koneksidb) or die ("Error hapus data mutasi_tujuan : ".mysql_error());
	
		// Hapus data Mutasi sesuai Kode yang didapat di URL
		$hapus3Sql = "DELETE FROM mutasi WHERE no_mutasi='$Kode'";
		mysql_query($hapus3Sql, $koneksidb) or die ("Error hapus data mutasi : ".mysql_error());
		
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Mutasi-Tampil'>";
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

