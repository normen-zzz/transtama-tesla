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
									<form action="<?= base_url('cs/order/filterLaporan') ?>" method="POST">
										<div class="row ml-2">
											<div class="form-group mr-2">
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
											</div>
											<div class="form-group"> <br>
												<button type="submit" class="btn btn-success mt-4 ml-3">Tampilkan</button>
												<a href="<?= base_url('cs/order/report') ?>" class="btn btn-primary mt-4 ml-1">Reset Filter</a>
												
											</div>
										</div>

									</form>
								</div>
								<!-- <button class="btn btn-icon waves-effect waves-light btn-success mb-4" data-toggle="modal" data-target="#addBukti"> <i class="fas fa-plus"></i> Lakukan Pembayaran Sample </button> -->

								<div class="row">
									<a target="blank" href="<?= base_url('cs/order/exportexcel/') ?>" class="btn btn-sm btn-danger mb-3 ml-2">Export Laporan Keseluruhan</a>
									<a target="blank" href="<?= base_url('cs/order/exportexcelVoid/') ?>" class="btn btn-sm btn-primary mb-3 ml-2">Export Void All</a>
								</div>
								<br>



						</div>

						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<table id="mytablereport" class="table table-bordered">
								<!-- <a href="<?= base_url('shipper/order/add') ?>" class="btn btn-success mr-2 mb-4">
									<i class="fas fa-plus-circle"> </i>Add
								</a> -->
								<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
								<p style="color:red"><?= $this->session->flashdata('message'); ?></p>
								<thead>
									<tr>
										<th style="width: 15%;">Pickup Date</th>
										<th style="width: 15%;">Customer</th>
										<th style="width: 15%;">Consignee</th>
										<th style="width: 15%;">Driver</th>
										<!-- <th style="width: 20%;">Shipper</th> -->
										<!-- <th style="width: 20%;">Consigne</th> -->
										<th style="width: 10%;">Shipment ID</th>
										<!-- <th style="width: 10%;">Order ID</th> -->
										<!-- <th style="width: 20%;">Image</th> -->
										<!-- <th>Signature</th> -->
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