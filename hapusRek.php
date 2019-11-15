<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$krj->hapusRek($_REQUEST['kode']);
header("location:rekening.php");