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
		<th align="right"><?php 
		$month = array('01' => 'Jan', '02' => 'Feb', '03' => 'Marc', '04' => 'April', '05' => 'Mey', '06' => 'Jun', '07' => 'July', '08' => 'Agust', '09' => 'Sept', '10' => 'Okt', '11' => 'Nov', '12' => 'Des');
		echo $month[$bulan]." ".$tahun;
		 ?></th>
	</tr>
	<?php  
	$sum = 0;
	$this->db->where('level', 'loket');
	$pen15 = $this->db->get('user')->result();

	foreach ($pen15 as $key) {
		$has = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%m')='$bulan' AND date_format(tglbayar, '%Y')='$tahun' AND id_loket='$key->kode_pegawai' ")->result();
		$sum += $has[0]->total;
	?>
	<tr>
		<td align="left"><?= $key->kode_pegawai ?></td>
		<td align="center"><?= $key->username ?></td>
		<td align="right"><?= $has[0]->total ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="2" align="center">Sub total</td>
		<td align="right"><?= $sum ?></td>
	</tr>
</table>
</body>
</html>