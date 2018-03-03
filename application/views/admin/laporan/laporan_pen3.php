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
		$starting_year  =date('Y', strtotime('-10 year'));
		$ending_year = date('Y');
		$current_year = date('Y');
		for($starting_year; $starting_year <= $ending_year; $starting_year++) {
			$month = array('01' => 'Januari', '02' => 'Febuari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
			echo '<th align="center">'.$month[$bulan].' '.$starting_year.'</th>';
		}
		?>
		<th>total</th>
	</tr>
	<?php  
	$tot = 0;
	$this->db->where('level', 'loket');
	$pen3 = $this->db->get('user')->result();

	foreach ($pen3 as $key) {
	?>
	<tr>
		<td align="left"><?= $key->kode_pegawai ?></td>
		<td align="center"><?= $key->username ?></td>
		<?php  
		$sum = 0;
		$starting_year  =date('Y', strtotime('-10 year'));
		$ending_year = date('Y');
		$current_year = date('Y');
		for($starting_year; $starting_year <= $ending_year; $starting_year++) {
			$has = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%m')='$bulan' AND date_format(tglbayar, '%Y')='$starting_year' AND id_loket='$key->kode_pegawai' ")->result();
			echo '<td align="right">'.number_format($has[0]->total,2,',','.').'</td>';
			$sum += $has[0]->total;
			$tot += $sum;
		}
		?>
		<td align="right"><?= number_format($sum,2,',','.') ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="13" align="center">Sub total</td>
		<td><?= number_format($tot,2,',','.') ?></td>
	</tr>
</table>
</body>
</html>