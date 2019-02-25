<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.hakakses.php";

# Hak akses (Yes = diijinkan, No = dilarang)
if($aksesData['mu_trans_pemeliharaan'] == "Yes") {

date_default_timezone_set("Asia/Jakarta");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TRANSAKSI PEMELIHARAAN </title>
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
    <td bgcolor="#F5F5F5"><a href="?open=Pemeliharaan-Baru" target="_self"><b>Pemeliharaan Baru</b></a> | 
	 <a href="?open=Pemeliharaan-Tampil" target="_self"><b>Data Pemeliharaan</b></a> </td>
  </tr>
</table>

<?php 
# KONTROL MENU PROGRAM
if(isset($_GET['open'])) {
	// Jika mendapatkan variabel URL ?open
	switch($_GET['open']){				
		case 'Pemeliharaan-Baru' :
			if(!file_exists ("pemeliharaan_baru_1.php")) die ("File tidak ditemukan !"); 
			include "pemeliharaan_baru_1.php";	break;
		case 'Pemeliharaan-Baru-2' :
			if(!file_exists ("pemeliharaan_baru_2.php")) die ("File tidak ditemukan !"); 
			include "pemeliharaan_baru_2.php";	break;
		case 'Pengembalian' :
			if(!file_exists ("pengembalian.php")) die ("File tidak ditemukan !"); 
			include "pengembalian.php";	break;
		case 'Pemeliharaan-Tampil' : 
			if(!file_exists ("pemeliharaan_tampil.php")) die ("File tidak ditemukan !"); 
			include "pemeliharaan_tampil.php";	break;
		case 'Pemeliharaan-Hapus' : 
			if(!file_exists ("pemeliharaan_hapus.php")) die ("File tidak ditemukan !"); 
			include "pemeliharaan_hapus.php";	break;
	}
}
else {
	include "pemeliharaan_baru_1.php";
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
