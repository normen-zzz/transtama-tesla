<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Card-->
			<div class="card">
				<div class="card-header flex-wrap border-0 pt-6 pb-0">
					<div class="card-title">
						<h3 class="card-label">Users
							<span class="d-block text-muted pt-2 font-size-sm"></span>
						</h3>
					</div>
					<div class="card-toolbar">

						<!--begin::Button-->
						<a href="#" class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#modal-lg" style="background-color: #9c223b;">
							<span class="svg-icon svg-icon-md">
								<i class="fa fa-plus text-light"></i>
								<!--end::Svg Icon-->
							</span>Add</a>
						<!--end::Button-->
					</div>
				</div>
				<div class="card-body" style="overflow: auto;">
					<!--begin: Datatable-->
					<table class="table table-separate table-head-custom table-checkable" id="myTable">

						<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
						<thead>
							<tr>
								<th>Nama User</th>
								<th>Username</th>
								<th>Email</th>
								<th>Role</th>
								<th>Jabatan</th>
								<th>Atasan</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($users as $usr) {
								$atasan = $this->db->get_where('tb_user', ['id_user' => $usr['id_atasan']])->row_array();
								if ($atasan == null) {
									$atasan = '-';
								} else {
									$atasan = $atasan['nama_user'];
								}
							?>
								<tr>

									<td><?= $usr['nama_user'] ?></td>
									<td><?= $usr['username'] ?></td>
									<td><?= $usr['email'] ?></td>
									<td><?= $usr['nama_role'] ?></td>
									<td><?= $usr['nama_jabatan'] ?></td>
									<td><?= $atasan ?></td>
									<td><?= ($usr['status'] == 1) ? 'Aktif' : 'Tidak aktif'; ?></td>
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
												<i class="fas fa-cog"></i>
											</button>
											<div class="dropdown-menu dropdown-menu-right" role="menu">
												<a class="dropdown-item" data-toggle="modal" data-target="#modalEdit<?= $usr['id_user'] ?>">Edit</a>
												<a href="<?= base_url('superadmin/users/delete/' . $usr['id_user']) ?>" onclick="return confirm('Apakah Anda yakin ?')" class="dropdown-item">Delete</a>

											</div>
										</div>


									</td>
								</tr>
							<?php } ?>

						</tbody>
					</table>
					<!--end: Datatable-->
				</div>
			</div>
			<!--end::Card-->
		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->
</div>


<div class="modal fade" id="modal-lg">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add New Users</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('superadmin/users/addUser') ?>" method="POST">
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Nama User</label>
									<input type="text" class="form-control" required name="nama_user">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Email</label>
									<input type="email" class="form-control" required name="email">
								</div>

							</div>

						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Username</label>
									<input type="text" class="form-control" required name="username">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Password</label>
									<input type="password" class="form-control" required name="password">
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleSelectBorder">Role</label>
									<select name="id_role" class="custom-select form-control-border" style="width: 80%;">
										<?php foreach ($roles as $r) { ?>
											<option value="<?= $r['id_role'] ?>" <?php if ($r['id_role'] == $usr['id_role']) {
																						echo 'selected';
																					} ?>><?= $r['nama_role'] ?></option>
										<?php } ?>


									</select>
								</div>


							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleSelectBorder">Jabatan</label>
									<select name="id_jabatan" class="custom-select form-control-border" style="width: 80%;">
										<?php foreach ($jabatan as $r) { ?>
											<option value="<?= $r['id_jabatan'] ?>"><?= $r['nama_jabatan'] ?></option>
										<?php } ?>


									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleSelectBorder">Atasan</label>
									<select name="id_atasan" class="custom-select form-control-border" style="width: 80%;">
										<option value="NULL">None</option>
										<?php foreach ($users as $r) { ?>
											<option value="<?= $r['id_user'] ?>"><?= $r['nama_user'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
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

<?php foreach ($users as $usr) { ?>
	<div class="modal fade" id="modalEdit<?= $usr['id_user'] ?>">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit User <?= $usr['nama_user'] ?></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('superadmin/users/editUser') ?>" method="POST">
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Nama User</label>
										<input type="text" class="form-control" value="<?= $usr['nama_user'] ?>" name="nama_user">
										<input type="text" hidden class="form-control" value="<?= $usr['id_user'] ?>" name="id_user">
									</div>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Email</label>
										<input type="email" class="form-control" value="<?= $usr['email'] ?>" name="email">
									</div>

								</div>

							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Username</label>
										<input type="text" class="form-control" value="<?= $usr['username'] ?>" name="username">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Password</label>
										<input type="password" class="form-control" placeholder="Isi jika password ingin diubah" name="password">
									</div>
								</div>
							</div>

							<div class="row">

								<div class="col-md-6">

									<div class="form-group">
										<label for="exampleSelectBorder">Status</label>
										<select name="status" class="custom-select form-control-border">
											<option value="1" <?php if ($usr['status'] == 1) {
																	echo 'selected';
																} ?>>Aktif</option>
											<option value="0" <?php if ($usr['status'] == 0) {
																	echo 'selected';
																} ?>>Tidak Aktif</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleSelectBorder">Role</label>
										<select name="id_role" class="custom-select form-control-border">
											<?php foreach ($roles as $r) { ?>
												<option value="<?= $r['id_role'] ?>" <?php if ($r['id_role'] == $usr['id_role']) {
																							echo 'selected';
																						} ?>><?= $r['nama_role'] ?></option>
											<?php } ?>


										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleSelectBorder">Jabatan</label>
										<select name="id_jabatan" class="custom-select form-control-border">
											<?php foreach ($jabatan as $r) { ?>
												<option value="<?= $r['id_jabatan'] ?>" <?php if ($r['id_jabatan'] == $usr['id_jabatan']) {
																							echo 'selected';
																						} ?>><?= $r['nama_jabatan'] ?></option>
											<?php } ?>


										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleSelectBorder">Atasan</label>
										<select name="id_atasan" class="custom-select form-control-border">
											<?php foreach ($users as $r) { ?>
												<option value="<?= $r['id_user'] ?>" <?php if ($r['id_user'] == $usr['id_atasan']) {
																							echo 'selected';
																						} ?>><?= $r['nama_user'] ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
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