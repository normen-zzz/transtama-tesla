	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch">
						<div class="card-header py-3">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bolder text-dark">Add Sales Order</h3>
							</div>
							<div class="card-toolbar">
								<a href="<?= base_url('sales/salesOrder') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-chevron-circle-left text-light"> </i>
									Cancel Order
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
											<form id="kt_form" novalidate="novalidate" action="<?= base_url('sales/salesOrder/processAdd') ?>" method="POST" enctype="multipart/form-data">
												<!--begin: Wizard Step 1-->
												<div class="pb-5" style="margin-top: -65px;">
													<h4 class="mb-10 font-weight-bold text-dark">Please fill in the blank</h4>
													<?= $this->session->userdata('message') ?>
													<?php echo validation_errors(); ?>

													<!--begin::Input-->
													<div class="row">
														<div class="col-md-2">
															<div class="form-group">
																<label for="exampleInputEmail1">Pickup Date<span style="color: red;">*</span></label>
																<input type="date" class="form-control" id="tgl_pickup" required name="tgl_pickup" value="<?php echo set_value('tgl_pickup'); ?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label for="exampleInputEmail1">Time<span style="color: red;">*</span></label>
																<input type="time" class="form-control" required name="time" value="<?php echo set_value('tgl_pickup'); ?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Shipper<span style="color: red;">*</span></label>
																<div id="prefetch">
																	<input type="text" class="form-control" id="shipper" required name="shipper" value="<?php echo set_value('shipper'); ?>">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Pickup Moda<span style="color: red;">*</span></label>
																<input type="text" class="form-control" required name="pu_moda" value="<?php echo set_value('pu_moda'); ?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Pickup Point<span style="color: red;">*</span></label>
																<input type="text" class="form-control" required name="pu_poin" value="<?php echo set_value('pu_poin'); ?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputPassword1">Destination<span style="color: red;">*</span></label>
																<textarea name="destination" class="form-control" required><?php echo set_value('destination'); ?></textarea>
															</div>
														</div>
														<div class="col-md-1">
															<div class="form-group">
																<label for="exampleInputEmail1">Koli<span style="color: red;">*</span></label>
																<input type="number" class="form-control" required name="koli" value="<?php echo set_value('koli'); ?>">
															</div>
														</div>
														<div class="col-md-1">
															<div class="form-group">
																<label for="exampleInputEmail1">Kg</label>
																<input type="number" class="form-control" name="kg" value="<?php echo set_value('kg'); ?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<!-- <label for="exampleInputEmail1">Is Incoming ?<span style="color: red;">*</span></label> -->
																<div class="form-check">
																	<input class="form-check-input" type="radio" name="is_incoming" id="flexRadioDefault1" value="1">
																	<label class="form-check-label" for="flexRadioDefault1">
																		Incoming
																	</label>
																</div>
																<div class="form-check">
																	<input class="form-check-input" type="radio" name="is_incoming" id="flexRadioDefault2" value="0">
																	<label class="form-check-label" for="flexRadioDefault2">
																		Outgoing
																	</label>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Commodity<span style="color: red;">*</span></label>
																<input type="text" class="form-control" required name="commodity" value="<?php echo set_value('commodity'); ?>">
															</div>
														</div>

														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Service Type <span style="color: red;">*</span></label>
																<select name="service" class="form-control">
																	<?php foreach ($service as $s) {
																	?>
																		<option value="<?= $s['service_name'] ?>" <?php if ($s['service_name'] == set_value('service_type')) {
																														echo 'selected';
																													} ?>><?= $s['service_name'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>

														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputPassword1">Note </label>
																<textarea name="note" class="form-control"><?php echo set_value('note'); ?></textarea>
															</div>
														</div>


													</div>

												</div>

												<!--end: Wizard Step 1-->

												<!--begin: Wizard Actions-->
												<div class="d-flex justify-content-between border-top mt-5 pt-10">
													<div>
														<button type="submit" class="btn btn font-weight-bolder text-uppercase px-9 py-4 text-light" style="background-color: #9c223b;">Submit</button>
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