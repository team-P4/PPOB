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
		<th align="center">ID Loket</th>
		<th align="center">Nama Loket</th>
		<th align="center">Tanggal</th>
		<th align="center">Pendapatan(Rp.)</th>
	</tr>
	<?php  
	$total = 0;
	$this->db->where('kode_pegawai', $loket);
	$pen10 = $this->db->get('user')->result();

	foreach ($pen10 as $key) {
	?>
	<tr>
		<td align="left"><?= $key->kode_pegawai ?></td>
		<td align="center"><?= $key->username ?></td>
		<td align="center"><?= $tahun."-".$bulan."-".$hari ?></td>
		<?php  
		$has = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m')='$bulan' AND date_format(tglbayar, '%Y')='$tahun' AND id_loket='$loket' ")->result();
		echo '<td align="right">'.number_format($has[0]->total,2,',','.').'</td>';
		$total += $has[0]->total;
		?>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="3" align="center">Total</td>
		<td align="right"><?= number_format($total,2,',','.') ?></td>
	</tr>
</table>
</body>
</html>