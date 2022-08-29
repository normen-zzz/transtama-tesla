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
								<a href="<?= base_url('cs/salesOrder') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-chevron-circle-left text-light"> </i>
									Back
								</a>
							</div>
						</div>

						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<div class="row">
								<div class="col-md-12">
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
												<th>Last Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($shipment2 as $shp) {
												$get_last_status = $this->db->limit(1)->order_by('id_tracking', 'desc')->get_where('tbl_tracking_real', ['shipment_id' => $shp['shipment_id']])->row_array();
											?>
												<tr>
													<td><a href="<?= base_url('cs/order/print/' . $shp['shipment_id']) ?>"> <?= $shp['shipment_id'] ?></a></td>
													<td><?= $shp['shipper'] ?></td>
													<td><?= $shp['destination'] ?>, <?= $shp['city_consigne'] ?>, <?= $shp['state_consigne'] ?></td>
													<td><?= $shp['consigne'] ?></td>

													<?php if ($shp['service_name'] == 'Same Day Service') {
													?>
														<td style="color: green;"><?= $get_last_status['status'] ?> <br> <?= longdate_indo($get_last_status['created_at']), ' ' . $get_last_status['time'] ?>
															<br>
															<?php if ($get_last_status['flag'] == 5) {
															?>
																<a href="#" class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#modal-pod<?= $shp['shipment_id'] ?>" style="background-color: #9c223b;">
																	<span class="svg-icon svg-icon-md">
																	</span>View POD</a>
															<?php	} ?>

														</td>
													<?php } else {
													?>
														<td style="color: green;"><?= $get_last_status['status'] ?> <br> <?= longdate_indo($get_last_status['created_at']), ' ' . $get_last_status['time'] ?>
															<br>
															<?php if ($get_last_status['flag'] == 11) {
															?>
																<a href="#" class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#modal-pod<?= $shp['shipment_id'] ?>" style="background-color: #9c223b;">
																	<span class="svg-icon svg-icon-md">
																	</span>View POD</a>
															<?php	} ?>

														</td>

													<?php	} ?>

													<td>

														<a href="<?= base_url('cs/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
													</td>
												</tr>

											<?php } ?>
										</tbody>


									</table>
								</div>
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

	<?php foreach ($shipment2 as $shp) {
	?>
		<div class="modal fade" id="modal-pod<?= $shp['shipment_id'] ?>">
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
									<?php
									$get_last_status = $this->db->limit(1)->order_by('id_tracking', 'desc')->get_where('tbl_tracking_real', ['shipment_id' => $shp['shipment_id']])->row_array();
									?>
									<?php $files = explode('+', $get_last_status['bukti']);
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
	<?php } ?>