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
		<td>Bulan Tahun</td>
		<td>:</td>
		<?php  
		$month = array('01' => 'Jan', '02' => 'Feb', '03' => 'Marc', '04' => 'April', '05' => 'Mey', '06' => 'Jun', '07' => 'July', '08' => 'Agust', '09' => 'Sept', '10' => 'Okt', '11' => 'Nov', '12' => 'Des');
		echo '<td>'.$month[$bulan].' '.$tahun.'</td>';
		?>
	</tr>
</table>
<table border="1">
	<tr>
		<th align="center">Hari</th>
		<th align="center">Pendapatan</th>
	</tr>
	<?php  
	$sum = 0;
	$zero = '0';
	for ($i=1; $i <= 31; $i++) { 
		if ($i > 9) {
			$zero = '';
		}
		$has = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%d')='$zero{$i}' AND date_format(tglbayar, '%m')='$bulan' AND date_format(tglbayar, '%Y')='$tahun' AND id_loket='$loket' ")->result();
	?>
	<tr>
		<td align="center"><?= $zero.$i ?></td>
		<td align="right"><?= $has[0]->total ?></td>
	</tr>
	<?php $sum += $has[0]->total; } ?>
	<tr>
		<td align="center">Total</td>
		<td align="right"><?= $sum ?></td>
	</tr>
</table>
</body>
</html>