<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_inventaris'] == "Yes") {

# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtTahunDatang			= $_POST['txtTahunDatang'];
	$txtTahunDigunakan		= $_POST['txtTahunDigunakan'];
	$txtNomorSeri			= $_POST['txtNomorSeri'];
	$txtMasaKalibrasi		= $_POST['txtMasaKalibrasi'];
	$txtNoSertifikat		= $_POST['txtNoSertifikat'];
	$txtPembuatSertifikat	= $_POST['txtPembuatSertifikat'];
	$txtAsal				= $_POST['txtAsal'];
	$txtHarga				= $_POST['txtHarga'];
	$txtKeterangan			= $_POST['txtKeterangan'];
	$txtKeterangan			= str_replace("'","&acute;",$txtKeterangan); // menghalangi penulisan tanda petik satu (')

	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtTahunDatang)=="") {
		$pesanError[] = "Data <b>Tahun Datang</b> tidak boleh kosong !";		
	}
	if (trim($txtTahunDigunakan)=="") {
		$pesanError[] = "Data <b>Tahun Digunakan</b> tidak boleh kosong !";		
	}
	if (trim($txtNomorSeri)=="") {
		$pesanError[] = "Data <b>Nomor Seri</b> tidak boleh kosong !";		
	}
	if (trim($txtMasaKalibrasi)=="") {
		$pesanError[] = "Data <b>Masa Kalibrasi</b> tidak boleh kosong !";		
	}
	if (trim($txtNoSertifikat)=="") {
		$pesanError[] = "Data <b>No. Sertifikat</b> tidak boleh kosong !";		
	}
	if (trim($txtPembuatSertifikat)=="") {
		$pesanError[] = "Data <b>Pembuat Sertifikat</b> tidak boleh kosong !";		
	}
	if (trim($txtAsal)=="") {
		$pesanError[] = "Data <b>Asal Barang</b> tidak boleh kosong !";		
	}
	if (trim($txtHarga)=="" or ! is_numeric(trim($txtHarga))) {
		$pesanError[] = "Data <b>Harga Barang </b> belum diisi, silahkan <b>isi dengan angka </b> !";		
	}
	if (trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";		
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
		# TIDAK ADA ERROR, Jika jumlah error message tidak ada, simpan datanya
		$Kode	= $_POST['txtKode'];
		$mySql	= "UPDATE barang_inventaris SET  tahun_datang='$txtTahunDatang',
									tahun_digunakan='$txtTahunDigunakan',
									nomor_seri='$txtNomorSeri',
									masa_habis_kalibrasi='$txtMasaKalibrasi',
									no_sertifikat_kalibrasi='$txtNoSertifikat',
									pembuat_sertifikat='$txtPembuatSertifikat',
									asal_barang='$txtAsal',
									harga_barang='$txtHarga',
									keterangan='$txtKeterangan'
						WHERE kd_inventaris ='$Kode'";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Inventaris-View&Kode=$Kode'>";
		}
		exit;
	}	
} // Penutup POST

# ==============================================================
# TAMPILKAN DATA UNTUK DIEDIT
// Skrip menampilkan daftar Inventaris Aset Barang per Barang
$Kode	 = $_GET['Kode']; 
$mySql = "SELECT IB.*, barang.nm_barang FROM barang_inventaris As IB 
			LEFT JOIN barang ON IB.kd_barang = barang.kd_barang
			WHERE IB.kd_inventaris='$Kode'";  
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData= mysql_fetch_array($myQry);

	# MASUKKAN DATA KE VARIABEL
	$dataKode				= $myData['kd_inventaris'];
	$dataTahunDatang		= isset($_POST['txtTahunDatang']) ? $_POST['txtTahunDatang'] : $myData['tahun_datang'];
	$dataTahunDigunakan		= isset($_POST['txtTahunDigunakan']) ? $_POST['txtTahunDigunakan'] : $myData['tahun_digunakan'];
	$dataNomorSeri			= isset($_POST['txtNomorSeri']) ? $_POST['txtNomorSeri'] : $myData['nomor_seri'];
	$dataMasaKalibrasi		= isset($_POST['txtMasaKalibrasi']) ? $_POST['txtMasaKalibrasi'] : $myData['masa_habis_kalibrasi'];
	$dataNoSertifikat		= isset($_POST['txtNoSertifikat']) ? $_POST['txtNoSertifikat'] : $myData['no_sertifikat_kalibrasi'];
	$dataPembuatSertifikat	= isset($_POST['txtPembuatSertifikat']) ? $_POST['txtPembuatSertifikat'] : $myData['pembuat_sertifikat'];
	$dataAsal				= isset($_POST['txtAsal']) ? $_POST['txtAsal'] : $myData['asal_barang'];
	$dataHarga				= isset($_POST['txtHarga']) ? $_POST['txtHarga'] : $myData['harga_barang'];
	$dataKeterangan			= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $myData['keterangan'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmedit">
<table class="table-list" width="100%" style="margin-top:0px;">
	<tr>
	  <th colspan="3"> DATA ASET (INVENTARIS) BARANG </th>
	</tr>
	<tr>
	  <td bgcolor="#CCCCCC"><strong>DATA BARANG </strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td><strong>Kode</strong></td>
	  <td><strong>:</strong></td>
	  <td> <?php echo $myData['kd_barang']; ?> </td>
    </tr>
	<tr>
	  <td><strong>Nama Barang/ Alat </strong></td>
	  <td><strong>:</strong></td>
	  <td> <?php echo $myData['nm_barang']; ?> </td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td bgcolor="#CCCCCC"><strong>DATA INVENTARIS </strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td width="17%"><strong>Kode Aset </strong></td>
	  <td width="1%"><strong>:</strong></td>
	  <td width="82%"><input name="textfield" value="<?php echo $dataKode; ?>" size="14" maxlength="10"  readonly="readonly"/>
    <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td></tr>
	<tr>
      <td><b>Tahun Datang </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtTahunDatang" id="txtTahunDatang" value="<?php echo $dataTahunDatang; ?>" size="6" maxlength="4" /></td>
    </tr>
	<tr>
      <td><b>Tahun Digunakan</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtTahunDigunakan" value="<?php echo $dataTahunDigunakan; ?>" size="6" maxlength="4" /></td>
    </tr>
	<tr>
      <td><b>Nomor Seri</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtNomorSeri"  value="<?php echo $dataNomorSeri; ?>" size="30" maxlength="30" /></td>
    </tr>
	<tr>
      <td><b>Masa Habis Kalibrasi </b></td>
	  <td><strong>:</strong></td>
	  <td><input name="txtMasaKalibrasi"  id="txtMasaKalibrasi" value="<?php echo $dataMasaKalibrasi; ?>" size="15" maxlength="10" />      </td>
    </tr>
	<tr>
      <td><b>No. Sertifikat  Kalibrasi </b></td>
	  <td><strong>:</strong></td>
	  <td><input name="txtNoSertifikat"  value="<?php echo $dataNoSertifikat; ?>" size="30" maxlength="40" />      </td>
    </tr>
	<tr>
      <td><b>Pembuat Sertifikat </b></td>
	  <td><strong>:</strong></td>
	  <td><input name="txtPembuatSertifikat" value="<?php echo $dataPembuatSertifikat; ?>" size="60" maxlength="100" />      </td>
    </tr>
	<tr>
      <td><b>Asal Barang </b></td>
	  <td><strong>:</strong></td>
	  <td><input name="txtAsal" value="<?php echo $dataAsal; ?>" size="60" maxlength="100" />
      </td>
    </tr>
	<tr>
      <td><b>Harga Barang (Rp.) </b></td>
	  <td><strong>:</strong></td>
	  <td><input name="txtHarga"  value="<?php echo $dataHarga; ?>" size="20" maxlength="12" />      </td>
    </tr>
	<tr>
      <td><b>Keterangan</b></td>
	  <td><strong>:</strong></td>
	  <td><textarea name="txtKeterangan" cols="60" rows="3"><?php echo $dataKeterangan; ?></textarea></td>
    </tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;"></td>
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
