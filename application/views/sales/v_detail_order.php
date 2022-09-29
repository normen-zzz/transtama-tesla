	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch">
						<div class="card-header py-3">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bolder text-dark">Detail Request Pickup </h3>
								<!-- <span class="text-muted font-weight-bold font-size-sm mt-1">Shipment ID :<b> <?= $p['shipment_id'] ?></b></span>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Order ID :<b> <?= $p['order_id'] ?></b></span> -->
							</div>
							<div class="card-toolbar">
								<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-chevron-circle-left text-light"> </i>
									Back
								</a>
							</div>
						</div>

						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<?php if ($shipment2) {
								echo '';
							} else {
							?>
								<div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="step-first" data-wizard-clickable="true">
									<!--begin: Wizard Nav-->

									<!--end: Wizard Nav-->
									<!--begin: Wizard Body-->
									<div class="row justify-content-center py-10 px-8 py-lg-12 px-lg-10">
										<div class="col-xl-12 col-xxl-7">
											<!--begin: Wizard Form-->
											<form id="kt_form" novalidate="novalidate" action="<?= base_url('sales/salesOrder/processEditOrder') ?>" method="POST" enctype="multipart/form-data">
												<!--begin: Wizard Step 1-->
												<div class="pb-5" style="margin-top: -65px;">
													<h4 class="mb-10 font-weight-bold text-dark"><b>1. Sales Order Information</b> </h4>
													<?= $this->session->userdata('message') ?>
													<?php echo validation_errors(); ?>

													<!--begin::Input-->
													<div class="row">
														<div class="col-md-1">
															<div class="form-group">
																<!-- <label for="exampleInputEmail1">Is Incoming ?<span style="color: red;">*</span></label> -->
																<div class="form-check">
																	<input class="form-check-input" type="radio" name="is_incoming" id="flexRadioDefault1" disabled value="1" <?php if ($p['is_incoming'] == 1) {
																																													echo 'checked';
																																												} ?>>
																	<label class="form-check-label" for="flexRadioDefault1">
																		Incoming
																	</label>
																</div>
																<div class="form-check">
																	<input class="form-check-input" type="radio" name="is_incoming" id="flexRadioDefault2" disabled value="0" <?php if ($p['is_incoming'] == 0) {
																																													echo 'checked';
																																												} ?>>
																	<label class="form-check-label" for="flexRadioDefault2">
																		Outgoing
																	</label>
																</div>
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label for="exampleInputPassword1">Destination<span style="color: red;">*</span></label>
																<textarea name="destination" class="form-control" disabled required><?php echo set_value('destination'); ?><?= $p['destination'] ?></textarea>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Shipper<span style="color: red;">*</span></label>
																<div id="prefetch">
																	<input type="text" class="form-control" disabled id="shipper" required name="shipper" value="<?= $p['shipper'] ?>">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Shipper Address</label>
																<div id="prefetch">
																	<input type="text" class="form-control" disabled id="shipper_address" name="shipper_address" value="<?= $p['shipper_address'] ?>">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Consignee</label>
																<div id="prefetch">
																	<input type="text" class="form-control" disabled name="consigne" value="<?= $p['consigne'] ?>">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Consignee Address</label>
																<div id="prefetch">
																	<input type="text" class="form-control" disabled name="consigne_address" value="<?= $p['consigne_address'] ?>">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Payment</label>
																<div class="form-check">
																	<input class="form-check-input" disabled name="payment" type="checkbox" value="Cash" id="flexCheckDefault" <?php if ($p['payment'] == "Cash") {
																																													echo 'checked';
																																												} ?>>
																	<label class="form-check-label" for="flexCheckDefault">
																		Cash
																	</label>
																</div>
																<div class="form-check">
																	<input class="form-check-input" disabled name="payment" type="checkbox" value="Credit" id="flexCheckChecked" <?php if ($p['payment'] == "Credit") {
																																														echo 'checked';
																																													} ?>>
																	<label class="form-check-label" for="flexCheckChecked">
																		Credit
																	</label>
																</div>
															</div>
														</div>
													</div>
													<hr>
													<h4 class="mb-10 font-weight-bold text-dark"><b>2. Pickup Information</b> </small>
														<br> <br>
														<div class="row">
															<div class="col-md-2">
																<div class="form-group">
																	<label for="exampleInputEmail1">Pickup Date<span style="color: red;">*</span></label>
																	<input type="date" class="form-control" disabled id="tgl_pickup" required name="tgl_pickup" value="<?= $p['tgl_pickup'] ?>">
																</div>
															</div>
															<div class="col-md-2">
																<div class="form-group">
																	<label for="exampleInputEmail1">Pickup Time<span style="color: red;">*</span></label>
																	<input type="time" class="form-control" disabled required name="time" value="<?= $p['time'] ?>">
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<label for="exampleInputEmail1">Moda <span style="color: red;">*</span></label>
																	<select name="pu_moda" class="form-control" disabled>
																		<?php foreach ($moda as $s) {
																		?>
																			<option value="<?= $s['nama_moda'] ?>" <?php if ($s['nama_moda'] == $p['pu_moda']) {
																														echo 'selected';
																													} ?>><?= $s['nama_moda'] ?></option>
																		<?php  } ?>
																	</select>
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<label for="exampleInputEmail1">Packing</label>
																	<select name="packing" class="form-control" disabled>
																		<option value="NULL">None</option>
																		<?php foreach ($packing as $s) {
																		?>
																			<option value="<?= $s['nama_packing'] ?>" <?php if ($s['nama_packing'] == $p['packing']) {
																															echo 'selected';
																														} ?>><?= $s['nama_packing'] ?></option>
																		<?php  } ?>
																	</select>
																</div>
															</div>

															<div class="col-md-4">
																<div class="form-group">
																	<label for="exampleInputEmail1">Pickup Point<span style="color: red;">*</span></label>
																	<input type="text" class="form-control" disabled required name="pu_poin" value="<?= $p['pu_poin'] ?>">
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<label for="exampleInputEmail1">Service Type <span style="color: red;">*</span></label>
																	<select name="service" class="form-control" disabled>
																		<?php foreach ($service as $s) {
																		?>
																			<option value="<?= $s['service_name'] ?>" <?php if ($s['service_name'] ==  $p['service']) {
																															echo 'selected';
																														} ?>><?= $s['service_name'] ?></option>
																		<?php  } ?>
																	</select>
																</div>
															</div>
															<div class="col-md-3">
																<div class="form-group">
																	<label for="exampleInputEmail1">Commodity<span style="color: red;">*</span></label>
																	<input type="text" disabled class="form-control" required name="commodity" value="<?= $p['commodity'] ?>">
																</div>
															</div>
															<div class="col-md-1">
																<div class="form-group">
																	<label for="exampleInputEmail1">Koli</label>
																	<input type="number" disabled class="form-control" required name="koli" value="<?= $p['koli'] ?>">
																</div>
															</div>

															<div class="col-md-4">
																<div class="form-group">
																	<label for="exampleInputPassword1">Note </label>
																	<textarea name="note" disabled class="form-control"><?= $p['note'] ?></textarea>
																</div>
															</div>


														</div>

												</div>

												<!--end: Wizard Actions-->
											</form>
											<!--end: Wizard Form-->
										</div>
									</div>
									<!--end: Wizard Body-->
								</div>

							<?php	} ?>

							<div class="row">
								<div class="col-md-12">
									<form action="<?= base_url('sales/salesOrder/prosesSo') ?>" method="POST">
										<table id="myTablee" class="table table-bordered" style="width: 500%;">
											<?php if ($p['status'] == 5) {
											?>
												<h3 class="title font-weight-bold">Request Canceled</h3>
												<h6 class="title font-weight-bold">Reason : <?= $p['alasan_cancel'] ?></h6>


											<?php	} else {
											?>
												<h3 class="title font-weight-bold">List Sales Order</h3>
												<a href="<?= base_url('sales/salesOrder/export/' . $p['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
													<i class="fas fa-download text-light"> </i>
													Export SO
												</a>
												<?php if ($p['lock'] == 0) {
												?>
													<a href="#" class="btn mr-2 text-light" data-toggle="modal" data-target="#modal-import" style="background-color: #9c223b;">
														<i class="fas fa-upload text-light"> </i>
														Import SO
													</a>
												<?php } ?>

											<?php	} ?>
											<p><?= $this->session->flashdata('message'); ?></p>
											<thead>
												<tr>
													<th style="width: 10%;">Shipment ID</th>
													<th style="width: 15%;">Shipper</th>
													<th style="width: 15%;">Consignee</th>
													<!-- <th>Destination</th> -->
													<th style="width: 15%;">Freight/Kg</th>
													<th style="width: 10%;">Special Freight/Kg</th>
													<th style="width: 15%;">Packing</th>
													<th style="width: 15%;">Insurance</th>
													<th style="width: 15%;">Surcharge</th>
													<th style="width: 15%;">Discount</th>
													<th style="width: 15%;">Commision (%)</th>
													<th style="width: 15%;">Special Commision (Rp.)</th>
													<th style="width: 10%;">Other</th>
													<th style="width: 10%;">PIC Invoice</th>
													<th style="width: 20%;">Note</th>
													<!-- <th>Last Status</th> -->
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($shipment2 as $shp) {
													$get_last_status = $this->db->limit(1)->order_by('id_tracking', 'desc')->get_where('tbl_tracking_real', ['shipment_id' => $shp['shipment_id']])->row_array();
												?>
													<tr>
														<td><a href="<?= base_url('sales/salesOrder/print/' . $shp['shipment_id']) ?>"> <?= $shp['shipment_id'] ?></a><br><?php if ($shp['service_name'] == 'Charter Service') {
																																												echo $shp['service_name'] . '-' . $shp['pu_moda'];
																																											} else {
																																												echo  $shp['service_name'];;
																																											} ?> </td>
														<td><?= $shp['shipper'] ?></td>
														<td><?= $shp['consigne'] ?>/ <br> <?= $shp['city_consigne'] ?></td>
														<!-- <td><?= $shp['city_consigne'] ?>, <?= $shp['state_consigne'] ?></td> -->

														<!-- <?php if ($shp['service_name'] == 'Same Day Service') {
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
															<?php if ($get_last_status['flag'] == 11 || $get_last_status['flag'] == 5 || $get_last_status['flag'] == 7) {
															?>
																<a href="#" class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#modal-pod<?= $shp['shipment_id'] ?>" style="background-color: #9c223b;">
																	<span class="svg-icon svg-icon-md">
																	</span>View POD</a>
															<?php	} ?>

														</td>

													<?php	} ?> -->
														<td>
															<input type="text" name="freight[]" value="<?= $shp['freight_kg'] ?>" required class="form-control">
															<input type="text" name="id[]" hidden value="<?= $shp['id'] ?>" class="form-control">
															<input type="text" name="id_so" hidden value="<?= $shp['id_so'] ?>" class="form-control">
														</td>
														<td>
															<input type="text" name="special_freight[]" value="<?= $shp['special_freight'] ?>" class="form-control">
														</td>
														<td>
															<input type="text" name="packing[]" value="<?= $shp['packing'] ?>" class="form-control">
														</td>
														<td>
															<input type="text" name="insurance[]" value="<?= $shp['insurance'] ?>" class="form-control">
														</td>
														<td>
															<input type="text" name="surcharge[]" value="<?= $shp['surcharge'] ?>" class="form-control">
														</td>
														<td>
															<input type="text" name="disc[]" value="<?= $shp['disc'] ?>" class="form-control" style="width: 100px;">
														</td>
														<td>
															<input type="number" name="cn[]" value="<?= $shp['cn'] ?>" class="form-control" style="width: 100px;">
														</td>
														<td>
															<input type="number" name="specialcn[]" value="<?= $shp['specialcn'] ?>" class="form-control" style="width: 100px;">
														</td>
														<td>
															<input type="text" name="others[]" value="<?= $shp['others'] ?>" class="form-control" style="width: 100px;">
														</td>
														<td>
															<input type="text" name="pic_invoice[]" value="<?= $shp['pic_invoice'] ?>" class="form-control" required style="width: 100px;">
														</td>
														<td>
															<input type="text" name="so_note[]" value="<?= $shp['so_note'] ?>" class="form-control" style="width: 200px;">
														</td>
														<td>
															<?php
															$id_atasan = $this->session->userdata('id_atasan');
															// kalo dia atasan sales
															$get_request_revisi = $this->db->get_where('tbl_request_revisi', ['shipment_id' => $shp['id']])->row_array();
															$cek_so_baru = $this->db->get_where('tbl_revisi_so', ['shipment_id' => $shp['id']])->row_array();
															// kalo dia atasan
															if ($id_atasan == 0 || $id_atasan == NULL) {
																// cek apakah sudah ada reqeust revisi
																if ($get_request_revisi) {
																	if ($cek_so_baru) {
															?>
																		<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
																		<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" data-toggle="modal" data-target="#modal-view<?= $shp['id'] ?>" style="background-color: #9c223b;">View New SO</a>
																	<?php	} else {
																	?>

																		<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" data-toggle="modal" data-target="#modal-lg<?= $shp['id'] ?>" style="background-color: #9c223b;">Add New SO</a>
																		<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>

																	<?php }
																	?>
																	<?php	} else {
																	// kalo dia udah ngajuin so
																	if ($shp['status_so'] >= 1) {
																	?>
																		<a href="<?= base_url('sales/salesOrder/requestRevisi/' . $shp['id'] . '/' . $shp['id_so']) ?>" onclick="return confirm('Are you sure ?')" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Request Revisi</a>
																		<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>

																	<?php	} else {
																	?>

																		<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
																	<?php }
																	?>

																<?php	}
																?>

																<?php  } else {
																if ($get_request_revisi) {
																	if ($get_request_revisi['status'] == 1) {
																		$cek_so_baru = $this->db->get_where('tbl_revisi_so', ['shipment_id' => $shp['id']])->row_array();
																		if ($cek_so_baru) {
																?>
																			<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
																			<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" data-toggle="modal" data-target="#modal-view<?= $shp['id'] ?>" style="background-color: #9c223b;">View New SO</a>
																		<?php	} else {
																		?>

																			<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
																			<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" data-toggle="modal" data-target="#modal-lg<?= $shp['id'] ?>" style="background-color: #9c223b;">Add New SO</a>
																		<?php }
																		?>

																	<?php	} else {
																	?>
																		<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
																		<small>Request Rejected</small>
																	<?php	}
																} else {
																	?>

																	<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
																<?php	} ?>

															<?php	} ?>
														</td>
													</tr>

												<?php } ?>
											</tbody>
										</table>

										<?php
										$id_atasan = $this->session->userdata('id_atasan');
										// kalo dia atasan sales
										if ($id_atasan == 0 || $id_atasan == NULL) {
											if ($shipment2) {
												if ($p['status_approve'] == 0) {
										?>
													<a href="<?= base_url('sales/salesOrder/approve/' . $p['id_so']) ?>" onclick="return confirm('Are You Sure ?')" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Approve</a>
													<?php	} else {
													if ($p['lock'] == 0) {
													?>
														<?php
														if (deadline($p['deadline_sales_so'])) {
															echo "<button type='submit' class='btn btn-success' onclick='return confirm('Are you sure ?')'>Submit SO</button>";
														} else {
															if ($request_aktivasi) {
																if ($request_aktivasi['status'] == 0) {
																	echo 'Wait Approve';
																} else {
																	echo '';
																}
															} else {
																echo  "<h4>SO Late Submit </h4> <br> <a href=" . base_url('#') . " 'onclick='return confirm('Are You Sure ?')' class='btn btn-sm mb-1 text-light' data-toggle='modal' data-target='#modal-request' style='background-color: #9c223b;'>Request Aktivasi</a>";
															}
														}
														?>
													<?php	} else {
														echo "<button type='submit' class='btn btn-success' onclick='return confirm('Are you sure ?')'>Submit SO</button>  SO Submited";
													}
													?>
											<?php	}
											} else {
											} ?>
										<?php	} else {
										?>
											<?php if ($shipment2) {
											?>
												<!-- kalo dia belum di lock -->
												<?php if ($p['lock'] == 0) {
												?>
													<?php

													if (deadline($p['deadline_sales_so'])) {
														echo "<button type='submit' class='btn btn-success' onclick='return confirm('Are you sure ?')'>Submit SO</button>";
													} else {
														if ($request_aktivasi) {
															if ($request_aktivasi['status'] == 0) {
																echo 'Wait Approve';
															} else {
																echo '';
															}
														} else {
															echo  "<h4>SO Late Submit </h4> <br> <a href=" . base_url('#') . " 'onclick='return confirm('Are You Sure ?')' class='btn btn-sm mb-1 text-light' data-toggle='modal' data-target='#modal-request' style='background-color: #9c223b;'>Request Aktivasi</a>";
														}
													}

													?>

												<?php	} else {
												?> <h4 class="title">So Submited</h4>

												<?php	} ?>

											<?php } else {
												echo '';
											} ?>
										<?php	}

										?>



									</form>
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



	<?php foreach ($shipment2 as $shp) {
	?>

		<div class="modal fade" id="modal-lg<?= $shp['id'] ?>">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Add New Sales Order with <?= $shp['shipment_id'] ?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="<?= base_url('sales/salesOrder/addNewSo') ?>" method="POST">

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Freight</label>
										<input type="text" class="form-control" id="exampleInputEmail1" required name="freight_baru">
										<input type="text" class="form-control" id="exampleInputEmail1" name="id" hidden required value="<?= $shp['id'] ?>">
										<input type="text" class="form-control" id="exampleInputEmail1" name="id_so" hidden required value="<?= $p['id_so'] ?>">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Special Freight</label>
										<input type="text" class="form-control" id="exampleInputEmail1" required name="special_freight_baru">
										<!-- <input type="text" class="form-control" id="exampleInputEmail1" hidden required value="<?= $msr['id_msr'] ?>" name="id_msr"> -->
									</div>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Packing</label>
										<input type="text" class="form-control" id="exampleInputEmail1" required name="packing_baru">
										<!-- <input type="text" class="form-control" id="exampleInputEmail1" hidden required value="<?= $msr['id_msr'] ?>" name="id_msr"> -->
									</div>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Others</label>
										<input type="text" class="form-control" id="exampleInputEmail1" required name="others_baru">
									</div>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Surcharge</label>
										<input type="text" class="form-control" id="exampleInputEmail1" required name="surcharge_baru">
									</div>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Insurance</label>
										<input type="text" class="form-control" id="exampleInputEmail1" required name="insurance_baru">
									</div>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Disc</label>
										<input type="number" class="form-control" id="exampleInputEmail1" required name="disc_baru">
									</div>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Cn</label>
										<input type="number" class="form-control" id="exampleInputEmail1" required name="cn_baru">
									</div>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Reason</label>
										<textarea name="alasan" class="form-control" required></textarea>
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



	<?php foreach ($shipment2 as $shp) {
		$cek_so_baru = $this->db->get_where('tbl_revisi_so', ['shipment_id' => $shp['id']])->row_array();
		if ($cek_so_baru) {
	?>
			<div class="modal fade" id="modal-view<?= $shp['id'] ?>">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">View New Sales Order with <?= $shp['shipment_id'] ?></h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="<?= base_url('sales/salesOrder/addNewSo') ?>" method="POST">

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Freight</label>
											<input type="text" class="form-control" id="exampleInputEmail1" required name="freight_baru" value="<?= $cek_so_baru['freight_baru'] ?>">
											<input type="text" class="form-control" id="exampleInputEmail1" name="id" hidden required value="<?= $shp['id'] ?>">
											<input type="text" class="form-control" id="exampleInputEmail1" name="id_so" hidden required value="<?= $p['id_so'] ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Special Freight</label>
											<input type="text" class="form-control" id="exampleInputEmail1" required name="special_freight_baru" value="<?= $cek_so_baru['special_freight_baru'] ?>">
											<!-- <input type="text" class="form-control" id="exampleInputEmail1" hidden required value="<?= $msr['id_msr'] ?>" name="id_msr"> -->
										</div>

									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Packing</label>
											<input type="text" class="form-control" id="exampleInputEmail1" required name="packing_baru" value="<?= $cek_so_baru['packing_baru'] ?>">
											<!-- <input type="text" class="form-control" id="exampleInputEmail1" hidden required value="<?= $msr['id_msr'] ?>" name="id_msr"> -->
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Others</label>
											<input type="text" class="form-control" id="exampleInputEmail1" required name="others_baru" value="<?= $cek_so_baru['others_baru'] ?>">
										</div>

									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Surcharge</label>
											<input type="text" class="form-control" id="exampleInputEmail1" required name="surcharge_baru" value="<?= $cek_so_baru['surcharge_baru'] ?>">
										</div>

									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Insurance</label>
											<input type="text" class="form-control" id="exampleInputEmail1" required name="insurance_baru" value="<?= $cek_so_baru['insurance_baru'] ?>">
										</div>

									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Disc</label>
											<input type="number" class="form-control" id="exampleInputEmail1" required name="disc_baru" value="<?= $cek_so_baru['disc_baru'] ?>">
										</div>

									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Cn</label>
											<input type="number" class="form-control" id="exampleInputEmail1" required name="cn_baru" value="<?= $cek_so_baru['cn_baru'] ?>">
										</div>

									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Reason</label>
											<textarea name="alasan" class="form-control" required><?= $cek_so_baru['alasan'] ?></textarea>
										</div>

									</div>
								</div>

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

		<?php	} else {
			echo '';
		}

		?>
		<!-- /.modal -->

	<?php } ?>



	<div class="modal fade" id="modal-import">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Import Sales Order</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?= base_url('sales/salesOrder/import') ?>" method="POST" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<label class="col-form-label text-lg-right font-weight-bold">Upload File</label>
							<input type="file" id="input-file-now" name="upload_file" class="dropify" required />
							<input type="text" name="id_so" hidden value="<?= $p['id_so'] ?>">
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
	<div class="modal fade" id="modal-request">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Request Aktivation</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?= base_url('sales/salesOrder/requestAktivasi') ?>" method="POST" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<label class="col-form-label text-lg-right font-weight-bold">Reason <span class="text-danger">*</span> </label>
							<textarea type="text" name="reason" class="form-control" required></textarea>
							<input type="text" name="id_so" hidden value="<?= $p['id_so'] ?>">
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