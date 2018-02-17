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
	<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.1.1.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$.ajaxSetup({
				type:"POST",
				url: "<?php echo base_url('index.php/Admin/ambil_data') ?>",
				cache: false,
			});
			$("#provinsi").change(function(){
				var value=$(this).val();
				if(value>0){
				$.ajax({
				data:{modul:'kabupaten',id:value},
				success: function(respond){
						$("#kabupaten-kota").html(respond);
						}
					})
				}
			});
			$("#kabupaten-kota").change(function(){
				var value=$(this).val();
				if(value>0){
					$.ajax({
					data:{modul:'kecamatan',id:value},
					success: function(respond){
						$("#kecamatan").html(respond);
						}
					})
				}
			});
			$("#kecamatan").change(function(){
				var value=$(this).val();
				if(value>0){
					$.ajax({
					data:{modul:'kelurahan',id:value},
					success: function(respond){
						$("#kelurahan-desa").html(respond);
						}
					})
				} 
			});
});
	</script>
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
										<a href="" class="btn btn-danger" data-toggle="modal" data-target="#gardu" data-class=""><span>Tambah Gardu</span></a><br><br>

<div class="modal fade" id="gardu" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-danger" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span></span>
			</div>
			<div class="modal-body">
				<p class="text-center">
					<span class="text-size-24">Tambah Gardu</span><br>
				</p>
				<form method="POST" action="<?php echo base_url('index.php/Admin/gardu'); ?>">
					<div class="form-group">
						<label for="" style="color: #fcfdff;">Nama Jalan(Singkatan)</label>
						<input type="text" style="background: transparent; color: #fcfdff;  border-color: #fcfdff;" class="form-control input-lg" name="jln">
					</div>
					<div class="form-group">
						<label for="" style="color: #fcfdff;">Nama Gardu(Singkatan)</label>
						<input type="text" style="background: transparent; color: #fcfdff; border-color: #fcfdff;" class="form-control input-lg" name="grd">
					</div>
					<div class="form-group">
						<button class="btn btn-lg"  style="background: transparent; color: #fcfdff;  border-color: #fcfdff;" type="submit">Input</button>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</div>
</div>
										<form action="<?php echo base_url('index.php/Admin/input_pelanggan'); ?>" method="POST" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
											<div class="col-xs-12 col-md-6">
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
															<option value='0'>-- Pilih Kode Tarif --</option>
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
													<label class="col-sm-3 control-label">Provinsi</label>
													<div class="col-sm-6">
														<select class="form-control" id='provinsi' name="provinsi">
															<option value='0'>-- Pilih Provinsi --</option>
															<?php 
																foreach ($provinsi as $prov) {
																echo "<option value='$prov[id]'>$prov[name]</option>";
																}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Kabupaten</label>
													<div class="col-sm-6">
														<select class="form-control" name="kabupaten" id="kabupaten-kota" required="">
															<option value='0'>-- Pilih Kabupaten --</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Kecamatan</label>
													<div class="col-sm-6">
														<select class="form-control" required="" id="kecamatan" name="kecamatan">
															<option value='0'>-- Pilih Kecamatan --</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-xs-12 col-md-6">
												<div class="form-group">
													<label class="col-sm-3 control-label">Kelurahan</label>
													<div class="col-sm-6">
														<select required="" class="form-control" id="kelurahan-desa" name="kelurahan">
															<option value='0'>-- Pilih Kelurahan --</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Gardu</label>
													<div class="col-sm-6">
														<select required="" class="form-control" name="gardu">
															<option value='0'>-- Pilih Gardu --</option>
															<?php  
															$gar = $this->db->get('gardu')->result();
															foreach ($gar as $key) {
																echo '<option value="'.$key->id_gardu.'">'.$key->id_gardu.'-'.$key->nama_gardu.'-'.$key->kode_gardu.'-'.$key->jln.'</option>\n';
															}
															?>
														</select>
													</div>
												</div>	
												<div class="form-group">
													<label class="col-sm-3 control-label">Kode Pos</label>
													<div class="col-sm-6">
														<input type="text" name="kode_pos" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Alamat Lengkap</label>
													<div class="col-sm-6">
														<textarea class="form-control" name="alamat"></textarea>
													</div>
												</div>
											</div>
											<div class="col-xs-12">
												<div class="form-group">
													<div class="col-sm-7 control-label">
														<button type="submit" class="btn btn-primary btn-lg">Input</button>
														<button type="reset" class="btn btn-default btn-lg">Cancel</button>
													</div>
												</div>
											</div>
										</form>
										<div class="col-xs-12">
											
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
						<span class="text-size-24">Laporan Pelanggan</span><br>
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
						<span class="col-sm-3 text-size-18 text-left">Provinsi</span>
						<span class="col-sm-6 text-size-18">
									<b><?php echo $key->provinsi; 
									?></b>
						</span><br>
						<span class="col-sm-2"></span>
						<span class="col-sm-3 text-size-18 text-left">Kabupaten</span>
						<span class="col-sm-6 text-size-18">
									<b><?php echo $key->kabupaten_kota; 
									?></b>
						</span><br>
						<span class="col-sm-2"></span>
						<span class="col-sm-3 text-size-18 text-left">Kecamatan</span>
						<span class="col-sm-6 text-size-18">
									<b><?php echo $key->kecamatan; 
									?></b>
						</span><br>
						<span class="col-sm-2"></span>
						<span class="col-sm-3 text-size-18 text-left">Kelurahan</span>
						<span class="col-sm-6 text-size-18">
									<b><?php echo $key->kelurahan_desa; 
									?></b>
						</span><br>
						<span class="col-sm-2"></span>
						<span class="col-sm-3 text-size-18 text-left">Kode Pos</span>
						<span class="col-sm-6 text-size-18">
									<b><?php echo $key->kodepos; ?></b>
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