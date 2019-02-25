<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_penempatan'] == "Yes") {

date_default_timezone_set("Asia/Jakarta");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TRANSAKSI PENEMPATAN - Inventory Kantor ( Aset Barang )</title>
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
    <td bgcolor="#F5F5F5"><a href="?open=Penempatan-Baru" target="_self"><b>Penempatan  Baru</b></a> | 
	 <a href="?open=Penempatan-Tampil" target="_self"><b>Data Penempatan </b></a> </td>
  </tr>
</table>

<?php 
# KONTROL MENU PROGRAM
if(isset($_GET['open'])) {
	// Jika mendapatkan variabel URL ?open
	switch($_GET['open']){				
		case 'Penempatan-Baru' :
			if(!file_exists ("penempatan_baru.php")) die ("File tidak ada !"); 
			include "penempatan_baru.php";	break;
		case 'Penempatan-Tampil' : 
			if(!file_exists ("penempatan_tampil.php")) die ("File tidak ada !"); 
			include "penempatan_tampil.php";	break;
		case 'Penempatan-Hapus' : 
			if(!file_exists ("penempatan_hapus.php")) die ("File tidak ada !"); 
			include "penempatan_hapus.php";	break;
	}
}
else {
	include "penempatan_baru.php";
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

