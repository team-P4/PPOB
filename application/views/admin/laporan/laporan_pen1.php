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
		<th align="center">ID loket</th>
		<th align="center">Loket</th>
		<?php  
		$starting_year  =date('Y', strtotime('-10 year'));
		$ending_year = date('Y');
		$current_year = date('Y');
		for($starting_year; $starting_year <= $ending_year; $starting_year++) {
			echo '<th align="center">'.$starting_year.'</th>';
		}
		?>
		<th align="center">Total</th>
	</tr>
	<?php  
	$sun = 0;
	$this->db->where('level', 'loket');
	$pen1 = $this->db->get('user')->result();
	foreach ($pen1 as $cor) {
	?>
	<tr>
		<td align="left"><?= $cor->kode_pegawai ?></td>
		<td align="center"><?= $cor->username ?></td>
		<?php  
		$sum_t = 0;
		$sum = 0;
		$starting_year  =date('Y', strtotime('-10 year'));
		$ending_year = date('Y');
		$current_year = date('Y');
		for($starting_year; $starting_year <= $ending_year; $starting_year++) {
			$has = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%Y')='$starting_year' AND id_loket='$cor->kode_pegawai' ")->result();
			echo '<td align="right">'.number_format($has[0]->total,2,',','.').'</td>';
			$sum += $has[0]->total;
			$sun += $sum;
		}
		?>
		<td align="right"><?= number_format($sum,2,',','.') ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="13">Sub Total</td>
		<td><?= number_format($sun,2,',','.') ?></td>
	</tr>
</body>
</html>