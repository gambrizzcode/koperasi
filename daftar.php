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
	<title>Koperasi | Daftar</title>  
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
			<center><h2><i class="fa fa-balance-scale"></i> <b style="color: darkblue">Koperasi Mini </b>| SMA 0 Jember</h2></center>
			<hr style="border: darkblue 2px solid;border-radius: 100px">
			<div class="row">
				<div class="col-md-12" id="kiri">
					
					<center><b style="font-size: 16px">Daftarkan Dirimu dan Mulai Menabung Sekarang Juga..</b></center><br>

					<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<input type="hidden" id="nia" value="<?php echo time(); ?>"><br>
							<input type="text" class="form-control" id="nama" placeholder="Nama.." style="border-radius: 100px"><br>
							<input type="text" class="form-control" id="alamat" placeholder="Alamat.." style="border-radius: 100px"><br>
							<input type="text" class="form-control" id="hp" placeholder="Nomor Handphone.." style="border-radius: 100px"><br>
							<input type="text" class="form-control" id="username" placeholder="Username.." style="border-radius: 100px">
							<div id="mila1"></div><br>
                   			<input type="password" class="form-control" id="password" placeholder="Password.." style="border-radius: 100px">
                   			<div id="mila2"></div><br>
                   			<input type="password" class="form-control" id="konpass" placeholder="Confirm Password.." style="border-radius: 100px">
                   			<b><div id="mila3"></div></b><br>
                   			<input type="hidden" id="level" value="INVESTOR">
                   			<input type="hidden" id="status" value="0">

                   			<div class="modal fade" id="popup" role="dialog">
                   				<div class="modal-dialog">
                   					<div class="modal-content">
                   						<div class="modal-header">
                   							<button type="button" class="close" data-dismiss="modal">&times;</button>
                   							<center><h3>Sudah Yakin ?</h3></center>
                   						</div>
                   						<div class="modal-body">
                   						<center>
                   						<div id="tbl">
                   							<button type="button" class="btn btn-success btn-lg" id="masuk" style="border-radius: 100px"><i class="fa fa-sign-in"></i> &nbsp;DAFTAR</button>
                   							<button type="button" class="btn btn-danger btn-lg" style="border-radius: 100px;margin-left: 25px" data-dismiss="modal"><i class="fa fa-close"></i> &nbsp;TIDAK</button><hr>
                   						</div>
                   						<div id="loading"><h1><i class="fa fa-spinner fa-spin"></i></h1></div>
                   						<div id="hasil"></div><br>

                   						</center>
                   						</div>
                   					</div>
                   				</div>
                   			</div>
                   			<div id="tbl">
                   			<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#popup" style="border-radius: 100px"><i class="fa fa-sign-in"></i> &nbsp;DAFTAR</button>
                   			</div>
                   			<br>
                   			Sudah Punya Akun ? <a href="index.php">Login Disini</a>
						</div>
					</div>
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
	$('#loading').hide();

	$("input[id='nama']").focus();
	$("input[id='nama']").keyup(function() {
		var nama = $(this).val().length;
		if (nama < 5) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
		}
	});
	$("input[id='nama']").keydown(function() {
		var nama = $(this).val().length;
		if (nama < 5) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
		}
	});
	$("input[id='nama']").focusout(function() {
		var nama = $(this).val().length;
		if (nama < 5) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
		}
	});

	$("input[id='alamat']").keyup(function() {
		var alamat = $(this).val().length;
		if (alamat < 5) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
		}
	});
	$("input[id='alamat']").keydown(function() {
		var alamat = $(this).val().length;
		if (alamat < 5) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
		}
	});
	$("input[id='alamat']").focusout(function() {
		var alamat = $(this).val().length;
		if (alamat < 5) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
		}
	});

	$("input[id='hp']").keyup(function() {
		var hp = $(this).val().length;
		if (hp < 9) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
		}
	});
	$("input[id='hp']").keydown(function() {
		var hp = $(this).val().length;
		if (hp < 9) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
		}
	});
	$("input[id='hp']").focusout(function() {
		var hp = $(this).val().length;
		if (hp < 9) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
		}
	});

	$("input[id='username']").keyup(function() {
		var username = $(this).val().length;
		if (username < 5) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
			var user = $(this).val();
            $.ajax({
            	url: 'cek_username.php',
            	type: 'GET',
            	data: "user="+user,
            	success:function(cek1){
            		$('#mila1').html(cek1);
            	}
            });
		}
	});
	$("input[id='username']").keydown(function() {
		var username = $(this).val().length;
		if (username < 5) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
			var user = $(this).val();
            $.ajax({
            	url: 'cek_username.php',
            	type: 'GET',
            	data: "user="+user,
            	success:function(cek1){
            		$('#mila1').html(cek1);
            	}
            });
		}
	});
	$("input[id='username']").focusout(function() {
		var username = $(this).val().length;
		if (username < 5) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
			var user = $(this).val();
            $.ajax({
            	url: 'cek_username.php',
            	type: 'GET',
            	data: "user="+user,
            	success:function(cek1){
            		$('#mila1').html(cek1);
            	}
            });
		}
	});

	$("input[id='password']").keyup(function() {
		var password = $(this).val().length;
		if (password < 8) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
		}
	});
	$("input[id='password']").keydown(function() {
		var password = $(this).val().length;
		if (password < 8) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
		}
	});
	$("input[id='password']").focusout(function() {
		var password = $(this).val().length;
		if (password < 8) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
		}
	});

	$("input[id='konpass']").keyup(function() {
		var konpass = $(this).val();
		var password = $('#password').val();
		if (konpass != password) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
            $('#mila3').html("Password Tidak Cocok");
            $('#mila3').css('color', 'red');
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
			$('#mila3').html("Password Cocok");
            $('#mila3').css('color', 'green');
		}
	});
	$("input[id='konpass']").keydown(function() {
		var konpass = $(this).val();
		var password = $('#password').val();
		if (konpass != password) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
            $('#mila3').html("Password Tidak Cocok");
            $('#mila3').css('color', 'red');
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
			$('#mila3').html("Password Cocok");
            $('#mila3').css('color', 'green');
		}
	});
	$("input[id='konpass']").focusout(function() {
		var konpass = $(this).val();
		var password = $('#password').val();
		if (konpass != password) {
			$(this).css('box-shadow', 'red 0px 0px 10px');
            $(this).focus();
            $('#mila3').html("Password Tidak Cocok");
            $('#mila3').css('color', 'red');
		}else{
			$(this).css('box-shadow', 'blue 0px 0px 2px');
			$('#mila3').html("Password Cocok");
            $('#mila3').css('color', 'green');
		}
	});

	$('#masuk').click(function() {
		var data = {
			nia 	 : $('#nia').val(),
			nama 	 : $('#nama').val(),
			alamat 	 : $('#alamat').val(),
			hp 		 : $('#hp').val(),
			username : $("#username").val(),
			password : $("#password").val(),
			level 	 : $('#level').val(),
			status 	 : $('#status').val()
		};
		$('#loading').fadeIn(500);
		$.ajax({
			url: 'daftar_do.php',
			type: 'GET',
			data: data,
			success:function(data){
				$('#hasil').html(data);
				$('#loading').fadeOut(500);
				var hsl = $('#hsl').val();
				if (hsl == "1" || hsl == 1) {
					$('#tbl').hide();
				}else{
					$('#tbl').show();
				}
			}
		});
	});
});
</script>
</body>
</html>
