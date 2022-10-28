	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h2 class="card-title">Add Order</h2>
						</div>
						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<div class="card-body p-0">
								<!--begin: Wizard-->
								<div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="step-first" data-wizard-clickable="true">
									<!--begin: Wizard Nav-->
									<div class="wizard-nav">
										<div class="wizard-steps px-8 py-8 px-lg-15 py-lg-3">
											<!--begin::Wizard Step 1 Nav-->
											<div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
												<div class="wizard-label">
													<h3 class="wizard-title">
														<span>1.</span>Order Details
													</h3>
													<div class="wizard-bar"></div>
												</div>
											</div>
											<!--end::Wizard Step 1 Nav-->
											<!--begin::Wizard Step 4 Nav-->
											<div class="wizard-step" data-wizard-type="step">
												<div class="wizard-label">
													<h3 class="wizard-title">
														<span>2.</span>Attachment
													</h3>
													<div class="wizard-bar"></div>
												</div>
											</div>
											<!--end::Wizard Step 4 Nav-->
										</div>

									</div>
									<!--end: Wizard Nav-->
									<!--begin: Wizard Body-->
									<div class="row justify-content-center py-10 px-8 py-lg-12 px-lg-10">
										<div class="col-xl-12 col-xxl-7">
											<!--begin: Wizard Form-->
											<form id="kt_form" novalidate="novalidate" action="<?= base_url('shipper/order/processAdd') ?>" method="POST" enctype="multipart/form-data">
												<!--begin: Wizard Step 1-->
												<div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
													<h4 class="mb-10 font-weight-bold text-dark">Please fill in the blank</h4>
													<!--begin::Input-->
													<div class="row">

														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Shipper</label>
																<select name="shipper_id" class="form-control" id="shipper_id">
																	<option value="choose">Choose Shipper</option>
																	<?php foreach ($customer as $f) {
																	?>
																		<option value="<?= $f['id_customer'] ?>"><?= $f['nama_pt'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>
														<input type="text" class="form-control" hidden name="state_shipper2" id="state_shipper">
														<input type="text" class="form-control" hidden name="city_shipper2" id="city_shipper">
														<input type="text" class="form-control" hidden name="shipper2" id="shipper">



														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Consigne</label>
																<div id="prefetch">
																	<input type="text" class="typeahead form-control" id="consigne" required name="consigne">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Destination State</label>
																<select name="state_consigne" class="form-control">
																	<?php foreach ($province as $f) {
																	?>
																		<option value="<?= $f['name'] ?>"><?= $f['name'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Destination City</label>
																<select name="city_consigne" class="form-control">
																	<?php foreach ($city as $c) {
																	?>
																		<option value="<?= $c['city_name'] ?>" <?php if ($c['city_name'] == "CENTRAL JAKARTA") {
																													echo 'selected';
																												} ?>><?= $c['city_name'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>


														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputPassword1">Destination Address</label>
																<textarea name="destination" id="destination" class="form-control" required rows="4"></textarea>
															</div>
														</div>

														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Service Type</label>
																<select name="service_type" class="form-control">
																	<?php foreach ($service as $s) {
																	?>
																		<option value="<?= $s['code'] ?>"><?= $s['service_name'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Koli</label>
																<input type="number" class="form-control" required name="koli">
															</div>
														</div>

													</div>

												</div>

												<!--end: Wizard Step 1-->
												<!--begin: Wizard Step 4-->
												<div class="pb-5" data-wizard-type="step-content">
													<h4 class="mb-10 font-weight-bold text-dark">Attachment </small>
													</h4>
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Image</label>
																<!-- <input type="file" class="form-control" name="ktp"> -->
																<input type="file" class="form-control" name="ktp" accept="image/*" capture>
															</div>

														</div>

														<div class="col-md-4">
															<div class="form-group">
																<button type="button" class="btn text-light" data-toggle="modal" data-target="#modal-lg" style="background-color: #9c223b;">
																	Add Signature
																</button>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Sender</label>
																<input type="text" class="form-control" required name="sender" id="sender">
															</div>
														</div>
														<div class="col-md-6">
															<textarea id='output' name="ttd" hidden></textarea><br />

														</div>

													</div>

												</div>
												<!--end: Wizard Step 4-->
												<!--begin: Wizard Actions-->
												<div class="d-flex justify-content-between border-top mt-5 pt-10">
													<div class="mr-2">
														<button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-prev">Previous</button>
													</div>
													<div>
														<button type="submit" class="btn btn font-weight-bolder text-uppercase px-9 py-4 text-light" data-wizard-type="action-submit" style="background-color: #9c223b;">Submit</button>
														<button type="button" class="btn btn font-weight-bolder text-uppercase px-9 py-4 text-light" data-wizard-type="action-next" style="background-color: #9c223b;">Next</button>
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
	<!-- /.content -->


	<div class="modal fade" id="modal-lg">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Signature</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('superadmin/role/addRole') ?>" method="POST">
						<div class="card-body">


							<div class="col-md-6">
								<label style="font-weight:bold">Signature</label>
								<div id="signature" style="height: 150%; width:50%;   border: 1px solid black;"></div><br />
							</div>

						</div>
						<!-- /.card-body -->


				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" id="click" class="btn text-light" data-dismiss="modal" style="background-color: #9c223b;">Submit</button>
					<!-- <button type="submit" class="btn btn-primary">Submit</button> -->
				</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->