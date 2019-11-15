<?php
include 'index.class.php';
$sambung = new sambung();
$krj     = new kerja();

$data = mysql_query("SELECT * FROM simpan WHERE id_simpan = '$_REQUEST[id_simpan]'");
$r = mysql_fetch_array($data);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Nota Transaksi Simpanan</title>
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
		<h4>Bukti Transaksi Simpanan</h4>
	</center>
	<hr>
	Nomor Transaksi : <label><?php echo $r[0]; ?></label><br>
	Nama : <label><?php echo mysql_fetch_array(mysql_query("SELECT nama FROM user WHERE nia = '$r[nia]'"))['nama']; ?></label><br>
	NIA : <label><?php echo $r['nia']; ?></label><br>
	<br>
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Jenis Rekening</th>
				<th>Keterangan</th>
				<th>Nominal</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo date('d-m-Y',strtotime($r['tanggal'])); ?></td>
				<td><?php echo $r['kode']; ?></td>
				<td><?php echo $r['ket']; ?></td>
				<td><?php echo "Rp. ".number_format($r['nominal'],0,",","."); ?></td>
			</tr>
		</tbody>
	</table>
	<br>
	Total Saldo Simpanan Sebelumnya : <label><?php echo "Rp. ".number_format(mysql_fetch_array(mysql_query("SELECT SUM(nominal) FROM simpan WHERE nia = '$r[nia]' AND id_simpan != '$r[0]'"))[0]-mysql_fetch_array(mysql_query("SELECT SUM(nominal) FROM tarik WHERE nia = '$r[nia]'"))[0],0,",","."); ?></label><br>
	Total Saldo Simpanan Saat Ini : <label><?php echo "Rp. ".number_format(mysql_fetch_array(mysql_query("SELECT SUM(nominal) FROM simpan WHERE nia = '$r[nia]'"))[0]-mysql_fetch_array(mysql_query("SELECT SUM(nominal) FROM tarik WHERE nia = '$r[nia]'"))[0],0,",","."); ?></label><br><br>
	<center>
		Anggota&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Petugas<br><br><br>
		<label><?php echo mysql_fetch_array(mysql_query("SELECT nama FROM user WHERE nia = '$r[nia]'"))[0]; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo mysql_fetch_array(mysql_query("SELECT nama FROM user WHERE nia = '$r[ptg]'"))[0]; ?></label>
	</center>
</body>
</html>