<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css">
	<title></title>
	<style type="text/css">
		@media print
		{    
		    .no-print, .no-print *
		    {
		        display: none !important;
		    }
		}
	</style>
</head>
<body>
<br>
<button class="btn btn-info btn-lg no-print" id="cetak" onclick="myFunction(), redirect()">Cetak</button><br><br>
<?php
	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}

	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}

foreach ($pemb as $key) {
 ?>
<div id="ctk">
	<h4>PT PPOB Tbk</h4>
	<center>
		<h3>STRUK PEMBAYARAN TAGIHAN LISTRIK</h3>
	</center>
	<table>
		<tr>
			<td>IDPEL</td>
			<td>:</td>
			<td><?php echo $key->id_pelanggan; ?></td>
			<td>BL/TH</td>
			<td>:</td>
			<td align="center"><?php echo $key->tgl_tagihan; ?></td>
		</tr>
		<tr>
			<td>NAMA</td>
			<td>:</td>
			<td><?php
			$this->db->where('id_pelanggan', $key->id_pelanggan); 
			$nama = $this->db->get('pelanggan')->result();
			echo $nama[0]->nama; ?></td>
			<td>STAND METER</td>
			<td>:</td>
			<td align="center"><?php echo $key->pemakaian; ?></td>
		</tr>
		<tr>
			<td>TARIF/DAYA</td>
			<td>:</td>
			<td align="right" style=""><?php 
			$this->db->where('kode_tarif', $key->kode_tarif);
			$tarif = $this->db->get('tarif')->result();
			echo number_format($tarif[0]->tarifperkwh,2,',','.');
			?></td>
		</tr>
		<tr>
			<td>RP TAG PLN</td>
			<td>:</td>
			<td align="right"><?php echo number_format($key->biaya_pln,2,',','.'); ?></td>
		</tr>
		<tr>
			<td>BIAYA LOKET</td>
			<td>:</td>
			<td align="right"><?php echo number_format($key->biaya_loket,2,',','.'); ?></td>
		</tr>
		<tr>
			<th>TOTAL BAYAR</th>
			<th>:</th>
			<th align="right"><?php echo number_format($key->total,2,',','.'); ?></th>
		</tr>
	</table>
	<center>
		Terima Kasih <br>
		"Informasi Hubungi Call Center 123 Atau Hub PLN Terdekat :"
	</center><br>
	<table>
		<tr>
			<th>TERBILANG</th>
			<th>:</th>
			<th align="left">&nbsp<?php echo  strtoupper(terbilang($key->total)); ?> RUPIAH</th>
		</tr>
		<tr>
			<th>DICETAK DI</th>
			<th>:</th>
			<th>&nbsp<?php 
			$this->db->where('kode_pegawai', $key->id_loket);
			$nama_lok = $this->db->get('user')->result();
			echo strtoupper($nama_lok[0]->username);
			?></th>
		</tr>
		<tr>
			<th>TANGGAL</th>
			<th>:</th>
			<th>&nbsp<?php echo $key->tglbayar; ?></th>
		</tr>
	</table><br>
	<hr width="">
</div>
<?php } ?>
<?php $this->load->view('loket/bottom'); ?>
<script>
 	function myFunction() {
	    window.print();
	    window.close();
	}
</script>
</body>
</html>