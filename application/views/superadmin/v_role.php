	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h2 class="card-title">Management Role</h2>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="myTable" class="table table-bordered">
								<button type="button" class="btn mb-4 text-light" data-toggle="modal" data-target="#modal-lg" style="background-color: #9c223b;">
									<i class="fas fa-plus text-light"> </i> Add
								</button>
								<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
								<thead>
									<tr>
										<th>Nama Role</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($role as $r) { ?>
										<tr>
											<td><?= $r['nama_role'] ?></td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
														<i class="fas fa-cog"></i>
													</button>
													<div class="dropdown-menu dropdown-menu-right" role="menu">
														</button>
														<a class="dropdown-item" data-toggle="modal" data-target="#modalEdit<?= $r['id_role'] ?>">Edit</a>
														<a href="<?= base_url('superadmin/role/delete/' . $r['id_role']) ?>" onclick="return confirm('Apakah Anda yakin ?')" class="dropdown-item">Delete</a>

													</div>
												</div>


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

	<div class="modal fade" id="modal-lg">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Tambah Role Baru</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('superadmin/role/addRole') ?>" method="POST">
						<div class="card-body">


							<div class="form-group">
								<label for="exampleInputEmail1">Nama Role</label>
								<input type="text" class="form-control" id="exampleInputEmail1" required name="nama_role">
							</div>



						</div>
						<!-- /.card-body -->


				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

	<?php foreach ($role as $r) { ?>
		<div class="modal fade" id="modalEdit<?= $r['id_role'] ?>">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Edit <?= $r['nama_role'] ?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="<?= base_url('superadmin/role/edit') ?>" method="POST">
							<div class="card-body">

								<div class="form-group">
									<label for="exampleInputEmail1">Nama prodi</label>
									<input type="text" class="form-control" id="exampleInputEmail1" value="<?= $r['nama_role'] ?>" name="nama_role">
									<input type="text" hidden class="form-control" id="exampleInputEmail1" value="<?= $r['id_role'] ?>" name="id_role">
								</div>

							</div>
							<!-- /.card-body -->


					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
					</form>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

	<?php } ?>