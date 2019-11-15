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
	<title>Koperasi | Rekening</title>  
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
						<li class="active"><a href="rekening.php"><i class="fa fa-ticket"></i> Rekening</a></li>
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
					<h3><i class="fa fa-ticket"></i> Tambah Rekening Baru</h3>
				</div>
				<div class="modal-body">
					<label>Kode Rekening : </label>
					<input type="text" class="form-control" id="kode" style="border-radius: 100px"><br>
					<label>Nama Rekening : </label>
					<input type="text" class="form-control" id="nama" style="border-radius: 100px">
					<hr>
					<button type="button" class="btn btn-primary pull-right" id="simpan" style="border-radius: 100px;margin-left: 25px">
						<i class="fa fa-save"></i> SIMPAN
					</button>
					<button type="button" class="btn btn-warning pull-right" data-dismiss="modal" style="border-radius: 100px">
						<i class="fa fa-close"></i> BATAL
					</button>
					<br><br>
					<div id="hasil_simpan" style="display: none;"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="content-wrapper">
		<div class="container">
			<section class="content-header">
				<h2><i class="fa fa-ticket"></i> Data Rekening
				<button type="button" class="btn btn-success pull-right" id="tambah" data-toggle="modal" data-target="#modalTambah" style="border-radius: 100px"><i class="fa fa-plus"></i> Tambah Rekening</button>
				</h2>
			</section>
			<section class="content">
				<div class="row">
				<div class="col-md-12">
				<div class="box box-primary">
				<div class="box-body">
					<table id="tbl_rek" class="table table-condensed table-striped table-hovered">
						<thead>
							<tr>
								<th>#</th>
								<th>Kode Rekening</th>
								<th>Nama Rekening</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							$qrek = mysql_query("SELECT * FROM rekening");
							while ($rrek = mysql_fetch_array($qrek)) { ?>
							<tr>
								<td><?php echo $no++; ?></td>
								<td><?php echo $rrek[0]; ?></td>
								<td><?php echo $rrek[1]; ?></td>
								<td>
								<?php
								$adaSimpan = mysql_num_rows(mysql_query("SELECT * FROM simpan WHERE kode = '$rrek[0]'"));
								$adaTarik  = mysql_num_rows(mysql_query("SELECT * FROM tarik WHERE kode = '$rrek[0]'"));
								if ($adaSimpan > 0 || $adaTarik > 0) { ?>
								<button type="button" class="btn btn-default btn-xs btn-flat" data-toggle="modal" data-target="#modalJangan" title="TIDAK BOLEH DIAPA-APAKAN" style="border-radius: 100px"><i class="fa fa-exclamation-triangle"></i></button>
								<div class="modal fade" id="modalJangan" role="dialog">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>
											<div class="modal-body">
												<div class="alert well">
													<center><h3><b>STOP !</b></h3></center>
													<h4 align="center">
														Rekening ini tidak dapat diapa-apakan karena sedang dipakai di transaksi. Jika masih tetap ingin mengubah atau menghapus rekening ini, hapus terlebih dahulu data transaksi yang menggunakan rekening ini. Terima Kasih.
													</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php								
								}else{
								?>
									<button type="button" id="tombol_hapus" class="btn btn-danger btn-xs btn-flat" data-toggle="modal" data-target="#modal<?php echo $rrek[0]; ?>" title="HAPUS" style="border-radius: 100px"><span class="fa fa-trash"></span></button>
									<div class="modal fade" id="modal<?php echo $rrek[0]; ?>" role="dialog">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<center><h3 class="modal-title">YAKIN HAPUS <i class="fa fa-question"></i></h3></center>
												</div>
												<div class="modal-body" align="center">
													<a href="hapusRek.php?kode=<?php echo $rrek[0]; ?>"><button type="button" class="btn btn-danger" style="border-radius: 100px"><span class="fa fa-trash"></span> HAPUS</button></a>
													&nbsp;&nbsp;&nbsp;
													<button type="button" class="btn btn-warning" data-dismiss="modal" style="border-radius: 100px">CANCEL</button>
												</div>
											</div>
										</div>
									</div> 
									|| 
									<button type="button" class="btn btn-xs btn-warning btn-flat buka_modal_edit" id="<?php echo $rrek[0]; ?>" title="EDIT" style="border-radius: 100px"><span class="fa fa-edit"></span></button>
								</td>
							</tr>
							<?php } }?>
						</tbody>
					</table>
				</div>
				</div>
				</div>
				</div>
			</section>

			<div class="modal fade" id="modalEdit" aria-labelledby="myModalLabel" aria-hidden="true"></div>

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
			url: 'editRek.php',
			type: 'GET',
			data: "kode="+id,
			success:function(edit){
				$('#modalEdit').html(edit);
				$('#modalEdit').modal('show',{backdrop:'true'});
			}
		});
	});
});
$(document).ready(function() {
	$('#tbl_rek').DataTable();

	$('#modalTambah').mouseenter(function() {
		$('#kode').focus();
	});

	$('#simpan').click(function() {
		var data = {
			kode : $('#kode').val(),
			nama : $('#nama').val()
		};
		$.ajax({
			url: 'simpanRek.php',
			type: 'GET',
			data: data,
			success:function(simpan){
				$('#hasil_simpan').html(simpan);
				window.location='rekening.php';
			}
		});
	});

	$('.buka_modal_edit').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			url: 'editRek.php',
			type: 'GET',
			data: "kode="+id,
			success:function(edit){
				$('#modalEdit').html(edit);
				$('#modalEdit').modal('show',{backdrop:'true'});
			}
		});
	});

	$('#modalEdit').mouseenter(function() {
		$('#update').click(function() {
			var newdata = {
			newkode : $('#newkode').val(),
			newnama : $('#newnama').val(),
			kodelama : $('#kodelama').val()
		};
		$.ajax({
			url: 'updateRek.php',
			type: 'GET',
			data: newdata,
			success:function(update){
				$('#hasil_update').html(update);
				window.location='rekening.php';
			}
		});
		});
	});
});
</script>
</body>
</html>
