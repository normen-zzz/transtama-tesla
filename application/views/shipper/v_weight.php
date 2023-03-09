<style>
	.hidden_row {
		display: none;
	}
</style>
<script type="text/javascript">
	function showHideRow(row) {
		$('#' + row).toggle();
		var icon = document.getElementById('icon' + row);
		icon.classList.toggle('fa-chevron-right');
		icon.classList.toggle('fa-chevron-down');
	}
</script>

<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="container">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-12">
				<div class="card card-custom card-stretch">
					<div class="card-header py-3">
						<div class="card-title align-items-start flex-column">
							<h3 class="card-label font-weight-bolder text-dark">Dimension Shipment <?= $shipment['shipment_id'] ?> </h3>
							<!-- <span class="text-muted font-weight-bold font-size-sm mt-1">Shipment ID :<b> <?= $p['shipment_id'] ?></b></span>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Order ID :<b> <?= $p['order_id'] ?></b></span> -->
						</div>
						<div class="card-toolbar">
							<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('shipper/salesOrder') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
								<i class="fas fa-chevron-circle-left text-light"> </i>
								Back
							</a>
						</div>
					</div>

					<!-- /.card-header -->
					<div class="card-body" style="overflow: auto;">
						<?php $dimension = $this->db->get_where('tbl_dimension', array('shipment_id' => $shipment['shipment_id']))->result_array(); ?>

						<?php if ($dimension == NULL) { ?>

							<form action="<?= base_url('shipper/SalesOrder/addWeight/' . $this->uri->segment(4)) ?>" method="post">
								<button type="submit" class="btn btn-primary mb-2">Submit Dimension</button>

								<?php $do = $this->db->get_where('tbl_no_do', array('shipment_id' => $shipment['shipment_id']))->result_array();
								?>
								<table class="table table-bordered text-center">
									<thead>
										<tr>
											<th>No</th>
											<th>Panjang (CM)</th>
											<th>Lebar (CM)</th>
											<th>Tinggi (CM)</th>
											<th>Berat Aktual (KG)</th>
											<?php if ($do != NULL) { ?>
												<th>No DO</th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php for ($i = 0; $i < $shipment['koli']; $i++) { ?>
											<?php $do = $this->db->get_where('tbl_no_do', array('shipment_id' => $shipment['shipment_id']))->result_array(); ?>

											<tr>
												<td style="width: 50px;"><?= $i + 1; ?></td>
												<td>
													<input class="form-control" type="text" name="panjang[]" id="panjang">
													<input type="text" name="shipment_id[]" value="<?= $shipment['shipment_id'] ?>" hidden id="shipment_id">
												</td>
												<td>

													<input required class="form-control" type="text" name="lebar[]" id="lebar">

												</td>
												<td><input required class="form-control" type="text" name="tinggi[]" id="tinggi"></td>
												<td><input required class="form-control" type="text" name="berat[]" id="berat"></td>
												<?php if ($do != NULL) { ?>
													<td>
														<select class="form-control" style="width: 200px;" name="no_do[]" id="no_do">
															<?php foreach ($do as $do) { ?>
																<option><?= $do['no_do'] ?></option>
															<?php } ?>
														</select>
													</td>
												<?php } ?>
											</tr>
										<?php } ?>

									</tbody>
								</table>
							</form>
						<?php } else { ?>

							<?php $merge = $this->db->get_where('tbl_merge_dimension', array('shipment_id' => $shipment['shipment_id']))->result_array();

							if ($merge != NULL) { ?>

								<table class="table table-bordered" id="table_detail">
									<thead>
										<tr>
											<th>Panjang</th>
											<th>Lebar</th>
											<th>Tinggi</th>
											<th>Berat Aktual</th>
											<th>Action</th>
										</tr>
									</thead>

									<?php foreach ($merge as $merge) {
										$detailMerge = $this->db->get_where('tbl_dimension', array('merge_to' => $merge['id_merge']))->result_array();
									?>
										<tr onclick="showHideRow('hidden_row<?= $merge['id_merge'] ?>');">
											<td scope="row"><b><?= $merge['panjang'] ?></b></td>
											<td><b><?= $merge['lebar'] ?></b></td>
											<td><b><?= $merge['tinggi'] ?></b></td>
											<td><b><?= $merge['berat_aktual'] ?></b></td>
											<td><a href="#" class="btn text-light" style="background-color: #9c223b;">Unmerge</a></td>
										</tr>
										<?php foreach ($detailMerge as $detail) { ?>
											<tr id="hidden_row<?= $merge['id_merge'] ?>" class="hidden_row">
												<td><?= $detail['panjang'] ?></td>
												<td><?= $detail['lebar'] ?></td>
												<td><?= $detail['tinggi'] ?></td>
												<td><?= $detail['berat_aktual'] ?></td>
												<td><a href="#" class="btn text-light" style="background-color: #9c223b;">Unmerge</a></td>
											</tr>
									<?php }
									} ?>


								</table>
							<?php } ?>



							<form action="<?= base_url('shipper/SalesOrder/mergeWeight/' . $this->uri->segment(4)) ?>" method="post">
								<button type="submit" class="btn btn-primary mb-2">Merge</button>
								<div class="row mb-2 ml-2 hide" style="display: none;">
									<div class="col-xs-12">
										<label for="Panjang">Panjang</label>
										<input type="text" name="panjang" class="form-control" placeholder="Panjang">
									</div>
									<div class="col-xs-12">
										<label for="Lebar">Lebar</label>
										<input type="text" name="lebar" class="form-control" placeholder="Lebar">
									</div>
									<div class="col-xs-12">
										<label for="Lebar">Tinggi</label>
										<input type="text" name="tinggi" class="form-control" placeholder="Tinggi">
									</div>

								</div>
								<?php $do = $this->db->get_where('tbl_no_do', array('shipment_id' => $shipment['shipment_id']))->result_array();
								?>
								<table class="table table-bordered text-center">
									<thead>
										<tr>
											<th>#</th>
											<th>No</th>
											<th>Panjang (CM)</th>
											<th>Lebar (CM)</th>
											<th>Tinggi (CM)</th>
											<th>Berat Aktual (KG)</th>
											<?php if ($do != NULL) { ?>
												<th>No DO</th>
											<?php } ?>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($dimension as $dimension) {
											if ($dimension['merge_to'] == NULL) {

										?>
												<tr>
													<td><input type="checkbox" class="check" onchange="valueChanged()" name="check[]" value="<?= $dimension['id_dimension'] ?>" id="check"></td>
													<td scope="row"><?= $dimension['urutan'] ?></td>
													<td>
														<?= $dimension['panjang'] ?>
													</td>
													<td><?= $dimension['lebar'] ?></td>
													<td><?= $dimension['tinggi'] ?></td>
													<td><?= $dimension['berat_aktual'] ?></td>
													<td>
														<?= $dimension['no_do'] ?>
													</td>
													<td><a class="btn text-light" data-toggle="modal" data-target="#editDimension<?= $dimension['id_dimension'] ?>" style="background-color: #9c223b;">Edit</a></td>

												</tr>
										<?php }
										} ?>

									</tbody>
								</table>
							</form>
						<?php } ?>


					</div>


					<!-- /.card -->
				</div>

			</div>
			<!-- /.row -->

		</div>
		<!--/. container-fluid -->
</section>
<!-- /.content -->
<?php $do2 = $this->db->get_where('tbl_no_do', array('shipment_id' => $shipment['shipment_id']))->result_array(); ?>
<?php $dimension2 = $this->db->get_where('tbl_dimension', array('shipment_id' => $shipment['shipment_id']))->result_array(); ?>
<?php foreach ($dimension2 as $dimension) { ?>
	<div class="modal fade" id="editDimension<?= $dimension['id_dimension'] ?>">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Dimension</h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('shipper/salesOrder/editWeight') ?>" method="POST">
						<div class="card-body">
							<div class="row">
								<input type="text" name="id_dimension" id="id_dimension" value="<?= $dimension['id_dimension'] ?>" hidden>
								<div class="col-md-12">
									<label for="panjang">Panjang</label>
									<input type="text" name="panjang" class="form-control" value="<?= $dimension['panjang'] ?>" id="panjang">

								</div>
								<div class="col-md-12 mt-2">
									<label for="lebar">Lebar</label>
									<input type="text" name="lebar" class="form-control" value="<?= $dimension['lebar'] ?>" id="lebar">

								</div>

								<div class="col-md-12 mt-2">
									<label for="tinggi">Tinggi</label>
									<input type="text" name="tinggi" class="form-control" value="<?= $dimension['tinggi'] ?>" id="tinggi">

								</div>
								<div class="col-md-12 mt-2">
									<label for="berat">Berat Aktual</label>
									<input type="text" name="berat" class="form-control" value="<?= $dimension['berat_aktual'] ?>" id="berat">

								</div>

								<div class="col-md-12 mt-2">
									<label for="berat">No DO</label>
									<select class="form-control" name="no_do" id="no_do">
										<?php foreach ($do2 as $do) { ?>
											<option <?php if ($dimension['no_do'] == $do['no_do']) {
														echo 'selected';
													} ?> value="<?= $do['no_do'] ?>"><?= $do['no_do'] ?></option>
										<?php } ?>
									</select>

								</div>

							</div>
						</div>
						<!-- /.card-body -->
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button onclick='$("#modalLoading").modal("show");' type="submit" class="btn btn-primary">Submit</button>
				</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
<?php } ?>