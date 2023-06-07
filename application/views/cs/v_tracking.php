<link rel="stylesheet" href="<?php echo base_url() ?>assets/scans/css/style.css">
<!-- Main content -->
<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="container">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-12">
				<div class="card card-custom card-stretch">
					<div class="card-header py-3">
						<div class="card-title align-items-start flex-column">
							<h3 class="card-label font-weight-bolder text-dark">Update Tracking</h3>
							<span class="text-muted font-weight-bold font-size-sm mt-1">Input Shipment Number</span>
						</div>
						<div class="card-toolbar">

						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body" style="overflow: auto;">
						<div class="row">
							<div class="col-md-4">
								<form action="<?= base_url('cs/salesOrder/tracking') ?>" method="POST">

									<label for="shipment_id">Shipment ID</label>
									<input type="text" class="form-control" name="shipment_id">
									<button type="submit" class="btn btn-success mt-2">View</button>
									<div class="navbar-form navbar-center">
										<select class="form-control" id="selectCamCs" style="width: 80%;"></select>
									</div>
									<canvas class="mt-2" id="cobascanCS" width="400" height="400"></canvas>
								</form>
							</div>
							<div class="col-md-8">
								<h4 class="title">Milestone AWB <?= $shipment_id ?></h4>
								<div class="row">
									<div class="col-md-6">Shipper : <b><?= $shipment['shipper'] ?> - <?= $shipment['tree_shipper'] ?></b> </div>
									<div class="col-md-6">Consignee : <b><?= $shipment['consigne'] ?> - <?= $shipment['tree_consignee'] ?></b> </div>
								</div>
								<div class="row">
									<?php $user = $this->db->get_where('tb_user', array('id_user' => $shipment['id_user']))->row_array() ?>
									<div class="col">Driver : <b><?= $user['nama_user'] ?></b> </div>
								</div>
								<br>
								<?php if ($shipment_id != NULL) {
								?>
									<a href="#" class="btn btn-sm text-light mb-1" data-toggle="modal" data-target="#modal-lg-dl-add<?= $shipment_id ?>" style="background-color: #9c223b;">
										<span class="fa fa-plus">
										</span> Add Status</a>

								<?php   } ?>
								<table class="table table-bordered">
									<tr>
										<td>Status</td>
										<td>Date</td>
										<td>Time</td>
										<td>Action</td>
									</tr>
									<tbody>
										<?php foreach ($tracking as $t) {
										?>
											<tr>
												<td><?= $t['status'] ?></td>
												<td><?= $t['created_at'] ?></td>
												<td><?= $t['time'] ?></td>
												<td>
													<a href="#" class="btn btn-sm text-light mb-1" data-toggle="modal" data-target="#modal-lg-dl-luar<?= $t['id_tracking'] ?>" style="background-color: #9c223b;">
														<span class="fa fa-edit">
														</span> Update</a>
													<a href="<?= base_url('cs/salesOrder/deleteShipmentTracking/' . $t['id_tracking'] . '/' . $t['shipment_id']) ?>" onclick="return confirm('Are you sure ?')" class="btn btn-sm text-light mb-1" style="background-color: #9c223b;">
														<span class="fa fa-trash">
														</span> Delete</a>
												</td>
											</tr>

										<?php } ?>

									</tbody>
								</table>

							</div>
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
<?php foreach ($tracking as $t) {
?>
	<div class="modal fade" id="modal-lg-dl-luar<?= $t['id_tracking'] ?>">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Update Status Shipment <b><?= $t['shipment_id'] ?></b> </h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('cs/salesOrder/updateShipmentTracking') ?>" method="POST" enctype="multipart/form-data">
						<div class="card-body">
							<div class="row">
								<input type="text" name="id_so" class="form-control" hidden value="<?= $t['id_so'] ?>">
								<input type="text" name="id_tracking" class="form-control" hidden value="<?= $t['id_tracking'] ?>">
								<input type="text" name="shipment_id" class="form-control" hidden value="<?= $t['shipment_id'] ?>">
								<div class="col-md-6">
									<label for="status">Status</label>
									<input type="text" name="status" class="form-control" value="<?= $t['status'] ?>">

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Note :<span style="color: red;">Soekarno Hatta or, Cengkareng, or consigne nama</span> </label>
										<input type="text" class="form-control" name="note" value="<?= $t['note'] ?>">
									</div>

								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="exampleInputEmail1">Date<span style="color: red;">*</span></label>
										<input type="date" class="form-control" value="<?= $t['created_at'] ?>" id="tgl_pickup" required name="date">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="exampleInputEmail1">Time<span style="color: red;">*</span></label>
										<?php $phpdate = strtotime($t['time']);
										$mysqldate = date('H:i', $phpdate);
										?>
										<input type="time" class="form-control" required name="time" value="<?= $mysqldate ?>">
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label for="exampleInputEmail1">POD/POP</label>
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

<?php } ?>

<div class="modal fade" id="modal-lg-dl-update<?= $shipment_id ?>">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Update Status Shipment <b><?= $shipment_id ?></b> </h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('cs/salesOrder/updateShipmentTrackingAdd') ?>" method="POST" enctype="multipart/form-data">
					<div class="card-body">
						<div class="row">
							<input type="text" name="id_so" class="form-control" hidden value="<?= $t['id_so'] ?>">
							<input type="text" name="id_user" class="form-control" hidden value="<?= $t['id_user'] ?>">
							<input type="text" name="shipment_id" class="form-control" hidden value="<?= $t['shipment_id'] ?>">
							<div class="col-md-6">
								<label for="status">Choose Status : </label>
								<select name="status" class="form-control">
									<option value="Request Pickup From Shipper">Request Pickup From Shipper</option>
									<option value="Driver Menuju Lokasi Pickup">Driver Menuju Lokasi Pickup</option>
									<option value="Driver Telah Sampai DI Lokasi Pickup">Driver Menuju Lokasi Pickup</option>
									<option value="Shipment Telah Dipickup Dari Shipper">Shipment Telah Dipickup Dari Shipper</option>
									<option value="Shipment Telah Tiba Di Hub Jakarta Pusat">Shipment Telah Tiba Di Hub Jakarta Pusat</option>
									<option value="Shipment Keluar Dari Hub Jakarta Pusat">Shipment Keluar Dari Hub Jakarta Pusat</option>
									<option value="Shipment Telah Tiba Di Hub CGK">Shipment Telah Tiba Di Hub CGK</option>
									<option value="Shipment Keluar Dari Hub CGK">Shipment Keluar Dari Hub CGK</option>
									<option value="Shipment Telah Tiba Di Hub Jakarta Utara">Shipment Telah Tiba Di Hub Jakarta Utara</option>
									<option value="Shipment Keluar Dari Hub Jakarta Utara">Shipment Keluar Dari Hub Jakarta Utara</option>
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
									<label for="exampleInputEmail1">POD/POP</label>
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

<div class="modal fade" id="modal-lg-dl-add<?= $shipment_id ?>">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Update Status Shipment <b><?= $shipment_id ?></b> </h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('cs/salesOrder/updateShipmentTrackingAdd') ?>" method="POST" enctype="multipart/form-data">
					<div class="card-body">
						<div class="row">
							<input type="text" name="id_so" class="form-control" hidden value="<?= $t['id_so'] ?>">
							<input type="text" name="id_user" class="form-control" hidden value="<?= $t['id_user'] ?>">
							<input type="text" name="shipment_id" class="form-control" hidden value="<?= $t['shipment_id'] ?>">
							<div class="col-md-6">
								<label for="status">Choose Status : </label>
								<select name="status" class="form-control">
									<option value="Request Pickup From Shipper">Request Pickup From Shipper</option>
									<option value="Driver Menuju Lokasi Pickup">Driver Menuju Lokasi Pickup</option>
									<option value="Driver Telah Sampai Di Lokasi Pickup">Driver Menuju Lokasi Pickup</option>
									<option value="Shipment Telah Dipickup Dari Shipper">Shipment Telah Dipickup Dari Shipper</option>
									<option value="Shipment Telah Tiba Di Hub Jakarta Pusat">Shipment Telah Tiba Di Hub Jakarta Pusat</option>
									<option value="Shipment Keluar Dari Hub Jakarta Pusat">Shipment Keluar Dari Hub Jakarta Pusat</option>
									<option value="Shipment Telah Tiba Di Hub CGK">Shipment Telah Tiba Di Hub CGK</option>
									<option value="Shipment Keluar Dari Hub CGK">Shipment Keluar Dari Hub CGK</option>
									<option value="Shipment Telah Tiba Di Hub Jakarta Utara">Shipment Telah Tiba Di Hub Jakarta Utara</option>
									<option value="Shipment Keluar Dari Hub Jakarta Utara">Shipment Keluar Dari Hub Jakarta Utara</option>
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
									<input type="date" class="form-control" id="tgl_pickup" required name="date" value="<?= date('Y-m-d') ?>">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="exampleInputEmail1">Time<span style="color: red;">*</span></label>
									<input type="time" class="form-control" required name="time" value="<?= date("H:i:s"); ?>">
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1">POD/POP</label>
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