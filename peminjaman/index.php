<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_peminjaman'] == "Yes") {

date_default_timezone_set("Asia/Jakarta");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TRANSAKSI PEMINJAMAN - Inventory Kantor ( Aset Barang )</title>
<link href="../styles/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../plugins/tigra_calendar/tcal.css" />
<script type="text/javascript" src="../plugins/tigra_calendar/tcal.js"></script> 
<script type="text/javascript" src="../plugins/js.popupWindow.js"></script>
</head>
<body>
<table width="100%" class="table-common" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#F5F5F5"><img src="../images/logo.png"></td>
  </tr>
  <tr>
    <td bgcolor="#F5F5F5"><a href="?open=Peminjaman-Baru" target="_self"><b>Peminjaman Baru</b></a> | 
	 <a href="?open=Peminjaman-Tampil" target="_self"><b>Data Peminjaman</b></a> </td>
  </tr>
</table>

<?php 
# KONTROL MENU PROGRAM
if(isset($_GET['open'])) {
	// Jika mendapatkan variabel URL ?open
	switch($_GET['open']){				
		case 'Peminjaman-Baru' :
			if(!file_exists ("peminjaman_baru.php")) die ("File tidak ditemukan !"); 
			include "peminjaman_baru.php";	break;
		case 'Pengembalian' :
			if(!file_exists ("pengembalian.php")) die ("File tidak ditemukan !"); 
			include "pengembalian.php";	break;
		case 'Peminjaman-Tampil' : 
			if(!file_exists ("peminjaman_tampil.php")) die ("File tidak ditemukan !"); 
			include "peminjaman_tampil.php";	break;
		case 'Peminjaman-Hapus' : 
			if(!file_exists ("peminjaman_hapus.php")) die ("File tidak ditemukan !"); 
			include "peminjaman_hapus.php";	break;
	}
}
else {
	include "peminjaman_baru.php";
}
 ?>
</body>
</html>
<?php
# Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
