<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'css.php'; ?>
	<?php include 'bottom.php'; ?>
	<title>Floyd</title>
</head>
<body>
	<div id="wrapper">
		<?php include 'sidebar.php'; ?>
		<div id="main-panel">
			<?php include 'nav.php'; ?>
			<div id="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<h1>Cetak Laporan</h1>
							<div class="panel panel-default">
								<div class="panel-body">
									<h5>Cetak Berdasarkan :</h5>
									<table class="table table-bordered">
										<tr>
											<td><label for="" class="control-label">Per Tanggal</label></td>
											<td><input type="date" class="input-md"></td>
										</tr>
										<tr>
											<td><label for="" class="control-label">Per Bulan/Tahun</label></td>
											<td>
												<select name="" id="" class="input-md">
												<?php 
												$months = array('1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
												foreach ($months as $m => $value) {
												?>
													<option value="<?php echo $m; ?>"><?php echo $value; ?></option>

												<?php	} ?>
												</select>
											</td>
										</tr>
									</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>