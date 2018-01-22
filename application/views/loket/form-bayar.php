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
                            <form class="form-inline">
                            <div class="form-group">
                                <input type="text" placeholder="Masukkan ID PELANGGAN" class="form-control" name="">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default">Cari</button>
                            </div>
                            </form>
                        </div>
					</div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Kode Pelanggan :</label>
                                                    <label class="control-label"><b>PL0912678</b></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Nama Pelanggan :</label>
                                                    <label class="control-label"><b>Dika</b></label>
                                                </div>  
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="control-label">Daftar Tagihan Pelanggan :</label>
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
                                                        <tr>
                                                            <td>TG98712</td>
                                                            <td>01/11/2017</td>
                                                            <td>450 Kwh</td>
                                                            <td>Rp 300.000,-</td>
                                                            <td><label class="label label-danger">Belum Lunas</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td>TG68123</td>
                                                            <td>01/12/2017</td>
                                                            <td>500 Kwh</td>
                                                            <td>Rp 350.000,-</td>
                                                            <td><label class="label label-danger">Belum Lunas</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td>TG72365</td>
                                                            <td>01/12/2017</td>
                                                            <td>400 Kwh</td>
                                                            <td>Rp 250.000,-</td>
                                                            <td><label class="label label-danger">Belum Lunas</label></td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3">Total Tagihan :</td>
                                                            <td colspan="2">Rp 900.000,-</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">Bayar :</td>
                                                            <td>Rp <input type="text" name=""></td>
                                                            <td><button class="btn btn-red btn-theme" data-class="floyd-red">Bayar</button></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>    
                                            </div>
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
</body>
<?php include 'bottom.php'; ?>
</html>