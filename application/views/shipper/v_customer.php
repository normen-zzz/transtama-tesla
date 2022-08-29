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
								<th>Province</th>
								<th>City</th>
								<!-- <th>Address</th> -->
								<th>No. Telp</th>
								<!-- <th>Join At</th> -->
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($customer as $c) { ?>
								<tr>
									<td><?= $c['nama_pt'] ?></td>
									<td><?= $c['pic'] ?></td>
									<td><?= $c['provinsi'] ?></td>
									<td><?= $c['kota'] ?></td>
									<!-- <td><?= $c['alamat'] ?></td> -->
									<td><?= $c['no_telp'] ?></td>
									<!-- <td><?= $c['join_at'] ?></td> -->
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
												<i class="fas fa-cog"></i>
											</button>
											<div class="dropdown-menu dropdown-menu-right" role="menu">
												<a href="#editCustomerDialog" class="open-Customer dropdown-item" data-toggle="modal" data-id="<?= $c['id_customer'] ?>" data-nama="<?= $c['nama_pt'] ?>" data-email="<?= $c['email'] ?>" data-pic="<?= $c['pic'] ?>" data-no_telp="<?= $c['no_telp'] ?>" data-provinsi="<?= $c['provinsi'] ?>" data-kota="<?= $c['kota'] ?>" data-alamat="<?= $c['alamat'] ?>">Edit</a>
												<a href="<?= base_url('shipper/customer/delete/' . $c['id_customer']) ?>" onclick="return confirm('Apakah Anda yakin ?')" class="dropdown-item">Delete</a>

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
				<form action="<?= base_url('shipper/customer/add') ?>" method="POST">
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">PT <span style="color: red;">*</span></label>
									<input type="text" class="form-control" required name="nama_pt">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Email</label>
									<input type="email" class="form-control" name="email">
								</div>

							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">PIC<span style="color: red;">*</span></label>
									<input type="text" class="form-control" required name="pic">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">No. Telp<span style="color: red;">*</span></label>
									<input type="text" class="form-control" required name="no_telp">
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="exampleInputPassword1">Address<span style="color: red;">*</span></label>
									<textarea name="alamat" class="form-control" required></textarea>
								</div>
							</div>
							<!-- <div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Join At</label>
									<input type="date" class="form-control" name="join_at">
								</div>
							</div> -->

						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Province<span style="color: red;">*</span></label>
									<select name="provinsi" class="form-control" required>
										<?php foreach ($province as $f) {
										?>
											<option value="<?= $f['name'] ?>"><?= $f['name'] ?></option>
										<?php  } ?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">City<span style="color: red;">*</span></label>
									<select name="kota" class="form-control" required>
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

<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="editCustomerDialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit PT </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('shipper/customer/edit') ?>" method="POST">
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">PT<span style="color: red;">*</span></label>
									<input type="text" class="form-control" id="nama_pt" value="" required name="nama_pt">
									<input type="text" class="form-control" hidden id="id_customer" value="" name="id_customer">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Email</label>
									<input type="email" class="form-control" id="email" value="" name="email">
								</div>

							</div>

						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">PIC<span style="color: red;">*</span></label>
									<input type="text" class="form-control" id="pic" value="" required name="pic">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">No. Telp<span style="color: red;">*</span></label>
									<input type="text" class="form-control" required id="no_telp" value="" name="no_telp">
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="exampleInputPassword1">Address<span style="color: red;">*</span></label>
									<textarea name="alamat" class="form-control" required id="alamat" value=""></textarea>
								</div>
							</div>

						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Province<span style="color: red;">*</span></label>
									<select name="provinsi" class="form-control" disabled>
										<?php foreach ($province as $f) {
										?>
											<option value="<?= $f['name'] ?>" <?php if ($f['name'] == 'dd') {
																					echo 'selected';
																				} ?>><?= $f['name'] ?></option>
										<?php  } ?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">City<span style="color: red;">*</span></label>
									<select name="kota" class="form-control" id="kota" disabled>
										<?php foreach ($city as $cc) {
										?>
											<option value="<?= $cc['city_name'] ?>" <?php if ($cc['city_name'] == 'dd') {
																						echo 'selected';
																					} ?>><?= $cc['city_name'] ?></option>
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