<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$krj->simpanSimpan($_POST['id_simpan'],$_POST['nia'],$_POST['tanggal'],$_POST['kode'],$_POST['nominal'],$_POST['ket'],$_POST['ptg']);
header("location:printSimpan.php?id_simpan=".$_POST['id_simpan']);