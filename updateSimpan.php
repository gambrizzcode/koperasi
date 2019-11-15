<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$krj->updateSimpan($_POST['id_simpan'],$_POST['nia'],$_POST['tanggal'],$_POST['kode'],$_POST['nominal'],$_POST['ket'],$_POST['ptg']);
header("location:transaksi.php");