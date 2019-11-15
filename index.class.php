<?php
session_start();
ob_start();

ini_set("display_errors","off");

date_default_timezone_set('Asia/Jakarta');

/************************

|						|
|  By : Syaikhu Rizal	|
|						|	
|  ANMEDIACORP JEMBER	|
|						|

************************/

class sambung{
	private $host = "localhost";
	private $user = "root";
	private $pass = "";
	private $db   = "koperasi";
	function __construct(){
		mysql_connect($this->host,$this->user,$this->pass);
		mysql_select_db($this->db);
	}
}

class kerja{
	function hapusAnggota($a){
		mysql_query("DELETE FROM user WHERE nia = '$a'");
	}
	function verifikasi($a){
		mysql_query("UPDATE user SET status = '1' WHERE nia = '$a'");
	}
	function updateAnggota($a,$b,$c,$d,$e,$f,$g,$h){
		mysql_query("UPDATE user SET nama = '$b', alamat = '$c', hp = '$d', username = '$e', password = '$f', level = '$g', status = '$h' WHERE nia = '$a'");
	}
	function updateBio($a,$b,$c){
		mysql_query("UPDATE user SET username = '$b', password = '$c' WHERE nia = '$a'");
	}
	function updateData($a,$b,$c,$d){
		mysql_query("UPDATE user SET nama = '$b', alamat = '$c', hp = '$d' WHERE nia = '$a'");
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function simpanRek($a,$b){
		mysql_query("INSERT INTO rekening VALUES('$a','$b','')");
	}
	function hapusRek($a){
		mysql_query("DELETE FROM rekening WHERE kode = '$a'");
	}
	function updateRek($a,$b,$c){
		mysql_query("UPDATE rekening SET nama = '$b', kode = '$c' WHERE kode = '$a'");
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function simpanSimpan($a,$b,$c,$d,$e,$f,$g){
		mysql_query("INSERT INTO simpan VALUES('$a','$b','$c','$d','$e','$f','$g')");
	}
	function hapusSimpan($a){
		mysql_query("DELETE FROM simpan WHERE id_simpan = '$a'");
	}
	function updateSimpan($a,$b,$c,$d,$e,$f,$g){
		mysql_query("UPDATE simpan SET nia = '$b', tanggal = '$c', kode = '$d', nominal = '$e', ket = '$f', ptg = '$g' WHERE id_simpan = '$a'");
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function simpanTarik($a,$b,$c,$d,$e,$f,$g){
		mysql_query("INSERT INTO tarik VALUES('$a','$b','$c','$d','$e','$f','$g')");
	}
	function hapusTarik($a){
		mysql_query("DELETE FROM tarik WHERE id_tarik = '$a'");
	}
	function updateTarik($a,$b,$c,$d,$e,$f,$g){
		mysql_query("UPDATE tarik SET nia = '$b', tanggal = '$c', kode = '$d', nominal = '$e', ket = '$f', ptg = '$g' WHERE id_tarik = '$a'");
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function totalSimpanan(){
		$qsimpan2 = mysql_query("SELECT SUM(nominal) FROM simpan");
		$rsimpan2 = mysql_fetch_array($qsimpan2);
		// echo number_format($rsimpan2[0],0,",",".");
		// return number_format($rsimpan2[0],0,",",".");
		return $rsimpan2[0];
	}
	function totalTarikan(){
		$qtarik2 = mysql_query("SELECT SUM(nominal) FROM tarik");
		$rtarik2 = mysql_fetch_array($qtarik2);
		// echo number_format($rtarik2[0],0,",",".");
		// return number_format($rtarik2[0],0,",",".");
		return $rtarik2[0];
	}
	function totalAnggota(){
		$qanggota = mysql_num_rows(mysql_query("SELECT * FROM user"));
		echo $qanggota;
		return $qanggota;
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}