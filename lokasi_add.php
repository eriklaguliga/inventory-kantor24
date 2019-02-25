<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_lokasi'] == "Yes") {

# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtNama		= $_POST['txtNama'];
	$txtNama		= str_replace("'","&acute;",$txtNama); // menghalangi penulisan tanda petik satu (')
	$cmbDepartemen	= $_POST['cmbDepartemen'];
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Lokasi</b> tidak boleh kosong !";		
	}
	if (trim($cmbDepartemen)=="Kosong") {
		$pesanError[] = "Data <b>Departemen</b> belum dipilih, silahkan pilih pada Combo !";		
	}
	
	# Validasi Nama lokasi, jika sudah ada akan ditolak
	$cekSql="SELECT * FROM lokasi WHERE kd_departemen='$cmbDepartemen' AND nm_lokasi='$txtNama'";
	$cekQry=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "Maaf, Nama Lokasi : <b> $txtNama </b> sudah ada, ganti dengan yang lain";
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
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
		$kodeBaru	= buatKode("lokasi", "L");
		$mySql	= "INSERT INTO lokasi (kd_lokasi, nm_lokasi, kd_departemen) VALUES ('$kodeBaru', '$txtNama', '$cmbDepartemen')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Lokasi-Data'>";
		}
		exit;
	}	
} // Penutup Tombol Simpan

# MASUKKAN DATA KE VARIABEL
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKode	= buatKode("lokasi", "L");
$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
<table class="table-list" width="100%">
	<tr>
	  <th colspan="3">TAMBAH DATA LOKASI </th>
	</tr>
	<tr>
	  <td width="15%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="84%"><input name="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="4" readonly="readonly"/></td></tr>
	<tr>
	  <td><b>Nama Lokasi </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtNama" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></td>
	</tr>
	<tr>
      <td><strong>Departemen </strong></td>
	  <td><strong>:</strong></td>
	  <td><select name="cmbDepartemen">
          <option value="Kosong">....</option>
          <?php
		  // Menampilkan data Departemen
		$mySql = "SELECT * FROM departemen ORDER BY kd_departemen";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
		while ($myData = mysql_fetch_array($myQry)) {
		if ($myData['kd_departemen']== $dataDepartemen) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$myData[kd_departemen]' $cek>$myData[nm_departemen] </option>";
		}
		?>
      </select></td>
    </tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnSimpan" value=" SIMPAN "></td>
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
