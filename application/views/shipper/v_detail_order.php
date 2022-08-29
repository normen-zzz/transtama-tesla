	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch">
						<div class="card-header py-3">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bolder text-dark">Detail Sales Order </h3>
								<!-- <span class="text-muted font-weight-bold font-size-sm mt-1">Shipment ID :<b> <?= $p['shipment_id'] ?></b></span>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Order ID :<b> <?= $p['order_id'] ?></b></span> -->
							</div>
							<div class="card-toolbar">
								<a href="<?= base_url('shipper/salesOrder') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-chevron-circle-left text-light"> </i>
									Back
								</a>
							</div>
						</div>

						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<div class="row">
								<div class="col-md-8">
									<table class="table border">
										<tr>
											<td>Pickup Date</td>
											<td><b>:<?= longdate_indo($p['tgl_pickup']) ?>, <?= $p['time'] ?></b></td>
											<td>Shipper</td>
											<td><b>:<?= $p['shipper'] ?></b> </td>
										</tr>
										<tr>
											<td>Pickup Moda</td>
											<td><b>:<?= $p['pu_moda'] ?></b> </td>
											<td>Pickup Point</td>
											<td><b>:<?= $p['pu_poin'] ?></b> </td>
										</tr>
										<tr>
											<td>Destination</td>
											<td><b>:<?= $p['destination'] ?></b> </td>
											<td>Koli</td>
											<td><b>:<?= $p['koli'] ?></b> </td>
										</tr>
										<tr>
											<td>Kg</td>
											<td><b>:<?= $p['kg'] ?></b> </td>
											<td>Commodity</td>
											<td><b>:<?= $p['commodity'] ?></b> </td>
										</tr>
										<tr>
											<td>Service</td>
											<td><b>:<?= $p['service'] ?></b> </td>
											<td>Status</td>
											<td><b>:<?= ($p['status'] == 0) ? 'Process' : 'Selesai';   ?></b> </td>
										</tr>
										<tr>
											<td>Note</td>
											<td colspan="2"><b>:<?= $p['note'] ?></b> </td>
											<td></td>
										</tr>
									</table>
								</div>
								<!-- kalo dia bukan icoming -->
								<?php if ($p['is_incoming'] == 0) {
								?>
									<div class="col-md-4">
										<!-- kalo sales ordernya sudah di pickup -->
										<?php if ($p['status'] == 2) {
										?>
											<a href="#" class="btn font-weight-bolder text-light mb-4" data-toggle="modal" data-target="#modal-lg-dl-luar" style="background-color: #9c223b;">
												<span class="svg-icon svg-icon-md">
													<i class="fa fa-user text-light"></i>
													<!--end::Svg Icon-->
												</span>Shipment Out From Benhil HUB</a>
											<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
											<?php $tracking_real = $this->db->limit(1)->order_by('id_tracking', 'DESC')->get_where('tbl_tracking_real', ['id_so' => $p['id_so'], 'flag' => 5])->row_array();
											$order = $this->db->limit(1)->order_by('id_tracking', 'DESC')->get_where('tbl_tracking_real', ['id_so' => $p['id_so']])->row_array();
											// var_dump($tracking_real);
											// die;
											?>
											<div class="d-flex align-items-center mb-10">
												<?php if ($tracking_real == null) {
												?>

													<h4 class="title">No driver selected</h4>

												<?php	} else {
												?>
													<!--begin::Symbol-->
													<div class="symbol symbol-40 symbol-light-success mr-5">
														<span class="symbol-label">
															<img src="<?= base_url('assets/back/metronic/') ?>media/avatars/009-boy-4.svg" class="h-75 align-self-end" alt="">
														</span>
													</div>
													<!--end::Symbol-->
													<!--begin::Text-->
													<?php $driver = $this->db->get_where('tb_user', ['id_user' => $tracking_real['id_user']])->row_array(); ?>
													<div class="d-flex flex-column flex-grow-1 font-weight-bold">
														<a href="#" class="text-dark text-hover-primary mb-1 font-size-lg"><?= $driver['nama_user'] ?></a>
														<span class="text-muted">Driver</span>
													</div>
													<!--end::Text-->
												<?php	} ?>

											</div>
											<!-- kalo sales order nya belum di pickup -->
											<?php } elseif ($p['status'] == 0) {

											$tracking = $this->db->order_by('id_tracking', 'asc')->get_where('tbl_tracking_real', ['id_so' => $p['id_so']])->row_array();
											// cek apakah sudah diterima task oleh driver
											if ($tracking['flag'] == 2) {
											?>
												<div class="card-body">
													<p class="h-14"><i class="fa fa-info text-danger"></i> If you have Arrived, please input the order !</p>
													<!-- <div class="alert alert-success text-light" role="alert"> </div> -->
													<div class="card-toolbar">
														<a href="<?= base_url('shipper/order/view/' . $p['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
															<i class="fas fa-plus-circle text-light"> </i>
															Add Shipment
														</a>
													</div>
												</div>
											<?php	} else {
											?>
												<a href="#" class="btn font-weight-bolder text-light mb-4" data-toggle="modal" data-target="#modal-lg" style="background-color: #9c223b;">
													<span class="svg-icon svg-icon-md">
														<i class="fa fa-user text-light"></i>
														<!--end::Svg Icon-->
													</span>Asign Driver PU</a>
												<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
												<div class="d-flex align-items-center mb-10">
													<?php if ($tracking['id_user'] == null) {
													?>
														<h4 class="title">No driver selected</h4>
													<?php	} else {
													?>
														<!--begin::Symbol-->
														<div class="symbol symbol-40 symbol-light-success mr-5">
															<span class="symbol-label">
																<img src="<?= base_url('assets/back/metronic/') ?>media/avatars/009-boy-4.svg" class="h-75 align-self-end" alt="">
															</span>
														</div>
														<!--end::Symbol-->
														<!--begin::Text-->
														<?php $driver = $this->db->get_where('tb_user', ['id_user' => $tracking['id_user']])->row_array(); ?>
														<div class="d-flex flex-column flex-grow-1 font-weight-bold">
															<a href="#" class="text-dark text-hover-primary mb-1 font-size-lg"><?= $driver['nama_user'] ?></a>
															<span class="text-muted">Driver</span>
														</div>
														<!--end::Text-->
													<?php	} ?>
												</div>
											<?php	}
											?>
										<?php } else {
										?>
											<h4 class="title">Order Finished</h4>
										<?php	} ?>
									</div>

								<?php	} else {
								?>
									<div class="col-md-4">
										<h4 class="title">Incoming Order, wait until CS Process the Order .</h4>
									</div>
								<?php	} ?>

							</div>
							<div class="card-body" style="overflow: auto;">
								<table id="myTable" class="table table-bordered">
									<h3 class="title font-weight-bold">List Shipment</h3>
									<!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
									<p><?= $this->session->flashdata('message'); ?></p>
									<thead>
										<tr>
											<th style="width: 10%;">Shipment ID</th>
											<th style="width: 15%;">Shipper</th>
											<th>Destination</th>
											<th style="width: 15%;">Consignee</th>
											<!-- <th style="width: 20%;">Image</th> -->
											<!-- <th>Signature</th> -->
											<th>Last Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($shipment2 as $shp) {
											$get_last_status = $this->db->limit(1)->order_by('id_tracking', 'desc')->get_where('tbl_tracking_real', ['shipment_id' => $shp['shipment_id']])->row_array();
											// var_dump($get_last_status);
											// die;
										?>
											<tr>
												<td><a href="<?= base_url('shipper/salesOrder/print/' . $shp['shipment_id']) ?>"> <?= $shp['shipment_id'] ?></a></td>
												<td><?= $shp['shipper'] ?></td>
												<td><?= $shp['destination'] ?>, <?= $shp['city_consigne'] ?> <?= $shp['state_consigne'] ?></td>
												<td><?= $shp['consigne'] ?></td>
												<td style="color: green;"><?= $get_last_status['status'] ?> <?= $get_last_status['note'] ?>. <?= longdate_indo($get_last_status['created_at']), ' ' . $get_last_status['time'] ?>
													<br>
													<?php if ($get_last_status['flag'] == 11) {
													?>
														<a href="#" class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#modal-pod" style="background-color: #9c223b;">
															<span class="svg-icon svg-icon-md">
															</span>View POD</a>
													<?php	} ?>

												</td>
												<td>
													<!-- kalo dia bukan incoming -->
													<?php if ($p['is_incoming'] == 0) {
													?>
														<?php if ($get_last_status['flag'] >= 7  && $get_last_status['flag'] <= 10) {
														?>
															<a href="#" class="btn btn-sm text-light mb-1" data-toggle="modal" data-target="#modal-lg-dl-luar<?= $shp['shipment_id'] ?>" style="background-color: #9c223b;">
																<span class="svg-icon svg-icon-md">
																</span>Update Status</a>
															<a href="<?= base_url('shipper/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a>
															<a href="<?= base_url('shipper/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
														<?php } else {
														?>
															<a href="<?= base_url('shipper/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
														<?php	} ?>
														<?php	} else {

														if ($get_last_status['flag'] == 5  && $get_last_status['flag'] <= 6) {
														?>
															<span class="badge badge-secondary mb-1">Menunggu scan in/out HUB</span>
															<a href="<?= base_url('shipper/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a>
															<a href="<?= base_url('shipper/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
														<?php	} elseif ($get_last_status['flag'] == 11) {
														?>
															<!-- <a href="#" class="btn btn-sm text-light mb-1" data-toggle="modal" data-target="#modal-lg-dl-incoming<?= $shp['shipment_id'] ?>" style="background-color: #9c223b;">
															<span class="svg-icon svg-icon-md">
															</span>Update Status</a>
														<a href="<?= base_url('shipper/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a> -->
															<a href="<?= base_url('shipper/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>

														<?php	} else {
														?>
															<a href="#" class="btn btn-sm text-light mb-1" data-toggle="modal" data-target="#modal-lg-dl-incoming<?= $shp['shipment_id'] ?>" style="background-color: #9c223b;">
																<span class="svg-icon svg-icon-md">
																</span>Update Status</a>
															<a href="<?= base_url('shipper/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a>
															<a href="<?= base_url('shipper/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>

														<?php	}
														?>

													<?php	} ?>
												</td>
											</tr>

										<?php } ?>
									</tbody>


								</table>
							</div>

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
					<h4 class="modal-title">Assign Driver PU</h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('shipper/salesOrder/assignDriver') ?>" method="POST">
						<div class="card-body">
							<div class="row">
								<input type="text" name="id_so" class="form-control" hidden value="<?= $p['id_so'] ?>">
								<div class="col-md-12">
									<label for="id_driver">Choose Driver : </label>
									<select name="id_driver" class="form-control" style="width: 200px;">
										<?php foreach ($users as $u) {
										?>
											<option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
										<?php	} ?>
									</select>

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

	<div class="modal fade" id="modal-lg-dl">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Assign Driver DL</h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('shipper/salesOrder/assignDriverDl') ?>" method="POST">
						<div class="card-body">
							<div class="row">
								<input type="text" name="id_so" class="form-control" hidden value="<?= $p['id_so'] ?>">
								<input type="text" name="shipment_id" class="form-control" hidden value="<?= $order['shipment_id'] ?>">
								<div class="col-md-12">
									<label for="id_driver">Choose Driver : </label>
									<select name="id_driver" class="form-control" style="width: 200px;">
										<?php foreach ($users as $u) {
										?>
											<option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
										<?php	} ?>
									</select>

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

	<div class="modal fade" id="modal-lg-dl-luar">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Assign Driver & Map Gateway</h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('shipper/salesOrder/assignDriverHub') ?>" method="POST">
						<div class="card-body">
							<div class="row">
								<input type="text" name="id_so" class="form-control" hidden value="<?= $p['id_so'] ?>">
								<input type="text" name="shipment_id" class="form-control" hidden value="<?= $order['shipment_id'] ?>">
								<div class="col-md-6">
									<label for="id_driver">Choose Driver : </label>
									<select name="id_driver" class="form-control" style="width: 200px;">
										<?php foreach ($users as $u) {
										?>
											<option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
										<?php	} ?>
									</select>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Choose Gateway ?</label>
										<div class="form-check">
											<input class="radioBtnClass" type="radio" name="gateway" value="ops">
											<label class="form-check-label" for="flexRadioDefault1">
												OPS
											</label>
										</div>
										<div class="form-check">
											<input class="radioBtnClass" type="radio" name="gateway" value="cs">
											<label class="form-check-label" for="flexRadioDefault1">
												CS
											</label>
										</div>
									</div>

								</div>
								<div class="col-md-6" id="driver2" style="display: none;">
									<label for="id_driver">Choose Gateway : </label>
									<select name="driver_gateway" class="form-control" style="width: 200px;">
										<?php foreach ($users as $u) {
										?>
											<option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
										<?php	} ?>
									</select>
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




	<div class="modal fade" id="modal-pod">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">POD</h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('cs/salesOrder/updateShipment') ?>" method="POST" enctype="multipart/form-data">
						<div class="card-body">
							<div class="row">
								<input type="text" name="id_so" class="form-control" hidden value="<?= $p['id_so'] ?>">
								<!-- <input type="text" name="shipment_id" class="form-control" hidden value="<?= $order['shipment_id'] ?>"> -->
								<?php $files = explode('+', $shp['image']);
								$no = 1;
								foreach ($files as $file) {
								?>
									<div class="col-md-6">
										<b>Image <?= $no ?> :</b> <img src="<?= base_url('uploads/berkas/') . $file ?>" height="100" width="200"> <br>
										<?php $no++; ?>
									</div>
								<?php	} ?>

							</div>
						</div>
						<!-- /.card-body -->
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<!-- <button type="submit" class="btn btn-primary">Submit</button> -->
				</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>