	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h2 class="card-title">Management Pengajuan Wisuda</h2>
						</div>
						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<table id="myTable" class="table table-bordered">

								<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
								<thead>
									<tr>
										<th>Nama</th>
										<th>NIM</th>
										<th>Fakultas</th>
										<th>Prodi</th>
										<th>Tanggal Lulus</th>
										<th>IPK</th>
										<th>Status</th>
										
									</tr>
								</thead>
								<tbody>
									<?php foreach ($pengajuan as $p) {
										$id_user = $this->session->userdata('id_user');
										$cek_tanggapan = $this->db->order_by('id_verifikasi_dekan', 'DESC')->get_where('tbl_verifikasi_dekan', ['id_pengajuan' => $p['id_pengajuan'], 'id_user' => $id_user])->row_array();

									?>
										<tr>
											<td><?= $p['nama_mhs'] ?></td>
											<td><?= $p['nim'] ?></td>
											<td><?= $p['fakultas'] ?></td>
											<td><?= $p['prodi'] ?></td>
											<td><?= bulan_indo($p['tgl_lulus']) ?></td>
											<td><?= $p['ipk'] ?></td>
											<td><a class="badge badge-light-danger font-weight-bold"><?= status($p['status']) ?> </a></td>
											
												


											</td>
										</tr>
									<?php } ?>

								</tbody>

							</table>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>

			</div>
			<!-- /.row -->

		</div>
		<!--/. container-fluid -->
	</section>
	<!-- /.content -->