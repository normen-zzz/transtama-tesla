<?php $shipment_id = $this->db->get_where('tbl_booking_number_resi', array('id_driver' => $this->session->userdata('id_user')))->result_array(); ?>
<!-- Main content -->
<style>
	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}
</style>
<section class="content">
	<div class="container-fluid">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h2 class="card-title">Add Special Order</h2>

						<!-- <div class="card-toolbar mb-2">
							<a href="<?= base_url('uploads/import.xlsx') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
								<i class="fas fa-download text-light"> </i>
								Download Template
							</a>
						</div> -->

					</div>
					<!-- /.card-header -->
					<div class="card-body" style="overflow: auto;">
						<p class="text-danger"><?= $this->session->flashdata('message'); ?></p>
						<div class="card-body p-0">
							<!--begin: Wizard-->
							<div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="step-first" data-wizard-clickable="true">
								<!--begin: Wizard Body-->
								<div class="row justify-content-center py-10 px-8 py-lg-12 px-lg-10">
									<div class="col-xl-12 col-xxl-7">
										<!--begin: Wizard Form-->
										<form id="kt_form" novalidate="novalidate" action="<?= base_url('shipper/order/processAddShipmentGenerateResi') ?>" method="POST" enctype="multipart/form-data">
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">No Resi<span class="text-danger">*</span></label>
													<input type="number" name="shipment_id" class="form-control" placeholder="Cth: 1234">
												</div>
												<!-- <div class="form-group">
													<label for="exampleInputEmail1">Service Type<span class="text-danger">*</span></label>
													<select name="service_type" class="form-control" width="150px">
														<?php foreach ($service as $s) {
														?>
															<option value="<?= $s['code'] ?>" <?php if ($s['code'] == set_value('service_type')) {
																									echo 'selected';
																								} ?>><?= $s['service_name'] ?></option>
														<?php  } ?>
													</select>
												</div> -->
												<!-- <div class="form-group">
													<label for="exampleInputEmail1">Moda<span class="text-danger">*</span></label>
													<select name="moda" class="form-control" required id="moda">
														<option value="NULL">-Choose Moda-</option>
														<?php foreach ($moda as $m) {
														?>
															<option value="<?= $m['nama_moda'] ?>" <?php if ($m['nama_moda'] == $so['pu_moda']) {
																										echo 'selected';
																									} ?>><?= $m['nama_moda'] ?></option>
														<?php  } ?>
													</select>
												</div> -->
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
											<div class="col-md-4">
												<div class="form-group">
													<label class="col-form-label text-lg-right font-weight-bold">Upload File</label>
													<input type="file" name="upload_fileuncompress[]" onchange="preview_image(); handleImageUpload(this.id);" accept="image/*" capture multiple id="upload_file" />
													<input type="file" class="form-control" name="ktp2[]" accept="image/*" capture id="upload_file2" hidden>
													<input type="text" name="id_so" value="<?= $id_so ?>" hidden>
													<input type="text" name="id_tracking" value="<?= $id_tracking ?>" hidden>
												</div>
											</div>
											<div class="col-md-4 mb-2">
												<div id="image_preview"></div>
											</div>

											<!--begin: Wizard Actions-->
											<div class="d-flex justify-content-between border-top mt-5 pt-10">

												<button type="submit" class="btn mr-2 text-light" style="background-color: #9c223b;">Submit</button>
												<a href="<?= base_url('shipper/order/view/' . $id_so . '/' . $id_tracking) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
													<i class="fas fa-chevron-circle-left text-light"> </i>
													Back
												</a>

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