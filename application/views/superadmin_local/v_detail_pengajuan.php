	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch">
						<div class="card-header py-3">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bolder text-dark">Detail Order </h3>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Shipment ID :<b> <?= $p['shipment_id'] ?></b></span>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Order ID :<b> <?= $p['order_id'] ?></b></span>
							</div>
							<div class="card-toolbar">
								<a href="<?= base_url('superadmin/order') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-chevron-circle-left text-light"> </i>
									Back
								</a>
							</div>
						</div>

						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<div class="row">
								<div class="col-md-6 mb-3">
									<b>Shipper &nbsp;&nbsp;&nbsp; :</b> <b><?= $p['shipper'] ?>, <?= $p['city_shipper'] ?>, <?= $p['state_shipper'] ?></b>
								</div>
								<div class="col-md-6 mb-3">
									<b>Consigne &nbsp;&nbsp;: <?= $p['consigne'] ?>, <?= $p['city_consigne'] ?>, <?= $p['state_consigne'] ?></b>
								</div>
								<div class="col-md-6 mb-3">
									<b>Image :</b> <img src="<?= base_url('uploads/berkas/') . $p['image'] ?>" height="100" width="200">
								</div>
								<div class="col-md-6">
									<b>Signature : </b> <img src="data:<?= $p['signature']; ?>" height="80" width="200" alt="">
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


	<div class="modal fade" id="modalDetail">
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
									<b>Shipper &nbsp;&nbsp;&nbsp; :</b> <b><?= $p['shipper'] ?>, <?= $p['city_shipper'] ?>, <?= $p['state_shipper'] ?></b>
								</div>
								<div class="col-md-6 mb-3">
									<b>Consigne &nbsp;&nbsp;: <?= $p['consigne'] ?>, <?= $p['city_consigne'] ?>, <?= $p['state_consigne'] ?></b>
								</div>
								<div class="col-md-6 mb-3">
									<b>Order ID &nbsp;&nbsp;&nbsp;: <?= $p['order_id'] ?></b>
								</div>
								<div class="col-md-6 mb-3">
									<b>Image :</b> <img src="<?= base_url('uploads/berkas/') . $p['image'] ?>" height="100" width="200">
								</div>
								<div class="col-md-6">
									<b>Signature : </b> <img src="data:<?= $p['signature']; ?>" height="80" width="200" alt="">
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