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
								<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/salesOrder/detail/' . $id_so) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-chevron-circle-left text-light"> </i>
									Back
								</a>
								<a href="<?= base_url('cs/order/print/' . $p['shipment_id']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
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
									<!--begin: Wizard Body-->
									<div class="row justify-content-center py-10 px-8 py-lg-12 px-lg-10">
										<div class="col-xl-12 col-xxl-7">
											<!--begin: Wizard Form-->
											<form id="kt_form" novalidate="novalidate" action="<?= base_url('cs/order/processEdit') ?>" method="POST" enctype="multipart/form-data">
												<!--begin: Wizard Step 1-->
												<div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
													<h4 class="mb-10 font-weight-bold text-dark">Order Information</h4>
													<?= $this->session->userdata('message') ?>
													<!--begin::Input-->
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Shipper <small class="text-danger">(*Required)</small></label> <br>
																<?= form_error('shipper', '<small class="text-danger pl-3">', '</small>'); ?>
																<input type="text" class="form-control" required name="shipper" id="shipper" value="<?= $p['shipper'] ?>" disabled>
																<input type="text" class="form-control" required name="id" value="<?= $p['id'] ?>" hidden>
																<input type="text" class="form-control" required name="id_so" value="<?= $p['id_so'] ?>" hidden>
															</div>
														</div>

														<div class="form-group">
																<label for="exampleInputEmail1">Mark Shipper</label>
																<?php if ($p['mark_shipper'] == NULL || $p['mark_shipper'] == '') { ?>
																	<input type="text" class="form-control" id="mark_shipper" name="mark_shipper" value="">
																<?php }else{ ?>
																	<input type="text" class="form-control" id="mark_shipper" name="mark_shipper" value="<?= $p['mark_shipper'] ?>">
																<?php } ?>
																
															</div>

														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputPassword1">Destination</label>
																<textarea name="destination" class="form-control" required id="destination"><?= $p['destination'] ?></textarea>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Origin State</label>
																<select name="state_shipper" class="form-control">
																	<?php foreach ($province as $f) {
																	?>
																		<option value="<?= $f['name'] ?>" <?php if ($f['name'] == $p['state_shipper']) {
																												echo 'selected';
																											}  ?>><?= $f['name'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Origin City</label>
																<select name="city_shipper" class="form-control" id="city" disabled>
																	<?php foreach ($city as $c) {
																	?>
																		<option value="<?= $c['city_name'] ?>" <?php if ($c['city_name'] == $p['city_shipper']) {
																													echo 'selected';
																												}  ?>><?= $c['city_name'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>



														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Consigne</label>
																<input type="text" class="form-control" required name="consigne" value="<?= $p['consigne'] ?>">
															</div>
														</div>
														<!-- <div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Destination</label>
																<input type="text" class="form-control" required name="destination">
															</div>
														</div> -->
														<div class="col-md-3">
															<div class="form-group">
																<label for="exampleInputEmail1">Destination State</label>
																<select name="state_consigne" class="form-control">
																	<?php foreach ($province as $f) {
																	?>
																		<?php if ($p['state_consigne'] == NULL || $p['state_consigne'] == '') {
																		?>
																			<option value="">-</option>
																		<?php } ?>
																		<option value="<?= $f['name'] ?>" <?php if ($f['name'] == $p['state_consigne']) {
																												echo 'selected';
																											}  ?>><?= $f['name'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label for="exampleInputEmail1">Destination City</label>

																<select name="city_consigne" class="form-control">
																	<?php foreach ($city as $c) {
																	?>
																		<?php if ($p['city_consigne'] == NULL || $p['city_consigne'] == '') {
																		?>
																			<option value="">-</option>
																		<?php } ?>
																		<option value="<?= $c['city_name'] ?>" <?php if ($c['city_name'] == $p['city_consigne']) {
																													echo 'selected';
																												} ?>><?= $c['city_name'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>

														<div class="col-md-3">
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
														<div class="col-md-2">
															<div class="form-group">
																<label for="exampleInputEmail1">Koli</label>
																<input type="number" class="form-control" disabled required name="koli" value="<?= $p['koli'] ?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label for="exampleInputEmail1">Weight</label>
																<input type="number" class="form-control" required name="weight" disabled value="<?= $p['berat_js'] ?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label for="exampleInputEmail1">Is Weight Print ?</label>
																<div class="form-check">
																	<input class="form-check-input" type="radio" name="is_weight_print" id="flexRadioDefault1" value="1" <?php if ($p['is_weight_print'] == 1) {
																																												echo 'checked';
																																											} ?>>
																	<label class="form-check-label" for="flexRadioDefault1">
																		Yes
																	</label>
																</div>
																<div class="form-check">
																	<input class="form-check-input" type="radio" name="is_weight_print" id="flexRadioDefault2" value="0" <?php if ($p['is_weight_print'] == 0) {
																																												echo 'checked';
																																											} ?>>
																	<label class="form-check-label" for="flexRadioDefault2">
																		No
																	</label>
																</div>
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
														<div class="col-md-2">
															<div class="form-group">
																<label for="exampleInputEmail1">Sender</label>
																<input type="text" class="form-control" required name="sender" value="<?= $p['sender'] ?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label for="exampleInputEmail1">Commodity</label>
																<input type="text" class="form-control" required name="pu_commodity" value="<?= $p['pu_commodity'] ?>">
															</div>
														</div>
														<!-- <div class="col-md-3">
															<div class="form-group">
																<label for="exampleInputEmail1">No. DO/DN</label>
																<input type="text" class="form-control" name="note_cs" value="<?= $p['note_cs'] ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label for="exampleInputEmail1">No. SO/PO</label>
																<input type="text" class="form-control" name="no_so" value="<?= $p['no_so'] ?>">
															</div>
														</div> -->
														<div class="col-md-3">
															<div class="form-group">
																<label for="exampleInputEmail1">STP</label>
																<input type="text" class="form-control" name="no_stp" value="<?= $p['no_stp'] ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label for="exampleInputEmail1">SMU</label>
																<input type="text" class="form-control" name="no_smu" value="<?= $p['no_smu'] ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label for="exampleInputEmail1">Flight At</label>
																<input type="datetime-local" class="form-control" name="flight_at" value="<?= $p['flight_at'] ?>">
															</div>
														</div>

														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputPassword1">Note Cs</label>
																<textarea name="note_shipment" class="form-control"><?= $p['note_shipment'] ?></textarea>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Image</label>
																<img src="<?= base_url('uploads/berkas/' . $p['image']) ?>" width="250" height="250">

															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Signature</label>
																<img src="data:<?= $p['signature']; ?>" height="80" width="100">
															</div>
														</div>


													</div>
													<div class="row">
														<div class="col-md-12">
															<h4 class="mb-10 font-weight-bold text-dark">Detail Order</h4>
														</div>
														<?php $get_do = $this->db->get_where('tbl_no_do', ['shipment_id' => $p['shipment_id']])->result_array();
														if ($get_do) {
															$no = 1;
															foreach ($get_do as $do) {
														?>
																<div class="col-md-3">
																	<div class="form-group">
																		<label for="exampleInputEmail1">No. DO/DN <?= $no; ?></label>
																		<input type="text" class="form-control" name="note_cs[]" value="<?= $do['no_do'] ?>">
																		<input type="text" class="form-control" hidden name="id_do[]" value="<?= $do['id_berat'] ?>">
																	</div>
																</div>
																<div class="col-md-2">
																	<div class="form-group">
																		<label for="exampleInputEmail1">No. SO/PO <?= $no; ?></label>
																		<input type="text" class="form-control" name="no_so[]" value="<?= $do['no_so'] ?>">
																	</div>
																</div>
																<div class="col-md-2">
																	<div class="form-group">
																		<label for="exampleInputEmail1">Collie <?= $no; ?></label>
																		

																		<?php if ($invoice == NULL) { ?>
																			<input type="text" class="form-control" name="collie[]" value="<?= $do['koli'] ?>">
																			<?php } else {
																			if ($invoice['status'] == 1 || $invoice['status'] == 2) { ?>
																				<input type="text" class="form-control" name="collie[]" readonly value="<?= $do['koli'] ?>">
																			<?php } else { ?>
																				<input type="text" class="form-control" name="collie[]" value="<?= $do['koli'] ?>">
																		<?php }
																		} ?>
																	</div>
																</div>
																<div class="col-md-2">
																	<div class="form-group">
																		<label for="exampleInputEmail1">Weight <?= $no; ?></label>
																		<?php if ($invoice == NULL) { ?>
																			<input type="text" class="form-control" name="weight[]" value="<?= $do['berat'] ?>">
																			
																			<?php } else {
																			if ($invoice['status'] == 1 || $invoice['status'] == 2) { ?>
																				<input type="text" class="form-control" name="weight[]" readonly value="<?= $do['berat'] ?>">
																			<?php } else { ?>
																				<input type="text" class="form-control" name="weight[]" value="<?= $do['berat'] ?>">
																				
																		<?php }
																		} ?>

																	</div>
																</div>
																<div class="col-md-2">
																	<div class="form-group">
																		<label for="exampleInputEmail1">Action</label>
																		<?php if ($invoice == NULL) { ?>
																			<a class=" form-control btn btn-danger" href="<?= base_url('cs/Order/deleteDo/'.$do['id_berat']) ?>">Delete</a>
																			<?php } else {
																			if ($invoice['status'] == 1 || $invoice['status'] == 2) { ?>
																				-
																			<?php } else { ?>
																				<a class=" form-control btn btn-danger" href="<?= base_url('cs/Order/deleteDo/'.$do['id_berat']) ?>">Delete</a>
																		<?php }
																		} ?>

																	</div>
																</div>
																<br>
															<?php $no++;
															}

															?>
															<!-- <div class="col-md-4">
																<div class="form-group">
																	<label for="exampleInputEmail1">No. SO/PO</label>
																	<input type="text" class="form-control" name="no_so" value="<?= $do['no_so'] ?>">
																</div>
															</div> -->


														<?php	} else {


														?>
															<div class="col-md-4">
																<div class="form-group">
																	<label for="exampleInputEmail1">No. DO/DN </label>
																	<input type="text" class="form-control" name="note_cs[]" value="<?= $p['note_cs'] ?>">
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<label for="exampleInputEmail1">Koli </label>
																	

																	<?php if ($invoice == NULL) { ?>
																		<input type="text" class="form-control" name="koli" value="<?= $p['koli'] ?>">
																			<?php } else {
																			if ( $invoice['status'] != 2) { ?>
																				<input type="text" class="form-control" name="koli" readonly value="<?= $p['koli'] ?>">
																			<?php } else { ?>
																				<input type="text" class="form-control" name="koli" value="<?= $p['koli'] ?>">
																		<?php }
																		} ?>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="exampleInputEmail1">Weight </label>
																	<?php if ($invoice == NULL) { ?>
																		<input type="text" class="form-control" name="weight" value="<?= $p['berat_js'] ?>">
																			<?php } else {
																			if ($invoice['status'] != 2) { ?>
																				<input type="text" class="form-control" name="weight" readonly value="<?= $p['berat_js'] ?>">
																			<?php } else { ?>
																				<input type="text" class="form-control" name="weight" value="<?= $p['berat_js'] ?>">
																		<?php }
																		} ?>
																	
																</div>
															</div>
														<?php 	} ?>
													</div>

												</div>

												<!--begin: Wizard Actions-->
												<div class="d-flex justify-content-between border-top mt-5 pt-10">

												

													<div>
													<?php if ($invoice == NULL) { ?>
                                               
														<button onclick='$("#modalLoading").modal("show");' type="submit" class="btn btn font-weight-bolder text-uppercase px-9 py-4 text-light" style="background-color: #9c223b;">Submit</button>
											   <?php } else { 
													if ($invoice['status'] == 1 || $invoice['status'] == 2) {
												   ?>
													
													<?php } else{ ?>
														<button onclick='$("#modalLoading").modal("show");' type="submit" class="btn btn font-weight-bolder text-uppercase px-9 py-4 text-light" style="background-color: #9c223b;">Submit</button>
													<?php } }?>
														

													</div>
												</div>
												<!--end: Wizard Actions-->
											</form>

											<div class="row" style="margin-top: 100px ;">

												<div class="col">
													<h2>Tambah DO</h2>
													<form action="<?= base_url('cs/Order/tambahDo') ?>" method="POST">
														<div class="col">
															<div class="form-group">
																<label for="exampleInputEmail1">No. DO/DN </label>
																<input type="text" class="form-control" name="tambahNoDo">
																<input type="text" name="tambahShipmentId" id="" value="<?= $p['shipment_id'] ?>" hidden>

															</div>
														</div>
														<div class="col">
															<div class="form-group">
																<label for="exampleInputEmail1">No. SO/PO</label>
																<input type="text" class="form-control" name="tambahNoSo">
															</div>
														</div>

														<div>
														<?php if ($invoice == NULL) { ?>
                                               
															<button type="submit" class="btn btn font-weight-bolder text-uppercase px-9 py-4 text-light" style="background-color: #9c223b;">Submit Tambah Do</button>
											   <?php } else { 
													if ($invoice['status'] == 1 || $invoice['status'] == 2) {
												   ?>
												
													<?php } else{ ?>
														<button type="submit" class="btn btn font-weight-bolder text-uppercase px-9 py-4 text-light" style="background-color: #9c223b;">Submit Tambah Do</button>

													<?php }}?>
															
														</div>
													</form>
												</div>
											</div>
											
											<?php if ($dimension != NULL) { ?>
												
											
											<div class="row" style="margin-top: 100px ;">
												<div class="col">
													<h2>Dimension From Outbond</h2>
													<table class="table">
														<thead>
															<tr>
																<th>Koli</th>
																<th>Panjang</th>
																<th>Lebar</th>
																<th>Tinggi</th>
																<th>Berat Aktual</th>
																<th>Berat Volume</th>
																<th>No DO</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($dimension as $dimension1) { ?>
															<tr>
																<td scope="row"><?= $dimension1['koli'] ?></td>
																<td><?= $dimension1['panjang'] ?></td>
																<td><?= $dimension1['lebar'] ?></td>
																<td><?= $dimension1['tinggi'] ?></td>
																<?php if ($dimension1['berat_aktual'] > $dimension1['berat_volume']) { ?>
																	<td><strong><?= $dimension1['berat_aktual'] ?></strong></td>
																	<td><?= $dimension1['berat_volume'] ?></td>
																<?php } elseif ($dimension1['berat_aktual'] < $dimension1['berat_volume']){ ?>
																	
																	<td><?= $dimension1['berat_aktual'] ?></td>
																	<td><strong><?= $dimension1['berat_volume'] ?></strong></td>
																	<?php } else{ ?>
																		<td><?= $dimension1['berat_aktual'] ?></td>
																	<td><strong><?= $dimension1['berat_volume'] ?></strong></td>
																		<?php } ?>
																
																
																<td><?= $dimension1['no_do'] ?></td>
															</tr>
															
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
											<?php } ?>
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