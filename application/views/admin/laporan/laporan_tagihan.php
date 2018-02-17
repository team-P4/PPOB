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
		<?php
	    $starting_year  =date('Y', strtotime('-10 year'));
	    $ending_year = date('Y');
	    $current_year = date('Y');
	    for($starting_year; $starting_year <= $ending_year; $starting_year++) {
	        	echo "<th>".$starting_year."</th>";
	        }               
	    ?>
		<th>Total Keseluruhan</th>
	</tr>
	<?php  
	$no = 1;
	foreach ($loket as $key) {
		$link = mysqli_connect("localhost","root","","ppob");
		$query = mysqli_query($link, "SELECT SUM(total) FROM pembayaran WHERE id_loket='$key->kode_pegawai' ");
		$show = mysqli_fetch_array($query);
	?>
	<tr>
		<td><?= $no++ ?></td>
		<td><?= $key->username ?></td>
		<?php
	    $starting_year  =date('Y', strtotime('-10 year'));
	    $ending_year = date('Y');
	    $current_year = date('Y');
	    for($starting_year; $starting_year <= $ending_year; $starting_year++) {
			$query1 = mysqli_query($link, "SELECT SUM(total) FROM pembayaran WHERE id_loket='$key->kode_pegawai' AND date_format(tglbayar, '%Y')='$starting_year' ");
			$show1 = mysqli_fetch_array($query1);		
	        	echo "<td>".$show1['SUM(total)']."</td>";
	        }               
	    ?>
		<td><?= $show['SUM(total)'] ?></td>
	</tr>
	<?php  
	}
	?>
</table>
</body>
</html>