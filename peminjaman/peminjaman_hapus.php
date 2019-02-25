<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_peminjaman'] == "Yes") {

	// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
	if(isset($_GET['Kode'])){
		$Kode	= $_GET['Kode'];
		$bulan	= $_GET['bulan'];
		$tahun	= $_GET['tahun'];
		
		// Baca data dalam tabel anak (peminjaman_item)
		$bacaSql = "SELECT * FROM peminjaman_item WHERE no_peminjaman='$Kode'";
		$bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query baca data".mysql_error());
		while($bacaData = mysql_fetch_array($bacaQry)) {
			$kodeBarang	= $bacaData['kd_inventaris'];
			
			// Skrip Kembalikan Jumlah Stok
			$stokSql = "UPDATE barang_inventaris SET status_barang ='Tersedia' WHERE kd_inventaris='$kodeBarang'";
			mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Status".mysql_error());
		}
		
		// Hapus data pada tabel anak (peminjaman_item)
		$hapusSql = "DELETE FROM peminjaman_item WHERE no_peminjaman='$Kode'";
		mysql_query($hapusSql, $koneksidb) or die ("Error hapus data 1 ".mysql_error());
	
		// Hapus data sesuai Kode yang didapat di URL
		$hapus2Sql = "DELETE FROM peminjaman WHERE no_peminjaman='$Kode'";
		mysql_query($hapus2Sql, $koneksidb) or die ("Error hapus data 2".mysql_error());
	
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Peminjaman-Tampil&bulan=$bulan&tahun=$tahun'>";
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

