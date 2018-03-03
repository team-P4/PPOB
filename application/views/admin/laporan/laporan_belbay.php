<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<table border="1">
	<tr>
		<th>No.</th>
		<th align="center">Pelanggan</th>
		<th align="center">Tanggal</th>
		<th align="center">Tagihan</th>
	</tr>
	<?php 
	$no = 1; 
	$sum = 0;
	foreach ($tagihan as $tag) {
		$sum += $tag->total_biaya;
	?>
	<tr>
		<td><?= $no++ ?></td>
		<td align="center"><?php 
			$this->db->where('id_pelanggan', $tag->id_pelanggan);
			$nama = $this->db->get('pelanggan')->result();
			echo $nama[0]->nama;
			 ?></td>
		<td align="center"><?= $tag->tgl_tagihan ?></td>
		<td align="right"><?= number_format($tag->total_biaya,2,',','.') ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="3">Total</td>
		<td align="right"><?= number_format($sum,2,',','.') ?></td>
	</tr>
</table>
</body>
</html>