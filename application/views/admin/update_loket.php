<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'css.php'; ?>
	<title>Update Loket</title>
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
								<div class="col-xs-12">
									<p class="text-center">
										<span class="text-size-32"><i class="fa fa-building-o fa-2x"></i></span><br><br>
										<span class="text-size-24">Update Loket</span><br><br>
										<form action="<?php echo base_url('index.php/Admin/update_loket/'); ?>" method="POST" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
											<?php  
											foreach ($upd as $key) {
											?>
											<div class="form-group">
												<label class="col-sm-3 control-label">ID Loket</label>
												<div class="col-sm-6">
													<input type="text" name="id_loket" class="form-control" value="<?php echo $key->kode_pegawai; ?>" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label">Username</label>
												<div class="col-sm-6">
													<input type="text" name="username" class="form-control" placeholder="Nama Loket" value="<?= $key->username ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label">Password</label>
												<div class="col-sm-6">
													<input type="password" name="password" class="form-control" placeholder="Password" value="<?= $key->password ?>">
													<input type="hidden" name="level" value="loket">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-5 control-label">
													<button type="submit" class="btn btn-primary">Update</button>
													<a href="<?php echo base_url('index.php/Admin/tloket'); ?>" class="btn btn-default">Back</a>
												</div>
											</div>
											<?php } ?>
										</form>
									</p>
								</div>
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