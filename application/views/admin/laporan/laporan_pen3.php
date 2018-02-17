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
		<th>Hari</th>
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
	<?php $ka = 0; $no = 1; foreach ($loket as $key) {?>
	<tr>
		<td><?= $no++ ?></td>
		<td><?= $key->username ?></td>
		<td><?= $day ?></td>
		<?php
	    $starting_year  =date('Y', strtotime('-10 year'));
	    $ending_year = date('Y');
	    $current_year = date('Y');
	    for($starting_year; $starting_year <= $ending_year; $starting_year++) {
	    	$query1 = mysqli_query($link, "SELECT SUM(total) FROM pembayaran WHERE id_loket='$key->kode_pegawai' AND date_format(tglbayar, '%d')='$day' AND date_format(tglbayar, '%Y')='$starting_year' ");
	    	$show1 = mysqli_fetch_array($query1);
	        	echo "<td>".$show1['SUM(total)']."</td>";
	        }
	    ?>
	</tr>
	<?php } ?>
</table>
</body>
</html>