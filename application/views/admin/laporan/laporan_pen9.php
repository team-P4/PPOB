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
		<?php  
		 $month = array('01' => 'Jan', '02' => 'Feb', '03' => 'Marc', '04' => 'April', '05' => 'Mey', '06' => 'Jun', '07' => 'July', '08' => 'Agust', '09' => 'Sept', '10' => 'Okt', '11' => 'Nov', '12' => 'Des');
		foreach ($month as $bu => $u) {
			echo '<th align="center">'.$hari.' '.$u.' '.$tahun.'</th>';
		}
		?>
		<th align="center">Total</th>
	</tr>
	<?php  
	$sb_t = 0;
	$this->db->where('level', 'loket');
	$pen9 = $this->db->get('user')->result();
	foreach ($pen9 as $key) {
	?>
	<tr>
		<td align="center"><?= $key->kode_pegawai ?></td>
		<td align="center"><?= $key->username ?></td>
		<?php  
		$sum = 0;
		 $month = array('01' => 'Jan', '02' => 'Feb', '03' => 'Marc', '04' => 'April', '05' => 'Mey', '06' => 'Jun', '07' => 'July', '08' => 'Agust', '09' => 'Sept', '10' => 'Okt', '11' => 'Nov', '12' => 'Des');
		foreach ($month as $bu => $u) {
			$has = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m')='$bu' AND date_format(tglbayar, '%Y')='$tahun' AND id_loket='$key->kode_pegawai' ")->result();
			echo '<td align="center">'.number_format($has[0]->total,2,',','.').'</td>';
			$sum += $has[0]->total;
		} $sb_t += $sum;
		?>
		<td align="center"><?= number_format($sum,2,',','.') ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="14" align="center">Sub total</td>
		<td align="center"><?= number_format($sb_t,2,',','.') ?></td>
	</tr>
</table>
</body>
</html>