	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch">
						<div class="card-header py-3">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bolder text-dark">Sales Order</h3>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Order Information</span>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<table id="myTable" class="table table-bordered">
								<!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
								<p><?= $this->session->flashdata('message'); ?></p>
								<thead>
									<tr>
										<th style="width: 15%;">Sales</th>
										<th style="width: 15%;">PU. Date</th>
										<th style="width: 15%;">Time</th>
										<th style="width: 30%;">Shipper</th>
										<th style="width: 15%;">Destination</th>
										<th>Last Status</th>
										<th style="width: 15%;">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($so as $s) {
									?>
										<tr>
											<td><?= $s['nama_user'] ?></td>
											<td><?= longdate_indo($s['tgl_pickup']) ?></td>
											<td><?= $s['time'] ?></td>
											<td><?= $s['shipper'] ?></td>
											<td><?= $s['destination'] ?></td>
											<td><?php if ($s['status_approve'] == 0) {
												?>
													<span class="label label-danger label-inline font-weight-lighter" style="width: 100px;">Order Masuk</span>
												<?php	} elseif ($s['status_approve'] == 1) {
												?>
													<span class="label label-primary label-inline font-weight-lighter" style="width: 120px;">Approve Manager</span>
												<?php	} elseif ($s['status_approve'] == 2) {
												?>
													<span class="label label-purple label-inline font-weight-lighter" style="width: 100px;">Approve Cs</span>
												<?php	} elseif ($s['status_approve'] == 3) {
												?>
													<span class="label label-success label-inline font-weight-lighter" style="width: 100px;">Approve Finance</span>
												<?php	} ?>
											</td>
											<td>
												<?php
												$id_atasan = $this->session->userdata('id_atasan');
												$get_approve = $this->db->get_where('tbl_approve_so', ['id_so' => $s['id_so']])->row_array();
												$get_cs_approve = $get_approve['approve_finance'];
												// var_dump($get_cs_approve);
												// die;
												if ($get_cs_approve == NULL || $get_cs_approve == 0) {
													if ($id_atasan == NULL || $id_atasan == 0) {
												?>
														<a href="<?= base_url('finance/salesOrder/detail/' . $s['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
														<a href="<?= base_url('finance/salesOrder/approve/' . $s['id_so']) ?>" onclick="return confirm('Are You Sure ?')" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Approve</a>

													<?php	} else {
													?>
														<a href="<?= base_url('finance/salesOrder/detail/' . $s['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
													<?php	}
													?>
												<?php	} else {
												?>
													<a href="<?= base_url('finance/salesOrder/detail/' . $s['id_so']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>

												<?php	}
												?>
											</td>
										</tr>

									<?php	} ?>
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