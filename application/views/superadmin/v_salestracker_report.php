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
																} ?> value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
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
							<table id="myTable2" class="table table-bordered">
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
										<th>image</th>
										<!-- <th>Action</th> -->
									</tr>
								</thead>
								<tbody>
									<?php foreach ($salestracker as $salestracker) { ?>
										<tr>
											<td><?= $salestracker['nama_user'] ?></td>
											<td><?= $salestracker['subject'] ?></td>
											<td><?= $salestracker['description'] ?></td>
											<td><?= $salestracker['location'] ?></td>
											<td><?= date('D d/m/Y H:i:s', strtotime($salestracker['dibuat'])) ?></td>
											<td><?= date('D d/m/Y H:i:s', strtotime($salestracker['start_date'])) ?></td>
											<td><?= date('D d/m/Y H:i:s', strtotime($salestracker['end_date'])) ?></td>
											<td><?= $salestracker['contact'] ?></td>
											<td><?= $salestracker['summary'] ?></td>
											<td><img src="<?= base_url('uploads/salestracker/' . $salestracker['image']) ?>" alt="" srcset="" width="70px"></td>
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