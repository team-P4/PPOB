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
</head>
<body>
	<div id="wrapper">
		<div class="container" style="padding: 10%">
			<div class="panel panel-default" style="padding: 5%;">
				<div class="panel-heading">
					<h3>Login Page</h3>
				</div>
				<div class="panel-body">
					<form>
						<div class="form-group">
							<input type="text" class="form-control input-lg" placeholder="Username" name="">
						</div>

						<div class="form-group">
							<input type="text" class="form-control input-lg" placeholder="Password" name="">
						</div>
						<div class="form-group">
							<button class="btn btn-default btn-block" data-class="">Default</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/theme-floyd.js"></script>
</html>