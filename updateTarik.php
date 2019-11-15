<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$krj->updateTarik($_POST['id_tarik'],$_POST['tnia'],$_POST['ttanggal'],$_POST['tkode'],$_POST['tnominal'],$_POST['tket'],$_POST['tptg']);
header("location:transaksi.php");