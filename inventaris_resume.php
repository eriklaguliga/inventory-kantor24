<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_inventaris'] == "Yes") {

// Membaca User yang Login
$userLogin	= $_SESSION['SES_LOGIN'];

# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtKode				= $_POST['txtKode'];
	$txtKondisiBarang		= $_POST['txtKondisiBarang'];
	$txtHasilResume			= $_POST['txtHasilResume'];
	
	$txtKondisiBarang		= str_replace("'","&acute;",$txtKondisiBarang); // menghalangi penulisan tanda petik satu (')
	$txtHasilResume			= str_replace("'","&acute;",$txtHasilResume); // menghalangi penulisan tanda petik satu (')

	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtKondisiBarang)=="") {
		$pesanError[] = "Data <b>Kondisi Barang</b> tidak boleh kosong !";		
	}
	if (trim($txtHasilResume)=="") {
		$pesanError[] = "Data <b>Hasil Resume</b> tidak boleh kosong !";		
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
		$mySql	= "INSERT INTO resume_inventaris (kd_inventaris, hasil_resume, kondisi_barang, kd_petugas) 
					VALUES ('$txtKode', '$txtHasilResume', '$txtKondisiBarang', '$userLogin')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Inventaris-Data'>";
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
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query ambil data 1 salah : ".mysql_error());
$myData= mysql_fetch_array($myQry);

// Membaca Hasil Resume sebelumnya
$my2Sql = "SELECT RI.*, petugas.nm_petugas FROM resume_inventaris AS RI 
			LEFT JOIN petugas ON RI.kd_petugas = petugas.kd_petugas WHERE RI.kd_inventaris='$Kode' ORDER BY RI.id DESC LIMIT 1";  
$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query ambil data 2 salah : ".mysql_error());
$my2Data= mysql_fetch_array($my2Qry);


# MASUKKAN DATA KE VARIABEL
$dataKondisiBarang	= isset($_POST['txtKondisiBarang']) ? $_POST['txtKondisiBarang'] : '';
$dataHasilResume	= isset($_POST['txtHasilResume']) ? $_POST['txtHasilResume'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmedit">
<table class="table-list" width="100%" style="margin-top:0px;">
	<tr>
	  <td colspan="3"> <strong><h2> RESUME BARANG </h2></strong></td>
	</tr>
	<tr>
	  <td width="17%" bgcolor="#CCCCCC"><strong>DATA ASET </strong></td>
	  <td width="1%">&nbsp;</td>
	  <td width="82%">&nbsp;</td>
    </tr>
	<tr>
	  <td><strong>Kode</strong></td>
	  <td><strong>:</strong></td>
	  <td> <?php echo $myData['kd_barang']; ?> <input name="txtKode" type="hidden" value="<?php echo $myData['kd_inventaris']; ?>" /></td>
    </tr>
	<tr>
	  <td><strong>Nama Barang </strong></td>
	  <td><strong>:</strong></td>
	  <td> <?php echo $myData['nm_barang']; ?> </td>
    </tr>
	<tr>
	  <td><strong>Kode ID </strong></td>
	  <td><strong>:</strong></td>
	  <td><?php echo $myData['kd_inventaris']; ?></td>
    </tr>
	<tr>
	  <td><strong>Nomor Seri </strong></td>
	  <td><strong>:</strong></td>
	  <td><?php echo $myData['nomor_seri']; ?></td>
    </tr>
	<tr>
	  <td><strong>Tahun Datang </strong></td>
	  <td><strong>:</strong></td>
	  <td><?php echo $myData['tahun_datang']; ?></td>
    </tr>
	<tr>
	  <td><strong>Tahun Digunakan </strong></td>
	  <td><strong>:</strong></td>
	  <td><?php echo $myData['tahun_digunakan']; ?></td>
    </tr>
	<tr>
	  <td bgcolor="#CCCCCC"><strong>RESUME SEBELUMNYA </strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td><b>Kondisi Barang </b></td>
	  <td><strong>:</strong></td>
	  <td><?php echo $my2Data['kondisi_barang']; ?></td>
    </tr>
	<tr>
	  <td><b>Hasil Resume </b></td>
	  <td><strong>:</strong></td>
	  <td><?php echo $my2Data['hasil_resume']; ?></td>
    </tr>
	<tr>
      <td><b>Petugas</b></td>
	  <td><strong>:</strong></td>
	  <td><?php echo $my2Data['nm_petugas']; ?></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td bgcolor="#CCCCCC"><strong>RESUME BARU </strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
      <td><b>Kondisi Barang  </b></td>
	  <td><strong>:</strong></td>
	  <td><input name="txtKondisiBarang" value="<?php echo $dataKondisiBarang; ?>" size="60" maxlength="100" />      </td>
    </tr>
	<tr>
      <td><b>Hasil Resume </b></td>
	  <td><strong>:</strong></td>
	  <td><textarea name="txtHasilResume" cols="60" rows="3"><?php echo $dataHasilResume; ?></textarea></td>
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
