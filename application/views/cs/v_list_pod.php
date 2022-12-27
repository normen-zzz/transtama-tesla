	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h2 class="card-title">POD TRACKING
								<div class="row">
									<form action="<?= base_url('cs/Pod/list') ?>" method="POST">
										<div class="row ml-2">
											<div class="form-group mr-2">
												<label>Start</label><br>
												<input type="date" <?php if ($awal != NULL) { ?> value="<?= $awal ?>" <?php } ?> name="awal" id="awal" class="form-control">


											</div>
											<div class="form-group mr-3">
												<label>End</label> <br>
												<input type="date" <?php if ($akhir != NULL) { ?> value="<?= $akhir ?>" <?php } ?> name="akhir" id="akhir" class="form-control">
											</div>

											<div class="form-group"> <br>
												<button type="submit" class="btn btn-success ml-3">Tampilkan</button>
												<a href="<?= base_url('superadmin/SalesTracker') ?>" class="btn btn-primary ml-1">Reset Filter</a>
											</div>
										</div>

									</form>
								</div>
						</div>

						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<table id="myTable2" class="table table-bordered">
								<!-- <a href="<?= base_url('shipper/order/add') ?>" class="btn btn-success mr-2 mb-4">
									<i class="fas fa-plus-circle"> </i>Add
								</a> -->
								<!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
								<p><?= $this->session->flashdata('message'); ?></p>
								<thead>
									<tr>
										<th style="width: 15%;">Request Pickup</th>
										<th style="width: 15%;">Shipment Id</th>
										<th style="width: 15%;">Shipper</th>
										<th style="width: 10%;">Consignee</th>
										<th>Status POD</th>
										<th>Tgl Diterima</th>
										<th>Tgl Pod Tiba</th>
										<th>KPI POD</th>
										<th>Action</th>

									</tr>
								</thead>
								<tbody>
									<?php foreach ($shipment->result_array() as $shipment) {

										$trackingPod = $this->db->get_where('tbl_tracking_pod', array('shipment_id' => $shipment['shipment_id']))->row_array();
										if (isset($trackingPod['tgl_sampe']) == NULL) {
											$tgl_pod = 'POD Pending';
										} else {
											$tgl_pod = $trackingPod['tgl_sampe'];
										}
										// note
										// 1. P = tgl_pickup - tgl_pod_tiba
										// 2. R,A = tgl_diterima - tgl_pod_tiba
										$prioritas_cek = $shipment['shipper'];
										$tgl1 = '';
										$kategori = '';
										if (customerPrioritas($prioritas_cek)) {
											$tgl1 = strtotime($shipment['tgl_diterima']);
											$kategori = 'Prioritas';
										} elseif (customerReguler($prioritas_cek)) {
											$tgl1 = strtotime($shipment['tgl_diterima']);
											$kategori = 'Reguler';
										} else {
											$tgl1 = strtotime($shipment['tgl_diterima']);
											$kategori = 'Agen';
										}

										// KPI
										$tgl2 = strtotime($tgl_pod);
										$jarak = $tgl2 - $tgl1;
										$hari = $jarak / 60 / 60 / 24;
										$kpi = cekJenisCustomer($shipment['shipper'], $hari, $shipment['no_smu']);
										$status_pod = $shipment['status_pod'];
										$action = '';
										if ($status_pod == 0) {
											$action = '<a data-toggle="modal" data-id="' . $shipment['shipment_id'] . '" data-shipper="' . $shipment['shipper'] . '" 
								data-consigne="' . $shipment['consigne'] . '"  data-destination="' . $shipment['destination'] . '"
								title="OTW Jakarta" class="open-AddBookDialog btn btn-icon
								 waves-effect waves-light btn-danger btn-rounded" href="#addBookDialog"><i class="fas fa-car"></i></a>';
										} elseif ($status_pod == 1) {
											$action = '<a data-toggle="modal" data-id="' . $shipment['shipment_id'] . '" data-shipper="' . $shipment['shipper'] . '" 
								data-consigne="' . $shipment['consigne'] . '"  data-destination="' . $shipment['destination'] . '"
								title="Arrive Jakarta" class="open-Arrive btn btn-icon
								 waves-effect waves-light btn-primary btn-rounded" href="#arrive"> <i class="fas fa-book"></i> </a>';
										} else {
											$action = '<a title="Finish" class="btn btn-icon waves-effect waves-light btn-success btn-rounded text-light"> <i class="fas fa-check"></i> </a>';
										}
										$status = '';
										$kpi_result = '';
										if ($status_pod == 0) {
											$status = '<span class="badge badge-danger">Pending</span>';
										} elseif ($status_pod == 1) {
											$status = '<span class="badge badge-primary">On Delivery</span>';
										} else {
											$status = '<span class="badge badge-success">Arrive</span>';
											$kpi_result = $hari . ' Hari -> ' . $kpi;
										}



									?>
										<tr>
											<td><?= date('d F Y', strtotime($shipment['tgl_pickup']))  ?></td>
											<td><?= $shipment['shipment_id'] ?></td>
											<td><?= $shipment['shipper'] ?></td>
											<td><?= $shipment['consigne'] ?></td>
											<td><?= $status; ?></td>
											<td><?php if ($shipment['tgl_diterima'] != NULL) {
													echo date('d F Y', strtotime($shipment['tgl_diterima']));
												}  ?></td>
											<td><?php
												if ($trackingPod != NULL) {
													if ($trackingPod['tgl_sampe'] != NULL) {
														echo date('d F Y', strtotime($trackingPod['tgl_sampe']));
													} else {
														echo 'Belum Sampai';
													}
												} else {
													echo 'Belum Sampai';
												} ?></td>
											<td><?php if ($shipment['tgl_diterima'] != NULL) {
													$kpi_result;
												}  ?></td>
											<td><?php

												if ($shipment != NULL) {


													if ($shipment['status_pod'] == 0) {
														$action = '<a data-toggle="modal" data-id="' . $shipment['shipment_id'] . '" data-shipper="' . $shipment['shipper'] . '" 
data-consigne="' . $shipment['consigne'] . '"  data-destination="' . $shipment['destination'] . '"
title="OTW Jakarta" class="open-modalOtw btn btn-icon
waves-effect waves-light btn-danger btn-rounded" href="#modalOtw' . $shipment['shipment_id'] . '"><i class="fas fa-car"></i></a>';
													} elseif ($shipment['status_pod'] == 1) {
														$action = '<a data-toggle="modal" data-id="' . $shipment['shipment_id'] . '" data-shipper="' . $shipment['shipper'] . '" 
data-consigne="' . $shipment['consigne'] . '"  data-destination="' . $shipment['destination'] . '"
title="Arrive Jakarta" class="open-Arrive btn btn-icon
waves-effect waves-light btn-primary btn-rounded" href="#arrive' . $shipment["shipment_id"] . '"> <i class="fas fa-book"></i> </a>';
													} else {
														$action = '<a title="Finish" class="btn btn-icon waves-effect waves-light btn-success btn-rounded text-light"> <i class="fas fa-check"></i> </a>';
													}

													echo $action;

												?>
												<?php }
												?></td>
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

	<?php if ($shipmentOtw != NULL) {
		foreach ($shipmentOtw->result_array() as $shipment) {
	?>
			<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="modalOtw<?= $shipment['shipment_id'] ?>">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myLargeModalLabel">Are You Sure This POD <input type="text" disabled value="<?= $shipment['shipment_id'] ?>"> Will Coming To Jakarta ?
							</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						</div>
						<form role="form" action="<?= base_url('cs/Pod/otw') ?>" method="POST" class="form-horizontal">
							<div class="modal-body">

								<div class="row">
									<div class="col-12">
										<div class="card-box">
											<div class="p-2">

												<div class="form-group row">
													<label class="col-md-2 col-form-label" for="example-input-small">Shipper</label>
													<div class="col-md-10">
														<input type="text" id="id" hidden name="shipment_id" value="<?= $shipment['shipment_id']; ?>">
														<input type="text" disabled id="shipper" value="<?= $shipment['shipper'] ?>" name="example-input-small" class="form-control form-control-sm" placeholder=".input-sm">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" for="example-input-normal">Consignee</label>
													<div class="col-md-10">
														<input type="text" disabled name="consigne" class="form-control" value="<?= $shipment['consigne'] ?>" id="consigne" value="" class="form-control" placeholder="Normal">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" for="example-input-large">Destination</label>
													<div class="col-md-10">
														<input type="text" disabled name="destination" id="destination" value="<?= $shipment['destination'] ?>" class="form-control form-control-lg" placeholder=".input-lg">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-2 col-form-label" for="example-input-large">Date Comming</label>
													<div class="col-md-10">
														<input type="date" required name="tgl_otw" class="form-control form-control-lg" placeholder=".input-lg">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-2 col-form-label" for="example-input-large">Provider</label>
													<div class="col-md-10">
														<input type="text" name="provider" class="form-control form-control-lg" placeholder="Ex: Jne">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-2 col-form-label" for="example-input-large">No Resi</label>
													<div class="col-md-10">
														<input type="text" name="resi" class="form-control form-control-lg" placeholder="Ex: 12345abcd">
													</div>
												</div>


											</div>
										</div> <!-- end card-box -->
									</div> <!-- end col -->
								</div>
								<!-- end row -->
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
								<button type="submit" class="btn btn-primary">Yes</button>
							</div>
						</form>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
	<?php }
	} ?>


	<?php if ($shipmentArrive != NULL) {

		foreach ($shipmentArrive->result_array() as $shipment) { ?>
			<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="arrive<?= $shipment['shipment_id'] ?>">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myLargeModalLabel">Are You Sure This POD Has Arrived ?
							</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						</div>
						<form role="form" action="<?= base_url('cs/Pod/arrive') ?>" method="POST" class="form-horizontal">
							<div class="modal-body">

								<div class="row">
									<div class="col-12">
										<div class="card-box">
											<div class="p-2">

												<div class="form-group row">
													<label class="col-md-2 col-form-label" for="example-input-small">Shipment ID</label>
													<div class="col-md-10">
														<input type="text" id="id" value="" name="example-input-small" class="form-control form-control-sm" placeholder=".input-sm">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-2 col-form-label" for="example-input-small">Shipper</label>
													<div class="col-md-10">
														<input type="text" id="id" hidden name="shipment_id" value="<?= $shipment['shipment_id']; ?>">
														<input type="text" disabled id="shipper" value="<?= $shipment['shipper'] ?>" name="example-input-small" class="form-control form-control-sm" placeholder=".input-sm">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" for="example-input-normal">Consignee</label>
													<div class="col-md-10">
														<input type="text" name="consigne" class="form-control" value="<?= $shipment['consigne'] ?>" disabled id="consigne" value="" class="form-control" placeholder="Normal">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" for="example-input-large">Destination</label>
													<div class="col-md-10">
														<input type="text" name="destination" id="destination" value="<?= $shipment['destination'] ?>" disabled class="form-control form-control-lg" placeholder=".input-lg">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-2 col-form-label" for="example-input-large">Date Arrive</label>
													<div class="col-md-10">
														<input type="date" required name="tgl_sampe" class="form-control form-control-lg" placeholder=".input-lg">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-2 col-form-label" for="example-input-large">Receiver's Name</label>
													<div class="col-md-10">
														<input type="text" name="penerima" class="form-control form-control-lg" placeholder="Ex : Hamzah">
													</div>
												</div>



											</div>
										</div> <!-- end card-box -->
									</div> <!-- end col -->
								</div>
								<!-- end row -->
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
								<button type="submit" class="btn btn-primary">Yes</button>
							</div>
						</form>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
	<?php }
	} ?>