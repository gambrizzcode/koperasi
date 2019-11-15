<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Koperasi | Login</title>  
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="icon" href="images/favicon.png">
	<link rel="stylesheet" href="mybootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="AdminLTE/css/font-awesome.min.css">
	<link rel="stylesheet" href="AdminLTE/css/AdminLTE.min.css">
</head>
<body style="background-color: rgba(0,200,50,0.2);" class="layout-top-nav">
<div class="wrapper">
<div class="content-wrapper">
	<div class="container">
		<section class="content">
			<div class="row">
				<div class="col-md-6" id="kiri">
					<center><h2><i class="fa fa-balance-scale"></i> <b style="color: darkblue">Koperasi Mini </b>| SMA 0 Jember</h2></center>
					<hr style="border: darkblue 2px solid;border-radius: 100px"><br><br>
					<b style="font-size: 18px">SILAHKAN LOGIN TERLEBIH DAHULU</b><br><br>

                    <input type="text" class="form-control" id="username" placeholder="Username.." style="border-radius: 100px"><br>
                   	<input type="password" class="form-control" id="password" placeholder="Password.." style="border-radius: 100px"><br>

                   	<div id="hasil"></div>
                   	<center><div id="loading"><h1><i class="fa fa-spinner fa-spin"></i></h1></div></center>

                    <button type="button" class="btn btn-primary" id="masuk" style="border-radius: 100px"><i class="fa fa-sign-in"></i> &nbsp;MASUK</button>
                    <button type="button" class="btn btn-default pull-right" id="daftar" onclick="window.location='daftar.php'" style="border-radius: 100px"><i class="fa fa-user"></i> DAFTAR</button>

				</div>
				<div class="col-md-6" id="kanan">
					<img src="images/sampul.jpg" style="max-height: 575px;max-width: 600px;border-radius: 10px">
				</div>
			</div>
		</section>
	</div>
</div>
	<footer class="main-footer">
		<div class="container">
			<div class="pull-right hidden-xs"><b>Versi</b> 1.0.0</div><strong>Copyright &copy; 2017, ANMEDIACORP Jember
		</div>
	</footer>
</div>
<script src="jquery/external/jquery/jquery.js"></script>
<script src="mybootstrap/js/bootstrap.min.js"></script>
<script src="slimScroll/jquery.slimscroll.min.js"></script>
<script src="AdminLTE/js/app.min.js"></script>
<script>
$(document).ready(function(){
	$("input[id='username']").focus();
	$('#loading').hide();
	$('#masuk').click(function() {
		var data = {
			username : $("#username").val(),
			password : $("#password").val()
		};
		$('#loading').fadeIn(500);
		$.ajax({
			url: 'login_do.php',
			type: 'GET',
			data: data,
			success:function(data){
				$('#hasil').html(data);
				if ($('#uhu').text() == "Berhasil Login !! ") {
					window.location="dashboard.php";
				}else{
					$('#loading').fadeOut(500);
				}
			}
		});
	});
});
</script>
</body>
</html>
