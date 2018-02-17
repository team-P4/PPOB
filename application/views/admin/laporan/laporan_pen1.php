<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
Tahun : <?= $year ?>
<table border="1">
	<tr>
		<th>No.</th>
		<th>Loket</th>
		<?php  
		$bulan = array('01' => 'Januari', '02' => 'Febuari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');

		foreach ($bulan as $key => $value) {
			if ($hari != "semua" && $year != "semua") {
				echo "<th>".$year."-".$key."-".$hari."</th>";
			} else {
				echo "<th>".$value."</th>";
				echo "<th>Total</th>";
			}
		}
		?>
	</tr>
	<?php 
	$ko = 0; $co = 0;
	$no = 1; 
	if ($user != "semua" AND $year != "semua") {
		echo '<tr>
				<td>'.$no++.'</td>
				<td>'.$usr_dec[0]->username.'</td>';
		foreach ($bulan as $cum => $res) {
			$db1 = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%m') = '$cum' AND date_format(tglbayar, '%Y') = '$year' AND id_loket='$user' ")->result();
			foreach ($db1 as $ham) {
				$co += $ham->total;
				echo "<td>".$ham->total."</td>";
			}
		}
		$ko += $co;
		echo "<td>".$co."</td>	
			  </tr>";
	} elseif ($hari != "semua" && $year != "semua") {
		foreach ($loket as $as) {
			echo "<tr>
					<td>".$no++."</td>
					<td>".$as->username."</td>";
			foreach ($bulan as $key1 => $value1) {
				$link = mysqli_connect("localhost","root","","ppob");
				$query = mysqli_query($link, "SELECT SUM(total) FROM pembayaran WHERE id_loket='$as->kode_pegawai' AND date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m')='$key1' AND date_format(tglbayar, '%Y')='$year' ");
				$show = mysqli_fetch_array($query);
				echo "<td>".$show['SUM(total)']."</td>";
			}
		}
	} else {
		foreach ($loket as $im) { 
	?>
	<tr>
		<td><?= $no++ ?></td>
		<td><?= $im->username ?></td>
		<?php  
		$nu = 0;
		foreach ($bulan as $key1 => $value1) {
			$link = mysqli_connect("localhost","root","","ppob");
			$query = mysqli_query($link, "SELECT SUM(total) FROM pembayaran WHERE id_loket='$im->kode_pegawai' AND date_format(tglbayar, '%m')='$key1' AND date_format(tglbayar, '%Y')='$year' ");
			$show = mysqli_fetch_array($query);
			$nu += $show['SUM(total)'];
			echo "<td>".$show['SUM(total)']."</td>";
		}
		?>
		<td><?= $nu ?></td>
	</tr>
	<?php 
		$ko += $nu; }
	} 

	if ($hari != "semua" && $year != "semua") {

	} else {
	?>
	<tr>	
		<td colspan="14" align="center">Subtotal</td>
		<td><?= $ko ?></td>
	</tr>
	<?php } ?>
</table>
</body>
</html>