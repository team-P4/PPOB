<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'css.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/morris.css">">
	<?php include 'bottom.php'; ?>
	<script src="<?php echo base_url(); ?>assets/js/raphael.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/morris.min.js"></script>
			<script>
		// Menggunakan Morris.Line
		Morris.Line({
		 
		// ID Element dimana grafik ditempatkan
		element: 'grafik',
		 
		// Data dari chart yang akan ditampilkan
		data: [
		{ year: '2010', value: 20 },
		{ year: '2011', value: 10 },
		{ year: '2012', value: 5},
		{ year: '2013', value: 5},
		{ year: '2014', value: 20}
		],
		 
		// Sumbu X
		xkey: 'year',
		 
		// Sumbu Y
		ykeys: ['value'],
		 
		// Label
		labels: ['Value','x']
		});
		</script>
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
						<div id="grafik"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>