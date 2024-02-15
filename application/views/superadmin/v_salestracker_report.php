<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<!-- Main content -->
<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="container">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h2 class="card-title">Report Order
							<div class="row">
								<form action="<?= base_url('superadmin/SalesTracker/index') ?>" method="POST">
									<div class="row ml-2">
										<div class="form-group mr-2">
											<label>Start</label><br>
											<input type="datetime-local" <?php if ($awal != NULL) { ?> value="<?= $awal ?>" <?php } ?> name="awal" id="awal" class="form-control">


										</div>
										<div class="form-group mr-3">
											<label>End</label> <br>
											<input type="datetime-local" <?php if ($akhir != NULL) { ?> value="<?= $akhir ?>" <?php } ?> name="akhir" id="akhir" class="form-control">
										</div>
										<div class="form-group">
											<label>Sales</label> <br>
											<select name="sales" class="form-control" style="width: 200px; height:20px">
												<option <?php if ($sales == 0) {
															echo 'selected';
														} ?> value="0">All Sales</option>
												<?php foreach ($users as $u) {
												?>
													<option <?php if ($sales == $u['id_user']) {
																echo 'selected';
															} ?> value="<?= $u['id_user'] ?>"><?= $u['username'] ?></option>
												<?php } ?>
											</select>
										</div>

										<div class="form-group"> <br>
											<button type="submit" class="btn btn-success mt-4 ml-3">Tampilkan</button>
											<a href="<?= base_url('superadmin/SalesTracker') ?>" class="btn btn-primary mt-4 ml-1">Reset Filter</a>
										</div>
									</div>

								</form>
							</div>
							<!-- <button class="btn btn-icon waves-effect waves-light btn-success mb-4" data-toggle="modal" data-target="#addBukti"> <i class="fas fa-plus"></i> Lakukan Pembayaran Sample </button> -->

							<!-- <div class="row">
									<a target="blank" href="<?= base_url('superadmin/order/exportexcel/null/null/0') ?>" class="btn btn-sm btn-danger mb-3 ml-2">Export Laporan Keseluruhan</a>
								</div> -->
							<br>



					</div>

					<!-- /.card-header -->
					<div class="card-body" style="overflow: auto;">
						<div class="row text-center">
							<div class="col-xl-4 col-md-6">
								<h4>TOTAL REPORT</h4>
								<input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#35b8e0" data-bgColor="#98a6ad" data-max="<?= $salestracker->num_rows() ?>" value="<?= $salestracker->num_rows() ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" class="dial" />

							</div><!-- end col -->
							<div class="col-xl-4 col-md-6">
								<h4>TOTAL ON GOING</h4>
								<input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#f05050 " data-bgColor="#F9B9B9" data-max="<?= $salestracker->num_rows() ?>" value="<?= $ongoing ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" class="dial" />

							</div><!-- end col -->
							<div class="col-xl-4 col-md-6">
								<h4>TOTAL HELD</h4>
								<input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#00FF00" data-bgColor="#98a6ad" data-max="<?= $salestracker->num_rows() ?>" value="<?= $held ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" class="dial" />

							</div><!-- end col -->
						</div>
						<table  class="table table-bordered" id="myTableSalesTracker">
							<!-- <a href="<?= base_url('shipper/order/add') ?>" class="btn btn-success mr-2 mb-4">
									<i class="fas fa-plus-circle"> </i>Add
								</a> -->
							<!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
							<p><?= $this->session->flashdata('message'); ?></p>
							<thead>
								<tr>
									<th style="width: 15%;">Sales</th>
									<th style="width: 15%;">Subject</th>
									<th style="width: 15%;">Description</th>
									<th style="width: 10%;">Location</th>
									<th>Created At</th>
									<th>Start Date</th>
									<th>End Date</th>
									<th>PIC</th>
									<th>summary</th>
									<!-- <th>image</th> -->
									<th>Status</th>
									<th>Image</th>
									<!-- <th>Action</th> -->
								</tr>
							</thead>
							<tbody>
								<?php foreach ($salestracker->result_array() as $s) { ?>
									<tr>
										<td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?= $s['nama_user'] ?></td>
										<td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?= $s['subject'] ?></td>
										<td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?= $s['description'] ?></td>
										<td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?= $s['location'] ?></td>
										<td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?= date('D d/m/Y H:i:s', strtotime($s['dibuat'])) ?></td>
										<td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?= date('D d/m/Y H:i:s', strtotime($s['start_date'])) ?></td>
										<td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?php if ($s['end_date'] != NULL) {
																														echo date('D d/m/Y H:i:s', strtotime($s['end_date']));
																													} ?></td>
										<td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?= $s['contact'] ?></td>
										<td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?= $s['summary'] ?></td>
										<!-- <td><img src="<?= base_url('uploads/salestracker/' . $s['image']) ?>" alt="" srcset="" width="70px"></td> -->
										<td><?php if ($s['end_date'] == NULL) { ?> <span class="badge badge-danger">On Going</span> <?php } else { ?> <span class="badge badge-success">held</span> <?php } ?></td>
										<td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?php if ($s['image'] != NULL) {

																													?><a href="<?= base_url('uploads/salestracker/' . $s['image']) ?>" target="_blank">foto</a></td>
									<?php } ?>
									</tr>
								<?php
								} ?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="10" class="text-center"><b>TOTAL : <?= $salestracker->num_rows() ?> Data</b></td>
								</tr>
							</tfoot>

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
