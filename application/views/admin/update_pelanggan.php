<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'css.php'; ?>
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
	<title>Update Pelanggan</title>
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
							<div class="panel-body">
								<p class="text-center">
									<span class="text-size-32"><i class="fa fa-user-o fa-2x"></i></span><br><br>
									<span class="text-size-24">Update Pelanggan</span><br><br>
								</p>
								<form action="<?php echo base_url('index.php/Admin/update_pelanggan'); ?>" method="POST" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
									<?php  
									foreach ($plg as $key) {
										$awl = $key->kodetarif;
									?>
									<div class="form-group">
										<label class="col-sm-3 control-label">ID Pelanggan</label>
										<div class="col-sm-6">
											<input type="text" name="id_pelanggan" class="form-control" value="<?= $key->id_pelanggan ?>" readonly>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Nama</label>
										<div class="col-sm-6">
											<input type="text" name="nama" class="form-control" value="<?= $key->nama ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Kode Tarif</label>
										<div class="col-sm-6">
											<!-- <input type="text" name="kodetarif" class="form-control"> -->
											<select class="form-control" id="select" name="kodetarif">
												<?php 
												$link = mysqli_connect('localhost','root','','ppob');
		                                        $query = mysqli_query($link,"SELECT * FROM tarif");
		                                        while ($data = mysqli_fetch_array($query)) { 
		                                        echo '<option value="'.$data['kode_tarif'].'"';
		                                                if( $data['kode_tarif'] ==  $key->kodetarif ) {
		                                                echo ' selected="selected"';
		                                                }
		                                                echo ' >'.$data['kode_tarif'].'</option>';
		                                        }?>
												?>
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
											<!-- <input type="text" name="kodetarif" class="form-control"> -->
											<select class="form-control" id="select" name="gardu">
												<option value="0">---- Pilih Gardu ----</option>
												<?php 
												$link = mysqli_connect('localhost','root','','ppob');
		                                        $query = mysqli_query($link,"SELECT * FROM gardu");
		                                        while ($data = mysqli_fetch_array($query)) { 
		                                        echo '<option value="'.$data['id_gardu'].'"';
		                                                if( $data['id_gardu'] ==  $key->id_gardu ) {
		                                                echo ' selected="selected"';
		                                                }
		                                                echo ' >'.$data['id_gardu'].'-'.$data['nama_gardu'].'-'.$data['kode_gardu'].'-'.$data['jln'].'</option>';
		                                        }?>
												?>
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Kode Pos</label>
										<div class="col-sm-6">
											<input type="text" name="kode_pos" class="form-control" value="<?php echo $key->kodepos; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Alamat</label>
										<div class="col-sm-6">
											<textarea class="form-control" name="alamat"><?php echo $key->alamat; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-5 control-label">
											<button type="submit" class="btn btn-primary">Update</button>
											<a href="<?php echo base_url('index.php/Admin/tpelanggan'); ?>" class="btn btn-default">Back</a>
										</div>
									</div>
									<?php } ?>
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
</html>