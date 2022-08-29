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
									<form action="<?= base_url('sales/salesOrder/filterLaporan') ?>" method="POST">
										<h6 class="title">Filter By Pickup Date</h6>
										<div class="row ml-2">
											<div class="form-group">
												<label>Start</label><br>
												<input type="date" class="form-control" name="awal" value="<?= date('Y-m-d') ?>">
											</div>
											<div class="form-group ml-2">
												<label>From</label><br>
												<input type="date" class="form-control" name="akhir" value="<?= date('Y-m-d') ?>">
											</div>
											<!-- <div class="form-group mr-2">
												<label>Bulan</label><br>
												<select name="bulan" class="form-control" style="width: 200px; height:100px">
													<option value="">Pilih</option>
													<option value="01">Januari</option>
													<option value="02">Februari</option>
													<option value="03">Maret</option>
													<option value="04">April</option>
													<option value="05">Mei</option>
													<option value="06">Juni</option>
													<option value="07">Juli</option>
													<option value="08">Agustus</option>
													<option value="09">September</option>
													<option value="10">Oktober</option>
													<option value="11">November</option>
													<option value="12">Desember</option>
												</select>
											</div>
											<div class="form-group">
												<label>Tahun</label> <br>
												<select name="tahun" class="form-control" style="width: 200px; height:100px">
													<option selected="selected">Pilih</option>
													<?php
													for ($i = date('Y'); $i >= date('Y') - 5; $i -= 1) {
														echo "<option value='$i'> $i </option>";
													}
													?>
												</select>
											</div> -->
											<div class="form-group"> <br>
												<button type="submit" class="btn btn-success ml-3">Show</button>
												<a href="<?= base_url('sales/salesOrder/report') ?>" class="btn btn-primary ml-1">Reset Filter</a>
												<a target="blank" href="<?= base_url('sales/salesOrder/exportexcel/') ?>" class="btn btn-sm btn-danger ml-2">Export All</a>
											</div>
										</div>

									</form>
								</div>

						</div>

						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<table id="mytablereportsales" class="table table-bordered">
								<p><?= $this->session->flashdata('message'); ?></p>
								<thead>
									<tr>
										<th style="width: 15%;">Pickup Date</th>
										<th style="width: 15%;">Customer</th>
										<th style="width: 15%;">Consignee</th>
										<th style="width: 15%;">Driver</th>
										<th style="width: 10%;">Shipment ID</th>
										<th>Created At</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>


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