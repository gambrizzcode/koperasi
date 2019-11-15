<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$krj->verifikasi($_REQUEST['nia']);
header("location:anggota.php");