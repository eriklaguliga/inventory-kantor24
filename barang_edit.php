<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_barang'] == "Yes") {

# Tombol Simpan diklik
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
	$Kode	= $_POST['txtKode'];
	$sqlCek	= "SELECT * FROM barang WHERE nm_barang='$txtNama' AND NOT(kd_barang='$Kode')";
	$qryCek	= mysql_query($sqlCek, $koneksidb) or die ("Eror Query".mysql_error()); 
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
		# TIDAK ADA ERROR, Jika jumlah error message tidak ada, simpan datanya
		$Kode	= $_POST['txtKode'];
		$mySql	= "UPDATE barang SET  nm_barang='$txtNama',
									keterangan='$txtKeterangan',
									merek='$txtMerek',
									tipe='$txtTipe',
									satuan='$cmbSatuan',
									kd_kategori='$cmbKategori'
						WHERE kd_barang ='$Kode'";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
		}
		exit;
	}	
} // Penutup POST

# TAMPILKAN DATA UNTUK DIEDIT
$Kode	 = $_GET['Kode']; 
$mySql = "SELECT * FROM barang WHERE kd_barang='$Kode'";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData= mysql_fetch_array($myQry);

	# MASUKKAN DATA KE VARIABEL
	$dataKode	= $myData['kd_barang'];
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_barang'];
	$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $myData['keterangan'];
	$dataMerek		= isset($_POST['txtMerek']) ? $_POST['txtMerek'] : $myData['merek'];
	$dataTipe		= isset($_POST['txtTipe']) ? $_POST['txtTipe'] : $myData['tipe'];
	$dataSatuan		= isset($_POST['cmbSatuan']) ? $_POST['cmbSatuan'] : $myData['satuan'];
	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $myData['kd_kategori'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmedit">
<table class="table-list" width="100%" style="margin-top:0px;">
	<tr>
	  <th colspan="3">LENGKAPI DATA ASET BARANG </th>
	</tr>
	<tr>
	  <td width="17%"><strong>Kode </strong></td>
	  <td width="1%"><strong>:</strong></td>
	  <td width="82%"><input name="textfield" value="<?php echo $dataKode; ?>" size="14" maxlength="10"  readonly="readonly"/>
    <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td></tr>
	<tr>
	  <td><b>Nama Barang</b></td>
      <td><strong>:</strong></td>
	  <td><input name="txtNama" value="<?php echo $dataNama; ?>" size="80" maxlength="100" />
	    <input name="txtLama" type="hidden" value="<?php echo $myData['nm_barang']; ?>" /></td>
    </tr>
	<tr>
	  <td><b>Keterangan</b></td>
	  <td><strong>:</strong></td>
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
	  <td><input name="txtTipe" id="txtTipe" value="<?php echo $dataTipe; ?>" size="60" maxlength="100" /></td>
    </tr>
	<tr>
      <td><strong>Satuan</strong></td>
	  <td><strong>:</strong></td>
	  <td><b>
        <select name="cmbSatuan">
          <option value="Kosong">....</option>
          <?php
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
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="9"><strong>DAFTAR INVENTARIS</strong> </td>
  </tr>
  <tr>
    <td width="21" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="123" bgcolor="#F5F5F5"><strong>Kode Inventaris</strong></td>
    <td width="150" bgcolor="#F5F5F5"><strong>Nomor Seri </strong></td>
    <td width="50" bgcolor="#F5F5F5"><strong>Th. Dtg</strong> </td>
    <td width="50" bgcolor="#F5F5F5"><strong>Th. Dgn </strong></td>
    <td width="90" bgcolor="#F5F5F5"><strong>Status</strong></td>
    <td width="180" bgcolor="#F5F5F5"><strong>Lokasi</strong></td>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
    </tr>
  <?php
	// Skrip menampilkan daftar Inventaris Aset Barang per Barang
	$mySql = "SELECT * FROM barang_inventaris WHERE kd_barang='$Kode'";  
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$KodeInventaris = $myData['kd_inventaris'];
		
		$infoLokasi	= "";
		
		// Mencari lokasi Penempatan Barang
		if($myData['status_barang']=="Ditempatkan") {
			$my2Sql = "SELECT lokasi.nm_lokasi FROM penempatan_item as PI
						LEFT JOIN penempatan ON PI.no_penempatan=penempatan.no_penempatan
						LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
						WHERE PI.status_aktif='Yes' AND PI.kd_inventaris='$KodeInventaris'";  
			$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
			$my2Data = mysql_fetch_array($my2Qry);
			$infoLokasi	= $my2Data['nm_lokasi'];
		}
		
		// Mencari Siapa Penempatan Barang
		if($myData['status_barang']=="Dipinjam") {
			$my3Sql = "SELECT pegawai.nm_pegawai FROM peminjaman_item as PI
						LEFT JOIN peminjaman ON PI.no_peminjaman=peminjaman.no_peminjaman
						LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
						WHERE peminjaman.status_kembali='Pinjam' AND PI.kd_inventaris='$KodeInventaris'";  
			$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
			$my3Data = mysql_fetch_array($my3Qry);
			$infoLokasi	= $my3Data['nm_pegawai'];
		}
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_inventaris']; ?></td>
    <td><?php echo $myData['nomor_seri']; ?></td>
    <td><?php echo $myData['tahun_datang']; ?></td>
    <td><?php echo $myData['tahun_digunakan']; ?></td>
    <td><?php echo $myData['status_barang']; ?></td>
    <td><?php echo $infoLokasi; ?></td>
    <td width="45" align="center"><a href="?open=Inventaris-Edit&Kode=<?php echo $KodeInventaris; ?>" target="_blank" alt="Edit Data">Edit</a></td>
    <td width="45" align="center"><a href="?open=Inventaris-View&Kode=<?php echo $KodeInventaris; ?>" target="_blank" alt="View Data">View</a></td>
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
