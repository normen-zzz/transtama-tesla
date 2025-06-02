	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch shadow-sm">
						<div class="card-header py-3 bg-gradient-light">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bold text-dark">
									<i class="fas fa-truck-loading mr-2"></i>Add Request Pickup
								</h3>
							</div>
							<div class="card-toolbar">
								<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder') ?>" class="btn btn-danger btn-pill btn-shadow">
									<i class="fas fa-chevron-circle-left mr-1"></i>
									Cancel
								</a>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="p-0">
								<div class="row justify-content-center py-4 px-3 py-lg-6 px-lg-5">
									<div class="col-xl-12">
										<!-- Form -->
										<form id="kt_form" novalidate="novalidate" action="<?= base_url('sales/salesOrder/processAdd') ?>" method="POST" enctype="multipart/form-data">

											<!-- Section 1: Request Pickup Information -->
											<div class="pb-5">
												<div class="d-flex align-items-center bg-light-primary p-3 rounded mb-4">
													<div class="mr-3">
														<span class="svg-icon svg-icon-primary svg-icon-2x">
															<i class="fas fa-info-circle fa-2x text-primary"></i>
														</span>
													</div>
													<div>
														<h4 class="mb-0 font-weight-bold text-dark">1. Request Pickup Information</h4>
													</div>
												</div>
												
												<?= $this->session->userdata('message') ?>
												<?php echo validation_errors(); ?>

												<div class="row bg-white p-4 rounded shadow-sm mb-4">
													<div class="col-md-1">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Type<span class="text-danger">*</span></label>
															<div class="form-check custom-radio mt-2">
																<input class="form-check-input" type="radio" name="is_incoming" id="flexRadioDefault1" value="1">
																<label class="form-check-label" for="flexRadioDefault1">Incoming</label>
															</div>
															<div class="form-check custom-radio">
																<input class="form-check-input" type="radio" name="is_incoming" id="flexRadioDefault2" value="0">
																<label class="form-check-label" for="flexRadioDefault2">Outgoing</label>
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Destination</label>
															<textarea name="destination" class="form-control" placeholder="Enter destination details"><?php echo set_value('destination'); ?></textarea>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Shipper<span class="text-danger">*</span></label>
															<div id="prefetch">
																<input type="text" class="form-control" id="shipper" required name="shipper" value="<?php echo set_value('shipper'); ?>" placeholder="Enter shipper name">
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Shipper Address</label>
															<div id="prefetch">
																<input type="text" class="form-control" id="shipper_address" name="shipper_address" value="<?php echo set_value('shipper_address'); ?>" placeholder="Enter shipper address">
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Consignee</label>
															<div id="prefetch">
																<input type="text" class="form-control" name="consigne" value="<?php echo set_value('consigne'); ?>" placeholder="Enter consignee name">
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Consignee Address</label>
															<div id="prefetch">
																<input type="text" class="form-control" name="consigne_address" value="<?php echo set_value('consigne_address'); ?>" placeholder="Enter consignee address">
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Payment</label>
															<div class="form-check custom-checkbox mt-2">
																<input class="form-check-input" name="payment" type="checkbox" value="Cash" id="flexCheckDefault">
																<label class="form-check-label" for="flexCheckDefault">Cash</label>
															</div>
															<div class="form-check custom-checkbox">
																<input class="form-check-input" name="payment" type="checkbox" value="Credit" id="flexCheckChecked">
																<label class="form-check-label" for="flexCheckChecked">Credit</label>
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Use Generate Resi ?<span class="text-danger ml-2">FOR EH CHOOSE YES</span></label>
															<div class="form-check custom-radio mt-2">
																<input class="form-check-input" type="radio" name="type" id="flexRadioDefault1" value="1">
																<label class="form-check-label" for="flexRadioDefault1">Yes</label>
															</div>
															<div class="form-check custom-radio">
																<input class="form-check-input" type="radio" name="type" id="flexRadioDefault2" value="0">
																<label class="form-check-label" for="flexRadioDefault2">No</label>
															</div>
														</div>
													</div>
												</div>
											</div>

											<!-- Section 2: Pickup Information -->
											<div class="pb-5">
												<div class="d-flex align-items-center bg-light-success p-3 rounded mb-4">
													<div class="mr-3">
														<span class="svg-icon svg-icon-success svg-icon-2x">
															<i class="fas fa-calendar-check fa-2x text-success"></i>
														</span>
													</div>
													<div>
														<h4 class="mb-0 font-weight-bold text-dark">2. Pickup Information</h4>
													</div>
												</div>
												
												<div class="row bg-white p-4 rounded shadow-sm mb-4">
													<div class="col-md-2">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Pickup Date<span class="text-danger">*</span></label>
															<input type="date" class="form-control" id="tgl_pickup" required name="tgl_pickup" value="<?php echo set_value('tgl_pickup'); ?>">
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Pickup Time<span class="text-danger">*</span></label>
															<input type="time" class="form-control" required name="time" value="<?php echo set_value('tgl_pickup'); ?>">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Moda <span class="text-danger">*</span></label>
															<select name="pu_moda" class="form-control select2">
																<?php foreach ($moda as $s) { ?>
																	<option value="<?= $s['nama_moda'] ?>" <?php if ($s['nama_moda'] == set_value('pu_moda')) echo 'selected'; ?>><?= $s['nama_moda'] ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Packing</label>
															<select name="packing" class="form-control select2">
																<option value="NULL">None</option>
																<?php foreach ($packing as $s) { ?>
																	<option value="<?= $s['nama_packing'] ?>" <?php if ($s['nama_packing'] == set_value('packing')) echo 'selected'; ?>><?= $s['nama_packing'] ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Pickup Point<span class="text-danger">*</span></label>
															<input type="text" class="form-control" required name="pu_poin" value="<?php echo set_value('pu_poin'); ?>" placeholder="Enter pickup point">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Service Type <span class="text-danger">*</span></label>
															<select name="service" class="form-control select2">
																<?php foreach ($service as $s) { ?>
																	<option value="<?= $s['service_name'] ?>" <?php if ($s['service_name'] == set_value('service_type')) echo 'selected'; ?>><?= $s['service_name'] ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Commodity<span class="text-danger">*</span></label>
															<input type="text" class="form-control" required name="commodity" value="<?php echo set_value('commodity'); ?>" placeholder="Enter commodity details">
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Koli</label>
															<input type="number" class="form-control" name="koli" value="<?php echo set_value('koli'); ?>" placeholder="Enter koli">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="font-weight-bold text-dark">Note</label>
															<textarea name="note" class="form-control" placeholder="Enter additional notes"><?php echo set_value('note'); ?></textarea>
														</div>
													</div>
												</div>
												
												<!-- DO Section -->
												<div class="bg-white p-4 rounded shadow-sm mb-4">
													<div id="nextkolom2" name="nextkolom2"></div>
													<button type="button" class="btn btn-info btn-pill btn-shadow mb-3 tambahBarisDo">
														<i class="fa fa-plus mr-1"></i> Tambah No DO
													</button>
													<button type="button" id="jumlahkolom2" value="1" style="display:none"></button>
												</div>
												
												<div class="ln_solid2"></div>
												<div id="nextkolom" name="nextkolom"></div>
												<button type="button" id="jumlahkolom" value="1" style="display:none"></button>

												<!-- Submit Button -->
												<div class="text-right mt-4">
													<button onclick='$("#modalLoading").modal("show");' type="submit" class="btn btn-primary btn-lg btn-pill btn-shadow" data-wizard-type="action-submit">
														<i class="fas fa-paper-plane mr-2"></i> Submit
													</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Script section -->
	<script>
		$(document).ready(function() {
			// Enable select2 for dropdown
			$('.select2').select2({
				width: '100%',
				placeholder: 'Select an option'
			});
			
			var i = 1;
			$(".tambahBarisDo").on('click', function() {
				row = '<div class="rec-element2 slide-in">' +
					'<div class="form-group">' +
					'<label class="control-label font-weight-bold" for="first-name">No. DO/DN ' + i + ' <span class="required"></span>' +
					'</label>' +
					'<div class="input-group">' +
					'<input type="text" name="doReqPickup[]" id="doReqPickup' + i + '" alt="' + i + '" class="form-control" placeholder="Enter DO/DN number">' +
					'<div class="input-group-append">' +
					'<button type="button" class="btn btn-danger del-element2"><i class="fa fa-minus-square mr-1"></i> Hapus</button>' +
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
				$(this).parents('.rec-element2').fadeOut(300, function() {
					$(this).remove();
				});
				$('#jumlahkolom2').val(i - 1);
			});
		});
	</script>

	<style>
		.form-control {
			border-radius: 0.5rem;
			padding: 0.65rem 1rem;
		}
		
		.form-control:focus {
			border-color: #9c223b;
			box-shadow: 0 0 0 0.2rem rgba(156, 34, 59, 0.25);
		}
		
		.btn-pill {
			border-radius: 50px;
		}
		
		.btn-shadow {
			box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
		}
		
		.slide-in {
			animation: slideIn 0.3s ease-in-out;
		}
		
		@keyframes slideIn {
			0% {
				opacity: 0;
				transform: translateY(-10px);
			}
			100% {
				opacity: 1;
				transform: translateY(0);
			}
		}
		
		.custom-radio .form-check-input, .custom-checkbox .form-check-input {
			margin-top: 0.25rem;
		}
		
		.bg-gradient-light {
			background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
		}
	</style>