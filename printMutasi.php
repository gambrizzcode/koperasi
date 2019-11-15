<?php
include 'index.class.php';
$sambung = new sambung();
$krj     = new kerja();

$data = mysql_query("SELECT * FROM user WHERE nia = '$_REQUEST[nia]'");
$r = mysql_fetch_array($data);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Laporan Simpanan</title>
	<link rel="icon" href="images/favicon.png">
	<link href="mybootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="datatables/dataTables.bootstrap.css" rel="stylesheet" />
</head>
<body onload="prin()">
	<center>
		<b style="font-size: 20px">SMA 0 Jember</b><br>
		Jl. Raya Jember, Telp. 0331, Hp. 081<hr>
		<h4>Laporan Mutasi</h4>
	</center>
	<br>
	<div class="pull-left">
		<label>NIA : <?php echo $r[0]; ?></label><br>
		<label>NAMA : <?php echo $r[1]; ?></label>
	</div>

	<div class="pull-right">
		<label>Total Simpanan : 
			<?php
				$qtots = mysql_query("SELECT SUM(nominal) FROM simpan WHERE nia = '$r[0]'");
				$rtots = mysql_fetch_array($qtots);
				echo number_format($rtots[0],0,",",".");
			?>
		</label><br>
		<label>Total Penarikan : 
			<?php
				$qtotr = mysql_query("SELECT SUM(nominal) FROM tarik WHERE nia = '$r[0]'");
				$rtotr = mysql_fetch_array($qtotr);
				echo number_format($rtotr[0],0,",",".");
			?>
		</label><br>
		<label>Total Saldo : 
			<?php echo number_format($rtots[0]-$rtotr[0],0,",","."); ?>
		</label>
	</div>
	<table id="tbl_s" class="table table-condensed table-striped table-hovered">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Jenis Rekening</th>
								<th>Keterangan</th>
								<th>Nominal Simpan</th>
								<th>Nominal Tarik</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$query_detail = mysql_query("SELECT * FROM simpan WHERE nia = '$_REQUEST[nia]' ORDER BY tanggal");
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
								<td align="right"><?php
								echo "-";
								?></td>
							</tr>
							<?php
							}
							$query_detail2 = mysql_query("SELECT * FROM tarik WHERE nia = '$_REQUEST[nia]' ORDER BY tanggal");
							while ($isi_detail2 = mysql_fetch_array($query_detail2)) { ?>
							<tr>
								<td><?php echo date('d-m-Y',strtotime($isi_detail2[2])); ?></td>
								<td><?php
								$qr2 = mysql_query("SELECT nama FROM rekening WHERE kode = '$isi_detail2[3]'");
								$rr2 = mysql_fetch_array($qr2);
								echo $rr2[0]." <b>(".$isi_detail2[3].")</b>";
								?></td>
								<td><?php echo $isi_detail2[5];?></td>
								<td align="right"><?php
								echo "-";
								?></td>
								<td align="right"><?php echo number_format($isi_detail2[4],0,",","."); ?></td>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
<script src="jquery/external/jquery/jquery.js"></script>
<script src="mybootstrap/js/bootstrap.min.js"></script>
<script src="datatables/jquery.dataTables.min.js"></script>
<script src="datatables/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function() {
	$('#tbl_s').DataTable({
		'order' : [0,'desc'],
		'searching' : false,
		'paging' : false,
		'lengthChange' : false
	});
});
	function prin() {
		window.print();
		window.location="transaksi.php";
	}
</script>
</body>
</html>