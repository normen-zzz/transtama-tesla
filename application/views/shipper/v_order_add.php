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
													<?= $this->session->userdata('message') ?>
													<?php echo validation_errors(); ?>
													<!--begin::Input-->
													<div class="row">

														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Shipper <span class="text-danger">*</span></label>
																<select name="shipper_id" class="form-control" id="shipper_id">
																	<option value="choose">Choose Shipper</option>
																	<?php foreach ($customer as $f) {
																	?>
																		<option value="<?= $f['id_customer'] ?>" <?php if ($f['id_customer'] == set_value('shipper_id')) {
																														echo 'selected';
																													} ?>><?= $f['nama_pt'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>
														<input type="text" class="form-control" hidden name="state_shipper2" value="<?php echo set_value('state_shipper2'); ?>" id="state_shipper">
														<input type="text" class="form-control" hidden name="city_shipper2" value="<?php echo set_value('city_shipper2'); ?>" id="city_shipper">
														<input type="text" class="form-control" hidden name="shipper2" value="<?php echo set_value('shipper2'); ?>" id="shipper">
														<input type="text" class="form-control" hidden name="origin_destination" value="<?php echo set_value('origin_destination'); ?>" id="origin_destination">
														<input type="text" class="form-control" hidden name="id_so" value="<?= $id_so ?>" id="id_so">
														<input type="text" class="form-control" hidden name="id_tracking" value="<?= $id_tracking ?>" id="id_tracking">



														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Consigne <span class="text-danger">*</span></label>
																<div id="prefetch">
																	<input type="text" class="form-control" id="consigne" required name="consigne" value="<?php echo set_value('consigne'); ?>">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Destination State <span class="text-danger">*</span></label>
																<select name="state_consigne" class="form-control">
																	<?php foreach ($province as $f) {
																	?>
																		<option value="<?= $f['name'] ?>" <?php if ($f['name'] == set_value('state_consigne')) {
																												echo 'selected';
																											} ?>><?= $f['name'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Destination City <span class="text-danger">*</span></label>
																<select name="city_consigne" class="form-control">
																	<?php foreach ($city as $c) {
																	?>
																		<option value="<?= $c['city_name'] ?>" <?php if ($c['city_name'] == set_value('city_consigne')) {
																													echo 'selected';
																												} ?>><?= $c['city_name'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputPassword1">Destination Address<span class="text-danger">*</span></label>
																<textarea name="destination" id="destination" class="form-control" required rows="4"><?php echo set_value('destination'); ?></textarea>
															</div>
														</div>

														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Service Type<span class="text-danger">*</span></label>
																<select name="service_type" class="form-control">
																	<?php foreach ($service as $s) {
																	?>
																		<option value="<?= $s['code'] ?>" <?php if ($s['code'] == set_value('service_type')) {
																												echo 'selected';
																											} ?>><?= $s['service_name'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Moda<span class="text-danger">*</span></label>
																<select name="moda" class="form-control" required>
																	<option value="NULL">-Choose Moda-</option>
																	<?php foreach ($moda as $m) {
																	?>
																		<option value="<?= $m['nama_moda'] ?>" <?php if ($m['nama_moda'] == $so['pu_moda']) {
																													echo 'selected';
																												} ?>><?= $m['nama_moda'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Koli<span class="text-danger">*</span></label>
																<input type="number" class="form-control" required name="koli" value="<?php echo set_value('koli'); ?>">
															</div>
														</div>
														
														<div class="col-md-2">
															<div class="form-group rec-element2">
																<label for="exampleInputEmail1">No. DO/DN 1 <button type="button" class="btn btn-info tambah-form-essay"><i class="fa fa-plus"></i> </button> </label>
																<input type="text" class="form-control" name="note_cs[]">
															</div>
														</div>
														<div class="ln_solid"></div>
														<div id="nextkolom2" name="nextkolom2"></div>
														<button type="button" id="jumlahkolom2" value="1" style="display:none"></button>

														<div class="col-md-2">
															<div class="form-group rec-element">
																<label for="exampleInputEmail1">No. SO/PO 1 <button type="button" class="btn btn-info tambah-so"><i class="fa fa-plus"></i> </button> </label>
																<input type="text" class="form-control" name="no_so[]">
															</div>
														</div>
														<div class="ln_solid2"></div>
														<div id="nextkolom" name="nextkolom"></div>
														<button type="button" id="jumlahkolom" value="1" style="display:none"></button>
														
														<div class="col-md-2">
															<div class="form-group">
																<label for="exampleInputEmail1">STP</label>
																<input type="text" class="form-control" name="no_stp" value="<?php echo set_value('no_stp'); ?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputPassword1">Note</label>
																<textarea name="note_driver" class="form-control" rows="4"><?php echo set_value('note_driver'); ?></textarea>
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
																<input type="file" class="form-control" name="ktp[]" onchange="preview_image(); handleImageUpload(this.id);" accept="image/*" capture multiple id="upload_file">
																<input type="file" class="form-control" name="ktp2[]" onchange="preview_image();" accept="image/*" capture multiple id="upload_file2" hidden></div>
														</div>
														<div class="col-md-4 mb-2">
															<div id="image_preview"></div>
														</div>

														<div class="col-md-2">
															<div class="form-group">
																<button type="button" class="btn text-light" data-toggle="modal" data-target="#modal-lg" style="background-color: #9c223b;">
																	Add Signature
																</button>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label for="exampleInputEmail1">Sender <span class="text-danger">*</span></label>
																<input type="text" class="form-control" required name="sender" id="sender" value="<?php echo set_value('sender'); ?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label for="exampleInputEmail1">Is Jabodetabek ? <span class="text-danger">*</span></label>
																<div class="form-check">
																	<input class="form-check-input" type="radio" name="is_jabodetabek" id="flexRadioDefault1" value="1" <?php if (set_value('is_jabodetabek') == 1) {
																																											echo 'checked';
																																										} ?>>
																	<label class="form-check-label" for="flexRadioDefault1">
																		Yes
																	</label>
																</div>
																<div class="form-check">
																	<input class="form-check-input" type="radio" name="is_jabodetabek" id="flexRadioDefault2" value="2" <?php if (set_value('is_jabodetabek') == 2) {
																																											echo 'checked';
																																										} ?>>
																	<label class="form-check-label" for="flexRadioDefault2">
																		No
																	</label>
																</div>
															</div>
														</div>
														<div class="col-md-6">
															<textarea id='output' name="ttd" hidden><?php echo set_value('ttd'); ?></textarea><br />

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
														<button onclick='$("#modalLoading").modal("show");' type="submit" class="btn btn font-weight-bolder text-uppercase px-9 py-4 text-light" data-wizard-type="action-submit" style="background-color: #9c223b;">Submit</button>
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
						<div class="col-md-12">
							<label style="font-weight:bold">Signature</label>
							<div id="signature" style="height: 300%; width:100%;   border: 1px solid black;"></div><br />
						</div>
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