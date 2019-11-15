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
	<title>Laporan Rekap Simpanan</title>
	<link rel="icon" href="images/favicon.png">
	<link href="mybootstrap/css/bootstrap.min.css" rel="stylesheet" />
</head>
<script>
function prin() {
	window.print();
	window.location="LapRekap.php";
}
</script>
<body onload="prin()">
	<center>
		<b style="font-size: 20px">SMA 0 Jember</b><br>
		Jl. Raya Jember, Telp. 0331, Hp. 081<hr>
		<h4>Laporan Rekap Simpanan</h4>
	</center>
	<br><?php echo "Total Anggota Keseluruhan : <b>".$totalAnggota = mysql_num_rows(mysql_query("SELECT * FROM user"))."</b>"; ?><br>
					<table class="table table-condensed table-striped table-hovered table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Rekening Simpanan</th>
								<th>Masuk / Debet</th>
								<th>Keluar / Kredit</th>
								<th>Saldo</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							$queryRek = mysql_query("SELECT * FROM rekening");
							while ($isiRek = mysql_fetch_array($queryRek)) { ?>
							<tr>
								<td><?php echo $no++; ?></td>
								<td><?php echo $isiRek[1] ?></td>
								<td>
									<?php
									$qsimpan = mysql_query("SELECT SUM(nominal) FROM simpan WHERE kode = '$isiRek[0]'");
									$rsimpan = mysql_fetch_array($qsimpan);
									echo number_format($rsimpan[0],0,",",".");
									?>
								</td>
								<td>
									<?php
									$qtarik = mysql_query("SELECT SUM(nominal) FROM tarik WHERE kode = '$isiRek[0]'");
									$rtarik = mysql_fetch_array($qtarik);
									echo number_format($rtarik[0],0,",",".");
									?>
								</td>
								<td>
									<?php
									echo number_format($rsimpan[0]-$rtarik[0],0,",",".");
									?>
								</td>
							</tr>
							<?php } ?>
							<tr>
								<td colspan="2" align="center"><label>TOTAL</label></td>
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