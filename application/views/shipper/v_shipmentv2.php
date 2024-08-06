	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">

				<?php foreach ($delivery->result_array() as $delivery1) { ?>

					<div class="col-12">
						<div class="card card-custom gutter-b">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="symbol symbol-40 mr-5 symbol-success">
										<span class="symbol-label">
											<p class="h-90 font-weight-bold mt-3">DL</p>
										</span>
									</div>
									<div class="d-flex flex-column flex-grow-1">
										<a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder"><?= $delivery1['shipper'] ?></a>
										<span class="text-muted font-weight-bold"><?= $delivery1['shipment_id'] ?></span>
									</div>
								</div>
								<div>
									<span class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
										<b>Informasi Delivery : </b>
										</b> jumlah koli <b><?= $delivery1['koli'] ?></b> <?php print ($delivery1['weight'] != NULL) ? 'dan berat<b>' . $delivery1['weight'] . '  Kg</b>' : ""; ?>
										dengan tujuan <b><?= $delivery1['consigne'] ?></b> <br>
										<b>Alamat : </b> <?= $delivery1['destination'] ?>, <?= $delivery1['city_consigne'] ?> <br>
										<b>Jenis barang :</b> <?= $delivery1['pu_commodity'] ?> <br>
										<b>Service :</b> <?= $delivery1['pu_service'] ?>
									</span>

									<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
										<b>Informasi Tambahan :</b> <i><b><?= $delivery1['pu_note'] ?></b></i> <br>

									</p>
									<hr>
									<!--edit::Editor-->


									<div class="card-toolbar">
										<?php if ($delivery1['delivery_status'] == 1) { ?>
											<a onclick="return confirm('Apakah anda yakin ?')" href="<?= base_url('shipper/SalesOrder/receiveTaskDelivery/' . $delivery1['shipment_id']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
												<i class="fas fa-car text-light"> </i>
												Terima Tugas
											</a>
										<?php } elseif ($delivery1['delivery_status'] == 2) { ?>
											<button type="button" class="btn modalDelivery text-light" data-toggle="modal" data-shipment_id="<?= $delivery1['shipment_id'] ?>" data-target="#modal-lg-dl" style="background-color: #9c223b;">
												<i class="fas fa-car text-light"> </i>
												Finish Delivery
											</button>
										<?php } ?>

									</div>
								</div>

							</div>
						</div>
					</div>

				<?php } ?>

				<?php foreach ($shipments as $shipment) { ?>
					<div class="col-12">
						<div class="card card-custom gutter-b">
							<?php if ($shipment['status_pickup'] == 1) {
							?>
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-40 mr-5 symbol-success">
											<span class="symbol-label">
												<p class="h-90 font-weight-bold mt-3">PU</p>
											</span>
										</div>
										<div class="d-flex flex-column flex-grow-1">
											<a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder"><?= $shipment['shipper'] ?></a>
											<span class="text-muted font-weight-bold"><?= longdate_indo($shipment['tgl_pickup']) ?> at <?= $shipment['time'] ?></span>
										</div>
									</div>
									<div>
										<span class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
											Hallo <?= $this->session->userdata('nama_user') ?>, Ada pickup di <b> <?= $shipment['pu_poin'] ?></b> menggunakan moda
											<b><?= $shipment['pu_moda'] ?></b> jumlah koli <b><?= $shipment['koli'] ?></b> dan berat <b><?= $shipment['kg'] ?> Kg</b>
											dengan tujuan <b><?= $shipment['destination'] ?></b> <br>
											Jenis barang : <b><?= $shipment['commodity'] ?></b> <br>
											Service : <b><?= $shipment['service'] ?></b>
										</span>
										<hr>
										<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
											Informasi Tambahan : <i><b><?= $shipment['note'] ?></b></i>
										</p>
									</div>
									<div class="separator separator-solid mt-2 mb-4"></div>
									<form class="position-relative" style="height: 20px;">
										<div class="position-absolute top-0 right-0 mt-n1 mr-n2">
											<a href="<?= base_url('shipper/salesOrder/receive/' . $shipment['id_so']) ?>" onclick='$("#modalLoading").modal("show");' class="btn text-light" style="background-color: #9c223b;">Receive Task</a>
										</div>
									</form>
									<!--edit::Editor-->
								</div>
							<?php } elseif ($shipment['status_pickup'] == 2) {
							?>
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-40 mr-5 symbol-success">
											<span class="symbol-label">
												<p class="h-90 font-weight-bold mt-3">PU</p>
											</span>
										</div>
										<div class="d-flex flex-column flex-grow-1">
											<a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder"><?= $shipment['shipper'] ?></a>
											<span class="text-muted font-weight-bold"><?= longdate_indo($shipment['tgl_pickup']) ?> at <?= $shipment['time'] ?></span>
										</div>
									</div>
									<div>
										<span class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
											<b>Informasi Pickup: </b> Pickup di <b> <?= $shipment['pu_poin'] ?></b> menggunakan moda
											<b><?= $shipment['pu_moda'] ?></b> jumlah koli <b><?= $shipment['koli'] ?></b> dan berat <b><?= $shipment['kg'] ?>Kg</b>
											dengan tujuan <b><?= $shipment['destination'] ?></b> <br>
											Jenis barang : <b><?= $shipment['commodity'] ?></b> <br>
											Service : <b><?= $shipment['service'] ?></b>
										</span>

										<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
											Informasi Tambahan : <i><b><?= $shipment['note'] ?></b></i>
										</p>
									</div>
									<hr>

									<!--edit::Editor-->
									<div class="card-body">
										<p class="h-14"><i class="fa fa-info text-danger"></i> Tekan tombol <b>Arrive PU</b> Jika sudah tiba ditempat Pickup</p>
										<!-- <div class="alert alert-success text-light" role="alert"> </div> -->
										<div class="card-toolbar">
											<!-- <a href="<?= base_url('shipper/salesOrder/arrivePu/' . $shipment['id_so'] . '/' . $shipment['id_tracking'] . '/' . $shipment['shipment_id']) ?>" onclick='$("#modalLoading").modal("show");' class="btn text-light" style="background-color: #9c223b;">Arrive PU</a> -->
											<a href="<?= base_url('shipper/salesOrder/arrivePu/' . $shipment['id_so']) ?>" onclick='$("#modalLoading").modal("show");' class="btn text-light" style="background-color: #9c223b;">Arrive PU</a>
										</div>
									</div>
								</div>
							<?php } elseif ($shipment['status_pickup'] == 3) { ?>
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-40 mr-5 symbol-success">
											<span class="symbol-label">
												<p class="h-90 font-weight-bold mt-3">PU</p>
											</span>
										</div>
										<div class="d-flex flex-column flex-grow-1">
											<a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder"><?= $shipment['shipper'] ?></a>
											<span class="text-muted font-weight-bold"><?= longdate_indo($shipment['tgl_pickup']) ?> at <?= $shipment['time'] ?></span>
										</div>
									</div>
									<div>
										<span class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
											<b>Informasi Pickup: </b> Pickup di <b> <?= $shipment['pu_poin'] ?></b> menggunakan moda
											<b><?= $shipment['pu_moda'] ?></b> jumlah koli <b><?= $shipment['koli'] ?></b> dan berat <b><?= $shipment['kg'] ?>Kg</b>
											dengan tujuan <b><?= $shipment['destination'] ?></b> <br>
											Jenis barang : <b><?= $shipment['commodity'] ?></b> <br>
											Service : <b><?= $shipment['service'] ?></b>
										</span>

										<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
											Informasi Tambahan : <i><b><?= $shipment['note'] ?></b></i>
										</p>
									</div>
									<hr>

									<?php $shipmentOnSoCharter =  $this->db->query('SELECT a.shipment_id,a.tgl_diterima  FROM tbl_shp_order AS a INNER JOIN tb_service_type AS b ON a.service_type = b.code WHERE a.id_so = ' . $shipment['id_so'] . ' AND (b.prefix = "CHA" OR b.prefix = "SDS") AND a.is_jabodetabek = 1')  ?>
									<?php if ($shipmentOnSoCharter->num_rows() != 0) {
										$cekTglDiterima = $shipmentOnSoCharter->result_array();
										if (in_array(NULL, array_column($cekTglDiterima, 'tgl_diterima'))) { ?>


											<div class="card-body">
												<table class="table">
													<thead>
														<tr>
															<th>Resi</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($shipmentOnSoCharter->result_array() as $shipmentOnSoCharter1) {
															if ($shipmentOnSoCharter1['tgl_diterima'] == NULL) { ?>

																<tr>
																	<td scope="row"><?= $shipmentOnSoCharter1['shipment_id'] ?></td>
																	<td><a onclick="return confirm('Are You sure ?')" href="<?= base_url('shipper/salesOrder/deliveryCharter/' . $shipmentOnSoCharter1['shipment_id']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
																			<i class="fas fa-car text-light"> </i>
																			Delivery
																		</a></td>
																</tr>
														<?php }
														} ?>
													</tbody>
												</table>
											</div>
											<hr>

									<?php }
									} ?>

									<!--edit::Editor-->
									<div class="card-body">
										<p class="h-14"><i class="fa fa-info text-danger"></i> Tekan tombol <b>Add Shipment</b> Jika Ingin Menambahkan Shipment</p>

										<p class="h-14"><i class="fa fa-info text-danger"></i> Tekan tombol <b>Done</b> Jika Sudah Selesai</p>
										<!-- <div class="alert alert-success text-light" role="alert"> </div> -->
										<div class="card-toolbar">
											<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('shipper/order/view/' . $shipment['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
												<i class="fas fa-plus-circle text-light"> </i>
												Add Shipment
											</a>

											<?php $shipmentOnSoReguler =  $this->db->query('SELECT a.shipment_id  FROM tbl_shp_order AS a INNER JOIN tb_service_type AS b ON a.service_type = b.code WHERE a.id_so = ' . $shipment['id_so'] . ' AND (b.prefix = "REG" OR b.prefix = "AIR")') ?>

											<?php if ($shipmentOnSoReguler->num_rows() != 0 || $shipmentOnSoCharter->num_rows() != 0) { ?>

												<?php if ($shipmentOnSoCharter->num_rows() != 0) {

													if (in_array(NULL, array_column($cekTglDiterima, 'tgl_diterima'))) { ?>
														-
													<?php } else { ?>
														<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('shipper/order/doneShipmentDriver/' . $shipment['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
															<i class="fas fa-check text-light"> </i>
															Done Shipment
														</a>
													<?php } ?>

												<?php } else { ?>
													<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('shipper/order/doneShipmentDriver/' . $shipment['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
														<i class="fas fa-check text-light"> </i>
														Done Shipment
													</a>
											<?php }
											} ?>


										</div>
									</div>



								</div>
							<?php } ?>
						</div>
					</div>
			</div>
		<?php } ?>


		</div>
		<!-- /.card -->
		</div>
		<!--/. container-fluid -->

		<div class="modal fade" id="modal-lg-dl">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Finish Delivery</b> </h4>

						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="<?= base_url('shipper/SalesOrder/finishDelivery') ?>" method="POST">
							<div id="modal-content">


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
	</section>
	<!-- /.content -->
	<script>
		$(document).ready(function() {
			$('.modalDelivery').click(function() {
				var shipment_id = $(this).data('shipment_id'); // Mendapatkan ID dari atribut data-id tombol yang diklik

				var contentTunggu = '<div class="card-body">' +
					'<div class="row">' +
					'<b>Please Wait</b>' +
					'</div>' +
					'</div>';

				$('#modal-content').html(contentTunggu);
				// Memuat data menggunakan AJAX dengan mengirimkan ID sebagai parameter

				// Menampilkan data ke dalam modal
				var content = '<div class="card-body">' +
					'<div class="row">' +
					'Finish Delivery <b> ' + shipment_id + '</b>' +
					'<input type="text" name="shipment_id" class="form-control" hidden value="' + shipment_id + '">' +
					'<div class="col-md-12">' +
					'<label for="id_driver">Diterima Oleh : </label>' +
					'<input type="text" class="form-control" name="penerima" id="penerima">' +
					'</div>' +
					'</div>' +
					'</div>';
				$('#modal-content').html(content);
				$('#selectField').select2();


			});
		});
	</script>