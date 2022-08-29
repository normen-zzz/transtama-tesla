	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch">
						<div class="card-header py-3">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bolder text-dark">Shipment Information</h3>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Input Your Shipment Information</span>
							</div>
							<div class="card-toolbar">

							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<table id="mytablecs" class="table table-bordered">
								<!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
								<p><?= $this->session->flashdata('message'); ?></p>
								<thead>
									<tr>
										<th style="width: 10%;">Shipment ID</th>
										<!-- <th style="width: 10%;">Driver</th> -->
										<!-- <th style="width: 20%;">Image</th> -->
										<!-- <th>Signature</th> -->
										<th>Created At</th>
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