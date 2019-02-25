<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_mutasi'] == "Yes") {

// Membaca User yang Login
$userLogin	= $_SESSION['SES_LOGIN'];

# HAPUS DAFTAR BARANG DI TMP
if(isset($_GET['Act'])){
	$Act	= $_GET['Act'];
	$ID		= $_GET['ID'];
	
	if(trim($Act)=="Delete"){
		# Hapus Tmp jika datanya sudah dipindah
		$mySql = "DELETE FROM tmp_mutasi WHERE id='$ID' AND kd_petugas='$userLogin'";
		mysql_query($mySql, $koneksidb) or die ("Gagal menghapus tmp : ".mysql_error());
	}
	if(trim($Act)=="Sucsses"){
		echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
	}
}
// =========================================================================

# TOMBOL TAMBAH (KODE BARANG) DIKLIK  & SAAT ADA KODE INVENTARIS DIINPUT PADA KOTAK OLEH BARCODE ATAU COPY-PASTE-TAB
if(isset($_POST['btnTambah']) or isset($_POST['txtKodeInventaris'])){
	# Baca variabel
	$txtKodeInventaris	= $_POST['txtKodeInventaris'];
	$txtKodeInventaris	= str_replace("'","&acute;",$txtKodeInventaris);
	
	// Validasi form
	$pesanError = array();
	if(trim($txtKodeInventaris) !="") {	
		# Periksa 1, apakah Kode Inventaris yang dimasukkan ada di dalam Database Penempatan Item (lokasi lama)
		// Dan status Aktif-nya masih Yes (masih ditempatkan pada posisi lama)
		$cekSql	= "SELECT * FROM penempatan_item WHERE ( kd_inventaris='$txtKodeInventaris' OR RIGHT(kd_inventaris,6) ='$txtKodeInventaris' ) AND status_aktif='Yes'";
		$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query Cek 1 : ".mysql_error());
		if(mysql_num_rows($cekQry) < 1) {
			$pesanError[] = "Kode/ Label Barang <b>$txtKodeInventaris</b> tidak ditemukan dalam lokasi lama !";
		}
		
		# Periksa 2, apakah Kode Inventaris sudah diinput (sudah masuk dalam TMP) atau belum
		$cek2Sql = "SELECT * FROM tmp_mutasi WHERE kd_inventaris='$txtKodeInventaris' OR RIGHT(kd_inventaris,6) ='$txtKodeInventaris'";
		$cek2Qry = mysql_query($cek2Sql, $koneksidb) or die ("Gagal Query Cek 2 : ".mysql_error());
		if(mysql_num_rows($cek2Qry) >=1) {
			$pesanError[] = "Kode/ Label Barang <b>$txtKodeInventaris</b> sudah di-Input, ganti dengan yang lain !";
		}
	}
			
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# Jika jumlah error pesanError tidak ada
		$bacaSql	= "SELECT * FROM penempatan_item WHERE ( kd_inventaris='$txtKodeInventaris' OR RIGHT(kd_inventaris,6) ='$txtKodeInventaris' ) AND status_aktif='Yes'";
		$bacaQry 	= mysql_query($bacaSql, $koneksidb) or die ("Gagal Query baca : ".mysql_error());
		if(mysql_num_rows($bacaQry) >= 1) {
			$bacaData	= mysql_fetch_array($bacaQry);
			
			$nomorPenempatan	= $bacaData['no_penempatan'];
			$kodeInventaris		= $bacaData['kd_inventaris'];
			
			// Masukkan data ke Temporary
			$tmpSql 	= "INSERT INTO tmp_mutasi (no_penempatan, kd_inventaris, kd_petugas) VALUES ('$nomorPenempatan', '$kodeInventaris', '$userLogin')";
			mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
		}
	}

}
// ============================================================================

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca variabel from
	$txtTanggal 		= InggrisTgl($_POST['txtTanggal']);
	$cmbDepartemen		= $_POST['cmbDepartemen'];
	$cmbLokasi			= $_POST['cmbLokasi'];
	$txtKeterangan		= $_POST['txtKeterangan'];
	$txtKeterangan2		= $_POST['txtKeterangan2'];
	
	# Validasi form
	$pesanError = array();
	if(trim($txtTanggal)=="--") {
		$pesanError[] = "Data <b>Tgl. Transaksi</b> belum diisi, pilih pada combo !";		
	}
	if(trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan Mutasi</b> belum diisi, silahkan diisi !";		
	}
	if(trim($cmbDepartemen)=="Kosong") {
		$pesanError[] = "Data <b>Departemen Penempatan Baru</b> belum diisi, pilih pada combo !";		
	}
	if(trim($cmbLokasi)=="Kosong") {
		$pesanError[] = "Data <b>Lokasi Penempatan Baru</b> belum diisi, pilih pada combo !";		
	}
	if(trim($txtKeterangan2)=="") {
		$pesanError[] = "Data <b>Keterangan Penempatan</b> belum diisi, silahkan diisi !";		
	}
	
	# Periksa Data di dalam TMP Mutasi
	$tmpSql = "SELECT * FROM tmp_mutasi WHERE kd_petugas='$userLogin'";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpData = mysql_fetch_array($tmpQry);
	if(mysql_num_rows($tmpQry) < 1) {
		// Jika di dalam tabel TMP belum ada barang satupun (belum diinput)
		$pesanError[] = "<b>DATA BARANG BELUM DIINPUT</b>, minimal 1 barang yang akan (dimutasi) ditempatkan ke lokasi baru ";
	}

			
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if(count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE
		# Jika jumlah error pesanError tidak ada

		// Menyimpan data utama Mutasi 
		$kodeMutasi = buatKode("mutasi", "MB");
		$mySql	= "INSERT INTO mutasi (no_mutasi, tgl_mutasi, keterangan, kd_petugas) VALUES ('$kodeMutasi', '$txtTanggal', '$txtKeterangan', '$userLogin')";
		mysql_query($mySql, $koneksidb) or die ("Gagal query mutasi baru : ".mysql_error());
		
		
		// Penempatan Baru (Tempat Baru)
		$kodePenempatan = buatKode("penempatan", "PB");
		$my2Sql	= "INSERT INTO penempatan (no_penempatan, tgl_penempatan, kd_lokasi, keterangan, jenis, kd_petugas)
					VALUES ('$kodePenempatan', '$txtTanggal', '$cmbLokasi', '$txtKeterangan2', 'Mutasi', '$userLogin')";
		$my2Qry	= mysql_query($my2Sql, $koneksidb) or die ("Gagal query penempatan baru : ".mysql_error());		
		if($my2Qry){
			# …LANJUTAN, SIMPAN DATA
			
			// Menyimpan data Mutasi Tujuan, dari hasil mutasi tadi, barang ditempatkan pada Nomor Penempatan yang baru dicatat dalam tabel Mutasi_Tujuan
			// Informasi Nomor Penempatan pada Mutasi Tujuan adalah sama dengan Nomor Penempatan baru
			$my3Sql	= "INSERT INTO mutasi_tujuan (no_mutasi, no_penempatan, keterangan) VALUES ('$kodeMutasi', '$kodePenempatan', '$txtKeterangan2')";
			mysql_query($my3Sql, $koneksidb) or die ("Gagal query 3 : ".mysql_error());
			
			# Ambil semua data barang yang dipilih, berdasarkan Petugas yg login
			$tmpSql ="SELECT * FROM tmp_mutasi WHERE kd_petugas='$userLogin'";
			$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
			while ($tmpData = mysql_fetch_array($tmpQry)) {
				$nomorPenempatan 	= $tmpData['no_penempatan']; // Nomor penempatan lama
				$kodeInventaris 	= $tmpData['kd_inventaris']; // Kode label barang yang dimutasi
				
				// MEMINDAH DATA, Masukkan semua dari TMP_Mutasi ke dalam tabel Penempatan_Item
				$pindahSql = "INSERT INTO penempatan_item (no_penempatan, kd_inventaris, status_aktif) VALUES ('$kodePenempatan', '$kodeInventaris', 'Yes')";
				mysql_query($pindahSql, $koneksidb) or die ("Gagal Query penempatan_item : ".mysql_error());
				
				// MEMINDAH DATA 2, Masukkan semua dari TMP_Mutasi ke dalam tabel Mutasi_Asal
				$pindah2Sql = "INSERT INTO mutasi_asal (no_mutasi, no_penempatan, kd_inventaris) 
								VALUES ('$kodeMutasi', '$nomorPenempatan', '$kodeInventaris')";
				mysql_query($pindah2Sql, $koneksidb) or die ("Gagal Query penempatan_item : ".mysql_error());
				
				// Skrip Update status barang dari Penempatan Lama, Status menjadi NO (Tidak aktif)
				$mySql = "UPDATE penempatan_item SET status_aktif='No' WHERE kd_inventaris='$kodeInventaris' AND no_penempatan ='$nomorPenempatan'";
				mysql_query($mySql, $koneksidb) or die ("Gagal Query Edit Status".mysql_error());
			}
			
			# Kosongkan Tmp jika datanya sudah dipindah
			$hapusSql = "DELETE FROM tmp_mutasi WHERE kd_petugas='$userLogin'";
			mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
			
			// Refresh form
			echo "<script>";
			echo "window.open('../cetak/mutasi_cetak.php?noMutasi=$noMutasi', width=330,height=330,left=100, top=25)";
			echo "</script>";
		}
	}	
}
	
# TAMPILKAN DATA KE FORM
$dataKode 			= buatKode("mutasi", "MB");
$dataTglMutasi 		= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataDepartemen		= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : '';
$dataLokasi			= isset($_POST['cmbLokasi']) ? $_POST['cmbLokasi'] : '';
$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataKeterangan2	= isset($_POST['txtKeterangan2']) ? $_POST['txtKeterangan2'] : '';
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="form1">
<table width="900" cellpadding="3" cellspacing="1" class="table-list">
	<tr>
	  <td colspan="3"><h1>MUTASI ( PEMINDAHAN ) BARANG </h1> </td>
	</tr>
	<tr>
	  <td bgcolor="#F5F5F5"><strong>MUTASI</strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td width="21%"><strong>No. Mutasi </strong></td>
	  <td width="1%"><strong>:</strong></td>
	  <td width="78%"><input name="txtNomor" value="<?php echo $dataKode; ?>" size="23" maxlength="20" readonly="readonly"/></td>
	</tr>
	<tr>
      <td><strong>Tgl. Mutasi </strong></td>
	  <td><strong>:</strong></td>
	  <td><input type="text" name="txtTanggal" class="tcal" value="<?php echo $dataTglMutasi; ?>" /></td>
    </tr>
	<tr>
      <td><strong>Keterangan</strong></td>
	  <td><strong>:</strong></td>
	  <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="100"/></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td bgcolor="#F5F5F5"><strong>PENEMPATAN BARU </strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr class="table-list">
      <td><strong>Departemen </strong></td>
	  <td><strong>:</strong></td>
	  <td><select name="cmbDepartemen" onchange="javascript:submitform();" >
          <option value="Semua">....</option>
          <?php
		  // Skrip menampilkan data Departemen dalam ComboBox
	  $comboSql = "SELECT * FROM departemen ORDER BY kd_departemen";
	  $comboQry = mysql_query($comboSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($comboData = mysql_fetch_array($comboQry)) {
		if ($comboData['kd_departemen'] == $dataDepartemen) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$comboData[kd_departemen]' $cek>$comboData[nm_departemen]</option>";
	  }
	  ?>
      </select></td>
    </tr>
	<tr>
      <td><strong>Lokasi </strong></td>
	  <td><strong>:</strong></td>
	  <td><b>
	    <select name="cmbLokasi">
          <option value="Kosong">....</option>
          <?php
		  // Menampilkan data Lokasi dengan filter Nama Departemen yang dipilih
	  $comboSql = "SELECT * FROM lokasi WHERE kd_departemen='$dataDepartemen' ORDER BY kd_lokasi";
	  $comboQry = mysql_query($comboSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($comboData = mysql_fetch_array($comboQry)) {
	  	if ($dataLokasi == $comboData['kd_lokasi']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$comboData[kd_lokasi]' $cek> $comboData[nm_lokasi]</option>";
	  }
	  ?>
        </select>
	  </b></td>
    </tr>
	<tr class="table-list">
      <td><strong>Keterangan</strong></td>
	  <td><strong>:</strong></td>
	  <td><input name="txtKeterangan2" value="<?php echo $dataKeterangan2; ?>" size="80" maxlength="100" /></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td bgcolor="#F5F5F5"><strong>INPUT BARANG </strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td><strong>Kode/ Label Barang </strong></td>
	  <td><strong>:</strong></td>
	  <td><b>
	    <input name="txtKodeInventaris" id="txtKodeInventaris" size="40" maxlength="40" onchange="javascript:submitform();" />
	    <input name="btnTambah" type="submit" style="cursor:pointer;" value=" Tambah " />
      </b></td>
    </tr>
	<tr>
      <td>&nbsp;</td>
	  <td><strong>:</strong></td>
	  <td><input name="txtNamaBrg"  id="txtNamaBrg" size="80" maxlength="100" disabled="disabled" /></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><a href="javaScript: void(0)" target="_self" onclick="popup('pencarian_barang_terpakai.php')"><strong>Pencarian Barang</strong></a>, bisa pakai <strong>Barcode Reader</strong> untuk membaca label barang </td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input name="btnSimpan" type="submit" style="cursor:pointer;" value=" SIMPAN DATA " /></td>
    </tr>
</table>

<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th colspan="5">DAFTAR BARANG  </th>
    </tr>
  <tr>
    <td width="26" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="95" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="524" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
    <td width="180" bgcolor="#CCCCCC"><strong>Lokasi Sekarang </strong></td>
    <td width="49" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
<?php
// Skrip menampilkan data Barang dari tabel TMP_Mutasi, dilengkapi informasi Lokasi dari relasi tabel Penempatan 
$tmpSql ="SELECT lokasi.nm_lokasi, barang.*, tmp.* FROM tmp_mutasi As tmp
			LEFT JOIN barang_inventaris ON tmp.kd_inventaris = barang_inventaris.kd_inventaris
			LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
			LEFT JOIN penempatan ON tmp.no_penempatan = penempatan.no_penempatan
			LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
			WHERE tmp.kd_petugas='$userLogin' ORDER BY barang.kd_barang ";
$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0;  
while($tmpData = mysql_fetch_array($tmpQry)) {
	$nomor++;
	$ID			= $tmpData['id'];
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><b><?php echo $tmpData['kd_inventaris']; ?></b></td>
    <td><?php echo $tmpData['nm_barang']; ?></td>
    <td><?php echo $tmpData['nm_lokasi']; ?></td>
    <td align="center" bgcolor="#FFFFCC"><a href="?Act=Delete&ID=<?php echo $ID; ?>" target="_self">Delete</a></td>
  </tr>
<?php } ?>
</table>
</form>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
