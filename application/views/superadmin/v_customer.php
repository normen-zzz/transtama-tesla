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
						<h3 class="card-label">Customer
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
								<th>PT</th>
								<th>PIC</th>
								<th>Username</th>
								<th>Address</th>
								<th>No. Telp</th>
								<th>Join At</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($customer as $c) { ?>
								<tr>

									<td><?= $c['nama_pt'] ?></td>
									<td><?= $c['pic'] ?></td>
									<td><?= $c['username'] ?></td>
									<td><?= $c['alamat'] ?></td>
									<td><?= $c['no_telp'] ?></td>
									<td><?= $c['join_at'] ?></td>
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
												<i class="fas fa-cog"></i>
											</button>
											<div class="dropdown-menu dropdown-menu-right" role="menu">
												<a class="dropdown-item" data-toggle="modal" data-target="#modalEdit<?= $c['id_customer'] ?>">Edit</a>
												<a href="<?= base_url('superadmin/customer/delete/' . $c['id_customer']) ?>" onclick="return confirm('Apakah Anda yakin ?')" class="dropdown-item">Delete</a>

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
				<h4 class="modal-title">Add New Customer</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('superadmin/customer/add') ?>" method="POST">
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">PT</label>
									<input type="text" class="form-control" required name="nama_pt">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Email</label>
									<input type="email" class="form-control" name="email">
								</div>

							</div>
							<!-- <div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Username</label>
									<input type="text" class="form-control" name="username">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Password</label>
									<input type="text" class="form-control" name="password" placeholder="type new password">
								</div>

							</div> -->

						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">PIC</label>
									<input type="text" class="form-control" required name="pic">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">No. Telp</label>
									<input type="text" class="form-control" required name="no_telp">
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Address</label>
									<textarea name="alamat" class="form-control" rows="6" required></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Join At</label>
									<input type="date" class="form-control" name="join_at">
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

<?php foreach ($customer as $c) { ?>
	<div class="modal fade" id="modalEdit<?= $c['id_customer'] ?>">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit PT <?= $c['nama_pt'] ?></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('superadmin/customer/edit') ?>" method="POST">
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">PT</label>
										<input type="text" class="form-control" required name="nama_pt" value="<?= $c['nama_pt'] ?>">
										<input type="text" class="form-control" hidden name="id_customer" value="<?= $c['id_customer'] ?>">
									</div>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Email</label>
										<input type="email" class="form-control" name="email" value="<?= $c['email'] ?>">
									</div>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Username</label>
										<input type="text" class="form-control" name="username" value="<?= $c['username'] ?>">
									</div>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Password</label>
										<input type="text" class="form-control" name="password" placeholder="type new password">
									</div>

								</div>

							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">PIC</label>
										<input type="text" class="form-control" required name="pic" value="<?= $c['pic'] ?>">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">No. Telp</label>
										<input type="text" class="form-control" required name="no_telp" value="<?= $c['no_telp'] ?>">
									</div>
								</div>

							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Address</label>
										<textarea name="alamat" class="form-control" rows="6" required><?= $c['alamat'] ?></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Join At</label>
										<input type="date" class="form-control" name="join_at" value="<?= $c['join_at'] ?>">
									</div>
								</div>

							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="exampleInputEmail1">Destination State</label>
										<select name="state_consigne" class="form-control">
											<?php foreach ($province as $f) {
											?>
												<option value="<?= $f['name'] ?>"><?= $f['name'] ?></option>
											<?php  } ?>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="exampleInputEmail1">Destination City</label>
										<select name="city_consigne" class="form-control">
											<?php foreach ($city as $c) {
											?>
												<option value="<?= $c['city_name'] ?>" <?php if ($c['city_name'] == "CENTRAL JAKARTA") {
																							echo 'selected';
																						} ?>><?= $c['city_name'] ?></option>
											<?php  } ?>
										</select>
									</div>
								</div>
							</div>


						</div>


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