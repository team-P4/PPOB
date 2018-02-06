<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'css.php'; ?>
	<title>Pelanggan</title>
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
						<div class="panel-head">
							<h2 class="text-title">Daftar Pelanggan</h2>
						</div>
						<div class="panel-body">
							<form action="<?php echo base_url('index.php/Admin/del_pelanggan'); ?>" method="POST">
							<a href="" class="btn btn-warning"><span>Export</span></a>
							<table class="table table-bordered" id="myTable">
								<thead>
								    <tr class="danger">
								      	<TH>...</TH>
								      	<TH>NO.</TH>
								        <TH>Nama</TH>
								        <TH>Kode Tarif(Kwh)</TH>
								        <TH>Opsi</TH>
								    </tr>
							    </thead>
							    <tbody>
							    <?php  
							    $no = 1;
							    foreach ($pel as $key) {
							    ?>
								    <tr>
									     <th><input type="checkbox" name="pel[]" value="<?= $key->id_pelanggan ?>"></th>
									     <td><?php echo $no++; ?></td>
									     <td><?php echo $key->nama; ?></td>
									     <td align="center"><?php echo $key->kodetarif; ?></td>
									     <td align="center">
									      <a href="#" class="btn btn-floyd" data-toggle="modal" data-target="#myModal<?php echo $key->id_pelanggan; ?>" data-class="modal-default"><i class="fa fa-ellipsis-h"></i></a>
	<!-- modal -->
	<div class="modal fade" id="myModal<?php echo $key->id_pelanggan; ?>" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-default" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<span></span>
				</div>
				<div class="modal-body">
					<p class="text-center">
						<span class="text-size-32"><i class="fa fa-user-o fa-2x"></i></span><br><br>
						<span class="text-size-24">Detail Pelanggan <?php echo $key->nama; ?></span><br><br>
					</p>	
							<span class="col-sm-2"></span>
							<span class="col-sm-3 text-size-18 text-left">ID Pelanggan</span>
							<span class="col-sm-6 text-size-18">
										<b><?php echo $key->id_pelanggan; ?></b>
							</span><br>
							<span class="col-sm-2"></span>
							<span class="col-sm-3 text-size-18 text-left" align="left">Nama</span>
							<span class="col-sm-6 text-size-18">
										<b><?php echo $key->nama; ?></b>
							</span><br>
							<span class="col-sm-2"></span>
							<span class="col-sm-3 text-size-18 text-left">Kode Tarif</span>
							<span class="col-sm-6 text-size-18">
										<b><?php echo $key->kodetarif; ?></b>
							</span><br>
							<span class="col-sm-2"></span>
							<span class="col-sm-3 text-size-18 text-left">Loket</span>
							<span class="col-sm-6 text-size-18">
										<b><?php 
										$this->db->where('kode_pegawai', $key->kode_pegawai);
										$lol = $this->db->get('user')->result();
										foreach ($lol as $lue) {
											echo $lue->username;
										}
										?></b>
							</span><br>
							<span class="col-sm-2"></span>
							<span class="col-sm-3 text-size-18 text-left">Alamat</span>
							<span class="col-sm-6 text-size-18">
										<b><?php echo $key->alamat; ?></b>
							</span><br>
				</div>
				<div class="modal-footer"></div>
			</div>
		</div>
	</div>
								            </td>
								    </tr>
							    <?php } ?>
							    </tbody>
							</table>
							<div class="form-group">
								<input type="submit" class="btn btn-danger" name="hapus" value="Hapus">
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
<?php include 'bottom.php'; ?>
<script src="<?php echo base_url(); ?>assets/js/datatables.min.js"></script>
<script>
	$(document).ready(function(){
    $('#myTable').DataTable();
});
</script>
</html>