	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h2 class="card-title">Report Order
								<?php if ($start == 'null' && $start == 'null') {
									echo '';
								} else {
									echo bulan_indo($start) . '-' . bulan_indo($end);
								} ?>
							</h2>
							<form method="POST" action="<?= base_url() ?>superadmin/order/filterLaporan" id="reportBerdasarkan">
								<div class="row">
									<div class="col-md-2">
										<b>Filter Tanggal</b>

									</div>
									<div class="col-md-4">

										<div class="align-items-center" style="margin-top: -5px;">
											<div class="mt-4">
												<!-- <label class="sr-only" for="inlineFormInput"></label> -->
												Dari<input type="date" name="start" class="form-control" id="inlineFormInput">
											</div>

											<div class="mt-2">
												<!-- <label class="sr-only" for="inlineFormInput"></label> -->
												Sampai <input type="date" name="end" class="form-control" id="inlineFormInput">

											</div>

										</div>
									</div>
									<div class="col-md-2">
										<b>Filter Driver</b>
									</div>
									<div class="col-md-4 mt-2">
										<div class="form-row align-items-center" style="margin-top: -5px;">
											<select name="id_user" class="form-control">
												<option value="0">-All-</option>
												<?php foreach ($users as $u) {
												?>
													<option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
												<?php } ?>
											</select>

										</div>

									</div>

								</div>

								<div class="col-md-12">

									<button type="submit" class="btn btn-sm btn-success mt-2" id="submit">Tampilkan</button>
									<a href="<?= base_url() ?>superadmin/order/report" class="btn btn-sm btn-primary mt-2">Reset Filter</a>

									<?php if (isset($start) && isset($end) && isset($id_user)) { ?>
										<a href="<?= base_url('superadmin/order/print/' . $start . '/' . $end . '/' . $id_user) ?>" class="btn btn-sm btn-danger mt-2">Print</a>
									<?php } elseif (isset($start) && isset($end)) { ?>
										
									 <a href="<?= base_url() ?>superadmin/order/Exportexcel" class="btn btn-sm btn-danger mt-2">Print Excell</a>
									<?php } else {
									?>
										
									<?php } ?>

								</div>

							</form>
						</div>

						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<table id="mytable" class="table table-bordered">
								<!-- <a href="<?= base_url('shipper/order/add') ?>" class="btn btn-success mr-2 mb-4">
									<i class="fas fa-plus-circle"> </i>Add
								</a> -->
								<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
								<p style="color:red"><?= $this->session->flashdata('message'); ?></p>
								<thead>
									<tr>
										<th style="width: 15%;">Driver</th>
										<!-- <th style="width: 20%;">Shipper</th> -->
										<!-- <th style="width: 20%;">Consigne</th> -->
										<th style="width: 10%;">Shipment ID</th>
										<!-- <th style="width: 10%;">Order ID</th> -->
										<!-- <th style="width: 20%;">Image</th> -->
										<!-- <th>Signature</th> -->
										<th>Created At</th>
										
									</tr>
								</thead>
								
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

