<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<center>
	<h1>PPOB</h1>
	<b>Terus Menyala, Menyala Terus</b><br>
	...............<br>
	<hr width="100%" height="75"></hr><br>
</center>
<body>
	<table border="1">
		<tr>
			<th align="center">ID Loket</th>
			<th align="center">Nama Loket</th>
			<?php  
			$starting_year  =date('Y', strtotime('-10 year'));
			$ending_year = date('Y');
			$current_year = date('Y');
			for($starting_year; $starting_year <= $ending_year; $starting_year++) {
				echo '<th align="center">'.$hari.' '.$starting_year.'</th>';
			}
			?>
			<th align="center">Total</th>
		</tr>
		<?php
		$nonb = 0;
		$this->db->where('level', 'loket');
		$pen4 = $this->db->get('user')->result();

		foreach ($pen4 as $key) {
		?>
		<tr>
			<td algin="left"><?= $key->kode_pegawai ?></td>
			<td algin="center"><?= $key->username ?></td>
			<?php 
			$sum = 0;
			$starting_year  =date('Y', strtotime('-10 year'));
			$ending_year = date('Y');
			$current_year = date('Y');
			for($starting_year; $starting_year <= $ending_year; $starting_year++) {
				$has = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%Y')='$starting_year' AND id_loket='$key->kode_pegawai' ")->result();
				echo '<td algin="right">'.number_format($has[0]->total,2,',','.').'</td>';
				$sum += $has[0]->total;
				$nonb += $sum;
			}
			?>
			<td algin="right"><?= number_format($sum,2,',','.') ?></td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="13" align="center">Sub total</td>
			<td align="right"><?= number_format($nonb,2,',','.') ?></td>
		</tr>
	</table>
</body>
</html>