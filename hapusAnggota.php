<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$krj->hapusAnggota($_REQUEST['nia']);
header("location:anggota.php");