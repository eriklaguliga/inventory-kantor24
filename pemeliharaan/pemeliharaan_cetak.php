<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_pemeliharaan'] == "Yes") {

// Membaca User yang Login
$userLogin	= $_SESSION['SES_LOGIN'];

# ==============================================================
# TAMPILKAN DATA UNTUK DIEDIT
// Skrip menampilkan daftar Inventaris Aset Barang per Barang
$Kode	 = $_GET['Kode']; 
$mySql = "SELECT pemeliharaan.*, barang_inventaris.*, barang.nm_barang FROM pemeliharaan 
			LEFT JOIN barang_inventaris ON pemeliharaan.kd_inventaris = barang_inventaris.kd_inventaris
			LEFT JOIN barang ON barang_inventaris.kd_barang = barang.kd_barang
			WHERE pemeliharaan.no_pemeliharaan='$Kode'";   
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query ambil data 1 salah : ".mysql_error());
$myData= mysql_fetch_array($myQry);
?>
<html>
<head>
<title>::  Cetak Pemeliharaan </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmedit">
<table class="table-list" width="100%" style="margin-top:0px;">
	
	<tr>
	  <td width="17%" bgcolor="#CCCCCC"><strong>DATA ASET </strong></td>
	  <td width="1%">&nbsp;</td>
	  <td width="82%">&nbsp;</td>
    </tr>
	<tr>
	  <td><strong>Kode</strong></td>
	  <td><strong>:</strong></td>
	  <td> <?php echo $myData['kd_barang']; ?></td>
    </tr>
	<tr>
	  <td><strong>Nama Barang </strong></td>
	  <td><strong>:</strong></td>
	  <td> <?php echo $myData['nm_barang']; ?> </td>
    </tr>
	<tr>
	  <td><strong>Kode ID </strong></td>
	  <td><strong>:</strong></td>
	  <td><?php echo $myData['kd_inventaris']; ?></td>
    </tr>
	<tr>
	  <td><strong>Nomor Seri </strong></td>
	  <td><strong>:</strong></td>
	  <td><?php echo $myData['nomor_seri']; ?></td>
    </tr>
	<tr>
	  <td><strong>Tahun Datang </strong></td>
	  <td><strong>:</strong></td>
	  <td><?php echo $myData['tahun_datang']; ?></td>
    </tr>
	<tr>
	  <td><strong>Tahun Digunakan </strong></td>
	  <td><strong>:</strong></td>
	  <td><?php echo $myData['tahun_digunakan']; ?></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td bgcolor="#CCCCCC"><strong>PEMELIHARAAN</strong></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td><strong>No. Pemeliharaan </strong></td>
      <td><strong>:</strong></td>
	  <td><?php echo $myData['no_pemeliharaan']; ?></td>
    </tr>
	<tr>
	  <td><strong>Tgl. Pemeliharaan </strong></td>
      <td><strong>:</strong></td>
	  <td><?php echo IndonesiaTgl($myData['tgl_pemeliharaan']); ?></td>
    </tr>
	<tr>
      <td><b>Biaya Pemeliharaan(Rp) </b></td>
	  <td><strong>:</strong></td>
	  <td><?php echo format_angka($myData['biaya']); ?></td>
    </tr>
	<tr>
      <td><b>Keterangan</b></td>
	  <td><strong>:</strong></td>
	  <td><?php echo $myData['keterangan']; ?></td>
    </tr>
</table>
</form>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>

<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
