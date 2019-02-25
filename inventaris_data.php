<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_data_inventaris'] == "Yes") {

// Set variabel SQL
$filterSQL = "";

# BACA VARIABEL KATEGORI
$kodeKategori = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'Semua';
$dataKategori = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;

# Filter Data
if(trim($dataKategori) =="Semua") {
	$filterSQL = "";
}
else {
	// Jika kategori milih data, dan Kata Kunci tidak diisi
	$filterSQL = "WHERE barang.kd_kategori='$dataKategori'";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;  // Jumlah baris data
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang_inventaris LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:".mysql_error());  
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);

?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmedit">
  <table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
    <tr>
      <td colspan="2" align="right"><h1><b>DATA INVENTARIS(ASET)  </b></h1></td>
    </tr>
    <tr>
      <td colspan="2"><table width="100%" border="0"  class="table-list">
          <tr>
            <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
          </tr>
          <tr>
            <td width="134"><strong> Kategori </strong></td>
            <td width="5"><strong>:</strong></td>
            <td width="741"><select name="cmbKategori">
                <option value="Semua">....</option>
                <?php
		  $daftarSql = "SELECT * FROM kategori ORDER BY kd_kategori";
		  $daftarQry = mysql_query($daftarSql, $koneksidb) or die ("Gagal Query".mysql_error());
		  while ($daftarData = mysql_fetch_array($daftarQry)) {
			if ($dataKategori == $daftarData['kd_kategori']) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$daftarData[kd_kategori]' $cek>$daftarData[nm_kategori]</option>";
		  }
		  ?>
            </select>
            <input name="btnTampil" type="submit" id="btnTampil" value=" Tampil " /></td>
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
      <td colspan="2"><table class="table-list" width="1000" border="0" cellspacing="1" cellpadding="2">
          <tr>
            <td colspan="10"><strong>DAFTAR ASET </strong> </td>
          </tr>
          <tr>
            <td width="22" bgcolor="#F5F5F5"><strong>No</strong></td>
            <td width="100" bgcolor="#F5F5F5"><strong>Kode Label</strong></td>
            <td width="100" bgcolor="#F5F5F5"><strong>Nomor Seri </strong></td>
            <td width="305" bgcolor="#F5F5F5"><strong>Nama Barang </strong></td>
            <td width="90" bgcolor="#F5F5F5"><strong>Status</strong></td>
            <td width="152" bgcolor="#F5F5F5"><strong>Lokasi</strong></td>
            <td colspan="4" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
          </tr>
          <?php
	# MENAMPILKAN DATA ASET BARANG (INVENTARIS BARANG)
	$mySql = "SELECT barang_inventaris.*, barang.nm_barang FROM barang_inventaris 
				LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
				$filterSQL ORDER BY kd_barang, kd_inventaris LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$KodeInventaris = $myData['kd_inventaris'];
		
		$infoLokasi	= "";
		
		// Mencari lokasi Penempatan Barang
		if($myData['status_barang']=="Ditempatkan") {
			$my2Sql = "SELECT lokasi.nm_lokasi FROM penempatan_item as PI
						LEFT JOIN penempatan ON PI.no_penempatan=penempatan.no_penempatan
						LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi
						WHERE PI.status_aktif='Yes' AND PI.kd_inventaris='$KodeInventaris'";  
			$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
			$my2Data = mysql_fetch_array($my2Qry);
			$infoLokasi	= $my2Data['nm_lokasi'];
		}
		
		// Mencari Siapa Penempatan Barang
		if($myData['status_barang']=="Dipinjam") {
			$my3Sql = "SELECT pegawai.nm_pegawai FROM peminjaman_item as PI
						LEFT JOIN peminjaman ON PI.no_peminjaman=peminjaman.no_peminjaman
						LEFT JOIN pegawai ON peminjaman.kd_pegawai=pegawai.kd_pegawai
						WHERE peminjaman.status_kembali='Pinjam' AND PI.kd_inventaris='$KodeInventaris'";  
			$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
			$my3Data = mysql_fetch_array($my3Qry);
			$infoLokasi	= $my3Data['nm_pegawai'];
		}
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
          <tr bgcolor="<?php echo $warna; ?>">
            <td bgcolor="<?php echo $warna; ?>"><?php echo $nomor; ?></td>
            <td bgcolor="<?php echo $warna; ?>"><?php echo $myData['kd_inventaris']; ?></td>
            <td><?php echo $myData['nomor_seri']; ?></td>
            <td bgcolor="<?php echo $warna; ?>"><?php echo $myData['nm_barang']; ?></td>
            <td bgcolor="<?php echo $warna; ?>"><?php echo $myData['status_barang']; ?></td>
            <td bgcolor="<?php echo $warna; ?>"><?php echo $infoLokasi; ?></td>
            <td width="45" align="center" bgcolor="<?php echo $warna; ?>"><a href="pemeliharaan/?open=Pemeliharaan-Baru-2&Kode=<?php echo $KodeInventaris; ?>" target="_blank">Pemeliharaan</a></td>
            <td width="45" align="center" bgcolor="<?php echo $warna; ?>"><a href="?open=Inventaris-Resume&Kode=<?php echo $KodeInventaris; ?>" target="_self">Resume</a></td>
            <td width="45" align="center" bgcolor="<?php echo $warna; ?>"><a href="?open=Inventaris-Edit&Kode=<?php echo $KodeInventaris; ?>" target="_self" alt="Edit Data">Edit</a></td>
            <td width="45" align="center"><a href="?open=Inventaris-View&Kode=<?php echo $KodeInventaris; ?>" target="_blank" alt="View Data">View</a></td>
          </tr>
          <?php } ?>
          <tr>
            <td colspan="3"><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
            <td colspan="7" align="right"><b>Halaman ke :</b>
              <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?open=Inventaris-Data&hal=$list[$h]&kodeKategori=$dataKategori'>$h</a> ";
	}
	?></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>

<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
