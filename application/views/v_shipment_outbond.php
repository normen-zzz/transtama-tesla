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
										<select class="form-control" id="camera-select" style="width: 80%;"></select>
									</div>

								</div>
							</div>
							<div class="col-md-6">
								<div class="well" style="position: middle;">
									<form action="<?php echo base_url('scan1/cek_id'); ?>" method="POST">
										<canvas id="cobascanOPS" width="400" height="400" id="webcodecam-canvas"></canvas>
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
											<th style="width: 5%;">Last Milestone</th>
											<th>Status</th>
											<th>Action</th>

										</tr>
									</thead>
									<tbody>
										<?php foreach ($gateway as $g) {
											$cekLastMilestone = $this->db->limit(1)->order_by('id_tracking', 'desc')->get_where('tbl_tracking_real', ['shipment_id' => $g['shipment_id']])->row_array();
											if ($cekLastMilestone['flag'] == 4) {
										?>
												<tr>
													<td><?= $g['shipment_id'] ?></td>
													<td><?= $g['shipper'] ?><br><?= $g['tree_shipper'] ?></td>
													<td><?= $g['consigne'] ?><br><?= $g['tree_consignee'] ?></td>
													<td><?= $cekLastMilestone['status'] ?></td>
													<td><?= ($g['status_eksekusi'] == 1) ? '<span class="btn btn-sm btn-success">Success</span> <br>' . $g['created_at'] . ' ' : '<span class="btn btn-sm btn-danger">Pending</span><br>' . $g['created_at'] . ' '; ?></td>
													<!-- <td><?= $g['created_at'] ?></td> -->
													<td>
														<?php if ($g['status_eksekusi'] == 0) {
														?>
															<a href="#" class="btn btn-sm text-light btn-edit" data-id="<?= $g['shipment_id']; ?>" style="background-color: #9c223b;">Update</a>
														<?php } else {
															echo '-';
														} ?>
													</td>
												</tr>

										<?php }
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