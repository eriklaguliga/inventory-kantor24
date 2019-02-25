<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_departemen'] == "Yes") {

// Simpan Variabel KeyWord (kata kunci)
$keyWord	= isset($_GET['keyWord']) ? $_GET['keyWord'] : '';
$dataKeyWord= isset($_POST['txtkeyWord']) ? $_POST['txtkeyWord'] : $keyWord;

// Membuat SQL Filter data
if(trim($dataKeyWord) == "") {
	// Jika kategori milih Semua, dan Kata Kunci tidak diisi
	$filterSQL = "";
}
else {
	$filterSQL = "WHERE nm_departemen LIKE '%$dataKeyWord%'";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM departemen $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2" align="right"><h1><b>DATA DEPARTEMEN</b></h1></td>
  </tr>
  <tr>
    <td colspan="2"><a href="?open=Departemen-Add" target="_self"><img src="images/btn_add_data.png"  border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2">
	
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
      <table width="100%" border="0"  class="table-list">
        <tr>
          <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
        </tr>

        <tr>
          <td width="123"><strong>Cari Departemen </strong></td>
          <td width="5"><strong>:</strong></td>
          <td width="752"><input name="txtkeyWord" type="text" value="<?php echo $dataKeyWord; ?>" size="40" maxlength="100" />
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
        <th width="49">Kode</th>
        <th width="279"><b>Nama Departemen </b></th>
        <th width="333">Keterangan</th>
        <th width="96" align="right"><b>Qty Lokasi </b> </th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b></td>
        </tr>
      <?php
	  // Menampilkan data Departemen
	$mySql = "SELECT * FROM departemen $filterSQL ORDER BY kd_departemen ASC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_departemen'];
		
		// Menghitung jumlah lokasi/lokasi per departemen
		$my2Sql = "SELECT COUNT(*) As qty_lokasi FROM lokasi WHERE kd_departemen='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_departemen']; ?></td>
        <td><?php echo $myData['nm_departemen']; ?></td>
        <td><?php echo $myData['keterangan']; ?></td>
        <td align="right"><?php echo $my2Data['qty_lokasi']; ?></td>
        <td width="41" align="center">
		<a href="?open=Departemen-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return 
				confirm('YAKIN AKAN MENGHAPUS DATA DEPARTEMEN ( <?php echo $Kode; ?> ) INI ... ?')"> Delete</a></td>
        <td width="40" align="center">
		<a href="?open=Departemen-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data"> Edit</a></td>
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
		echo " <a href='?open=Departemen-Data&hal=$list[$h]&keyWord=$dataKeyWord'>$h</a> ";
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
