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
	    	echo '<th align="center">'.$starting_year.'-'.$bulan.'-'.$hari.'</th>';
	    }
		?>
		<th align="center">Total</th>
	</tr>
	<?php  
	$sub_t = 0;
	$this->db->where('kode_pegawai', $loket);
	$pen11 = $this->db->get('user')->result();

	foreach ($pen11 as $key) {
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
	    	$has = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m')='$bulan' AND date_format(tglbayar, '%Y')='$starting_year' AND id_loket='$loket' ")->result();
	    	echo '<td align="right">'.number_format($has[0]->total,2,',','.').'</td>';
	    	$sum += $has[0]->total;
	    } $sub_t += $sum;
		?>
		<td align="right"><?= $sum ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="13" align="center">Sub total</td>
		<td align="right"><?= number_format($sub_t,2,',','.') ?></td>
	</tr>
</table>
</body>
</html>