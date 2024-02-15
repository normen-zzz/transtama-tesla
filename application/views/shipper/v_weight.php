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

					<!-- /.cad-header -->
					<div class="card-body" style="overflow: auto;">
						<?php if ($dimension == NULL) { ?>
							<!-- <button id="tambahBarisBtn" class="btn btn-primary mb-2">Tambah Baris</button> -->
							
							<form action="<?= base_url('shipper/SalesOrder/addWeight/' . $this->uri->segment(4)) ?>" method="post">
							<button onclick='$("#modalLoading").modal("show");' type="submit" class="btn btn-primary mb-2">Submit Dimension</button>
							<button class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#addDimensionBulk" style="background-color: #9c223b;">Bulk Input</button>

								<input type="text" name="shipment_id" value="<?= $shipment['shipment_id'] ?>" hidden id="shipment_id">

								<?php $do = $this->db->get_where('tbl_no_do', array('shipment_id' => $shipment['shipment_id']))->result_array();
								?>
								<table class="table table-bordered text-center" id="tableDimension">
									<thead>
										<tr>
											<th>No</th>
											<th>Koli</th>
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
											<td>1</td>
											<td>
												<input style="width: 50px;" required class="form-control" type="number" name="koli[]" id="koli">
											</td>
											<td>
												<input required class="form-control" type="number" name="panjang[]" id="panjang">
											</td>
											<td>
												<input required class="form-control" type="number" name="lebar[]" id="lebar">
											</td>
											<td><input required class="form-control form-control-sm" type="number" name="tinggi[]" id="tinggi"></td>
											<td><input required class="form-control form-control-sm" type="number" name="berat[]" id="berat"></td>
											<?php if ($do != NULL) { ?>
												<td>
													<select class="form-control" style="width: 200px;" name="no_do[]" id="no_do">
														<?php foreach ($do as $do) { ?>
															<option value="<?= $do['id_berat'] ?>"><?= $do['no_do'] ?></option>
														<?php } ?>
													</select>
												</td>
											<?php } ?>
										</tr>

									</tbody>
								</table>
							</form>

							<button id="tambahBarisBtn" class="btn btn-primary mb-2  float-right">Tambah Baris</button>
							<button id="hapusBaris" class="btn btn-danger mb-2 mr-4 float-right">Hapus Baris</button>
						<?php } else { ?>

							<button class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#addDimension" style="background-color: #9c223b;">Tambah</button>

							<table class="table table-bordered text-center mt-2" id="tableDimensionAkhir">
								<thead>
									<tr>
							<th>Koli</th>
										<th>Panjang (CM)</th>
										<th>Lebar (CM)</th>
										<th>Tinggi (CM)</th>
										<th>Berat Aktual (KG)</th>
										<th>Berat Volume</th>

										<th>No DO</th>
										<th>Action</th>

									</tr>
								</thead>
								<tbody>

									<?php foreach ($dimension as $dimension1) { ?>



										<tr>
										<td>
												<?= $dimension1['koli'] ?>
											</td>
											<td>
												<?= $dimension1['panjang'] ?>
											</td>
											<td>
												<?= $dimension1['lebar'] ?>
											</td>
											<td><?= $dimension1['tinggi'] ?></td>

											<?php if ($dimension1['berat_aktual'] > $dimension1['berat_volume']) { ?>
												<td><b><?= $dimension1['berat_aktual'] ?></b></td>
												<td><?= $dimension1['berat_volume'] ?></td>
											<?php } else { ?>

												<td><?= $dimension1['berat_aktual'] ?></td>
												<td><b><?= $dimension1['berat_volume'] ?></b></td>

											<?php } ?>

											<td><?= $dimension1['no_do'] ?></td>
											<td><button class="btn font-weight-bolder text-light modalEditDimension" data-toggle="modal" data-target="#editDimension" data-id_dimension="<?= $dimension1['id_dimension'] ?>" style="background-color: #9c223b;">Edit</button>
												<a class="btn font-weight-bolder text-light" href="<?= base_url('shipper/SalesOrder/deleteDimension/' . $dimension1['id_dimension']) ?>" onclick="return confirm('Apakah Anda Yakin?')" style="background-color: #9c223b;">Delete</a>
											</td>


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




<div class="modal fade" id="editDimension">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Dimension</h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('shipper/salesOrder/editDimension') ?>" method="POST">
					<div id="contentEditDimension">

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

<div class="modal fade" id="addDimension">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Dimension</h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

			<div class="card-body">
				<div style="overflow-x:auto;">
					<form action="<?= base_url('shipper/SalesOrder/addWeight/' . $this->uri->segment(4)) ?>" method="post">
						<button onclick='$("#modalLoading").modal("show");' type="submit" class="btn btn-primary mb-2">Submit Dimension</button>

						<input type="text" name="shipment_id" value="<?= $shipment['shipment_id'] ?>" hidden id="shipment_id">

						<?php $do = $this->db->get_where('tbl_no_do', array('shipment_id' => $shipment['shipment_id']))->result_array();
						?>
						<table class="table table-bordered text-center" id="tableDimensionModal">
							<thead>
								<tr>
									<th>No</th>
									<th>Koli</th>
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
									<td>1</td>
									<td>
										<input required class="form-control" type="number" name="koli[]" id="koli">
									</td>
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
													<option value="<?= $do['id_berat'] ?>"><?= $do['no_do'] ?></option>
												<?php } ?>
											</select>
										</td>
									<?php } ?>
								</tr>

							</tbody>
						</table>
					</form>
					<button id="tambahBarisBtnModal" class="btn btn-primary mb-2  float-right">Tambah Baris</button>
					<button id="hapusBaris" class="btn btn-danger mb-2 mr-4 float-right">Hapus Baris</button>
				</div>
				<!-- /.card-body -->
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

			</div>

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="addDimensionBulk">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Dimension Bulk</h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<a href="<?= base_url('shipper/SalesOrder/createExcelWeight/' . $shipment['shipment_id']) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
					<i class="fas fa-download text-light"> </i>
					Download Template
				</a>

				<div class="card-body">



					<form id="kt_form" novalidate="novalidate" action="<?= base_url('shipper/SalesOrder/importWeight/' . $shipment['shipment_id']) ?>" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label class="col-form-label text-lg-right font-weight-bold">Upload File</label>
							<input type="file" id="input-file-now" required name="upload_file" class="dropify" />


						</div>
						<!--begin: Wr ons-->


						<button type="submit" class="btn mr-2 text-light" style="background-color: #9c223b;">Submit</button>



						<!--end: Wizard Actio-->
					</form>
				</div>

			</div>
			<!-- /.card-body -->
		</div>
		<div class="modal-footer justify-content-between">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

		</div>

	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>








<?php $do1 = $this->db->get_where('tbl_no_do', array('shipment_id' => $shipment['shipment_id']))->result_array();
?>

<script>
	$(document).ready(function() {
		$("#tambahBarisBtn").click(function() {
			var rowCount = $('#tableDimension tbody tr').length;
			var newRow = rowCount + 1;
			var row = $("<tr>");
			var cell0 = $("<td>").append(newRow);
			var cell1 = $("<td>").append($("<input>").attr("type", "number").attr("name", "koli[]").addClass("form-control").attr("required", true));
			var cell2 = $("<td>").append($("<input>").attr("type", "number").attr("name", "panjang[]").addClass("form-control").attr("required", true));
			var cell3 = $("<td>").append($("<input>").attr("type", "number").attr("name", "lebar[]").addClass("form-control").attr("required", true));
			var cell4 = $("<td>").append($("<input>").attr("type", "number").attr("name", "tinggi[]").addClass("form-control form-control-sm").attr("required", true));
			var cell5 = $("<td>").append($("<input>").attr("type", "number").attr("name", "berat[]").addClass("form-control form-control-sm").attr("required", true));
			var cell6 = $("<td>").append(getDoSelectOptions());
			row.append(cell0, cell1, cell2, cell3, cell4, cell5, cell6);
			$("#tableDimension tbody").append(row);
			$('.selectField').select2();

		});

		function getDoSelectOptions() {
			var select = $("<select>").attr("name", "no_do[]").addClass("form-control selectField");
			<?php foreach ($do1 as $do2) : ?>
				var option = $("<option>").attr("value", "<?php echo $do2['id_berat']; ?>").text("<?php echo $do2['no_do']; ?>");

				select.append(option);

			<?php endforeach; ?>
			return select;
		}
	});
</script>

<script>
	$(document).ready(function() {
		$("#tambahBarisBtnModal").click(function() {
			var rowCount = $('#tableDimensionModal tbody tr').length;
			var newRow = rowCount + 1;
			var row = $("<tr>");
			var cell0 = $("<td>").append(newRow);
			var cell1 = $("<td>").append($("<input>").attr("type", "number").attr("name", "koli[]").addClass("form-control").attr("required", true));
			var cell2 = $("<td>").append($("<input>").attr("type", "number").attr("name", "panjang[]").addClass("form-control").attr("required", true));
			var cell3 = $("<td>").append($("<input>").attr("type", "number").attr("name", "lebar[]").addClass("form-control").attr("required", true));
			var cell4 = $("<td>").append($("<input>").attr("type", "number").attr("name", "tinggi[]").addClass("form-control form-control-sm").attr("required", true));
			var cell5 = $("<td>").append($("<input>").attr("type", "number").attr("name", "berat[]").addClass("form-control form-control-sm").attr("required", true));
			var cell6 = $("<td>").append(getDoSelectOptions());
			row.append(cell0, cell1, cell2, cell3, cell4, cell5, cell6);
			$("#tableDimensionModal tbody").append(row);
			$('.selectField').select2();

		});

		function getDoSelectOptions() {
			var select = $("<select>").attr("name", "no_do[]").addClass("form-control selectField");
			<?php foreach ($do1 as $do2) : ?>
				var option = $("<option>").attr("value", "<?php echo $do2['id_berat']; ?>").text("<?php echo $do2['no_do']; ?>");

				select.append(option);

			<?php endforeach; ?>
			return select;
		}
	});
</script>

<script>
	$(document).ready(function() {
		$('#hapusBaris').click(function() {
			$('table tr:last').remove();
		});
	});
</script>

<script>
	$(document).ready(function() {
		$('.modalEditDimension').click(function() {
			var id_dimension = $(this).data('id_dimension'); // Mendapatkan ID dari atribut data-id tombol yang diklik
			$('#ContentEditDimension').html('');
			// Memuat data menggunakan AJAX dengan mengirimkan ID sebagai parameter
			$.ajax({
				url: '<?php echo base_url("shipper/SalesOrder/getModalEditDimension"); ?>',
				type: 'GET',
				dataType: 'json',
				data: {
					id_dimension: id_dimension
				},
				success: function(response) {
					// Menampilkan data ke dalam modal
					var content = '<div class="card-body">' +
						'<div class="row">' +
						'<input type="text" name="id_dimension" id="id_dimension" value="' + response.id_dimension + '" hidden>' +
						'<div class="col-md-12">' +
						'<label for="koli">Koli</label>' +
						'<input type="text" name="koli" class="form-control" value="' + response.koli + '" id="koli">' +

						'</div>' +
						'<div class="col-md-12 mt-2">' +
						'<label for="panjang">Panjang</label>' +
						'<input type="text" name="panjang" class="form-control" value="' + response.panjang + '" id="panjang">' +

						'</div>' +
						'<div class="col-md-12 mt-2">' +
						'<label for="lebar">Lebar</label>' +
						'<input type="text" name="lebar" class="form-control" value="' + response.lebar + '" id="lebar">' +

						'</div>' +

						'<div class="col-md-12 mt-2">' +
						'<label for="tinggi">Tinggi</label>' +
						'<input type="text" name="tinggi" class="form-control" value="' + response.tinggi + '" id="tinggi">' +

						'</div>' +
						'<div class="col-md-12 mt-2">' +
						'<label for="berat">Berat Aktual</label>' +
						'<input type="text" name="berat" class="form-control" value="' + response.berat_aktual + '" id="berat">' +

						'</div>' +


						'</div>' +
						'</div>';
					$('#contentEditDimension').html(content);
					$('#selectField').select2();

				},
				error: function() {
					alert('Terjadi kesalahan dalam memuat data.');
				}
			});


		});
	});
</script>



