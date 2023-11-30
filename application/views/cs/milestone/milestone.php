	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch">
						<div class="card-header py-3">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bolder text-dark">Milestone</h3>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Shipment Information</span>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<table id="tableMilestone" class="table table-bordered">
								<!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
								<p><?= $this->session->flashdata('message'); ?></p>
								<thead>
									<tr>
										<th style="width: 15%;">Resi</th>
										<th style="width: 15%;">PU. Date</th>
										<th style="width: 5%;">Time</th>
										<th style="width: 20%;">Shipper</th>
										<th style="width: 20%;">Destination</th>
										<th style="width: 20%;">Pu. Poin</th>
										
										<th style="width: 15%;">Type</th>
										<!-- <th>Status</th> -->
										<th>Action</th>
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

	<script>
		var tabel = null;
		$(document).ready(function() {
			tabel = $('#tableMilestone').DataTable({
				"processing": true,
				// "responsive": true,
				"serverSide": true,
				"ordering": true, // Set true agar bisa di sorting
				"dom": "<'row'<'col-lg-10 col-md-10 col-xs-12'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
					"<'row'<'col-lg-10 col-md-10 col-xs-12'l>>",
				"order": [
					[1, 'desc']
				], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
				"ajax": {
					"url": "<?= base_url('cs/Milestone/getDataMilestone'); ?>", // URL file untuk proses select datanya
					"type": "POST"
				},
				"deferRender": true,
				"aLengthMenu": [
					[10, 50,100],
					[10, 50,100]
				], // Combobox Limit
				"columns": [{
						"data": "shipment_id",
						
					}, {
						"data": "tgl_pickup",
					},
					{
						"data": "time",
					},
					{
						"data": "shipper",
					},
					{
						"data": "destination",
					},
					{
						"data": "pu_poin",
					},
					
					{
						"data": "is_incoming",
						"render": function(data, type, row, meta) {
							if (data == 0) {
								return 'Outgoing';
							} else {
								return 'Incoming';
							}
						}
					},
					// {
					// 	"data": "status",
					// 	"render": function(data, type, row, meta) {
					// 		if (data == 0) {
					// 			return '<a href="#" class="btn btn-danger font-weight-bold btn-pill">Order In</a>';
					// 		} else if (data == 1) {
					// 			return '<a href="#" class="btn btn-success font-weight-bold btn-pill">Order PU</a>';
					// 		} else if (data == 2) {
					// 			return '<a href="#" class="btn btn-success font-weight-bold btn-pill">Order Pickuped</a>';
					// 		} else {
					// 			return '<a href="#" class="btn btn-success font-weight-bold btn-pill">Order Finished</a>';
					// 		}
					// 	}
					// },
					{
						"data": "shipment_id",
						"render": function(data, type, row, meta) {
							return `<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('cs/Milestone/detailMilestone/') ?>` + data + `" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>`;

						}
					},
				],
			});
		});
	</script>