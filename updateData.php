<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$krj->updateData($_POST['nia'],$_POST['nama'],$_POST['alamat'],$_POST['hp']);
header("location:biodata.php");