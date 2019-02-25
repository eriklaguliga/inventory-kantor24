<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_petugas'] == "Yes") {

# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtNama		= $_POST['txtNama'];
	$txtUsername	= $_POST['txtUsername'];
	$txtPassword	= $_POST['txtPassword'];	
	$txtTelepon		= $_POST['txtTelepon'];	
	$cmbLevel		= $_POST['cmbLevel'];

	// Membaca Form Hak Akses
	$rbDataPetugas		=  $_POST['rbDataPetugas'];
	$rbDataSupplier		=  $_POST['rbDataSupplier'];
	$rbDataPegawai		=  $_POST['rbDataPegawai'];
	$rbDataDepartemen	=  $_POST['rbDataDepartemen'];
	$rbDataKategori		=  $_POST['rbDataKategori'];
	$rbDataLokasi		=  $_POST['rbDataLokasi'];
	$rbDataBarang		=  $_POST['rbDataBarang'];
	$rbDataInventaris	=  $_POST['rbDataInventaris'];
	$rbCariBarang		=  $_POST['rbCariBarang'];
	$rbCetakBarcode		=  $_POST['rbCetakBarcode'];
	$rbPengadaan		=  $_POST['rbPengadaan'];
	$rbPenempatan		=  $_POST['rbPenempatan'];
	$rbMutasi			=  $_POST['rbMutasi'];
	$rbPeminjaman		=  $_POST['rbPeminjaman'];

	$rbBackupRestore	=  $_POST['rbBackupRestore'];
	$rbExportBarang		=  $_POST['rbExportBarang'];
	$rbImportBarang		=  $_POST['rbImportBarang'];
	$rbExportPegawai	=  $_POST['rbExportPegawai'];
	$rbImportPegawai	=  $_POST['rbImportPegawai'];

	$rbLapPetugas		=  $_POST['rbLapPetugas'];
	$rbLapPegawai		=  $_POST['rbLapPegawai'];
	$rbLapSupplier		=  $_POST['rbLapSupplier'];
	$rbLapDepartemen	=  $_POST['rbLapDepartemen'];
	$rbLapKategori		=  $_POST['rbLapKategori'];
	$rbLapLokasi		=  $_POST['rbLapLokasi'];
	$rbLapBarangKategori		=  $_POST['rbLapBarangKategori'];
	$rbLapBarangLokasi			=  $_POST['rbLapBarangLokasi'];
	
	$rbLapPengadaanPeriode		=  $_POST['rbLapPengadaanPeriode'];
	$rbLapPengadaanBulan		=  $_POST['rbLapPengadaanBulan'];
	$rbLapPengadaanSupplier		=  $_POST['rbLapPengadaanSupplier'];
	$rbLapPengadaanBarangPeriode=  $_POST['rbLapPengadaanBarangPeriode'];
	$rbLapPengadaanBarangBulan	=  $_POST['rbLapPengadaanBarangBulan'];
	$rbLapPengadaanBarangKategori	=  $_POST['rbLapPengadaanBarangKategori'];
	$rbLapPengadaanBarangSupplier	=  $_POST['rbLapPengadaanBarangSupplier'];
	
	$rbLapPenempatanPeriode		=  $_POST['rbLapPenempatanPeriode'];
	$rbLapPenempatanBulan		=  $_POST['rbLapPenempatanBulan'];
	$rbLapPenempatanLokasi		=  $_POST['rbLapPenempatanLokasi'];
	
	$rbLapMutasiPeriode		=  $_POST['rbLapMutasiPeriode'];
	$rbLapMutasiBulan		=  $_POST['rbLapMutasiBulan'];
	$rbLapMutasiLokasi		=  $_POST['rbLapMutasiLokasi'];
			
	$rbLapPeminjamanPeriode		=  $_POST['rbLapPeminjamanPeriode'];
	$rbLapPeminjamanBulan		=  $_POST['rbLapPeminjamanBulan'];
	$rbLapPeminjamanPegawai		=  $_POST['rbLapPeminjamanPegawai'];
		
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Petugas</b> tidak boleh kosong, silahkan diisi !";		
	}
	if (trim($txtTelepon)=="") {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong, silahkan diisi !";		
	}
	if (trim($txtUsername)=="") {
		$pesanError[] = "Data <b>Username</b> tidak boleh kosong, silahkan diisi !";		
	}
	if (trim($cmbLevel)=="Kosong") {
		$pesanError[] = "Data <b>Level login</b> belum dipilih, silahkan dipilih dari Combo !";		
	}
			
	# VALIDASI petugas LOGIN (username), jika sudah ada akan ditolak
	$Kode	= $_POST['txtKode'];
	$cekSql	= "SELECT * FROM petugas WHERE username='$txtUsername' AND NOT(kd_petugas ='$Kode')";
	$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "Username : <b> $txtUsername </b> sudah ada, ganti dengan yang lain";
	}

	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# Cek Password baru
		if (trim($txtPassword)=="") {
			$txtPassLama	= $_POST['txtPassLama'];
			
			$sqlPasword = ", password='$txtPassLama'";
		}
		else {
			$sqlPasword = ",  password ='".md5($txtPassword)."'";
		}
		
		# SIMPAN DATA KE DATABASE (Jika tidak menemukan error, simpan data ke database)
		$Kode	= $_POST['txtKode'];
		$mySql  = "UPDATE petugas SET nm_petugas='$txtNama', username='$txtUsername', 
					no_telepon='$txtTelepon', level='$cmbLevel'
					$sqlPasword  
					WHERE kd_petugas='$Kode'";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			// Update Hak Akses
			$my2Sql  = "UPDATE hak_akses SET 
							mu_data_petugas = '$rbDataPetugas', 
							mu_data_supplier = '$rbDataSupplier', 
							mu_data_departemen = '$rbDataDepartemen', 
							mu_data_pegawai = '$rbDataPegawai', 
							mu_data_kategori = '$rbDataKategori', 
							mu_data_lokasi = '$rbDataLokasi', 
							mu_data_barang = '$rbDataBarang', 
							mu_data_inventaris = '$rbDataInventaris', 
							mu_pencarian = '$rbCariBarang', 
							mu_barcode = '$rbCetakBarcode', 
							mu_trans_pengadaan = '$rbPengadaan', 
							mu_trans_penempatan = '$rbPenempatan', 
							mu_trans_mutasi = '$rbMutasi', 
							mu_trans_peminjaman = '$rbPeminjaman', 
							mu_backup_restore = '$rbBackupRestore', 
							mu_export_import = 'Yes',
							mu_export_barang = '$rbExportBarang',
							mu_import_barang = '$rbImportBarang',
							mu_export_pegawai = '$rbExportPegawai',
							mu_import_pegawai = '$rbExportPegawai',
							mu_laporan_cetak = 'Yes', 
							mlap_petugas = '$rbLapPetugas', 
							mlap_supplier = '$rbLapSupplier', 
							mlap_pegawai = '$rbLapPegawai', 
							mlap_departemen = '$rbLapDepartemen', 
							mlap_kategori = '$rbLapKategori', 
							mlap_lokasi = '$rbLapLokasi', 
							mlap_barang_kategori = '$rbLapBarangKategori', 
							mlap_barang_lokasi = '$rbLapBarangLokasi', 
							mlap_pengadaan_periode = '$rbLapPengadaanPeriode', 
							mlap_pengadaan_bulan = '$rbLapPengadaanBulan', 
							mlap_pengadaan_supplier = '$rbLapPengadaanSupplier', 
							mlap_pengadaan_barang_periode = '$rbLapPengadaanBarangPeriode', 
							mlap_pengadaan_barang_bulan = '$rbLapPengadaanBarangBulan', 
							mlap_pengadaan_barang_kategori = '$rbLapPengadaanBarangKategori', 
							mlap_pengadaan_barang_supplier = '$rbLapPengadaanBarangSupplier',
							mlap_penempatan_periode = '$rbLapPenempatanPeriode',
							mlap_penempatan_bulan = '$rbLapPenempatanBulan',
							mlap_penempatan_lokasi = '$rbLapPenempatanLokasi',
							mlap_mutasi_periode = '$rbLapMutasiPeriode',
							mlap_mutasi_bulan = '$rbLapMutasiBulan',
							mlap_mutasi_lokasi = '$rbLapMutasiLokasi',
							mlap_peminjaman_periode = '$rbLapPeminjamanPeriode',
							mlap_peminjaman_bulan = '$rbLapPeminjamanBulan',
							mlap_peminjaman_pegawai = '$rbLapPeminjamanPegawai'
						WHERE kd_petugas='$Kode'";
			mysql_query($my2Sql, $koneksidb) or die ("Gagal query 2 ".mysql_error());
			
			echo "<meta http-equiv='refresh' content='0; url=?open=Petugas-Data'>";
		}
		exit;
	}	
} // Penutup Tombol Simpan


# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
$Kode	= $_GET['Kode']; 
$mySql 	= "SELECT * FROM petugas WHERE kd_petugas='$Kode'";
$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query ambil data Petugas salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);  

	// Data Variabel Temporary (sementara)
	$dataKode		= $myData['kd_petugas'];
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_petugas'];
	$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : $myData['username'];
	$dataTelepon	= isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
	$dataLevel		= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : $myData['level'];

# TAMPILKAN DATA HAK AKSES
$my2Sql 	= "SELECT * FROM hak_akses WHERE kd_petugas='$Kode'";
$my2Qry		= mysql_query($my2Sql, $koneksidb)  or die ("Query ambil data Hak akses salah : ".mysql_error());
$my2Data 	= mysql_fetch_array($my2Qry);    

	// Data Hak Akses
	$dataPetugas	   	= isset($_POST['rbDataPetugas']) ? $_POST['rbDataPetugas'] : $my2Data['mu_data_petugas'];
		if($dataPetugas =="No") { $pilihPetugasN = "checked"; $pilihPetugasY = ""; } else { $pilihPetugasN = ""; $pilihPetugasY = "checked"; }

	$dataPegawai 	= isset($_POST['rbDataPegawai']) ? $_POST['rbDataPegawai'] : $my2Data['mu_data_pegawai'];
		if($dataPegawai =="No") { $pilihPegawaiN = "checked"; $pilihPegawaiY = ""; } else { $pilihPegawaiN = ""; $pilihPegawaiY = "checked"; }

	$dataSupplier 	= isset($_POST['rbDataSupplier']) ? $_POST['rbDataSupplier'] : $my2Data['mu_data_supplier'];
		if($dataSupplier =="No") { $pilihSupplierN = "checked"; $pilihSupplierY = ""; } else { $pilihSupplierN = ""; $pilihSupplierY = "checked"; }

	$dataDepartemen 		= isset($_POST['rbDataDepartemen']) ? $_POST['rbDataDepartemen'] : $my2Data['mu_data_departemen'];
		if($dataDepartemen =="No") { $pilihDepartemenN = "checked"; $pilihDepartemenY = ""; } else { $pilihDepartemenN = ""; $pilihDepartemenY = "checked"; }

	$dataKategori 		= isset($_POST['rbDataKategori']) ? $_POST['rbDataKategori'] : $my2Data['mu_data_kategori'];
		if($dataKategori =="No") { $pilihKategoriN = "checked"; $pilihKategoriY = ""; } else { $pilihKategoriN = ""; $pilihKategoriY = "checked"; }

	$dataLokasi 		= isset($_POST['rbDataLokasi']) ? $_POST['rbDataLokasi'] : $my2Data['mu_data_lokasi'];
		if($dataLokasi =="No") { $pilihLokasiN = "checked"; $pilihLokasiY = ""; } else { $pilihLokasiN = ""; $pilihLokasiY = "checked"; }

	$dataBarang 		= isset($_POST['rbDataBarang']) ? $_POST['rbDataBarang'] : $my2Data['mu_data_barang'];
		if($dataBarang =="No") { $pilihBarangN = "checked"; $pilihBarangY = ""; } else { $pilihBarangN = ""; $pilihBarangY = "checked"; }

	$dataInventaris 		= isset($_POST['rbDataInventaris']) ? $_POST['rbDataInventaris'] : $my2Data['mu_data_inventaris'];
		if($dataInventaris =="No") { $pilihInventarisN = "checked"; $pilihInventarisY = ""; } else { $pilihInventarisN = ""; $pilihInventarisY = "checked"; }

	$dataCariBarang 		= isset($_POST['rbCariBarang']) ? $_POST['rbCariBarang'] : $my2Data['mu_pencarian'];
		if($dataCariBarang =="No") { $pilihCariBarangN = "checked"; $pilihCariBarangY = ""; } else { $pilihCariBarangN = ""; $pilihCariBarangY = "checked"; }

	$dataBarcode 		= isset($_POST['rbCetakBarcode']) ? $_POST['rbCetakBarcode'] : $my2Data['mu_barcode'];
		if($dataBarcode =="No") { $pilihBarcodeN = "checked"; $pilihBarcodeY = ""; } else { $pilihBarcodeN = ""; $pilihBarcodeY = "checked"; }

// TRANSAKSI PEMBELIAN
	$dataPengadaan 		= isset($_POST['rbPengadaan']) ? $_POST['rbPengadaan'] : $my2Data['mu_trans_pengadaan'];
		if($dataPengadaan =="No") { $pilihPengadaanN = "checked"; $pilihPengadaanY = ""; } else { $pilihPengadaanN = ""; $pilihPengadaanY = "checked"; }

	$dataPenempatan 		= isset($_POST['rbPenempatan']) ? $_POST['rbPenempatan'] : $my2Data['mu_trans_penempatan'];
		if($dataPenempatan =="No") { $pilihPenempatanN = "checked"; $pilihPenempatanY = ""; } else { $pilihPenempatanN = ""; $pilihPenempatanY = "checked"; }

	$dataMutasi 		= isset($_POST['rbMutasi']) ? $_POST['rbMutasi'] : $my2Data['mu_trans_mutasi'];
		if($dataMutasi =="No") { $pilihMutasiN = "checked"; $pilihMutasiY = ""; } else { $pilihMutasiN = ""; $pilihMutasiY = "checked"; }

	$dataPeminjaman 		= isset($_POST['rbPeminjaman']) ? $_POST['rbPeminjaman'] : $my2Data['mu_trans_peminjaman'];
		if($dataPeminjaman =="No") { $pilihPeminjamanN = "checked"; $pilihPeminjamanY = ""; } else { $pilihPeminjamanN = ""; $pilihPeminjamanY = "checked"; }

// TOOLS
	$dataBackupRestore 		= isset($_POST['rbBackupRestore']) ? $_POST['rbBackupRestore'] : $my2Data['mu_backup_restore'];
		if($dataBackupRestore =="No") { $pilihBackupRestoreN = "checked"; $pilihBackupRestoreY = ""; } else { $pilihBackupRestoreN = ""; $pilihBackupRestoreY = "checked"; }

	$dataExportBarang 		= isset($_POST['rbExportBarang']) ? $_POST['rbExportBarang'] : $my2Data['mu_export_barang'];
		if($dataExportBarang =="No") { $pilihExportBarangN = "checked"; $pilihExportBarangY = ""; } else { $pilihExportBarangN = ""; $pilihExportBarangY = "checked"; }
	
	$dataImportBarang 		= isset($_POST['rbImportBarang']) ? $_POST['rbImportBarang'] : $my2Data['mu_import_barang'];
		if($dataImportBarang =="No") { $pilihImportBarangN = "checked"; $pilihImportBarangY = ""; } else { $pilihImportBarangN = ""; $pilihImportBarangY = "checked"; }

	$dataExportPegawai 		= isset($_POST['rbExportPegawai']) ? $_POST['rbExportPegawai'] : $my2Data['mu_export_pegawai'];
		if($dataExportPegawai =="No") { $pilihExportPegawaiN = "checked"; $pilihExportPegawaiY = ""; } 
		else { $pilihExportPegawaiN = ""; $pilihExportPegawaiY = "checked"; }
	
	$dataImportPegawai 		= isset($_POST['rbImportPegawai']) ? $_POST['rbImportPegawai'] : $my2Data['mu_import_pegawai'];
		if($dataImportPegawai =="No") { $pilihImportPegawaiN = "checked"; $pilihImportPegawaiY = ""; } 
		else { $pilihImportPegawaiN = ""; $pilihImportPegawaiY = "checked"; }

	$lapPetugas 			= isset($_POST['rbLapPetugas']) ? $_POST['rbLapPetugas'] : $my2Data['mlap_petugas'];
		if($lapPetugas =="No") { $pilihLapPetugasN = "checked"; $pilihLapPetugasY = ""; } else { $pilihLapPetugasN = ""; $pilihLapPetugasY = "checked"; }

	$lapPegawai 		= isset($_POST['rbLapPegawai']) ? $_POST['rbLapPegawai'] : $my2Data['mlap_pegawai'];
		if($lapPegawai =="No") { $pilihLapPegawaiN = "checked"; $pilihLapPegawaiY = ""; } else { $pilihLapPegawaiN = ""; $pilihLapPegawaiY = "checked"; }

	$lapSupplier 		= isset($_POST['rbLapSupplier']) ? $_POST['rbLapSupplier'] : $my2Data['mlap_pegawai'];
		if($lapSupplier =="No") { $pilihLapSupplierN = "checked"; $pilihLapSupplierY = ""; } else { $pilihLapSupplierN = ""; $pilihLapSupplierY = "checked"; }

	$lapDepartemen 		= isset($_POST['rbLapDepartemen']) ? $_POST['rbLapDepartemen'] : $my2Data['mlap_departemen'];
		if($lapDepartemen =="No") { $pilihLapDepartemenN = "checked"; $pilihLapDepartemenY = ""; } else { $pilihLapDepartemenN = ""; $pilihLapDepartemenY = "checked"; }

	$lapKategori 		= isset($_POST['rbLapKategori']) ? $_POST['rbLapKategori'] : $my2Data['mlap_kategori'];
		if($lapKategori =="No") { $pilihLapKategoriN = "checked"; $pilihLapKategoriY = ""; } else { $pilihLapKategoriN = ""; $pilihLapKategoriY = "checked"; }

	$lapLokasi 		= isset($_POST['rbLapLokasi']) ? $_POST['rbLapLokasi'] : $my2Data['mlap_lokasi'];
		if($lapLokasi =="No") { $pilihLapLokasiN = "checked"; $pilihLapLokasiY = ""; } else { $pilihLapLokasiN = ""; $pilihLapLokasiY = "checked"; }

	$lapBarangKategori 		= isset($_POST['rbLapBarangKategori']) ? $_POST['rbLapBarangKategori'] : $my2Data['mlap_barang_kategori'];
		if($lapBarangKategori =="No") { $pilihLapBarangKategoriN = "checked"; $pilihLapBarangKategoriY = ""; } 
		else { $pilihLapBarangKategoriN = ""; $pilihLapBarangKategoriY = "checked"; }

	$lapBarangLokasi 		= isset($_POST['rbLapBarangLokasi']) ? $_POST['rbLapBarangLokasi'] : $my2Data['mlap_barang_lokasi'];
		if($lapBarangLokasi =="No") { $pilihLapBarangLokasiN = "checked"; $pilihLapBarangLokasiY = ""; } 
		else { $pilihLapBarangLokasiN = ""; $pilihLapBarangLokasiY = "checked"; }

	
	# PENGADAAN
	$lapPengadaanPeriode 		= isset($_POST['rbLapPengadaanPeriode']) ? $_POST['rbLapPengadaanPeriode'] : $my2Data['mlap_pengadaan_periode'];
		if($lapPengadaanPeriode =="No") { $pilihLapPengadaanPeriodeN = "checked"; $pilihLapPengadaanPeriodeY = ""; } 
		else { $pilihLapPengadaanPeriodeN = ""; $pilihLapPengadaanPeriodeY = "checked"; }

	$lapPengadaanBulan 		= isset($_POST['rbLapPengadaanBulan']) ? $_POST['rbLapPengadaanBulan'] : $my2Data['mlap_pengadaan_bulan'];
		if($lapPengadaanBulan =="No") { $pilihLapPengadaanBulanN = "checked"; $pilihLapPengadaanBulanY = ""; } 
		else { $pilihLapPengadaanBulanN = ""; $pilihLapPengadaanBulanY = "checked"; }

	$lapPengadaanSupplier 		= isset($_POST['rbLapPengadaanSupplier']) ? $_POST['rbLapPengadaanSupplier'] : $my2Data['mlap_pengadaan_supplier'];
		if($lapPengadaanSupplier =="No") { $pilihLapPengadaanSupplierN = "checked"; $pilihLapPengadaanSupplierY = ""; } 
		else { $pilihLapPengadaanSupplierN = ""; $pilihLapPengadaanSupplierY = "checked"; }

	$lapPengadaanBarangPeriode 		= isset($_POST['rbLapPengadaanBarangPeriode']) ? $_POST['rbLapPengadaanBarangPeriode'] : $my2Data['mlap_pengadaan_barang_periode'];
		if($lapPengadaanBarangPeriode =="No") { $pilihLapPengadaanBarangPeriodeN = "checked"; $pilihLapPengadaanBarangPeriodeY = ""; } 
		else { $pilihLapPengadaanBarangPeriodeN = ""; $pilihLapPengadaanBarangPeriodeY = "checked"; }

	$lapPengadaanBarangBulan 		= isset($_POST['rbLapPengadaanBarangBulan']) ? $_POST['rbLapPengadaanBarangBulan'] : $my2Data['mlap_pengadaan_barang_bulan'];
		if($lapPengadaanBarangBulan =="No") { $pilihLapPengadaanBarangBulanN = "checked"; $pilihLapPengadaanBarangBulanY = ""; } 
		else { $pilihLapPengadaanBarangBulanN = ""; $pilihLapPengadaanBarangBulanY = "checked"; }

	$lapPengadaanBarangKategori 		= isset($_POST['rbLapPengadaanBarangKategori']) ? $_POST['rbLapPengadaanBarangKategori'] : $my2Data['mlap_pengadaan_barang_kategori'];
		if($lapPengadaanBarangKategori =="No") { $pilihLapPengadaanBarangKategoriN = "checked"; $pilihLapPengadaanBarangKategoriY = ""; } 
		else { $pilihLapPengadaanBarangKategoriN = ""; $pilihLapPengadaanBarangKategoriY = "checked"; }

	$lapPengadaanBarangSupplier 		= isset($_POST['rbLapPengadaanBarangSupplier']) ? $_POST['rbLapPengadaanBarangSupplier'] : $my2Data['mlap_pengadaan_barang_supplier'];
		if($lapPengadaanBarangSupplier =="No") { $pilihLapPengadaanBarangSupplierN = "checked"; $pilihLapPengadaanBarangSupplierY = ""; } 
		else { $pilihLapPengadaanBarangSupplierN = ""; $pilihLapPengadaanBarangSupplierY = "checked"; }

	# PENEMPATAN BARANG

	$lapPenempatanPeriode 		= isset($_POST['rbLapPenempatanPeriode']) ? $_POST['rbLapPenempatanPeriode'] : $my2Data['mlap_penempatan_periode'];
		if($lapPenempatanPeriode =="No") { $pilihLapPenempatanPeriodeN = "checked"; $pilihLapPenempatanPeriodeY = ""; } 
		else { $pilihLapPenempatanPeriodeN = ""; $pilihLapPenempatanPeriodeY = "checked"; }

	$lapPenempatanBulan 		= isset($_POST['rbLapPenempatanBulan']) ? $_POST['rbLapPenempatanBulan'] : $my2Data['mlap_penempatan_bulan'];
		if($lapPenempatanBulan =="No") { $pilihLapPenempatanBulanN = "checked"; $pilihLapPenempatanBulanY = ""; } 
		else { $pilihLapPenempatanBulanN = ""; $pilihLapPenempatanBulanY = "checked"; }

	$lapPenempatanLokasi 		= isset($_POST['rbLapPenempatanLokasi']) ? $_POST['rbLapPenempatanLokasi'] : $my2Data['mlap_penempatan_lokasi'];
		if($lapPenempatanLokasi =="No") { $pilihLapPenempatanLokasiN = "checked"; $pilihLapPenempatanLokasiY = ""; } 
		else { $pilihLapPenempatanLokasiN = ""; $pilihLapPenempatanLokasiY = "checked"; }
		
	# MUTASI BARANG (PEMINDAHAN)

	$lapMutasiPeriode 		= isset($_POST['rbLapMutasiPeriode']) ? $_POST['rbLapMutasiPeriode'] : $my2Data['mlap_mutasi_periode'];
		if($lapMutasiPeriode =="No") { $pilihLapMutasiPeriodeN = "checked"; $pilihLapMutasiPeriodeY = ""; } 
		else { $pilihLapMutasiPeriodeN = ""; $pilihLapMutasiPeriodeY = "checked"; }

	$lapMutasiBulan 		= isset($_POST['rbLapMutasiBulan']) ? $_POST['rbLapMutasiBulan'] : $my2Data['mlap_mutasi_bulan'];
		if($lapMutasiBulan =="No") { $pilihLapMutasiBulanN = "checked"; $pilihLapMutasiBulanY = ""; } 
		else { $pilihLapMutasiBulanN = ""; $pilihLapMutasiBulanY = "checked"; }

	$lapMutasiLokasi 		= isset($_POST['rbLapMutasiLokasi']) ? $_POST['rbLapMutasiLokasi'] : $my2Data['mlap_mutasi_lokasi'];
		if($lapMutasiLokasi =="No") { $pilihLapMutasiLokasiN = "checked"; $pilihLapMutasiLokasiY = ""; } 
		else { $pilihLapMutasiLokasiN = ""; $pilihLapMutasiLokasiY = "checked"; }
		
	# PEMINJAMAN

	$lapPeminjamanPeriode 		= isset($_POST['rbLapPeminjamanPeriode']) ? $_POST['rbLapPeminjamanPeriode'] : $my2Data['mlap_peminjaman_periode'];
		if($lapPeminjamanPeriode =="No") { $pilihLapPeminjamanPeriodeN = "checked"; $pilihLapPeminjamanPeriodeY = ""; } 
		else { $pilihLapPeminjamanPeriodeN = ""; $pilihLapPeminjamanPeriodeY = "checked"; }

	$lapPeminjamanBulan 		= isset($_POST['rbLapPeminjamanBulan']) ? $_POST['rbLapPeminjamanBulan'] : $my2Data['mlap_peminjaman_bulan'];
		if($lapPeminjamanBulan =="No") { $pilihLapPeminjamanBulanN = "checked"; $pilihLapPeminjamanBulanY = ""; } 
		else { $pilihLapPeminjamanBulanN = ""; $pilihLapPeminjamanBulanY = "checked"; }


	$lapPeminjamanPegawai 		= isset($_POST['rbLapPeminjamanPegawai']) ? $_POST['rbLapPeminjamanPegawai'] : $my2Data['mlap_peminjaman_pegawai'];
		if($lapPeminjamanPegawai =="No") { $pilihLapPeminjamanPegawaiN = "checked"; $pilihLapPeminjamanPegawaiY = ""; } 
		else { $pilihLapPeminjamanPegawaiN = ""; $pilihLapPeminjamanPegawaiY = "checked"; }
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><b>UBAH DATA PETUGAS</b></th>
    </tr>
    <tr>
      <td width="332"><b>Kode</b></td>
      <td width="5"><b>:</b></td>
      <td width="929"> <input name="textfield" type="text"  value="<?php echo $dataKode; ?>" size="10" maxlength="5"  readonly="readonly"/>
      <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td><b>Nama Petugas </b></td>
      <td><b>:</b></td>
      <td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td><b>No. Telepon </b></td>
      <td><b>:</b></td>
      <td><input name="txtTelepon" type="text" value="<?php echo $dataTelepon; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td><b>Username</b></td>
      <td><b>:</b></td>
      <td><input name="txtUsername" type="text"  value="<?php echo $dataUsername; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td><b>Password</b></td>
      <td><b>:</b></td>
      <td><input name="txtPassword" type="password" size="20" maxlength="20" />
      <input name="txtPassLama" type="hidden" value="<?php echo $myData['password']; ?>" /></td>
    </tr>
    <tr>
      <td><b>Level</b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbLevel">
          <option value="Kosong">....</option>
          <?php
		  $pilihan	= array("Petugas", "Admin");
          foreach ($pilihan as $nilai) {
            if ($dataLevel==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>HAK AKSES </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>MASTER DATA </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong> Data Petugas </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataPetugas" type="radio" value="No" <?php echo $pilihPetugasN; ?>/>
        No
        <input name="rbDataPetugas" type="radio" value="Yes" <?php echo $pilihPetugasY; ?>/>
        Yes </td>
    </tr>
    <tr>
      <td><strong> Data Pegawai </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataPegawai" type="radio" value="No"  <?php echo $pilihPegawaiN; ?> />
        No
        <input name="rbDataPegawai" type="radio" value="Yes" <?php echo $pilihPegawaiY; ?>/>
        Yes </td>
    </tr>
    <tr>
      <td><strong> Data Supplier </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataSupplier" type="radio" value="No"  <?php echo $pilihSupplierN; ?> />
        No
        <input name="rbDataSupplier" type="radio" value="Yes" <?php echo $pilihSupplierY; ?>/>
        Yes </td>
    </tr>
    <tr>
      <td><strong> Data Departemen </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataDepartemen" type="radio" value="No" <?php echo $pilihDepartemenN; ?> />
        No
        <input name="rbDataDepartemen" type="radio" value="Yes" <?php echo $pilihDepartemenY; ?>/>
        Yes </td>
    </tr>
    <tr>
      <td><strong> Data Kategori </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataKategori" type="radio" value="No" <?php echo $pilihKategoriN; ?> />
        No
        <input name="rbDataKategori" type="radio" value="Yes" <?php echo $pilihKategoriY; ?>/>
        Yes </td>
    </tr>
    <tr>
      <td><strong> Data Lokasi </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataLokasi" type="radio" value="No" <?php echo $pilihLokasiN; ?> />
        No
        <input name="rbDataLokasi" type="radio" value="Yes" <?php echo $pilihLokasiY; ?>/>
        Yes </td>
    </tr>
    <tr>
      <td><strong> Data Barang </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataBarang" type="radio" value="No" <?php echo $pilihBarangN; ?> />
        No
        <input name="rbDataBarang" type="radio" value="Yes" <?php echo $pilihBarangY; ?>/>
        Yes </td>
    </tr>
    <tr>
      <td><strong> Data Inventaris Barang </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataInventaris" type="radio" value="No" <?php echo $pilihInventarisN; ?> />
        No
        <input name="rbDataInventaris" type="radio" value="Yes" <?php echo $pilihInventarisY; ?>/>
        Yes </td>
    </tr>
    <tr>
      <td><strong>Pencarian Barang </strong></td>
      <td><b>:</b></td>
      <td><input name="rbCariBarang" type="radio" value="No" <?php echo $pilihCariBarangN; ?> />
        No
        <input name="rbCariBarang" type="radio" value="Yes" <?php echo $pilihCariBarangY; ?>/>
        Yes </td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>TOOLS</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong> Cetak Label Barcode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbCetakBarcode" type="radio" value="No" <?php echo $pilihBarcodeN; ?> />
        No
        <input name="rbCetakBarcode" type="radio" value="Yes" <?php echo $pilihBarcodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong> Backup &amp; Restore Database </strong></td>
      <td><b>:</b></td>
      <td><input name="rbBackupRestore" type="radio" value="No" <?php echo $pilihBackupRestoreN; ?> />
        No
        <input name="rbBackupRestore" type="radio" value="Yes" <?php echo $pilihBackupRestoreY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Export Barang (Xls) </strong></td>
      <td><b>:</b></td>
      <td><input name="rbExportBarang" type="radio" value="No" <?php echo $pilihExportBarangN; ?> />
        No
        <input name="rbExportBarang" type="radio" value="Yes" <?php echo $pilihExportBarangY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Import Barang (Xls) </strong></td>
      <td><b>:</b></td>
      <td><input name="rbImportBarang" type="radio" value="No" <?php echo $pilihImportBarangN; ?> />
        No
        <input name="rbImportBarang" type="radio" value="Yes" <?php echo $pilihImportBarangY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Export Pegawai (Xls) </strong></td>
      <td><b>:</b></td>
      <td><input name="rbExportPegawai" type="radio" value="No" <?php echo $pilihExportPegawaiN; ?> />
        No
        <input name="rbExportPegawai" type="radio" value="Yes" <?php echo $pilihExportPegawaiY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Import Pegawai (Xls) </strong></td>
      <td><b>:</b></td>
      <td><input name="rbImportPegawai" type="radio" value="No" <?php echo $pilihImportPegawaiN; ?> />
        No
        <input name="rbImportPegawai" type="radio" value="Yes" <?php echo $pilihImportPegawaiY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>TRANSAKSI</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong> Transaksi Pengadaan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbPengadaan" type="radio" value="No" <?php echo $pilihPengadaanN; ?> />
        No
        <input name="rbPengadaan" type="radio" value="Yes" <?php echo $pilihPengadaanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong> Transaksi Penempatan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbPenempatan" type="radio" value="No" <?php echo $pilihPenempatanN; ?> />
        No
        <input name="rbPenempatan" type="radio" value="Yes" <?php echo $pilihPenempatanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong> Transaksi Mutasi </strong></td>
      <td><b>:</b></td>
      <td><input name="rbMutasi" type="radio" value="No" <?php echo $pilihMutasiN; ?> />
        No
        <input name="rbMutasi" type="radio" value="Yes" <?php echo $pilihMutasiY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Transaksi Retur Jual </strong></td>
      <td><b>:</b></td>
      <td><input name="rbPeminjaman" type="radio" value="No" <?php echo $pilihPeminjamanN; ?> />
        No
        <input name="rbPeminjaman" type="radio" value="Yes" <?php echo $pilihPeminjamanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>LAPORAN MASTER DATA </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Laporan Petugas </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPetugas" type="radio" value="No" <?php echo $pilihLapPetugasN; ?> />
        No
        <input name="rbLapPetugas" type="radio" value="Yes" <?php echo $pilihLapPetugasY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Pegawai </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPegawai" type="radio" value="No" <?php echo $pilihLapPegawaiN; ?> />
        No
        <input name="rbLapPegawai" type="radio" value="Yes" <?php echo $pilihLapPegawaiY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Supplier </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapSupplier" type="radio" value="No" <?php echo $pilihLapSupplierN; ?> />
        No
        <input name="rbLapSupplier" type="radio" value="Yes" <?php echo $pilihLapSupplierY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Departemen </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapDepartemen" type="radio" value="No" <?php echo $pilihLapDepartemenN; ?> />
        No
        <input name="rbLapDepartemen" type="radio" value="Yes" <?php echo $pilihLapDepartemenY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Kategori </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapKategori" type="radio" value="No" <?php echo $pilihLapKategoriN; ?> />
        No
        <input name="rbLapKategori" type="radio" value="Yes" <?php echo $pilihLapKategoriY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Lokasi </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapLokasi" type="radio" value="No" <?php echo $pilihLapLokasiN; ?> />
        No
        <input name="rbLapLokasi" type="radio" value="Yes" <?php echo $pilihLapLokasiY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Berang per Kategori </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapBarangKategori" type="radio" value="No" <?php echo $pilihLapBarangKategoriN; ?> />
        No
        <input name="rbLapBarangKategori" type="radio" value="Yes" <?php echo $pilihLapBarangKategoriY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Berang per Lokasi </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapBarangLokasi" type="radio" value="No" <?php echo $pilihLapBarangLokasiN; ?> />
        No
        <input name="rbLapBarangLokasi" type="radio" value="Yes" <?php echo $pilihLapBarangLokasiY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>LAPORAN PENGADAAN </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Laporan Pengadaan per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPengadaanPeriode" type="radio" value="No" <?php echo $pilihLapPengadaanPeriodeN; ?> />
        No
        <input name="rbLapPengadaanPeriode" type="radio" value="Yes" <?php echo $pilihLapPengadaanPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pengadaan per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPengadaanBulan" type="radio" value="No" <?php echo $pilihLapPengadaanBulanN; ?> />
        No
        <input name="rbLapPengadaanBulan" type="radio" value="Yes" <?php echo $pilihLapPengadaanBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pengadaan per Supplier </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPengadaanSupplier" type="radio" value="No" <?php echo $pilihLapPengadaanSupplierN; ?> />
        No
        <input name="rbLapPengadaanSupplier" type="radio" value="Yes" <?php echo $pilihLapPengadaanSupplierY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pengadaan Brg per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPengadaanBarangPeriode" type="radio" value="No" <?php echo $pilihLapPengadaanBarangPeriodeN; ?> />
        No
        <input name="rbLapPengadaanBarangPeriode" type="radio" value="Yes" <?php echo $pilihLapPengadaanBarangPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pengadaan Brg per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPengadaanBarangBulan" type="radio" value="No" <?php echo $pilihLapPengadaanBarangBulanN; ?> />
        No
        <input name="rbLapPengadaanBarangBulan" type="radio" value="Yes" <?php echo $pilihLapPengadaanBarangBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pengadaan Rekap per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPengadaanBarangKategori" type="radio" value="No" <?php echo $pilihLapPengadaanBarangKategoriN; ?> />
        No
        <input name="rbLapPengadaanBarangKategori" type="radio" value="Yes" <?php echo $pilihLapPengadaanBarangKategoriY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pengadaan Rekap per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPengadaanBarangSupplier" type="radio" value="No" <?php echo $pilihLapPengadaanBarangSupplierN; ?> />
        No
        <input name="rbLapPengadaanBarangSupplier" type="radio" value="Yes" <?php echo $pilihLapPengadaanBarangSupplierY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>LAPORAN PENEMPATAN </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Laporan Penempatan per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenempatanPeriode" type="radio" value="No" <?php echo $pilihLapPenempatanPeriodeN; ?> />
        No
        <input name="rbLapPenempatanPeriode" type="radio" value="Yes" <?php echo $pilihLapPenempatanPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penempatan per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenempatanBulan" type="radio" value="No" <?php echo $pilihLapPenempatanBulanN; ?> />
        No
        <input name="rbLapPenempatanBulan" type="radio" value="Yes" <?php echo $pilihLapPenempatanBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penempatan Brg Lokasi </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenempatanLokasi" type="radio" value="No" <?php echo $pilihLapPenempatanLokasiN; ?> />
        No
        <input name="rbLapPenempatanLokasi" type="radio" value="Yes" <?php echo $pilihLapPenempatanLokasiY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>LAPORAN MUTASI </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Laporan Mutasi per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapMutasiPeriode" type="radio" value="No" <?php echo $pilihLapMutasiPeriodeN; ?> />
        No
        <input name="rbLapMutasiPeriode" type="radio" value="Yes" <?php echo $pilihLapMutasiPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Mutasi per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapMutasiBulan" type="radio" value="No" <?php echo $pilihLapMutasiBulanN; ?> />
        No
        <input name="rbLapMutasiBulan" type="radio" value="Yes" <?php echo $pilihLapMutasiBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Mutasi per Lokasi </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapMutasiLokasi" type="radio" value="No" <?php echo $pilihLapMutasiLokasiN; ?> />
        No
        <input name="rbLapMutasiLokasi" type="radio" value="Yes" <?php echo $pilihLapMutasiLokasiY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td bgcolor="#F5F5F5"><strong>LAPORAN PEMINJAMAN </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Laporan Peminjaman per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPeminjamanPeriode" type="radio" value="No" <?php echo $pilihLapPeminjamanPeriodeN; ?> />
        No
        <input name="rbLapPeminjamanPeriode" type="radio" value="Yes" <?php echo $pilihLapPeminjamanPeriodeY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Peminjaman per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPeminjamanBulan" type="radio" value="No" <?php echo $pilihLapPeminjamanBulanN; ?> />
        No
        <input name="rbLapPeminjamanBulan" type="radio" value="Yes" <?php echo $pilihLapPeminjamanBulanY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Peminjaman per Pegawai </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPeminjamanPegawai" type="radio" value="No" <?php echo $pilihLapPeminjamanPegawaiN; ?> />
        No
        <input name="rbLapPeminjamanPegawai" type="radio" value="Yes" <?php echo $pilihLapPeminjamanPegawaiY; ?>/>
        Yes</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="btnSimpan" value=" Simpan " /> </td>
    </tr>
  </table>
</form>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
