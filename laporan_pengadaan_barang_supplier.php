<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mlap_pengadaan_barang_supplier'] == "Yes") {

# Supplier terpilih
$kodeSupplier = isset($_GET['kodeSupplier']) ? $_GET['kodeSupplier'] : 'Semua';
$dataSupplier = isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : $kodeSupplier;

#  Tahun Terpilih
$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# MEMBUAT SUB SQL FILTER
if(trim($dataSupplier)=="Semua") {
	// Semua Supplier
	$filterSQL 	= "AND LEFT(tgl_pengadaan,4)='$dataTahun'";
}
else {
	// Supplier terpilih, dan Tahun Terpilih
	$filterSQL 	= " AND pengadaan.kd_supplier ='$dataSupplier' AND LEFT(pengadaan.tgl_pengadaan,4)='$dataTahun'";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/pengadaan_barang_supplier.php?kodeSupplier=$dataSupplier&tahun=$dataTahun')";
		echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$barisData 	= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM pengadaan, pengadaan_item WHERE pengadaan.no_pengadaan = pengadaan_item.no_pengadaan  $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumData	= mysql_num_rows($pageQry);
$maksData	= ceil($jumData/$barisData);
?>
<h2>  LAPORAN PENGADAAN BARANG PER SUPPLIER </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="111"><strong>Supplier</strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="770">
	  <select name="cmbSupplier">
          <option value="Semua"> .... </option>
          <?php
	  $mySql = "SELECT * FROM supplier ORDER BY kd_supplier";
	  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($myData = mysql_fetch_array($myQry)) {
	  	if ($dataSupplier == $myData['kd_supplier']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$myData[kd_supplier]' $cek> $myData[nm_supplier]</option>";
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td><strong>Periode Tahun </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbTahun">
          <?php
		# Baca tahun terendah(kecil), dan tahun tertinggi(besar) di tabel Transaksi
		$thnSql = "SELECT MIN(LEFT(tgl_pengadaan,4)) As tahun_kecil, MAX(LEFT(tgl_pengadaan,4)) As tahun_besar FROM pengadaan";
		$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
		$thnRow	= mysql_fetch_array($thnQry);
		
		// Membaca tahun
		$thnKecil = $thnRow['tahun_kecil'];
		$thnBesar = $thnRow['tahun_besar'];
		
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		for($thn= $thnKecil; $thn <= $thnBesar; $thn++) {
			if ($thn == $dataTahun) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$thn' $cek>$thn</option>";
		}
	  ?>
        </select>
          <input name="btnTampil" type="submit" value=" Tampilkan " />
          <input name="btnCetak" type="submit" id="btnCetak" value=" Cetak " /></td>
    </tr>
  </table>
</form>

<br />
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  
  <tr>
    <td width="26" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="70" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>No. Pengadaan</strong></td>
    <td width="65" bgcolor="#CCCCCC"><strong>Kode </strong></td>
    <td width="350" bgcolor="#CCCCCC"><b>Nama Barang</b></td>
    <td width="100" align="right" bgcolor="#CCCCCC"><b> Hrg. Beli (Rp)</b></td>
    <td width="48" align="right" bgcolor="#CCCCCC"><b>Jumlah</b></td>
    <td width="100" align="right" bgcolor="#CCCCCC"><strong> Tot. Harga(Rp)</strong></td>
  </tr>
  <?php
  	// deklarasi variabel
	$subTotal 		= 0; 
	$totalHarga 	= 0; 
	$totalBarang 	= 0;  
	
	//  Perintah SQL menampilkan data barang daftar pengadaan
	$mySql ="SELECT pengadaan_item.*, pengadaan.tgl_pengadaan, barang.nm_barang 
			 FROM pengadaan, pengadaan_item
			 	LEFT JOIN barang ON pengadaan_item.kd_barang=barang.kd_barang 
			 WHERE pengadaan.no_pengadaan=pengadaan_item.no_pengadaan 
			 $filterSQL
			 ORDER BY pengadaan.tgl_pengadaan";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	$nomor  = 0;   
	while($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$subTotal 	= $myData['harga_beli'] * $myData['jumlah'];
		$totalHarga	= $totalHarga + $subTotal;
		$totalBarang= $totalBarang + $myData['jumlah'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pengadaan']); ?></td>
    <td><?php echo $myData['no_pengadaan']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
    <td align="right" bgcolor="<?php echo $warna; ?>"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subTotal); ?></td>
  </tr>
  <?php 
}?>
  <tr>
    <td colspan="6" align="right"><b> GRAND TOTAL : </b></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC">Rp. <strong><?php echo format_angka($totalHarga); ?></strong></td>
  </tr>
</table>
<a href="cetak/pengadaan_barang_supplier.php?kodeSupplier=<?php echo $kodeSupplier; ?>&tahun=<?php echo $dataTahun; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
