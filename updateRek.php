<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$krj->updateRek($_GET['kodelama'],$_GET['newnama'],$_GET['newkode']);