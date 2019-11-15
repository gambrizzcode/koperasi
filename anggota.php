<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

if (!$_SESSION['nia'] || $_SESSION['nia'] == "") {
	header("location:index.php");
}else{
	$data = mysql_query("SELECT * FROM user WHERE nia = '$_SESSION[nia]'");
	$isi  = mysql_fetch_array($data);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Koperasi | Anggota</title>  
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="icon" href="images/favicon.png">
	<link rel="stylesheet" href="mybootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="AdminLTE/css/font-awesome.min.css">
	<link rel="stylesheet" href="AdminLTE/css/AdminLTE.min.css">
	<link rel="stylesheet" href="AdminLTE/css/skins/_all-skins.min.css">
	<link href="datatables/dataTables.bootstrap.css" rel="stylesheet" />
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
						<li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li><a href="transaksi.php"><i class="fa fa-money"></i> Transaksi</a></li>
						<li class="active"><a href="anggota.php"><i class="fa fa-users"></i> Anggota</a></li>
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

	<div class="modal fade" id="modalTambah" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3><i class="fa fa-users"></i> Tambah Anggota Baru</h3>
				</div>
				<div class="modal-body">
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
                   	<div class="row">
                   		<div class="col-md-6">
                   			<select class="form-control" style="border-radius: 100px" id="level">
		                   		<option value="">--- Pilih Level ---</option>
		                   		<option value="ADMIN">ADMIN</option>
		                   		<option value="INVESTOR">INVESTOR</option>
		                   	</select>
                   		</div>
                   		<div class="col-md-6">
                   			<select class="form-control" style="border-radius: 100px" id="status">
		                   		<option value="">--- Pilih Status ---</option>
		                   		<option value="1">AKTIF</option>
		                   		<option value="0">NONAKTIF</option>
		                   	</select>
                   		</div>
                   	</div>
                   	<hr>
                   	<button type="button" class="btn btn-primary pull-right" id="masuk" style="border-radius: 100px;margin-left: 20px"><i class="fa fa-sign-in"></i> &nbsp;TAMBAHKAN</button>
                   	<button type="button" class="btn btn-warning pull-right" data-dismiss="modal" style="border-radius: 100px"><i class="fa fa-close"></i> &nbsp;BATAL</button><br><br>
				</div>
			</div>
		</div>
	</div>

	<div class="content-wrapper">
		<div class="container">
			<section class="content-header">
				<h2><i class="fa fa-users"></i> Data Anggota
				<button type="button" class="btn btn-success pull-right" id="tambah" data-toggle="modal" data-target="#modalTambah" style="border-radius: 100px"><i class="fa fa-plus"></i> Tambah Anggota</button>
				<button type="button" class="btn btn-info pull-right" id="print" onclick="window.location='printAnggota.php'" style="border-radius: 100px;margin-right: 25px;padding-left: 25px;padding-right: 25px"><i class="fa fa-print"></i> Print</button>
				</h2>
			</section>
			<section class="content">
				<div class="row">
				<div class="col-md-12">
				<div class="box box-primary">
				<div class="box-body table-responsive">
					<table id="tbl_anggota" class="table table-condensed table-striped table-hovered">
						<thead>
							<tr>
								<th>#</th>
								<th>NIA</th>
								<th>Nama</th>
								<th>Alamat</th>
								<th>No Hp</th>
								<th>Username</th>
								<th>Password</th>
								<th>Level</th>
								<th>Status</th>
								<th>ket</th>
								<th>___Action___</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							$quser = mysql_query("SELECT * FROM user");
							while ($risi = mysql_fetch_array($quser)) { ?>
							<tr <?php if($risi[7] == "1"){}else{echo "style='color:red'";} ?>>
								<td><?php echo $no++; ?></td>
								<td><?php echo $risi[0]; ?></td>
								<td><?php echo $risi[1]; ?></td>
								<td><?php echo $risi[2]; ?></td>
								<td><?php echo $risi[3]; ?></td>
								<td><?php echo $risi[4]; ?></td>
								<td>(********)</td>
								<td><?php echo $risi[6]; ?></td>
								<td><?php if($risi[7] == "1"){echo "AKTIF";}else{echo "NONAKTIF";}; ?></td>
								<td><?php echo $risi[8]; ?></td>
								<td>
									<button type="button" id="tombol_hapus" class="btn btn-danger btn-xs btn-flat" data-toggle="modal" data-target="#<?php echo $risi[0]; ?>" title="HAPUS" style="border-radius:100px"><span class="fa fa-trash"></span></button>
									<div class="modal fade" id="<?php echo $risi[0]; ?>" role="dialog">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<center><h3 class="modal-title">YAKIN HAPUS <i class="fa fa-question"></i></h3></center>
												</div>
												<div class="modal-body" align="center">
													<a href="hapusAnggota.php?nia=<?php echo $risi[0]; ?>"><button type="button" class="btn btn-danger"><span class="fa fa-trash"></span> HAPUS</button></a>
													&nbsp;&nbsp;&nbsp;
													<button type="button" class="btn btn-warning" data-dismiss="modal">CANCEL</button>
												</div>
											</div>
										</div>
									</div>
									||
									<button type="button" class="btn btn-xs btn-warning btn-flat buka_modal_edit" id="<?php echo $risi[0]; ?>" title="EDIT" style="border-radius:100px"><span class="fa fa-edit"></span></button> 
									<?php
									if($risi[7] == "1"){}else{ ?>
										|| 
									<button type="button" class="btn btn-xs btn-info btn-flat verifikasi" data-toggle="modal" data-target="#ver<?php echo $risi[0]; ?>" id="<?php echo $risi[0]; ?>" title="VERIFIKASI" style="border-radius:100px">
									<i class="fa fa-check"></i></button>
									<div class="modal fade" id="ver<?php echo $risi[0]; ?>" role="dialog">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<center>
														<h3 class="modal-title">VERIFIKASI <i class="fa fa-question"></i></h3>
														<h4>Dengan melakukan verifikasi, berarti anda telah mengizinkan anggota dengan NIA <?php echo $risi[0]; ?> ini untuk bergabung. Lanjut ???</h4>
													</center>
												</div>
												<div class="modal-body" align="center">
													<a href="verifikasi.php?nia=<?php echo $risi[0]; ?>"><button type="button" class="btn btn-info"><span class="fa fa-check"></span> VERIFIKASI</button></a>
													&nbsp;&nbsp;&nbsp;
													<button type="button" class="btn btn-warning" data-dismiss="modal">CANCEL</button>
												</div>
											</div>
										</div>
									</div>
									<?php
									}
									?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				</div>
				</div>
				</div>
			</section>

			<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tata-attention-animation="true" aria-labelledby="myModalLabel" aria-hidden="true"></div>

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
<script src="datatables/jquery.dataTables.min.js"></script>
<script src="datatables/dataTables.bootstrap.min.js"></script>
<script>
$(function() {
	$('.buka_modal_edit').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			url: 'editAnggota.php',
			type: 'GET',
			data: "nia="+id,
			success:function(edit){
				$('#modalEdit').html(edit);
				$('#modalEdit').modal('show',{backdrop:'true'});
			}
		});
	});
});
$(document).ready(function() {
	$('#tbl_anggota').DataTable();

	$('.buka_modal_edit').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			url: 'editAnggota.php',
			type: 'GET',
			data: "nia="+id,
			success:function(edit){
				$('#modalEdit').html(edit);
				$('#modalEdit').modal('show',{backdrop:'true'});

			}
		});
	});

	$('#modalTambah').mouseenter(function() {
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

		$("select[id='level']").click(function() {
			var level = $(this).val();
			if (level == "") {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("select[id='level']").change(function() {
			var level = $(this).val();
			if (level == "") {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("select[id='level']").focusout(function() {
			var level = $(this).val();
			if (level == "") {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});

		$("select[id='status']").click(function() {
			var status = $(this).val();
			if (status == "") {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("select[id='status']").change(function() {
			var status = $(this).val();
			if (status == "") {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("select[id='status']").focusout(function() {
			var status = $(this).val();
			if (status == "") {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
	});
//-------------------------------------------------------------------------------------------------------------------------------
	$('#modalEdit').mouseenter(function() {
		$("input[name='newnama']").focus();
		$("input[name='newnama']").keyup(function() {
			var nama = $(this).val().length;
			if (nama < 5) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("input[name='newnama']").keydown(function() {
			var nama = $(this).val().length;
			if (nama < 5) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("input[name='newnama']").focusout(function() {
			var nama = $(this).val().length;
			if (nama < 5) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});

		$("input[name='newalamat']").keyup(function() {
			var alamat = $(this).val().length;
			if (alamat < 5) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("input[name='newalamat']").keydown(function() {
			var alamat = $(this).val().length;
			if (alamat < 5) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("input[name='newalamat']").focusout(function() {
			var alamat = $(this).val().length;
			if (alamat < 5) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});

		$("input[name='newhp']").keyup(function() {
			var hp = $(this).val().length;
			if (hp < 9) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("input[name='newhp']").keydown(function() {
			var hp = $(this).val().length;
			if (hp < 9) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("input[name='newhp']").focusout(function() {
			var hp = $(this).val().length;
			if (hp < 9) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});

		$("input[name='newusername']").keyup(function() {
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
	            		$('#newmila1').html(cek1);
	            	}
	            });
			}
		});
		$("input[name='newusername']").keydown(function() {
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
	            		$('#newmila1').html(cek1);
	            	}
	            });
			}
		});
		$("input[name='newusername']").focusout(function() {
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
	            		$('#newmila1').html(cek1);
	            	}
	            });
			}
		});

		$("input[name='newpassword']").keyup(function() {
			var password = $(this).val().length;
			if (password < 8) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("input[name='newpassword']").keydown(function() {
			var password = $(this).val().length;
			if (password < 8) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("input[name='newpassword']").focusout(function() {
			var password = $(this).val().length;
			if (password < 8) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});

		$("input[name='newkonpass']").keyup(function() {
			var konpass = $(this).val();
			var password = $("input[name='newpassword']").val();
			if (konpass != password) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
	            $('#newmila3').html("Password Tidak Cocok");
	            $('#newmila3').css('color', 'red');
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
				$('#newmila3').html("Password Cocok");
	            $('#newmila3').css('color', 'green');
			}
		});
		$("input[name='newkonpass']").keydown(function() {
			var konpass = $(this).val();
			var password = $("input[name='newpassword']").val();
			if (konpass != password) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
	            $('#newmila3').html("Password Tidak Cocok");
	            $('#newmila3').css('color', 'red');
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
				$('#newmila3').html("Password Cocok");
	            $('#newmila3').css('color', 'green');
			}
		});
		$("input[name='newkonpass']").focusout(function() {
			var konpass = $(this).val();
			var password = $("input[name='newpassword']").val();
			if (konpass != password) {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
	            $('#newmila3').html("Password Tidak Cocok");
	            $('#newmila3').css('color', 'red');
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
				$('#newmila3').html("Password Cocok");
	            $('#newmila3').css('color', 'green');
			}
		});

		$("select[name='newlevel']").click(function() {
			var level = $(this).val();
			if (level == "") {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("select[name='newlevel']").change(function() {
			var level = $(this).val();
			if (level == "") {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("select[name='newlevel']").focusout(function() {
			var level = $(this).val();
			if (level == "") {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});

		$("select[name='newstatus']").click(function() {
			var status = $(this).val();
			if (status == "") {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("select[name='newstatus']").change(function() {
			var status = $(this).val();
			if (status == "") {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
		$("select[name='newstatus']").focusout(function() {
			var status = $(this).val();
			if (status == "") {
				$(this).css('box-shadow', 'red 0px 0px 10px');
	            $(this).focus();
			}else{
				$(this).css('box-shadow', 'blue 0px 0px 2px');
			}
		});
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
		$.ajax({
			url: 'daftar_do.php',
			type: 'GET',
			data: data,
			success:function(data){
				$('#hasil').html(data);
				window.location="anggota.php";
			}
		});
	});

});
</script>
</body>
</html>
