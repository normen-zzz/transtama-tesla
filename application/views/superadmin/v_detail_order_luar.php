	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch">
						<div class="card-header py-3">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bolder text-dark">Detail Sales Order </h3>
								<!-- <span class="text-muted font-weight-bold font-size-sm mt-1">Shipment ID :<b> <?= $p['shipment_id'] ?></b></span>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Order ID :<b> <?= $p['order_id'] ?></b></span> -->
							</div>
							<div class="card-toolbar">
								<a href="<?= base_url('superadmin/salesOrder') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
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
											<!-- <td>Status</td>
											<td><b>:<?= ($p['status'] == 0) ? 'Process' : 'Selesai';   ?></b> </td> -->
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
										<h4 class="title"></h4>
									</div>

									<?php	} else {
									if ($p['status'] == 5) {
										echo "<h3>Cancel Request</h3> <br> <p>Reason : $p[alasan_cancel]</p>";
									} else {
									?>
										<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
										<!-- <div class="col-md-4">
										<a href="<?= base_url('superadmin/salesOrder/add/' . $p['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
											<i class="fas fa-plus-circle text-light"> </i>
											Single Order
										</a>
										<a href="<?= base_url('superadmin/salesOrder/bulk/' . $p['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
											<i class="fas fa-plus-circle text-light"> </i>
											Bulk Order
										</a>

									</div> -->

								<?php	}
								} ?>

							</div>

							<table id="myTable" class="table table-bordered">
								<div class="row">
									<div class="col-md-10">
										<h3 class="title font-weight-bold">List Shipment</h3>

									</div>
									<div class="col-md-2 mt-4">
										<a href="<?= base_url('superadmin/order/printAll/' . $p['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
											<i class="fas fa-print text-light"> </i>
											Print All
										</a>

									</div>
								</div>
								<!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
								<p><?= $this->session->flashdata('message'); ?></p>
								<thead>
									<tr>
										<th style="width: 10%;">Shipment ID</th>
										<th style="width: 15%;">Shipper</th>
										<th>Destination</th>
										<th style="width: 15%;">Consignee</th>
										<th style="width: 20%;">Status Delete</th>
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
											<td><a href="<?= base_url('superadmin/salesOrder/print/' . $shp['shipment_id']) ?>"> <?= $shp['shipment_id'] ?></a></td>
											<td><?= $shp['shipper'] ?></td>
											<td><?= $shp['destination'] ?>, <?= $shp['city_consigne'] ?> <?= $shp['state_consigne'] ?></td>
											<td><?= $shp['consigne'] ?></td>
											<td><?php if ($shp['deleted'] == 0) {
													echo 'Shipment Success';
												} else {
													echo 'Shipment Delete <br> Reason: ' . $shp['reason_delete'];
												} ?></td>
											<td style="color: green;"><?= $get_last_status['status'] ?> <br> <?= longdate_indo($get_last_status['created_at']), ' ' . $get_last_status['time'] ?>
												<br>
												<?php if ($get_last_status['flag'] == 11 || $get_last_status['flag'] == 5) {
												?>
													<a href="#" class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#modal-pod<?= $shp['shipment_id'] ?>" style="background-color: #9c223b;">
														<span class="svg-icon svg-icon-md">
														</span>View POD</a>
												<?php	} ?>

											</td>
											<td>

												<a href="<?= base_url('superadmin/order/detail/' . $shp['id'] . '/' . $shp['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
												<a href="#" class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#modal-delete<?= $shp['shipment_id'] ?>" style="background-color: #9c223b;">
													<span class="svg-icon svg-icon-md">
													</span>Delete</a>
												<!-- <a href="<?= base_url('superadmin/order/delete/' . $shp['id'] . '/' . $shp['id_so']) ?>" onclick="return confirm('Are Your Sure ?')" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Delete</a> -->

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

	

	

	


	<?php foreach ($shipment2 as $shp) {
	?>
		<div class="modal fade" id="modal-delete<?= $shp['shipment_id'] ?>">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Delete <b><?= $shp['shipment_id'] ?></b> </h4>

						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="<?= base_url('superadmin/order/delete') ?>" method="POST" enctype="multipart/form-data">
							<div class="card-body">
								<div class="row">
									<input type="text" name="id_so" class="form-control" hidden value="<?= $p['id_so'] ?>">
									<input type="text" name="id_order" class="form-control" hidden value="<?= $shp['id'] ?>">

									<div class="col-md-12">
										<div class="form-group">
											<label for="exampleInputPassword1">Reason To Delete & User Request</label>
											<textarea type="text" class="form-control" required name="reason_delete"></textarea>
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