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
	<title>Data Anggota Koperasi</title>
	<link rel="icon" href="images/favicon.png">
	<link href="mybootstrap/css/bootstrap.min.css" rel="stylesheet" />
</head>
<script>
function prin() {
	window.print();
	window.location="anggota.php";
}
</script>
<body onload="prin()">
	<center>
		<b style="font-size: 20px">SMA 0 Jember</b><br>
		Jl. Raya Jember, Telp. 0331, Hp. 081<hr>
		<h4>Data Anggota</h4>
	</center>
	<br><?php echo "Total Anggota Keseluruhan : <b>".$totalAnggota = mysql_num_rows(mysql_query("SELECT * FROM user"))."</b>"; ?><br><br>
					<table class="table table-condensed table-striped table-bordered">
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
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							$data = mysql_query("SELECT * FROM user");
							while ($isi = mysql_fetch_array($data)) { ?>
							<tr <?php if($isi[7] == "1"){}else{echo "style='color:red'";} ?>>
								<td><?php echo $no++; ?></td>
								<td><?php echo $isi[0]; ?></td>
								<td><?php echo $isi[1]; ?></td>
								<td><?php echo $isi[2]; ?></td>
								<td><?php echo $isi[3]; ?></td>
								<td><?php echo $isi[4]; ?></td>
								<td>(********)</td>
								<td><?php echo $isi[6]; ?></td>
								<td><?php if($isi[7] == "1"){echo "AKTIF";}else{echo "NONAKTIF";}; ?></td>
								<td><?php echo $isi[8]; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
</body>
</html>