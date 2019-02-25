<?php
# KONTROL MENU PROGRAM
if($_GET) {
	// Jika mendapatkan variabel URL ?page
	switch($_GET['open']){				
		case '' :
			if(!file_exists ("main.php")) die ("Empty Main Page!"); 
			include "main.php";	break;
			
		case 'Halaman-Utama' :
			if(!file_exists ("main.php")) die ("File tidak ditemukan !"); 
			include "main.php";	break;
			
		case 'Login' :
			if(!file_exists ("login.php")) die ("File tidak ditemukan !"); 
			include "login.php"; break;
			
		case 'Login-Validasi' :
			if(!file_exists ("login_validasi.php")) die ("File tidak ditemukan !"); 
			include "login_validasi.php"; break;
			
		case 'Logout' :
			if(!file_exists ("login_out.php")) die ("File tidak ditemukan !"); 
			include "login_out.php"; break;		

		# PETUGAS / USER LOGIN (Admin, Petugas)
		case 'Petugas-Data' :
			if(!file_exists ("petugas_data.php")) die ("File tidak ditemukan !"); 
			include "petugas_data.php";	 break;		
		case 'Petugas-Add' :
			if(!file_exists ("petugas_add.php")) die ("File tidak ditemukan !"); 
			include "petugas_add.php";	 break;		
		case 'Petugas-Delete' :
			if(!file_exists ("petugas_delete.php")) die ("File tidak ditemukan !"); 
			include "petugas_delete.php"; break;		
		case 'Petugas-Edit' :
			if(!file_exists ("petugas_edit.php")) die ("File tidak ditemukan !"); 
			include "petugas_edit.php"; break;	
			
		# PEGAWAI
		case 'Pegawai-Data' :
			if(!file_exists ("pegawai_data.php")) die ("File tidak ditemukan !"); 
			include "pegawai_data.php";	 break;
		case 'Pegawai-Add' :
			if(!file_exists ("pegawai_add.php")) die ("File tidak ditemukan !"); 
			include "pegawai_add.php";	 break;
		case 'Pegawai-Delete' :
			if(!file_exists ("pegawai_delete.php")) die ("File tidak ditemukan !"); 
			include "pegawai_delete.php"; break;
		case 'Pegawai-Edit' :
			if(!file_exists ("pegawai_edit.php")) die ("File tidak ditemukan !"); 
			include "pegawai_edit.php"; break;

		# DEPARTEMEN
		case 'Departemen-Data' :
			if(!file_exists ("departemen_data.php")) die ("File tidak ditemukan !"); 
			include "departemen_data.php"; break;		
		case 'Departemen-Add' :
			if(!file_exists ("departemen_add.php")) die ("File tidak ditemukan !"); 
			include "departemen_add.php";	break;		
		case 'Departemen-Delete' :
			if(!file_exists ("departemen_delete.php")) die ("File tidak ditemukan !"); 
			include "departemen_delete.php"; break;		
		case 'Departemen-Edit' :
			if(!file_exists ("departemen_edit.php")) die ("File tidak ditemukan !"); 
			include "departemen_edit.php"; break;	
			
		# LOKASI / RUANG
		case 'Lokasi-Data' :
			if(!file_exists ("lokasi_data.php")) die ("File tidak ditemukan !"); 
			include "lokasi_data.php"; break;		
		case 'Lokasi-Add' :
			if(!file_exists ("lokasi_add.php")) die ("File tidak ditemukan !"); 
			include "lokasi_add.php";	break;		
		case 'Lokasi-Delete' :
			if(!file_exists ("lokasi_delete.php")) die ("File tidak ditemukan !"); 
			include "lokasi_delete.php"; break;		
		case 'Lokasi-Edit' :
			if(!file_exists ("lokasi_edit.php")) die ("File tidak ditemukan !"); 
			include "lokasi_edit.php"; break;	

		# KATEGORI / PENGELOMPOKAN JENIS BARANG
		case 'Kategori-Data' :
			if(!file_exists ("kategori_data.php")) die ("File tidak ditemukan !"); 
			include "kategori_data.php"; break;		
		case 'Kategori-Add' :
			if(!file_exists ("kategori_add.php")) die ("File tidak ditemukan !"); 
			include "kategori_add.php";	break;		
		case 'Kategori-Delete' :
			if(!file_exists ("kategori_delete.php")) die ("File tidak ditemukan !"); 
			include "kategori_delete.php"; break;		
		case 'Kategori-Edit' :
			if(!file_exists ("kategori_edit.php")) die ("File tidak ditemukan !"); 
			include "kategori_edit.php"; break;	
			
		# BARANG / PRODUK YANG DIJUAL
		case 'Barang-Data' :
			if(!file_exists ("barang_data.php")) die ("File tidak ditemukan !"); 
			include "barang_data.php"; break;		
		case 'Barang-Add' :
			if(!file_exists ("barang_add.php")) die ("File tidak ditemukan !"); 
			include "barang_add.php"; break;		
		case 'Barang-Delete' :
			if(!file_exists ("barang_delete.php")) die ("File tidak ditemukan !"); 
			include "barang_delete.php"; break;		
		case 'Barang-Edit' :
			if(!file_exists ("barang_edit.php")) die ("File tidak ditemukan !"); 
			include "barang_edit.php"; break;	
			
		case 'Pencarian-Aset' :
			if(!file_exists ("barang_cari.php")) die ("File tidak ditemukan !"); 
			include "barang_cari.php"; break;		
			
		case 'Barang-View' :
			if(!file_exists ("barang_view.php")) die ("File tidak ditemukan !"); 
			include "barang_view.php"; break;	

		case 'Inventaris-Data' :
			if(!file_exists ("inventaris_data.php")) die ("File tidak ditemukan !"); 
			include "inventaris_data.php"; break;	

		case 'Inventaris-Edit' :
			if(!file_exists ("inventaris_edit.php")) die ("File tidak ditemukan !"); 
			include "inventaris_edit.php"; break;	

		case 'Inventaris-Resume' :
			if(!file_exists ("inventaris_resume.php")) die ("File tidak ditemukan !"); 
			include "inventaris_resume.php"; break;	

		case 'Inventaris-Pemeliharaan' :
			if(!file_exists ("inventaris_pemeliharaan.php")) die ("File tidak ditemukan !"); 
			include "inventaris_pemeliharaan.php"; break;	

		case 'Inventaris-View' :
			if(!file_exists ("inventaris_view.php")) die ("File tidak ditemukan !"); 
			include "inventaris_view.php"; break;	

		# TOOLS / PERLENGKAPAN
		case 'Cetak-Barcode' :
			if(!file_exists ("cetak_barcode.php")) die ("File tidak ditemukan !"); 
			include "cetak_barcode.php"; break;		
		case 'Cetak-Barcode-View' :
			if(!file_exists ("cetak_barcode_view.php")) die ("File tidak ditemukan !"); 
			include "cetak_barcode_view.php"; break;		
			
		case 'Backup-Restore' :
			if(!file_exists ("backup_restore.php")) die ("File tidak ditemukan !"); 
			include "backup_restore.php"; break;		

		# SUPPLIER (PEMASOK)
		case 'Supplier-Data' :
			if(!file_exists ("supplier_data.php")) die ("File tidak ditemukan !"); 
			include "supplier_data.php";	 break;		
		case 'Supplier-Add' :
			if(!file_exists ("supplier_add.php")) die ("File tidak ditemukan !"); 
			include "supplier_add.php";	 break;		
		case 'Supplier-Delete' :
			if(!file_exists ("supplier_delete.php")) die ("File tidak ditemukan !"); 
			include "supplier_delete.php"; break;		
		case 'Supplier-Edit' :				
			if(!file_exists ("supplier_edit.php")) die ("File tidak ditemukan !"); 
			include "supplier_edit.php"; break;	

		# REPORT INFORMASI / LAPORAN DATA
		case 'Laporan-Cetak' :
				if(!file_exists ("menu_laporan.php")) die ("File tidak ditemukan !"); 
				include "menu_laporan.php"; break;

			# LAPORAN MASTER DATA (petugas, Supplier, Pelanggan, Kategori dan Barang)
			case 'Laporan-Petugas' :
				if(!file_exists ("laporan_petugas.php")) die ("File tidak ditemukan !"); 
				include "laporan_petugas.php"; break;
	
			case 'Laporan-Supplier' :
				if(!file_exists ("laporan_supplier.php")) die ("File tidak ditemukan !"); 
				include "laporan_supplier.php"; break;
				
			case 'Laporan-Pegawai' :
				if(!file_exists ("laporan_pegawai.php")) die ("File tidak ditemukan !"); 
				include "laporan_pegawai.php"; break;
				
			case 'Laporan-Pelanggan' :
				if(!file_exists ("laporan_pelanggan.php")) die ("File tidak ditemukan !"); 
				include "laporan_pelanggan.php"; break;

			case 'Laporan-Departemen' :
				if(!file_exists ("laporan_departemen.php")) die ("File tidak ditemukan !"); 
				include "laporan_departemen.php"; break;
				
			case 'Laporan-Lokasi' :
				if(!file_exists ("laporan_lokasi.php")) die ("File tidak ditemukan !"); 
				include "laporan_lokasi.php"; break;

			case 'Laporan-Kategori' :
				if(!file_exists ("laporan_kategori.php")) die ("File tidak ditemukan !"); 
				include "laporan_kategori.php"; break;

			case 'Laporan-Barang' :
				if(!file_exists ("laporan_barang.php")) die ("File tidak ditemukan !"); 
				include "laporan_barang.php"; break;
					
			case 'Laporan-Barang-Kategori' :
				if(!file_exists ("laporan_barang_kategori.php")) die ("File tidak ditemukan !"); 
				include "laporan_barang_kategori.php"; break;
				
			case 'Laporan-Barang-Lokasi' :
				if(!file_exists ("laporan_barang_lokasi.php")) die ("File tidak ditemukan !"); 
				include "laporan_barang_lokasi.php"; break;
				
			case 'Laporan-Inventaris-Barang-1' :
				if(!file_exists ("laporan_inventaris_barang_1.php")) die ("File tidak ditemukan !"); 
				include "laporan_inventaris_barang_1.php"; break;
				
			case 'Laporan-Inventaris-Barang-2' :
				if(!file_exists ("laporan_inventaris_barang_2.php")) die ("File tidak ditemukan !"); 
				include "laporan_inventaris_barang_2.php"; break;
				
			# LAPORAN TRANSAKSI PENGADAAN
			case 'Laporan-Pengadaan-Periode' :
				if(!file_exists ("laporan_pengadaan_periode.php")) die ("File tidak ditemukan !"); 
				include "laporan_pengadaan_periode.php"; break;
				
			case 'Laporan-Pengadaan-Bulan' :
				if(!file_exists ("laporan_pengadaan_bulan.php")) die ("File tidak ditemukan !"); 
				include "laporan_pengadaan_bulan.php"; break;
				
			case 'Laporan-Pengadaan-Supplier' :
				if(!file_exists ("laporan_pengadaan_supplier.php")) die ("File tidak ditemukan !"); 
				include "laporan_pengadaan_supplier.php"; break;
			
			// PENGADAAN BARANG 
			case 'Laporan-Pengadaan-Barang-Bulan' :				
				if(!file_exists ("laporan_pengadaan_barang_bulan.php")) die ("File tidak ditemukan !"); 
				include "laporan_pengadaan_barang_bulan.php"; break;
								
			case 'Laporan-Pengadaan-Barang-Periode' :
				if(!file_exists ("laporan_pengadaan_barang_periode.php")) die ("File tidak ditemukan !"); 
				include "laporan_pengadaan_barang_periode.php"; break;

			case 'Laporan-Pengadaan-Barang-Kategori' :				
				if(!file_exists ("laporan_pengadaan_barang_kategori.php")) die ("File tidak ditemukan !"); 
				include "laporan_pengadaan_barang_kategori.php"; break;

			case 'Laporan-Pengadaan-Barang-Supplier' :				
				if(!file_exists ("laporan_pengadaan_barang_supplier.php")) die ("File tidak ditemukan !"); 
				include "laporan_pengadaan_barang_supplier.php"; break;
				
			# LAPORAN TRANSAKSI PENEMPATAN
			case 'Laporan-Penempatan-Periode' :
				if(!file_exists ("laporan_penempatan_periode.php")) die ("File tidak ditemukan !"); 
				include "laporan_penempatan_periode.php"; break;
				
			case 'Laporan-Penempatan-Bulan' :
				if(!file_exists ("laporan_penempatan_bulan.php")) die ("File tidak ditemukan !"); 
				include "laporan_penempatan_bulan.php"; break;
				
			case 'Laporan-Penempatan-Lokasi' :
				if(!file_exists ("laporan_penempatan_lokasi.php")) die ("File tidak ditemukan !"); 
				include "laporan_penempatan_lokasi.php"; break;

			# LAPORAN TRANSAKSI MUTASI (PEMINDAHAN TEMPAT)
			case 'Laporan-Mutasi-Periode' :
				if(!file_exists ("laporan_mutasi_periode.php")) die ("File tidak ditemukan !"); 
				include "laporan_mutasi_periode.php"; break;
				
			case 'Laporan-Mutasi-Bulan' :
				if(!file_exists ("laporan_mutasi_bulan.php")) die ("File tidak ditemukan !"); 
				include "laporan_mutasi_bulan.php"; break;

			case 'Laporan-Mutasi-Lokasi' :				
				if(!file_exists ("laporan_mutasi_lokasi.php")) die ("File tidak ditemukan !"); 
				include "laporan_mutasi_lokasi.php"; break;

			# LAPORAN TRANSAKSI PEMINJAMAN
			case 'Laporan-Peminjaman-Periode' :
				if(!file_exists ("laporan_peminjaman_periode.php")) die ("File tidak ditemukan !"); 
				include "laporan_peminjaman_periode.php"; break;
				
			case 'Laporan-Peminjaman-Bulan' :
				if(!file_exists ("laporan_peminjaman_bulan.php")) die ("File tidak ditemukan !"); 
				include "laporan_peminjaman_bulan.php"; break;
				
			case 'Laporan-Peminjaman-Pegawai' :
				if(!file_exists ("laporan_peminjaman_pegawai.php")) die ("File tidak ditemukan !"); 
				include "laporan_peminjaman_pegawai.php"; break;

		default:
			if(!file_exists ("main.php")) die ("Empty Main Page!"); 
			include "main.php";						
		break;
	}
}
else {
	// Jika tidak mendapatkan variabel URL : ?page
	if(!file_exists ("main.php")) die ("Empty Main Page!"); 
	include "main.php";	
}
?>