<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$krj->hapusSimpan($_REQUEST['id_simpan']);
header("location:transaksi.php");