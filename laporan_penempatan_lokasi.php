<?php
include_once "library/inc.seslogin.php";

// Variabel SQL
$filterSQL= "";

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
		$filterSQL = " WHERE lokasi.kd_departemen='$dataDepartemen'";
	}
}
else {
	// Jika Lokasi dipilih
	$filterSQL = "WHERE penempatan.kd_lokasi='$dataLokasi'";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/penempatan_lokasi.php?kodeLokasi=$dataLokasi', width=330,height=330,left=100, top=25)";
		echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penempatan LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$baris);
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 

<h2>LAPORAN DATA PENEMPATAN PER LOKASI </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td><b> Departemen </b></td>
      <td><b>:</b></td>
      <td><select name="cmbDepartemen" onchange="javascript:submitform();" >
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
      <td width="137"><b> Lokasi </b></td>
      <td width="6"><b>:</b></td>
      <td width="743"><select name="cmbLokasi">
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
          <input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="24" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="70" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="112" bgcolor="#CCCCCC"><strong>No. Transaksi</strong></td>
    <td width="285" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="243" bgcolor="#CCCCCC"><strong>Lokasi</strong></td>
    <td width="90" align="right" bgcolor="#CCCCCC"><strong>Qty Barang</strong></td>
    <td width="40" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
	// Skrip menampilkan data Transaksi Penempatan, dilengkapi informasi Lokasi, dan filter per Lokasi
	$mySql = "SELECT penempatan.*, lokasi.nm_lokasi FROM penempatan 
				LEFT JOIN lokasi ON penempatan.kd_lokasi = lokasi.kd_lokasi 
				$filterSQL
				ORDER BY penempatan.no_penempatan DESC LIMIT $hal, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		# Membaca Kode penempatan/ Nomor transaksi
		$noNota = $myData['no_penempatan'];
		
		# Menghitung Total Barang yang ditempatkan dilokasi terpilih
		$my2Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item WHERE  no_penempatan='$noNota'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penempatan']); ?></td>
    <td><?php echo $myData['no_penempatan']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td><?php echo $myData['nm_lokasi']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="center"><a href="cetak/penempatan_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><b>Jumlah Data :</b> <?php echo $jml; ?></td>
    <td colspan="4" align="right"><b>Halaman ke :</b>
        <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Penempatan-Lokasi&hal=$list[$h]&kodeLokasi=$dataLokasi'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<br />
<a href="cetak/penempatan_lokasi.php?kodeLokasi=<?php echo $dataLokasi; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
