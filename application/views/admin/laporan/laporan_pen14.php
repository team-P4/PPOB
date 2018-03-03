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
		<th align="left">ID Loket</th>
		<th align="center">Nama Loket</th>
		<th align="center"><?= $tahun."-".$bulan."-".$hari ?></th>
	</tr>
	<?php 
	$sum = 0; 
	$this->db->where('level', 'loket');
	$pen14 = $this->db->get('user')->result();

	foreach ($pen14 as $key) {
		$has = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m')='$bulan' AND date_format(tglbayar, '%Y')='$tahun' AND id_loket='$key->kode_pegawai' ")->result();
		$sum += $has[0]->total;
	?>
	<tr>
		<td align="left"><?= $key->kode_pegawai ?></td>
		<td align="center"><?= $key->username ?></td>
		<td align="right"><?= $has[0]->total ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="2" align="center">Total</td>
		<td align="right"><?= $sum ?></td>
	</tr>
</table>
</body>
</html>