<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme-floyd.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme-helper.css">
	<title>Floyd</title>
	<style type="text/css">
	.gbr{
		background: url('<?php echo base_url('assets/logo.jpg'); ?>');
		background-size: cover;
		height: 250px;
		}
	</style>
</head>
<body>
	<div id="wrapper">
		<div class="container" style="padding: 5%">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-7">
			<center>
				<div class="gbr">
				
				</div>
				<div class="thumbnail" style="border-radius: 0px;">
					<div class="caption">
						<h1>Login</h1><br>	
							<form method="post" action="<?php echo base_url('index.php/login/proses/'); ?>">
						<div class="form-group">
							<input type="text" class="form-control input-lg" placeholder="Username" name="user">
						</div>

						<div class="form-group">
							<input type="password" class="form-control input-lg" placeholder="Password" name="password">
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-default btn-block" data-class="">Login</button>
						</div>
					</form>	
					</div>
				</div>		
			</center>
				</div>
				<div class="col-md-3"></div>
			</div>
		</div>
	</div>
</body>
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/theme-floyd.js"></script>
</html>