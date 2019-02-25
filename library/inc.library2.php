<?php
# Pengaturan tanggal komputer
date_default_timezone_set("Asia/Jakarta");

# Fungsi untuk membuat kode automatis
function buatKode($tabel, $inisial){
	$struktur	= mysql_query("SELECT * FROM $tabel");
	$field		= mysql_field_name($struktur,0);
	
	# MEMBACA PANJANG KOLOM KUNCI (PRIMARY) - CARA 1
	//$panjang	= mysql_field_len($struktur,0);
	
	# MEMBACA PANJANG KOLOM KUNCI (PRIMARY) - CARA 2 
	$hasil 	= mysql_fetch_field($struktur,0);
	$panjang= $hasil->max_length;  
	if(mysql_num_rows($struktur) <=0) {
		// Panjang kolom kunci setiap tabel (kolom Kode)
		if($tabel == "barang") { $panjang = 5;  }
		else if($tabel == "departemen") { $panjang = 4;  }
		else if($tabel == "kategori") { $panjang = 4;  }
		else if($tabel == "lokasi") { $panjang = 5;  }
		else if($tabel == "mutasi") { $panjang = 7;  }
		else if($tabel == "pegawai") { $panjang = 5;  }
		else if($tabel == "peminjaman") { $panjang = 7;  }
		else if($tabel == "penempatan") { $panjang = 7;  }
		else if($tabel == "pengadaan") { $panjang = 7;  }
		else if($tabel == "pengembalian") { $panjang = 7;  }
		else if($tabel == "petugas") { $panjang = 4;  }
		else if($tabel == "supplier") { $panjang = 4;  }
		else if($tabel == "pemeliharaan") { $panjang = 7;  }
		else if($tabel == "pemeliharaan") { $panjang = 7;  }
		else { }
	}
	else {
		$panjang= $hasil->max_length; 
	}  
	
	
 	$qry	= mysql_query("SELECT MAX(".$field.") FROM ".$tabel);
 	$row	= mysql_fetch_array($qry); 
 	if ($row[0]=="") {
 		$angka=0;
	}
 	else {
 		$angka		= substr($row[0], strlen($inisial));
 	}
	
 	$angka++;
 	$angka	=strval($angka); 
 	$tmp	="";
 	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";	
	}
	
 	return $inisial.$tmp.$panjang;
}

# Fungsi untuk membuat kode automatis
function buatKodeLama($tabel, $inisial){
	$struktur	= mysql_query("SELECT * FROM $tabel");
	$field		= mysql_field_name($struktur,0);
	
	# MEMBACA PANJANG KOLOM KUNCI (PRIMARY) - CARA 1
	//$panjang	= mysql_field_len($struktur,0);
	
	# MEMBACA PANJANG KOLOM KUNCI (PRIMARY) - CARA 2 
	$hasil 	= mysql_fetch_field($struktur,0);
	$panjang	= $hasil->max_length; 

 	$qry	= mysql_query("SELECT MAX(".$field.") FROM ".$tabel);
 	$row	= mysql_fetch_array($qry); 
 	if ($row[0]=="") {
 		$angka=0;
	}
 	else {
 		$angka		= substr($row[0], strlen($inisial));
 	}
	
 	$angka++;
 	$angka	=strval($angka); 
 	$tmp	="";
 	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";	
	}
	
 	return $inisial.$tmp.$angka;
}

# Fungsi untuk membuat kode Koleksi Inventaris Barang 
// Kodenya urut berdasarkan Kode Barang, berganti barang urutan mulai 001 lagi 
// (B0001.001, B0001.002, B0001.003, B0001.004) (B0002.001, B0002.002, B0002.003, B0002.004)
function buatKodeKoleksi($tabel, $inisial, $filter){
	$struktur	= mysql_query("SELECT * FROM $tabel");
	$field		= mysql_field_name($struktur,0);

	# MEMBACA PANJANG KOLOM KUNCI (PRIMARY) - CARA 1
	//$panjang	= mysql_field_len($struktur,0);
	
	# MEMBACA PANJANG KOLOM KUNCI (PRIMARY) - CARA 2 
	$hasil 	= mysql_fetch_field($struktur,0);
	$panjang= $hasil->max_length; 
	if(mysql_num_rows($struktur) <=0) {
		 $panjang = 12; // panjang kolom Kode Inventaris
	}
	else {
		$panjang= $hasil->max_length; 
	}
	
 	$qry	= mysql_query("SELECT MAX(".$field.") FROM ".$tabel." WHERE kd_barang='$filter'");
 	$row	= mysql_fetch_array($qry); 
 	if ($row[0]=="") {
 		$angka=0;
	}
 	else {
 		$angka		= substr($row[0], strlen($inisial));
 	}
	
	
 	$angka++;
 	$angka	=strval($angka); 
 	$tmp	="";
 	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";	
	}
 	return $inisial.$tmp.$angka;
}

# Fungsi untuk membuat kode Koleksi Inventaris Barang 
// Kodenya urut terus, biarpun Kode Nama Baranngya berganti 
// Contoh (B0001.00001, B0001.00002, B0001.00003) ( B0002.00004, B0002.00005 )  (B0003.00006, B0003.00007, B0003.00008) ( B0004.00009,...)
function buatKodeKoleksi2($tabel, $kodeDepan){
	$struktur	= mysql_query("SELECT * FROM $tabel");
	$field		= mysql_field_name($struktur,0);
	
	# MEMBACA PANJANG KOLOM KUNCI (PRIMARY) - CARA 1
	//$panjang	= mysql_field_len($struktur,0);
	
	# MEMBACA PANJANG KOLOM KUNCI (PRIMARY) - CARA 2 
	$hasil 	= mysql_fetch_field($struktur,0);
	$panjang= $hasil->max_length; 
	if(mysql_num_rows($struktur) <=0) {
		 $panjang = 12; // panjang kolom Kode Inventaris
	}
	else {
		$panjang= $hasil->max_length; 
	}


 	$qry	= mysql_query("SELECT MAX(RIGHT(".$field.",6)) AS angka FROM ".$tabel."");
 	$row	= mysql_fetch_array($qry); 
 	if ($row['angka']=="") {
 		$angka=0;
	}
 	else {
 		$angka		= $row['angka'];
 	}
	
 	$angka++;
 	$angka	= strval($angka); 
 	$tmp	="";
 	for($i=1; $i<=($panjang-strlen($kodeDepan)-strlen($angka)); $i++) {
		$tmp=$tmp."0";	
	}
 	return $kodeDepan.$tmp.$angka;
}

# Fungsi untuk membalik tanggal dari format Indo (d-m-Y) -> English (Y-m-d)
function InggrisTgl($tanggal){
	$tgl=substr($tanggal,0,2);
	$bln=substr($tanggal,3,2);
	$thn=substr($tanggal,6,4);
	$tanggal="$thn-$bln-$tgl";
	return $tanggal;
}

# Fungsi untuk membalik tanggal dari format English (Y-m-d) -> Indo (d-m-Y)
function IndonesiaTgl($tanggal){
	$tgl=substr($tanggal,8,2);
	$bln=substr($tanggal,5,2);
	$thn=substr($tanggal,0,4);
	$tanggal="$tgl-$bln-$thn";
	return $tanggal;
}

# Fungsi untuk membalik tanggal dari format English (Y-m-d) -> Indo (d-m-Y)
function Indonesia2Tgl($tanggal){
	$namaBln = array("01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei", "06" => "Juni", 
					 "07" => "Juli", "08" => "Agustus", "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember");
					 
	$tgl=substr($tanggal,8,2);
	$bln=substr($tanggal,5,2);
	$thn=substr($tanggal,0,4);
	$tanggal ="$tgl ".$namaBln[$bln]." $thn";
	return $tanggal;
}

function hitungHari($myDate1, $myDate2){
        $myDate1 = strtotime($myDate1);
        $myDate2 = strtotime($myDate2);
 
        return ($myDate2 - $myDate1)/ (24 *3600);
}

# Fungsi untuk membuat format rupiah pada angka (uang)
function format_angka($angka) {
	$hasil =  number_format($angka,0, ",",".");
	return $hasil;
}

# Fungsi untuk format tanggal, dipakai plugins Callendar
function form_tanggal($nama,$value=''){
	echo" <input type='text' name='$nama' id='$nama' size='11' maxlength='20' value='$value'/>&nbsp;
	<img src='images/calendar-add-icon.png' align='top' style='cursor:pointer; margin-top:7px;' alt='kalender'onclick=\"displayCalendar(document.getElementById('$nama'),'dd-mm-yyyy',this)\"/>			
	";
}

function angkaTerbilang($x){
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return angkaTerbilang($x - 10) . " belas";
  elseif ($x < 100)
    return angkaTerbilang($x / 10) . " puluh" . angkaTerbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . angkaTerbilang($x - 100);
  elseif ($x < 1000)
    return angkaTerbilang($x / 100) . " ratus" . angkaTerbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . angkaTerbilang($x - 1000);
  elseif ($x < 1000000)
    return angkaTerbilang($x / 1000) . " ribu" . angkaTerbilang($x % 1000);
  elseif ($x < 1000000000)
    return angkaTerbilang($x / 1000000) . " juta" . angkaTerbilang($x % 1000000);
}
?>