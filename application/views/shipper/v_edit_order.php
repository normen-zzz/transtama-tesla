	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch">
						<div class="card-header py-3">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bolder text-dark">Edit Order </h3>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Shipment ID :<b> <?= $p['shipment_id'] ?></b></span>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Order ID :<b> <?= $p['order_id'] ?></b></span>
							</div>
							<div class="card-toolbar">
								<a href="<?= base_url('shipper/order/view/' . $id_so . '/' . $id_tracking) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-chevron-circle-left text-light"> </i>
									Back
								</a>
								<a href="<?= base_url('shipper/order/print/' . $p['shipment_id']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-print text-light"> </i>
									Print
								</a>
							</div>

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
											<form id="kt_form" novalidate="novalidate" action="<?= base_url('shipper/order/processEdit') ?>" method="POST" enctype="multipart/form-data">
												<!--begin: Wizard Step 1-->
												<div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
													<h4 class="mb-10 font-weight-bold text-dark">Edit Order</h4>
													<?= $this->session->userdata('message') ?>
													<!--begin::Input-->
													<div class="row">

														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Shipper</label>
																<select name="shipper_id" class="form-control" disabled>
																	<option value="choose">Choose Shipper</option>
																	<?php foreach ($customer as $f) {
																	?>
																		<option value="<?= $f['id_customer'] ?>" <?php if ($f['nama_pt'] == $p['shipper']) {
																														echo 'selected';
																													} ?>><?= $f['nama_pt'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>

														<input type="text" class="form-control" hidden name="id" value="<?= $p['id'] ?>">
														<input type="text" class="form-control" hidden name="id_so" value="<?= $p['id_so'] ?>">
														<input type="text" class="form-control" hidden name="id_tracking" value="<?= $id_tracking ?>">


														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputPassword1">Destination</label>
																<textarea name="destination" class="form-control" required id="destination"><?= $p['destination'] ?></textarea>
															</div>
														</div>

														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Consigne</label>
																<input type="text" class="form-control" required name="consigne" value="<?= $p['consigne'] ?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Destination State</label>
																<select name="state_consigne" class="form-control">
																	<?php foreach ($province as $f) {
																	?>
																		<option value="<?= $f['name'] ?>" <?php if ($f['name'] == $p['state_consigne']) {
																												echo 'selected';
																											}  ?>><?= $f['name'] ?></option>
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
																		<option value="<?= $c['city_name'] ?>" <?php if ($c['city_name'] == $p['city_consigne']) {
																													echo 'selected';
																												} ?>><?= $c['city_name'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>


														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Service Type</label>
																<select name="service_type" class="form-control">
																	<?php foreach ($service as $s) {
																	?>
																		<option value="<?= $s['code'] ?>" <?php if ($s['code'] == $p['service_type']) {
																												echo 'selected';
																											} ?>><?= $s['service_name'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Moda<span class="text-danger">*</span></label>
																<select name="moda" class="form-control">
																	<?php foreach ($moda as $m) {
																	?>
																		<option value="<?= $m['nama_moda'] ?>" <?php if ($m['nama_moda'] == $p['pu_moda']) {
																													echo 'selected';
																												} ?>><?= $m['nama_moda'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Koli</label>
																<input type="number" class="form-control" required name="koli" value="<?= $p['koli'] ?>">
															</div>
														</div>
														<?php $get_do = $this->db->get_where('tbl_no_do', ['shipment_id' => $p['shipment_id']])->result_array(); ?>
														<?php

														if ($get_do) {
															$no = 1;
															foreach ($get_do as $do) {
														?>
																<div class="col-md-4">
																	<div class="form-group">
																		<label for="exampleInputEmail1">No. DO/DN <?= $no; ?></label>
																		<input type="text" class="form-control" name="note_cs[]" value="<?= $do['no_do'] ?>">
																		<input type="text" class="form-control" hidden name="id_do[]" value="<?= $do['id_berat'] ?>">
																	</div>
																</div>
															<?php $no++;
															}
														} else {
															?>
															<div class="col-md-4">
																<div class="form-group">
																	<label for="exampleInputEmail1">No. DO/DN </label>
																	<input type="text" class="form-control" name="note_cs[]" value="<?= $p['note_cs'] ?>">
																</div>
															</div>

														<?php	}

														?>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">No. SO/PO</label>
																<input type="text" class="form-control" name="no_so" value="<?= $do['no_so'] ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label for="exampleInputEmail1">STP</label>
																<input type="text" class="form-control" name="no_stp" value="<?= $p['no_stp'] ?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label for="exampleInputEmail1">Tree Shipper</label>
																<input type="text" class="form-control" required name="tree_shipper" value="<?= $p['tree_shipper'] ?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label for="exampleInputEmail1">Tree Consignee</label>
																<input type="text" class="form-control" required name="tree_consignee" value="<?= $p['tree_consignee'] ?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputPassword1">Note</label>
																<textarea name="note_driver" class="form-control" rows="4"><?= $p['note_driver'] ?></textarea>
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
																<input type="file" class="form-control" name="ktp[]" accept="image/*" capture multiple>
																<?php if ($p['image'] == NULL) {
																?>
																	<!-- <input type="file" class="form-control" name="ktp" accept="image/*" capture> -->
																	<?php	} else {
																	$files = explode("+", $p['image']);
																	foreach ($files as $file) {
																		// var_dump($file);
																		// die;
																		$cek_foto = file_exists($_SERVER['DOCUMENT_ROOT'] . 'uploads/berkas/' . $file);
																		if ($cek_foto) {
																	?>
																			<div class="col-md-3">
																				<img src="<?= base_url('uploads/berkas/' . $file) ?>" width="250" height="250">

																			</div>

																		<?php    } else {
																		?>
																			<!-- <input type="file" name="foto[]" class="form-control" multiple> -->

																<?php    }
																	}
																} ?>
															</div>

														</div>

														<div class="col-md-4">
															<div class="form-group">
																<?php if ($p['signature'] == NULL) {
																?>
																	<button type="button" class="btn text-light" data-toggle="modal" data-target="#modal-lg" style="background-color: #9c223b;">
																		Add Signature
																	</button>

																<?php	} else {
																?>
																	<button type="button" class="btn text-light" data-toggle="modal" data-target="#modal-lg" style="background-color: #9c223b;">
																		Add Signature
																	</button>
																	<label for="exampleInputEmail1">Signature</label>
																	<img src="data:<?= $p['signature']; ?>" height="80" width="100">
																<?php	} ?>
															</div>
														</div>

														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Sender</label>
																<input type="text" class="form-control" required name="sender" id="sender" value="<?= $p['sender'] ?>">
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
								<div id="signature" style="height: 300%; width:100%;   border: 1px solid black;"></div><br />
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