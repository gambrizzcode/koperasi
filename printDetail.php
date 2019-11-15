<?php
include 'index.class.php';
$sambung = new sambung();
$krj     = new kerja();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Laporan Detail Transaksi</title>
	<link rel="icon" href="images/favicon.png">
	<link href="mybootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="datatables/dataTables.bootstrap.css" rel="stylesheet" />
</head>
<script>
function prin() {
	window.print();
	window.location="LapDetail.php";
}
</script>
<body onload="prin()">
	<center>
		<b style="font-size: 20px">SMA 0 Jember</b><br>
		Jl. Raya Jember, Telp. 0331, Hp. 081<hr>
		<?php
		if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") { ?>
		<h4>Laporan Detail Transaksi Semua Periode</h4>	
		<?php }else{ ?>
		<h4>Laporan Detail Transaksi Periode <?php echo date('d-m-Y',strtotime($_REQUEST['dari'])); ?> Sampai <?php echo date('d-m-Y',strtotime($_REQUEST['ke'])); ?></h4>
		<?php } ?>
	</center>
	<hr>
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
	</label><br>
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
	</label><br>
	Total Saldo : <label>
		<?php echo number_format($rtots[0]-$rtotr[0],0,",","."); ?>
	</label><br>
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
<script src="jquery/external/jquery/jquery.js"></script>
<script src="mybootstrap/js/bootstrap.min.js"></script>
<script src="datatables/jquery.dataTables.min.js"></script>
<script src="datatables/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function() {
	$('#tbl_detail').DataTable({
		'order' : [0,'desc'],
		'searching' : false,
		'paging' : false,
		'lengthChange' : false
	});
});
	function prin() {
		window.print();
		window.location="LapDetail.php";
	}
</script>
</body>
</html>