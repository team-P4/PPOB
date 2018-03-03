<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
	.grid-container {
	  display: inline-block;/**/
	  grid-template-columns: auto auto auto;
	 /* padding: 10px;*/
	}
	.grid-item {
	  padding: 10px;
	}
	</style>
</head>
<body>
<center>
	<h1>PPOB</h1>
	<b>Terus Menyala, Menyala Terus</b><br>
	...............<br>
	<hr width="100%" height="75"></hr><br>
</center>
<div class="grid-container">
	<div class="grid-item"> 
		<table>
			<tr>
				<td>Kode Pelanggan</td>
				<td>:</td>
				<td><?= $name[0]->id_pelanggan ?></td>
			</tr>
			<tr>
				<td>Nama Pelanggan</td>
				<td>:</td>
				<td><?= $name[0]->nama ?></td>
			</tr>
		</table>
	</div>
	<div class="grid-item"> 
		Daftar Tagihan Pelanggan Yang Belum Lunas :
		<table border="1">
			<tr>
                <th align="center">ID TAGIHAN</th>
                <th align="center">TANGGAL TAGIHAN</th>
                <th align="center">PENGGUNAAN LISTRIK(Kwh)</th>
                <th align="center">BIAYA TAGIHAN (Rp.)</th>
                <th align="center">STATUS</th>
			</tr>
			<?php
			foreach ($b_l as $k) {
			?>
			<tr>
				<td><?= $k->id_tagihan ?></td>
				<td align="center"><?= $k->tgl_tagihan ?></td>
				<td align="center"><?= $k->pemakaian ?></td>
				<td align="right"><?= number_format($k->total_biaya,2,',','.') ?></td>
				<td align="center"><?php echo 'Belum Lunas'; ?></td>
			</tr>
			<?php } ?>
		</table><br><br><br><br>
		Daftar Tagihan Pelanggan Yang Sudah Lunas :
		<table border="1">
			<tr>
				<th align="center">ID TAGIHAN</th>
                <th align="center">TANGGAL TAGIHAN</th>
                <th align="center">PENGGUNAAN LISTRIK(Kwh)</th>
                <th align="center">BIAYA TAGIHAN (Rp.)</th>
                <th align="center">STATUS</th>
			</tr>
			<?php  
			foreach ($l as $m) {
			?>
			<tr>
				<td><?= $m->id_tagihan ?></td>
				<td align="center"><?= $m->tgl_tagihan ?></td>
				<td align="center"><?= $m->pemakaian ?></td>
				<td align="right"><?= number_format($m->total_biaya,2,',','.') ?></td>
				<td align="center"><?php echo 'Lunas'; ?></td>
			</tr>
			<?php } ?>
		</table>
	</div>
</div>
</body>
</html>