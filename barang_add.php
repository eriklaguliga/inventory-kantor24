<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_barang'] == "Yes") {

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtNama		= $_POST['txtNama'];
	$txtNama		= str_replace("'","&acute;",$txtNama); // menghalangi penulisan tanda petik satu (')
	
	$txtKeterangan	= $_POST['txtKeterangan'];
	$txtKeterangan	= str_replace("'","&acute;",$txtKeterangan); // menghalangi penulisan tanda petik satu (')
	
	$txtMerek		= $_POST['txtMerek'];
	$txtMerek		= str_replace("'","&acute;",$txtMerek); // menghalangi penulisan tanda petik satu (')
	
	$txtTipe		= $_POST['txtTipe'];
	$txtTipe		= str_replace("'","&acute;",$txtTipe); // menghalangi penulisan tanda petik satu (')
	
	$cmbSatuan		= $_POST['cmbSatuan'];
	$cmbKategori	= $_POST['cmbKategori'];

	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Barang</b> tidak boleh kosong !";		
	}
	if (trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";		
	}
	if (trim($txtMerek)=="") {
		$pesanError[] = "Data <b>Merek</b> tidak boleh kosong !";		
	}
	if (trim($txtTipe)=="") {
		$pesanError[] = "Data <b>Tipe</b> tidak boleh kosong !";		
	}
	if (trim($cmbSatuan)=="Kosong") {
		$pesanError[] = "Data <b>Satuan Barang</b> belum dipilih !";		
	}
	if (trim($cmbKategori)=="Kosong") {
		$pesanError[] = "Data <b>Kategori Barang</b> belum dipilih !";		
	}
		
	# Validasi Nama barang, jika sudah ada akan ditolak
	$sqlCek="SELECT * FROM barang WHERE nm_barang='$txtNama'";
	$qryCek=mysql_query($sqlCek, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($qryCek)>=1){
		$pesanError[] = "Maaf, Nama Barang <b> $txtNama </b> sudah dipakai, ganti dengan yang lain";
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
		# SIMPAN DATA KE DATABASE. // Jika tidak menemukan error, simpan data ke database
		$kodeBarang	= buatKode("barang", "B");
		$mySql	= "INSERT INTO barang (kd_barang, nm_barang, keterangan, merek, tipe, satuan, jumlah, kd_kategori) 
							VALUES ('$kodeBarang',
									'$txtNama',
									'$txtKeterangan',
									'$txtMerek',
									'$txtTipe',
									'$cmbSatuan',
									'0',
									'$cmbKategori')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){		
			echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Add'>";
		}
		exit;
	}

} // Penutup POST
	
# MASUKKAN DATA KE VARIABEL
$dataKode		= buatKode("barang", "B");
$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataMerek		= isset($_POST['txtMerek']) ? $_POST['txtMerek'] : '';
$dataTipe		= isset($_POST['txtTipe']) ? $_POST['txtTipe'] : '';
$dataSatuan		= isset($_POST['cmbSatuan']) ? $_POST['cmbSatuan'] : '';
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd" target="_self">
<table width="100%" cellpadding="2" cellspacing="1" class="table-list" style="margin-top:0px;">
	<tr>
	  <th colspan="3">TAMBAH DATA ASET BARANG </th>
	</tr>
	<tr>
	  <td width="17%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="82%"><input name="textfield" value="<?php echo $dataKode; ?>" size="14" maxlength="10" readonly="readonly"/></td></tr>
	<tr>
	  <td><b>Nama Barang</b></td>
      <td><b>:</b></td>
	  <td><input name="txtNama" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></td>
    </tr>
	<tr>
	  <td><b>Keterangan</b></td>
	  <td><b>:</b></td>
	  <td><textarea name="txtKeterangan" cols="60" rows="3"><?php echo $dataKeterangan; ?></textarea></td>
	</tr>
	<tr>
      <td><b>Merek</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtMerek" value="<?php echo $dataMerek; ?>" size="60" maxlength="100" /></td>
    </tr>
	<tr>
      <td><b>Tipe</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtTipe" value="<?php echo $dataTipe; ?>" size="60" maxlength="100" /></td>
    </tr>
	<tr>
	  <td><strong>Satuan</strong></td>
	  <td><b>:</b></td>
	  <td><b>
	    <select name="cmbSatuan">
          <option value="Kosong">....</option>
          <?php
		  // Menampilkan data Satuan  ke comboBox, satuan ada pada file library/inc.pilihan.php
		  include_once "library/inc.pilihan.php";
          foreach ($satuan as $nilai) {
            if ($dataSatuan == $nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
	  </b></td>
    </tr>
	<tr>
      <td><strong>Kategori </strong></td>
	  <td><strong>:</strong></td>
	  <td><select name="cmbKategori">
          <option value="Kosong">....</option>
          <?php
		  // Menampilkan data kategori ke comboBox
		$mySql = "SELECT * FROM kategori ORDER BY nm_kategori";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
		while ($myData = mysql_fetch_array($myQry)) {
		if ($myData['kd_kategori']== $dataKategori) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$myData[kd_kategori]' $cek>$myData[nm_kategori] </option>";
		}
		?>
      </select></td>
    </tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;"></td>
    </tr>
</table>
<strong># Note:</strong> Jumlah barang akan bertambah dari  <a href="pengadaan/" target="_blank">Transaksi Pembelian / Pengadaan Barang</a>
</form>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
