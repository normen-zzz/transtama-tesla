	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<?php foreach ($shipments as $shipment) {
				?>
					<div class="col-12">
						<!-- ini jabodetabek -->
						<?php if ($shipment['is_jabodetabek'] == 1) {
							// var_dump($shipment['service_name']);
							// die;
							// kalo dia servicenya ONS
							// var_dump($shipment['flag']);
							// die;
							if ($shipment['service_name'] == 'Same Day Service' || $shipment['service_name'] == 'Charter Service') {
						?>
								<div class="card card-custom gutter-b">
									<?php if ($shipment['flag'] == 1) {
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
													<b><?= $shipment['pu_moda'] ?></b> jumlah koli <b><?= $shipment['koli'] ?></b> dan berat <b><?= $shipment['weight'] ?>Kg</b>
													dengan tujuan <b><?= $shipment['destination'] ?></b> <br>
													Jenis barang : <b><?= $shipment['pu_commodity'] ?></b> <br>
													Service : <b><?= $shipment['pu_service'] ?></b>
												</span>
												<hr>
												<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
													Informasi Tambahan : <i><b><?= $shipment['note'] ?></b></i>
												</p>
											</div>
											<div class="separator separator-solid mt-2 mb-4"></div>
											<form class="position-relative" style="height: 20px;">
												<div class="position-absolute top-0 right-0 mt-n1 mr-n2">
													<a href="<?= base_url('shipper/salesOrder/receive/' . $shipment['id_so'] . '/' . $shipment['id_tracking'] . '/' . $shipment['shipment_id']) ?>" onclick='$("#modalLoading").modal("show");' class="btn text-light" style="background-color: #9c223b;">Receive Task</a>
												</div>
											</form>
											<!--edit::Editor-->
										</div>
									<?php	} elseif ($shipment['flag'] == 2) {
									?>
										<div class="card-body <?= $shipment['shipment_id'] ?>">
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
													<b><?= $shipment['pu_moda'] ?></b> jumlah koli <b><?= $shipment['koli'] ?></b> dan berat <b><?= $shipment['weight'] ?>Kg</b>
													dengan tujuan <b><?= $shipment['destination'] ?></b> <br>
													Jenis barang : <b><?= $shipment['pu_commodity'] ?></b> <br>
													Service : <b><?= $shipment['pu_service'] ?></b>
												</span>

												<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
													Informasi Tambahan : <i><b><?= $shipment['pu_note'] ?></b></i>
												</p>
											</div>
											<hr>

											<!--edit::Editor-->
											<div class="card-body">
												<p class="h-14"><i class="fa fa-info text-danger"></i> Tekan tombol <b>Add Shipment</b> Jika sudah tiba ditempat Pickup</p>
												<!-- <div class="alert alert-success text-light" role="alert"> </div> -->
												<div class="card-toolbar">
													<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('shipper/order/view/' . $shipment['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
														<i class="fas fa-plus-circle text-light"> </i>
														Add Shipment
													</a>
												</div>
											</div>
										</div>
									<?php	} elseif ($shipment['flag'] == 3) {
									?>
										<div class="card-body <?= $shipment['shipment_id'] ?>">
											<div class="d-flex align-items-center">
												<div class="symbol symbol-40 mr-5 symbol-success">
													<span class="symbol-label">
														<p class="h-90 font-weight-bold mt-3">DL</p>
													</span>
												</div>
												<div class="d-flex flex-column flex-grow-1">
													<a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder"><?= $shipment['shipper'] ?></a>
													<span class="text-muted font-weight-bold"><?= $shipment['shipment_id'] ?></span>
												</div>
											</div>
											<div>
												<span class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
													<b>Informasi Delivery : </b>
													</b> jumlah koli <b><?= $shipment['koli'] ?></b> dan berat <b><?= $shipment['weight'] ?> Kg</b>
													dengan tujuan <b><?= $shipment['consigne'] ?></b> <br>
													<b>Alamat : </b> <?= $shipment['destination'] ?>, <?= $shipment['city_consigne'] ?> <br>
													<b>Jenis barang :</b> <?= $shipment['pu_commodity'] ?> <br>
													<b>Service :</b> <?= $shipment['pu_service'] ?>
												</span>

												<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
													<b>Informasi Tambahan :</b> <i><b><?= $shipment['pu_note'] ?></b></i> <br>
													<b>Tanggal Tugas :</b> <?= longdate_indo($shipment['tgl_tugas']) . ' ' . $shipment['jam_tugas'] ?>
												</p>
												<hr>
												<!--edit::Editor-->

												<p class="h-14 mt-4"><i class="fa fa-info text-danger"></i> Jika barang kiriman sudah di input, tekan tombol <b>Delivery</b> </p>
												<!-- <div class="alert alert-success text-light" role="alert"> </div> -->
												<div class="card-toolbar">
													<a onclick="return confirm('Are You sure ?')" href="<?= base_url('shipper/salesOrder/deliveryOns/' . $shipment['id_so'] . '/' . $shipment['shipment_id'] . '/' . $shipment['id_tracking']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
														<i class="fas fa-car text-light"> </i>
														Delivery
													</a>
													<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('shipper/order/view/' . $shipment['id_so'] . '/' . $shipment['id_tracking']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
														<i class="fas fa-plus-circle text-light"> </i>
														View Shipment
													</a>
												</div>
											</div>

										</div>


									<?php	} elseif ($shipment['flag'] == 4) {
									?>
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div class="symbol symbol-40 mr-5 symbol-success">
													<span class="symbol-label">
														<p class="h-90 font-weight-bold mt-3">DL</p>
													</span>
												</div>
												<div class="d-flex flex-column flex-grow-1">
													<a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder"><?= $shipment['shipper'] ?></a>
													<span class="text-muted font-weight-bold"><?= $shipment['shipment_id'] ?></span>
												</div>
											</div>
											<div>
												<span class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
													<b>Informasi Delivery : </b>
													</b> jumlah koli <b><?= $shipment['koli'] ?></b> dan berat <b><?= $shipment['weight'] ?> Kg</b>
													dengan tujuan <b><?= $shipment['consigne'] ?></b> <br>
													<b>Alamat : </b> <?= $shipment['destination'] ?>, <?= $shipment['city_consigne'] ?> <br>
													<b>Jenis barang :</b> <?= $shipment['pu_commodity'] ?> <br>
													<b>Service :</b> <?= $shipment['pu_service'] ?>
												</span>
												<hr>
												<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
													<b>Informasi Tambahan :</b> <i><b><?= $shipment['pu_note'] ?></b></i> <br>
													<b>Tanggal Tugas :</b> <?= longdate_indo($shipment['tgl_tugas']) . ' ' . $shipment['jam_tugas'] ?>
												</p>
											</div>
											<p class="h-14 mt-4"><i class="fa fa-info text-danger"></i> Tekan tombol <b>Arrive</b> Jika Kiriman Anda sudah sampai di tujuan</p>
											<!-- <div class="alert alert-success text-light" role="alert"> </div> -->
											<div class="card-toolbar">
												<a href="#" class="btn mr-2 text-light" data-toggle="modal" data-target="#modal-lg-ons<?= $shipment['shipment_id'] ?>" style="background-color: #9c223b;">
													<i class="fas fa-check text-light"> </i>
													Arrive
												</a>
											</div>
										</div>
									<?php	} elseif ($shipment['flag'] == 5) {
									?>

									<?php } else {
									} ?>

								</div>

							<?php	} else {
								// var_dump($shipment['flag']);
								// die;
							?>
								<div class="card card-custom gutter-b <?= $shipment['shipment_id'] ?>">
									<?php if ($shipment['flag'] == 1) {
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
													<b><?= $shipment['pu_moda'] ?></b> jumlah koli <b><?= $shipment['koli'] ?></b> dan berat <b><?= $shipment['weight'] ?> Kg</b>
													dengan tujuan <b><?= $shipment['destination'] ?></b> <br>
													Jenis barang : <b><?= $shipment['pu_commodity'] ?></b> <br>
													Service : <b><?= $shipment['pu_service'] ?></b>
												</span>
												<hr>
												<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
													Informasi Tambahan : <i><b><?= $shipment['pu_note'] ?></b></i>
												</p>
											</div>
											<div class="separator separator-solid mt-2 mb-4"></div>
											<form class="position-relative" style="height: 20px;">
												<div class="position-absolute top-0 right-0 mt-n1 mr-n2">
													<a href="<?= base_url('shipper/salesOrder/receive/' . $shipment['id_so'] . '/' . $shipment['id_tracking'] . '/' . $shipment['shipment_id']) ?>" onclick='$("#modalLoading").modal("show");' class="btn text-light" style="background-color: #9c223b;">Receive Task</a>
												</div>
											</form>
											<!--edit::Editor-->
										</div>
									<?php	} elseif ($shipment['flag'] == 2) {
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
													<b>Informasi Pickup :</b> Pickup di <b> <?= $shipment['pu_poin'] ?></b> menggunakan moda
													<b><?= $shipment['pu_moda'] ?></b> jumlah koli <b><?= $shipment['koli'] ?></b> dan berat <b><?= $shipment['weight'] ?> Kg</b>
													dengan tujuan <b><?= $shipment['destination'] ?></b> <br>
													Jenis barang : <b><?= $shipment['pu_commodity'] ?></b> <br>
													Service : <b><?= $shipment['pu_service'] ?></b>
												</span>
												<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
													Informasi Tambahan : <i><b><?= $shipment['pu_note'] ?></b></i>
												</p>
											</div>

											<div class="separator separator-solid mt-2 mb-4"></div>
											<p class="h-14"><i class="fa fa-info text-danger"></i> Tekan Tombol <b>Add Shipment</b> apabila sudah sampai tempat Pickup</p>
											<!-- <div class="alert alert-success text-light" role="alert"> </div> -->

											<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('shipper/order/view/' . $shipment['id_so'] . '/' . $shipment['id_tracking']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
												<i class="fas fa-plus-circle text-light"> </i>
												Add Shipment
											</a>

										</div>
									<?php	} elseif ($shipment['flag'] == 3) {
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
													<span class="text-muted font-weight-bold"><?= $shipment['shipment_id'] ?></span>
												</div>
											</div>
											<div>
												<span class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
													<b>Informasi Pickup :</b> Pickup di <b> <?= $shipment['pu_poin'] ?></b> menggunakan moda
													<b><?= $shipment['pu_moda'] ?></b> jumlah koli <b><?= $shipment['koli'] ?></b> dan berat <b><?= $shipment['weight'] ?>Kg</b>
													dengan tujuan <b><?= $shipment['destination'] ?></b> <br>
													Jenis barang : <b><?= $shipment['pu_commodity'] ?></b> <br>
													Service : <b><?= $shipment['pu_service'] ?></b>
												</span>
												<hr>
												<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
													Informasi Tambahan : <i><b><?= $shipment['pu_note'] ?></b></i>
												</p>
											</div>
											<p class="h-12"><i class="fa fa-info text-danger"></i> Apabila sudah sampai di Hub Benhil, tekan tombol <i>Arrive In Benhil Hub</i></p>
											<!-- <div class="alert alert-success text-light" role="alert"> </div> -->
											<div class="card-toolbar">
												<a onclick="return confirm('Are you sure ?')" href="<?= base_url('shipper/salesOrder/arriveBenhil/' . $shipment['id_so'] . '/' . $shipment['shipment_id'] . '/' . $shipment['id_tracking']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
													<i class="fas fa-check text-light"> </i>
													Arrive In Benhil Hub
												</a>

												<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('shipper/order/view/' . $shipment['id_so'] . '/' . $shipment['id_tracking']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
													<i class="fas fa-plus-circle text-light"> </i>
													Add Shipment
												</a>

											</div>
											<!--edit::Editor-->
										</div>

									<?php	} elseif ($shipment['flag'] == 4) {
									?>
										<div class="card-body">
											<div>
												<p class="text-dark-150 font-size-lg font-weight-normal" style="text-align: justify;">
													<i class="fa fa-calendar-check text-success"></i> <span style="font-size: 
					15px;">No Activity Right Now </span>
												</p>
											</div>

											<!--edit::Editor-->
										</div>
									<?php	} elseif ($shipment['flag'] == 5) {
									?>
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div class="symbol symbol-40 mr-5 symbol-success">
													<span class="symbol-label">
														<p class="h-90 font-weight-bold mt-3">DL</p>
													</span>
												</div>
												<div class="d-flex flex-column flex-grow-1">
													<a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder"><?= $shipment['shipper'] ?></a>
													<span class="text-muted font-weight-bold"><?= $shipment['shipment_id'] ?></span>
												</div>
											</div>
											<div>
												<span class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
													Hallo <?= $this->session->userdata('nama_user') ?>, Tolong Delivery ke<b> <?= $shipment['destination'] ?>, <?= $shipment['state_consigne'] ?>, <?= $shipment['city_consigne'] ?></b> <br>
													jumlah koli <b><?= $shipment['koli'] ?></b> dengan
													Service : <b><?= $shipment['service_name'] ?></b>
													Consignee : <b><?= $shipment['consigne'] ?></b>
												</span>
											</div>
											<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
												<b>Informasi Tambahan :</b> <i><b><?= $shipment['pu_note'] ?></b></i> <br>
												<b>Tanggal Tugas :</b> <?= longdate_indo($shipment['tgl_tugas']) . ' ' . $shipment['jam_tugas'] ?>
											</p>
											<div class="separator separator-solid mt-2 mb-4"></div>
											<form class="position-relative" style="height: 20px;">
												<div class="position-absolute top-0 right-0 mt-n1 mr-n2">
													<a href="<?= base_url('shipper/salesOrder/receiveDelivery/' . $shipment['id_so'] . '/' . $shipment['shipment_id'] . '/' . $shipment['id_tracking']) ?>" onclick='$("#modalLoading").modal("show");' class="btn text-light" style="background-color: #9c223b;">Receive Task</a>
												</div>
											</form>
											<!--edit::Editor-->
										</div>
									<?php	} elseif ($shipment['flag'] == 6) {
									?>
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div class="symbol symbol-40 mr-5 symbol-success">
													<span class="symbol-label">
														<p class="h-90 font-weight-bold mt-3">DL</p>
													</span>
												</div>
												<div class="d-flex flex-column flex-grow-1">
													<a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder"><?= $shipment['shipper'] ?></a>
													<span class="text-muted font-weight-bold"><?= $shipment['shipment_id'] ?></span>
												</div>
											</div>
											<div>
												<span class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
													Hallo <?= $this->session->userdata('nama_user') ?>, Tolong Delivery ke<b> <?= $shipment['destination'] ?>, <?= $shipment['state_consigne'] ?>, <?= $shipment['city_consigne'] ?></b> <br>
													jumlah koli <b><?= $shipment['koli'] ?></b> dengan
													Service : <b><?= $shipment['service_name'] ?></b>
													Consignee : <b><?= $shipment['consigne'] ?></b>
												</span>
											</div>
											<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
												<b>Informasi Tambahan :</b> <i><b><?= $shipment['pu_note'] ?></b></i> <br>
												<b>Tanggal Tugas :</b> <?= longdate_indo($shipment['tgl_tugas']) . ' ' . $shipment['jam_tugas'] ?>
											</p>
											<p class="h-14 mt-4"><i class="fa fa-info text-danger"></i> Tekan tombol <b>Arrive</b> Jika Kiriman Anda sudah sampai di tujuan</p>
											<!-- <div class="alert alert-success text-light" role="alert"> </div> -->
											<div class="card-toolbar">
												<a href="#" class="btn mr-2 text-light" data-toggle="modal" data-target="#modal-lg<?= $shipment['shipment_id'] ?>" style="background-color: #9c223b;">
													<i class="fas fa-check text-light"> </i>
													Arrive
												</a>
											</div>
										</div>
									<?php	} elseif ($shipment['flag'] == 7) {
									?>
										<div class="card-body">
											<div>
												<p class="text-dark-150 font-size-lg font-weight-normal" style="text-align: justify;">
													<i class="fa fa-calendar-check text-success"></i> <span style="font-size: 
					15px;">No Activity Right Now </span>
												</p>
											</div>

											<!--edit::Editor-->
										</div>

									<?php	} elseif ($shipment['flag'] == 9) {
									?>
										<?php if ($shipment['status_eksekusi'] == 0) {
										?>
											<div class="card-body">
												<div class="d-flex align-items-center">
													<div class="symbol symbol-40 mr-5 symbol-success">
														<span class="symbol-label">
															<p class="h-90 font-weight-bold mt-3">DL</p>
														</span>
													</div>
													<div class="d-flex flex-column flex-grow-1">
														<a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder"><?= $shipment['shipper'] ?></a>
														<span class="text-muted font-weight-bold"><?= $shipment['shipment_id'] ?></span>
													</div>
												</div>
												<div>
													<span class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
														Hallo <?= $this->session->userdata('nama_user') ?>, Tolong Delivery ke<b> <?= $shipment['destination'] ?>, <?= $shipment['state_consigne'] ?>, <?= $shipment['city_consigne'] ?></b> <br>
														jumlah koli <b><?= $shipment['koli'] ?></b> <br>
														Service : <b><?= $shipment['service_name'] ?></b> <br>
														Consignee : <b><?= $shipment['consigne'] ?></b>
													</span>
												</div>
												<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
													<b>Informasi Tambahan :</b> <i><b><?= $shipment['note'] ?></b></i> <br>
													<b>Tanggal Tugas :</b> <?= longdate_indo($shipment['tgl_tugas']) . ' ' . $shipment['jam_tugas'] ?>
												</p>
												<div class="separator separator-solid mt-2 mb-4"></div>
												<form class="position-relative" style="height: 20px;">
													<div class="position-absolute top-0 right-0 mt-n1 mr-n2">
														<a href="<?= base_url('shipper/salesOrder/receiveDeliveryIncoming/' . $shipment['id_so'] . '/' . $shipment['shipment_id'] . '/' . $shipment['id_tracking']) ?>" onclick='$("#modalLoading").modal("show");' class="btn text-light" style="background-color: #9c223b;">Receive Task</a>
													</div>
												</form>
												<!--edit::Editor-->
											</div>
										<?php	} else {
										?>
											<div class="card-body">
												<div>
													<p class="text-dark-150 font-size-lg font-weight-normal" style="text-align: justify;">
														<i class="fa fa-calendar-check text-success"></i> <span style="font-size: 
					15px;">On The Way To <?= $shipment['note'] ?></span>
													</p>
												</div>

												<!--edit::Editor-->
											</div>


										<?php	} ?>

									<?php	} elseif ($shipment['flag'] == 10) {
									?>
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div class="symbol symbol-40 mr-5 symbol-success">
													<span class="symbol-label">
														<p class="h-90 font-weight-bold mt-3">DL</p>
													</span>
												</div>
												<div class="d-flex flex-column flex-grow-1">
													<a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder"><?= $shipment['shipper'] ?></a>
													<span class="text-muted font-weight-bold"><?= $shipment['shipment_id'] ?></span>
												</div>
											</div>
											<div>
												<span class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
													Hallo <?= $this->session->userdata('nama_user') ?>, Tolong Delivery ke<b> <?= $shipment['destination'] ?>, <?= $shipment['state_consigne'] ?>, <?= $shipment['city_consigne'] ?></b> <br>
													jumlah koli <b><?= $shipment['koli'] ?></b> <br>
													Service : <b><?= $shipment['service_name'] ?></b> <br>
													Consignee : <b><?= $shipment['consigne'] ?></b>
												</span>
											</div>
											<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
												<b>Informasi Tambahan :</b> <i><b><?= $shipment['note'] ?></b></i> <br>
												<b>Tanggal Tugas :</b> <?= longdate_indo($shipment['tgl_tugas']) . ' ' . $shipment['jam_tugas'] ?>
											</p>
											<hr>
											<p class="h-14 mt-4"><i class="fa fa-info text-danger"></i> Tekan tombol <b>Arrive</b> Jika Kiriman Anda sudah sampai di tujuan</p>
											<!-- <div class="alert alert-success text-light" role="alert"> </div> -->
											<div class="card-toolbar">
												<a href="#" class="btn mr-2 text-light" data-toggle="modal" data-target="#modal-lg-incoming<?= $shipment['shipment_id'] ?>" style="background-color: #9c223b;">
													<i class="fas fa-check text-light"> </i>
													Arrive
												</a>
											</div>
										</div>

									<?php	} else {
									?>
										<!--				<div class="card-body">-->
										<!--					<div>-->
										<!--						<p class="text-dark-150 font-size-lg font-weight-normal" style="text-align: justify;">-->
										<!--							<i class="fa fa-calendar-check text-success"></i> <span style="font-size: -->
										<!--15px;">No Activity Right Now </span>-->
										<!--						</p>-->
										<!--					</div>-->

										<!--					edit::Editor-->
										<!--				</div>-->
									<?php	} ?>

									<!--end::Body-->
								</div>

							<?php	}
							?>
							<!-- kalo dia bukan jabodetabek -->
						<?php	} else {


						?>
							<div class="card card-custom gutter-b">
								<?php if ($shipment['flag'] == 1) {
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
												<b><?= $shipment['pu_moda'] ?></b> jumlah koli <b><?= $shipment['koli'] ?></b> dan berat <b><?= $shipment['weight'] ?> Kg</b>
												dengan tujuan <b><?= $shipment['destination'] ?></b> <br>
												Jenis barang : <b><?= $shipment['pu_commodity'] ?></b> <br>
												Service : <b><?= $shipment['pu_service'] ?></b>
											</span>
											<hr>
											<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
												Informasi Tambahan : <i><b><?= $shipment['pu_note'] ?></b></i>
											</p>
										</div>
										<div class="separator separator-solid mt-2 mb-4"></div>
										<form class="position-relative" style="height: 20px;">
											<div class="position-absolute top-0 right-0 mt-n1 mr-n2">
												<a href="<?= base_url('shipper/salesOrder/receive/' . $shipment['id_so'] . '/' . $shipment['id_tracking'] . '/' . $shipment['shipment_id']) ?>" onclick='$("#modalLoading").modal("show");' class="btn text-light" style="background-color: #9c223b;">Receive Task</a>
											</div>
										</form>
										<!--edit::Editor-->
									</div>
								<?php	} elseif ($shipment['flag'] == 2) {
								?>
									<div class="card-body <?= $shipment['shipment_id'] ?>">
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
												<b>Informasi Pickup : </b> Pickup di <b> <?= $shipment['pu_poin'] ?></b> menggunakan moda
												<b><?= $shipment['pu_moda'] ?></b> jumlah koli <b><?= $shipment['koli'] ?></b> dan berat <b><?= $shipment['weight'] ?> Kg</b>
												dengan tujuan <b><?= $shipment['destination'] ?></b> <br>
												Jenis barang : <b><?= $shipment['pu_commodity'] ?></b> <br>
												Service : <b><?= $shipment['pu_service'] ?></b>
											</span>

											<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
												Informasi Tambahan : <i><b><?= $shipment['pu_note'] ?></b></i>
											</p>
										</div>
										<hr>
										<p class="h-12"><i class="fa fa-info text-danger"></i> Apabila sudah sampai, tekan tombol <i>Add Shipment</i> untuk membuat Shipment</p>
										<!-- <div class="alert alert-success text-light" role="alert"> </div> -->
										<div class="card-toolbar">
											<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('shipper/order/view/' . $shipment['id_so'] . '/' . $shipment['id_tracking']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
												<i class="fas fa-plus-circle text-light"> </i>
												Add Shipment
											</a>
										</div>
										<!--edit::Editor-->
									</div>
								<?php	} elseif ($shipment['flag'] == 3) {
								?>
									<div class="card-body <?= $shipment['shipment_id'] ?>">
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
												<b>Informasi Pickup : </b> Pickup di <b> <?= $shipment['pu_poin'] ?></b> menggunakan moda
												<b><?= $shipment['pu_moda'] ?></b> jumlah koli <b><?= $shipment['koli'] ?></b> dan berat <b><?= $shipment['weight'] ?> Kg</b>
												dengan tujuan <b><?= $shipment['destination'] ?></b> <br>
												Jenis barang : <b><?= $shipment['pu_commodity'] ?></b> <br>
												Service : <b><?= $shipment['pu_service'] ?></b>
											</span>
											<hr>
											<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
												Informasi Tambahan : <i><b><?= $shipment['pu_note'] ?></b></i>
											</p>
										</div>
										<p class="h-14 mt-4"><i class="fa fa-info text-danger"></i> Tekan tombol <b>Arrive In Benhil Hub</b>apabila sudah sampai di Hub Benhil</p>
										<!-- <div class="alert alert-success text-light" role="alert"> </div> -->
										<div class="card-toolbar">
											<a href="<?= base_url('shipper/salesOrder/arriveBenhil/' . $shipment['id_so'] . '/' . $shipment['shipment_id'] . '/' . $shipment['id_tracking']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
												<i class="fas fa-check text-light"> </i>
												Arrive In Benhil Hub
											</a>
											<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('shipper/order/view/' . $shipment['id_so'] . '/' . $shipment['id_tracking']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
												<i class="fas fa-plus-circle text-light"> </i>
												View Shipment
											</a>
										</div>
									</div>


								<?php	} elseif ($shipment['flag'] == 4) {
								?>
									<div class="card-body">
										<div>
											<p class="text-dark-150 font-size-lg font-weight-normal" style="text-align: justify;">
												<i class="fa fa-calendar-check text-success"></i> <span style="font-size: 
					15px;">No Activity Right Now </span>
											</p>
										</div>

										<!--edit::Editor-->
									</div>
								<?php	} elseif ($shipment['flag'] == 5) {
								?>
									<?php if ($shipment['status_eksekusi'] == 0) {
									?>
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div class="symbol symbol-40 mr-5 symbol-success">
													<span class="symbol-label">
														<p class="h-90 font-weight-bold mt-3">HUB</p>
													</span>
												</div>
												<div class="d-flex flex-column flex-grow-1">
													<a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder"><?= $shipment['shipper'] ?></a>
													<span class="text-muted font-weight-bold"><?= $shipment['shipment_id'] ?></span>
													<!-- <span class="text-muted font-weight-bold"><?= $shipment['update_at'] ?></span> -->
												</div>
											</div>
											<div>
												<span class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
													Hallo <?= $this->session->userdata('nama_user') ?>, Tolong antarkan barang ke Hub <b> <?= $shipment['pu_note'] ?> </b>
													jumlah koli <b><?= $shipment['koli'] ?></b> dan berat <b><?= $shipment['weight'] ?> Kg</b>
													Consignee <b><?= $shipment['consigne'] ?></b> <br>
													dengan tujuan <b><?= $shipment['destination'] ?></b> <br>
													Jenis barang : <b><?= $shipment['pu_commodity'] ?></b> <br>
													Service : <b><?= $shipment['service_name'] ?></b>
												</span>
											</div>
											<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
												<b>Informasi Tambahan :</b> <i><b><?= $shipment['pu_note'] ?></b></i> <br>
												<b>Tanggal Tugas :</b> <?= longdate_indo($shipment['tgl_tugas']) . ' ' . $shipment['jam_tugas'] ?>
											</p>
											<div class="separator separator-solid mt-2 mb-4"></div>
											<form class="position-relative" style="height: 20px;">
												<div class="position-absolute top-0 right-0 mt-n1 mr-n2">
													<a href="<?= base_url('shipper/salesOrder/receiveDeliveryHub/' . $shipment['id_tracking']) ?>" onclick='$("#modalLoading").modal("show");' class="btn text-light" style="background-color: #9c223b;">Receive Task</a>
												</div>
											</form>
											<!--edit::Editor-->
										</div>
									<?php	} else {
									?>
										<div class="card-body">
											<div>
												<p class="text-dark-150 font-size-lg font-weight-normal" style="text-align: justify;">
													<i class="fa fa-calendar-check text-success"></i> <span style="font-size: 
					15px;">On The Way To <?= $shipment['note'] ?></span>
												</p>
											</div>

											<!--edit::Editor-->
										</div>


									<?php	} ?>
								<?php	} elseif ($shipment['flag'] == 6) {
								?>
									<div class="card-body">
										<p class="h-14 mt-4"><i class="fa fa-info text-danger"></i> If your shipment have been arrived, please click the button below !</p>
										<!-- <div class="alert alert-success text-light" role="alert"> </div> -->
										<div class="card-toolbar">
											<a href="#" class="btn mr-2 text-light" data-toggle="modal" data-target="#modal-lg<?= $shipment['shipment_id'] ?>" style="background-color: #9c223b;">
												<i class="fas fa-check text-light"> </i>
												Arrive
											</a>
										</div>
									</div>
								<?php	} elseif ($shipment['flag'] == 7) {
								?>
									<div class="card-body">
										<div>
											<p class="text-dark-150 font-size-lg font-weight-normal" style="text-align: justify;">
												<i class="fa fa-calendar-check text-success"></i> <span style="font-size: 
					15px;">No Activity Right Now </span>
											</p>
										</div>

										<!--edit::Editor-->
									</div>

								<?php	} elseif ($shipment['flag'] == 9) {
								?>
									<?php if ($shipment['status_eksekusi'] == 0) {
									?>
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div class="symbol symbol-40 mr-5 symbol-success">
													<span class="symbol-label">
														<p class="h-90 font-weight-bold mt-3">DL</p>
													</span>
												</div>
												<div class="d-flex flex-column flex-grow-1">
													<a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder"><?= $shipment['shipper'] ?></a>
													<span class="text-muted font-weight-bold"><?= $shipment['shipment_id'] ?></span>
												</div>
											</div>
											<div>
												<span class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
													Hallo <?= $this->session->userdata('nama_user') ?>, Tolong Delivery ke<b> <?= $shipment['destination'] ?>, <?= $shipment['state_consigne'] ?>, <?= $shipment['city_consigne'] ?></b> <br>
													jumlah koli <b><?= $shipment['koli'] ?></b> <br>
													Service : <b><?= $shipment['service_name'] ?></b> <br>
													Consignee : <b><?= $shipment['consigne'] ?></b>
												</span>
											</div>
											<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
												<b>Informasi Tambahan :</b> <i><b><?= $shipment['note'] ?></b></i> <br>
												<b>Tanggal Tugas :</b> <?= longdate_indo($shipment['tgl_tugas']) . ' ' . $shipment['jam_tugas'] ?>
											</p>
											<div class="separator separator-solid mt-2 mb-4"></div>
											<form class="position-relative" style="height: 20px;">
												<div class="position-absolute top-0 right-0 mt-n1 mr-n2">
													<a href="<?= base_url('shipper/salesOrder/receiveDeliveryIncoming/' . $shipment['id_so'] . '/' . $shipment['shipment_id'] . '/' . $shipment['id_tracking']) ?>" onclick='$("#modalLoading").modal("show");' class="btn text-light" style="background-color: #9c223b;">Receive Task</a>
												</div>
											</form>
											<!--edit::Editor-->
										</div>
									<?php	} else {
									?>
										<div class="card-body">
											<div>
												<p class="text-dark-150 font-size-lg font-weight-normal" style="text-align: justify;">
													<i class="fa fa-calendar-check text-success"></i> <span style="font-size: 
					15px;">On The Way To <?= $shipment['note'] ?></span>
												</p>
											</div>

											<!--edit::Editor-->
										</div>


									<?php	} ?>

								<?php	} elseif ($shipment['flag'] == 10) {
								?>
									<div class="card-body">
										<div class="d-flex align-items-center">
											<div class="symbol symbol-40 mr-5 symbol-success">
												<span class="symbol-label">
													<p class="h-90 font-weight-bold mt-3">DL</p>
												</span>
											</div>
											<div class="d-flex flex-column flex-grow-1">
												<a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder"><?= $shipment['shipper'] ?></a>
												<span class="text-muted font-weight-bold"><?= $shipment['shipment_id'] ?></span>
											</div>
										</div>
										<div>
											<span class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
												Hallo <?= $this->session->userdata('nama_user') ?>, Tolong Delivery ke<b> <?= $shipment['destination'] ?>, <?= $shipment['state_consigne'] ?>, <?= $shipment['city_consigne'] ?></b> <br>
												jumlah koli <b><?= $shipment['koli'] ?></b> <br>
												Service : <b><?= $shipment['service_name'] ?></b> <br>
												Consignee : <b><?= $shipment['consigne'] ?></b>
											</span>
										</div>
										<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
											<b>Informasi Tambahan :</b> <i><b><?= $shipment['note'] ?></b></i> <br>
											<b>Tanggal Tugas :</b> <?= longdate_indo($shipment['tgl_tugas']) . ' ' . $shipment['jam_tugas'] ?>
										</p>
										<hr>
										<p class="h-14 mt-4"><i class="fa fa-info text-danger"></i> Tekan tombol <b>Arrive</b> Jika Kiriman Anda sudah sampai di tujuan</p>
										<!-- <div class="alert alert-success text-light" role="alert"> </div> -->
										<div class="card-toolbar">
											<a href="#" class="btn mr-2 text-light" data-toggle="modal" data-target="#modal-lg-incoming<?= $shipment['shipment_id'] ?>" style="background-color: #9c223b;">
												<i class="fas fa-check text-light"> </i>
												Arrive
											</a>
										</div>
									</div>

								<?php	} else {
								?>
									<div class="card-body">
										<div>
											<p class="text-dark-150 font-size-lg font-weight-normal" style="text-align: justify;">
												<i class="fa fa-calendar-check text-success"></i> <span style="font-size: 
					15px;">No Activity Right Now </span>
											</p>
										</div>

										<!--edit::Editor-->
									</div>
								<?php	} ?>

								<!--end::Body-->
							</div>
						<?php	} ?>
					</div>

				<?php	} ?>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!--/. container-fluid -->
	</section>
	<!-- /.content -->

	<?php foreach ($shipments as $shipment) {
	?>
		<div class="modal fade" id="modal-lg<?= $shipment['shipment_id'] ?>">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Input Consignee with QC <b><?= $shipment['shipment_id'] ?></b> </h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="<?= base_url('shipper/salesOrder/arriveCustomer/' . $shipment['id_so'] . '/' . $shipment['shipment_id']) ?>" method="POST" enctype="multipart/form-data">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="exampleInputEmail1">Consignee <span style="color: red;">*</span></label>
											<input type="text" class="form-control" required name="consignee">
										</div>

									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInputEmail1">POD</label>
											<input type="file" name="awal" id="attachment<?= $shipment['shipment_id'] ?>" onchange="handleImageUploadTracker(this.id);" accept="image/*" required capture>
											<input type="file" class="form-control" id="upload_file-attachment<?= $shipment['shipment_id'] ?>" name="ktp[]" accept="image/*" hidden>

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
	<!-- /.modal -->


	<?php foreach ($shipments as $shipment) {
	?>
		<div class="modal fade" id="modal-lg-incoming<?= $shipment['shipment_id'] ?>">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Input Consignee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="<?= base_url('shipper/salesOrder/arriveCustomerIncoming/' . $shipment['id_so'] . '/' . $shipment['shipment_id'] . '/' . $shipment['id_tracking']) ?>" method="POST" enctype="multipart/form-data">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="exampleInputEmail1">Consignee <span style="color: red;">*</span></label>
											<input type="text" class="form-control" required name="consignee">
										</div>

									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInputEmail1">POD</label>
											<input type="file" name="awal" id="attachmentincoming<?= $shipment['shipment_id'] ?>" onchange="handleImageUploadTracker(this.id);" accept="image/*" required capture>
											<input type="file" class="form-control" id="upload_file-attachmentincoming<?= $shipment['shipment_id'] ?>" name="ktp[]" accept="image/*" hidden>

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
		<!-- /.modal -->

	<?php } ?>


	<?php foreach ($shipments as $shipment) {
	?>
		<div class="modal fade" id="modal-lg-ons<?= $shipment['shipment_id'] ?>">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Input Consignee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="<?= base_url('shipper/salesOrder/arriveCustomerOns/' . $shipment['id_so'] . '/' . $shipment['shipment_id'] . '/' . $shipment['id_tracking']) ?>" method="POST" enctype="multipart/form-data">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="exampleInputEmail1">Consignee <span style="color: red;">*</span></label>
											<input type="text" class="form-control" required name="consignee">
										</div>

									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInputEmail1">POD</label>
											<!-- <input type="file" class="form-control" name="ktp"> -->
											<input type="file" name="awal" id="attachmentons<?= $shipment['shipment_id'] ?>" onchange="handleImageUploadTracker(this.id);" accept="image/*" required capture>
											<input type="file" class="form-control" id="upload_file-attachmentons<?= $shipment['shipment_id'] ?>" name="ktp[]" accept="image/*" hidden>
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
		<!-- /.modal -->

	<?php } ?>