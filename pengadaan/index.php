<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_pengadaan'] == "Yes") {

date_default_timezone_set("Asia/Jakarta");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TRANSAKSI PENGADAAN - Inventory Kantor ( Aset Barang )</title>
<link href="../styles/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../plugins/tigra_calendar/tcal.css" />
<script type="text/javascript" src="../plugins/tigra_calendar/tcal.js"></script> 
<script type="text/javascript" src="../plugins/js.popupWindow.js"></script>
</head>
<body>
<table width="100%" class="table-common" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#F5F5F5"><img src="../images/logo.png" border="0" ></td>
  </tr>
  <tr>
    <td bgcolor="#F5F5F5"><a href="?open=Pengadaan-Baru" target="_self"><b>Pengadaan  Baru</b></a> | 
	 <a href="?open=Pengadaan-Tampil" target="_self"><b>Data Pengadaan </b></a> </td>
  </tr>
</table>

<?php 
# KONTROL MENU PROGRAM
if(isset($_GET['open'])) {
	// Jika mendapatkan variabel URL ?page
	switch($_GET['open']){				
		case 'Pengadaan-Baru' :
			if(!file_exists ("pengadaan_baru.php")) die ("File tidak ditemukan!"); 
			include "pengadaan_baru.php";	break;
		case 'Pengadaan-Tampil' : 
			if(!file_exists ("pengadaan_tampil.php")) die ("File tidak ditemukan!"); 
			include "pengadaan_tampil.php";	break;
		case 'Pengadaan-Hapus' : 
			if(!file_exists ("pengadaan_hapus.php")) die ("File tidak ditemukan!"); 
			include "pengadaan_hapus.php";	break;
	}
}
else {
	include "pengadaan_baru.php";
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
