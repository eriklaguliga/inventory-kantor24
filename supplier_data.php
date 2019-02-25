<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_supplier'] == "Yes") {

// Simpan Variabel KeyWord (kata kunci)
$keyWord	= isset($_GET['keyWord']) ? $_GET['keyWord'] : '';
$dataKeyWord= isset($_POST['txtkeyWord']) ? $_POST['txtkeyWord'] : $keyWord;

// Membuat SQL Filter data
if(trim($dataKeyWord) == "") {
	// Jika kategori milih Semua, dan Kata Kunci tidak diisi
	$filterSQL = "";
}
else {
	$filterSQL = "WHERE nm_supplier LIKE '%$dataKeyWord%'";
}


# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM supplier $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2" align="right"><h1><b>DATA SUPPLIER </b></h1></td>
  </tr>
  <tr>
    <td colspan="2"><a href="?open=Supplier-Add" target="_self"><img src="images/btn_add_data.png"  border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2">
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
      <table width="100%" border="0"  class="table-list">
        <tr>
          <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
        </tr>

        <tr>
          <td width="84"><strong>Cari Nama </strong></td>
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
        <th width="21" align="center">No</th>
        <th width="45">Kode</th>
        <th width="180">Nama Supplier </th>
        <th width="412">Alamat</th>
        <th width="120">No. Telepon </th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b><b></b></td>
        </tr>
      <?php
	  // Skrip menampilkan data Supplier
	$mySql = "SELECT * FROM supplier $filterSQL ORDER BY kd_supplier ASC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_supplier'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_supplier']; ?></td>
        <td><?php echo $myData['nm_supplier']; ?></td>
        <td><?php echo $myData['alamat']; ?></td>
        <td><?php echo $myData['no_telepon']; ?></td>
        <td width="40" align="center"><a href="?open=Supplier-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA SUPPLIER ( <?php echo $Kode; ?> ) INI ... ?')">Delete</a></td>
        <td width="40" align="center"><a href="?open=Supplier-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
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
		echo " <a href='?open=Supplier-Data&hal=$list[$h]&keyWord=$dataKeyWord'>$h</a> ";
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
