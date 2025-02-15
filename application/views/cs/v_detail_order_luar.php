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
									<table class="table border">
										<tr>
											<td>Pickup Date</td>
											<td><b>:<?= longdate_indo($p['tgl_pickup']) ?>, <?= $p['time'] ?></b></td>
											<td>Shipper</td>
											<td><b>:<?= $p['shipper'] ?></b> </td>
										</tr>
										<tr>
											<td>Pickup Moda</td>
											<td><b>:<?= $p['pu_moda'] ?></b> </td>
											<td>Pickup Point</td>
											<td><b>:<?= $p['pu_poin'] ?></b> </td>
										</tr>
										<tr>
											<td>Destination</td>
											<td><b>:<?= $p['destination'] ?></b> </td>
											<td>Koli</td>
											<td><b>:<?= $p['koli'] ?></b> </td>
										</tr>
										<tr>
											<td>Kg</td>
											<td><b>:<?= $p['kg'] ?></b> </td>
											<td>Commodity</td>
											<td><b>:<?= $p['commodity'] ?></b> </td>
										</tr>
										<tr>
											<td>Service</td>
											<td><b>:<?= $p['service'] ?></b> </td>
											<td>Status</td>
											<td><b>:<?= ($p['status'] == 0) ? 'Process' : 'Selesai';   ?></b> </td>
										</tr>
										<tr>
											<td>Note</td>
											<td colspan="2"><b>:<?= $p['note'] ?></b> </td>
											<td></td>
										</tr>
									</table>
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
										<th>Last Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($shipment2 as $shp) {
										$get_last_status = $this->db->limit(1)->order_by('id_tracking', 'desc')->get_where('tbl_tracking_real', ['shipment_id' => $shp['shipment_id']])->row_array();
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
											<td style="color: green;"><?= $get_last_status['status'] ?> <br> <?= longdate_indo($get_last_status['created_at']), ' ' . $get_last_status['time'] ?>
												<br>
												<?php if ($get_last_status['flag'] == 12 || $get_last_status['flag'] == 6) {
												?>
													<!-- <a href="#" class="btn font-weight-bolder text-light modalPod" data-toggle="modal" data-target="#modal-pod" style="background-color: #9c223b;" data-shipment_id="<?= $shp['shipment_id'] ?>">
														<span class="svg-icon svg-icon-md">
														</span>View POD</a> -->
												<?php	} ?>

											</td>
											<td>
												<!-- kalo dia bukan incoming -->
												<?php if ($p['is_incoming'] == 0) {
													// apakah dia jabodetabek
													if ($shp['is_jabodetabek'] == 1) {
												?>
														<?php if ($get_last_status['flag'] >= 8  && $get_last_status['flag'] <= 11) {
														?>
															<!-- <a href="#" class="btn btn-sm text-light mb-1" data-toggle="modal" data-target="#modal-lg-dl-luar<?= $shp['shipment_id'] ?>" style="background-color: #9c223b;">
																<span class="svg-icon svg-icon-md">
																</span>Update Status</a> -->
															<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a>
															<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
														<?php } else {
														?>
															<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a>
															<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
														<?php	} ?>
														<!-- kalo bukan jabodetabek -->
													<?php	} else {
													?>
														<?php if ($get_last_status['flag'] >= 8 && $get_last_status['flag'] <= 11) {
														?>
															<a href="#" class="btn btn-sm text-light mb-1 modalDlLuar" data-toggle="modal" data-target="#modal-lg-dl-luar" style="background-color: #9c223b;" data-shipment_id="<?= $shp['shipment_id'] ?>" data-id_so="<?= $shp['id_so'] ?>">
																<span class="svg-icon svg-icon-md">
																</span>Update Status</a>
															<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a>
															<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
														<?php } else {
														?>
															<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a>
															<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
														<?php	} ?>

													<?php	}
													?>
													<?php	} else {

													if ($get_last_status['flag'] >= 6  && $get_last_status['flag'] <= 8) {
													?>
														<span class="badge badge-secondary mb-1">Menunggu scan in/out HUB</span>
														<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a>
														<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
													<?php	} elseif ($get_last_status['flag'] == 12) {
													?>
														<!-- <a href="#" class="btn btn-sm text-light mb-1" data-toggle="modal" data-target="#modal-lg-dl-incoming<?= $shp['shipment_id'] ?>" style="background-color: #9c223b;">
															<span class="svg-icon svg-icon-md">
															</span>Update Status</a>
														<a href="<?= base_url('cs/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a> -->
														<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a>
														<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>

													<?php	} else {
													?>
														<a href="#" class="btn btn-sm text-light mb-1 modalDlIncoming" data-toggle="modal" data-target="#modal-lg-dl-incoming" style="background-color: #9c223b;" data-shipment_id="<?= $shp['shipment_id'] ?>" data-id_so="<?= $shp['id_so'] ?>" data-service="<?= $shp['service_name'] ?>">
															<span class="svg-icon svg-icon-md">
															</span>Update Status</a>
														<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/edit/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a>
														<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>

													<?php	}
													?>

												<?php	} ?>
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
									<input type="text" name="shipment_id" class="form-control" hidden >
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
									<input type="text" name="id_so" class="form-control" hidden >
									<input type="text" name="shipment_id" class="form-control" hidden >
									<input type="text" name="service" class="form-control" hidden >
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
					url: '<?= base_url('cs/salesOrder/processAddImport/'.$p['id_so']) ?>',
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