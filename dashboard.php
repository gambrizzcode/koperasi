<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

if (!$_SESSION['nia'] || $_SESSION['nia'] == "") {
	header("location:index.php");
}else{
	$data = mysql_query("SELECT * FROM user WHERE nia = '$_SESSION[nia]'");
	$isi  = mysql_fetch_array($data);
	if ($isi['level'] == "ADMIN") {}else{
		header("location:biodata.php");
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Koperasi | Dashboard</title>  
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
				<h2><i class="fa fa-dashboard"></i> Dashboard</h2>
			</section>
			<section class="content">
				<div class="row">

					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-navy">
							<div class="inner">
							<br>
								<h3><?php $krj->totalAnggota(); ?></h3>
								<p>Total Anggota</p>
							<br>
							</div>
							<div class="icon">
								<i class="fa fa-users"></i>
							</div>
							<a href="anggota.php" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>

					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-green">
							<div class="inner">
							<br>
								<h3><?php echo number_format($krj->totalSimpanan(),0,",","."); ?></h3>
								<p>Total Simpanan</p>
							<br>
							</div>
							<div class="icon">
								<i class="fa fa-download"></i>
							</div>
							<a href="LapRekap.php" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
					
					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-orange">
							<div class="inner">
							<br>
								<h3><?php echo number_format($krj->totalTarikan(),0,",","."); ?></h3>
								<p>Total Penarikan</p>
							<br>
							</div>
							<div class="icon">
								<i class="fa fa-upload"></i>
							</div>
							<a href="LapRekap.php" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
					
					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-aqua">
							<div class="inner">
							<br>
								<h3><?php echo number_format($krj->totalSimpanan()-$krj->totalTarikan(),0,",","."); ?></h3>
								<p>Total Saldo</p>
							<br>
							</div>
							<div class="icon">
								<i class="fa fa-money"></i>
							</div>
							<a href="LapRekap.php" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
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
	
});
</script>
</body>
</html>
