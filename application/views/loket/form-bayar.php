<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'css.php'; ?>
	<title>Floyd</title>
</head>
<body>
	<div id="wrapper">
		<?php include 'sidebar.php'; ?>
		<div id="main-panel">
			<?php include 'nav.php'; ?>
			<div id="content">
				<div class="container-fluid">
                    <center><h1>Form Pembayaran</h1></center><br>
					<div class="row">
                        <div class="col-md-12">
                            <form class="form-inline" method="get" action="<?php echo base_url('index.php/loket/search/'); ?>">
                            <div class="form-group">
                                <input type="text" placeholder="Masukkan ID PELANGGAN" class="form-control" name="id">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default">Cari</button>
                            </div>
                            </form>
                        </div>
					</div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            if ($number==1) {
                            ?>
                            <?php }elseif ($number==0) {
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <?php 
                                                  foreach ($name as $n) {
                                                ?>
                                                <form action="get" action="">
                                                <div class="form-group">
                                                    <label class="control-label">Kode Pelanggan :</label>
                                                    <label class="control-label"><b><?php echo $n->id_pelanggan; ?></b></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Nama Pelanggan :</label>
                                                    <label class="control-label"><b><?php echo $n->nama; ?></b></label>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" value="Buat Cetak Laporan Pelanggan" class="btn btn-info">
                                                </div>
                                                </form>
                                                <?php } ?>  
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="control-label">Daftar Tagihan Pelanggan Yang Belum Lunas :</label>
                                                </div>
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>ID TAGIHAN</th>
                                                            <th>TANGGAL TAGIHAN</th>
                                                            <th>PENGGUNAAN LISTRIK</th>
                                                            <th>BIAYA TAGIHAN</th>
                                                            <th>STATUS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $total = 0;
                                                        foreach ($data as $d) {
                                                        $total += $d->total_biaya;
                                                        $total_hrg = 0  + $total;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $d->id_tagihan; ?></td>
                                                            <td><?php echo $d->tgl_tagihan; ?></td>
                                                            <td><?php echo $d->pemakaian; ?></td>
                                                            <td>Rp <?php echo number_format($d->total_biaya,2,',','.'); ?></td>
                                                            <td><label class="label label-danger">Belum Lunas</label></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3">Total Tagihan :</td>
                                                            <td colspan="2">Rp <?php echo number_format($total_hrg,2,',','.'); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">Bayar :</td>
                                                            <td>Rp <input type="text" name="" style="width: 80%;"></td>
                                                            <td><button class="btn btn-red btn-theme" data-class="floyd-red">Bayar</button></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">Kembalian :</td>
                                                            <td>Rp <input type="text" name="" style="width: 80%;"></td>
                                                            <td><button class="btn btn-red btn-theme" data-class="floyd-red">Bayar</button></td>
                                                        </tr>
                                                    </tfoot>
                                                </table> <br>
                                                <label class="control-label">Daftar Tagihan Pelanggan Yang Sudah Lunas :</label>
                                                 <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>ID TAGIHAN</th>
                                                            <th>TANGGAL TAGIHAN</th>
                                                            <th>PENGGUNAAN LISTRIK</th>
                                                            <th>BIAYA TAGIHAN</th>
                                                            <th>STATUS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($lunas as $l) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $l->id_tagihan; ?></td>
                                                            <td><?php echo $l->tgl_tagihan; ?></td>
                                                            <td><?php echo $l->pemakaian; ?></td>
                                                            <td>Rp <?php echo number_format($l->total_biaya,2,',','.'); ?></td>
                                                            <td><label class="label label-success">Lunas</label></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>   
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php }  ?>
                        </div>  
                    </div>
				</div>
			</div>
		</div>
	</div>
</body>
<?php include 'bottom.php'; ?>
</html>