<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_kategori'] == "Yes") {

// Simpan Variabel KeyWord (kata kunci)
$keyWord	= isset($_GET['keyWord']) ? $_GET['keyWord'] : '';
$dataKeyWord= isset($_POST['txtkeyWord']) ? $_POST['txtkeyWord'] : $keyWord;

// Membuat SQL Filter data
if(trim($dataKeyWord) == "") {
	// Jika kategori milih Semua, dan Kata Kunci tidak diisi
	$filterSQL = "";
}
else {
	$filterSQL = "WHERE nm_kategori LIKE '%$dataKeyWord%'";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM kategori $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2" align="right"><h1><b>DATA KATEGORI</b></h1></td>
  </tr>
  <tr>
    <td colspan="2"><a href="?open=Kategori-Add" target="_self"><img src="images/btn_add_data.png" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2">
	
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
      <table width="100%" border="0"  class="table-list">
        <tr>
          <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
        </tr>

        <tr>
          <td width="84"><strong>Cari Kategori </strong></td>
          <td width="5"><strong>:</strong></td>
          <td width="791"><input name="txtkeyWord" type="text" value="<?php echo $dataKeyWord; ?>" size="40" maxlength="100" />
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
        <th width="23" align="center"><b>No</b></th>
        <th width="51"><b>Kode</b></th>
        <th width="584"><b>Nama Kategori </b></th>
        <th width="125" align="right"><b>Qty Barang </b> </th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b><b></b></td>
        </tr>
      <?php
	  // Menampilkan daftar kategori
	$mySql = "SELECT * FROM kategori $filterSQL ORDER BY kd_kategori ASC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_kategori'];
		
		// Menghitung jumlah barang per Kategori
		$my2Sql = "SELECT COUNT(*) As qty_barang FROM barang WHERE kd_kategori='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_kategori']; ?></td>
        <td><?php echo $myData['nm_kategori']; ?></td>
        <td align="right"><?php echo $my2Data['qty_barang']; ?></td>
        <td width="40" align="center">
		<a href="?open=Kategori-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return 
				confirm('YAKIN AKAN MENGHAPUS DATA KATEGORI ( <?php echo $Kode; ?> ) INI ... ?')"> Delete</a></td>
        <td width="40" align="center">
		<a href="?open=Kategori-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data"> Edit</a></td>
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
		echo " <a href='?open=Kategori-Data&hal=$list[$h]&keyWord=$dataKeyWord'>$h</a> ";
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
