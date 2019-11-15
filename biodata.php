<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

if (!$_SESSION['nia'] || $_SESSION['nia'] == "") {
	header("location:index.php");
}else{
	$data = mysql_query("SELECT * FROM user WHERE nia = '$_SESSION[nia]'");
	$isi  = mysql_fetch_array($data);
	if ($isi['level'] == "ADMIN") {
		header("location:dashboard.php");
	}else{}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Koperasi | Biodata</title>  
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="icon" href="images/favicon.png">
	<link rel="stylesheet" href="mybootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="AdminLTE/css/font-awesome.min.css">
	<link rel="stylesheet" href="AdminLTE/css/AdminLTE.min.css">
	<link rel="stylesheet" href="AdminLTE/css/skins/_all-skins.min.css">
</head>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<header class="main-header">
		<nav class="navbar navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<a href="dashboard.php" class="navbar-brand"><b>Koperasi</b> Siswa</a>
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            			<i class="fa fa-bars"></i>
          			</button>
				</div>

				<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
					<ul class="nav navbar-nav">
						<?php
						if ($isi['level'] == "ADMIN") { ?>
						<li class="active"><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li><a href="transaksi.php"><i class="fa fa-money"></i> Transaksi</a></li>
						<li><a href="anggota.php"><i class="fa fa-users"></i> Anggota</a></li>
						<li><a href="rekening.php"><i class="fa fa-ticket"></i> Rekening</a></li>
						<li><a href="LapRekap.php"><i class="fa fa-files-o"></i> Laporan Rekap</a></li>
						<li><a href="LapDetail.php"><i class="fa fa-file-text"></i> Laporan Detail</a></li>
						<?php
						}else{ ?>
						<li class="active"><a href="biodata.php"><i class="fa fa-user"></i> Biodata</a></li>
						<li><a href="LapSendiri.php"><i class="fa fa-book"></i> Data Simpanan</a></li>
						<?php } ?>
					</ul>
				</div>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav"><li><a href="logout.php"><b><?php echo $isi['nama']; ?></b> | Logout <i class="fa fa-sign-out"></i></a></li></ul>
				</div>
			</div>
		</nav>
	</header>

	<div class="content-wrapper">
		<div class="container">
			<section class="content-header">
				<h2><i class="fa fa-user"></i> Biodata</h2>
			</section>
			<section class="content">
				<div class="row">
				<div class="col-md-12">
				<div class="box box-primary">
				<div class="box-header">
					<h3>
						Nomor Induk Anggota (NIA) : <b><?php echo $isi[0]; ?></b>
					</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
						<div class="well" align="center" style="min-height: 250px">
							<table style="font-size: 16px">
								<tr>
									<td align="right">Nama :&nbsp;</td>
									<td><b><?php echo $isi[1]; ?></b></td>
								</tr>
								<tr>
									<td align="right">Alamat :&nbsp;</td>
									<td><b><?php echo $isi[2]; ?></b></td>
								</tr>
								<tr>
									<td align="right">Nomor Hp :&nbsp;</td>
									<td><b><?php echo $isi[3]; ?></b></td>
								</tr>
								<tr>
									<td align="right">Level :&nbsp;</td>
									<td><b><?php echo $isi[6]; ?></b></td>
								</tr>
								<tr>
									<td align="right">Status :&nbsp;</td>
									<td>
										<b><?php if ($isi[7] == "1") { ?>
											Terverifikasi&nbsp;&nbsp;<small class="label bg-green">AKTIF</small>
										<?php }else{ ?>
											Belum diverifikasi&nbsp;&nbsp;<small class="label bg-green">NONAKTIF</small>
										<?php }; ?></b>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<br>
										<button type="button" class="btn btn-flat btn-info btn-block" style="border-radius: 100px" id="btnlagi" data-toggle="modal" data-target="#modalLagi"><i class="fa fa-edit"></i> EDIT</button>

										<div class="modal fade" id="modalLagi" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4>Edit Biodata</h4>
													</div>
													<div class="modal-body">
													<form id="MyForm2" method="post" action="updateData.php">
														<label>Nama</label>
														<input type="hidden" name="nia" value="<?php echo $isi[0]; ?>">
														<input type="text" name="nama" class="form-control" style="border-radius: 100px" placeholder="Nama.." value="<?php echo $isi[1]; ?>"><br>
														<label>Alamat</label>
														<input type="text" name="alamat" class="form-control" style="border-radius: 100px" placeholder="Alamat.." value="<?php echo $isi[2]; ?>"><br>
														<label>Nomor Hp</label>
														<input type="text" name="hp" class="form-control" style="border-radius: 100px" placeholder="Nomor Hp.." value="<?php echo $isi[3]; ?>"><br>
														<button type="submit" class="btn btn-flat btn-primary" style="border-radius: 100px"><i class="fa fa-save"></i> UPDATE</button>&nbsp;&nbsp;&nbsp;&nbsp;
														<button type="button" class="btn btn-flat btn-warning" style="border-radius: 100px" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button>
													</form>
													</div>
												</div>
											</div>
										</div>
									</td>
								</tr>
							</table>
						</div>
						</div>
						<div class="col-md-6">
						<div class="well" align="center" style="min-height: 250px">
							<br><br>
							<table style="font-size: 16px">
								<tr>
									<td align="right">Username :&nbsp;</td>
									<td><b><?php echo $isi[4]; ?></b></td>
								</tr>
								<tr>
									<td align="right">Password :&nbsp;</td>
									<td><b>(********)</b></td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<br>
										<button type="button" class="btn btn-flat btn-info btn-block" style="border-radius: 100px" id="btnmodal" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i> EDIT</button>

										<div class="modal fade" id="modalEdit" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4>Edit Username & Password</h4>
													</div>
													<div class="modal-body">
													<form id="MyForm" method="post" action="updateBio.php">
														<label>Username</label>
														<input type="hidden" name="nia" value="<?php echo $isi[0]; ?>">
														<input type="text" name="username" class="form-control" style="border-radius: 100px" placeholder="Username.." value="<?php echo $isi[4]; ?>">
														<div id="mila1"></div>
														<br>
														<label>Password</label>
														<input type="password" name="password" class="form-control" style="border-radius: 100px" placeholder="Password.." value="<?php echo $isi[5]; ?>"><br>
														<button type="submit" class="btn btn-flat btn-primary" style="border-radius: 100px"><i class="fa fa-save"></i> UPDATE</button>&nbsp;&nbsp;&nbsp;&nbsp;
														<button type="button" class="btn btn-flat btn-warning" style="border-radius: 100px" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button>
													</form>
													</div>
												</div>
											</div>
										</div>
									</td>
								</tr>
							</table>
						</div>
						</div>
					</div>
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
$(document).ready(function() {
	$('#modalEdit').mouseenter(function() {
		$("input[name='username']").focus();
		$("input[name='username']").keyup(function() {
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
		$("input[name='username']").keydown(function() {
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
		$("input[name='username']").focusout(function() {
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

		$("input[name='password']").keyup(function() {
			var password = $(this).val().length;
			if (password < 8) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("input[name='password']").keydown(function() {
			var password = $(this).val().length;
			if (password < 8) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("input[name='password']").focusout(function() {
			var password = $(this).val().length;
			if (password < 8) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
	});

	$('#modalLagi').mouseenter(function() {
		$("input[name='nama']").focus();
		$("input[name='nama']").keyup(function() {
			var nama = $(this).val().length;
			if (nama < 5) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("input[name='nama']").keydown(function() {
			var nama = $(this).val().length;
			if (nama < 5) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("input[name='nama']").focusout(function() {
			var nama = $(this).val().length;
			if (nama < 5) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});

		$("input[name='alamat']").keyup(function() {
			var alamat = $(this).val().length;
			if (alamat < 5) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("input[name='alamat']").keydown(function() {
			var alamat = $(this).val().length;
			if (alamat < 5) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("input[name='alamat']").focusout(function() {
			var alamat = $(this).val().length;
			if (alamat < 5) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});

		$("input[name='hp']").keyup(function() {
			var hp = $(this).val().length;
			if (hp < 9) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("input[name='hp']").keydown(function() {
			var hp = $(this).val().length;
			if (hp < 9) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("input[name='hp']").focusout(function() {
			var hp = $(this).val().length;
			if (hp < 9) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
	});
});
</script>
</body>
</html>
