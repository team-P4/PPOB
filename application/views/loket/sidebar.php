	<div id="sidebar">
			<div id="sidebar-wrapper">
				<div class="sidebar-title">
					<span class="text-size-40 text-loose">PPOB</span><br>
					<span class="text-size-18 text-grey">Bahagiamu Sukacita</span><br>
					<span class="text-size-18 text-grey">Kami</span>
				</div>
				<div class="sidebar-avatar">
					<div class="sidebar-avatar-image"><img src="<?php echo base_url(); ?>assets/images/pln1.png" alt="" class="img-circle"></div>
					<div class="sidebar-avatar-text"><?php  
					$this->db->select('username');
					$this->db->where('kode_pegawai', $this->session->userdata('kode_pegawai'));
					$username = $this->db->get('user')->result();

					echo $username[0]->username;
					?></div>
				</div>
				<ul class="sidebar-nav">
					<li class="sidebar-close"><a href="#"><i class="fa fa-fw fa-close"></i></a></li>
					<li><a href="<?php echo base_url('index.php/loket/index'); ?>"><i class="fa fa-fw fa-desktop"></i><span>Dashboard</span></a></li>
					<li><a href="<?php echo base_url('index.php/loket/payment'); ?>"><i class="fa fa-handshake-o"></i><span>Pembayaran</span></a></li>
					<li><a href="<?php echo base_url('index.php/loket/laporan'); ?>"><i class="fa fa-fw fa-list-alt"></i><span>Laporan</span></a></li>
				</ul>
				<div class="sidebar-footer">
					<hr style="border-color: #DDD">
					created by <a href="" target="" class="text-default">P4-PPOB</a><br>
				</div>
			</div>
		</div>