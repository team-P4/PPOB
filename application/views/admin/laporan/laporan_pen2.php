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
		<th align="center"><?= $tahun ?></th>
	</tr>
	<?php
	$tot = 0;  
	$this->db->where('level', 'loket');
	$pen2 = $this->db->get('user')->result();

	foreach ($pen2 as $key) {
	?>
	<tr>
		<td align="left"><?= $key->kode_pegawai ?></td>
		<td align="center"><?= $key->username ?></td>
		<?php 
		$has = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%Y')='$tahun' AND id_loket='$key->kode_pegawai' ")->result();
		foreach ($has as $lue) {
			echo '<td align="right">'.number_format($lue->total,2,',','.').'</td>';
			$tot += $lue->total;
		}?>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="2" align="center">total</td>
		<td align="right"><?= number_format($tot,2,',','.') ?></td>
	</tr>
</table>
</body>
</html>