<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$krj->simpanTarik($_POST['id_tarik'],$_POST['tnia'],$_POST['ttanggal'],$_POST['tkode'],$_POST['tnominal'],$_POST['tket'],$_POST['tptg']);
header("location:printTarik.php?id_tarik=".$_POST['id_tarik']);