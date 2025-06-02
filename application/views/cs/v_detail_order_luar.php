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
							</div>
							<div class="card-toolbar">
								<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/salesOrder') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-chevron-circle-left text-light"> </i>
									Back
								</a>
							</div>
						</div>

						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<div class="row">
								<div class="col-md-8">
									<div class="card card-custom shadow-sm">
										<div class="card-header bg-light">
											<h5 class="card-title font-weight-bold text-dark mb-0">
												<i class="fas fa-info-circle text-primary mr-2"></i> Order Information
											</h5>
										</div>
										<div class="card-body p-0">
											<div class="table-responsive">
												<table class="table table-hover mb-0">
													<tbody>
														<tr>
															<td class="text-muted" width="20%">
																<i class="far fa-calendar-alt text-success mr-1"></i> Pickup Date
															</td>
															<td width="30%"><strong><?= longdate_indo($p['tgl_pickup']) ?>, <?= $p['time'] ?></strong></td>
															<td class="text-muted" width="20%">
																<i class="fas fa-building text-primary mr-1"></i> Shipper
															</td>
															<td width="30%"><strong><?= $p['shipper'] ?></strong></td>
														</tr>
														<tr>
															<td class="text-muted">
																<i class="fas fa-truck-loading text-warning mr-1"></i> Pickup Moda
															</td>
															<td><strong><?= $p['pu_moda'] ?></strong></td>
															<td class="text-muted">
																<i class="fas fa-map-marker-alt text-danger mr-1"></i> Pickup Point
															</td>
															<td><strong><?= $p['pu_poin'] ?></strong></td>
														</tr>
														<tr>
															<td class="text-muted">
																<i class="fas fa-location-arrow text-info mr-1"></i> Destination
															</td>
															<td><strong><?= $p['destination'] ?></strong></td>
															<td class="text-muted">
																<i class="fas fa-boxes text-secondary mr-1"></i> Koli
															</td>
															<td><strong><?= $p['koli'] ?></strong></td>
														</tr>
														<tr>
															<td class="text-muted">
																<i class="fas fa-weight-hanging text-dark mr-1"></i> Weight
															</td>
															<td><strong><?= $p['kg'] ?> kg</strong></td>
															<td class="text-muted">
																<i class="fas fa-box text-primary mr-1"></i> Commodity
															</td>
															<td><strong><?= $p['commodity'] ?></strong></td>
														</tr>
														<tr>
															<td class="text-muted">
																<i class="fas fa-shipping-fast text-success mr-1"></i> Service
															</td>
															<td><strong><?= $p['service'] ?></strong></td>
															<td class="text-muted">
																<i class="fas fa-tasks text-info mr-1"></i> Status
															</td>
															<td>
																<span class="badge badge-pill <?= ($p['status'] == 0) ? 'badge-warning' : 'badge-success' ?>">
																	<i class="fas fa-<?= ($p['status'] == 0) ? 'hourglass-half' : 'check-circle' ?> mr-1"></i>
																	<strong><?= ($p['status'] == 0) ? 'Process' : 'Selesai' ?></strong>
																</span>
															</td>
														</tr>
														<tr>
															<td class="text-muted">
																<i class="fas fa-sticky-note text-warning mr-1"></i> Note
															</td>
															<td><strong><?= $p['note'] ?></strong></td>
															<td class="text-muted">
																<i class="fas fa-user-tie text-dark mr-1"></i> Driver
															</td>
															<td><strong><?= $p['driver'] ?></strong></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<!-- kalo dia bukan icoming -->
								<?php if ($p['is_incoming'] == 0) {
									if ($p['status'] == 5) {
										echo	"<div class='col-md-4'>
											<h4 class='title'>Cancel Request</h4> <br> <p>Reason : $p[alasan_cancel]</p>
										</div>";
									}
								?>
									<div class="col-md-4">
										<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/salesOrder/add/' . $p['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
											<i class="fas fa-plus-circle text-light"> </i>
											Single Order
										</a>
										<!-- <a href="<?= base_url('cs/salesOrder/bulk/' . $p['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
												<i class="fas fa-plus-circle text-light"> </i>
												Bulk Order
											</a> -->
									</div>
									<?php	?>
									<?php	} else {
									if ($p['status'] == 5) {
										echo "<h3>Cancel Request</h3> <br> <p>Reason : $p[alasan_cancel]</p>";
									} else {
									?>
										<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
										<div class="col-md-4">
											<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/salesOrder/add/' . $p['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
												<i class="fas fa-plus-circle text-light"> </i>
												Single Order
											</a>
											<!-- button to open modal bulk order  -->
											<button class="btn mr-2 text-light" style="background-color: #9c223b;" data-toggle="modal" data-target="#modalBulkOrder">
												<i class="fas fa-plus-circle text-light"> </i>
												Bulk Order
											</button>




											<!-- <a href="<?= base_url('cs/salesOrder/bulk/' . $p['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
												<i class="fas fa-plus-circle text-light"> </i>
												Bulk Order
											</a> -->
										</div>
								<?php	}
								} ?>
							</div>
							<br>
							<br>
							<br>
							<?php if ($p['device_id'] != NULL && $p['device_id'] != '-') { ?>
								<!-- Map Container -->
								<style>
									#map {
										height: 400px;
									}
								</style>
								<div id="map">

								</div>
							<?php } ?>

							<table id="myTable" class="table table-bordered">
								<div class="row">
									<div class="col-md-10">
										<h3 class="title font-weight-bold">List Shipment</h3>

									</div>
									<?php if ($p['status'] == 5) {
										// echo '<h3>Cancel Request</h3>';
									} else {
									?>
										<div class="col-md-2 mt-4">
											<a href="<?= base_url('cs/order/printAll/' . $p['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
												<i class="fas fa-print text-light"> </i>
												Print All
											</a>
										</div>
									<?php	} ?>
								</div>
								<p><?= $this->session->flashdata('message'); ?></p>
								<thead>
									<tr>
										<th style="width: 10%;">Shipment ID</th>
										<th style="width: 15%;">Shipper</th>
										<th>Destination</th>
										<th style="width: 15%;">Consignee</th>
										<!-- <th style="width: 20%;">Image</th> -->
										<!-- <th>Signature</th> -->

										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($shipment2 as $shp) {

										// var_dump($get_last_status);
										// die;
									?>
										<tr>
											<td><a href="<?= base_url('cs/salesOrder/print/' . $shp['shipment_id']) ?>"> <?= $shp['shipment_id'] ?></a>
												<br> <?= $shp['service_name'] ?>
											</td>
											<td><?= $shp['shipper'] . ' (' . $shp['mark_shipper'] . ') ' ?> <br> No. DO: <?= $shp['note_cs'] ?></td>
											<td><?= $shp['destination'] ?>, <?= $shp['city_consigne'] ?> <?= $shp['state_consigne'] ?></td>
											<td><?= $shp['consigne'] ?></td>



											<td><a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a>
												<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
											</td>



										</tr>

									<?php } ?>
								</tbody>


							</table>
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


	<div class="modal fade" id="modal-lg-dl-luar">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Update Status Shipment <b><?= $shp['shipment_id'] ?></b> </h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('cs/salesOrder/updateShipment') ?>" method="POST" enctype="multipart/form-data">
						<div class="card-body">
							<div class="row">
								<input type="text" name="id_so" class="form-control" hidden>
								<input type="text" name="shipment_id" class="form-control" hidden>
								<div class="col-md-6">
									<label for="status">Choose Status : </label>
									<select name="status" class="form-control">
										<option value="Shipment Telah Tiba Di Hub">Shipment Telah Tiba Di Hub Tujuan</option>
										<option value="Shipment Keluar Di Hub Tujuan">Shipment Keluar Di Hub Tujuan</option>
										<option value="Shipment Dalam Proses Delivery">Shipment Dalam Proses Delivery</option>
										<option value="Shipment Telah Diterima Oleh">Shipment Telah Diterima</option>
									</select>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Note :<span style="color: red;">Soekarno Hatta or, Cengkareng, or consigne nama</span> </label>
										<input type="text" class="form-control" name="note">
									</div>

								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="exampleInputEmail1">Date<span style="color: red;">*</span></label>
										<input type="date" class="form-control" id="tgl_pickup" required name="date">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="exampleInputEmail1">Time<span style="color: red;">*</span></label>
										<input type="time" class="form-control" required name="time">
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label for="exampleInputEmail1">POD</label>
										<!-- <input type="file" class="form-control" name="ktp"> -->
										<input type="file" class="form-control" name="ktp[]" accept="image/*" capture multiple>
									</div>

								</div>



							</div>
						</div>
						<!-- /.card-body -->
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




	<div class="modal fade" id="modal-pod">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">POD</h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="pod">

					</div>


					<form action="<?= base_url('cs/salesOrder/updateShipment') ?>" method="POST" enctype="multipart/form-data">
						<div class="card-body">
							<div class="row">
								<?php
								$get_last_status = $this->db->limit(1)->order_by('id_tracking', 'desc')->get_where('tbl_tracking_real', ['shipment_id' => $shp['shipment_id']])->row_array();
								?>
								<?php $files = explode('+', $get_last_status['bukti']);
								$no = 1;
								foreach ($files as $file) {
								?>
									<div class="col-md-6">
										<b>Image <?= $no ?> :</b> <img src="<?= base_url('uploads/berkas/') . $file ?>" height="100" width="200"> <br>
										<?php $no++; ?>
									</div>
								<?php	} ?>

							</div>
						</div>
						<!-- /.card-body -->
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



	<div class="modal fade" id="modal-lg-dl-incoming">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Update Status Shipment <b><?= $shp['shipment_id'] ?></b> </h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('cs/salesOrder/updateShipmentIncoming') ?>" method="POST" enctype="multipart/form-data">
						<div class="card-body">
							<div class="row">
								<input type="text" name="id_so" class="form-control" hidden>
								<input type="text" name="shipment_id" class="form-control" hidden>
								<input type="text" name="service" class="form-control" hidden>
								<div class="col-md-6">
									<label for="status">Choose Status : </label>
									<select name="status" class="form-control">
										<option value="Shipment Telah Tiba Di Hub">Shipment Telah Tiba Di Hub</option>
										<option value="Shipment Keluar Di Hub">Shipment Keluar Di Hub</option>
										<!-- <option value="Shipment Telah Diterima Oleh">Shipment Telah Diterima</option> -->
									</select>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Note :<span style="color: red;">Soekarno Hatta or, Cengkareng, or consigne nama</span> </label>
										<input type="text" class="form-control" name="note">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="exampleInputEmail1">Date<span style="color: red;">*</span></label>
										<input type="date" class="form-control" id="tgl_pickup" required name="date">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="exampleInputEmail1">Time<span style="color: red;">*</span></label>
										<input type="time" class="form-control" required name="time">
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label for="exampleInputEmail1">POD</label>
										<!-- <input type="file" class="form-control" name="ktp"> -->
										<input type="file" class="form-control" name="ktp[]" accept="image/*" capture multiple>
									</div>

								</div>



							</div>
						</div>
						<!-- /.card-body -->
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



	<!-- modalBulkOrder -->
	<div class="modal fade" id="modalBulkOrder" tabindex="-1" role="dialog" aria-labelledby="modalBulkOrderLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalBulkOrderLabel">Bulk Order <a href="<?= base_url('cs/salesOrder/downloadTemplateBulkInput') ?>" class="btn btn-primary">Download Template</a></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="bulkInput">
					<div class="modal-body">
						<div class="form-group">
							<label for="exampleInputPassword1">Upload File Excel</label>
							<input type="file" class="form-control" name="file" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {


			$('#bulkInput').submit(function(e) {
				e.preventDefault();
				$.ajax({
					url: '<?= base_url('cs/salesOrder/processAddImport/' . $p['id_so']) ?>',
					type: 'POST',
					data: new FormData(this),
					processData: false,
					contentType: false,
					cache: false,
					success: function(data) {
						var obj = JSON.parse(data);
						if (obj.status == 'success') {
							// toast 
							Swal.fire({
								icon: 'success',
								title: 'Success',
								text: 'Data berhasil di import'
							}).then((result) => {
								location.reload();
							});
						} else {

							Swal.fire({
								icon: 'error',
								title: 'Failed',
								text: 'Data gagal di import karena ' + obj.message
							}).then((result) => {
								location.reload();
							});
						}

					}
				});
			});
		});
	</script>

	<script>
		$(document).ready(function() {
			$('.modalDlLuar').click(function() {
				var shipment_id = $(this).data('shipment_id');
				$('[name="shipment_id"]').val(shipment_id);
				// id_so 
				var id_so = $(this).data('id_so');
				$('[name="id_so"]').val(id_so);
			});

			$('.modalDlIncoming').click(function() {
				var shipment_id = $(this).data('shipment_id');
				$('[name="shipment_id"]').val(shipment_id);
				// id_so
				var id_so = $(this).data('id_so');
				$('[name="id_so"]').val(id_so);
				// service
				var service = $(this).data('service');
				$('[name="service"]').val(service);
			});
		});
	</script>

	<script>
		var map = L.map('map').setView([-6.2088, 106.8456], 10);
        // show layer in jakarta 
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
				url: '<?php echo base_url("cs/SalesOrder/getLocationVehicle"); ?>',
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
						// Create a styled popup with better layout and visual elements
						var popupContent = 
							'<div style="min-width: 220px; padding: 0; font-family: Arial, sans-serif;">' +
								'<div style="background-color: #9c223b; color: white; padding: 8px 12px; border-radius: 5px 5px 0 0;">' +
									'<h4 style="margin: 0; font-size: 16px;"><i class="fas fa-truck"></i> Vehicle Tracking</h4>' +
								'</div>' +
								'<div style="padding: 12px; background-color: #f8f9fa; border-radius: 0 0 5px 5px; border: 1px solid #e9ecef; border-top: none;">' +
									'<table style="width:100%; border-collapse:collapse;">' +
										'<tr>' +
											'<td style="padding:5px 0;"><i class="fas fa-power-off" style="color:' + (response.Acc == 'On' ? 'green' : 'red') + '"></i> <strong>Status:</strong></td>' +
											'<td style="padding:5px 0;"><span style="color:' + (response.Acc == 'On' ? 'green' : 'red') + '; font-weight:bold;">' + response.Acc + '</span></td>' +
										'</tr>' +
										'<tr>' +
											'<td style="padding:5px 0;"><i class="fas fa-car" style="color:#666"></i> <strong>Nopol:</strong></td>' +
											'<td style="padding:5px 0;">' + response.Nopol + '</td>' +
										'</tr>' +
										'<tr>' +
											'<td style="padding:5px 0;" colspan="2"><i class="fas fa-map-marker-alt" style="color:#9c223b"></i> <strong>Address:</strong>' +
												'<div style="margin-top:4px; font-size:13px;">' + response.Address + '</div>' +
											'</td>' +
										'</tr>' +
										'<tr>' +
											'<td colspan="2" style="padding:12px 0 5px; text-align:center;">' +
												'<a href="https://www.google.com/maps?q=' + response.Latitude + ',' + response.Longitude + '" target="_blank" ' +
												'style="display:block; background-color:#4285f4; color:white; padding:8px; text-decoration:none; ' +
												'border-radius:4px; font-weight:bold; box-shadow:0 2px 4px rgba(0,0,0,0.2); transition:all 0.3s ease;">' +
												'<i class="fas fa-map"></i> Open in Google Maps</a>' +
											'</td>' +
										'</tr>' +
									'</table>' +
								'</div>' +
							'</div>';

						marker.bindPopup(popupContent).openPopup();
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