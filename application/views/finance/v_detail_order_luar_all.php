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
								<a href="<?= base_url('finance/salesOrder') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-chevron-circle-left text-light"> </i>
									Back
								</a>
							</div>
						</div>

						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
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
																<label for="exampleInputEmail1">Pickup Moda<span style="color: red;">*</span></label>
																<input type="text" class="form-control" disabled required name="pu_moda" value="<?= $p['pu_moda'] ?>">
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

														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputPassword1">Note </label>
																<textarea name="note" disabled class="form-control"><?= $p['note'] ?></textarea>
															</div>
														</div>


													</div>

											</div>
											<hr>
											<h4 class="mb-10 font-weight-bold text-dark"><b>3. Shipment Content </b> </small>
											</h4>
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label for="exampleInputEmail1">Commodity<span style="color: red;">*</span></label>
														<input type="text" disabled class="form-control" required name="commodity" value="<?= $p['commodity'] ?>">
													</div>
												</div>
												<div class="col-md-1">
													<div class="form-group">
														<label for="exampleInputEmail1">Koli<span style="color: red;">*</span></label>
														<input type="number" disabled class="form-control" required name="koli" value="<?= $p['koli'] ?>">
													</div>
												</div>
												<div class="col-md-1">
													<div class="form-group">
														<label for="exampleInputEmail1">Weight</label>
														<input type="number" disabled class="form-control" name="kg" value="<?= $p['kg'] ?>">
													</div>
												</div>
												<div class="col-md-1">
													<div class="form-group">
														<label for="exampleInputEmail1">P</label>
														<input type="number" disabled class="form-control" name="p" value="<?= $p['p'] ?>">
													</div>
												</div>
												<div class="col-md-1">
													<div class="form-group">
														<label for="exampleInputEmail1">L</label>
														<input type="number" disabled class="form-control" name="l" value="<?= $p['l'] ?>">
													</div>
												</div>
												<div class="col-md-1">
													<div class="form-group">
														<label for="exampleInputEmail1">T</label>
														<input type="number" disabled class="form-control" name="t" value="<?= $p['t'] ?>">
													</div>
												</div>


											</div>
											<h4 class="mb-10 font-weight-bold text-dark"><b>4. Others </b> </small>
											</h4>
											<div class="row">
												<div class="col-md-2">
													<div class="form-group">
														<label for="exampleInputEmail1">Freight (Rate)<span style="color: red;">*</span></label>
														<input type="text" disabled class="form-control" required name="freight_kg" value="<?= $p['freight_kg'] ?>">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label for="exampleInputEmail1">Total Selling</label>
														<input type="text" disabled class="form-control" name="total_selling" value="<?= $p['total_selling'] ?>">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label for="exampleInputEmail1">Packing</label>
														<input type="text" disabled class="form-control" name="packing" value="<?= $p['packing'] ?>">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label for="exampleInputEmail1">Insurance</label>
														<input type="text" disabled class="form-control" name="insurance" value="<?= $p['insurance'] ?>">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label for="exampleInputEmail1">Surcharge</label>
														<input type="text" disabled class="form-control" name="surcharge" value="<?= $p['surcharge'] ?>">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label for="exampleInputEmail1">Discount</label>
														<input type="text" disabled class="form-control" name="discount" value="<?= $p['discount'] ?>">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label for="exampleInputEmail1">Commision</label>
														<input type="text" disabled class="form-control" name="commision" value="<?= $p['commision'] ?>">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label for="exampleInputEmail1">Others</label>
														<input type="text" disabled class="form-control" name="others" value="<?= $p['others'] ?>">
														<input type="text" class="form-control" name="id_so" hidden value="<?= $p['id_so'] ?>">
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