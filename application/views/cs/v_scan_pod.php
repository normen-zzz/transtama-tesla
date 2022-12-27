<link rel="stylesheet" href="<?php echo base_url() ?>assets/scans/css/style.css">
<?php
date_default_timezone_set('Asia/Jakarta');
setlocale(LC_TIME, "id_ID.UTF8");
?>
<!-- Main content -->
<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="container">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-12">
				<div class="card card-custom card-stretch">
					<div class="card-header py-3">
						<div class="card-title align-items-start flex-column">
							<h3 class="card-label font-weight-bolder text-dark">POD Tracking</h3>
							<span class="text-muted font-weight-bold font-size-sm mt-1">Input Shipment Number</span>
						</div>
						<div class="card-toolbar">

						</div>
					</div>
					<?php
					if ($resi != NULL) {


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
					}
					?>
					<!-- /.card-header -->
					<div class="card-body" style="overflow: auto;">
						<div class="row">
							<div class="col-md-4">
								<form action="<?= base_url('cs/Pod') ?>" method="POST">


									<label for="shipment_id">Shipment ID</label>
									<input type="text" class="form-control" name="shipment_id" <?php if ($resi != NULL) { ?> value="<?= $resi ?>" <?php } ?>>
									<button type="submit" class="btn btn-success mt-2">View</button>
									<!-- <div class="navbar-form navbar-center">
										<select class="form-control" id="selectCamCs" style="width: 80%;"></select>
									</div>
									<canvas class="mt-2" id="cobascanCS" width="400" height="400"></canvas> -->
								</form>
							</div>
							<div class="col-md-8">
								<div class="row">
									<div class="col text-center">
										<h2>POD TRACKING <?php if ($resi != NULL) {
																echo $resi;
															} ?></h2>

										<?php if ($resi != NULL) { ?>
											<table class="table table-borderless table-striped" style="border-top: none;">
												<tr>
													<td>
														<h5>Customer :</h5>
													</td>
													<td>
														<h6><?= $shipment['shipper'] ?></h6>
													</td>
												</tr>
												<tr>
													<td>
														<h5>Consignee :</h5>
													</td>
													<td>
														<h6><?= $shipment['consigne'] ?></h6>
													</td>
												</tr>
												<tr>
													<td>
														<h5>Request Pickup :</h5>
													</td>
													<td>
														<h6><?php if ($shipment['tgl_pickup'] != NULL) {
																echo date('d F Y', strtotime($shipment['tgl_pickup']));
															} else {
																echo 'Belum Diterima';
															}  ?></h6>
													</td>
												</tr>
												<tr>
													<td>
														<h5>Status POD :</h5>
													</td>
													<td>
														<h6><?= $status ?></h6>
													</td>
												</tr>

												<tr>
													<td>
														<h5>Tgl Barang Diterima :</h5>
													</td>
													<td>
														<h6><?php if ($shipment['tgl_diterima'] != NULL) {
																echo date('d F Y', strtotime($shipment['tgl_diterima']));
															} else {
																echo 'Belum Diterima';
															}  ?></h6>
													</td>
												</tr>

												<tr>
													<td>
														<h5>Tgl Pod Jalan :</h5>
													</td>
													<td>
														<h6><?php
															if ($trackingPod != NULL) {
																if ($trackingPod['tgl_otw'] != NULL) {
																	echo date('d F Y', strtotime($trackingPod['tgl_otw']));
																} else {
																	echo 'Belum Jalan';
																}
															} else {
																echo 'Belum Jalan';
															} ?></h6>
													</td>
												</tr>

												<tr>
													<td>
														<h5>Provider :</h5>
													</td>
													<td>
														<h6><?php
															if ($trackingPod != NULL) {


																if ($trackingPod['provider'] != NULL) {
																	echo $trackingPod['provider'];
																} else {
																	echo 'None';
																}
															} else {
																echo 'None';
															}  ?></h6>
													</td>
												</tr>

												<tr>
													<td>
														<h5>No Resi Provider :</h5>
													</td>
													<td>
														<h6><?php
															if ($trackingPod != NULL) {
																if ($trackingPod['resi'] != NULL) {
																	echo $trackingPod['resi'];
																} else {
																	echo 'Belum Ada Resi';
																}
															} else {
																echo 'Belum Ada Resi';
															} ?></h6>
													</td>
												</tr>

												<tr>
													<td>
														<h5>Tgl Pod Tiba :</h5>
													</td>
													<td>
														<h6><?php
															if ($trackingPod != NULL) {
																if ($trackingPod['tgl_sampe'] != NULL) {
																	echo date('d F Y', strtotime($trackingPod['tgl_sampe']));
																} else {
																	echo 'Belum Sampai';
																}
															} else {
																echo 'Belum Sampai';
															} ?></h6>
													</td>
												</tr>

												<tr>
													<td>
														<h5>Received By :</h5>
													</td>
													<td>
														<h6><?php
															if ($trackingPod != NULL) {
																if ($trackingPod['penerima'] != NULL) {
																	echo $trackingPod['penerima'];
																} else {
																	echo 'Belum Ada Penerima';
																}
															} else {
																echo 'Belum Ada Penerima';
															} ?></h6>
													</td>
												</tr>



												<tr>
													<td>
														<h5>Update POD By :</h5>
													</td>
													<td>
														<h6><?php
															if ($trackingPod != NULL) {
																if ($trackingPod['created_by'] != NULL) {
																	echo $trackingPod['created_by'];
																} else {
																	echo 'Belum Ada Update';
																}
															} else {
																echo 'Belum Ada Update';
															} ?></h6>
													</td>
												</tr>

												<tr>
													<td>
														<h5>KPI POD :</h5>
													</td>
													<td>
														<h6><?= $kpi_result; ?></h6>
													</td>
												</tr>

											</table>
										<?php } ?>
										<?php

										if ($shipment != NULL) {


											if ($shipment['status_pod'] == 0) {
												$action = '<a data-toggle="modal" data-id="' . $shipment['shipment_id'] . '" data-shipper="' . $shipment['shipper'] . '" 
data-consigne="' . $shipment['consigne'] . '"  data-destination="' . $shipment['destination'] . '"
title="OTW Jakarta" class="open-modalOtw btn btn-icon
waves-effect waves-light btn-danger btn-rounded" href="#modalOtw"><i class="fas fa-car"></i></a>';
											} elseif ($shipment['status_pod'] == 1) {
												$action = '<a data-toggle="modal" data-id="' . $shipment['shipment_id'] . '" data-shipper="' . $shipment['shipper'] . '" 
data-consigne="' . $shipment['consigne'] . '"  data-destination="' . $shipment['destination'] . '"
title="Arrive Jakarta" class="open-Arrive btn btn-icon
waves-effect waves-light btn-primary btn-rounded" href="#arrive"> <i class="fas fa-book"></i> </a>';
											} else {
												$action = '<a title="Finish" class="btn btn-icon waves-effect waves-light btn-success btn-rounded text-light"> <i class="fas fa-check"></i> </a>';
											}

											echo $action;

										?>
										<?php }
										?>
									</div>


								</div>
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
	<?php if ($shipment != NULL) { ?>
		<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="modalOtw">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myLargeModalLabel">Are You Sure This POD <input type="text" disabled value="<?php if ($resi != NULL) {
																																	echo $resi;
																																}  ?>"> Will Coming To Jakarta ?
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
													<input type="text" id="id" hidden name="shipment_id" value="<?= $resi; ?>">
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
	<?php } ?>


	<?php if ($shipment != NULL) { ?>
		<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="arrive">
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
													<input type="text" id="id" hidden name="shipment_id" value="<?= $resi; ?>">
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
	<?php } ?>

</section>
<!-- /.content -->