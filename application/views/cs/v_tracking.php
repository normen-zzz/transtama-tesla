<link rel="stylesheet" href="<?php echo base_url() ?>assets/scans/css/style.css">
<!-- Main content -->
<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="container">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-12">
				<div class="card card-custom card-stretch">
					<div class="card-header py-3">
						<div class="card-title align-items-start flex-column">
							<h3 class="card-label font-weight-bolder text-dark">Update Tracking</h3>
							<span class="text-muted font-weight-bold font-size-sm mt-1">Input Shipment Number</span>
						</div>
						<div class="card-toolbar">

						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body" style="overflow: auto;">
						<div class="row">
							<div class="col-md-4">
								<form id="formSearchTracking">

									<label for="shipment_id">Shipment ID</label>
									<input type="text" class="form-control" name="resi" id="shipment_id" required>
									<button type="submit" class="btn btn-success mt-2 btnSearchTracking">View</button>
									<!-- <div class="navbar-form navbar-center">
										<select class="form-control" id="selectCamCs" style="width: 80%;"></select>
									</div>
									<canvas class="mt-2" id="cobascanCS" width="400" height="400"></canvas> -->
								</form>
							</div>

							<div class="col-md-8">
								<h4 class="title">Milestone AWB <div class="shipment_id"></div>
								</h4>
								<div class="row">
									<div class="col-md-6">Shipper : <b>
											<div class="shipper"></div> - <div class="tree_shipper"></div>
										</b> </div>
									<div class="col-md-6">Consignee : <b>
											<div class="consigne"></div> - <div class="tree_consignee"></div>
										</b> </div>
								</div>
								<div class="row">

									<div class="col">Driver : <b>
											<div class="nama_driver"></div>
										</b> </div>
								</div>
								<br>

								<a href="#" class="btn btn-sm text-light mb-1" data-toggle="modal" data-target="#modalAddTracking" style="background-color: #9c223b;">
									<span class="fa fa-plus">
									</span> Add Status</a>


								<table class="table table-bordered">
									<tr>
										<td>Status</td>
										<td>Date</td>
										<td>Time</td>
										<td>Action</td>
									</tr>
									<tbody id="dataTracking">
										<tr>
											<td colspan="4">No Data</td>
										</tr>
									</tbody>
								</table>

							</div>

						</div>
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






<div class="modal fade" id="modalAddTracking">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Status Shipment <b class="shipment_id"></b> </h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="formAddTracking">
					<div class="card-body">
						<div class="row">
							<input type="text" name="id_so" id="id_soAdd" class="form-control" value="" hidden>
							<input type="text" name="id_user" id="id_userAdd" class="form-control" value="" hidden>
							<input type="text" name="shipment_id" id="shipment_idAdd" class="form-control" value="" hidden>
							<div class="col-md-6">
								<label for="status">Choose Status : </label>
								<select name="status" class="form-control">
									<option value="Permintaan pickup dari pengirim">Permintaan pickup oleh shipper</option>
									<option value="Driver Menuju Lokasi Pickup">Driver Menuju Lokasi Pickup</option>
									<option value="Driver Telah Sampai Di Lokasi Pickup">Driver Telah Sampai Di Lokasi Pickup</option>
									<option value="Paket Telah Dipickup Oleh Driver">Paket Telah Dipickup Oleh Driver</option>
									<option value="Paket Telah Tiba Di Hub Jakarta Pusat">Paket Telah Tiba Di Hub Jakarta Pusat</option>
									<option value="Paket Telah Keluar Dari Hub Jakarta Pusat">Paket Telah Keluar Dari Hub Jakarta Pusat</option>
									<option value="Paket Telah Tiba Di Hub CGK">Paket Telah Tiba Di Hub CGK</option>
									<option value="Paket Telah Keluar Dari Hub CGK">Paket Telah Keluar Dari Hub CGK</option>
									<option value="Paket Telah Tiba Di Hub Tujuan dan sedang dalam proses pengantaran">Paket Telah Tiba Di Hub Tujuan dan sedang dalam proses pengantaran</option>
									<option value="Paket Telah Diterima Oleh">Paket Telah Diterima Oleh</option>
								</select>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Note :<span style="color: red;">Soekarno Hatta or, Cengkareng, or consigne nama</span> </label>
									<input type="text" class="form-control" name="note">
								</div>

							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1">Date<span style="color: red;">*</span></label>
									<input type="date" class="form-control" id="tgl_pickup" required name="date" value="<?= date('Y-m-d') ?>">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="exampleInputEmail1">Time<span style="color: red;">*</span></label>
									<input type="time" class="form-control" required name="time" value="<?= date("H:i:s"); ?>">
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1">POD/POP</label>
									<!-- <input type="file" class="form-control" name="ktp"> -->
									<input type="file" class="form-control" name="ktp[]" accept="image/*" capture multiple>
								</div>

							</div>



						</div>
					</div>
					<!-- /.card-body -->
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>


<div class="modal fade" id="modalEditTracking">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Update Status Shipment</b> </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('cs/SalesOrder/updateShipmentTracking') ?>" method="POST" enctype="multipart/form-data">
					<div class="card-body">
						<div class="row" id="content-tracking">


						</div>
					</div>
					<!-- /.card-body -->
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<script>
	$(document).ready(function() {
		$(document).on('click', '.modalEditTracking', function() {

			var id_tracking = $(this).data('id_tracking'); // Mendapatkan ID dari atribut data-id tombol yang diklik
			// $('#content-tracking').html('');
			// Memuat data menggunakan AJAX dengan mengirimkan ID sebagai parameter
			$.ajax({
				url: '<?php echo base_url("cs/SalesOrder/getModalTracking"); ?>',
				type: 'GET',
				dataType: 'json',
				data: {
					id_tracking: id_tracking
				},
				success: function(response) {
					// Menampilkan data ke dalam modal

					var time = response.time;
					if (response.note == null) {
						response.note = '';
					}

					var content = '<input type="text" name="id_so" class="form-control" hidden value="' + response.id_so + '">' +
						'<input type="text" name="id_tracking" class="form-control" hidden value="' + response.id_tracking + '">' +
						'<input type="text" name="shipment_id" class="form-control" hidden value="' + response.shipment_id + '">' +
						'<div class="col-md-6">' +
						'<label for="status">Status</label>' +
						'<input type="text" name="status" class="form-control" value="' + response.status + '">' +

						'</div>' +
						'<div class="col-md-6">' +
						'<div class="form-group">' +
						'<label for="exampleInputPassword1">Note :<span style="color: red;">Soekarno Hatta or, Cengkareng, or consigne nama</span> </label>' +
						'<input type="text" class="form-control" name="note" value="' + response.note + '">' +
						'</div>' +

						'</div>' +
						'<div class="col-md-4">' +
						'<div class="form-group">' +
						'<label for="exampleInputEmail1">Date<span style="color: red;">*</span></label>' +
						'<input type="date" class="form-control" value="' + response.created_at + '" id="tgl_pickup" required name="date">' +
						'</div>' +
						'</div>' +
						'<div class="col-md-4">' +
						'<label for="status">Flag</label>' +
						'<input type="text" name="flag" class="form-control" value="' + response.flag + '">' +

						'</div>' +
						'<div class="col-md-4">' +
						'<label for="status">Excecution Status</label>' +

						'<select name="status_eksekusi" class="form-control">' +
						'<option value="0"';

					if (response.status_eksekusi == 0) {
						content += 'selected';
					}
					content += '>Pending</option>' +
						'<option value="1"';
					if (response.status_eksekusi == 1) {
						content += 'selected';
					}
					content += '>Success</option>' +
						'</select>' +

						'</div>' +
						'<div class="col-md-4">' +
						'<div class="form-group">' +
						'<label for="exampleInputEmail1">Time<span style="color: red;">*</span></label>' +

						'<input type="time" class="form-control" required name="time" value="' + response.time + '">' +
						'</div>' +
						'</div>' +

						'<div class="col-md-4">' +
						'<div class="form-group">' +
						'<label for="exampleInputEmail1">POD/POP</label>' +

						'<input type="file" class="form-control" name="ktp[]" accept="image/*" capture multiple>' +
						'</div>' +

						'</div>';
					$('#content-tracking').html(content);
					$('#selectField').select2();

				},
				error: function() {
					alert('Terjadi kesalahan dalam memuat data.');
				}
			});
		});
	})
</script>

<script>
	// formAddTracking 
	$('#formAddTracking').submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		// btnSearchTracking enable
		$('.btnSearchTracking').prop('disabled', false);

		// swal confirm
		Swal.fire({
			title: 'Apakah Anda Yakin?',
			text: "Data yang diinput tidak dapat diubah kembali!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Input!',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.isConfirmed) {
				// swal loading 
				Swal.fire({
					title: 'Loading',
					willOpen: () => {
						Swal.showLoading()
					},
					allowOutsideClick: false,
					showConfirmButton: false,
				});
				$.ajax({
					url: '<?= base_url('cs/SalesOrder/updateShipmentTrackingAdd2') ?>',
					type: 'POST',
					dataType: 'json',
					data: formData,
					contentType: false,
					processData: false,
					success: function(response) {
						// dari json encode $response di controller

						if (response.status == 'error') {
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: response.message,
							});
							return false;
						} else {
							Swal.fire({
								icon: 'success',
								title: 'Success',
								text: response.message,
								showConfirmButton: true,
							}).then((result) => {
								if (result.isConfirmed) {

									Swal.fire({
										title: 'Loading',
										onBeforeOpen: () => {
											Swal.showLoading()
										},
										allowOutsideClick: false,
										showConfirmButton: false,
									});

									$('#dataTracking').html('-');
									var shipment_id = $('#shipment_id').val();
									$html = '';
									$.ajax({
										url: '<?= base_url('cs/SalesOrder/getDataTracking') ?>',
										type: 'POST',
										dataType: 'json',
										data: {
											shipment_id: shipment_id
										},
										success: function(response) {
											response = response.data;
											// data yang ada di response lebih dari 1 dengan each
											$.each(response, function(index, value) {

												$html += '<tr>';
												$html += '<td>' + value.status + '</td>';
												$html += '<td>' + value.created_at + '</td>';
												$html += '<td>' + value.time + '</td>';
												$html += '<td><button type="button" class="btn btn-primary btn-sm modalEditTracking" data-toggle="modal" data-target="#modalEditTracking" data-id_tracking="' + value.id_tracking + '">Edit</button></td>';
												$html += '<td><button type="button" class="btn btn-danger btn-sm deleteTracking" data-id_tracking="' + value.id_tracking + '">Delete</button></td>';
												$html += '</tr>';
											});
											// swal close
											$('#dataTracking').html($html);
											Swal.close();



										},
										error: function() {
											Swal.fire({
												icon: 'error',
												title: 'Oops... DATA TIDAK TERSEDIA',
												text: 'Data tidak ditemukan',
											});
											return false;
										}
									});


									$('#modalAddTracking').modal('hide');
								}
							});
						}
					}
				});
			}
		});

	});
</script>

<script>
	// formSearchTracking
	$('#formSearchTracking').submit(function(e) {
		e.preventDefault();
		var shipment_id = $('#shipment_id').val();
		// btnSearchTracking enable
		$('.btnSearchTracking').prop('disabled', false);
		// swal loading 
		Swal.fire({
			title: 'Loading',
			onBeforeOpen: () => {
				Swal.showLoading()
			},
			allowOutsideClick: false,
			showConfirmButton: false,
		});

		$html = '';
		$.ajax({
			url: '<?= base_url('cs/SalesOrder/getDataTracking') ?>',
			type: 'POST',
			dataType: 'json',
			data: {
				shipment_id: shipment_id
			},
			success: function(response) {
				response = response.data;
				// data yang ada di response lebih dari 1 dengan each
				$.each(response, function(index, value) {

					$html += '<tr>';
					$html += '<td>' + value.status + '</td>';
					$html += '<td>' + value.created_at + '</td>';
					$html += '<td>' + value.time + '</td>';
					$html += '<td><button type="button" class="btn btn-primary btn-sm modalEditTracking" data-toggle="modal" data-target="#modalEditTracking" data-id_tracking="' + value.id_tracking + '">Edit</button></td>';
					$html += '<td><button type="button" class="btn btn-danger btn-sm deleteTracking" data-id_tracking="' + value.id_tracking + '">Delete</button></td>';
					$html += '</tr>';
				});
				

				$('#dataTracking').html($html);
				// swal close
				Swal.close();

			},
			error: function() {
				Swal.fire({
					icon: 'error',
					title: 'Oops... DATA TIDAK TERSEDIA',
					text: 'Data tidak ditemukan',
				});
				return false;
			}
		});
		$.ajax({
			url: '<?= base_url('cs/SalesOrder/getDataSo') ?>',
			type: 'POST',
			dataType: 'json',
			data: {
				shipment_id: shipment_id
			},
			success: function(response) {
				if (response.status == 'error') {
					Swal.fire({
						icon: 'error',
						title: 'Oops... DATA TIDAK TERSEDIA',
						text: response.message,
					});
					return false;

				} else {
					response = response.data;

					$('.shipment_id').html(response.shipment_id);
					$('.shipper').html(response.shipper);
					$('.tree_shipper').html(response.tree_shipper);
					$('.consigne').html(response.consigne);
					$('.tree_consignee').html(response.tree_consignee);
					$('#id_soAdd').val(response.id_so);
					$('#id_userAdd').val(response.id_user);
					$('#shipment_idAdd').val(response.shipment_id);
					$('.nama_driver').html(response.nama_driver);
					Swal.close();
				}
			}
		});
	});
</script>

<script>
	// deleteTracking
	$(document).on('click', '.deleteTracking', function() {
		var id_tracking = $(this).data('id_tracking');
		Swal.fire({
			title: 'Apakah Anda Yakin?',
			text: "Data yang dihapus tidak dapat dikembalikan!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Ya, Hapus!',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: '<?= base_url('cs/SalesOrder/deleteShipmentTracking') ?>',
					type: 'POST',
					dataType: 'json',
					data: {
						id_tracking: id_tracking
					},
					success: function(response) {
						if (response.status == 'error') {
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: response.message,
							});
							return false;
						} else {
							Swal.fire({
								icon: 'success',
								title: 'Success',
								text: response.message,
								showConfirmButton: true,
							}).then((result) => {
								if (result.isConfirmed) {
									Swal.fire({
										title: 'Loading',
										onBeforeOpen: () => {
											Swal.showLoading()
										},
										allowOutsideClick: false,
										showConfirmButton: false,
									});
									$('#dataTracking').html('-');
									var shipment_id = $('#shipment_id').val();
									$html = '';
									$.ajax({
										url: '<?= base_url('cs/SalesOrder/getDataTracking') ?>',
										type: 'POST',
										dataType: 'json',
										data: {
											shipment_id: shipment_id
										},
										success: function(response) {
											response = response.data;
											// data yang ada di response lebih dari 1 dengan each
											$.each(response, function(index, value) {

												$html += '<tr>';
												$html += '<td>' + value.status + '</td>';
												$html += '<td>' + value.created_at + '</td>';
												$html += '<td>' + value.time + '</td>';
												$html += '<td><button type="button" class="btn btn-primary btn-sm modalEditTracking" data-toggle="modal" data-target="#modalEditTracking" data-id_tracking="' + value.id_tracking + '">Edit</button></td>';
												$html += '<td><button type="button" class="btn btn-danger btn-sm deleteTracking" data-id_tracking="' + value.id_tracking + '">Delete</button></td>';
												$html += '</tr>';
											});
											// swal close
											$('#dataTracking').html($html);
											Swal.close();
										},
										error: function() {
											Swal.fire({
												icon: 'error',
												title: 'Oops... DATA TIDAK TERSEDIA',
												text: 'Data tidak ditemukan',
											});
											return false;
										}
									});
								}
							});
						}
					}
				});
			}
		});
	});
</script>