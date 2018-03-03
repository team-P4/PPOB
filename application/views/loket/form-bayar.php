<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'css.php'; ?>
	<title>Floyd</title>
    <style type="text/css">
        .btn-custom1{
            background-color: #099CEB;
            border-color: #099CEB;

            color: #f9f7f7;
        }
        .btn-custom1:hover{
            color: #f9f7f7;
        }
        .alert-costum5 {
            background-color: #f9f7f7;
            border-color: #ff0000;
            color: #ff0000;
        }
        .panel-custom78.panel-fill {
            border-color: #bdbebf;
            background-color: #bdbebf;
        }
    </style>
</head>
<body>
	<div id="wrapper">
		<?php include 'sidebar.php'; ?>
		<div id="main-panel">
			<?php include 'nav.php'; ?>
			<div id="content">
				<div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel panel-info panel-fill">
                                <div class="panel-heading">
                                    <span class="text-size-22"><i class="fa fa-clone space-right-10"></i>Saldo</span>
                                </div>
                                <div class="panel-body">
                                    <p class="break-top-10 text-size-16">Rp. <?php $kosong = array('kode_pegawai' => $this->session->userdata('kode_pegawai') );
                                            $ia = $this->mod_admin->tampil_di('user',$kosong);

                                            $saldo = $ia[0]->saldo; 
                                            echo number_format($saldo,2,',','.'); ?> ,-</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-danger panel-fill">
                                <div class="panel-heading">
                                    <span class="text-size-22"><i class="fa fa-clone space-right-10"></i>Keuntungan Bulan Ini</span>
                                </div>
                                <div class="panel-body">
                                   <?php  
                                   $this->db->select('SUM(biaya_loket) as biaya_loket');
                                   $this->db->where("date_format(tglbayar, '%m') =", date('m'));
                                   $this->db->where("date_format(tglbayar, '%Y') =", date('Y'));
                                   $data1 = $this->db->get('pembayaran')->result();
                                   ?>
                                    <p class="break-top-10 text-size-16">Rp. <?php echo number_format($data1[0]->biaya_loket,2,',','.'); ?>,-</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-success panel-fill">
                                <div class="panel-heading">
                                    <span class="text-size-22"><i class="fa fa-clone space-right-10"></i>Uang Terima Bulan Ini</span>
                                </div>
                                <div class="panel-body">
                                   <?php  
                                   $this->db->select('SUM(total) as total');
                                   $this->db->where("date_format(tglbayar, '%m') =", date('m'));
                                   $this->db->where("date_format(tglbayar, '%Y') =", date('Y'));
                                   $data2 = $this->db->get('pembayaran')->result();
                                   ?>
                                    <p class="break-top-10 text-size-16">Rp. <?php echo number_format($data2[0]->total,2,',','.'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <section class="content">
                        <div>
                            <?php echo $this->session->flashdata('pesan'); ?>
                        </div>
                    </section>
					<div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal group-border-dashed" method="get" action="<?php echo base_url('index.php/loket/search/'); ?>">
                                <div class="form-group">
                                    <!-- <input type="text" placeholder="Masukkan ID PELANGGAN" class="form-control" name="id"> -->
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Masukkan ID PELANGGAN" name="id" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-lg btn-custom1"><b>Cari</b></button>
                                    </div>
                                </div>
                            </form>
                        </div>
					</div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            if ($number==1) {
                            ?>
                            <div class="panel panel-custom78 panel-fill">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Tutorial Pembayaran PPOB</h3>
                                </div>
                                <div class="panel-body">
                                    <p class="text-size-16">
                                        1. Klik pembayaran yang ada di Sidebar sebelah kiri <br>
                                        2. Cari daftar tagihan di Pencarian yang telah disediakan <br>
                                        3. Jika pelanggan memiliki tagihan yang belum dibayar maka akan tampil di form pembayaran <br>
                                        4. Kemudian inputkan uang yang dibayarkan di Inputan yang sudah disediakan <br>
                                        5. Lalu Klik Bayar, untuk membayar semua tagihan yang ada <br>
                                        6. Struk akan muncul otomatis <br>
                                    </p>
                                </div>
                            </div>
                            <?php }elseif ($number==0) {
                                 $where21 = array('id_pelanggan' => $id,
                                                'status' => 0 );
                                $il = $this->db->get_where('tagihan', $where21)->result();
                                $where1 = array('id_pelanggan' => $id);
                                $where2 = array('id_pelanggan' => $id,
                                                'status' => 0 );
                                $ala = $this->db->get_where('tagihan', $where1)->result();
                                $ili = $this->db->get_where('tagihan', $where2)->result();
                                if (count($ala) != 0) {
                                    if (count($ili) >= 3) {
                                        $this->db->where('id_pelanggan', $id);
                                        $am = $this->db->get('pelanggan')->result();
                                    echo '<div class="panel panel-default panel-fill">
                                              <div class="panel-body">
                                              <center>
                                              <span class="text-size-32"><i class="fa fa-bullhorn fa-2x"></i></span><br><br>
                                              <span class="text-size-32">Maaf !!</span><br>
                                              <span class="text-size-18">Pelanggan <b>'.$am[0]->nama.'</b> memiliki 3 tagihan yang belum terbayarkan... jika ingin melunasinya, anda bisa ke PLN nya langsung</span>
                                              </center>
                                              <br><br><br><br><br>
                                              </div>
                                          </div>
                                   ';
                                        } else {
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form action="<?php echo base_url('index.php/loket/tambah_pembayaran'); ?>" method="POST" target="_blank">
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
                                                    <a href="<?php  echo base_url("index.php/Import/cetak_pelanggan/").$n->id_pelanggan; ?>" class="btn btn-info" target="_blank" >Buat Cetak Laporan Pelanggan</a>
                                                </div>
                                                </form>
                                                <?php } ?>  
                                            </div>
                                            <div class="col-md-9">
                                                <?php  
                                                if (count($il) != 0) {
                                                ?>
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
                                                        $total_hrg = 0;
                                                        $total1 = 0;
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
                                                            <td align="right"><input type="text" id="bayar" placeholder="Isi uang pembayaran disini" name="bayar" style="border: none;background: none; text-align: right;"></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">Kembalian </td>
                                                            <td colspan="1" align="right">
                                                                <input type="text" style="border: none;background: none; text-align: right;" id="hasil_uang" >
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5" align="right"><button class="btn btn-lg btn-red btn-theme" onclick="reload()" data-class="floyd-red">Bayar</button></td>
                                                        </tr>
                                                    </tfoot>
                                                </table> <br>
                                                <?php }
                                                $where4 = array('id_pelanggan' => $id,
                                                                'status' => 1 );
                                                $lul = $this->db->get_where('tagihan', $where4)->result();

                                                if (count($lul) != 0) {
                                                ?>
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
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php }
                                } else{

                            echo '<div class="panel panel-default panel-fill alert" role="alert">
                                      <div class="panel-body">
                                      <center>
                                      <span class="text-size-32"><i class="fa fa-bullhorn fa-2x"></i></span><br><br>
                                      <span class="text-size-24">Maaf !!</span><br>
                                      <span>ID Pelanggan yang anda cari tidak ada, Mohon cek kembali</span>
                                      </center>
                                      </div>
                                  </div>
                                  <div class="panel panel-custom78 panel-fill">
                                      <div class="panel-heading">
                                          <h3 class="panel-title">Tutorial Pembayaran PPOB</h3>
                                      </div>
                                      <div class="panel-body">
                                          <p class="text-size-16">
                                              1. Klik pembayaran yang ada di Sidebar sebelah kiri <br>
                                              2. Cari daftar tagihan di Pencarian yang telah disediakan <br>
                                              3. Jika pelanggan memiliki tagihan yang belum dibayar maka akan tampil di form pembayaran <br>
                                              4. Kemudian inputkan uang yang dibayarkan di Inputan yang sudah disediakan <br>
                                              5. Lalu Klik Bayar, untuk membayar semua tagihan yang ada <br>
                                              6. Struk akan muncul otomatis <br>
                                          </p>
                                      </div>
                                  </div>
                           ';
                                }
                             }  ?>
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
    <script type="text/javascript">
        function reload() {
           // window.location.reload();
           window.location.href= "<?php echo base_url('index.php/loket/noc/'.$name[0]->id_pelanggan) ?>";
        }
    </script>
    <script type="text/javascript">
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 4000);
    </script>
</body>
</html>