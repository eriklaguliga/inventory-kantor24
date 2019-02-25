<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_pengadaan'] == "Yes") {

// Membaca User yang Login
$userLogin	= $_SESSION['SES_LOGIN'];

# HAPUS DAFTAR BARANG DI TMP
if(isset($_GET['Act'])){
	$Act	= $_GET['Act'];
	$ID		= $_GET['ID'];
	
	if(trim($Act)=="Delete"){
		# Hapus Tmp jika datanya sudah dipindah
		$mySql = "DELETE FROM tmp_pengadaan WHERE id='$ID' AND kd_petugas='$userLogin'";
		mysql_query($mySql, $koneksidb) or die ("Gagal menghapus tmp : ".mysql_error());
	}
	if(trim($Act)=="Sucsses"){
		echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
	}
}
// =========================================================================

$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
$dataBarang		= isset($_POST['cmbBarang']) ? $_POST['cmbBarang'] : '';
$dataDeskripsi	= isset($_POST['txtDeskripsi']) ? $_POST['txtDeskripsi'] : '';

# TOMBOL TAMBAH DIKLIK
if(isset($_POST['btnTambah'])){
	# Baca variabel Input Barang
	$cmbBarang		= $_POST['cmbBarang'];
	
	$txtDeskripsi	= $_POST['txtDeskripsi'];
	$txtDeskripsi	= str_replace("'","&acute;",$txtDeskripsi);
	
	$txtHargaBeli	= $_POST['txtHargaBeli'];
	$txtHargaBeli	= str_replace("'","&acute;", $txtHargaBeli);
	$txtHargaBeli	= str_replace(".","", $txtHargaBeli);
	
	$txtJumlah		= $_POST['txtJumlah'];

	// Validasi form
	$pesanError = array();
	if (trim($cmbBarang)=="Kosong") {
		$pesanError[] = "Data <b>Nama Barang belum dipilih</b>, harus Anda memilih dari combo, atau lihat di 
						 <a href='?page=Pencarian-Barang' target='_blank'> Pencarian </a>!";		
	}
	if (trim($txtDeskripsi)=="") {
		$pesanError[] = "Data <b>Deskripsi belum diisi</b>, silahkan perbaiki datanya !";		
	}
	if (trim($txtHargaBeli)=="" or ! is_numeric(trim($txtHargaBeli))) {
		$pesanError[] = "Data <b>Harga Barang/ Beli (Rp) belum diisi</b>, silahkan <b>isi dengan angka/ harga pengadaan per unit</b> !";		
	}
	if (trim($txtJumlah)=="" or ! is_numeric(trim($txtJumlah))) {
		$pesanError[] = "Data <b>Jumlah (Qty) belum diisi</b>, silahkan <b>isi dengan angka </b> !";		
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
		# Jika jumlah error pesanError tidak ada, skrip di bawah dijalankan
		// Data yang ditemukan dimasukkan ke keranjang transaksi
		$tmpSql 	= "INSERT INTO tmp_pengadaan (kd_barang, deskripsi, harga_beli, jumlah, kd_petugas) 
					VALUES ('$cmbBarang', '$txtDeskripsi', '$txtHargaBeli', '$txtJumlah','$userLogin')";
		mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
		
		// kosongkan variabel Input Barang
		$dataBarang		= "";
		$dataDeskripsi	= "";
		$dataHargaBeli	= "";
		$dataJumlah		= "";
		
	}
}
else {
	// kosongkan variabel Input Barang
	$dataBarang		= "";
	$dataDeskripsi	= "";
	$dataHargaBeli	= "";
	$dataJumlah		= "";
}
// ============================================================================

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca variabel
	$txtTanggal 	= InggrisTgl($_POST['txtTanggal']);
	$cmbSupplier	= $_POST['cmbSupplier'];
	$cmbJenis		= $_POST['cmbJenis'];
	$txtKeterangan	= $_POST['txtKeterangan'];
			
	// Validasi Form
	$pesanError = array();
	if (trim($txtTanggal)=="--") {
		$pesanError[] = "Data <b>Tgl. Pengadaan</b> belum diisi, pilih pada combo !";		
	}
	if (trim($cmbSupplier)=="Kosong") {
		$pesanError[] = "Data <b> Nama Supplier</b> belum dipilih, silahkan pilih pada combo !";		
	}
	if (trim($cmbJenis)=="Kosong") {
		$pesanError[] = "Data <b> Nama Jenis</b> belum dipilih, silahkan pilih pada combo !";		
	}

	# Validasi jika belum ada satupun data item yang dimasukkan
	$tmpSql ="SELECT COUNT(*) As qty FROM tmp_pengadaan WHERE kd_petugas='$userLogin'";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpData = mysql_fetch_array($tmpQry);
	if ($tmpData['qty'] < 1) {
		$pesanError[] = "<b>DAFTAR BARANG MASIH KOSONG</b>, Daftar item barang yang dibeli belum dimasukan ";
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
		$kodeBaru = buatKode("pengadaan", "BB");
		$mySql	= "INSERT INTO pengadaan (no_pengadaan, tgl_pengadaan, keterangan, kd_supplier, jenis_pengadaan, kd_petugas) 
					VALUES ('$kodeBaru', '$txtTanggal', '$txtKeterangan', '$cmbSupplier', '$cmbJenis', '$userLogin')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			# Ambil semua data barang/barang yang dipilih, berdasarkan petugas yg login
			$tmpSql ="SELECT * FROM tmp_pengadaan WHERE kd_petugas='$userLogin'";
			$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp : ".mysql_error());
			while ($tmpData = mysql_fetch_array($tmpQry)) {
				$dataKode 		= $tmpData['kd_barang'];
				$dataDeskripsi 	= $tmpData['deskripsi'];
				$dataHarga 		= $tmpData['harga_beli'];
				$dataJumlah		= $tmpData['jumlah'];
				
				// Masukkan semua barang/barang dari TMP ke tabel pengadaan detail
				$itemSql	= "INSERT INTO pengadaan_item (no_pengadaan, kd_barang, deskripsi, harga_beli, jumlah) 
								VALUES ('$kodeBaru', '$dataKode', '$dataDeskripsi', '$dataHarga', '$dataJumlah')";
				mysql_query($itemSql, $koneksidb) or die ("Gagal Query Item : ".mysql_error());

				// Update stok (Jumlah barang + jumlah barang masuk)
				$stokSql = "UPDATE barang SET jumlah = jumlah + $dataJumlah WHERE kd_barang='$dataKode'";
				mysql_query($stokSql, $koneksidb) or die ("Gagal Query Update Stok : ".mysql_error());

				# Membuat Kode koleksi Buku
				for($i =1; $i <= $dataJumlah; $i++) {
					// Membuat Kode Label Inventaris baru, menggunakan Fungsi buatKodeKoleksi() dari library/inc.library.php
					$kodeDepan		= $dataKode.".";
					$kodeInventaris = buatKodeKoleksi2("barang_inventaris", $kodeDepan);
					
					// Input data kode Inventaris
					$tgl_masuk	= date('Y-m-d');
					$th_datang	= date('Y');
					$mySql	= "INSERT INTO barang_inventaris(kd_inventaris, kd_barang, no_pengadaan, tgl_masuk, th_datang, harga_barang, keterangan, status_barang) 
								VALUES('$kodeInventaris', '$dataKode', '$kodeBaru', '$tgl_masuk', '$th_datang', '$dataHarga', '$txtKeterangan', 'Tersedia')";
					mysql_query($mySql, $koneksidb) or die ("Gagal query inventaris : ".mysql_error());
				}
			}
			
			# Kosongkan Tmp jika datanya sudah dipindah
			$hapusSql = "DELETE FROM tmp_pengadaan WHERE kd_petugas='$userLogin'";
			mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp ".mysql_error());
			
			// Refresh halaman
			echo "<meta http-equiv='refresh' content='0; url=?open=Pengadaan-Baru'>";

			echo "<script>";
			echo "window.open('../cetak/pengadaan_cetak.php?noNota=$noTransaksi')";
			echo "</script>";
		}
	}	
}

# TAMPILKAN DATA KE FORM
$noTransaksi 	= buatKode("pengadaan", "BB");
$tglTransaksi 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');

$dataSupplier	= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : '';

$dataJenis		= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';

?>

<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="form1">
<table width="900" cellspacing="1" class="table-list" style="margin-top:0px;">
	<tr>
	  <td colspan="3"><h1>TRANSAKSI PENGADAAN </h1> </td>
	</tr>
	<tr>
	  <td bgcolor="#F5F5F5"><strong>DATA TRANSAKSI </strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td width="24%"><strong>No. Pengadaan </strong></td>
	  <td width="1%"><strong>:</strong></td>
	  <td width="75%"><input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="20" readonly="readonly"/></td></tr>
	<tr>
      <td><strong>Tgl.  Pengadaan </strong></td>
	  <td><strong>:</strong></td>
	  <td><input type="text" name="txtTanggal" class="tcal" value="<?php echo $tglTransaksi; ?>" /></td>
    </tr>
	<tr>
      <td><strong>Supplier (Asal Barang) </strong></td>
	  <td><strong>:</strong></td>
	  <td><b>
        <select name="cmbSupplier">
          <option value="Kosong">....</option>
          <?php
	  $mySql = "SELECT * FROM supplier ORDER BY kd_supplier";
	  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($myData = mysql_fetch_array($myQry)) {
	  	if ($dataSupplier == $myData['kd_supplier']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$myData[kd_supplier]' $cek>[ $myData[kd_supplier] ] $myData[nm_supplier]</option>";
	  }
	  ?>
        </select>
	  </b></td>
    </tr>
	<tr>
      <td><strong>Jenis Pengadaan </strong></td>
	  <td><strong>:</strong></td>
	  <td><b>
	    <select name="cmbJenis">
          <option value="Kosong">....</option>
          <?php
		  include_once "../library/inc.pilihan.php";
          foreach ($jenisPengadaan as $nilai) {
            if ($dataJenis == $nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
	  </b></td>
    </tr>
	<tr>
      <td><strong>Keterangan</strong></td>
	  <td><strong>:</strong></td>
	  <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="60" maxlength="100" /></td>
    </tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td bgcolor="#F5F5F5"><strong>INPUT  BARANG </strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
      <td><strong>Kategori</strong></td>
	  <td><b>:</b></td>
	  <td><select name="cmbKategori" onchange="javascript:submitform();">
          <option value="Kosong"> .... </option>
          <?php
	  $daftarSql = "SELECT * FROM kategori  ORDER BY kd_kategori";
	  $daftarQry = mysql_query($daftarSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($daftarData = mysql_fetch_array($daftarQry)) {
		if ($daftarData['kd_kategori'] == $dataKategori) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$daftarData[kd_kategori]' $cek> $daftarData[nm_kategori]</option>";
	  }
	  ?>
      </select>
	    <strong>
	    <input name="btnPilih" type="submit" id="btnPilih" value=" Pilih " />
      </strong></td>
    </tr>
	<tr>
	  <td><strong>Nama Barang </strong></td>
	  <td><strong>:</strong></td>
	  <td><b>
	    <select name="cmbBarang">
          <option value="Kosong">....</option>
          <?php
	  $mySql = "SELECT * FROM barang WHERE kd_kategori='$dataKategori' ORDER BY nm_barang";
	  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($myData = mysql_fetch_array($myQry)) {
	  	if ($dataBarang == $myData['kd_barang']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$myData[kd_barang]' $cek> [ $myData[kd_barang] ] $myData[nm_barang]</option>";
	  }
	  ?>
        </select>
	  </b><a href="?page=Pencarian-Barang" target="_blank"></a></td>
    </tr>
	<tr>
	  <td><strong>Deskripsi Barang </strong></td>
	  <td><strong>:</strong></td>
	  <td><input name="txtDeskripsi" value="<?php echo $dataDeskripsi; ?>"  size="80" maxlength="100" /></td>
    </tr>
	<tr>
	  <td><strong>Harga Barang/ Beli (Rp.) </strong></td>
	  <td><strong>:</strong></td>
	  <td><b>
	    <input name="txtHargaBeli"  size="18" maxlength="12" />
	    Jumlah  : 
          <input class="angkaC" name="txtJumlah" size="3" maxlength="4" value="1" 
	  		 onblur="if (value == '') {value = '1'}" 
      		 onfocus="if (value == '1') {value =''}"/>
          <input name="btnTambah" type="submit" style="cursor:pointer;" value=" Tambah " />
      </b></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input name="btnSimpan" type="submit" style="cursor:pointer;" value=" SIMPAN DATA " /></td>
    </tr>
</table>

<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th colspan="8">DAFTAR BARANG</th>
    </tr>
  <tr>
    <td width="27" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="59" bgcolor="#CCCCCC"><strong>Kode </strong></td>
    <td width="189" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
    <td width="257" bgcolor="#CCCCCC"><strong>Deskripsi</strong></td>
    <td width="115" align="right" bgcolor="#CCCCCC"><strong>Harga (Rp) </strong></td>
    <td width="48" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
    <td width="125" align="right" bgcolor="#CCCCCC"><strong>Total Biaya (Rp)</strong></td>
    <td width="39" align="center" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
	<?php
	//  tabel menu 
	$tmpSql ="SELECT tmp_pengadaan.*, barang.nm_barang FROM tmp_pengadaan, barang
			  WHERE tmp_pengadaan.kd_barang=barang.kd_barang AND tmp_pengadaan.kd_petugas='$userLogin' ORDER BY id";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$nomor=0; $subTotal=0; $totalBelanja = 0; $qtyItem = 0; 
	while($tmpData = mysql_fetch_array($tmpQry)) {
		$ID			= $tmpData['id'];
		$qtyItem	= $qtyItem + $tmpData['jumlah'];
		$subTotal		= $tmpData['harga_beli'] * $tmpData['jumlah']; // Harga beli dari tabel tmp_pengadaan (harga terbaru yang diinput)
		$totalBelanja	= $totalBelanja + $subTotal;
		$nomor++;
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $tmpData['kd_barang']; ?></td>
    <td><?php echo $tmpData['nm_barang']; ?></td>
    <td><?php echo $tmpData['deskripsi']; ?></td>
    <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo format_angka($tmpData['harga_beli']); ?></td>
    <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $tmpData['jumlah']; ?></td>
    <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo format_angka($subTotal); ?></td>
    <td align="center" bgcolor="#FFFFCC"><a href="?Act=Delete&ID=<?php echo $ID; ?>" target="_self">Delete</a></td>
  </tr>
<?php 
}?>
  <tr>
    <td colspan="5" align="right"><b> GRAND TOTAL : </b></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo $qtyItem; ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong>Rp. <?php echo format_angka($totalBelanja); ?></strong></td>
    <td align="center">&nbsp;</td>
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
