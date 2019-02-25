<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_lokasi'] == "Yes") {

// Variabel SQL
$filterSQL= "";

// Temporary Variabel form
$Dept			= isset($_GET['Dept']) ? $_GET['Dept'] : 'Kosong'; // dari URL
$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $Dept; // dari Form

// Simpan Variabel KeyWord (kata kunci)
$keyWord		= isset($_GET['keyWord']) ? $_GET['keyWord'] : '';
$dataKeyWord	= isset($_POST['txtkeyWord']) ? $_POST['txtkeyWord'] : $keyWord;

if (trim($dataDepartemen) =="Kosong") {
	if(trim($dataKeyWord) == "") {
		// Jika kategori milih Semua, dan Kata Kunci tidak diisi
		$filterSQL = "";
	}
	else {
		$filterSQL = "WHERE nm_lokasi LIKE '%$dataKeyWord%'";
	}
}
else {
	if(trim($dataKeyWord) == "") {
		// Jika kategori milih data, dan Kata Kunci tidak diisi
		$filterSQL = "WHERE  lokasi.kd_departemen='$dataDepartemen'";
	}
	else {
		$filterSQL = "WHERE lokasi.kd_departemen='$dataDepartemen' AND nm_lokasi LIKE '%$dataKeyWord%'";
	}
}


# UNTUK PAGING (PEMlokasi HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM lokasi $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2" align="right"><h1><b>DATA LOKASI</b></h1></td>
  </tr>
  <tr>
    <td colspan="2"><a href="?open=Lokasi-Add" target="_self"><img src="images/btn_add_data.png"  border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2">
	
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="134"><b> Departemen </b></td>
      <td width="5"><b>:</b></td>
      <td width="741">
	  <select name="cmbDepartemen">
          <option value="Kosong">....</option>
          <?php
		  // Skrip menampilkan data Departemen dalam ComboBox
	  $dataSql = "SELECT * FROM departemen ORDER BY kd_departemen";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
		if ($dataRow['kd_departemen'] == $dataDepartemen) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$dataRow[kd_departemen]' $cek>$dataRow[nm_departemen]</option>";
	  }
	  ?>
      </select>
      <input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
    <tr>
      <td><strong>Cari Lokasi </strong></td>
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
        <th width="20" align="center"><b>No</b></th>
        <th width="50">Kode</th>
        <th width="493"><b>Nama Lokasi </b></th>
        <th width="220"><b>Departemen </b> </th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b></td>
        </tr>
      <?php
	  // Menampilkan data Lokasi, dilengkapi dengan data Departemen dari tabel relasi
	$mySql = "SELECT lokasi.*, departemen.nm_departemen FROM lokasi 
				LEFT JOIN departemen ON lokasi.kd_departemen=departemen.kd_departemen
				$filterSQL
				ORDER BY kd_lokasi ASC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_lokasi'];
				
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_lokasi']; ?></td>
        <td><?php echo $myData['nm_lokasi']; ?></td>
        <td><?php echo $myData['nm_departemen']; ?></td>
        <td width="40" align="center">
		<a href="?open=Lokasi-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('AKAN MENGHAPUS DATA LOKASI ( <?php echo $Kode; ?> ) INI ... ?')"> Delete</a></td>
         <td width="40" align="center">
		<a href="?open=Lokasi-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data"> Edit</a></td>
     </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr class="selKecil">
    <td><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td align="right"> <b>Halaman ke :</b> 
	<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?open=Lokasi-Data&hal=$list[$h]&Dept=$dataDepartemen&keyWord=$dataKeyWord'>$h</a> ";
	}
	?>
	</td>
  </tr>
</table>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
