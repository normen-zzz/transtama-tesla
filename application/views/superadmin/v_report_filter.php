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
									<form action="<?= base_url('superadmin/order/filterLaporan') ?>" method="POST">
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
											<div class="form-group">
												<label>Sales</label> <br>
												<select name="id_user" class="form-control ml-4" style="width: 200px; height:100px">
													<option value="0">All Sales</option>
													<?php foreach ($users as $u) {
													?>
														<option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
													<?php } ?>
												</select>
											</div>

											<div class="form-group"> <br>
												<button type="submit" class="btn btn-success mt-4 ml-3">Tampilkan</button>
												<a href="<?= base_url('superadmin/order/report') ?>" class="btn btn-primary mt-4 ml-1">Reset Filter</a>
											</div>
										</div>

									</form>
								</div>
								<!-- <button class="btn btn-icon waves-effect waves-light btn-success mb-4" data-toggle="modal" data-target="#addBukti"> <i class="fas fa-plus"></i> Lakukan Pembayaran Sample </button> -->

								<div class="row">
									<a target="blank" href="<?= base_url('superadmin/order/exportexcel/' . $bulan . '/' . $tahun . '/' . $id_sales) ?>" class="btn btn-sm btn-danger mb-3 ml-2">Export Laporan Excell</a>

								</div>
								<br>


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
										<th style="width: 15%;">Sales</th>
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
											<td> <a href="<?= base_url('cs/order/print/' . $p['shipment_id']) ?>"><?= $p['shipment_id'] ?> </a> </td>

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