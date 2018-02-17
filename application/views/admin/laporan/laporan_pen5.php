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
		<?php if ($tahun == "semua") {
			$starting_year  =date('Y', strtotime('-10 year'));
	        $ending_year = date('Y');
	        $current_year = date('Y');
	        for($starting_year; $starting_year <= $ending_year; $starting_year++) {
				echo "<th>".$starting_year."-".$bulan."-".$hari."</th>";
			}
		} elseif ($bulan == "semua") {
			$bulan1 = array("","01","02","03","04","05","06","07","08","09","10","11","12");
		 	for ($i=1; $i < 13; $i++) { 
				echo "<th>".$tahun."-".$bulan1[$i]."-".$hari."</th>";
			}
		} elseif ($hari == "semua") {
			echo "<th>Tanggal</th>
			<th>Pendapatan</th>";
		} else {
			echo "<th>Tanggal</th>
			<th>Pendapatan</th>";
		}?>
	</tr>
	<?php 
	$no = 1; 
	if ($hari == "semua") {
		$zero = '0';
		for ($i=1; $i <= 31; $i++) { 
			if ($i > 9) {
					$zero = '';
			}
			echo "<tr>
				  <td>".$no++."</td>
				  <td>".$user."</td>";
			echo "<td>".$tahun."-".$bulan."-".$zero . $i."</td>";
			$db[$i] = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%d')='$zero{$i}' AND date_format(tglbayar, '%m') = '$bulan' AND date_format(tglbayar, '%Y') = '$tahun' AND id_loket='$user' ")->result();

			foreach ($db[$i] as $key[$i]) {
				if ($key[$i]->total) {
						echo "<td>".$key[$i]->total."</td>";
					} else {
						echo "<td>0</td>";
					}
				}
			echo "</tr>";
		}
	} elseif ($user == "semua") {
		foreach ($loket as $jam) {
			echo '<tr>
					<td>'.$no++.'</td>
					<td>'.$jam->username.'</td>';
			if ($tahun == "semua") {
				$starting_year  =date('Y', strtotime('-10 year'));
		        $ending_year = date('Y');
		        $current_year = date('Y');
		        for($starting_year; $starting_year <= $ending_year; $starting_year++) {
					$db1 = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m') = '$bulan' AND date_format(tglbayar, '%Y') = '$starting_year' AND id_loket='$jam->kode_pegawai' ")->result();
					echo "<td>".$db1[0]->total."</td>";
				}
				echo "</tr>";
			} else {
				echo '<td>'.$tahun.'-'.$bulan.'-'.$hari.'</td>';
				$db1 = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m') = '$bulan' AND date_format(tglbayar, '%Y') = '$tahun' AND id_loket='$jam->kode_pegawai' ")->result();
				foreach ($db1 as $boost) {
					echo "<td>".$boost->total."</td>
					</tr>";
				}	
			}
		}
	} else {
	?>
	<tr>
		<td><?= $no++ ?></td>
		<td><?= $user ?></td>
		<?php if ($tahun == "semua") {
			$starting_year  =date('Y', strtotime('-10 year'));
	        $ending_year = date('Y');
	        $current_year = date('Y');
	        for($starting_year; $starting_year <= $ending_year; $starting_year++) {
	        	$query = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m')='$bulan' AND date_format(tglbayar, '%Y')='$starting_year' AND id_loket='$user'  ")->result();
				echo "<td>".$query[0]->total."</td>";
			}
		 } elseif ($bulan == "semua") {
		 	$bulan1 = array("","01","02","03","04","05","06","07","08","09","10","11","12");
		 	for ($i=1; $i < 13; $i++) { 
			$db[$i] = $this->db->query("SELECT SUM(total) as total FROM pembayaran WHERE date_format(tglbayar, '%d')='$hari' AND date_format(tglbayar, '%m') = '$bulan1[$i]' AND date_format(tglbayar, '%Y') = '$tahun' AND id_loket='$user' ")->result();

				foreach ($db[$i] as $key[$i]) {
					if ($key[$i]->total) {
							echo "<td>".$key[$i]->total."</td>";
						} else {
							echo "<td>0</td>";
						}
					}
			}
		 } else {?>
		<td><?= $tahun."-".$bulan."-".$hari ?></td>
		<td><?= $query[0]->total ?></td>
		<?php } ?>
	</tr>
	<?php } ?>
</table>
</body>
</html>