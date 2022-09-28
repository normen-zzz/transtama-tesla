	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<!-- cek apakah dia jabodetabek -->
					<?php foreach ($shipments as $shipment) {
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
											<a href="<?= base_url('shipper/salesOrder/receive/' . $shipment['id_so'] . '/' . $shipment['id_tracking']) ?>" onclick="return confirm('You will accept this Request')" class="btn text-light" style="background-color: #9c223b;">Receive Task</a>
										</div>
									</form>
									<!--edit::Editor-->
								</div>
							<?php    } elseif ($shipment['flag'] == 2) {
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
											<b>Informasi Pickup </b> : Pickup di <b> <?= $shipment['pu_poin'] ?></b> menggunakan moda
											<b><?= $shipment['pu_moda'] ?></b> jumlah koli <b><?= $shipment['koli'] ?></b> dan berat <b><?= $shipment['kg'] ?> Kg</b>
											dengan tujuan <b><?= $shipment['destination'] ?></b> <br>
											Jenis barang : <b><?= $shipment['commodity'] ?></b> <br>
											Service : <b><?= $shipment['service'] ?></b>
										</span>
										<p class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
											Informasi Tambahan : <i><b><?= $shipment['note'] ?></b></i>
										</p>
										<hr>
									</div>
									<p class="h-12"><i class="fa fa-info text-danger"></i> Apabila sudah sampai, tekan tombol <i>Add Shipment</i> untuk membuat Shipment</p>
									<!-- <div class="alert alert-success text-light" role="alert"> </div> -->
									<div class="card-toolbar">
										<a href="<?= base_url('shipper/order/view/' . $shipment['id_so'] . '/' . $shipment['id_tracking']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
											<i class="fas fa-plus-circle text-light"> </i>
											Add Shipment
										</a>
									</div>
									<!--edit::Editor-->
								</div>

							<?php    } elseif ($shipment['flag'] == 3) {
							?>
								<div class="card-body">
									<p class="h-14 mt-4"><i class="fa fa-info text-danger"></i> If you have input shipment, please click the button below !</p>
									<!-- <div class="alert alert-success text-light" role="alert"> </div> -->
									<div class="card-toolbar">
										<a href="<?= base_url('shipper/salesOrder/arriveBenhil/' . $shipment['id_so'] . '/' . $shipment['shipment_id']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
											<i class="fas fa-check text-light"> </i>
											Arrive In Benhil Hub
										</a>
										<a href="<?= base_url('shipper/order/view/' . $shipment['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
											<i class="fas fa-plus-circle text-light"> </i>
											View Shipment
										</a>
									</div>
								</div>


							<?php    } elseif ($shipment['flag'] == 4) {
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
							<?php    } elseif ($shipment['flag'] == 5) {
							?>
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-40 mr-5 symbol-success">
											<span class="symbol-label">
												<p class="h-90 font-weight-bold mt-3">DL</p>
											</span>
										</div>
										<div class="d-flex flex-column flex-grow-1">
											<a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder"><?= $shipment['consigne'] ?></a>
											<span class="text-muted font-weight-bold"><?= $shipment['shipment_id'] ?></span>
										</div>
									</div>
									<div>
										<span class="text-dark-75 font-size-lg font-weight-normal" style="text-align: justify;">
											Hallo <?= $this->session->userdata('nama_user') ?>, Tolong Delivery ke<b> <?= $shipment['destination'] ?>, <?= $shipment['state_consigne'] ?>, <?= $shipment['city_consigne'] ?></b> <br>
											jumlah koli <b><?= $shipment['koli'] ?></b> dengan
											Service : <b><?= $shipment['service_name'] ?></b>
										</span>
									</div>
									<div class="separator separator-solid mt-2 mb-4"></div>
									<form class="position-relative" style="height: 20px;">
										<div class="position-absolute top-0 right-0 mt-n1 mr-n2">
											<a href="<?= base_url('shipper/salesOrder/receiveDelivery/' . $shipment['id_so'] . '/' . $shipment['shipment_id']) ?>" onclick="return confirm('You will accept this Request')" class="btn text-light" style="background-color: #9c223b;">Receive Task</a>
										</div>
									</form>
									<!--edit::Editor-->
								</div>
							<?php    } elseif ($shipment['flag'] == 6) {
							?>
								<div class="card-body">
									<p class="h-14 mt-4"><i class="fa fa-info text-danger"></i> If your shipment have been arrived, please click the button below !</p>
									<!-- <div class="alert alert-success text-light" role="alert"> </div> -->
									<div class="card-toolbar">
										<a href="#" class="btn mr-2 text-light" data-toggle="modal" data-target="#modal-lg" style="background-color: #9c223b;">
											<i class="fas fa-check text-light"> </i>
											Arrive
										</a>
									</div>
								</div>
							<?php    } elseif ($shipment['flag'] == 7) {
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

							<?php    } ?>

							<!--end::Body-->
						</div>
					<?php	} ?>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!--/. container-fluid -->
	</section>
	<!-- /.content -->


	<div class="modal fade" id="modal-lg">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Input Consignee</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('shipper/salesOrder/arriveCustomer/' . $shipment['id_so'] . '/' . $shipment['shipment_id']) ?>" method="POST">
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="exampleInputEmail1">Consignee <span style="color: red;">*</span></label>
										<input type="text" class="form-control" required name="consignee">
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