<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

if ($_GET['nama'] == "" || $_GET['alamat'] == "" || $_GET['hp'] == "" || $_GET['username'] == "" || $_GET['password'] == "") { ?>
	<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<h3>Gagal !</h3>
		<h4>Data tidak lengkap ! Dilengkapi dulu ya formulir pendaftarannya.</h4>
		<input type="hidden" value="0" id="hsl">
	</div>
<?php
}else{
	$pass = md5($_GET["password"]);
	mysql_query("INSERT INTO user VALUES('$_GET[nia]','$_GET[nama]','$_GET[alamat]','$_GET[hp]','$_GET[username]','$pass','$_GET[level]','$_GET[status]','')"); ?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<h3>Berhasil !</h3>
		<h4>Pendaftaran berhasil. Anda belum bisa menggunakan akun ini sebelum diverifikasi untuk memastikan data anda. Anda akan kami hubungi setelah kami verifikasi. Terima kasih.</h4>
		<input type="hidden" value="1" id="hsl">
	</div>
<?php
}
?>