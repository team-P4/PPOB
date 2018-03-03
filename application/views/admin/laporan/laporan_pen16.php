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
<table>
	<tr>
		<td>Loket</td>
		<td>:</td>
		<td><?= $loket ?></td>
	</tr>
	<tr>
		<td>Hari</td>
		<td>:</td>
		<td><?= $hari ?></td>
	</tr>
</table>
<table border="1">
	<tr>
		<th align="center">Bulan</th>
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
	$sub_t = 0; 
	$month = array('01' => 'Jan', '02' => 'Feb', '03' => 'Marc', '04' => 'April', '05' => 'Mey', '06' => 'Jun', '07' => 'July', '08' => 'Agust', '09' => 'Sept', '10' => 'Okt', '11' => 'Nov', '12' => 'Des');
	foreach ($month as $bu => $u) {
	?>
	<tr>
		<td align="center"><?= $u ?></td>
		<?php  
		$sum = 0;
		$starting_year  =date('Y', strtotime('-10 year'));
		$ending_year = date('Y');
		$current_year = date('Y');
		for($starting_year; $starting_year <= $ending_year; $starting_year++) {
			$has = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m')='$bu' AND date_format(tglbayar, '%Y')='$starting_year' AND id_loket='$loket' ")->result();
			echo '<td align="right">'.$has[0]->total.'</td>';
			$sum += $has[0]->total;
		} $sub_t += $sum;
		?>
		<td align="right"><?= $sum ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="12">Sub total</td>
		<td align="right"><?= $sub_t ?></td>
	</tr>
</table>
</body>
</html>