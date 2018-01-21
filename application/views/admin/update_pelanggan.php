<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'css.php'; ?>
	<title>Update Pelanggan</title>
</head>
<body>
	<div id="wrapper">
		<?php include 'sidebar.php'; ?>
		<div id="main-panel">
			<?php include 'nav.php'; ?>
			<div id="content">
				<div class="container-fluid">
					<div class="row">
						<div class="panel panel-default">
							<div class="panel-body">
								<p class="text-center">
									<span class="text-size-32"><i class="fa fa-user-o fa-2x"></i></span><br><br>
									<span class="text-size-24">Update Pelanggan</span><br><br>
								</p>
								<form action="<?php echo base_url('index.php/Admin/update_pelanggan'); ?>" method="POST" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
									<?php  
									foreach ($plg as $key) {
									?>
									<div class="form-group">
										<label class="col-sm-3 control-label">ID Pelanggan</label>
										<div class="col-sm-6">
											<input type="text" name="id_pelanggan" class="form-control" value="<?= $key->id_pelanggan ?>" readonly>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Nama</label>
										<div class="col-sm-6">
											<input type="text" name="nama" class="form-control" value="<?= $key->nama ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Kode Tarif</label>
										<div class="col-sm-6">
											<!-- <input type="text" name="kodetarif" class="form-control"> -->
											<select class="form-control" name="kodetarif">
												<?php 
												$tarif = $this->db->get('tarif')->result();
												foreach ($tarif as $kws) {
													echo '<option value="'.$kws->kode_tarif.'">'.$kws->kode_tarif.'</option>\n';
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Loket</label>
										<div class="col-md-6">
											<select class="form-control" name="id">
												<?php  
												$this->db->where('level', 'loket');
												$query = $this->db->get('user')->result();

												foreach ($query as $adf) {
													echo '<option value="'.$adf->id.'">'.$adf->username.'</option>\n';
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Alamat</label>
										<div class="col-sm-6">
											<textarea class="form-control" name="alamat"><?php echo $key->alamat; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-5 control-label">
											<button type="submit" class="btn btn-primary">Update</button>
											<a href="<?php echo base_url('index.php/Admin/tpelanggan'); ?>" class="btn btn-default">Back</a>
										</div>
									</div>
									<?php } ?>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<?php include 'bottom.php'; ?>
</html>