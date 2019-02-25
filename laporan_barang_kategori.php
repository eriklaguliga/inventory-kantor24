<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_barang_kategori'] == "Yes") {

// Variabel SQL
$filterSQL= "";

// Temporary Variabel form
$kodeKategori	= isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua'; // dari URL
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori; // dari Form

# PENCARIAN DATA BERDASARKAN FILTER DATA
if(isset($_POST['btnTampil'])) {
	# PILIH KATEGORI
	if (trim($dataKategori) =="Semua") {
		$filterSQL = "";
	}
	else {
		$filterSQL = "WHERE kd_kategori='$dataKategori'";
	}
}
else {
	if(isset($kodeKategori)) {
		$filterSQL = "WHERE kd_kategori='$kodeKategori'";
	}
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row 	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<h2> LAPORAN DATA BARANG PER KATEGORI</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="137"><b>Nama Kategori </b></td>
      <td width="5"><b>:</b></td>
      <td width="744">
	  <select name="cmbKategori">
          <option value="Semua"> .... </option>
          <?php
		  // Menampilkan data Kategori ke dalam ComboBox (ListMenu)
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
  </table>
</form>
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="45" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="329" bgcolor="#CCCCCC"><strong>Nama Barang</strong></td>
    <td width="140" bgcolor="#CCCCCC"><strong>Merek</strong></td>
    <td width="50" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
    <td width="70" align="right" bgcolor="#CCCCCC"><strong> Tersedia </strong></td>
    <td width="87" align="right" bgcolor="#CCCCCC"><strong>Ditempatkan</strong></td>
    <td width="70" align="right" bgcolor="#CCCCCC"><strong>Dipinjam</strong></td>
    <td width="40" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
	// Skrip menampilkan data Barang dengan filter Kategori
	$mySql 	= "SELECT * FROM barang $filterSQL ORDER BY kd_barang ASC LIMIT $hal, $row";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];
		
		// Membuat variabel akan diisi angka
		$jumTersedia =0;
		$jumDitempatkan =0; 
		$jumDipinjam =0;
		
		// Query menampilkan data Inventaris per Kode barang
		$my2Sql = "SELECT * FROM barang_inventaris WHERE kd_barang='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		while($my2Data = mysql_fetch_array($my2Qry)) {
			if($my2Data['status_barang']=="Tersedia") {
				$jumTersedia++;
			}
			
			if($my2Data['status_barang']=="Ditempatkan") {
				$jumDitempatkan++;
			}
			
			if($my2Data['status_barang']=="Dipinjam") {
				$jumDipinjam++;
			}			
		}
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['merek']; ?></td>
    <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $myData['jumlah']; ?></td>
    <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $jumTersedia; ?></td>
    <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $jumDitempatkan; ?></td>
    <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $jumDipinjam; ?></td>
    <td align="center"><a href="cetak/barang_view.php?Kode=<?php echo $Kode; ?>" target="_blank">View</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td colspan="6" align="right" bgcolor="#F5F5F5"><b>Halaman ke :</b>
        <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?open=Laporan-Barang-per-Kategori&hal=$list[$h]&kodeKategori=$dataKategori'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<br />
<a href="cetak/barang_kategori.php?kodeKategori=<?php echo $dataKategori; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
