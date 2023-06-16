<!--begin::Content-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/scans/css/style.css">
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Dashboard-->
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch">

						<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
						<div class="row">
							<div class="col-md-6">
								<div class="panel-heading ml-2">
									<div class="navbar-form navbar-left">
										<h4>SCAN IN & SCAN OUT</h4>
									</div>
									<div class="navbar-form navbar-center">
										<select class="form-control selectCamera" id="selectCamera" style="width: 80%;"></select>
									</div>

								</div>
							</div>
							<div class="col-md-6">
								<div class="well" style="position: middle;">
									<form action="<?php echo base_url('shipper/scan/outbond'); ?>" method="POST">
										<canvas id="scanOutbond" width="200" height="200"></canvas>
										<br>
										<input type="text" name="id_karyawan" autofocus>
										<input type="submit">
									</form>

								</div>
							</div>
						</div>
						<!-- /.box-body -->
						<div class="row m-4" style="overflow: auto;">
							<div class="col-md-12">
								<table id="myTable" class="table table-bordered">
									<h3 class="title font-weight-bold">List Scan In/Out</h3>
									<!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
									<p><?= $this->session->flashdata('message'); ?></p>
									<thead>
										<tr>
											<th style="width: 10%;">Shipment ID</th>
											<th style="width: 15%;">Shipper</th>
											<th style="width: 15%;">Consignee</th>
											<th style="width: 5%;">Last Status</th>
											<th style="width: 5%;">Action</th>
											<th style="width: 5%;">Driver</th>

										</tr>
									</thead>
									<tbody>
										<?php foreach ($outbond as $g) {
											//cek outgoing or incoming
											$getLast = $this->order->getLastTracking($g['shipment_id'])->row_array();
											if ($g['is_incoming'] != 1) {

												


												if ($getLast['flag'] >= 4 && $getLast['flag'] <= 5) {
										?>
													<tr>
														<td><?= $g['shipment_id'] ?></td>
														<td><?= $g['shipper'] ?><br><?= $g['tree_shipper'] ?></td>
														<td><?= $g['consigne'] ?><br><?= $g['tree_consignee'] ?></td>
														<td><?= $getLast['status'] ?></td>
														<?php if ($getLast['flag'] == 4) { ?>
															<td>Scan IN</td>
														<?php } elseif ($getLast['flag'] == 5) { ?>
															<td><a href="<?= base_url('shipper/salesOrder/weight/' . $g['shipment_id']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Weight</a>
																<a href="<?= base_url('shipper/salesOrder/edit/' . $g['id'] . '/' . $g['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Edit</a>
																<a href="<?= base_url('shipper/order/detail/' . $g['id'] . '/' . $g['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
																<!-- ini jabodetabek -->
																<?php if ($g['is_jabodetabek'] == 1) {
																?>
																	<!-- kalo sales ordernya sudah di pickup -->
																	<!-- kalo shipmentnya telah tiba di hub benhil -->
																	<?php if ($getLast['flag'] == 5 || $getLast['flag'] == 6) {
																	?>


																		<a href="#" class="btn btn-sm text-light" data-toggle="modal" data-target="#modal-lg-dl<?= $g['shipment_id'] ?>" style="background-color: #9c223b;">
																			Assign Driver DL
																		</a>
																		<?php $tracking_real = $this->db->limit(1)->order_by('id_tracking', 'DESC')->get_where('tbl_tracking_real', ['shipment_id' => $g['shipment_id'], 'flag' => 5])->row_array();
																		$order = $this->db->limit(1)->order_by('id_tracking', 'DESC')->get_where('tbl_tracking_real', ['shipment_id' => $g['shipment_id']])->row_array();
																		// var_dump($tracking_real);
																		// die;
																		?>
																		<div class="d-flex align-items-center">
																			<?php if ($tracking_real == null) {
																			?>

															<td>
																<h4 class="title"> No Driver</h4>
															</td>


														<?php	} else {
														?>
															
															<td>
																<!--begin::Symbol-->
															<div class="symbol symbol-40 symbol-light-success">
																<span class="symbol-label">
																	<img src="<?= base_url('assets/back/metronic/') ?>media/avatars/009-boy-4.svg" class="h-75 align-self-end" alt="">
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Text-->
															<?php $driver = $this->db->get_where('tb_user', ['id_user' => $tracking_real['id_user']])->row_array(); ?>
															<div class="d-flex flex-column flex-grow-1 font-weight-bold">
																<a href="#" class="text-dark text-hover-primary mb-1 font-size-lg"><?= $driver['nama_user'] ?></a>
																<span class="text-muted">Driver</span>
															</div>
															</td>
															
															<!--end::Text-->
														<?php	} ?>

							</div>
							<!-- kalo sales order nya belum di pickup -->
						<?php } elseif ($getLast['flag'] == 2) {
						?>
							<a href="#" class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#modal-lg" style="background-color: #9c223b;">
								Asign Driver PU
							</a>
							<?php $tracking = $this->db->order_by('id_tracking', 'asc')->get_where('tbl_tracking_real', ['id_so' => $p['id_so']])->row_array();

							?>
							<div class="d-flex align-items-center">
								<?php if ($tracking['id_user'] == null) {
								?>
									<td>
										<h4 class="title">No driver selected</h4>
									</td>

								<?php	} else {
								?>
								<td>
									<!--begin::Symbol-->
									<div class="symbol symbol-40 symbol-light-success">
										<span class="symbol-label">
											<img src="<?= base_url('assets/back/metronic/') ?>media/avatars/009-boy-4.svg" class="h-75 align-self-end" alt="">
										</span>
									</div>
									<!--end::Symbol-->
									<!--begin::Text-->
									<?php $driver = $this->db->get_where('tb_user', ['id_user' => $tracking['id_user']])->row_array(); ?>
									<div class="d-flex flex-column flex-grow-1 font-weight-bold">
										<a href="#" class="text-dark text-hover-primary mb-1 font-size-lg"><?= $driver['nama_user'] ?></a>
										<span class="text-muted">Driver</span>
									</div>
									<!--end::Text-->
									</td>
								<?php	} ?>

							</div>


						<?php } else {
						?>
							<h4 class="title">Your Task Has Finished</h4>
						<?php	} ?>

						<!-- KALO BUKAN JABODETABEK -->
					<?php	} else {
					?>
						<!-- kalo sales ordernya sudah di pickup -->
						<!-- kalo shipmentnya telah tiba di hub benhil -->
						<?php if ($getLast['flag'] == 5 || $getLast['flag'] == 6) {
						?>
							<a href="#" class="btn text-light" data-toggle="modal" data-target="#modal-lg-dl-luar<?= $g['shipment_id'] ?>" style="background-color: #9c223b;">
								Scan Out
							</a>
							<?php $tracking_real = $this->db->limit(1)->order_by('id_tracking', 'DESC')->get_where('tbl_tracking_real', ['shipment_id' => $g['shipment_id'], 'flag' => 5])->row_array();
																		$order = $this->db->limit(1)->order_by('id_tracking', 'DESC')->get_where('tbl_tracking_real', ['shipment_id' => $g['shipment_id']])->row_array();
																		// var_dump($tracking_real);
																		// die;
							?>
							<div class="d-flex align-items-center">
								<?php if ($tracking_real == null) {
								?>
									<td>
										<h4 class="title">No driver</h4>
									</td>


								<?php	} else {
								?>
								<td>
									<!--begin::Symbol-->
									<div class="symbol symbol-40 symbol-light-success">
										<span class="symbol-label">
											<img src="<?= base_url('assets/back/metronic/') ?>media/avatars/009-boy-4.svg" class="h-75 align-self-end" alt="">
										</span>
									</div>
									<!--end::Symbol-->
									<!--begin::Text-->
									<?php $driver = $this->db->get_where('tb_user', ['id_user' => $tracking_real['id_user']])->row_array(); ?>
									<div class="d-flex flex-column flex-grow-1 font-weight-bold">
										<a href="#" class="text-dark text-hover-primary mb-1 font-size-lg"><?= $driver['nama_user'] ?></a>
										<span class="text-muted">Driver</span>
									</div>
									<!--end::Text-->
									</td>
								<?php	} ?>

							</div>
							<!-- kalo sales order nya belum di pickup -->
						<?php } elseif ($getLast['flag'] == 2) {
						?>
							<a href="#" class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#modal-lg" style="background-color: #9c223b;">
								Asign Driver PU</a>
							<?php $tracking = $this->db->order_by('id_tracking', 'asc')->get_where('tbl_tracking_real', ['id_so' => $p['id_so']])->row_array();

							?>
							<div class="d-flex align-items-center">
								<?php if ($tracking['id_user'] == null) {
								?>
									<td>
										<h4 class="title">No driver</h4>
									</td>

								<?php	} else {
								?>
								<td>
									<!--begin::Symbol-->
									<div class="symbol symbol-40 symbol-light-success">
										<span class="symbol-label">
											<img src="<?= base_url('assets/back/metronic/') ?>media/avatars/009-boy-4.svg" class="h-75 align-self-end" alt="">
										</span>
									</div>
									<!--end::Symbol-->
									<!--begin::Text-->
									<?php $driver = $this->db->get_where('tb_user', ['id_user' => $tracking['id_user']])->row_array(); ?>
									<div class="d-flex flex-column flex-grow-1 font-weight-bold">
										<a href="#" class="text-dark text-hover-primary mb-1 font-size-lg"><?= $driver['nama_user'] ?></a>
										<span class="text-muted">Driver</span>
									</div>
									<!--end::Text-->
									</td>
								<?php	} ?>

							</div>


						<?php } else {
						?>
							<h4 class="title">Your Task Has Finished</h4>
						<?php	} ?>


					<?php	} ?>
					</td>
				<?php } ?>

				</tr>

			<?php }
												// jika incoming
											} else {
												if ($getLast['flag'] == 9) { ?>

				<tr>
					<td><?= $g['shipment_id'] ?></td>
					<td><?= $g['shipper'] ?><br><?= $g['tree_shipper'] ?></td>
					<td><?= $g['consigne'] ?><br><?= $g['tree_consignee'] ?></td>
					<td><?= $getLast['status'] ?></td>
					<td><a href="<?= base_url('shipper/Scan/scanOutIncoming/' . $g['shipment_id']) ?>" class="btn text-light" style="background-color: #9c223b;">
							Scan Out
						</a></td>
				</tr>

	<?php }
											}
										} ?>
	</tbody>


	</table>
						</div>
					</div>
				</div>

			</div>
		</div>


	</div>
	<!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->

<form action="<?= base_url('dispatcher/scan/cek_id') ?>" method="post">
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Scan In/Out With <b>
							<span id="id2"></span>
						</b>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h4>Are you sure ?</h4>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="shipment_id" class="shipment_id">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
					<button type="submit" class="btn btn-primary">Yes</button>
				</div>
			</div>
		</div>
	</div>
</form>

<?php foreach ($outbond as $shp) {
?>
	<div class="modal fade" id="modal-lg-dl<?= $shp['shipment_id'] ?>">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Assign Driver DL <b><?= $shp['shipment_id'] ?></b> </h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('shipper/Scan/assignDriverDl') ?>" method="POST">
						<div class="card-body">
							<div class="row">
								<input type="text" name="id_so" class="form-control" hidden value="<?= $shp['id_so'] ?>">
								<input type="text" name="shipment_id" class="form-control" hidden value="<?= $shp['shipment_id'] ?>">
								<!-- <input type="text" name="id_tracking" class="form-control" value="<?= $shipment['id_tracking'] ?>"> -->
								<div class="col-md-12">
									<label for="id_driver">Choose Driver : </label>
									<select name="id_driver" class="form-control" style="width: 200px;">
										<?php foreach ($users as $u) {
										?>
											<option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
										<?php	} ?>
									</select>

								</div>

							</div>
						</div>
						<!-- /.card-body -->
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button onclick='$("#modalLoading").modal("show");' type="submit" class="btn btn-primary">Submit</button>
				</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

<?php } ?>

<?php foreach ($outbond as $shp) {
?>
	<div class="modal fade" id="modal-dl-incoming<?= $shp['shipment_id'] ?>">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Assign Driver DL <b><?= $shp['shipment_id'] ?></b> </h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('shipper/Scan/assignDriverDlIncoming') ?>" method="POST">
						<div class="card-body">
							<div class="row">
								<input type="text" name="id_so" class="form-control" hidden value="<?= $shp['id_so'] ?>">
								<input type="text" name="shipment_id" class="form-control" hidden value="<?= $shp['shipment_id'] ?>">
								<!-- <input type="text" name="id_tracking" class="form-control" value="<?= $shipment['id_tracking'] ?>"> -->
								<div class="col-md-12">
									<label for="id_driver">Choose Driver : </label>
									<select name="id_driver" class="form-control" style="width: 200px;">
										<?php foreach ($users as $u) {
										?>
											<option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
										<?php	} ?>
									</select>

								</div>

							</div>
						</div>
						<!-- /.card-body -->
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button onclick='$("#modalLoading").modal("show");' type="submit" class="btn btn-primary">Submit</button>
				</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

<?php } ?>

<?php foreach ($outbond as $shp) {
?>
	<div class="modal fade" id="modal-lg-dl-luar<?= $shp['shipment_id'] ?>">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Assign Driver & Map Gateway <b><?= $shp['shipment_id'] ?></b></h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('shipper/Scan/assignDriverHub') ?>" method="POST">
						<div class="card-body">
							<div class="row">
								<input type="text" name="id_so" class="form-control" hidden value="<?= $shp['id_so'] ?>">
								<input type="text" name="shipment_id" class="form-control" hidden value="<?= $shp['shipment_id'] ?>">
								<div class="col-md-6">
									<label for="id_driver">Choose Driver : </label>
									<select name="id_driver" class="form-control" style="width: 200px;">
										<?php foreach ($users as $u) {
										?>
											<option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
										<?php	} ?>
									</select>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Choose Gateway ?</label>
										<div class="form-check">
											<input class="radioBtnClass" type="radio" name="gateway" value="ops">
											<label class="form-check-label" for="flexRadioDefault1">
												OPS
											</label>
										</div>
										<div class="form-check">
											<input class="radioBtnClass" type="radio" name="gateway" value="cs">
											<label class="form-check-label" for="flexRadioDefault1">
												CS
											</label>
										</div>
									</div>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">HUB ? <span style="color: red;">Soekarno Hatta or, Cengkareng</span> </label>
										<input type="text" class="form-control" name="note">
									</div>

								</div>
								<!-- <div class="col-md-6" id="driver2" style="display: none;">
									<label for="id_driver">Choose Gateway : </label>
									<select name="driver_gateway" class="form-control" style="width: 200px;">
										<?php foreach ($users as $u) {
										?>
											<option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
										<?php	} ?>
									</select>
								</div> -->

							</div>
						</div>
						<!-- /.card-body -->
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button onclick='$("#modalLoading").modal("show");' type="submit" class="btn btn-primary">Submit</button>
				</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

<?php } ?>