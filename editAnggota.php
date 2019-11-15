<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$data = mysql_query("SELECT * FROM user WHERE nia = '$_GET[nia]'");
$isi  = mysql_fetch_array($data);
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3><i class="fa fa-users"></i> Edit Anggota NIA : <?php echo $isi[0]; ?></h3>
		</div>
		<div class="modal-body">
		<form id="MyForm" method="post" action="updateAnggota.php">
			<input type="hidden" name="newnia" value="<?php echo $isi[0]; ?>"><br>
			<input type="text" class="form-control" name="newnama" placeholder="Nama.." style="border-radius: 100px" value="<?php echo $isi[1]; ?>"><br>
			<input type="text" class="form-control" name="newalamat" placeholder="Alamat.." style="border-radius: 100px" value="<?php echo $isi[2]; ?>"><br>
			<input type="text" class="form-control" name="newhp" placeholder="Nomor Handphone.." style="border-radius: 100px" value="<?php echo $isi[3]; ?>"><br>
			<input type="text" class="form-control" name="newusername" placeholder="Username.." style="border-radius: 100px" value="<?php echo $isi[4]; ?>">
			<div id="newmila1"></div><br>
			<input type="password" class="form-control" name="newpassword" placeholder="Password.." style="border-radius: 100px" value="<?php echo $isi[5]; ?>">
			<div id="newmila2"></div><br>
			<input type="password" class="form-control" name="newkonpass" placeholder="Confirm Password.." style="border-radius: 100px" value="<?php echo $isi[5]; ?>">
			<b><div id="newmila3"></div></b><br>
			<div class="row">
				<div class="col-md-6">
					<select class="form-control" style="border-radius: 100px" name="newlevel">
						<option value="">--- Pilih Level ---</option>
						<option <?php if($isi[6] == "ADMIN"){echo "selected";}else{} ?> value="ADMIN">ADMIN</option>
						<option <?php if($isi[6] == "INVESTOR"){echo "selected";}else{} ?> value="INVESTOR">INVESTOR</option>
					</select>
				</div>
				<div class="col-md-6">
					<select class="form-control" style="border-radius: 100px" name="newstatus">
						<option value="">--- Pilih Status ---</option>
						<option <?php if($isi[7] == "1"){echo "selected";}else{} ?> value="1">AKTIF</option>
						<option <?php if($isi[7] == "0"){echo "selected";}else{} ?> value="0">NONAKTIF</option>
					</select>
				</div>
			</div>
			<hr>
			<button type="submit" class="btn btn-primary pull-right" id="update" style="border-radius: 100px;margin-left: 20px"><i class="fa fa-sign-in"></i> &nbsp;UPDATE</button>
			<button type="button" class="btn btn-warning pull-right" data-dismiss="modal" style="border-radius: 100px"><i class="fa fa-close"></i> &nbsp;BATAL</button><br><br>
		</form>
		</div>
	</div>
</div>
