<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<center>
	<h1>PPOB</h1>
	<b>Terus Menyala, Menyala Terus</b><br>
	...............<br>
	<hr width="100%" height="75"></hr><br>
</center>
<table border="1">
	<tr>
		<th align="center">ID Pembayaran</th>
		<th align="center">Nama Pelanggan</th>
		<th align="center">Jumlah Tagihan(Rp.)</th>
		<th align="center">Biaya PLN(Rp.)</th>
		<th align="center">Biaya Loket(Rp.)</th>
		<th align="center">Total Keseluruhan(Rp.)</th>
		<th align="center">Yang dibayar(Rp.)</th>
		<th align="center">Status</th>
		<th align="center">Tanggal Bayar</th>
	</tr>
	<?php  
	foreach ($trk as $key) {
	?>
	<tr>
		<td><?php echo $key->id_pembayaran; ?></td>
		<td><?php $this->db->where('id_pelanggan', $key->id_pelanggan);
				  $data = $this->db->get('pelanggan')->result();
			echo $data[0]->nama;	  
			 ?></td>
		<td align="right"><?php echo number_format($key->jml_tagihan,2,',','.'); ?></td>
		<td align="right"><?php echo number_format($key->biaya_pln,2,',','.'); ?></td>
		<td align="right"><?php echo number_format($key->biaya_loket,2,',','.'); ?></td>
		<td align="right"><?php echo number_format($key->total,2,',','.'); ?></td>
		<td align="right"><?php echo number_format($key->uang_bayar,2,',','.'); ?></td>
		<td><?php echo $key->status; ?></td>
		<td><?php echo $key->tglbayar; ?></td>
	</tr>
	<?php } ?>
</table>
</body>
</html>