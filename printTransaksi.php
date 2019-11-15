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
	<title>Laporan Simpanan Per Anggota</title>
	<link rel="icon" href="images/favicon.png">
	<link href="mybootstrap/css/bootstrap.min.css" rel="stylesheet" />
</head>
<script>
function prin() {
	window.print();
	window.location="transaksi.php";
}
</script>
<body onload="prin()">
	<center>
		<b style="font-size: 20px">SMA 0 Jember</b><br>
		Jl. Raya Jember, Telp. 0331, Hp. 081<hr>
		<h4>Laporan Simpanan Per Anggota</h4>
	</center>
					<table class="table table-condensed table-bordered table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>NIA</th>
								<th>Nama</th>
								<th>Total Simpanan</th>
								<th>Penarikan</th>
								<th>Saldo</th>
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
							</tr>
							<?php } ?>
							<tr>
								<td colspan="3" align="center"><label>TOTAL</label></td>
								<td>
								<label>
									<?php
									$qsimpan2 = mysql_query("SELECT SUM(nominal) FROM simpan");
									$rsimpan2 = mysql_fetch_array($qsimpan2);
									echo number_format($rsimpan2[0],0,",",".");
									?>
								</label>
								</td>
								<td>
								<label>
									<?php
									$qtarik2 = mysql_query("SELECT SUM(nominal) FROM tarik");
									$rtarik2 = mysql_fetch_array($qtarik2);
									echo number_format($rtarik2[0],0,",",".");
									?>
								</label>
								</td>
								<td>
								<label>
									<?php
									echo number_format($rsimpan2[0]-$rtarik2[0],0,",",".");
									?>
								</label>
								</td>
							</tr>
						</tbody>
					</table>

</body>
</html>