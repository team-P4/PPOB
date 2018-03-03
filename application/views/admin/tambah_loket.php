<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "css.php"; ?>
	<title>Tambah Loket</title>
	<style type="text/css">
	   .panel-heading a{float: right;}
	   #importFrm{margin-bottom: 20px;display: none;}
	   #importFrm input[type=file] {display: inline;}
	</style>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datatables.min.css">
</head>
<body>
	<div id="wrapper">
		<?php include "sidebar.php"; ?>
		<div id="main-panel">
			<?php include 'nav.php'; ?>
			<div id="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<center><span class="text-size-22"><i class="fa fa-user-o space-right-10"></i>Tambah Loket</span></center><br> <br> 
									<?php echo $this->session->flashdata('pesan'); ?>
									<div class="col-md-12">	
										<form action="<?php echo base_url('index.php/Admin/input_loket'); ?>" method="POST" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
											<div class="form-group">
												<label class="col-sm-3 control-label">Username</label>
												<div class="col-sm-6">
													<input type="text" name="username" class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label">Password</label>
												<div class="col-sm-6">
													<input type="password" name="password" class="form-control">
													<input type="hidden" name="level" value="loket">
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
										<center><span class="text-size-22"><i class="fa fa-bars space-right-10"></i>Import Loket</span></center><br> <br> 
										<div class="panel-heading">
							                Members list
							                <a href="javascript:void(0);" onclick="$('#importFrm').slideToggle();">Import Members</a>
							            </div>
							            <div class="panel-body">
							                <form action="<?php echo base_url('index.php/Import/import'); ?>" method="POST" enctype="multipart/form-data" id="importFrm">
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
					<center><a href="<?php echo base_url('index.php/Import/export_loket_xlsx'); ?>" class="btn btn-default"><i class="fa fa-file-excel-o"></i><span> Excel</span></a><a href="<?php echo base_url('index.php/Import/export_loket_pdf'); ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i><span> PDF</span></a></center>
				</div>
			</div>
		</div>
	</div>
							                    <a href="<?php echo base_url('index.php/Admin/d_loket'); ?>" class="btn btn-success">Download Template(.xlsx)</a>
							                </form>
							                <form action="<?php echo base_url('index.php/Admin/del_loket'); ?>" method="POST">
							                <table class="table table-bordered" id="myTable">
							                    <thead>
							            	        <tr class="danger">
							            	        	<TH>...</TH>
							            	        	<TH>NO.</TH>
							                            <TH>Username</TH>
							                            <TH>Opsi</TH>
							                        </tr>
							                    </thead>
							                    <tbody>
							                    	<?php  
							                    	$no =1;
							                    	foreach ($loket as $key) {
							                    	?>
							                    	<tr>
							                    		<td><input type="checkbox" name="list[]" value="<?php echo $key->id; ?>"></td>
							                    		<td><?php echo $key->kode_pegawai; ?></td>
							                    		<td><?php echo $key->username; ?></td>
							                    		<td align="center">
							                    			<a href="#" title="Detail" class="btn btn-floyd" data-toggle="modal" data-target="#myModal<?php echo $key->id; ?>" data-class="modal-default"><i class="fa fa-ellipsis-h"></i></a>
<!-- modal -->
<div class="modal fade" id="myModal<?php echo $key->id; ?>" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-default" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span></span>
			</div>
			<div class="modal-body">
				<p class="text-center">
					<span class="text-size-32"><i class="fa fa-building-o fa-2x"></i></span><br><br>
					<span class="text-size-24">Loket <?php echo $key->username; ?></span><br><br>
				</p>
						<span class="col-sm-2"></span>
						<span class="col-sm-3 text-size-18 text-left">ID</span>
						<span class="col-sm-6 text-size-18">
									<b><?php echo $key->kode_pegawai; ?></b>
						</span><br>
						<span class="col-sm-2"></span>
						<span class="col-sm-3 text-size-18 text-left" align="left">Username</span>
						<span class="col-sm-6 text-size-18">
									<b><?php echo $key->username; ?></b>
						</span><br>
						<span class="col-sm-2"></span>
						<span class="col-sm-3 text-size-18 text-left">Password</span>
						<span class="col-sm-6 text-size-18">
									<b><?php echo $key->password; ?></b>
						</span><br>
						<span class="col-sm-2"></span>
						<span class="col-sm-3 text-size-18 text-left">Saldo</span>
						<span class="col-sm-6 text-size-18">
									<b>Rp. <?php echo number_format($key->saldo,2,',','.'); ?>,-</b>
						</span><br>
						<span class="col-sm-2"></span>
						<span class="col-sm-3 text-size-18 text-left">Level</span>
						<span class="col-sm-6 text-size-18">
									<b><?php echo $key->level; ?></b>
						</span><br>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

							                    			<a href="<?php echo base_url('index.php/Admin/edit_loket/').$key->id; ?>" title="Edit" class="btn btn-info"><i class="fa fa-circle-o-notch"></i></a>
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
<script type="text/javascript">
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 4000);
</script>
</html>