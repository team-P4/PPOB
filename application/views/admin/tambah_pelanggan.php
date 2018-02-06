<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'css.php'; ?>
	<title>Pelanggan</title>
	<style type="text/css">
	   .panel-heading a{float: right;}
	   #importFrm{margin-bottom: 20px;display: none;}
	   #importFrm input[type=file] {display: inline;}
	</style>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datatables.min.css">
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
							<div class="panel panel-default">
								<div class="panel-body">
									<center><span class="text-size-22"><i class="fa fa-user-o space-right-10"></i>Tambah Pelanggan</span></center><br> <br>
									<div class="col-md-12">	
										<form action="<?php echo base_url('index.php/Admin/input_pelanggan'); ?>" method="POST" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
											<div class="form-group">
												<label class="col-sm-3 control-label">Nama</label>
												<div class="col-sm-6">
													<input type="text" name="nama" class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label">Kode Tarif</label>
												<div class="col-sm-6">
													<!-- <input type="text" name="kodetarif" class="form-control"> -->
													<select class="form-control" name="kodetarif">
														<?php 
														$tarif = $this->db->get('tarif')->result();
														foreach ($tarif as $key) {
															echo '<option value="'.$key->kode_tarif.'">'.$key->kode_tarif.'</option>\n';
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label">Loket</label>
												<div class="col-md-6">
													<select class="form-control" name="id">
														<?php  
														$this->db->where('level', 'loket');
														$query = $this->db->get('user')->result();

														foreach ($query as $key) {
															echo '<option value="'.$key->kode_pegawai.'">'.$key->username.'</option>\n';
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label">Alamat</label>
												<div class="col-sm-6">
													<textarea class="form-control" name="alamat"></textarea>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-5 control-label">
													<button type="submit" class="btn btn-primary">Input</button>
													<button type="reset" class="btn btn-default">Cancel</button>
												</div>
											</div>
										</form>
										<center><span class="text-size-22"><i></i>Or</span></center><br><br>
										<center><span class="text-size-22"><i class="fa fa-bars space-right-10"></i>Import Pelanggan</span></center><br> <br> 
										<div class="panel-heading">
							                Members list
							                <a href="javascript:void(0);" onclick="$('#importFrm').slideToggle();">Import Members</a>
							            </div>
							            <div class="panel-body">
							                <form action="<?php echo base_url('index.php/Import/import_pel'); ?>" method="POST" enctype="multipart/form-data" id="importFrm">
							                    <input type="file" name="file" id="file">
							                    <input type="submit" class="btn btn-primary" id="submit" name="import" value="IMPORT">
							                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#myModalkk" data-class="">EXPORT</a>

<div class="modal fade" id="myModalkk" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<span></span>
				</div>
				<div class="modal-body">
					<p class="text-center">
						<span class="text-size-32"><i class="fa fa-file-o fa-2x"></i></span><br><br>
						<span class="text-size-24">Laporan Loket</span><br>
						<span>Ada dua pilihan untuk cetak laporan</span><br>
						<span>Excel, Untuk mencetak laporan dengan ekstensi .xlsx</span><br>
						<span> Dan PDF, Untuk mencetak laporan dengan ekstensi .pdf</span>
					</p>
				</div>
				<div class="modal-footer">
					<center><a href="<?php echo base_url('index.php/Import/export_pelanggan_xlsx'); ?>" class="btn btn-default"><i class="fa fa-file-excel-o"></i><span> Excel</span></a><a href="<?php echo base_url('index.php/Import/export_pelanggan_pdf'); ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i><span> PDF</span></a></center>
				</div>
			</div>
		</div>
	</div>
							                    <a href="<?php echo base_url('index.php/Admin/d_pelanggan'); ?>" class="btn btn-success">Download Template(.xlsx)</a>
							                </form>
							                <form action="<?php echo base_url('index.php/Admin/del_pelanggan'); ?>" method="POST">
							                <table class="table table-bordered" id="myTable">
							                    <thead>
							            	        <tr class="danger">
							            	        	<TH>...</TH>
							            	        	<TH>NO.</TH>
							                            <TH>Nama</TH>
							                            <TH>Kode Tarif</TH>
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
							                    		<td><?php echo $key->kodetarif; ?></td>
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
							                    			<a href="<?php echo base_url('index.php/Admin/edit_pelanggan/').$key->id_pelanggan; ?>" class="btn btn-info"><i class="fa fa-circle-o-notch"></i></a>
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