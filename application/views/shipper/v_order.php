	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch">
						<div class="card-header py-3">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bolder text-dark">Orders Information</h3>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Input Your Order Information</span>
							</div>
							<div class="card-toolbar">
								<a href="<?= base_url('shipper/order/add/' . $id_so . '/' . $id_tracking) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-plus-circle text-light"> </i>
									Single Order
								</a>

								<?php if ($so['type'] == 1) {
								?>
									<a href="<?= base_url('shipper/order/special/' . $id_so . '/' . $id_tracking) ?>" class="btn mr-2 mt-1 text-light" style="background-color: #9c223b;">
										<i class="fas fa-plus-circle text-light"> </i>
										Special Order
									</a>
								<?php	} else {
								?>
									<a href="<?= base_url('shipper/order/bulk/' . $id_so . '/' . $id_tracking) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
										<i class="fas fa-plus-circle text-light"> </i>
										Bulk Order
									</a>

								<?php	} ?>

							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<table id="myTable" class="table table-bordered">
								<div class="col-md-12 mt-4">
									<a href="<?= base_url('shipper/order/printAll/' . $id_so) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
										<i class="fas fa-print text-light"> </i>
										Print All
									</a>
									<a href="<?= base_url('shipper/order/completeTtd/' . $id_so . '/' . $id_tracking) ?>" class="btn mr-2 text-light mt-1" style="background-color: #9c223b;">
										<i class="fas fa-print text-light"> </i>
										Complete TTD & POP
									</a>

								</div>
								<!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
								<p><?= $this->session->flashdata('message'); ?></p>
								<thead>
									<tr>
										<th style="width: 15%;">Shipment ID</th>
										<th style="width: 20%;">Shipper</th>
										<th style="width: 20%;">Consignee</th>
										<th>Created At</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($order as $o) {
									?>
										<tr>
											<td><a href="<?= base_url('shipper/order/print/' . $o['shipment_id']) ?>"><?= $o['shipment_id'] ?></a> <br> <?= $o['service_name'] ?> </td>
											<td><?= $o['shipper'] ?> <br> <?= $o['tree_shipper'] ?>-<?= $o['tree_consignee'] ?></td>
											<td><?= $o['consigne'] ?></td>
											<td><?= $o['created_at'] ?></td>
											<td>
												<a href="<?= base_url('shipper/order/detail/' . $o['id'] . '/' . $o['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
												<a href="<?= base_url('shipper/order/edit/' . $o['id'] . '/' . $o['id_so'] . '/' . $id_tracking) ?>" class="btn btn-sm text-light ml-2" style="background-color: #9c223b;">Edit</a>
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