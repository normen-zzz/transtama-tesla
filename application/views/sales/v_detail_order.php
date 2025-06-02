
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch">
						<div class="card-header py-3">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bolder text-dark">Detail Request Pickup </h3>
								<!-- <span class="text-muted font-weight-bold font-size-sm mt-1">Shipment ID :<b> <?= $p['shipment_id'] ?></b></span>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Order ID :<b> <?= $p['order_id'] ?></b></span> -->
								<div id="time-now">

								</div>
							</div>
							<div class="card-toolbar">
								<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-chevron-circle-left text-light"> </i>
									Back
								</a>
							</div>
						</div>

						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">

							<div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="step-first" data-wizard-clickable="true">
								<div class="row justify-content-center py-5 px-8">
									<div class="col-xl-12">
										<div class="pb-3" style="margin-top: -25px;">
											<h4 class="mb-3 font-weight-bold text-dark d-flex align-items-center">
												<span class="svg-icon svg-icon-primary svg-icon-2x mr-2">
													<i class="flaticon2-information" style="font-size: 22px; color: #9c223b;"></i>
												</span>
												<b>Sales Order Information</b>
											</h4>
											<?= $this->session->userdata('message') ?>

											<!-- Combined Information Table -->
											<div class="card card-custom shadow-sm mb-4">
												<div class="card-header" style="background-color: #f8f9fa;">
													<h5 class="card-title font-weight-bold">
														<i class="flaticon-file-1 text-primary mr-2"></i>
														Order & Pickup Details
													</h5>
												</div>
												<div class="card-body p-0">
													<div class="table-responsive">
														<table class="table table-bordered table-hover mb-0">
															<tbody>
																<tr>
																	<th style="width: 15%; background-color: #f8f9fa;">
																		<i class="flaticon2-delivery-package text-primary mr-1"></i> Order Type
																	</th>
																	<td style="width: 35%;">
																		<span class="badge badge-pill <?= $p['is_incoming'] == 1 ? 'badge-info' : 'badge-warning' ?> font-weight-bold px-2 py-1">
																			<?= $p['is_incoming'] == 1 ? ' Incoming' : ' Outgoing' ?>
																		</span>
																	</td>
																	<th style="width: 15%; background-color: #f8f9fa;">
																		<i class="flaticon2-pin mr-1"></i> Destination
																	</th>
																	<td style="width: 35%;">
																		<?= $p['destination'] ?>
																	</td>
																</tr>
																<tr>
																	<th style="background-color: #f8f9fa;">
																		<i class="flaticon2-user mr-1"></i> Shipper
																	</th>
																	<td><?= $p['shipper'] ?></td>
																	<th style="background-color: #f8f9fa;">
																		<i class="flaticon2-user mr-1"></i> Consignee
																	</th>
																	<td><?= $p['consigne'] ?></td>
																</tr>
																<tr>
																	<th style="background-color: #f8f9fa;">
																		<i class="flaticon2-map mr-1"></i> Shipper Address
																	</th>
																	<td><?= $p['shipper_address'] ?></td>
																	<th style="background-color: #f8f9fa;">
																		<i class="flaticon2-map mr-1"></i> Consignee Address
																	</th>
																	<td><?= $p['consigne_address'] ?></td>
																</tr>
																<tr>
																	<th style="background-color: #f8f9fa;">
																		<i class="flaticon-calendar-1 mr-1"></i> Pickup Date/Time
																	</th>
																	<td>
																		<?= date('d F Y', strtotime($p['tgl_pickup'])) ?> - <?= date('H:i', strtotime($p['time'])) ?> WIB
																	</td>
																	<th style="background-color: #f8f9fa;">
																		<i class="flaticon-truck mr-1"></i> Transportation
																	</th>
																	<td>
																		<?php
																		$moda_icons = [
																			'Air' => 'flaticon2-plane',
																			'Land' => 'flaticon2-truck',
																			'Sea' => 'flaticon2-boat-ship'
																		];
																		$icon_class = isset($moda_icons[$p['pu_moda']]) ? $moda_icons[$p['pu_moda']] : 'flaticon2-delivery-package';
																		?>
																		<i class="<?= $icon_class ?>"></i> <?= $p['pu_moda'] ?> -
																		<span class="badge badge-primary"><?= $p['service'] ?></span>
																	</td>
																</tr>
																<tr>
																	<th style="background-color: #f8f9fa;">
																		<i class="flaticon-price-tag mr-1"></i> Payment Method
																	</th>
																	<td>
																		<span class="badge badge-pill <?= $p['payment'] == 'Cash' ? 'badge-success' : 'badge-primary' ?>">
																			<?= $p['payment'] == "Cash" ? '<i class="fas fa-money-bill-wave"></i> Cash' : '<i class="fas fa-credit-card"></i> Credit' ?>
																		</span>
																	</td>
																	<th style="background-color: #f8f9fa;">
																		<i class="flaticon2-box mr-1"></i> Commodities
																	</th>
																	<td>
																		<?= $p['commodity'] ?> - <span class="badge badge-info"><?= $p['koli'] ?> Units</span>
																		<?= ($p['packing'] != 'NULL' && !empty($p['packing'])) ? ' - Packing: ' . $p['packing'] : '' ?>
																	</td>
																</tr>
																<tr>
																	<th style="background-color: #f8f9fa;">
																		<i class="flaticon2-pin mr-1"></i> Pickup Point
																	</th>
																	<td><?= $p['pu_poin'] ?></td>
																	<th style="background-color: #f8f9fa;">
																		<i class="flaticon2-chat-1 mr-1"></i> Note
																	</th>
																	<td><?= !empty($p['note']) ? $p['note'] : '<em class="text-muted">No notes provided</em>' ?></td>
																</tr>
																<tr>
																	<th style="background-color: #f8f9fa;">
																		<i class="flaticon2-truck mr-1"></i> Driver
																	</th>
																	<td><?= $driver['nama_user'] ?></td>
																	<th style="background-color: #f8f9fa;">
																		<i class="flaticon2-chat-1 mr-1"></i> Plate Number
																	</th>
																	<td><?= !empty($p['nopol']) ? $p['nopol'] : '<em class="text-muted">No plate number provided</em>' ?></td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>



							<?php if ($detailrequest) { ?>
								<div class="row">
									<h3>History Request Price</h3>
									<table class="table table-bordered">
										<thead>
											<tr>

												<th>ID Request</th>
												<th>Request At</th>
												<th>Customer</th>
												<th>From</th>
												<th>To</th>
												<th>Moda</th>
												<th>Jenis</th>
												<th>Berat (KG)</th>
												<th>Koli</th>
												<th>Dimension</th>
												<th>Price Approved</th>
												<th>Notes Sales</th>
												<th>Notes CS</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>REQP - <?= $detailrequest['id_detailrequest'] ?></td>
												<td><?= date('d-m-Y H:i:s', strtotime($detailrequest['created_at']))  ?></td>
												<td><?= getNameCustomer($detailrequest['customer']) ?></td>
												<td><?= $detailrequest['alamat_from'] . ', ' . $detailrequest['kecamatan_from'] . ', ' . $detailrequest['kota_from'] . ', ' . $detailrequest['provinsi_from'] ?></td>
												<td><?= $detailrequest['alamat_to'] . ', ' . $detailrequest['kecamatan_to'] . ', ' . $detailrequest['kota_to'] . ', ' . $detailrequest['provinsi_to'] ?></td>
												<td><?= moda($detailrequest['moda'])  ?></td>
												<td><?= $detailrequest['jenis'] ?></td>
												<td><?= $detailrequest['berat'] ?></td>
												<td><?= $detailrequest['koli'] ?></td>
												<td><?= (int)$detailrequest['panjang'] . ' X ' . (int)$detailrequest['lebar'] . ' X ' . (int)$detailrequest['tinggi'] ?><br> Air :<?= ((int)$detailrequest['panjang'] * (int)$detailrequest['lebar'] * (int)$detailrequest['tinggi']) / 6000 ?> KG<br>Land :<?= ((int)$detailrequest['panjang'] * (int)$detailrequest['lebar'] * (int)$detailrequest['tinggi']) / 4000 ?> KG</td>
												<td><?= rupiah($detailrequest['price']) ?> </td>
												<td><?= $detailrequest['notes_sales'] ?></td>
												<td><?= $detailrequest['notes_cs'] ?></td>
											</tr>

										</tbody>
									</table>
								</div>
							<?php } ?>

							<div class="row">
								<?php if ($p['device_id'] != NULL && $p['device_id'] != '-') { ?>
									<!-- Map Container -->
									<div class="col-md-12 mb-4">
										<div class="card card-custom shadow-sm">
											<div class="card-header" style="background-color: #f8f9fa;">
												<h5 class="card-title font-weight-bold">
													<i class="flaticon2-map-1 text-primary mr-2"></i>
													Live Vehicle Tracking
												</h5>
											</div>
											<div class="card-body p-0">
												<style>
													#map {
														height: 400px;
														width: 100%;
														border-radius: 0 0 4px 4px;
													}
												</style>
												<div id="map"></div>
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if ($p['status_pickup'] == 4) { ?>
								<div class="col-md-12">
									<form action="<?= base_url('sales/salesOrder/prosesSo') ?>" method="POST">
										<table id="myTablee" class="table table-bordered" style="width: 500%;">
											<?php if ($p['status'] == 5) {
											?>
												<h3 class="title font-weight-bold">Request Canceled</h3>
												<h6 class="title font-weight-bold">Reason : <?= $p['alasan_cancel'] ?></h6>


											<?php	} else {
											?>
												<h3 class="title font-weight-bold">List Sales Order</h3>
												<a href="<?= base_url('sales/salesOrder/export/' . $p['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
													<i class="fas fa-download text-light"> </i>
													Export SO
												</a>

											<?php if ($this->session->userdata('id_user') == $p['id_sales']) {
													// jika blm submit so
													if ($p['submitso_at'] == NULL) {
														if ($p['deadline_sales_so'] >= date('Y-m-d')) {
															echo '<a href="#" class="btn mr-2 text-light" data-toggle="modal" data-target="#modal-import" style="background-color: #9c223b;">
															<i class="fas fa-upload text-light"> </i>
															Import SO
														</a>';
														} else {

															if ($request_aktivasi) {
																if ($request_aktivasi['status'] == 0) {
																	echo 'Wait Approve';
																} else {
																}
															} else {
																// cek apakah hari ini dengan hari deadline  beda sehari 
																if (strtotime($p['deadline_sales_so']) - strtotime(date('Y-m-d')) == 86400) {
																	// cek apakah pickup diatas jam 9 malam dan dibawah jam 12 malam	
																	if (date('H:i:s', strtotime($p['pickup_at'])) >= date('H:i:s', strtotime('21:00:00')) && date('H:i:s', strtotime($p['pickup_at'])) <= date('H:i:s', strtotime('23:59:59'))) {

																		// cek sekarang jam berapa, jika sudah dibawah jam 09 pagi 
																		if (date('H:i:s') <= date('H:i:s', strtotime('09:00:00'))) {
																		} else {
																			echo "<h4>SO Late Submit (Diatas jam 9 pagi)</h4><br>";
																		}
																	}
																}
															}
														}
													}
												}
											} ?>



											<p><?= $this->session->flashdata('message'); ?></p>
											<thead>
												<tr>
													<th style="width: 10%;">Shipment ID</th>
													<th style="width: 15%;">Shipper</th>
													<th style="width: 15%;">Consignee</th>
													<!-- <th>Destination</th> -->
													<th style="width: 15%;">Freight/Kg</th>
													<th style="width: 10%;">Special Freight/Kg</th>
													<th style="width: 15%;">Packing</th>
													<th style="width: 15%;">Insurance</th>
													<th style="width: 15%;">Surcharge</th>
													<th style="width: 15%;">Discount</th>
													<th style="width: 15%;">Commision (%)</th>
													<th style="width: 15%;">Special Commision (Rp.)</th>
													<th style="width: 10%;">Other</th>
													<th style="width: 10%;">PIC Invoice</th>
													<th style="width: 20%;">Note</th>
													<!-- <th>Last Status</th> -->
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($shipment2 as $shp) {

												?>
													<tr>
														<td><a href="<?= base_url('sales/salesOrder/print/' . $shp['shipment_id']) ?>"> <?= $shp['shipment_id'] ?></a><br><?php if ($shp['service_name'] == 'Charter Service') {
																																												echo $shp['service_name'] . '-' . $shp['pu_moda'];
																																											} else {
																																												echo  $shp['service_name'];;
																																											} ?> </td>
														<td><?= $shp['shipper'] ?></td>
														<td><?= $shp['consigne'] ?>/ <br> <?= ucwords($shp['destination']) . '. ' . '<br>'  . '<b>' . ucwords(strtolower($shp['city_consigne'])) . '</b>' . ', ' . '<b>' . ucwords(strtolower($shp['state_consigne'])) . '</b>'  ?></td>

														<td>
															<input type="text" name="freight[]" value="<?= $shp['freight_kg'] ?>" required class="form-control" <?php if ($shp['status_so'] >= 1) {
																																								?> disabled <?php } ?>>
															<input type="text" name="id[]" hidden value="<?= $shp['id'] ?>" class="form-control" <?php if ($shp['status_so'] >= 1) {
																																					?> disabled <?php } ?>>
															<input type="text" name="id_so" hidden value="<?= $shp['id_so'] ?>" class="form-control" <?php if ($shp['status_so'] >= 1) {
																																						?> disabled <?php } ?>>
														</td>
														<td>
															<input type="text" name="special_freight[]" value="<?= $shp['special_freight'] ?>" class="form-control" <?php if ($shp['status_so'] >= 1) {
																																									?> disabled <?php } ?>>
														</td>
														<td>
															<input type="text" name="packing[]" value="<?= $shp['packing'] ?>" class="form-control" <?php if ($shp['status_so'] >= 1) {
																																					?> disabled <?php } ?>>
														</td>
														<td>
															<input type="text" name="insurance[]" value="<?= $shp['insurance'] ?>" class="form-control" <?php if ($shp['status_so'] >= 1) {
																																						?> disabled <?php } ?>>
														</td>
														<td>
															<input type="text" name="surcharge[]" value="<?= $shp['surcharge'] ?>" class="form-control" <?php if ($shp['status_so'] >= 1) {
																																						?> disabled <?php } ?>>
														</td>
														<td>
															<input type="text" name="disc[]" value="<?= $shp['disc'] ?>" class="form-control" style="width: 100px;" <?php if ($shp['status_so'] >= 1) {
																																									?> disabled <?php } ?>>
														</td>
														<td>
															<input type="number" name="cn[]" value="<?= $shp['cn'] ?>" class="form-control" style="width: 100px;" <?php if ($shp['status_so'] >= 1) {
																																									?> disabled <?php } ?>>
														</td>
														<td>
															<input type="number" name="specialcn[]" value="<?= $shp['specialcn'] ?>" class="form-control" style="width: 100px;" <?php if ($shp['status_so'] >= 1) {
																																												?> disabled <?php } ?>>
														</td>
														<td>
															<input type="text" name="others[]" value="<?= $shp['others'] ?>" class="form-control" style="width: 100px;" <?php if ($shp['status_so'] >= 1) {
																																										?> disabled <?php } ?>>
														</td>
														<td>
															<input type="text" name="pic_invoice[]" value="<?= $shp['pic_invoice'] ?>" class="form-control" required style="width: 100px;" <?php if ($shp['status_so'] >= 1) {
																																															?> disabled <?php } ?>>
														</td>
														<td>

															<textarea class="form-control" style="width: 200px;" <?php if ($shp['status_so'] >= 1) {
																													?> disabled <?php } ?> name="so_note[]" id="so_note" cols="30" rows="3"><?= $shp['so_note'] ?></textarea>
														</td>
														<td>
															<?php
															$id_atasan = $this->session->userdata('id_atasan');
															// kalo dia atasan sales
															$get_request_revisi = $this->db->get_where('tbl_request_revisi', ['shipment_id' => $shp['id']])->row_array();
															$cek_so_baru = $this->db->get_where('tbl_revisi_so', ['shipment_id' => $shp['id']])->row_array();
															// kalo dia atasan
															if ($id_atasan == 0 || $id_atasan == NULL) {
																// cek apakah sudah ada reqeust revisi
																if ($get_request_revisi) {
																	if ($cek_so_baru) {
															?>
																		<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
																		<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light viewRevisiSo" data-toggle="modal" data-target="#modalViewRevisiSo" data-id="<?= $shp['id'] ?>" style="background-color: #9c223b;">View New SO</a>
																	<?php	} else {
																	?>

																		<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light addNewSo" data-toggle="modal" data-target="#modalAddNewSo" data-id="<?= $shp['id'] ?>" style="background-color: #9c223b;">Add New SO</a>
																		<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>

																	<?php }
																	?>
																	<?php	} else {
																	// kalo dia udah ngajuin so
																	if ($shp['status_so'] >= 1) {
																	?>
																		<a href="<?= base_url('sales/salesOrder/requestRevisi/' . $shp['id'] . '/' . $shp['id_so']) ?>" onclick="return confirm('Are you sure ?')" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Request Revisi</a>
																		<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>

																	<?php	} else {
																	?>

																		<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
																	<?php }
																	?>

																<?php	}
																?>

																<?php  } else {
																if ($get_request_revisi) {
																	if ($get_request_revisi['status'] == 1) {

																		if ($cek_so_baru) {
																?>
																			<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
																			<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light viewRevisiSo" data-toggle="modal" data-target="#modalViewRevisiSo" data-id="<?= $shp['id'] ?>" style="background-color: #9c223b;">View New SO</a>
																		<?php	} else {
																		?>

																			<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
																			<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light addNewSo" data-toggle="modal" data-target="#modalAddNewSo" data-id="<?= $shp['id'] ?>" style="background-color: #9c223b;">Add New SO</a>
																		<?php }
																		?>

																	<?php	} else {
																	?>
																		<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
																		<small>Request Rejected</small>
																	<?php	}
																} else {
																	// kalo dia udah ngajuin so
																	if ($shp['status_so'] >= 1) {
																	?>
																		<a href="<?= base_url('sales/salesOrder/requestRevisi/' . $shp['id'] . '/' . $shp['id_so']) ?>" onclick="return confirm('Are you sure ?')" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Request Revisi</a>
																		<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>

																	<?php	} else {
																	?>

																		<a href="<?= base_url('sales/salesOrder/tracking/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
																	<?php }
																	?>
																<?php	} ?>

															<?php	} ?>
														</td>
													</tr>

												<?php } ?>
											</tbody>
										</table>

										<!-- Action buttons container with improved styling -->
										<div class="action-buttons-container mt-3 mb-3">
											<!-- Atasan approval section -->
											<?php if ($this->session->userdata('id_user') == $p['id_atasan_sales']) : ?>
												<?php if ($p['status_approve'] == 0) : ?>

													<?php if ($p['submitso_at'] != NULL) : ?>

														<button onclick="approveOrder('<?= $p['id_so'] ?>')" class="btn btn-lg btn-primary pulse-button" style="font-weight: bold; box-shadow: 0 4px 8px rgba(0,0,0,0.2); border-radius: 6px; padding: 12px 24px; transition: all 0.3s;">
															<i class="fas fa-check-circle mr-2"></i> Approve Sales Order
														</button>
													<?php else : ?>
														<div class="alert alert-warning" style="border-left: 5px solid #ffc107; font-weight: 500;">
															<?php $yangpunyaso = $this->db->query('SELECT nama_user FROM tb_user WHERE id_user = ? ', $p['id_sales'])->row_array(); ?>
															<i class="fas fa-exclamation-triangle mr-2"></i> Sales Order has not been submitted yet by <?= $yangpunyaso['nama_user'] ?>.
														</div>
													<?php endif; ?>
												<?php endif; ?>
											<?php endif; ?>

											<!-- Sales user actions section -->
											<?php if ($this->session->userdata('id_user') == $p['id_sales']) : ?>
												<?php if ($p['submitso_at'] == NULL) : ?>
													<?php if ($p['deadline_sales_so'] >= date('Y-m-d')) : ?>
														<!-- Active submission period -->
														<button type="submit" class="btn btn-lg btn-success pulse-button" style="font-weight: bold; box-shadow: 0 4px 8px rgba(0,0,0,0.2); border-radius: 6px; padding: 12px 24px; transition: all 0.3s;" onclick="return confirm('Are you sure you want to submit this Sales Order?')">
															<i class="fas fa-paper-plane mr-2"></i> Submit Sales Order
														</button>
													<?php else : ?>
														<!-- Past deadline section -->
														<?php if ($request_aktivasi) : ?>
															<?php if ($request_aktivasi['status'] == 0) : ?>
																<div class="alert alert-warning" style="border-left: 5px solid #ffc107; font-weight: 500;">
																	<i class="fas fa-hourglass-half"></i> Request activation is pending approval.
																</div>
															<?php else : ?>
																<i class="fas fa-exclamation-triangle mr-2"></i> <strong>Activation request has been submitted but not yet processed</strong>
																<button data-toggle="modal" data-target="#modal-request" class="btn btn-lg btn-danger" style="font-weight: bold; box-shadow: 0 4px 8px rgba(0,0,0,0.2); border-radius: 6px; padding: 12px 24px; transition: all 0.3s;">
																	<i class="fas fa-unlock-alt mr-2"></i> Request Activation
																</button>
															<?php endif; ?>
														<?php else : ?>
															<!-- Special case for late night pickups -->
															<?php if (strtotime($p['deadline_sales_so']) - strtotime(date('Y-m-d')) <= 86400) : ?>
																<?php if (
																	date('H:i:s', strtotime($p['pickup_at'])) >= date('H:i:s', strtotime('21:00:00')) &&
																	date('H:i:s', strtotime($p['pickup_at'])) <= date('H:i:s', strtotime('23:59:59'))
																) : ?>

																	<div class="alert alert-info" style="border-left: 5px solid #17a2b8; font-weight: 500;">
																		<i class="fas fa-clock mr-2"></i> <strong>Note:</strong> For pickups after 9 PM, SO submission is extended until 9 AM the next day.
																	</div>

																	<?php if (date('H:i:s') <= date('H:i:s', strtotime('09:00:00'))) : ?>
																		<button type="submit" class="btn btn-lg btn-success pulse-button" style="font-weight: bold; box-shadow: 0 4px 8px rgba(0,0,0,0.2); border-radius: 6px; padding: 12px 24px; transition: all 0.3s;" onclick="return confirm('Are you sure you want to submit this Sales Order?')">
																			<i class="fas fa-paper-plane mr-2"></i> Submit Sales Order
																		</button>
																	<?php else : ?>
																		<div class="alert alert-danger" style="border-left: 5px solid #dc3545; font-weight: 500;">
																			<i class="fas fa-exclamation-triangle mr-2"></i> <strong>SO Late Submission</strong> (After 9 AM)
																		</div>
																		<button type="button" data-toggle="modal" data-target="#modal-request" class="btn btn-lg btn-danger" style="font-weight: bold; box-shadow: 0 4px 8px rgba(0,0,0,0.2); border-radius: 6px; padding: 12px 24px; transition: all 0.3s;">
																			<i class="fas fa-unlock-alt mr-2"></i> Request Activation
																		</button>
																	<?php endif; ?>
																<?php else : ?>
																	<div class="alert alert-danger" style="border-left: 5px solid #dc3545; font-weight: 500;">
																		<i class="fas fa-exclamation-triangle mr-2"></i> <strong>SO Late Submission</strong> (Shipper pickup at <?= date('d-m-y H:i:s', strtotime($p['pickup_at'])) ?>)
																	</div>
																	<button type="button" data-toggle="modal" data-target="#modal-request" class="btn btn-lg btn-danger" style="font-weight: bold; box-shadow: 0 4px 8px rgba(0,0,0,0.2); border-radius: 6px; padding: 12px 24px; transition: all 0.3s;">
																		<i class="fas fa-unlock-alt mr-2"></i> Request Activation
																	</button>
																<?php endif; ?>
															<?php else : ?>
																<div class="alert alert-danger" style="border-left: 5px solid #dc3545; font-weight: 500;">
																	<i class="fas fa-exclamation-triangle mr-2"></i> <strong>SO Late Submission</strong> (After Deadline)
																</div>
																<button type="button" data-toggle="modal" data-target="#modal-request" class="btn btn-lg btn-danger" style="font-weight: bold; box-shadow: 0 4px 8px rgba(0,0,0,0.2); border-radius: 6px; padding: 12px 24px; transition: all 0.3s;">
																	<i class="fas fa-unlock-alt mr-2"></i> Request Activation
																</button>
															<?php endif; ?>
														<?php endif; ?>
													<?php endif; ?>
												<?php else : ?>
													<!-- If SO has already been submitted -->
													<div class="alert alert-info" style="border-left: 5px solid #17a2b8; font-weight: 500;">
														<i class="fas fa-info-circle mr-2"></i> Sales Order has already been submitted. Press the submit button only if the shipper has added additional shipments after your initial submission.
													</div>
													<button type="submit" class="btn btn-lg btn-success pulse-button" style="font-weight: bold; box-shadow: 0 4px 8px rgba(0,0,0,0.2); border-radius: 6px; padding: 12px 24px; transition: all 0.3s;" onclick="return confirm('Are you sure you want to submit this Sales Order?')">
														<i class="fas fa-paper-plane mr-2"></i> Submit Sales Order
													</button>
												<?php endif; ?>

											<?php endif; ?>
										</div>

										<!-- Add this script to handle the approval confirmation -->
										<script>
											// Add pulse animation to important buttons
											document.addEventListener('DOMContentLoaded', function() {
												// Add CSS for pulse animation
												var style = document.createElement('style');
												style.innerHTML = `
												.pulse-button {
													box-shadow: 0 0 0 0 rgba(156, 34, 59, 0.7);
													animation: pulse 2s infinite;
												}
												
												@keyframes pulse {
													0% {
														transform: scale(0.95);
														box-shadow: 0 0 0 0 rgba(156, 34, 59, 0.7);
													}
													
													70% {
														transform: scale(1);
														box-shadow: 0 0 0 10px rgba(156, 34, 59, 0);
													}
													
													100% {
														transform: scale(0.95);
														box-shadow: 0 0 0 0 rgba(156, 34, 59, 0);
													}
												}
											`;
												document.head.appendChild(style);
											});
										</script>
									</form>
								</div>
								<?php } ?>
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






	<div class="modal fade" id="modalAddNewSo">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 id="resi" class="modal-title"></h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('sales/salesOrder/addNewSo') ?>" method="POST" id="formAddNewSo">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Freight</label>
									<input type="text" class="form-control" id="exampleInputEmail1" required name="freight_baru">
									<input type="text" class="form-control" id="exampleInputEmail1" name="id" hidden required>
									<input type="text" class="form-control" id="exampleInputEmail1" name="id_so" hidden required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Special Freight</label>
									<input type="text" class="form-control" id="exampleInputEmail1" required name="special_freight_baru">
									<!-- <input type="text" class="form-control" id="exampleInputEmail1" hidden required value="<?= $msr['id_msr'] ?>" name="id_msr"> -->
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Packing</label>
									<input type="text" class="form-control" id="exampleInputEmail1" required name="packing_baru">
									<!-- <input type="text" class="form-control" id="exampleInputEmail1" hidden required value="<?= $msr['id_msr'] ?>" name="id_msr"> -->
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Others</label>
									<input type="text" class="form-control" id="exampleInputEmail1" required name="others_baru">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Surcharge</label>
									<input type="text" class="form-control" id="exampleInputEmail1" required name="surcharge_baru">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Insurance</label>
									<input type="text" class="form-control" id="exampleInputEmail1" required name="insurance_baru">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Disc</label>
									<input type="number" class="form-control" id="exampleInputEmail1" required name="disc_baru">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Cn</label>
									<input type="number" class="form-control" id="exampleInputEmail1" required name="cn_baru">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Special Cn</label>
									<input type="number" class="form-control" id="exampleInputEmail1" required name="special_cn_baru">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Reason</label>
									<textarea name="alasan" class="form-control" required></textarea>
								</div>

							</div>
						</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>




	<div class="modal fade" id="modalViewRevisiSo">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 id="resiViewRevisiSo" class="modal-title">View New Sales Order with</h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('sales/salesOrder/addNewSo') ?>" method="POST" id="formViewRevisiSo">

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Freight</label>
									<input type="text" class="form-control" id="exampleInputEmail1" required name="freight_baru">
									<input type="text" class="form-control" id="exampleInputEmail1" name="id" hidden required>
									<input type="text" class="form-control" id="exampleInputEmail1" name="id_so" hidden required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Special Freight</label>
									<input type="text" class="form-control" id="exampleInputEmail1" required name="special_freight_baru">
									<!-- <input type="text" class="form-control" id="exampleInputEmail1" hidden required value="<?= $msr['id_msr'] ?>" name="id_msr"> -->
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Packing</label>
									<input type="text" class="form-control" id="exampleInputEmail1" required name="packing_baru">
									<!-- <input type="text" class="form-control" id="exampleInputEmail1" hidden required value="<?= $msr['id_msr'] ?>" name="id_msr"> -->
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Others</label>
									<input type="text" class="form-control" id="exampleInputEmail1" required name="others_baru">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Surcharge</label>
									<input type="text" class="form-control" id="exampleInputEmail1" required name="surcharge_baru">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Insurance</label>
									<input type="text" class="form-control" id="exampleInputEmail1" required name="insurance_baru">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Disc (%)</label>
									<input type="number" class="form-control" id="exampleInputEmail1" required name="disc_baru">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Cn (%)</label>
									<input type="number" class="form-control" id="exampleInputEmail1" required name="cn_baru">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Special Cn</label>
									<input type="number" class="form-control" id="exampleInputEmail1" required name="special_cn_baru">
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">Reason</label>
									<textarea name="alasan" class="form-control" required></textarea>
								</div>

							</div>
						</div>

				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<!-- <button type="submit" class="btn btn-primary">Submit</button> -->
				</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>





	<div class="modal fade" id="modal-import">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Import Sales Order</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?= base_url('sales/salesOrder/import2') ?>" method="POST" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<label class="col-form-label text-lg-right font-weight-bold">Upload File</label>
							<input type="file" id="input-file-now" name="upload_file" class="dropify" required />
							<input type="text" name="id_so" hidden value="<?= $p['id_so'] ?>">
						</div>
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<div class="modal fade" id="modal-request">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Request Aktivation</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?= base_url('sales/salesOrder/requestAktivasi') ?>" method="POST" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<label class="col-form-label text-lg-right font-weight-bold">Reason <span class="text-danger">*</span> </label>
							<textarea type="text" name="reason" class="form-control" required></textarea>
							<input type="text" name="id_so" hidden value="<?= $p['id_so'] ?>">
						</div>
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

	<script>
		// .addNewSo
		$('.addNewSo').on('click', function() {
			const id = $(this).data('id');
			$.ajax({
				url: '<?= base_url('sales/salesOrder/getDataShipment') ?>',
				type: 'POST',
				data: {
					id: id
				},
				success: function(data) {
					data = JSON.parse(data);
					$('#resi').html('Add New Sales Order with ' + data.shipment_id);

					// fill form formAddNewSo
					$('#formAddNewSo').find('input[name="freight_baru"]').val(data.freight_kg);
					$('#formAddNewSo').find('input[name="special_freight_baru"]').val(data.special_freight);
					$('#formAddNewSo').find('input[name="packing_baru"]').val(data.packing);
					$('#formAddNewSo').find('input[name="insurance_baru"]').val(data.insurance);
					$('#formAddNewSo').find('input[name="surcharge_baru"]').val(data.surcharge);
					$('#formAddNewSo').find('input[name="disc_baru"]').val(data.disc);
					$('#formAddNewSo').find('input[name="cn_baru"]').val(data.cn * 100);
					$('#formAddNewSo').find('input[name="special_cn_baru"]').val(data.specialcn);
					$('#formAddNewSo').find('input[name="others_baru"]').val(data.others);
					$('#formAddNewSo').find('input[name="id"]').val(data.id);
					$('#formAddNewSo').find('input[name="id_so"]').val(data.id_so);


				}
			})
		})

		// viewRevisiSo 
		$('.viewRevisiSo').on('click', function() {
			const id = $(this).data('id');
			$.ajax({
				url: '<?= base_url('sales/salesOrder/getDataRevisiSo') ?>',
				type: 'POST',
				data: {
					id: id
				},
				success: function(data) {
					data = JSON.parse(data);
					$('#resiViewRevisiSo').html('View New Sales Order with ' + data.resi);

					// fill form formAddNewSo
					$('#formViewRevisiSo').find('input[name="freight_baru"]').val(data.freight_baru);
					$('#formViewRevisiSo').find('input[name="special_freight_baru"]').val(data.special_freight_baru);
					$('#formViewRevisiSo').find('input[name="packing_baru"]').val(data.packing_baru);
					$('#formViewRevisiSo').find('input[name="insurance_baru"]').val(data.insurance_baru);
					$('#formViewRevisiSo').find('input[name="surcharge_baru"]').val(data.surcharge_baru);
					$('#formViewRevisiSo').find('input[name="disc_baru"]').val(data.disc_baru);
					$('#formViewRevisiSo').find('input[name="cn_baru"]').val(data.cn_baru);
					$('#formViewRevisiSo').find('input[name="special_cn_baru"]').val(data.special_cn_baru);
					$('#formViewRevisiSo').find('input[name="others_baru"]').val(data.others_baru);
					$('#formViewRevisiSo').find('input[name="id"]').val(data.id);
					$('#formViewRevisiSo').find('input[name="id_so"]').val(data.id_so);

					// disabled all
					$('#formViewRevisiSo').find('input').attr('disabled', true);
					$('#formViewRevisiSo').find('textarea').attr('disabled', true);

				}
			})
		})
	</script>

	<script>
		// Function to display and update the current time
		function updateClock() {
			var now = new Date();
			var hours = now.getHours().toString().padStart(2, '0');
			var minutes = now.getMinutes().toString().padStart(2, '0');
			var seconds = now.getSeconds().toString().padStart(2, '0');
			var day = now.getDate().toString().padStart(2, '0');
			var month = (now.getMonth() + 1).toString().padStart(2, '0');
			var year = now.getFullYear();

			// Format: DD/MM/YYYY HH:MM:SS
			var timeString = day + '/' + month + '/' + year + ' ' + hours + ':' + minutes + ':' + seconds;

			// Update the element with the current time
			var timeNowElement = document.getElementById('time-now');
			if (timeNowElement) {
				timeNowElement.innerHTML = '<span class="text-muted font-weight-bold">Current Time: <b>' + timeString + '</b></span>';
			}

			// Call this function again in 1 second
			setTimeout(updateClock, 1000);
		}

		// Start the clock when the document is ready
		document.addEventListener('DOMContentLoaded', function() {
			updateClock();
		});
	</script>

	
	 

	<script>
		var map = L.map('map').setView([-6.2088, 106.8456], 10);
		var layer = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
			attribution: 'Transtama Logistics | © Google Maps',
			maxZoom: 19,
			subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
		}).addTo(map);
		// show marker like a car on monas 
		// Create marker with default position
		var marker = L.marker([-6.2088, 106.8456]).addTo(map);


		// Change marker icon with car icon
		var carIcon = L.icon({
			iconUrl: 'https://www.svgheart.com/wp-content/uploads/2020/05/car-free-svg-cut-file-1.png',
			iconSize: [32, 32],
			iconAnchor: [16, 16],
			popupAnchor: [0, -16]
		});

		// Apply the icon to the marker
		marker.setIcon(carIcon);

		// Function to update marker position
		function updateMarkerPosition() {
			$.ajax({
				url: '<?php echo base_url("sales/SalesOrder/getLocationVehicle"); ?>',
				type: 'POST',
				data: {
					device_id: <?= $p['device_id'] ?> // Get the selected vehicle ID
				},
				dataType: 'json',
				success: function(response) {

					if (response.Latitude && response.Longitude) {
						// Update marker position
						marker.setLatLng([response.Latitude, response.Longitude]);
						// Update popup content if needed
						if (response.Acc == true) {
							response.Acc = 'On';
						} else {
							response.Acc = 'Off';
						}
						marker.bindPopup('<table class="popup-table" style="width:100%; border-collapse:collapse;">' +
										'<tr><td style="padding:3px;"><strong>Status:</strong></td><td>' + response.Acc + '</td></tr>' +
										'<tr><td style="padding:3px;"><strong>Nopol:</strong></td><td>' + response.Nopol + '</td></tr>' +
										'<tr><td style="padding:3px;"><strong>Address:</strong></td><td>' + response.Address + '</td></tr>' +
										'<tr><td style="padding:3px;"><strong>Last refresh:</strong></td><td>' + new Date().toLocaleTimeString() + '</td></tr>' +
										'<tr><td colspan="2" style="padding:3px; text-align:center;"><a href="https://www.google.com/maps?q=' + response.Latitude + ',' + response.Longitude + '" target="_blank" class="btn btn-sm text-light" style="background-color: #9c223b; margin-top:5px;">Open in Google Maps</a></td></tr>' +
										'</table>').openPopup();
									}
				},
				error: function() {
					console.log('Error fetching location data');
				}
			});
		}

		// Initial update
		updateMarkerPosition();

		// Set interval to update every 3 seconds
		setInterval(updateMarkerPosition, 6000);
	</script>