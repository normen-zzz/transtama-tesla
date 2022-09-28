	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h2 class="card-title">Report Order
								<?php if ($start == 'null' && $start == 'null') {
									echo '';
								} else {
									echo bulan_indo($start) . '-' . bulan_indo($end);
								} ?>
							</h2>
							<form method="POST" action="<?= base_url() ?>superadmin/order/filterLaporan" id="reportBerdasarkan">
								<div class="row">
									<div class="col-md-2">
										<b>Filter Tanggal</b>

									</div>
									<div class="col-md-4">

										<div class="align-items-center" style="margin-top: -5px;">
											<div class="mt-4">
												<!-- <label class="sr-only" for="inlineFormInput"></label> -->
												Dari<input type="date" name="start" class="form-control" id="inlineFormInput">
											</div>

											<div class="mt-2">
												<!-- <label class="sr-only" for="inlineFormInput"></label> -->
												Sampai <input type="date" name="end" class="form-control" id="inlineFormInput">

											</div>

										</div>
									</div>
									<div class="col-md-2">
										<b>Filter Driver</b>
									</div>
									<div class="col-md-4 mt-2">
										<div class="form-row align-items-center" style="margin-top: -5px;">
											<select name="id_user" class="form-control">
												<option value="0">-All-</option>
												<?php foreach ($users as $u) {
												?>
													<option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
												<?php } ?>
											</select>

										</div>

									</div>

								</div>

								<div class="col-md-12">

									<button type="submit" class="btn btn-sm btn-success mt-2" id="submit">Tampilkan</button>
									<a href="<?= base_url() ?>superadmin/order/report" class="btn btn-sm btn-primary mt-2">Reset Filter</a>

									<?php if (isset($start) && isset($end) && isset($id_user)) { ?>
										<a href="<?= base_url('superadmin/order/print/' . $start . '/' . $end . '/' . $id_user) ?>" class="btn btn-sm btn-danger mt-2">Print</a>
									<?php } elseif (isset($start) && isset($end)) { ?>
										<!-- <a href="<?= base_url('superadmin/order/print/' . $start . '/' . $end) ?>" class="btn btn-sm btn-danger mt-2">Print</a> -->
										<!-- <a href="<?= base_url('superadmin/order/print/' . $start . '/' . $end) ?>" class="btn btn-sm btn-danger mt-2">Print</a> -->
										<a href="<?= base_url('superadmin/order/exportexcel/' . $start . '/' . $end) ?>" class="btn btn-sm btn-danger mt-2">Print</a>
										<!-- <a href="<?= base_url() ?>superadmin/order/Exportexcel" class="btn btn-sm btn-danger mt-2">Print Excell</a> -->
									<?php } else {
									?>
										<!-- <a href="<?= base_url() ?>superadmin/order/print" class="btn btn-sm btn-danger mt-2">Cetak</a> -->
									<?php } ?>

								</div>

							</form>
						</div>

						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<table id="myTable" class="table table-bordered">
								<!-- <a href="<?= base_url('shipper/order/add') ?>" class="btn btn-success mr-2 mb-4">
									<i class="fas fa-plus-circle"> </i>Add
								</a> -->
								<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
								<p style="color:red"><?= $this->session->flashdata('message'); ?></p>
								<thead>
									<tr>
										<th style="width: 15%;">Driver</th>
										<!-- <th style="width: 20%;">Shipper</th> -->
										<!-- <th style="width: 20%;">Consigne</th> -->
										<th style="width: 10%;">Shipment ID</th>
										<!-- <th style="width: 10%;">Order ID</th> -->
										<!-- <th style="width: 20%;">Image</th> -->
										<!-- <th>Signature</th> -->
										<th>Created At</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($order as $p) {

									?>
										<tr>
											<td><?= $p['nama_user'] ?></td>
											<!-- <td><b><?= $p['shipper'] ?></b> <br><?= $p['city_shipper'] ?>, <?= $p['state_shipper'] ?> </td> -->
											<!-- <td><b><?= $p['consigne'] ?></b> <br><?= $p['city_consigne'] ?>, <?= $p['state_consigne'] ?> </td> -->
											<td> <a href="<?= base_url('uploads/barcode/' . $p['shipment_id']) ?>.pdf"><?= $p['shipment_id'] ?> </a> </td>
											<!-- <td><?= $p['order_id'] ?></td> -->
											<!-- <td> <a href="<?= base_url('uploads/berkas/') . $p['image'] ?>">View</a> </td> -->
											<!-- <td> <img src="data:<?= $p['signature']; ?>" height="80" width="200" alt=""></td> -->
											<td><?= bulan_indo($p['created_at']) ?></td>
											<td>
												<button type="button" class="btn btn-sm text-light" data-toggle="modal" data-target="#modalDetail<?= $p['id'] ?>" style="background-color: #9c223b;">Detail</button>
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



	<?php foreach ($order as $p) { ?>
		<div class="modal fade" id="modalDetail<?= $p['id'] ?>">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Detail Order Shipment ID : <b> <?= $p['shipment_id'] ?></b></h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="#" method="POST">
							<div class="card-body">
								<div class="row">
									<div class="col-md-6 mb-3">
										Shipper &nbsp;&nbsp;&nbsp;: <b><?= $p['shipper'] ?>, <?= $p['city_shipper'] ?>, <?= $p['state_shipper'] ?></b>
									</div>
									<div class="col-md-6 mb-3">
										Consigne &nbsp;&nbsp;: <b> <?= $p['consigne'] ?>, <?= $p['city_consigne'] ?>, <?= $p['state_consigne'] ?></b>
									</div>
									<div class="col-md-6 mb-3">
										Order ID &nbsp;&nbsp;&nbsp;: <b><?= $p['order_id'] ?></b>
									</div>
									<div class="col-md-6 mb-3">
										Image &nbsp;&nbsp;&nbsp;&nbsp;: <img src="<?= base_url('uploads/berkas/') . $p['image'] ?>" height="100" width="200">
									</div>
									<div class="col-md-6">
										Signature &nbsp;&nbsp;&nbsp;: <img src="data:<?= $p['signature']; ?>" height="80" width="200" alt="">
									</div>
								</div>

							</div>
							<!-- /.card-body -->


					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn text-light" data-dismiss="modal" style="background-color: #9c223b;">Close</button>

					</div>
					</form>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

	<?php } ?>