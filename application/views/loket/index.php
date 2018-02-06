<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'css.php'; ?>
	<script src="<?php echo base_url(); ?>assets/css/style-grafic.css"></script>
	<script src="<?php echo base_url(); ?>assets/js/chart/Chart.bundle.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/utils.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/chart/analyser.js"></script>
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
						<div class="col-xs-12">
							<div class="col-xs-12 col-md-4">
								<div class="panel panel-info panel-fill">
									<div class="panel-heading">
										<span class="text-size-22"><i class="fa fa-clone space-right-10"></i>Saldo</span>
									</div>
									<div class="panel-body">
										<p class="break-top-10 text-size-16">Rp. <?php $where = array('kode_pegawai' => $this->session->userdata('kode_pegawai') );
											$ia = $this->mod_admin->tampil_di('user',$where);

											$saldo = $ia[0]->saldo; 
											echo number_format($saldo,2,',','.'); ?> ,-</p>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-md-4">
								<div class="panel panel-danger panel-fill">
									<div class="panel-heading">
										<span class="text-size-22"><i class="fa fa-clone space-right-10"></i>Keuntungan Bulan Ini</span>
									</div>
									<div class="panel-body">
										<?php  
										$sum = 0;
										$date = date("m");
										$date1 = date("Y");
										$id = $this->session->userdata('kode_pegawai');
										$query = $this->db->query("SELECT * FROM pembayaran WHERE date_format(tglbayar, '%m')='$date' AND  date_format(tglbayar, '%Y')='$date1' AND id_loket = '$id' ")->result();
										foreach ($query as $am) {
											$sum += $am->biaya_loket;
										}
										?>
										<p class="break-top-10 text-size-16">Rp. <?php echo number_format($sum,2,',','.'); ?> ,-</p>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-md-4">
								<div class="panel panel-success panel-fill">
									<div class="panel-heading">
										<span class="text-size-22"><i class="fa fa-clone space-right-10"></i>Uang Terima Bulan Ini</span>
									</div>
									<div class="panel-body">
										<?php  
										$sumg = 0;
										$date_ = date('m');
										$date1 = date("Y");
										$id_ = $this->session->userdata('kode_pegawai');
										$query1 = $this->db->query("SELECT * FROM pembayaran WHERE date_format(tglbayar, '%m')='$date_' AND  date_format(tglbayar, '%Y')='$date1' AND id_loket = '$id_' ")->result();
										foreach ($query1 as $iam) {
											$sumg += $iam->total;
										}
										?>
										<p class="break-top-10 text-size-16">Rp. <?php echo number_format($sumg,2,',','.'); ?> ,-</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-8">
							<div class="panel panel-default">
								<canvas id="canvas" style="width: : 70%;"></canvas>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4">
							<div class="panel panel-info">
								<div class="panel-heading">
									<span class="text-size-22"><i class="fa fa-bookmark-o space-right-10"></i>Notifikasi</span>
								</div>
								<div class="panel-body">
									<?php  
									$date = date("Y-m-d");
									if ($date) {
									?>
									<div class="alert alert-costum" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<button class="btn btn-lg btn-costum"></button> 
									</div>
									<div class="alert alert-default" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<strong>om telolet, om!</strong> Lorem ipsum dolor sit amet.
									</div>
									<div class="alert alert-costum1" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<button class="btn btn-lg btn-info"></button> 
									</div>
									<div class="alert alert-costum2" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<button class="btn btn-lg btn-primary"></button> 
									</div>
									<div class="alert alert-costum3" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<button class="btn btn-lg btn-warning"></button> 
									</div>
									<?php  
									$where = array('log_user' => $this->session->userdata('kode_pegawai') );
									$pem = $this->db->get_where('tabel_log', $where)->result();

									foreach ($pem as $kue) {
									?>
									<div class="alert alert-costum4" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<span class="text-success"><b>Pembayaran</b> <?php echo $kue->log_desc; ?></span>
									</div>
									<?php } ?>
									<div class="alert alert-costum5" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<button class="btn btn-lg btn-danger"></button> 
									</div>
									<?php  } ?>
								</div>
							</div>
						</div>
						<div class="col-xs-12">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		var config = {
			type: 'line',
			data: {
				labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
				datasets: [{
					label: "Uang Yang Diterima",
					borderColor: window.chartColors.red,
					backgroundColor: window.chartColors.red,
					data: [
						<?php  
						$tahun = date("Y");
						$bulan = array("","01","02","03","04","05","06","07","08","09","10","11","12");
						$nyot = $this->session->userdata('kode_pegawai');

						for ($i=1; $i < 13; $i++) { 
							$db[$i] = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE id_loket = '$nyot' AND date_format(tglbayar, '%m') = '$bulan[$i]' AND date_format(tglbayar, '%Y') = '$tahun'")->result();

							foreach ($db[$i] as $key[$i]) {
								if ($key[$i]->total) {
										echo $key[$i]->total.",";
									} else {
										echo "0".",";
									}
							}
						}
						?>
                    ],
				}, {
					label: "Keuntungan",
					borderColor: window.chartColors.green,
					backgroundColor: window.chartColors.green,
					data: [
						<?php  
						$tahun = date("Y");
						$bulan = array("","01","02","03","04","05","06","07","08","09","10","11","12");
						$nyot = $this->session->userdata('kode_pegawai');

						for ($i=1; $i < 13; $i++) { 
							$db[$i] = $this->db->query("SELECT SUM(biaya_loket) as total FROM pembayaran WHERE id_loket = '$nyot' AND date_format(tglbayar, '%m') = '$bulan[$i]' AND date_format(tglbayar, '%Y') = '$tahun'")->result();

							foreach ($db[$i] as $key[$i]) {
								if ($key[$i]->total) {
										echo $key[$i]->total.",";
									} else {
										echo "0".",";
									}
							}
						}
						?>
                    ],
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: true,
				spanGaps: false,
				elements: {
					line: {
						tension: 0.000001
					}
				},
				plugins: {
					filler: {
						propagate: false
					}
				},
				scales: {
					xAxes: [{
						scaleLabel: {
							display: true,
							labelString: 'Bulan'
						}
					}],
					yAxes: [{
						stacked: true,
						scaleLabel: {
							display: true,
							labelString: 'Rupiah'
						}
					}]
				},
				title:{
					display:true,
					text:"Grafik Pembayaran Pelanggan - Grafik Area"
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById("canvas").getContext("2d");
			window.myLine = new Chart(ctx, config);
		};
	</script>
<?php include 'bottom.php'; ?>
</body>
</html>