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
	<title>Koperasi | Laporan Detail</title>  
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
						<li><a href="anggota.php"><i class="fa fa-users"></i> Anggota</a></li>
						<li><a href="rekening.php"><i class="fa fa-ticket"></i> Rekening</a></li>
						<li><a href="LapRekap.php"><i class="fa fa-files-o"></i> Laporan Rekap</a></li>
						<li class="active"><a href="LapDetail.php"><i class="fa fa-file-text"></i> Laporan Detail</a></li>
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
				<h2>
				<i class="fa fa-file-text"></i> Laporan Detail Transaksi
				<button type="button" class="btn btn-info pull-right" id="prin" style="border-radius: 100px;padding-left: 25px;padding-right: 25px"><i class="fa fa-print"></i> Print</button>
				</h2>
			</section>
			<section class="content">
				<div class="row">
				<div class="col-md-12">
				<div class="box box-primary">
				<div class="box-header">
					<div class="row" align="right">
						<div class="col-md-12 form-inline">
							<label>Dari Tanggal : </label><input type="date" class="form-control" id="dari" <?php if(!$_REQUEST['dari']){}else{echo "value='".$_REQUEST['dari']."'";} ?> style="border-radius: 100px">
							&nbsp;
							<label>Sampai Tanggal : </label><input type="date" class="form-control" id="ke" <?php if(!$_REQUEST['ke']){}else{echo "value='".$_REQUEST['ke']."'";} ?> style="border-radius: 100px">&nbsp;&nbsp;&nbsp;
							<button type="button" class="btn btn-flat btn-warning" id="go" style="border-radius: 100px"><i class="fa fa-search"></i> GO !!</button>
						</div>
					</div><hr>
					Total Simpanan : <label>
						<?php
						if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
							$qtots = mysql_query("SELECT SUM(nominal) FROM simpan");
						}else{
							$qtots = mysql_query("SELECT SUM(nominal) FROM simpan WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
						}
						$rtots = mysql_fetch_array($qtots);
						echo number_format($rtots[0],0,",",".");
						?>
					</label> | 
					Total Penarikan : <label>
						<?php
						if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
							$qtotr = mysql_query("SELECT SUM(nominal) FROM tarik");
						}else{
							$qtotr = mysql_query("SELECT SUM(nominal) FROM tarik WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
						}
						$rtotr = mysql_fetch_array($qtotr);
						echo number_format($rtotr[0],0,",",".");
						?>
					</label> | 
					Total Saldo : <label>
						<?php echo number_format($rtots[0]-$rtotr[0],0,",","."); ?>
					</label><br>
				</div>
				<div class="box-body">
					<table id="tbl_detail" class="table table-condensed table-striped table-hovered">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Nama</th>
								<th>Rekening</th>
								<th>Keterangan</th>
								<th>Nominal Simpan</th>
								<th>Nominal Tarik</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
								$query_detail = mysql_query("SELECT * FROM simpan ORDER BY tanggal DESC");
							}else{
								$query_detail = mysql_query("SELECT * FROM simpan WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]' ORDER BY tanggal DESC");
							}
							while ($isi_detail = mysql_fetch_array($query_detail)) { ?>
							<tr>
								<td><?php echo date('d-m-Y',strtotime($isi_detail[2])); ?></td>
								<td><?php
								$quser = mysql_query("SELECT nama FROM user WHERE nia = '$isi_detail[nia]'");
								$ruser = mysql_fetch_array($quser);
								echo $ruser[0];
								?></td>
								<td><?php
								$qr = mysql_query("SELECT nama FROM rekening WHERE kode = '$isi_detail[3]'");
								$rr = mysql_fetch_array($qr);
								echo $rr[0]." <b>(".$isi_detail[3].")</b>";
								?></td>
								<td><?php echo $isi_detail[5]; ?></td>
								<td align="right"><?php echo number_format($isi_detail[4],0,",","."); ?></td>
									<td align="right"><?php echo "-"; ?></td>
								</tr>
							<?php
							}
							if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
								$query_detail2 = mysql_query("SELECT * FROM tarik ORDER BY tanggal DESC");
							}else{
								$query_detail2 = mysql_query("SELECT * FROM tarik WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]' ORDER BY tanggal DESC");
							}
							while ($isi_detail2 = mysql_fetch_array($query_detail2)) { ?>
							<tr>
								<td><?php echo date('d-m-Y',strtotime($isi_detail2[2])); ?></td>
								<td><?php
								$quser = mysql_query("SELECT nama FROM user WHERE nia = '$isi_detail[nia]'");
								$ruser = mysql_fetch_array($quser);
								echo $ruser[0];
								?></td>
								<td><?php
								$qr2 = mysql_query("SELECT nama FROM rekening WHERE kode = '$isi_detail2[3]'");
								$rr2 = mysql_fetch_array($qr2);
								echo $rr2[0]." <b>(".$isi_detail2[3].")</b>";
								?></td>
								<td><?php echo $isi_detail2[5]; ?></td>
								<td align="right"><?php echo "-"; ?></td>
								<td align="right"><?php echo number_format($isi_detail2[4],0,",","."); ?></td>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
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
<script src="datatables/jquery.dataTables.min.js"></script>
<script src="datatables/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function() {
	$('#tbl_detail').DataTable({
		'order' : [0,'desc'],
		'lengthMenu' : [100,200]
	});
	$('#go').click(function() {
		var dari = $('#dari').val();
		var ke   = $('#ke').val();
		window.location="LapDetail.php?dari="+dari+"&ke="+ke;
	});
	$('#prin').click(function() {
		var dari = $('#dari').val();
		var ke   = $('#ke').val();
		window.location="printDetail.php?dari="+dari+"&ke="+ke;
	});
});
</script>
</body>
</html>
