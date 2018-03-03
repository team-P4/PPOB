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
		<th align="center">ID Pelanggan</th>
		<th align="center">Nama</th>
		<th align="center">Gardu</th>
		<th align="center">Provinsi</th>
		<th align="center">Kabupaten</th>
		<th align="center">Kecamatan</th>
		<th align="center">Kelurahan</th>
		<th align="center">Kode Pos</th>
		<th align="center">Alamat</th>
		<th align="center">Kode Tarif</th>
	</tr>
	<?php
	$no = 1;
	foreach ($pel as $key) {
		$this->db->where('id', $key->provinsi);
              $prov = $this->db->get('provinces')->result();

              $this->db->where('id', $key->kabupaten_kota);
              $kab = $this->db->get('regencies')->result();

              $this->db->where('id',$key->kecamatan);
              $kec = $this->db->get('districts')->result();

              $this->db->where('id', $key->kelurahan_desa);
              $kel = $this->db->get('villages')->result();
	?>
	<tr>
		<td><?= $no++ ?></td>
		<td align="left"><?= $key->id_pelanggan ?></td>
		<td align="center"><?= $key->nama ?></td>
		<td align="right"><?php 
		if ($key->id_gardu == "") {
			
		} else {
			$this->db->where('id_gardu', $key->id_gardu);
			$gardu = $this->db->get('gardu')->result();

			echo $gardu[0]->id_gardu."-".$gardu[0]->nama_gardu."-".$gardu[0]->kode_gardu."-".$gardu[0]->jln;
		}
		 ?></td>
		<td align="center"><?= $prov[0]->name ?></td>
		<td align="center"><?= $kab[0]->name ?></td>
		<td align="center"><?= $kec[0]->name ?></td>
		<td align="center"><?= $kel[0]->name ?></td>
		<td align="center"><?= $key->kodepos ?></td>
		<td align="center"><?= $key->alamat ?></td>
		<td align="center"><?php
		$this->db->where('id_tarif', $key->kodetarif);
		$dsb = $this->db->get('tarif')->result();
		echo $dsb[0]->kode_tarif; ?></td>
	</tr>
	<?php } ?>
</table>
</body>
</html>