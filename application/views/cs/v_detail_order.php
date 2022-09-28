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
								<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('shipper/salesOrder') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
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
										<h4 class="title"></h4>
									</div>

								<?php	} else {
								?>
									<div class="col-md-4">
										<!-- kalo sales ordernya sudah di pickup -->
										<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/salesOrder/add/' . $p['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
											<i class="fas fa-plus-circle text-light"> </i>
											Single Order
										</a>
										<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/salesOrder/bulk/' . $p['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
											<i class="fas fa-plus-circle text-light"> </i>
											Bulk Order
										</a>
										<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>

									</div>

								<?php	} ?>

							</div>

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
									?>
										<tr>
											<td><?= $shp['shipment_id'] ?></td>
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
												<?php if ($get_last_status['flag'] >= 7  && $get_last_status['flag'] <= 10) {
												?>
													<a href="#" class="btn btn-sm text-light mb-1" data-toggle="modal" data-target="#modal-lg-dl-luar" style="background-color: #9c223b;">
														<span class="svg-icon svg-icon-md">
														</span>Update</a>
													<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a>
													<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
												<?php } else {
												?>
													<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
												<?php	} ?>
											</td>
										</tr>

									<?php } ?>
								</tbody>


							</table>
						</div>

					</div>
					<!-- /.card-body -->
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
										<td><a href="<?= base_url('cs/salesOrder/print/' . $shp['shipment_id']) ?>"> <?= $shp['shipment_id'] ?></a></td>
										<td><?= $shp['shipper'] ?></td>
										<td><?= $shp['destination'] ?>, <?= $shp['city_consigne'] ?> <?= $shp['state_consigne'] ?></td>
										<td><?= $shp['consigne'] ?></td>
										<td style="color: green;"><?= $get_last_status['status'] ?> <?= $get_last_status['note'] ?>. <?= longdate_indo($get_last_status['created_at']), ' ' . $get_last_status['time'] ?>
											<br>
											<?php if ($get_last_status['flag'] == 11 || $get_last_status['flag'] == 5 || $get_last_status['flag'] == 7) {
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
													<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a>
													<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
												<?php } else {
												?>
													<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
												<?php	} ?>
												<?php	} else {

												if ($get_last_status['flag'] == 5  && $get_last_status['flag'] <= 6) {
												?>
													<span class="badge badge-secondary mb-1">Menunggu scan in/out HUB</span>
													<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a>
													<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
												<?php	} elseif ($get_last_status['flag'] == 11) {
												?>
													<!-- <a href="#" class="btn btn-sm text-light mb-1" data-toggle="modal" data-target="#modal-lg-dl-incoming<?= $shp['shipment_id'] ?>" style="background-color: #9c223b;">
															<span class="svg-icon svg-icon-md">
															</span>Update Status</a>
														<a href="<?= base_url('cs/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a> -->
													<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>

												<?php	} else {
												?>
													<a href="#" class="btn btn-sm text-light mb-1" data-toggle="modal" data-target="#modal-lg-dl-incoming<?= $shp['shipment_id'] ?>" style="background-color: #9c223b;">
														<span class="svg-icon svg-icon-md">
														</span>Update Status</a>
													<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a>
													<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>

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
				<!-- /.card -->
			</div>

		</div>
		<!-- /.row -->
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