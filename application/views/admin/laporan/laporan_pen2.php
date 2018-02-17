<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<table border="1">
	<tr>
		<th>No.</th>
		<th>Loket</th>
		<th>Bulan</th>
		<?php
		$link = mysqli_connect("localhost","root","","ppob");
	    $starting_year  =date('Y', strtotime('-10 year'));
	    $ending_year = date('Y');
	    $current_year = date('Y');
	    for($starting_year; $starting_year <= $ending_year; $starting_year++) {
	        	echo "<th>".$starting_year."</th>";
	        }               
	    ?>
	</tr>
	<?php $bulan = array('01' => 'Januari', '02' => 'Febuari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
	$nu = 0; $no = 1; foreach ($loket as $ar) {?>
	<tr>
		<td><?= $no++ ?></td>
		<td><?= $ar->username ?></td>
		<td><?= $bulan[$month] ?></td>
		<?php
	    $starting_year  =date('Y', strtotime('-10 year'));
	    $ending_year = date('Y');
	    $current_year = date('Y');
	    for($starting_year; $starting_year <= $ending_year; $starting_year++) {
	    		$query1 = mysqli_query($link, "SELECT SUM(total) FROM pembayaran WHERE id_loket='$ar->kode_pegawai' AND date_format(tglbayar, '%m')='$month' AND date_format(tglbayar, '%Y')='$starting_year' ");
	    		$show1 = mysqli_fetch_array($query1);
	        	echo "<td>".$show1['SUM(total)']."</td>";
	        }               
	    ?>
	</tr>
	<?php } ?>
</table>
</body>
</html>