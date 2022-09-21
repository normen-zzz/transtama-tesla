	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch">
						<div class="card-header py-3">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bolder text-dark">Add Request Pickup</h3>
							</div>
							<div class="card-toolbar">
								<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-chevron-circle-left text-light"> </i>
									Cancel
								</a>
							</div>

						</div>
						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<div class="card-body p-0">
								<!--begin: Wizard-->

								<!--begin: Wizard Body-->
								<div class="row justify-content-center py-10 px-8 py-lg-12 px-lg-10">
									<div class="col-xl-12 col-xxl-7">
										<!--begin: Wizard Form-->
										<form id="kt_form" novalidate="novalidate" action="<?= base_url('sales/salesOrder/processAdd') ?>" method="POST" enctype="multipart/form-data">

											<div class="pb-5" style="margin-top: -65px;">
												<h4 class="mb-10 font-weight-bold text-dark"><b>1. Request Pickup Information</b> </h4>
												<?= $this->session->userdata('message') ?>
												<?php echo validation_errors(); ?>

												<!--begin::Input-->
												<div class="row">
													<div class="col-md-1">
														<div class="form-group">
															<label for="exampleInputEmail1">Type<span style="color: red;">*</span></label>
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
													<div class="col-md-3">
														<div class="form-group">
															<label for="exampleInputPassword1">Destination</label>
															<textarea name="destination" class="form-control"><?php echo set_value('destination'); ?></textarea>
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
															<label for="exampleInputEmail1">Shipper Address</label>
															<div id="prefetch">
																<input type="text" class="form-control" id="shipper_address" name="shipper_address" value="<?php echo set_value('shipper_address'); ?>">
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="exampleInputEmail1">Consignee</label>
															<div id="prefetch">
																<input type="text" class="form-control" name="consigne" value="<?php echo set_value('consigne'); ?>">
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="exampleInputEmail1">Consignee Address</label>
															<div id="prefetch">
																<input type="text" class="form-control" name="consigne_address" value="<?php echo set_value('consigne_address'); ?>">
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label for="exampleInputEmail1">Payment</label>
															<div class="form-check">
																<input class="form-check-input" name="payment" type="checkbox" value="Cash" id="flexCheckDefault">
																<label class="form-check-label" for="flexCheckDefault">
																	Cash
																</label>
															</div>
															<div class="form-check">
																<input class="form-check-input" name="payment" type="checkbox" value="Credit" id="flexCheckChecked">
																<label class="form-check-label" for="flexCheckChecked">
																	Credit
																</label>
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label for="exampleInputEmail1">Use Generate Resi ?<span style="color: red;">*</span></label>
															<div class="form-check">
																<input class="form-check-input" type="radio" name="type" id="flexRadioDefault1" value="1">
																<label class="form-check-label" for="flexRadioDefault1">
																	Yes
																</label>
															</div>
															<div class="form-check">
																<input class="form-check-input" type="radio" name="type" id="flexRadioDefault2" value="0">
																<label class="form-check-label" for="flexRadioDefault2">
																	No
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
																<input type="date" class="form-control" id="tgl_pickup" required name="tgl_pickup" value="<?php echo set_value('tgl_pickup'); ?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label for="exampleInputEmail1">Pickup Time<span style="color: red;">*</span></label>
																<input type="time" class="form-control" required name="time" value="<?php echo set_value('tgl_pickup'); ?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Moda <span style="color: red;">*</span></label>
																<select name="pu_moda" class="form-control">
																	<?php foreach ($moda as $s) {
																	?>
																		<option value="<?= $s['nama_moda'] ?>" <?php if ($s['nama_moda'] == set_value('pu_moda')) {
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
																		<option value="<?= $s['nama_packing'] ?>" <?php if ($s['nama_packing'] == set_value('packing')) {
																														echo 'selected';
																													} ?>><?= $s['nama_packing'] ?></option>
																	<?php  } ?>
																</select>
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
																<label for="exampleInputEmail1">Commodity<span style="color: red;">*</span></label>
																<input type="text" class="form-control" required name="commodity" value="<?php echo set_value('commodity'); ?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label for="exampleInputEmail1">Koli</label>
																<input type="number" class="form-control" name="koli" value="<?php echo set_value('koli'); ?>">
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

											<div class="d-flex justify-content-between border-top mt-5 pt-10">

												<div>
													<button onclick='$("#modalLoading").modal("show");' type="submit" class="btn btn font-weight-bolder text-uppercase px-9 py-4 text-light" data-wizard-type="action-submit" style="background-color: #9c223b;">Submit</button>
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
	<!-- /.content --