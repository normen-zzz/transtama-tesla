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
							<!-- <button id="tambahBarisBtn" class="btn btn-primary mb-2">Tambah Baris</button> -->
							<form action="<?= base_url('shipper/SalesOrder/addWeight/' . $this->uri->segment(4)) ?>" method="post">
								<button type="submit" class="btn btn-primary mb-2">Submit Dimension</button>

								<input type="text" name="shipment_id" value="<?= $shipment['shipment_id'] ?>" hidden id="shipment_id">

								<?php $do = $this->db->get_where('tbl_no_do', array('shipment_id' => $shipment['shipment_id']))->result_array();
								?>
								<table class="table table-bordered text-center" id="tableDimension">
									<thead>
										<tr>

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

										<tr>

											<td>
												<input required class="form-control" type="number" name="panjang[]" id="panjang">
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

									</tbody>
								</table>
							</form>
							<button id="tambahBarisBtn" class="btn btn-primary mb-2">Tambah Baris</button>
						<?php } else { ?>

							<table class="table table-bordered text-center" id="tableDimensionAkhir">
								<thead>
									<tr>

										<th>Panjang (CM)</th>
										<th>Lebar (CM)</th>
										<th>Tinggi (CM)</th>
										<th>Berat Aktual (KG)</th>
										<th>Berat Volume</th>

										<th>No DO</th>

									</tr>
								</thead>
								<tbody>

								<?php foreach ($dimension as $dimension1 ) { ?>
									
								

									<tr>

										<td>
											<?= $dimension1['panjang'] ?>
										</td>
										<td>
										<?= $dimension1['lebar'] ?>
										</td>
										<td><?= $dimension1['tinggi'] ?></td>
										<td><?= $dimension1['berat_aktual'] ?></td>
										<td><?= $dimension1['berat_volume'] ?></td>
								
										<td><?= $dimension1['no_do'] ?></td>
										
									</tr>
									<?php } ?>

								</tbody>
							</table>






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








<?php $do1 = $this->db->get_where('tbl_no_do', array('shipment_id' => $shipment['shipment_id']))->result_array();
?>




<script>
	$(document).ready(function() {
		$("#tambahBarisBtn").click(function() {
			var row = $("<tr>");
			var cell1 = $("<td>").append($("<input>").attr("type", "number").attr("name", "panjang[]").addClass("form-control").attr("required", true));
			var cell2 = $("<td>").append($("<input>").attr("type", "text").attr("name", "lebar[]").addClass("form-control").attr("required", true));
			var cell3 = $("<td>").append($("<input>").attr("type", "text").attr("name", "tinggi[]").addClass("form-control form-control-sm").attr("required", true));
			var cell4 = $("<td>").append($("<input>").attr("type", "text").attr("name", "berat[]").addClass("form-control form-control-sm").attr("required", true));
			var cell5 = $("<td>").append(getDoSelectOptions());
			row.append(cell1, cell2, cell3, cell4, cell5);
			$("#tableDimension tbody").append(row);
		});

		function getDoSelectOptions() {
			var select = $("<select>").attr("name", "no_do[]").addClass("form-control");
			<?php foreach ($do1 as $do2) : ?>
				var option = $("<option>").attr("value", "<?php echo $do2['no_do']; ?>").text("<?php echo $do2['no_do']; ?>");
				select.append(option);
			<?php endforeach; ?>
			return select;
		}
	});
</script>