<div id="top-nav">
				<nav class="navbar navbar-default">
					<div class="container-fluid">
						<div class="navbar-header">
							<!-- Navbar toggle button -->
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
								<i class="fa fa-bars"></i>
							</button>
							<!-- Sidebar toggle button -->
							<button type="button" class="sidebar-toggle">
								<i class="fa fa-bars"></i>
							</button>
							<a class="nav navbar-brand text-size-24" href="#"><i class="fa fa-star-o"></i> Welcome <?php echo $this->session->userdata('nama'); ?></a>

						</div>
						<div class="collapse navbar-collapse" id="menu">
							<p class="nav navbar-brand text-size-24" style="padding-left: 380px;">Saldo: <?php 
							$where = array('kode_pegawai' => $this->session->userdata('kode_pegawai') );
							$ia = $this->mod_admin->tampil_di('user',$where);

							$saldo = $ia[0]->saldo; 
							echo number_format($saldo,2,',','.');?></p>
							<ul class="nav navbar-nav navbar-right ">
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										<span class="fa-stack">
											<i class="fa fa-circle fa-stack-2x"></i>
											<i class="fa fa-user fa-stack-1x"></i>
										</span>
									</a>
									<ul class="dropdown-menu">
										<li><a href="#"><i class="fa fa-fw fa-user"></i> Info</a></li>
										<li><a href="<?php echo base_url('index.php/login/logout'); ?>"><i class="fa fa-fw fa-power-off"></i> Logout</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</div>