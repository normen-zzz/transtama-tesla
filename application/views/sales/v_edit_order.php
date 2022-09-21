	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch">
						<div class="card-header py-3">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bolder text-dark">Edit Request Pickup</h3>
							</div>
							<div class="card-toolbar">
								<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-chevron-circle-left text-light"> </i>
									Cancel Edit
								</a>
							</div>

						</div>
						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<div class="card-body p-0">
								<!--begin: Wizard-->
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
													<h4 class="mb-10 font-weight-bold text-dark"><b>1. Request Pickup Information</b> </h4>
													<?= $this->session->userdata('message') ?>
													<?php echo validation_errors(); ?>

													<!--begin::Input-->
													<div class="row">
														<div class="col-md-1">
															<div class="form-group">
																<!-- <label for="exampleInputEmail1">Is Incoming ?<span style="color: red;">*</span></label> -->
																<div class="form-check">
																	<input class="form-check-input" type="radio" name="is_incoming" id="flexRadioDefault1" value="1" <?php if ($p['is_incoming'] == 1) {
																																											echo 'checked';
																																										} ?>>
																	<label class="form-check-label" for="flexRadioDefault1">
																		Incoming
																	</label>
																</div>
																<div class="form-check">
																	<input class="form-check-input" type="radio" name="is_incoming" id="flexRadioDefault2" value="0" <?php if ($p['is_incoming'] == 0) {
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
																<label for="exampleInputPassword1">Destination</label>
																<textarea name="destination" class="form-control"><?php echo set_value('destination'); ?><?= $p['destination'] ?></textarea>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Shipper<span style="color: red;">*</span></label>
																<div id="prefetch">
																	<input type="text" class="form-control" id="shipper" required name="shipper" value="<?= $p['shipper'] ?>">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Shipper Address</label>
																<div id="prefetch">
																	<input type="text" class="form-control" id="shipper_address" name="shipper_address" value="<?= $p['shipper_address'] ?>">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Consignee</label>
																<div id="prefetch">
																	<input type="text" class="form-control" name="consigne" value="<?= $p['consigne'] ?>">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Consignee Address</label>
																<div id="prefetch">
																	<input type="text" class="form-control" name="consigne_address" value="<?= $p['consigne_address'] ?>">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Payment</label>
																<div class="form-check">
																	<input class="form-check-input" name="payment" type="checkbox" value="Cash" id="flexCheckDefault" <?php if ($p['payment'] == "Cash") {
																																											echo 'checked';
																																										} ?>>
																	<label class="form-check-label" for="flexCheckDefault">
																		Cash
																	</label>
																</div>
																<div class="form-check">
																	<input class="form-check-input" name="payment" type="checkbox" value="Credit" id="flexCheckChecked" <?php if ($p['payment'] == "Credit") {
																																											echo 'checked';
																																										} ?>>
																	<label class="form-check-label" for="flexCheckChecked">
																		Credit
																	</label>
																</div>
															</div>
														</div>
														<?php
														if ($p['type'] == 1) {
														?>
															<div class="col-md-4">
																<div class="form-group">
																	<label for="exampleInputEmail1">Total Shipment<span style="color: red;">*</span></label>
																	<div id="prefetch">
																		<input type="number" class="form-control" readonly min="1" max="100" required name="total_shipment" value="<?= $p['total_shipment'] ?>">
																	</div>
																</div>
															</div>
														<?php	}

														?>
													</div>
													<hr>
													<h4 class="mb-10 font-weight-bold text-dark"><b>2. Pickup Information</b> </small>
														<br> <br>
														<div class="row">
															<div class="col-md-2">
																<div class="form-group">
																	<label for="exampleInputEmail1">Pickup Date<span style="color: red;">*</span></label>
																	<input type="date" class="form-control" id="tgl_pickup" required name="tgl_pickup" value="<?= $p['tgl_pickup'] ?>">
																</div>
															</div>
															<div class="col-md-2">
																<div class="form-group">
																	<label for="exampleInputEmail1">Pickup Time<span style="color: red;">*</span></label>
																	<input type="time" class="form-control" required name="time" value="<?= $p['time'] ?>">
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<label for="exampleInputEmail1">Moda <span style="color: red;">*</span></label>
																	<select name="pu_moda" class="form-control">
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
																	<select name="packing" class="form-control">
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
																	<input type="text" class="form-control" required name="pu_poin" value="<?= $p['pu_poin'] ?>">
																</div>
															</div>



															<div class="col-md-4">
																<div class="form-group">
																	<label for="exampleInputEmail1">Service Type <span style="color: red;">*</span></label>
																	<select name="service" class="form-control">
																		<?php foreach ($service as $s) {
																		?>
																			<option value="<?= $s['service_name'] ?>" <?php if ($s['service_name'] ==  $p['service']) {
																															echo 'selected';
																														} ?>><?= $s['service_name'] ?></option>
																		<?php  } ?>
																	</select>
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<label for="exampleInputEmail1">Commodity<span style="color: red;">*</span></label>
																	<input type="text" class="form-control" required name="commodity" value="<?= $p['commodity'] ?>">
																</div>
															</div>
															<div class="col-md-2">
																<div class="form-group">
																	<label for="exampleInputEmail1">Koli</label>
																	<input type="number" class="form-control" name="koli" value="<?= $p['koli'] ?>">
																	<input type="text" class="form-control" name="id_so" hidden value="<?= $p['id_so'] ?>">
																</div>
															</div>

															<div class="col-md-4">
																<div class="form-group">
																	<label for="exampleInputPassword1">Note </label>
																	<textarea name="note" class="form-control"><?= $p['note'] ?></textarea>
																</div>
															</div>


														</div>

												</div>



												<!--end: Wizard Step 1-->

												<!--begin: Wizard Actions-->
												<div class="d-flex justify-content-between border-top mt-5 pt-10">
													<div>
														<button onclick='$("#modalLoading").modal("show");' type="submit" class="btn btn font-weight-bolder text-uppercase px-9 py-4 text-light" style="background-color: #9c223b;">Submit</button>
														<!-- <button type="button" class="btn btn font-weight-bolder text-uppercase px-9 py-4 text-light" data-wizard-type="action-next" style="background-color: #9c223b;">Next</button> -->
													</div>
												</div>
												<!--end: Wizard Actions-->
											</form>
											<!--end: Wizard Form-->
										</div>
									</div>
									<!--end: Wizard Body-->
								</div>
								<!--end: Wizard-->
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
	<!-- /.content --