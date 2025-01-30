<style>
	.hidden_row {
		display: none;
	}

	th {
		white-space: nowrap;
	}

	td {
		white-space: nowrap;
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
							<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('shipper/Scan') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
								<i class="fas fa-chevron-circle-left text-light"> </i>
								Back
							</a>
							<a href="<?= base_url('shipper/order/printOutbond/' . $shipment['shipment_id']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
	                                <i class="fas fa-print text-light"> </i>
	                                Print
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
													<input required class="form-control" type="number" name="panjang[]" id="panjang">
													<input type="text" name="shipment_id[]" value="<?= $shipment['shipment_id'] ?>" hidden id="shipment_id">
												</td>
												<td>

													<input required class="form-control" type="text" name="lebar[]" id="lebar">

												</td>
												<td><input required class="form-control form-control-sm" type="text" name="tinggi[]" id="tinggi"></td>
												<td><input required class="form-control form-control-sm" type="text" name="berat[]" id="berat"></td>
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
											<th>NO</th>
											<th>Isi</th>
										</tr>
									</thead>



									<?php $no = 1;
									foreach ($merge as $merge2) {
										$detailMerge = $this->db->get_where('tbl_dimension', array('merge_to' => $merge2['id_merge']))->result_array();
									?>
										<tr onclick="showHideRow('hidden_row<?= $merge2['id_merge'] ?>');">
											<td><?= $no; ?></td>
											
											<!-- <td><a href="#" class="btn text-light" style="background-color: #9c223b;">Unmerge</a></td> -->
											<td>
												<table>
													<tr>
														<th>NO</th>
														<th>Panjang</th>
														<th>Lebar</th>
														<th>Tinggi</th>
														<th>Berat (KG)</th>
														<th>No DO</th>
														<th>Action</th>
													</tr>
													<?php foreach ($detailMerge as $detail2) { ?>
														<tr>
															<td><?= $detail2['urutan'] ?></td>
															<td><?= $detail2['panjang_handling'] ?></td>
															<td><?= $detail2['lebar_handling'] ?></td>
															<td><?= $detail2['tinggi_handling'] ?></td>
															<?php if ($detail2['berat_aktual_handling'] > $detail2['berat_volume_handling']) { ?>
																<td><b><?= $detail2['berat_aktual_handling'] ?> (Aktual)</b> | <?= $detail2['berat_volume_handling'] ?> (Volume)</td>
															<?php } else { ?>
																<td><?= $detail2['berat_aktual_handling'] ?> (Aktual) | <b><?= $detail2['berat_volume_handling'] ?> (Volume)</b></td>
															<?php } ?>
															<td><?= $detail2['no_do'] ?></td>
															<td><a href="<?= base_url('shipper/SalesOrder/unMerge/' . $detail2['id_dimension']) ?>" class="btn text-light" style="background-color: #9c223b;">Unmerge</a></td>
														</tr>
													<?php  } ?>

												</table>
											</td>
										</tr>


									<?php $no++;
									} ?>


								</table>
							<?php } ?>



							<form action="<?= base_url('shipper/SalesOrder/mergeWeight/' . $this->uri->segment(4)) ?>" method="post">
							
								<button type="submit" id="submitMerge" style="visibility:hidden" class="btn btn-primary mb-2">Merge</button>
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

									<div class="col-xs-12">
										<label for="Berat">Berat Aktual</label>
										<input type="text" name="berat" class="form-control" placeholder="berat">
									</div>

								</div>
								<?php $do = $this->db->get_where('tbl_no_do', array('shipment_id' => $shipment['shipment_id']))->result_array();
								?>
								<table class="table table-bordered text-center">
									<thead>
										<tr>
											<th>#</th>
											<th>No</th>
											<th>Panjang (CM) <?php if ($dimension[0]['panjang_handling'] != NULL) {
																	echo '| Handling';
																} ?></th>
											<th>Lebar (CM) <?php if ($dimension[0]['panjang_handling'] != NULL) {
																echo '| Handling';
															} ?></th>
											<th>Tinggi (CM) <?php if ($dimension[0]['panjang_handling'] != NULL) {
																echo '| Handling';
															} ?></th>
											<th>Berat Aktual (KG) <?php if ($dimension[0]['panjang_handling'] != NULL) {
																		echo '| Handling';
																	} ?></th>
											<th>Berat Volume <?php if ($dimension[0]['panjang_handling'] != NULL) {
																	echo '| Handling';
																} ?></th>
											<?php if ($dimension[0]['no_do'] != NULL) { ?>
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
													<td><?php if ($dimension['panjang_handling'] != NULL) { ?> <input type="checkbox" name="check[]" onchange="checkTotalCheckedBoxes()"  value="<?= $dimension['id_dimension'] ?>" id="check"> <?php } ?></td>
													<td scope="row"><?= $dimension['urutan'] ?></td>
													<td>
														<?= $dimension['panjang'] ?> <?php if ($dimension['panjang_handling'] != NULL) {
																							echo '| ' . $dimension['panjang_handling'] . ' (Handling)';
																						} ?>
													</td>
													<td><?= $dimension['lebar'] ?> <?php if ($dimension['panjang_handling'] != NULL) {
																						echo '| ' . $dimension['lebar_handling'] . ' (Handling)';
																					} ?></td>
													<td><?= $dimension['tinggi'] ?> <?php if ($dimension['panjang_handling'] != NULL) {
																						echo '| ' . $dimension['tinggi_handling'] . ' (Handling)';
																					} ?></td>
													<td <?php if ($dimension['berat_aktual_handling'] > $dimension['berat_volume_handling']) { ?> style="font-weight: bold; color:#9c223b" <?php } ?>><?= $dimension['berat_aktual'] ?> <?php if ($dimension['panjang_handling'] != NULL) {
																																																											echo '| ' . $dimension['berat_aktual_handling'] . ' (Handling)';
																																																										} ?></td>
													<td <?php if ($dimension['berat_volume_handling'] > $dimension['berat_aktual_handling']) { ?> style="font-weight: bold; color:#9c223b" <?php } ?>><?= $dimension['berat_volume'] ?> <?php if ($dimension['panjang_handling'] != NULL) {
																																																											echo '| ' . $dimension['berat_volume_handling'] . ' (Handling)';
																																																										} ?></td>
													<?php if ($dimension['no_do'] != NULL) { ?>
														<td>
															<?= $dimension['no_do'] ?>
														</td>
													<?php } ?>

													<td>
														<?php if ($dimension['panjang_handling'] != NULL) { ?>
															<a class="btn text-light" data-toggle="modal" data-target="#editDimension<?= $dimension['id_dimension'] ?>" style="background-color: #9c223b;">Edit</a>
															<?php if ($dimension['no_do'] != NULL) { ?>
																<a class="btn text-light" data-toggle="modal" data-target="#editDo<?= $dimension['id_dimension'] ?>" style="background-color: #9c223b;">Change DO</a>
															<?php } ?>


														<?php } ?>
														<?php if ($dimension['panjang_handling'] == NULL) { ?>
															<a class="btn text-light" data-toggle="modal" data-target="#addHandling<?= $dimension['id_dimension'] ?>" style="background-color: #9c223b;">Handling</a>
														<?php } ?>
													</td>

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
								<div class="col-md-6">
									<label for="panjang">Panjang</label>
									<input type="text" name="panjang" class="form-control" value="<?= $dimension['panjang'] ?>" id="panjang">

								</div>
								<div class="col-md-6">
									<label for="panjang">Panjang (Handling)</label>
									<input type="text" name="panjang_handling" class="form-control" value="<?= $dimension['panjang_handling'] ?>" id="panjang_handling">

								</div>
								<div class="col-md-6 mt-2">
									<label for="lebar">Lebar</label>
									<input type="text" name="lebar" class="form-control" value="<?= $dimension['lebar'] ?>" id="lebar">

								</div>

								<div class="col-md-4 mt-2">
									<label for="lebar">Lebar (Handling)</label>
									<input type="text" name="lebar_handling" class="form-control" value="<?= $dimension['lebar_handling'] ?>" id="lebar_handling">

								</div>

								<div class="col-md-6 mt-2">
									<label for="tinggi">Tinggi</label>
									<input type="text" name="tinggi" class="form-control" value="<?= $dimension['tinggi'] ?>" id="tinggi">

								</div>

								<div class="col-md-6 mt-2">
									<label for="tinggi">Tinggi (Handling)</label>
									<input type="text" name="tinggi_handling" class="form-control" value="<?= $dimension['tinggi_handling'] ?>" id="tinggi_handling">

								</div>
								<div class="col-md-6 mt-2">
									<label for="berat">Berat Aktual</label>
									<input type="text" name="berat" class="form-control" value="<?= $dimension['berat_aktual'] ?>" id="berat">

								</div>

								<div class="col-md-6 mt-2">
									<label for="berat">Berat Aktual (Handling)</label>
									<input type="text" name="berat_handling" class="form-control" value="<?= $dimension['berat_aktual_handling'] ?>" id="berat_handling">

								</div>

								<div class="col-md-6 mt-2">
									<label for="berat">Berat Volume</label>
									<input type="text" name="volume" class="form-control" value="<?= $dimension['berat_volume'] ?>" id="volume" readonly>

								</div>

								<div class="col-md-6 mt-2">
									<label for="berat">Berat Volume (Handling)</label>
									<input type="text" name="volume_handling" class="form-control" value="<?= $dimension['berat_volume_handling'] ?>" id="volume" readonly>

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

<?php foreach ($dimension2 as $handling) { ?>
	<div class="modal fade" id="addHandling<?= $handling['id_dimension'] ?>">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Handling</h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('shipper/salesOrder/addHandling') ?>" method="POST">
						<div class="card-body">
							<div class="row">
								<input type="text" name="id_dimension" id="id_dimension" value="<?= $handling['id_dimension'] ?>" hidden>
								<div class="col-md-12">
									<label for="panjang">Panjang (Handling)</label>
									<input type="text" name="panjang" class="form-control" value="0" id="panjang">

								</div>
								<div class="col-md-12 mt-2">
									<label for="lebar">Lebar (Handling)</label>
									<input type="text" name="lebar" class="form-control" value="0" id="lebar">

								</div>

								<div class="col-md-12 mt-2">
									<label for="tinggi">Tinggi (Handling)</label>
									<input type="text" name="tinggi" class="form-control" value="0" id="tinggi">

								</div>
								<div class="col-md-12 mt-2">
									<label for="berat">Berat Aktual (Handling)</label>
									<input type="text" name="berat" class="form-control" value="0" id="berat">

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

<?php foreach ($dimension2 as $handling2) { ?>
	<div class="modal fade" id="editHandling<?= $handling2['id_dimension'] ?>">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Handling</h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('shipper/salesOrder/editHandling') ?>" method="POST">
						<div class="card-body">
							<div class="row">
								<input type="text" name="id_dimension" id="id_dimension" value="<?= $handling2['id_dimension'] ?>" hidden>
								<div class="col-md-12">
									<label for="panjang">Panjang (Handling)</label>
									<input type="text" name="panjang" class="form-control" value="0" id="panjang">

								</div>
								<div class="col-md-12 mt-2">
									<label for="lebar">Lebar (Handling)</label>
									<input type="text" name="lebar" class="form-control" value="0" id="lebar">

								</div>

								<div class="col-md-12 mt-2">
									<label for="tinggi">Tinggi (Handling)</label>
									<input type="text" name="tinggi" class="form-control" value="0" id="tinggi">

								</div>
								<div class="col-md-12 mt-2">
									<label for="berat">Berat Aktual (Handling)</label>
									<input type="text" name="berat" class="form-control" value="0" id="berat">

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

<?php foreach ($dimension2 as $handling3) { ?>
	<div class="modal fade" id="editDo<?= $handling3['id_dimension'] ?>">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Change DO</h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('shipper/salesOrder/changeDo/' . $handling3['id_dimension']) ?>" method="POST">
						<div class="card-body">
							<div class="row">
								<input type="text" name="id_dimension" id="id_dimension" value="<?= $handling3['id_dimension'] ?>" hidden>
								<div class="col-md-12 mt-2">
									<label for="berat">No DO</label>
									<select class="form-control" name="no_do" id="no_do">
										<?php foreach ($do2 as $do) { ?>
											<option <?php if ($handling3['no_do'] == $do['no_do']) {
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
