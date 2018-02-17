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
							<div class="panel panel-default">
								<div class="panel-heading">
									<h1 class="panel-title" style="color: black;">Cetak Laporan</h1>
									<span class="text-grey">Cetak Berdasarkan : Transaksi dan Pendapatan</span>
								</div>
								<div class="panel-body">
									<div class="col-lg-5">
										<form class="form-horizontal" target="_blank" action="<?php echo base_url('index.php/Import/laporan_loket'); ?>" method="POST">
										<div class="form-group">
											<label for="inputPassword3" class="col-sm-2 control-label">Tanggal</label>
											<div class="col-sm-10">
												<select name="hari" id="" class="form-control input-md">
													<option value="semua">Semua</option>
												<?php 
												$zero = '0';
												for ($i=1; $i <= 32; $i++) { 
													if ($i > 9) {
														$zero = '';
													}

													echo '<option value="'.$zero . $i.'">'.$i.'</option>';
												}
												?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="inputPassword3" class="col-sm-2 control-label">Bulan</label>
											<div class="col-sm-10">
												<select name="bulan" id="" class="form-control input-md">
													<option value="semua">Semua</option>
												<?php 
												$months = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
												foreach ($months as $m => $value) {
												?>
													<option value="<?php echo $m; ?>"><?php echo $value; ?></option>

												<?php	} ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="inputPassword3" class="col-sm-2 control-label">Tahun</label>
											<div class="col-sm-10">
												<select class="form-control" name="tahun">								<?php 
														echo "<option value='semua'>Semua</option>\n";
													   $starting_year  =date('Y', strtotime('-60 year'));
			                                           $ending_year = date('Y');
			                                           $current_year = date('Y');
			                                           for($starting_year; $starting_year <= $ending_year; $starting_year++) {
			                                               echo '<option value="'.$starting_year.'"';
			                                               if( $starting_year ==  $current_year ) {
			                                               echo ' selected="selected"';
			                                               }
			                                               echo ' >'.$starting_year.'</option>';
			                                               }               
													?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="inputPassword3" class="col-sm-2 control-label">Status</label>
											<div class="col-sm-10">
												<select class="form-control" name="berdasarkan">								<option value="transaksi">Transaksi</option>
													<option value="pendapatan">Pendapatan</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												<div class="checkbox">
													<label>
														<input type="radio" name="laporan" value="excel"> <b>Excel</b>&nbsp&nbsp
														<input type="radio" name="laporan" value="pdf"> <b>PDF </b>
													</label>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												<button type="submit" class="btn btn-primary">Print</button>
											</div>
										</div>
									</form>
									</div>
									<div class="col-lg-2">
										<center><span class="text-size-22"><i></i>Or</span></center><br><br>
									</div>
									<div class="col-lg-5">
										<form class="form-horizontal" target="_blank" action="<?php echo base_url('index.php/Import/laporan_loketming'); ?>" method="POST">
										<div class="form-group">
											<label for="inputPassword3" class="col-sm-2 control-label">Tanggal</label>
											<div class="col-sm-4">
												<input type="date" class="form-control" name="tgl1">
											</div>
											<div class="col-sm-1">
												<span>-</span>
											</div>
											<div class="col-sm-5">
												<input type="date" class="form-control" name="tgl2">
											</div>
										</div>
										<div class="form-group">
											<label for="inputPassword3" class="col-sm-2 control-label">Status</label>
											<div class="col-sm-10">
												<select class="form-control" name="berdasarkan">								<option value="transaksi">Transaksi</option>
													<option value="pendapatan">Pendapatan</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												<div class="checkbox">
													<label>
														<input type="radio" name="laporan" value="excel"> <b>Excel</b>&nbsp&nbsp
														<input type="radio" name="laporan" value="pdf"> <b>PDF </b>
													</label>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												<button type="submit" class="btn btn-primary">Print</button>
											</div>
										</div>
									</form>
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