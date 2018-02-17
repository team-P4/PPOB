<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
Loket : <?= $user ?>
<table border="1">
	<tr>
		<th>Bulan</th>
		<?php  
		$starting_year  =date('Y', strtotime('-10 year'));
	    $ending_year = date('Y');
	    $current_year = date('Y');
	    for($starting_year; $starting_year <= $ending_year; $starting_year++) {
	        	echo "<th>".$starting_year."</th>";
	        }     
		?>
		<th>Total</th>
	</tr>
	<?php 
	$bulan1 = array('01' => 'Januari', '02' => 'Febuari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
	$link = mysqli_connect("localhost","root","","ppob");
	if ($bulan != "semua") {
		$apa = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE id_loket='$user' AND date_format(tglbayar, '%m')='$bulan' ")->result();
		echo "<tr>
				<td>".$bulan1[$bulan]."</td>";
		$starting_year  =date('Y', strtotime('-10 year'));
	    $ending_year = date('Y');
	    $current_year = date('Y');
	    for($starting_year; $starting_year <= $ending_year; $starting_year++) {
	    		$query2 = mysqli_query($link, "SELECT SUM(total) FROM pembayaran WHERE id_loket='$user' AND date_format(tglbayar, '%m')='$bulan' AND date_format(tglbayar, '%Y')='$starting_year' ");
	    		$show2 = mysqli_fetch_array($query2);
	        	echo "<td>".$show2['SUM(total)']."</td>";
	        }  
	    echo "	<td>".$apa[0]->total."</td>
	    	  </tr>";
	} else {
		foreach ($bulan1 as $key => $value) {
		$apa = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE id_loket='$user' AND date_format(tglbayar, '%m')='$key' ")->result();
	?>
	<tr>	
		<td><?= $value ?></td>
		<?php  
		$starting_year  =date('Y', strtotime('-10 year'));
	    $ending_year = date('Y');
	    $current_year = date('Y');
	    for($starting_year; $starting_year <= $ending_year; $starting_year++) {
	    		$query1 = mysqli_query($link, "SELECT SUM(total) FROM pembayaran WHERE id_loket='$user' AND date_format(tglbayar, '%m')='$key' AND date_format(tglbayar, '%Y')='$starting_year' ");
	    		$show1 = mysqli_fetch_array($query1);
	        	echo "<td>".$show1['SUM(total)']."</td>";
	        }  
		?>
		<td><?= $apa[0]->total ?></td>
	</tr>
	<?php } 
	}?>
</table>
</body>
</html>