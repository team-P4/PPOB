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
		<th align="center">Pelanggan</th>
		<th align="center">Loket</th>
		<th align="center">Status</th>
		<th align="center">Tanggal</th>
		<th align="center">Total Semua(Rp.)</th>
		<th align="center">Yang dibayar(Rp.)</th>
	</tr>
	<?php
	$total = 0;  
	foreach ($pen as $key) {
	$total +=  $key->total;
	?>
	<tr>
		<td><?php echo $key->id_pembayaran; ?></td>
		<td><?php 
				  $this->db->where('id_pelanggan', $key->id_pelanggan);
				  $data = $this->db->get('pelanggan')->result();
			echo $data[0]->nama;	  
		?></td>
		<td><?php  
				  $this->db->where('kode_pegawai', $key->id_loket);
				  $data = $this->db->get('user')->result();
			echo $data[0]->username; 
		?></td>
		<td><?php echo $key->status; ?></td>
		<td><?php echo $key->tglbayar; ?></td>
		<td align="right"><?php echo number_format($key->total,2,',','.'); ?></td>
		<td align="right"><?php echo number_format($key->uang_bayar,2,',','.'); ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td>Total Keselurahan</td>
		<td colspan="5" align="right"><?php echo number_format($total,2,',','.'); ?></td>
		<td></td>
	</tr>
</table>
</body>
</html>