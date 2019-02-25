<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_petugas'] == "Yes") {

// Simpan Variabel KeyWord (kata kunci)
$keyWord	= isset($_GET['keyWord']) ? $_GET['keyWord'] : '';
$dataKeyWord= isset($_POST['txtkeyWord']) ? $_POST['txtkeyWord'] : $keyWord;

// Membuat SQL Filter data
if(trim($dataKeyWord) == "") {
	// Jika kategori milih Semua, dan Kata Kunci tidak diisi
	$filterSQL = "";
}
else {
	$filterSQL = "WHERE nm_petugas LIKE '%$dataKeyWord%'";
}

?>
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2" align="right"><h1><b>DATA PETUGAS </b></h1></td>
  </tr>
  <tr>
    <td colspan="2"><a href="?open=Petugas-Add" target="_self"><img src="images/btn_add_data.png"  border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2"> 
	
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
      <table width="100%" border="0"  class="table-list">
        <tr>
          <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
        </tr>

        <tr>
          <td width="100"><strong>Cari Petugas </strong></td>
          <td width="5"><strong>:</strong></td>
          <td width="775"><input name="txtkeyWord" type="text" value="<?php echo $dataKeyWord; ?>" size="40" maxlength="100" />
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
        <th width="24">No</th>
        <th width="41">&nbsp;</th>
        <th width="49">Kode</th>
        <th width="302">Nama Petugas </th>
        <th width="133">No. Telepon </th>
        <th width="125">Username</th>
        <th width="93">Level</th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b><b></b></td>
        </tr>
      <?php
	  // Skrip menampilkan data Petugas
	$mySql 	= "SELECT * FROM petugas $filterSQL ORDER BY kd_petugas ASC";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_petugas'];
		
		// Menampilkan gambar
		if($myData['foto']=="") { $fileGambar = "noimage.jpg"; }
		else { $fileGambar = $myData['foto']; }
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><img src="foto/petugas/<?php echo $fileGambar; ?>" width="41" height="41" /></td>
        <td><?php echo $myData['kd_petugas']; ?></td>
        <td><?php echo $myData['nm_petugas']; ?></td>
        <td><?php echo $myData['no_telepon']; ?></td>
        <td><?php echo $myData['username']; ?></td>
        <td><?php echo $myData['level']; ?></td>
        <td width="39" align="center"><a href="?open=Petugas-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" 
				onclick="return confirm('YAKIN AKAN MENGHAPUS DATA PETUGAS INI ... ?')">Delete</a></td>
		<td width="42" align="center"><a href="?open=Petugas-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
      </tr>
      <?php } ?>
    </table>    </td>
  </tr>
</table>

<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
