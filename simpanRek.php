<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$krj->simpanRek($_GET['kode'],$_GET['nama']);