<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_barang'] == "Yes") {

// Temporary Variabel form
$kodeKategori	= isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua'; // dari URL
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori; // dari Form

// Simpan Variabel KeyWord (kata kunci)
$keyWord	= isset($_GET['keyWord']) ? $_GET['keyWord'] : '';
$dataKeyWord= isset($_POST['txtkeyWord']) ? $_POST['txtkeyWord'] : $keyWord;

// Membuat SQL Filter data
if(trim($dataKategori) =="Semua") {
	if(trim($dataKeyWord) == "") {
		// Jika kategori milih Semua, dan Kata Kunci tidak diisi
		$filterSQL = "";
	}
	else {
		$filterSQL = "WHERE nm_barang LIKE '%$dataKeyWord%'";
	}
}
else {
	if(trim($dataKeyWord) == "") {
		// Jika kategori milih data, dan Kata Kunci tidak diisi
		$filterSQL = "WHERE kd_kategori='$dataKategori'";
	}
	else {
		$filterSQL = "WHERE kd_kategori='$dataKategori' AND nm_barang LIKE '%$dataKeyWord%'";
	}
}


# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2" align="right"><h1><b>DATA  BARANG </b></h1></td>
  </tr>
  <tr>
    <td width="401"><a href="?open=Barang-Add" target="_self"><img src="images/btn_add_data.png" border="0" /></a></td>
    <td width="488" align="right"></td>
  </tr>
  <tr>
    <td colspan="2">
	
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="134"><b>Nama Kategori </b></td>
      <td width="5"><b>:</b></td>
      <td width="741"><select name="cmbKategori">
          <option value="Semua">....</option>
          <?php
		  // Menampilkan data Kategori
	  $dataSql = "SELECT * FROM kategori ORDER BY kd_kategori";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
		if ($dataRow['kd_kategori'] == $dataKategori) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$dataRow[kd_kategori]' $cek>$dataRow[nm_kategori]</option>";
	  }
	  ?>
      </select>
      <input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
    <tr>
      <td><strong>Cari Nama </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtkeyWord" type="text" value="<?php echo $dataKeyWord; ?>" size="40" maxlength="100" />
          <input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>
	</td>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="23" align="center"><strong>No</strong></th>
        <th width="51"><strong>Kode</strong></th>
        <th width="417"><strong>Nama Barang</strong></th>
        <th width="132">Merek</th>
        <th width="70" align="center"><strong>Jumlah</strong></th>
        <th width="80"><strong>Satuan</strong></th>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>
      <?php
	  // Menampilkan data Barang
	$mySql = "SELECT * FROM barang $filterSQL ORDER BY kd_barang ASC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_barang']; ?></td>
        <td><?php echo $myData['nm_barang']; ?></td>
        <td><?php echo $myData['merek']; ?></td>
        <td align="center"><?php echo format_angka($myData['jumlah']); ?></td>
        <td><?php echo $myData['satuan']; ?></td>
        <td width="40" align="center"><a href="?open=Barang-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" 
						onclick="return confirm('YAKIN AKAN MENGHAPUS DATA BARANG ( <?php echo $Kode; ?> ) INI ... ?')">Delete</a></td>
        <td width="40" align="center"><a href="?open=Barang-Edit&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
        <td width="40" align="center"><a href="?open=Barang-View&amp;Kode=<?php echo $Kode; ?>" target="_blank" alt="Edit Data">View</a></td>
        </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr class="selKecil">
    <td><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td align="right"><b>Halaman ke :</b> 
	<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?open=Barang-Data&hal=$list[$h]&kodeKategori=$dataKategori&keyWord=$dataKeyWord'>$h</a> ";
	}
	?>	</td>
  </tr>
</table>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
