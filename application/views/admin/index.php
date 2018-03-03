<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "css.php"; ?>
	<script src="<?php echo base_url(); ?>assets/css/style-grafic.css"></script>
	<script src="<?php echo base_url(); ?>assets/js/chart/Chart.bundle.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/utils.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/chart/analyser.js"></script>
	<title>Admin</title>
	<style type="text/css">
		.btn-costum {
			background-color: #930522;
			color: #ffffff;
		}
		.btn-default {
			background-color: #ff2854;
			border-color: #fc0033;
			color: #ffffff;
		}
		.alert-costum1{
			background-color: #f9f7f7;
			border-color: #07b3f7;
		}
		.alert-costum2 {
			background-color: #f9f7f7;
			border-color: #072af7;
			color: #ffffff;
		}
		.alert-costum3 {
			background-color: #f9f7f7;
			border-color: #f79b07;
			color: #ffffff;
		}
		.alert-costum4 {
			background-color: #f9f7f7;
			border-color: #10a335;
			color: #ffffff;
		}
		.alert-costum5 {
			background-color: #f9f7f7;
			border-color: #ff0000;
			color: #ffffff;
		}
	</style>
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
							<div class="col-xs-12 col-md-6">
								<div class="panel panel-danger panel-fill">
									<div class="panel-heading">
										<span class="text-size-22"><i class="fa fa-clone space-right-10"></i>Yang belum Bayar</span>
									</div>
									<div class="panel-body">
										<?php  
										$this->db->where('status', 0);
										$tet = $this->db->get('tagihan')->num_rows();
										// $jse = $tet[0]->id_tagihan;
										if ($tet == 0) {
											$jujus = 0;
										} else {
											$jujus = $tet;
										}
										?>
										<p class="break-top-10 text-size-16"><?php echo $jujus; ?> Orang</p>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class="panel panel-success panel-fill">
									<div class="panel-heading">
										<span class="text-size-20"><i class="fa fa-clone space-right-10"></i>Pemasukan Keseluruhan</span>
									</div>
									<div class="panel-body">
										<?php  
										$sumg = 0;
										$date_ = date('m');
										$date1 = date("Y");
										$query1 = $this->db->query("SELECT * FROM pembayaran WHERE date_format(tglbayar, '%m')='$date_' AND  date_format(tglbayar, '%Y')='$date1' ")->result();
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
							<div class="panel panel-info" style="max-height: 348px; overflow: scroll">
								<div class="panel-heading">
									<span class="text-size-22"><i class="fa fa-info space-right-10"></i>Info</span>
								</div>
								<div class="panel-body">
									<?php  
									$d = date("d");
									$b = date("m");
									$Y = date("Y");
									$sess = $this->session->userdata('kode_pegawai');
									$login = $this->db->query("SELECT log_time,log_desc FROM tabel_log WHERE log_user = '$sess' AND date_format(log_time, '%d') = '$d' AND date_format(log_time, '%m') = '$b' AND date_format(log_time, '%Y') = '$Y' AND log_tipe = '0' ORDER BY log_id DESC LIMIT 1 ")->result();

									foreach ($login as $co) {
									?>
									<div class="alert alert-costum1" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<span class="text-info"><b>Login</b> <?php echo $co->log_desc." pada ".$co->log_time; ?></span> 
									</div>
									<?php } 

									$logout = $this->db->query("SELECT * FROM tabel_log WHERE log_user = '$sess' AND date_format(log_time, '%d') = '$d' AND date_format(log_time, '%m') = '$b' AND date_format(log_time, '%Y') = '$Y' AND log_tipe = '1' ORDER BY log_id DESC LIMIT 1 ")->result();
									foreach ($logout as $bl) {
									?>
									<div class="alert alert-costum" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<span style="color: #f90411;"><b>Logout</b> <?php echo $bl->log_desc." pada ".$bl->log_time; ?></span>
									</div>
									<?php  } 

									$excel = $this->db->query("SELECT * FROM tabel_log WHERE log_user = '$sess' AND date_format(log_time, '%d') = '$d' AND date_format(log_time, '%m') = '$b' AND date_format(log_time, '%Y') = '$Y' AND log_tipe = '6' ORDER BY log_id DESC LIMIT 1 ")->result();
									foreach ($excel as $lu) {
									?>
									<div class="alert alert-costum3" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<span class="text-warning"><b>Export Excel</b> <?php echo $lu->log_desc." pada ".$lu->log_time; ?></span>
									</div>
									<?php  }

									$pdf = $this->db->query("SELECT * FROM tabel_log WHERE log_user = '$sess' AND date_format(log_time, '%d') = '$d' AND date_format(log_time, '%m') = '$b' AND date_format(log_time, '%Y') = '$Y' AND log_tipe = '7' ORDER BY log_id DESC LIMIT 1 ")->result();
									foreach ($pdf as $sayang) {
									?>
									<div class="alert alert-costum5" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<span class="text-danger"><b>Export PDF</b> <?php echo $sayang->log_desc." pada ".$sayang->log_time; ?></span>
									</div>
									<?php }

									$pem = $this->db->query("SELECT * FROM tabel_log WHERE log_user = '$sess' AND date_format(log_time, '%d') = '$d' AND date_format(log_time, '%m') = '$b' AND date_format(log_time, '%Y') = '$Y' AND log_tipe = '5' ORDER BY log_id DESC LIMIT 1 ")->result();

									foreach ($pem as $kue) {
									?>
									<div class="alert alert-costum4" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<span class="text-success"><b>Pembayaran</b> <?php echo $kue->log_desc; ?></span>
									</div>
									<?php }?>
								</div>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="panel panel-warning">
								<div class="panel-heading">
									<span class="text-size-22"><i class="fa fa-clone space-right-10"></i>Pelanggan Belum Bayar</span>
									<a href="<?php echo base_url('index.php/Admin/laporan_tagihan'); ?>" target="_blank" class="btn btn-danger pull-right"><span>Export</span></a>
								</div>
								<div class="panel-body">
									<?php  
									$this->db->where('status', 0);
									$rtp = $this->db->get('tagihan')->result();
									foreach ($rtp as $ala) {
										$pel = $ala->id_pelanggan;
										$this->db->where('id_pelanggan', $pel);
										$sh = $this->db->get('pelanggan')->result();
									?>
									<div class="alert alert-warning" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<span class=""><b>Tagihan</b> Pelanggan <?php echo $sh[0]->nama." belum membayar tagihan tanggal ".$ala->tgl_tagihan; ?> </span> 
									</div>
									<?php } ?>
								</div>
							</div>
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
					label: "Uang Yang Diterima (Semua Loket)",
					borderColor: window.chartColors.red,
					backgroundColor: window.chartColors.red,
					data: [
						<?php  
						$tahun = date("Y");
						$bulan = array("","01","02","03","04","05","06","07","08","09","10","11","12");

						for ($i=1; $i < 13; $i++) { 
							$db[$i] = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%m') = '$bulan[$i]' AND date_format(tglbayar, '%Y') = '$tahun'")->result();

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
</body>
<?php include "bottom.php"; ?>
</html>