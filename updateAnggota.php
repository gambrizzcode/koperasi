<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$data = mysql_query("SELECT * FROM user WHERE nia = '$_POST[newnia]'");
$isi  = mysql_fetch_array($data);

if ($isi['password'] == md5($_POST['newpassword'])) {
	$password = $isi['password'];
}else{
	$password = md5($_POST['newpassword']);
}

$krj->updateAnggota($_POST['newnia'],$_POST['newnama'],$_POST['newalamat'],$_POST['newhp'],$_POST['newusername'],$password,$_POST['newlevel'],$_POST['newstatus']);
header("location:anggota.php");