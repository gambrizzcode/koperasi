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
	<title>Koperasi | Transaksi</title>  
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
						<li class="active"><a href="transaksi.php"><i class="fa fa-money"></i> Transaksi</a></li>
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
				<h2><i class="fa fa-money"></i> Transaksi
				<button type="button" class="btn btn-info pull-right" id="print" onclick="window.location='printTransaksi.php'" style="border-radius: 100px;padding-left: 25px;padding-right: 25px"><i class="fa fa-print"></i> Print</button>
				</h2>
			</section>
			<section class="content">
				<div class="row">
				<div class="col-md-12">
				<div class="box box-primary">
				<div class="box-header">
					
				</div>
				<div class="box-body">
					<table id="tbl_t" class="table table-condensed table-hovered table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>NIA</th>
								<th>Nama</th>
								<th>Total Simpanan</th>
								<th>Penarikan</th>
								<th>SALDO</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							$qtransaksi = mysql_query("SELECT * FROM user WHERE status = '1'");
							while ($rt = mysql_fetch_array($qtransaksi)) { ?>
							<tr>
								<td><?php echo $no++; ?></td>
								<td><?php echo $rt[0]; ?></td>
								<td><?php echo $rt[1]; ?></td>
								<td>
									<?php
									$querySimpan = mysql_query("SELECT SUM(nominal) FROM simpan WHERE nia = '$rt[0]'");
									$totalSimpan = mysql_fetch_array($querySimpan);
									if ($totalSimpan[0] == 0 || $totalSimpan[0] == null || !$totalSimpan[0]) {
										echo "-";
									}else{
										echo number_format($totalSimpan[0],0,",",".");
									}
									?>
								</td>
								<td>
									<?php
									$queryTarik = mysql_query("SELECT SUM(nominal) FROM tarik WHERE nia = '$rt[0]'");
									$totalTarik = mysql_fetch_array($queryTarik);
									if ($totalTarik[0] == 0 || $totalTarik[0] == null || !$totalTarik[0]) {
										echo "-";
									}else{
										echo number_format($totalTarik[0],0,",",".");
									}
									?>
								</td>
								<td>
									<?php
									$saldo = $totalSimpan[0]-$totalTarik[0];
									if ($saldo == null || $saldo == "" || !$saldo) {
										echo "-";
									}else{
										echo number_format($saldo,0,",",".");
									}
									?>
								</td>
								<td>
								<div class="btn-group">
									<button type="button" style="border-top-left-radius: 100px;border-bottom-left-radius: 100px" class="btn btn-primary btn-xs" id="simpan" data-toggle="modal" data-target="#simpan<?php echo $rt[0]; ?>"><i class="fa fa-download"></i> Simpan</button>

									<button type="button" class="btn btn-danger btn-xs" id="tarik" data-toggle="modal" data-target="#tarik<?php echo $rt[0]; ?>"><i class="fa fa-upload"></i> Tarik</button>

									<button type="button" style="border-top-right-radius: 100px;border-bottom-right-radius: 100px" class="btn btn-default btn-xs detail" id="<?php echo $rt[0]; ?>" data-toggle="modal" data-target="#detail<?php echo $rt[0]; ?>"><i class="fa fa-file-text"></i> Detail</button>
								</div>
						<!-- begin modal detail -->
							<div class="modal fade dttbl" id="detail<?php echo $rt[0]; ?>" role="dialog">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h3>
												<i class="fa fa-file-text"></i> Detail Simpanan <?php echo $rt[1]; ?>&nbsp;&nbsp;&nbsp;
												<button type="button" class="btn btn-flat btn-info" style="border-radius: 100px;padding-right: 25px;padding-left: 25px" onclick="window.location='printMutasi.php?nia=<?php echo $rt[0]; ?>'"><i class="fa fa-print"></i> Print</button>
											</h3>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="col-md-7">
													<label>NIA : <?php echo $rt[0]; ?></label><br>
													<label>Nama : <?php echo $rt[1]; ?></label><br>
												</div>
												<div class="col-md-5">
													<b style="font-size: 25px">
													Saldo : 
													<?php echo "Rp. ".number_format($saldo,0,",","."); ?>
													</b>
												</div>
												<div class="col-md-6">
												<hr>
												<h4><b>Total Simpanan</b></h4>
													<table>
														<?php
														$queryRek = mysql_query("SELECT * FROM rekening");
														while ($isiRek = mysql_fetch_array($queryRek)) {
															$ambilSimpan = mysql_query("SELECT SUM(nominal) FROM simpan WHERE kode = '$isiRek[0]' AND nia = '$rt[0]'");
															$dapatSimpan = mysql_fetch_array($ambilSimpan); ?>
														<tr>
															<td><?php echo $isiRek[1]; ?>  &nbsp;</td>
															<td> : <?php echo "Rp. ".number_format($dapatSimpan[0],0,",","."); ?></td>
														</tr>
														<?php } ?>
														<tr style="border-top: black 1px solid">
															<td align="center"><label>TOTAL</label></td>
															<td>
																<label>
																<?php echo " : Rp. ".number_format($totalSimpan[0],0,",","."); ?>
																</label>
															</td>
														</tr>
													</table>
												</div>
												<div class="col-md-6">
												<hr>
												<h4><b>Total Penarikan</b></h4>
													<table>
														<?php
														$queryRek2 = mysql_query("SELECT * FROM rekening");
														while ($isiRek2 = mysql_fetch_array($queryRek2)) {
															$ambilTarik = mysql_query("SELECT SUM(nominal) FROM tarik WHERE kode = '$isiRek2[0]' AND nia = '$rt[0]'");
															$dapatTarik = mysql_fetch_array($ambilTarik); ?>
														<tr>
															<td>Penarikan <?php echo $isiRek2[1]; ?>  &nbsp;</td>
															<td> : <?php echo "Rp. ".number_format($dapatTarik[0],0,",","."); ?></td>
														</tr>
														<?php } ?>
														<tr style="border-top: black 1px solid">
															<td align="center"><label>TOTAL</label></td>
															<td>
																<label>
																<?php echo " : Rp. ".number_format($totalTarik[0],0,",","."); ?>
																</label>
															</td>
														</tr>
													</table>
												</div>
												<div class="col-md-12">
												<hr>
													<table id="tbl<?php echo $rt[0]; ?>" class="table table-condensed table-striped table-hovered">
														<thead>
															<tr bgcolor="cyan">
																<th>Tanggal</th>
																<th>Rekening</th>
																<th>Keterangan</th>
																<th>Nominal Simpan</th>
																<th>Nominal Tarik</th>
															</tr>
														</thead>
														<tbody>
															<?php
															$query_detail = mysql_query("SELECT * FROM simpan WHERE nia = '$rt[0]' ORDER BY tanggal");
															while ($isi_detail = mysql_fetch_array($query_detail)) { ?>
															<tr>
																<td><?php echo date('d-m-Y',strtotime($isi_detail[2])); ?></td>
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
															$query_detail2 = mysql_query("SELECT * FROM tarik WHERE nia = '$rt[0]' ORDER BY tanggal");
															while ($isi_detail2 = mysql_fetch_array($query_detail2)) { ?>
															<tr>
																<td><?php echo date('d-m-Y',strtotime($isi_detail2[2])); ?></td>
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
								</div>
							</div>
						<!-- end modal detail -->
						<!-- begin modal simpan -->
							<div class="modal fade" id="simpan<?php echo $rt[0]; ?>" role="dialog">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h3><i class="fa fa-download"></i> Tambah Simpanan</h3>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="col-md-6">
													<label>NIA : <?php echo $rt[0]; ?></label><hr>
													<label>Nama : <?php echo $rt[1]; ?></label><hr>
													<label>Saldo Simpanan Sebelumnya :
													<?php
													$saldo = $totalSimpan[0]-$totalTarik[0];
													if ($saldo == null || $saldo == "" || !$saldo) {
														echo "-";
													}else{
														echo number_format($saldo,0,",",".");
													}
													?>
													</label><hr>
												</div>
												<div class="col-md-6">
												<form id="MyForm" method="post" action="simpanSimpan.php">
													<input type="hidden" name="id_simpan" value="<?php echo substr(md5(time()),0,8);?>">
													<input type="hidden" name="nia" value="<?php echo $rt[0]; ?>">
													<label>Tanggal Transaksi : </label>
													<input type="date" name="tanggal" class="form-control" style="border-radius: 100px;width: 100%"><br>
													<label>Jenis Simpanan : </label>
													<select name="kode" class="form-control" style="border-radius: 100px;width: 100%">
														<option value="">--- Pilih Jenis Simpanan ---</option>
														<?php
														$qrek = mysql_query("SELECT * FROM rekening");
														while ($rrek = mysql_fetch_array($qrek)) { ?>
														<option value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
														<?php } ?>
													</select><br>
													<label>Nominal : </label>
													<input type="text" name="nominal" class="form-control" style="border-radius: 100px;width: 100%"><br>
													<label>Uraian / Keterangan : </label>
													<input type="text" name="ket" class="form-control" style="border-radius: 100px;width: 100%"><br><br>
													<input type="hidden" name="ptg" value="<?php echo $isi[0]; ?>">
													<button type="submit" class="btn btn-primary" style="border-radius: 100px" name="simpansimpan"><i class="fa fa-save"></i> SIMPAN</button>&nbsp;&nbsp;&nbsp;&nbsp;
													<button type="button" class="btn btn-warning" style="border-radius: 100px" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button>
												</form>
												</div>
												<h4 style="margin-left: 10px">Data Transaksi Simpanan</h4>
												<div class="col-md-12">
													<table class="table table-condensed table-striped table-hovered">
														<thead>
															<tr bgcolor="cyan">
																<th>#</th>
																<th>Tgl Transaksi</th>
																<th>Jenis Simpan</th>
																<th>Keterangan</th>
																<th>Nominal</th>
																<th>Action</th>
															</tr>
														</thead>
														<tbody>
														<?php
														$nmer = 1;
														$qsimpan = mysql_query("SELECT * FROM simpan INNER JOIN rekening ON simpan.kode = rekening.kode WHERE simpan.nia = '$rt[0]' ORDER BY simpan.tanggal DESC");
														while ($rsimpan = mysql_fetch_array($qsimpan)) { ?>
															<tr>
																<td><?php echo $nmer++; ?></td>
																<td><?php echo date('d-m-Y',strtotime($rsimpan['tanggal'])); ?></td>
																<td><?php echo $rsimpan['nama']." (".$rsimpan[3].")"; ?></td>
																<td><?php echo $rsimpan[5]; ?></td>
																<td><?php echo number_format($rsimpan['nominal'],0,",","."); ?></td>
																<td>
																	<button type="button" id="tombol_hapus" class="btn btn-danger btn-xs btn-flat" data-toggle="modal" data-target="#modal<?php echo $rsimpan[0]; ?>" title="HAPUS" style="border-radius: 100px"><span class="fa fa-trash"></span></button>
																	<div class="modal fade" id="modal<?php echo $rsimpan[0]; ?>" role="dialog">
																		<div class="modal-dialog">
																			<div class="modal-content">
																				<div class="modal-header">
																					<button type="button" class="close" data-dismiss="modal">&times;</button>
																					<center><h3 class="modal-title">YAKIN HAPUS <i class="fa fa-question"></i></h3></center>
																				</div>
																				<div class="modal-body" align="center">
																					<a href="hapusSimpan.php?id_simpan=<?php echo $rsimpan[0]; ?>"><button type="button" class="btn btn-danger" style="border-radius: 100px"><span class="fa fa-trash"></span> HAPUS</button></a>
																					&nbsp;&nbsp;&nbsp;
																					<button type="button" class="btn btn-warning" data-dismiss="modal" style="border-radius: 100px">CANCEL</button>
																				</div>
																			</div>
																		</div>
																	</div> 
																	|| 
																	<button type="button" class="btn btn-xs btn-warning btn-flat buka_modal_edit" id="<?php echo $rsimpan[0]; ?>" title="EDIT" style="border-radius: 100px"><span class="fa fa-edit"></span></button>
																</td>
															</tr>
														<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="modal fade" id="modalEditSimpan" aria-labelledby="myModalLabel" aria-hidden="true" role="dialog" style="z-index: 9999"></div>
							<!-- end modal simpan -->
							<!-- begin modal tarik -->
							<div class="modal fade" id="tarik<?php echo $rt[0]; ?>" role="dialog">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h3><i class="fa fa-upload"></i> Tambah Penarikan</h3>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="col-md-6">
													<label>NIA : <?php echo $rt[0]; ?></label><hr>
													<label>Nama : <?php echo $rt[1]; ?></label><hr>
													<label>Saldo Simpanan Sebelumnya :
													<?php
													$saldo = $totalSimpan[0]-$totalTarik[0];
													if ($saldo == null || $saldo == "" || !$saldo) {
														echo "-";
													}else{
														echo number_format($saldo,0,",",".");
													}
													?>
													</label><hr>
												</div>
												<div class="col-md-6">
												<form id="MyFrom2" method="post" action="simpantarik.php">
													<input type="hidden" name="id_tarik" value="<?php echo substr(md5(time()),0,8); ?>">
													<input type="hidden" name="tnia" value="<?php echo $rt[0]; ?>">
													<label>Tanggal Transaksi : </label>
													<input type="date" name="ttanggal" class="form-control" style="border-radius: 100px;width: 100%"><br>
													<label>Jenis Simpanan : </label>
													<select name="tkode" class="form-control" style="border-radius: 100px;width: 100%">
														<option value="">--- Pilih Jenis Simpanan ---</option>
														<?php
														$qrek = mysql_query("SELECT simpan.kode, rekening.nama FROM simpan INNER JOIN rekening ON simpan.kode = rekening.kode WHERE simpan.nia = '$rt[0]' GROUP BY simpan.kode");
														while ($rrek = mysql_fetch_array($qrek)) { ?>
														<option value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
														<?php } ?>
													</select><br>
													<label>Nominal Penarikan : </label>
													<input type="text" name="tnominal" class="form-control" style="border-radius: 100px;width: 100%"><br>
													<label>Uraian / Keterangan : </label>
													<input type="text" name="tket" class="form-control" style="border-radius: 100px;width: 100%"><br><br>
													<input type="hidden" name="tptg" value="<?php echo $isi[0]; ?>">
													<?php
													$cekada = mysql_num_rows(mysql_query("SELECT * FROM simpan WHERE nia = '$rt[0]'"));
													if ($cekada == 0) { ?>
														<div class="alert alert-warning">
															Anggota ini tidak mempunyai simpanan sepeser pun. Sehingga tidak dapat melakukan penarikan.
														</div>
													<?php
													}else{
													?>
													<button type="submit" class="btn btn-primary" style="border-radius: 100px" name="simpantarik"><i class="fa fa-save"></i> SIMPAN</button>&nbsp;&nbsp;&nbsp;&nbsp;
													<button type="button" class="btn btn-warning" style="border-radius: 100px" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button>
													<?php } ?>
												</form>
												</div>
												<h4 style="margin-left: 10px">Data Transaksi Penarikan</h4>
												<div class="col-md-12">
													<table class="table table-condensed table-striped table-hovered">
														<thead>
															<tr bgcolor="cyan">
																<th>#</th>
																<th>Tgl Transaksi</th>
																<th>Jenis Penarikan Simpan</th>
																<th>Keterangan</th>
																<th>Nominal</th>
																<th>Action</th>
															</tr>
														</thead>
														<tbody>
														<?php
														$nmert = 1;
														$qtarik = mysql_query("SELECT * FROM tarik INNER JOIN rekening ON tarik.kode = rekening.kode WHERE tarik.nia = '$rt[0]' ORDER BY tarik.tanggal DESC");
														while ($rtarik = mysql_fetch_array($qtarik)) { ?>
															<tr>
																<td><?php echo $nmert++; ?></td>
																<td><?php echo date('d-m-Y',strtotime($rtarik['tanggal'])); ?></td>
																<td><?php echo $rtarik['nama']." (".$rtarik[3].")"; ?></td>
																<td><?php echo $rtarik[5]; ?></td>
																<td><?php echo number_format($rtarik['nominal'],0,",","."); ?></td>
																<td>
																	<button type="button" id="tombol_hapus" class="btn btn-danger btn-xs btn-flat" data-toggle="modal" data-target="#modalo<?php echo $rtarik[0]; ?>" title="HAPUS" style="border-radius: 100px"><span class="fa fa-trash"></span></button>
																	<div class="modal fade" id="modalo<?php echo $rtarik[0]; ?>" role="dialog">
																		<div class="modal-dialog">
																			<div class="modal-content">
																				<div class="modal-header">
																					<button type="button" class="close" data-dismiss="modal">&times;</button>
																					<center><h3 class="modal-title">YAKIN HAPUS <i class="fa fa-question"></i></h3></center>
																				</div>
																				<div class="modal-body" align="center">
																					<a href="hapusTarik.php?id_tarik=<?php echo $rtarik[0]; ?>"><button type="button" class="btn btn-danger" style="border-radius: 100px"><span class="fa fa-trash"></span> HAPUS</button></a>
																					&nbsp;&nbsp;&nbsp;
																					<button type="button" class="btn btn-warning" data-dismiss="modal" style="border-radius: 100px">CANCEL</button>
																				</div>
																			</div>
																		</div>
																	</div> 
																	|| 
																	<button type="button" class="btn btn-xs btn-warning btn-flat buka_modal_edito" id="<?php echo $rtarik[0]; ?>" title="EDIT" style="border-radius: 100px"><span class="fa fa-edit"></span></button>
																</td>
															</tr>
														<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- end modal tarik -->
							<div class="modal fade" id="modalEditTarik" aria-labelledby="myModalLabel" aria-hidden="true" role="dialog" style="z-index: 9999"></div>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				</div>
				</div>
				</div>
					<p align="right">
						<i><b>NB </b>: Data di atas adalah data simpanan anggota yang sudah di <b>Verifikasi</b> !</i>
					</p>
			</section>
		</div>
	</div>

	<input type="hidden" id="ptg" value="<?php echo $isi[0]; ?>">

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
		var ptg = $('#ptg').val();
		$.ajax({
			url: 'editSimpan.php',
			type: 'GET',
			data: "id_simpan="+id+"&ptg="+ptg,
			success:function(edit1){
				$('#modalEditSimpan').html(edit1);
				$('#modalEditSimpan').modal('show',{backdrop:'true'});
			}
		});
	});
	$('.buka_modal_edito').click(function() {
		var id = $(this).attr('id');
		var ptg = $('#ptg').val();
		$.ajax({
			url: 'editTarik.php',
			type: 'GET',
			data: "id_tarik="+id+"&ptg="+ptg,
			success:function(edit2){
				$('#modalEditTarik').html(edit2);
				$('#modalEditTarik').modal('show',{backdrop:'true'});
			}
		});
	});
});
$(document).ready(function() {
	$('#tbl_t').DataTable({
		'lengthMenu' : [100,200]
	});

	$('.detail').click(function() {
		var ahay = $(this).attr('id');
		$('#detail'+ahay).ready(function() {
			$('#tbl'+ahay).DataTable({
				'order' : [0,'desc'],
				'searching' : false,
				'paging' : false,
				'lengthChange' : false
			});
		});
	});

	$('.buka_modal_edit').click(function() {
		var id = $(this).attr('id');
		var ptg = $('#ptg').val();
		$.ajax({
			url: 'editSimpan.php',
			type: 'GET',
			data: "id_simpan="+id+"&ptg="+ptg,
			success:function(edit3){
				$('#modalEditSimpan').html(edit3);
				$('#modalEditSimpan').modal('show',{backdrop:'true'});
			}
		});
	});
	$('.buka_modal_edito').click(function() {
		var id = $(this).attr('id');
		var ptg = $('#ptg').val();
		$.ajax({
			url: 'editTarik.php',
			type: 'GET',
			data: "id_tarik="+id+"&ptg="+ptg,
			success:function(edit4){
				$('#modalEditTarik').html(edit4);
				$('#modalEditTarik').modal('show',{backdrop:'true'});
			}
		});
	});

});
</script>
</body>
</html>
