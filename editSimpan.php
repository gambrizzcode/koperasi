<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$data = mysql_query("SELECT * FROM simpan WHERE id_simpan = '$_GET[id_simpan]'");
$isi  = mysql_fetch_array($data);

?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3><i class="fa fa-edit"></i> Edit Simpanan <?php echo $_GET['id_simpan']; ?></h3>
		</div>
		<div class="modal-body">
		<form class="myForm" method="post" action="updateSimpan.php">
			<input type="hidden" name="id_simpan" value="<?php echo $isi[0]; ?>">
			<input type="hidden" name="nia" value="<?php echo $isi[1]; ?>">
			<label>Tanggal Transaksi : </label>
			<input type="date" name="tanggal" class="form-control" style="border-radius: 100px;width: 100%" value="<?php echo $isi[2]; ?>"><br>
			<label>Jenis Simpanan : </label>
			<select name="kode" class="form-control" style="border-radius: 100px;width: 100%">
				<option value="">--- Pilih Jenis Simpanan ---</option>
				<?php
				$qrek = mysql_query("SELECT * FROM rekening");
				while ($rrek = mysql_fetch_array($qrek)) { ?>
				<option <?php if($rrek[0] == $isi[3]){echo "selected";}else{} ?> value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
				<?php } ?>
			</select><br>
			<label>Nominal : </label>
			<input type="text" name="nominal" class="form-control" style="border-radius: 100px;width: 100%" value="<?php echo $isi[4]; ?>"><br>
			<label>Uraian / Keterangan : </label>
			<input type="text" name="ket" class="form-control" style="border-radius: 100px;width: 100%" value="<?php echo $isi[5]; ?>"><br><br>
			<input type="hidden" name="ptg" value="<?php echo $_GET['ptg']; ?>">
			<button type="submit" class="btn btn-primary" style="border-radius: 100px" id="updatesimpan"><i class="fa fa-save"></i> SIMPAN</button>&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="button" class="btn btn-warning" style="border-radius: 100px" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button>
		</form>
		</div>
	</div>
</div>