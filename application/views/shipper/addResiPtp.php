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
											<form id="kt_form" novalidate="novalidate" action="<?= base_url('shipper/SalesOrder/ProcessResiPtp') ?>" method="POST" enctype="multipart/form-data">
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
																<input type="text" class="form-control" required name="shipper" value="<?php echo $so['shipper']?>" readonly>
															</div>
														</div>

														<input type="text" class="form-control" hidden name="id_so" value="<?= $id_so ?>" id="id_so">




														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Consignee <span class="text-danger">*</span></label>
																<div id="prefetch">
																	<input type="text" class="form-control" id="consigne" required name="consignee" value="<?php echo $so['consigne'] ?>" readonly>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Destination State <span class="text-danger">*</span></label>
																<input type="text" class="form-control" required name="state_consigne" value="<?php echo $state['name_state'] ?>" readonly>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Destination City <span class="text-danger">*</span></label>
																<input type="text" class="form-control" required name="city_consigne" value="<?php echo $city['name'] ?>" readonly>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputPassword1">Destination Address<span class="text-danger">*</span></label>
																<textarea name="destination" id="destination" class="form-control" required rows="4"><?php echo $so['destination'] ?></textarea>
															</div>
														</div>

														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Service Type<span class="text-danger">*</span></label>
																<input type="text" class="form-control" required name="service_type" value="3c8b5fdd11cb10506705c16773204f8a" hidden>
                                                                <input type="text" class="form-control"  value="Port To Port" readonly>
															</div>
														</div>
														
																<input type="text" class="form-control" required name="moda" value="-" hidden>

                                                               
                                                                <div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Weight<span class="text-danger">*</span></label>
																<input type="number" class="form-control" required name="weight" required>
															</div>
														</div>      
															
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Koli<span class="text-danger">*</span></label>
																<input type="number" class="form-control" required name="koli" value="<?php echo $so['koli'] ?>">
															</div>
														</div>

														<?php if ($do == NULL) { ?>
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

														<?php } else { ?>


															<?php $no = 1;
															foreach ($do->result_array() as $do1) { ?>



																<div class="rec-element2">
																	<label class="control-label col-md-6 col-sm-6 col-xs-12" for="first-name">No. DO/DN <?= $no ?> <span class="required"></span>
																	</label>
																	<div class="col-md-12 col-sm-12 col-xs-12">
																		<div class="input-group">
																			<input type="text" name="note_cs[]" id="doReqPickup" value="<?= $do1['do'] ?>" class="form-control">
																			<span class="input-group-btn">
																				<button type="button" class="btn btn-warning del-element2"><i class="fa fa-minus-square"></i> Hapus</button>
																			</span>
																		</div>
																	</div>
																</div>



															<?php $no++;
															} ?>
															<div id="nextkolom2" name="nextkolom2"></div>
															<!-- <button type="button" class="btn btn-info tambahBarisDo"><i class="fa fa-plus">Tambah No DO</i> </button> -->
															<button type="button" id="jumlahkolom2" value="1" style="display:none"></button>


														<?php } ?>


														<div class="col-md-2">
															<div class="form-group">
																<label for="exampleInputEmail1">SMU</label>
                                                                <input type="text" class="form-control" name="smu" id="smu" required placeholder="Ex: 126-1234456">
																<input type="text" class="form-control" name="no_stp" value="" hidden>
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
																<input type="text" class="form-control" required name="sender" id="sender" value="-">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label for="exampleInputEmail1">Is Jabodetabek ? <span class="text-danger">*</span></label>
																
																<div class="form-check">
																	<input class="form-check-input" type="radio" name="is_jabodetabek" id="flexRadioDefault2" value="2" checked>
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


	<script>
		$(document).ready(function() {
			var i = <?= $do->num_rows() + 1 ?>;
			$(".tambahBarisDo").on('click', function() {
				row = '<div class="rec-element2">' +
					'<div class="form-group">' +
					'<label class="control-label col-md-6 col-sm-6 col-xs-12" for="first-name">No. DO/DN ' + i + ' <span class="required"></span>' +
					'</label>' +
					'<div class="col-md-12 col-sm-12 col-xs-12"> ' +
					'<div class="input-group">' +
					'<input type="text" name="note_cs[]" id="doReqPickup' + i + '" alt="' + i + '" class="form-control">' +
					'<span class="input-group-btn">' +
					'<button type="button" class="btn btn-warning del-element2"><i class="fa fa-minus-square"></i> Hapus</button>' +
					'</span>' +
					'</div>' +
					'</div>' +
					'</div>' +
					'<div class="ln_solid"></div>' +

					'</div>';
				$(row).insertBefore("#nextkolom2");
				$('#jumlahkolom2').val(i + 1);
				i++;
			});
			$(document).on('click', '.del-element2', function(e) {
				e.preventDefault()
				i--;
				//$(this).parents('.rec-element').fadeOut(400);
				$(this).parents('.rec-element2').remove();
				$('#jumlahkolom2').val(i - 1);
			});
		});
	</script>

	<script>
		// #smu ketika sudah lebih dari 3 angka diawal saja contoh 126545544 maka jadi 126-545544
		$(document).ready(function() {
			$('#smu').on('input', function() {
				var smu = $('#smu').val();
				if (smu.length > 3) {
					var smu = smu.replace(/-/g, '');
					var smu = smu.substring(0, 3) + '-' + smu.substring(3);
					$('#smu').val(smu);
				}
			});
		});
	</script>