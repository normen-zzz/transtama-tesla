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
								<a href="<?= base_url('finance/salesOrder') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
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
								?>
									<div class="col-md-4">
										<h4 class="title"></h4>
									</div>

								<?php	} else {
								?>
									<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
									<div class="col-md-4">
										<a href="<?= base_url('cs/salesOrder/add/' . $p['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
											<i class="fas fa-plus-circle text-light"> </i>
											Single Order
										</a>
										<a href="<?= base_url('cs/salesOrder/bulk/' . $p['id_so']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
											<i class="fas fa-plus-circle text-light"> </i>
											Bulk Order
										</a>

									</div>

								<?php	} ?>

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