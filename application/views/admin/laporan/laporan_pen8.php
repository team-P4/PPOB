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
	    $month = array('01' => 'Jan', '02' => 'Feb', '03' => 'Marc', '04' => 'April', '05' => 'Mey', '06' => 'Jun', '07' => 'July', '08' => 'Agust', '09' => 'Sept', '10' => 'Okt', '11' => 'Nov', '12' => 'Des');
	    for($starting_year; $starting_year <= $ending_year; $starting_year++) {
	    	echo '<th align="center">'.$hari." ".$month[$bulan]." ".$starting_year.'</th>';
	    }               
	    ?>
		<th align="center">Total</th>
	</tr>
	<?php  
	$s = 0; 
	$this->db->where('level', 'loket');
	$pen8 = $this->db->get('user')->result();

	foreach ($pen8 as $key) {
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
	    	$has = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m')='$bulan' AND date_format(tglbayar, '%Y')='$starting_year' AND id_loket='$key->kode_pegawai' ")->result();
	    	echo '<td align="right">'.number_format($has[0]->total,2,',','.').'</td>';
	    	$sum += $has[0]->total;

	    }  $s += $sum;
	    ?>
		<td align="right"><?= number_format($sum,2,',','.') ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="13" align="center">Sub total</td>
		<td align="right"><?= number_format($s,2,',','.') ?></td>
	</tr>
</table>
</body>
</html>