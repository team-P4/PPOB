<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "css.php"; ?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datatables.min.css">
	<title>Admin</title>
	
</head>
<body>
	<div id="wrapper">
		<?php include 'sidebar.php'; ?>
		<div id="main-panel">
			<?php include 'nav.php'; ?>
			<div id="content">
				<div class="container-fluid">
					<div class="panel panel-default">
						<div class="panel-body">
							<table class="table table-bordered" id="myTable">
							<thead>
							        <tr class="danger">
							        	<TH>NO.</TH>
							            <TH>Nama</TH>
							            <TH>Kode Tarif</TH>
							            <th>Tanggal</th>
							            <TH>Opsi</TH>
				                    </tr>
						    </thead>
						    <tbody>
						       	<?php  
						           	$no = 1;
						           	foreach ($data as $key) {
						       	?>
						       
						           	<tr>
						           	<form method="post" action="<?php echo base_url('index.php/Admin/input_tagihan/').$key->id_pelanggan; ?>">
						           		<td><?php echo $key->id_pelanggan; ?></td>
						           		<td><?php echo $key->nama; ?></td>
						          		<td><?php echo $key->kodetarif; ?></td>
						          		<td><input type="date" name="tgl"></td>
						           		<td>
						           				<input type="hidden" name="kode" value="<?php echo $key->kodetarif; ?>">
						              			<input type="submit" class="btn btn-primary" value="Buat Tagihan!">
						           		</td>
						           	</form>
						           	</tr>
						       	<?php } ?>
						    </tbody>
				    </table>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include "bottom.php"; ?>
<script src="<?php echo base_url(); ?>assets/js/datatables.min.js"></script>
<script>
	$(document).ready(function(){
    $('#myTable').DataTable();
});
</script>
</body>
</html>