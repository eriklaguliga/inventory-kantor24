<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_penempatan'] == "Yes") {

// Variabel SQL
$filterSQL= "";

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
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$baris);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pencarian Barang - Inventory Kantor ( Aset Barang )</title>
<link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2"><h1><b>PENCARIAN BARANG </b></h1></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0"  class="table-list">
        <tr>
          <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
        </tr>
        <tr>
          <td width="132"><b>Nama Kategori </b></td>
          <td width="11"><b>:</b></td>
          <td width="737">
		  <select name="cmbKategori">
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
            </select></td>
        </tr>
        <tr>
          <td><strong>Cari Nama </strong></td>
          <td><strong>:</strong></td>
          <td><input name="txtkeyWord" type="text" value="<?php echo $dataKeyWord; ?>" size="40" maxlength="100" />
            <input name="btnTampil" type="submit" value=" Tampilkan " /></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td colspan="2" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="29" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="51" bgcolor="#CCCCCC"><strong>Kode</strong></td>
        <td width="463" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
        <td width="178" bgcolor="#CCCCCC"><strong>Merek</strong></td>
        <td width="147" align="center" bgcolor="#CCCCCC"><strong>Kode Label </strong></td>
        </tr>
      <?php
	# MENJALANKAN QUERY FILTER DI ATAS
	$mySql = "SELECT * FROM barang $filterSQL ORDER BY kd_barang ASC LIMIT $hal, $baris";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];

		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_barang']; ?></td>
        <td><?php echo $myData['nm_barang']; ?></td>
        <td><?php echo $myData['merek']; ?></td>
        <td bgcolor="<?php echo $warna; ?>">
		<ul>
		<?php
			// Menampilkan daftar koleksi barang (Kode Inventaris)
			$my2Sql = "SELECT * FROM barang_inventaris WHERE kd_barang='$Kode'";
			$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query  salah : ".mysql_error());
			while ($my2Data = mysql_fetch_array($my2Qry)) {
				echo "<li>";
				if($my2Data['status_barang']=="Ditempatkan") {
					echo $my2Data['kd_inventaris']." <br>";
				}
				elseif($my2Data['status_barang']=="Dipinjam") {
					echo $my2Data['kd_inventaris']." <br>";
				}
				elseif($my2Data['status_barang']=="Tersedia") {
			?>
				  <a href="#" onClick="window.opener.document.getElementById('txtKodeInventaris').value = '<?php echo $my2Data['kd_inventaris']; ?>'; 
				  						window.opener.document.getElementById('txtNamaBrg').value = '<?php echo $myData['nm_barang']; ?>';
										window.close();"> <b><?php echo $my2Data['kd_inventaris']; ?> </b> <br>
			    </a>
          <?php
		  	echo "</li>";
		   } } ?>
		  </ul> </td>
        </tr>
      <?php } ?>
      <tr>
        <td colspan="3" bgcolor="#F5F5F5"><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
        <td colspan="2" align="right" bgcolor="#F5F5F5"><b>Halaman ke :</b>
            <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?page=Pencarian-Barang&hal=$list[$h]&kodeKategori=$dataKategori&keyWord=$dataKeyWord'>$h</a> ";
	}
	?></td>
      </tr>
    </table></td>
  </tr>
</table>
<p><strong>KETERANGAN</strong></p>
<ul>
  <li>Kode Label Inventaris yang dapat diklik, berarti status barang Tersedia</li>
  <li>Kode Label Innventaris yang mati (tidak dapat diklik), berarti status barang Dipinjam/ Ditempatkan  </li>
</ul>
</form>
</body>
</html>

<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
