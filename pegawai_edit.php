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
		# SIMPAN PERUBAHAN DATA, Jika jumlah error pesanError tidak ada, simpan datanya
		$Kode	= $_POST['txtKode'];

		// Membaca Kode Buku dari form
		$Kode	= $_POST['txtKode'];

		# Baca keberadaan file gambar baru pada form
		if (empty($_FILES['txtNamaFile']['tmp_name'])) {
			$nama_file = $_POST['txtFileSembunyi'];
		}
		else  {
			// Jika file gambar lama ada, akan dihapus
			$txtFileSembunyi = $_POST['txtFileSembunyi'];
			if(file_exists("foto/pegawai/".$txtFileSembunyi)) {
				unlink("foto/pegawai/".$txtFileSembunyi);	
			}

			# Jika gambar lama kosong, atau ada gambar baru, maka Mengkopi file gambar
			$nama_file = $_FILES['txtNamaFile']['name'];
			$nama_file = stripslashes($nama_file);
			$nama_file = str_replace("'","",$nama_file);
			
			// Perintah mengkopi file ke folder foto/buku
			$nama_file = $Kode.".".$nama_file;
			copy($_FILES['txtNamaFile']['tmp_name'],"foto/pegawai/".$nama_file);					
		}
		
		// Skrip penyimpanan data terbaru
		$mySql	= "UPDATE pegawai SET nm_pegawai='$txtNama', kelamin='$cmbKelamin', alamat='$txtAlamat',
					no_telepon='$txtTelepon', foto='$nama_file' WHERE kd_pegawai ='$Kode'";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Pegawai-Data'>";
		}
		exit;
	}	
} // Penutup Tombol Simpan

# MENGAMBIL DATA YANG DIEDIT, SESUAI KODE YANG DIDAPAT DARI URL
$Kode	= $_GET['Kode']; 
$mySql	= "SELECT * FROM pegawai WHERE kd_pegawai='$Kode'";
$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);

	# MASUKKAN DATA DARI FORM KE VARIABEL TEMPORARY (SEMENTARA)
	$dataKode	= $myData['kd_pegawai'];
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_pegawai'];
	$dataKelamin= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : $myData['kelamin'];
	$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : $myData['alamat'];
	$dataTelepon= isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1"  enctype="multipart/form-data">
<table class="table-list" width="100%">
	<tr>
	  <th colspan="3">UBAH DATA PEGAWAI </th>
	</tr>
	<tr>
	  <td width="15%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="84%"><input name="textfield" value="<?php echo $dataKode; ?>" size="8" maxlength="4"  readonly="readonly"/>
    <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td></tr>
	<tr>
	  <td><b>Nama Pegawai </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></td></tr>
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
            echo "<option value='$indeks' $cek> $nilai</option>";
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
	  <td><input name="txtNamaFile" type="file" id="txtNamaFile" size="40" />
          <input name="txtFileSembunyi" type="hidden" value="<?php echo $myData['foto']; ?>" /></td>
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

