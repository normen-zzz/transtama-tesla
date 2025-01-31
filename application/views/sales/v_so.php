	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch">
						<div class="card-header py-3">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bolder text-dark">Request Pickup</h3>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Your Request Information</span>
							</div>
							<div class="card-toolbar">
								<?php if ($this->session->userdata('id_role') == 8) { ?>
									<button type="button" class="btn mr-2 text-light" data-toggle="modal" style="background-color: #9c223b;" data-target="#modalAddPtp">
										Add PTP Request
									</button>
								<?php } ?>

								<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder/add') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-plus-circle text-light"> </i>
									Add Request Pickup
								</a>
								<div class="card-toolbar">

								</div>
							</div>

						</div>
						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<?php
							$id_atasan = $this->session->userdata('id_atasan');
							if ($id_atasan == 0 || $id_atasan == NULL) {
							?>
								<table id="myTable" class="table table-bordered">
									<!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
									<p><?= $this->session->flashdata('message'); ?></p>
									<thead>
										<tr>
											<th style="width: 15%;">Sales</th>
											<th style="width: 15%;">PU. Date</th>
											<th style="width: 15%;">Time</th>
											<th style="width: 30%;">Shipper</th>
											<th style="width: 20%;">Destination</th>
											<th>Pickup Status</th>
											<th>Approval</th>
											<th style="width: 15%;">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($so as $s) {
										?>
											<tr>
												<td><?= $s['nama_user'] ?></td>
												<td><?= longdate_indo($s['tgl_pickup']) ?></td>
												<td><?= $s['time'] ?></td>
												<td><?= $s['shipper'] ?></td>
												<td><?= $s['destination'] ?></td>
												<td><?php if ($s['status'] == 0) {
													?>
														<span class="label label-danger label-inline font-weight-lighter" style="width: 100px;">Request Pickup</span>
													<?php	} elseif ($s['status'] == 1 || $s['status'] == 2 || $s['status'] == 3 || $s['status'] == 4) {
													?>
														<span class="label label-success label-inline font-weight-lighter" style="width: 120px;">Pickuped</span>
													<?php } else {

														echo '<span class="label label-secondary label-inline font-weight-lighter" style="width: 120px;">Cancel</span>';
													} ?>
												</td>
												<td>
													<?php
													if ($s['status'] == 5) {
														echo '<span class="label label-secondary label-inline font-weight-lighter" style="width: 120px;">Cancel</span>';
													} else {
														if ($s['lock'] == 0) {
													?>
															<span class="label label-warning label-inline font-weight-lighter" style="width: 100px;">Unapprove</span>
															<small>Wait Until Sales Lock The SO</small>
															<?php	} else {
															if ($s['status_approve'] == 0) {
															?>
																<span class="label label-warning label-inline font-weight-lighter" style="width: 100px;">Unapprove</span>
															<?php	} elseif ($s['status_approve'] == 1) {
															?>
																<span class="label label-primary label-inline font-weight-lighter" style="width: 120px;">Approve Manager</span>
															<?php	} elseif ($s['status_approve'] == 2) {
															?>
																<span class="label label-purple label-inline font-weight-lighter" style="width: 100px;">Approve Cs</span>
															<?php	} elseif ($s['status_approve'] == 3) {
															?>
																<span class="label label-success label-inline font-weight-lighter" style="width: 100px;">Approve Finance</span>
															<?php	} ?>
													<?php	}
													} ?>



												</td>
												<td>
													<?php
													if ($s['id_atasan_sales'] == NULL || $s['id_atasan_sales'] == 0) {
														if ($s['status'] == 0 || $s['status'] == 1) {
															// kalo dia atasan
													?>
															<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder/detail/' . $s['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
															<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder/edit/' . $s['id_so']) ?>" class="btn btn-sm text-light ml-2 mb-1" style="background-color: #9c223b;">Edit</a>
															<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder/cancel/' . $s['id_so']) ?>" class="btn btn-sm text-light" style="background-color: #9c223b;">Cancel</a>
															<?php	} else {
															if ($s['status_approve'] == 0) {
															?>
																<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder/detail/' . $s['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
																<a href="<?= base_url('sales/salesOrder/approve/' . $s['id_so']) ?>" onclick="return confirm('Are You Sure ?')" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Approve</a>
															<?php	} else {
															?>
																<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder/detail/' . $s['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
															<?php	}
															?>
														<?php	}
														?>
													<?php	} else {
													?>
														<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder/detail/' . $s['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
														<!-- <a href="<?= base_url('sales/salesOrder/edit/' . $s['id_so']) ?>" class="btn btn-sm text-light ml-2" style="background-color: #9c223b;">Edit</a> -->

													<?php	} ?>
												</td>
											</tr>

										<?php	} ?>
									</tbody>


								</table>

							<?php	} else {
							?>
								<table id="mytableso" class="table table-bordered">
									<!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
									<p><?= $this->session->flashdata('message'); ?></p>
									<thead>
										<tr>
											<th style="width: 15%;">PU. Date</th>
											<th style="width: 15%;">Time</th>
											<th style="width: 20%;">Shipper</th>
											<th style="width: 20%;">Destination</th>
											<th>Pickup Status</th>
											<th>Approval</th>
											<th style="width: 15%;">Action</th>
										</tr>
									</thead>


								</table>
							<?php }

							?>
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

	<!-- modal add ptp  -->
	<div class="modal fade" id="modalAddPtp" tabindex="-1" role="dialog" aria-labelledby="modalAddPtp" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<form action="<?= base_url('sales/salesOrder/addPtpRequest') ?>" method="post">
					<div class="modal-header">
						<h5 class="modal-title" id="modalAddPtp">Add PTP Request</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<i aria-hidden="true" class="ki ki-close"></i>
						</button>
					</div>

					<div class="modal-body">
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Shipper</label>
							<div class="col-lg-9 col-md-9 col-sm-12">
								<select class="form-control shipperPtp" name="shipper" id="shipperPtp" required>
									<option value="">Select Shipper</option>
									<?php foreach ($shipperPtp->result_array() as $s) {
									?>
										<option value="<?= $s['id_customer_ptp'] ?>"><?= $s['nama_customer'] ?></option>
									<?php	} ?>
								</select>
							</div>
						</div>
						<div id="alamatShipperPtp">
							<div class="form-group row">
								<label class="col-form-label col-lg-3 col-sm-12">Address</label>
								<div class="col-lg-9 col-md-9 col-sm-12">
									<input type="text" class="form-control" name="alamat" id="alamat" disabled>
								</div>
							</div>
						</div>
						<!-- consignee  -->
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Consignee</label>
							<div class="col-lg-9 col-md-9 col-sm-12">
								<input type="text" class="form-control" name="consignee" required>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">PU. Date</label>
							<div class="col-lg-9 col-md-9 col-sm-12">
								<input type="datetime-local" name="tgl_pickup" id="tgl_pickup" class="form-control" required>
							</div>
						</div>

						


						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Destination</label>
							<div class="col-lg-9 col-md-9 col-sm-12">
								<select name="destination" id="destination" class="form-control" required>
									<option value="">Select Destination</option>
									<?php foreach ($destination->result_array() as $d) {
									?>
										<option value="<?= $d['id_city_ptp'] ?>"><?= $d['name'] ?></option>
									<?php	} ?>
								</select>
							</div>
						</div>
						<!-- commodity  -->
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Commodity</label>
							<div class="col-lg-9 col-md-9 col-sm-12">
								<input type="text" class="form-control" name="commodity" required>
							</div>
						</div>

						<!-- koli  -->
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Koli</label>
							<div class="col-lg-9 col-md-9 col-sm-12">
								<input type="number" class="form-control" name="koli" value="0" required>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Note</label>
							<div class="col-lg-9 col-md-9 col-sm-12">
								<textarea class="form-control" name="note"></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary font-weight-bold" id="submitAddPtp">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>



	<script>
		$(document).on('change', '#shipperPtp', function() {
			var id = $(this).val();
			if (id == '') {
				$('#alamat').val('');
				return false;
			} else {
				$.ajax({
					url: '<?= base_url('sales/salesOrder/getAlamatShipperPtp') ?>',
					type: 'post',
					data: {
						id: id
					},
					success: function(data) {
						data = JSON.parse(data);
						$('#alamat').val(data.address + ', ' + data.city + ', ' + data.state);
					}
				});
			}

		});
	</script>

	<script>
		// submitAddPtp
		$('#submitAddPtp').on('click', function() {

			// check val shipper not null 
			if ($('#shipperPtp').val() == '') {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Shipper Cannot Be Empty !',
				})
				return false;
			}
			// pu date 
			if ($('#tgl_pickup').val() == '') {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Pickup Date Cannot Be Empty !',
				})
				return false;
			}
			// destination
			if ($('#destination').val() == '') {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Destination Cannot Be Empty !',
				})
				return false;
			}
			// commodity
			if ($('input[name="commodity"]').val() == '') {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Commodity Cannot Be Empty !',
				})
				return false;
			}

			// swal for confirm
			Swal.fire({
				title: 'Are you sure?',
				text: "You want to add this PTP Request?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, add it!'
			}).then((result) => {
				if (result.isConfirmed) {
					// swal loading 
					Swal.fire({
						title: 'Please Wait !',
						html: 'Loading...',
						timerProgressBar: true,
						didOpen: () => {
							Swal.showLoading()
						},
						showConfirmButton: false,
						allowOutsideClick: false

					})
					$('form').submit();
				}
			})
		});
	</script>