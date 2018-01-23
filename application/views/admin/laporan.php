<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'css.php'; ?>
	<title>Laporan</title>
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
								<div class="col-xs-12 col-sm-12">
									<center><span class="text-size-22"><i class="fa fa-file-o space-right-10"aria-hidden="true"></i>Laporan pendapatan Loket</span></center><br> <br>
									<form action="">
										<div class="form-group">
											<label for="">Loket</label>
											<!-- <input type="text" class="form-control input-lg" placeholder="Nama Loket"> -->
											<select class="form-control" name="loket">
												<option value="semua">Semua</option>
												<?php  
												$this->db->where('level', 'loket');
												$query = $this->db->get('user')->result();

												foreach ($query as $ka) {
													echo '<option value="'.$ka->id.'">'.$ka->username.'</option>\n';	
													}	
												?>
											</select>
										</div>
										<div class="form-group">
											<label for="">Bulan</label>
											<select class="form-control" name="bulan">
												<?php  
												$bulan = array('0' => 'Semua', '1' => 'Januari', '2' => 'Febuari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
												foreach ($bulan as $key => $value) {
													echo '<option value"'.$key.'">'.$value.'</option>\n';
												}
												?>
											</select>
										</div>
										<div class="form-group">
											<label for="">Tahun</label>
											<select class="form-control" name="tahun">
	                                            <?php
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
										<div class="form-group">
											<label class="radio-inline">
												<input type="radio" name="laporan" value="excel"> Excel
											</label>
											<label class="radio-inline">
												<input type="radio" name="laporan" value="pdf"> PDF
											</label>
										</div><br>
										<div class="form-group">
											<button class="btn btn-primary" type="button">login</button>
											<button class="btn btn-default" type="reset">batal</button>
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
</body>
<?php include 'bottom.php'; ?>
</html>