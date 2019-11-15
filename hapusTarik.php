<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$krj->hapusTarik($_REQUEST['id_tarik']);
header("location:transaksi.php");