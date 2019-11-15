<?php
include 'index.class.php';
$sambung = new sambung();
$krj 	 = new kerja();

$data = mysql_query("SELECT * FROM rekening WHERE kode = '$_REQUEST[kode]'");
$isi  = mysql_fetch_array($data);
?>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3><i class="fa fa-ticket"></i> Edit Rekening <?php echo $isi[0]; ?></h3>
				</div>
				<div class="modal-body">
					<label>Kode Rekening : </label>
					<input type="hidden" id="kodelama" value="<?php echo $isi[0]; ?>">
					<input type="text" class="form-control" id="newkode" style="border-radius: 100px" value="<?php echo $isi[0]; ?>"><br>
					<label>Nama Rekening : </label>
					<input type="text" class="form-control" id="newnama" style="border-radius: 100px" value="<?php echo $isi[1]; ?>">
					<hr>
					<button type="button" class="btn btn-primary pull-right" id="update" style="border-radius: 100px;margin-left: 25px">
						<i class="fa fa-save"></i> UPDATE
					</button>
					<button type="button" class="btn btn-warning pull-right" data-dismiss="modal" style="border-radius: 100px">
						<i class="fa fa-close"></i> BATAL
					</button>
					<br><br>
					<div id="hasil_update" style="display: none;"></div>
				</div>
			</div>
		</div>