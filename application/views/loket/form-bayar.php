<?php error_reporting(0); ?>
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
                                    <form action="<?php echo base_url('index.php/loket/tambah_pembayaran'); ?>" method="POST">
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
                                                            <th>BIAYA TAGIHAN (Rp.)</th>
                                                            <th>STATUS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $total = 0;
                                                        foreach ($data as $d) {
                                                            $total += $d->total_biaya;
                                                            $total1 =  0  + $total;
                                                            $total_hrg = 0  + $total + 5000 + 2500;
                                                        ?>
                                                        <tr>
                                                            <td><input type="hidden" name="list[]" value="<?php echo $d->id_tagihan; ?>"><?php echo $d->id_tagihan; ?></td>
                                                            <td align="center"><?php echo $d->tgl_tagihan; ?></td>
                                                            <input type="hidden" name="id">
                                                            <td align="right"><?php echo $d->pemakaian; ?></td>
                                                            <td align="right"><?php echo number_format($d->total_biaya,2,',','.'); ?></td>
                                                            <td><label class="label label-danger">Belum Lunas</label></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3">Biaya PLN</td>
                                                            <td colspan="1" align="right"><input type="hidden" name="biaya_pln" value="5000"><?php echo number_format(5000,2,',','.'); ?></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">Biaya Loket</td>
                                                            <td colspan="1" align="right"><input type="hidden" name="biaya_loket" value="2500"><?php echo number_format(2500,2,',','.'); ?></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">Total Tagihan </td>
                                                            <td colspan="1" align="right"><?php echo number_format($total_hrg,2,',','.'); ?>

                                                                <!-- input hidden -->
                                                                <input type="hidden" name="id_pelanggan" value="<?php 
                                                                foreach($name as $n){
                                                                    echo $n->id_pelanggan;
                                                                }
                                                                ?>">
                                                                <input type="hidden" name="jumlah_tagihan" value="<?php echo $total1; ?>"></td>
                                                                <input type="hidden" name="biaya_total1" id="total2" value="<?php echo $total_hrg; ?>"></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">Bayar </td>
                                                            <td align="right"><input type="text" id="bayar" name="bayar" style="border: none;background: none; text-align: right;"></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">Kembalian </td>
                                                            <td colspan="1" align="right">
                                                                <input type="text" style="border: none;background: none; text-align: right;" id="hasil_uang" >
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5" align="right"><button class="btn btn-lg btn-red btn-theme" data-class="floyd-red">Bayar</button></td>
                                                        </tr>
                                                    </tfoot>
                                                </table> <br>
                                                <label class="control-label">Daftar Tagihan Pelanggan Yang Sudah Lunas :</label>
                                                 <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>ID TAGIHAN</th>
                                                            <th>TANGGAL TAGIHAN</th>
                                                            <th>PENGGUNAAN LISTRIK(Kwh)</th>
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
                                                            <td align="center"><?php echo $l->tgl_tagihan; ?></td>
                                                            <td><?php echo $l->pemakaian; ?></td>
                                                            <td align="right">Rp <?php echo number_format($l->total_biaya,2,',','.'); ?></td>
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
<?php include 'bottom.php'; ?>
<script type="text/javascript">
        $(document).ready(function(){
            $("form").prop('autocomplete', 'on');
        });

        function formatNumber(s) {
          var parts = s.split(/,/)
            , spaced = parts[0]
                 .split('').reverse().join('') // Reverse the string.
                 .match(/\d{1,3}/g).join('.') // Join groups of 3 digits with spaces.
                 .split('').reverse().join(''); // Reverse it back.
          return spaced + (parts[1] ? ','+parts[1] : ''); // Add the fractional part.
        }

        $("#bayar").keyup(function(){

            // if(event.which >= 37 && event.which <= 40) return;

            // $(this).val(function(index, value) {
            //     return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            // });
            // var $this = $(this);
            // $this.val(formatNumber($this.val()));

            var bayar = parseInt($(this).val());

            var total2 = $('#total2').val();

            $("#hasil").val(bayar - total2); 
            var format = (bayar - total2);
            // $("#potongan_insert").val(potongan);

            $('#hasil_uang').val(accounting.formatMoney(format));
        });
    </script>
</body>
</html>