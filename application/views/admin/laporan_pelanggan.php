<!DOCTYPE html>
<html>
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
		<th>ID Pelanggan</th>
		<th>Kode Pelanggan</th>
		<th>Nama</th>
		<th>Alamat</th>
		<th>Kode Tarif</th>
	</tr>
	<?php
	$no = 1;
	foreach ($pel as $key) {
	?>
	<tr>
		<td><?= $no++ ?></td>
		<td><?= $key->id_pelanggan ?></td>
		<td><?= $key->kode_pegawai ?></td>
		<td><?= $key->nama ?></td>
		<td><?= $key->alamat ?></td>
		<td><?= $key->kodetarif ?></td>
	</tr>
	<?php } ?>
</table>
</body>
</html>