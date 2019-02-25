<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_pegawai'] == "Yes") {

# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtNama		= $_POST['txtNama'];
	$cmbKelamin		= $_POST['cmbKelamin'];
	$txtAlamat		= $_POST['txtAlamat'];
	$txtTelepon		= $_POST['txtTelepon'];

	$txtNama		= str_replace("'","&acute;",$txtNama); // menghalangi penulisan tanda petik satu (')
	$txtAlamat		= str_replace("'","&acute;",$txtAlamat); // menghalangi penulisan tanda petik satu (')
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Pegawai</b> tidak boleh kosong, silahkan dilengkapi !";		
	}
	if (trim($cmbKelamin)=="Kosong") {
		$pesanError[] = "Data <b>Kelamin</b> belum dipilih, silahkan pilih pada Combo !";		
	}
	if (trim($txtAlamat)=="") {
		$pesanError[] = "Data <b>Alamat Pegawai</b> tidak boleh kosong, silahkan dilengkapi !";		
	}
	if (trim($txtTelepon)=="" or ! is_numeric(trim($txtTelepon))) {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong, harus ditulis angka !";		
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
		$kodeBaru	= buatKode("pegawai", "P");
		
		# Mengkopi file gambar
		if (! empty($_FILES['txtNamaFile']['tmp_name'])) {
			// Simpan gambar
			$nama_file = $_FILES['txtNamaFile']['name'];
			$nama_file = stripslashes($nama_file);
			$nama_file = str_replace("'","",$nama_file);
			
			$nama_file = $kodeBaru.".".$nama_file;
			copy($_FILES['txtNamaFile']['tmp_name'],"foto/pegawai/".$nama_file);
		}
		else {
			$nama_file = "";
		}
		
		// Skrip menyimpan data ke tabel buku
		$mySql	= "INSERT INTO pegawai (kd_pegawai, nm_pegawai, kelamin, alamat, no_telepon, foto) 
					VALUES ('$kodeBaru',
							'$txtNama',
							'$cmbKelamin',
							'$txtAlamat',
							'$txtTelepon',
							'$nama_file')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Pegawai-Data'>";
		}
		exit;
	}	
} // Penutup Tombol Simpan
	
# MASUKKAN DATA DARI FORM KE VARIABEL TEMPORARY (SEMENTARA)
$dataKode	= buatKode("pegawai", "P");
$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKelamin= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : '';
$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataTelepon= isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1"  enctype="multipart/form-data">
<table width="100%" cellpadding="2" cellspacing="1" class="table-list">
	<tr>
	  <th colspan="3">TAMBAH DATA PEGAWAI </th>
	</tr>
	<tr>
	  <td width="15%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="84%"><input name="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="4" readonly="readonly"/></td></tr>
	<tr>
	  <td><b>Nama Pegawai </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtNama" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></td>
	</tr>
	<tr>
      <td><b>Kelamin</b></td>
	  <td><b>:</b></td>
	  <td><b>
        <select name="cmbKelamin">
          <option value="Kosong">....</option>
          <?php
		  $pilihan	= array("L"=> "Laki-laki (L)", "P" => "Perempuan (P)");
          foreach ($pilihan as  $indeks => $nilai) {
            if ($dataKelamin==$indeks) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$indeks' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
	<tr>
      <td><b>Alamat Lengkap </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtAlamat" value="<?php echo $dataAlamat; ?>" size="80" maxlength="200" /></td>
    </tr>
	<tr>
      <td><b>No. Telepon </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtTelepon" value="<?php echo $dataTelepon; ?>" size="20" maxlength="20" /></td>
    </tr>
	<tr>
      <td><b>Foto</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtNamaFile" type="file" id="txtNamaFile" size="40" /></td>
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
