<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_mutasi'] == "Yes") {

// Variabel SQL
$filterSQL	= "";
$cariSQL	= "";

// Variabel data Combo Lokasi
$kodeDepartemen	= isset($_GET['kodeDepartemen']) ? $_GET['kodeDepartemen'] : 'Semua'; // dari URL
$dataDepartemen	= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : $kodeDepartemen; // dari Form

// Variabel data Combo Lokasi
$kodeLokasi	= isset($_GET['kodeLokasi']) ? $_GET['kodeLokasi'] : 'Semua'; // dari URL
$dataLokasi	= isset($_POST['cmbLokasi']) ? $_POST['cmbLokasi'] : $kodeLokasi; // dari Form

# MEMBUAT FILTER DATA
if (trim($dataLokasi) =="Semua") {
	if (trim($dataDepartemen) =="Semua") {
		// Jika Lokasi Kosong Semua, dan Departemen Kosong
		$filterSQL = "";
	}
	else {
		// dan Jika Lokasi Kosong (Semua), dan Departemen dipilih
		$filterSQL = " AND lokasi.kd_departemen='$dataDepartemen'";
	}
}
else {
	// Jika Lokasi dipilih
	$filterSQL = "AND penempatan.kd_lokasi='$dataLokasi'";
}

# ==========================================================================================================

// Simpan Variabel KeyWord (kata kunci)
$keyWord	= isset($_GET['keyWord']) ? $_GET['keyWord'] : '';
$dataKeyWord= isset($_POST['txtkeyWord']) ? $_POST['txtkeyWord'] : $keyWord;

if(isset($_POST['btnCari'])) {
	if(trim($dataKeyWord) == "") {
		// Jika kategori milih Semua, dan Kata Kunci tidak diisi
		$cariSQL = "";
	}
	else {
		$dataKeyWord	= trim($dataKeyWord);
		$cariSQL = "AND pi.kd_inventaris LIKE '%$dataKeyWord%'";
	}
}
else {
	$cariSQL = "";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris = 50;  // Jumlah baris data
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql	= "SELECT * FROM penempatan_item as PI 
				LEFT JOIN penempatan ON PI.no_penempatan = penempatan.no_penempatan
				LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
			WHERE PI.status_aktif='Yes'
			$filterSQL $cariSQL ";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$baris );
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pencarian Inventaris Barang - Inventory Kantor ( Aset Barang )</title>
<link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2"><h2><b>PENCARIAN  BARANG </b>YANG DITEMPATKAN </h2></td>
  </tr>
  <tr>
    <td colspan="2">
	  <table width="900" border="0"  class="table-list">
        <tr>
          <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
        </tr>
        <tr>
          <td><b> Departemen </b></td>
          <td><b>:</b></td>
          <td><select name="cmbDepartemen" onChange="javascript:submitform();" >
              <option value="Semua">....</option>
              <?php
		  // Skrip menampilkan data Departemen dalam ComboBox
	  $comboSql = "SELECT * FROM departemen ORDER BY kd_departemen";
	  $comboQry = mysql_query($comboSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($comboData = mysql_fetch_array($comboQry)) {
		if ($comboData['kd_departemen'] == $dataDepartemen) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$comboData[kd_departemen]' $cek>$comboData[nm_departemen]</option>";
	  }
	  ?>
          </select></td>
        </tr>
        <tr>
          <td width="156"><b> Lokasi </b></td>
          <td width="11"><b>:</b></td>
          <td width="719"><select name="cmbLokasi">
              <option value="Semua"> ....</option>
              <?php
			  // Menampilkan data Lokasi per Departemen yang dipilih dari ComboBox
		  $comboSql = "SELECT * FROM lokasi WHERE kd_departemen='$dataDepartemen' ORDER BY kd_lokasi";
		  $comboQry = mysql_query($comboSql, $koneksidb) or die ("Gagal Query".mysql_error());
		  while ($comboData = mysql_fetch_array($comboQry)) {
			if ($comboData['kd_lokasi'] == $dataLokasi) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$comboData[kd_lokasi]' $cek>$comboData[nm_lokasi]</option>";
		  }
		  ?>
            </select>
              <input name="btnTampil2" type="submit" value=" Tampilkan " /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Kata Kunci (Kode Label) </strong></td>
          <td><strong>:</strong></td>
          <td><input name="txtkeyWord" type="text" value="<?php echo $dataKeyWord; ?>" size="40" maxlength="40" />
              <input name="btnCari" type="submit"  value="Cari" /></td>
        </tr>
      </table>
	  </td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td colspan="2" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="28" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="121" bgcolor="#CCCCCC"><strong>Kode Barang </strong></td>
        <td width="474" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
        <td width="150" bgcolor="#CCCCCC"><strong>Kategori</strong></td>
        <td width="150" bgcolor="#CCCCCC"><strong>Lokasi</strong></td>
      </tr>
      <?php
	// Menampilkan data barang yang aktif ditempatkan dari tabel Penempatan_item
	$mySql	= "SELECT PI.*, barang.nm_barang, kategori.nm_kategori, lokasi.nm_lokasi FROM penempatan_item as PI
					LEFT JOIN penempatan ON PI.no_penempatan = penempatan.no_penempatan
					LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi
					LEFT JOIN barang_inventaris ON PI.kd_inventaris = barang_inventaris.kd_inventaris
					LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
					LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
				WHERE penempatan.no_penempatan = PI.no_penempatan AND PI.status_aktif='Yes'
				$filterSQL
				$cariSQL
				ORDER BY PI.kd_inventaris LIMIT $hal, $baris ";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_inventaris'];
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td>
			<a href="#" onClick="window.opener.document.getElementById('txtKodeInventaris').value = '<?php echo $myData['kd_inventaris']; ?>'; 
								window.opener.document.getElementById('txtNamaBrg').value = '<?php echo $myData['nm_barang']; ?>';
								window.close();">
			<b><?php echo $myData['kd_inventaris']; ?> </b>	 </a> </td>
        <td><?php echo $myData['nm_barang']; ?></td>
        <td><?php echo $myData['nm_kategori']; ?></td>
        <td><?php echo $myData['nm_lokasi']; ?></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="3"><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
        <td colspan="2" align="right"><b>Halaman ke :</b>
    <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $baris * $h - $baris ;
		echo " <a href='?page=Pencarian-Barang&hal=$list[$h]&keyWord=$dataKeyWord&kodeLokasi=$dataLokasi&kodeDepartemen=$dataDepartemen'>$h</a> ";
	}
	?></td>
        </tr>
    </table></td>
  </tr>
</table>
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
