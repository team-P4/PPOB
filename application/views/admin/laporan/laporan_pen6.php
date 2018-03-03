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
Loket : <?= $loket ?>
<table border="1">
	<tr>
		<th align="center">Bulan</th>
		<th align="center"><?= $tahun ?></th>
	</tr>
	<?php  
	$sum = 0;
	$bulan = array('01' => 'Januari', '02' => 'Febuari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
	foreach ($bulan as $bu => $u) {
	?>
	<tr>
		<td align="center"><?= $u ?></td>
		<?php 
		$has = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%m')='$bu' AND date_format(tglbayar, '%Y')='$tahun' AND id_loket='$loket' ")->result();
		echo '<td align="right">'.number_format($has[0]->total,2,',','.').'</td>';
		$sum += $has[0]->total;
		?>
	</tr>
	<?php } ?>
	<tr>
		<td align="center">Total</td>
		<td align="right"><?= number_format($sum,2,',','.') ?></td>
	</tr>
</table>
</body>
</html>