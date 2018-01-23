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
			<th>No.</th>
			<th>Kode Pegawai</th>
			<th>Username</th>
			<th>Password</th>
			<th>Level</th>
		</tr>
		<?php  
		$no = 1;
		foreach ($pdf as $key) {
		?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo $key->kode_pegawai; ?></td>
			<td><?php echo $key->username; ?></td>
			<td><?php echo $key->password; ?></td>
			<td><?php echo $key->level; ?></td>
		</tr>
		<?php } ?>
</table>
</body>
</html>