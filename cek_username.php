<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$cek = mysql_num_rows(mysql_query("SELECT * FROM user WHERE username = '$_GET[user]'"));

if ($cek == 0 || $cek == "0") {
	echo "<b style='color:green'>Username dapat digunakan</b>";
}else{
	echo "<b style='color:red'>Username telah dipakai. Cari yang lain.</b>";
}