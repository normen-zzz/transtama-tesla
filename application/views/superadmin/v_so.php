	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="container">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card card-custom card-stretch">
						<div class="card-header py-3">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bolder text-dark">Sales Order</h3>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Order Information</span>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<table id="mytablesoinsuperadmin" class="table table-bordered">
								<!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
								<p><?= $this->session->flashdata('message'); ?></p>
								<thead>
									<tr>
										<th style="width: 15%;">Sales</th>
										<th style="width: 15%;">PU. Date</th>
										<th style="width: 5%;">Time</th>
										<th style="width: 20%;">Shipper</th>
										<th style="width: 20%;">Destination</th>
										<th style="width: 20%;">Pu. Poin</th>
										<th style="width: 20%;">Pickup Status</th>
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