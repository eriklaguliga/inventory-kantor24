<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_pemeliharaan'] == "Yes") {

// Membaca User yang Login
$userLogin	= $_SESSION['SES_LOGIN'];

# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtKodeID			= $_POST['txtKodeID'];
	$txtTanggal 		= InggrisTgl($_POST['txtTanggal']);
	$txtBiaya			= $_POST['txtBiaya'];
	$txtKeterangan		= $_POST['txtKeterangan'];
	
	$txtBiaya			= str_replace("'","&acute;",$txtBiaya); // menghalangi penulisan tanda petik satu (')
	$txtKeterangan		= str_replace("'","&acute;",$txtKeterangan); // menghalangi penulisan tanda petik satu (')

	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtKodeID)=="") {
		$pesanError[] = "Data <b>Kode ID</b> tidak terbaca !";		
	}
	if (trim($txtTanggal)=="--") {
		$pesanError[] = "Data <b>Tgl. Pemeliharaan</b> belum diisi, pilih pada combo !";		
	}
	if (trim($txtBiaya)=="" or ! is_numeric(trim($txtBiaya))) {
		$pesanError[] = "Data <b>Biaya (Rp) Pemeliharaan </b> belum diisi, silahkan <b>isi dengan angka </b> !";		
	}
	if (trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";		
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
		# TIDAK ADA ERROR, Jika jumlah error message tidak ada, simpan datanya
		$noBaru = buatKode("pemeliharaan", "PB");
		$mySql	= "INSERT INTO pemeliharaan (no_pemeliharaan, tgl_pemeliharaan, kd_inventaris, biaya, keterangan, kd_petugas) 
					VALUES ('$noBaru', '$txtTanggal', '$txtKodeID', '$txtBiaya', '$txtKeterangan', '$userLogin')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			// Refresh
			echo "<meta http-equiv='refresh' content='0; url=?open=Pemeliharaan-Tampil'>";
		}
		exit;
	}	
} // Penutup POST

# ==============================================================
# MASUKKAN DATA KE VARIABEL
$noTransaksi 	= buatKode("pemeliharaan", "PB");
$tglTransaksi 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');

$dataBiaya		= isset($_POST['txtBiaya']) ? $_POST['txtBiaya'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmedit">
<table class="table-list" width="100%" style="margin-top:0px;">
	<tr>
	  <td colspan="3"> <strong>
	    <h2> PEMELIHARAAN BARANG </h2>
	  </strong></td>
	</tr>
	<tr>
	  <td width="17%" bgcolor="#CCCCCC"><strong>DATA ASET </strong></td>
	  <td width="1%">&nbsp;</td>
	  <td width="82%">&nbsp;</td>
    </tr>
	<tr>
      <td><strong>Kode ID ( Label ) </strong></td>
	  <td><strong>:</strong></td>
	  <td><b>
        <input name="txtKodeID" id="txtKodeID" size="40" maxlength="40" onchange="javascript:submitform();" />
	  </b></td>
    </tr>
	<tr>
      <td><strong>Nama Barang </strong></td>
	  <td><strong>:</strong></td>
	  <td><input name="txtNamaBrg"  id="txtNamaBrg" size="80" maxlength="100" disabled="disabled" /></td>
    </tr>
	<tr>
      <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><a href="javaScript: void(0)" onclick="popup('barang_cari.php')" target="_self"><strong>Pencarian Barang</strong></a>, bisa pakai <strong>Barcode Reader</strong> untuk membaca label barang </td>
    </tr>
	<tr>
	  <td><strong>Nomor Seri </strong></td>
	  <td><strong>:</strong></td>
	  <td><input name="txtNomorSeri"  id="txtNomorSeri" size="40" maxlength="40" disabled="disabled" /></td>
    </tr>
	<tr>
	  <td bgcolor="#CCCCCC"><strong>PEMELIHARAAN</strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td><strong>No. Pemeliharaan </strong></td>
      <td><strong>:</strong></td>
	  <td><input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="20" readonly="readonly"/></td>
    </tr>
	<tr>
	  <td><strong>Tgl. Pemeliharaan </strong></td>
      <td><strong>:</strong></td>
	  <td><input type="text" name="txtTanggal" class="tcal" value="<?php echo $tglTransaksi; ?>" /></td>
    </tr>
	<tr>
      <td><b>Biaya Pemeliharaan(Rp) </b></td>
	  <td><strong>:</strong></td>
	  <td><input name="txtBiaya" value="<?php echo $dataBiaya; ?>" size="20" maxlength="12" />      </td>
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
