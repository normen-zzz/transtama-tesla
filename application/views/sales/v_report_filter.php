	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h2 class="card-title">Report Order <?= bulan_indo($awal) . ' - ' . bulan_indo($akhir) ?>

								<div class="row">
									<form action="<?= base_url('sales/salesOrder/filterLaporan') ?>" method="POST">
										<h6 class="title">Filter By Pickup Date</h6>
										<div class="row ml-2">
											<div class="form-group">
												<label>Start</label><br>
												<input type="date" class="form-control" name="awal" value="<?= $awal ?>">
											</div>
											<div class="form-group ml-2">
												<label>From</label><br>
												<input type="date" class="form-control" name="akhir" value="<?= $akhir ?>">
											</div>

											<div class="form-group"> <br>
												<button type="submit" class="btn btn-success ml-3">Show</button>
												<a href="<?= base_url('sales/salesOrder/report') ?>" class="btn btn-primary ml-1">Reset Filter</a>
												<a target="blank" href="<?= base_url('sales/salesOrder/exportexcel/' . $awal . '/' . $akhir) ?>" class="btn btn-sm btn-danger ml-2">Export All</a>
											</div>
										</div>

									</form>
								</div>
						</div>

						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<table id="myTable" class="table table-bordered">
								<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
								<p style="color:red"><?= $this->session->flashdata('message'); ?></p>
								<thead>
									<tr>
										<th style="width: 15%;">Pickup Date</th>
										<th style="width: 15%;">Customer</th>
										<th style="width: 15%;">Consignee</th>
										<th style="width: 15%;">Driver</th>
										<th style="width: 10%;">Shipment ID</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($order as $p) {

									?>
										<tr>
											<td><?= bulan_indo($p['tgl_pickup']) ?></td>
											<td><?= $p['shipper'] ?></td>
											<td><?= $p['consigne'] ?></td>
											<td><?= $p['nama_user'] ?></td>
											<td> <a href="<?= base_url('sales/salesOrder/print/' . $p['shipment_id']) ?>"><?= $p['shipment_id'] ?> </a> </td>

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