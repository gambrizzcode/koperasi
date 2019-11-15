<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$data = mysql_query("SELECT * FROM user WHERE nia = '$_POST[nia]'");
$isi  = mysql_fetch_array($data);

if ($isi['password'] == md5($_POST['password'])) {
	$password = $isi['password'];
}elseif($isi['password'] == $_POST['password']){
	$password = $isi['password'];
}else{
	$password = md5($_POST['password']);
}

$krj->updateBio($_POST['nia'],$_POST['username'],$password);
header("location:biodata.php");