<style>
	.datepicker-inline {
		width: auto;
		/*what ever width you want*/
	}
</style>

<?php
function getGrade($nilai)
{
	if ($nilai >= 80) {
		return 'A';
	} elseif ($nilai >= 60) {
		return 'B';
	} elseif ($nilai >= 40) {
		return 'C';
	} elseif ($nilai >= 20) {
		return 'D';
	} else {
		return 'E';
	}
}

?>

<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Card-->
			<div class="card">
				<div class="card-header flex-wrap border-0 pt-6 pb-0">
					<div class="card-title">

						<h3 class="card-label"><?= $title ?>
							<span class="d-block text-muted pt-2 font-size-sm"></span>
						</h3>

					</div>


					<div class="card-toolbar float-right">



						<!--begin::Button-->
						<a href="#" class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#modal-lg" style="background-color: #9c223b;">
							<span class="svg-icon svg-icon-md">
								<i class="fa fa-plus text-light"></i>
								<!--end::Svg Icon-->
							</span>Add</a>
						<!--end::Button-->
					</div>
				</div>
				<div class="col-md-12">
					<nav>
						<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
							<a class="nav-item nav-link active" id="nav-scanin-tab" data-toggle="tab" href="#nav-scanin" role="tab" aria-controls="nav-scanin" aria-selected="true">Scan IN</a>
							<a class="nav-item nav-link" id="nav-scanout-tab" data-toggle="tab" href="#nav-scanout" role="tab" aria-controls="nav-scanout" aria-selected="false">Scan Out</a>

						</div>
					</nav>
				</div>
				<div class="card-body" style="overflow: auto;">

					<div class="col-md-12">

						<div class="tab-content" id="nav-tabContent">
							<div class="tab-pane fade show active" id="nav-scanin" role="tabpanel" aria-labelledby="nav-scanin-tab">

								<div class="row">
									<div class="col-12">
										<div class="card card-custom card-stretch">

											<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
											<div class="row">
												<div class="col-md-6">
													<div class="panel-heading ml-2">
														<div class="navbar-form navbar-left">
															<h4>SCAN IN</h4>
														</div>
														<div class="navbar-form navbar-center">
															<select class="form-control" id="selectCamera" style="width: 80%;"></select>
														</div>

													</div>
												</div>
												<div class="col-md-6">
													<div class="well" style="position: middle;">
														<form action="<?php echo base_url('scan/outbond'); ?>" method="POST">
															<canvas id="scanOutbondIn" width="400" height="400"></canvas>
															<br>
															<input type="text" name="id_karyawan" autofocus>
															<input type="submit">
														</form>

													</div>
												</div>
											</div>
											<!-- /.box-body -->
											<div class="row m-4" style="overflow: auto;">
												<div class="col-md-12">
													<table id="myTable" class="table table-bordered">
														<h3 class="title font-weight-bold">List Scan In/Out</h3>
														<!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
														<p><?= $this->session->flashdata('message'); ?></p>
														<thead>
															<tr>
																<th style="width: 10%;">Shipment ID</th>
																<th style="width: 15%;">Shipper</th>
																<th style="width: 15%;">Consignee</th>
																<th style="width: 5%;">Last Status</th>
																<th style="width: 5%;">Action</th>

															</tr>
														</thead>
														<tbody>
															<?php foreach ($outbond as $g) {

																$getLast = $this->order->getLastTracking($g['shipment_id'])->row_array();

																if ($getLast['flag'] >= 3 && $getLast['flag'] <= 4) {
															?>
																	<tr>
																		<td><?= $g['shipment_id'] ?></td>
																		<td><?= $g['shipper'] ?><br><?= $g['tree_shipper'] ?></td>
																		<td><?= $g['consigne'] ?><br><?= $g['tree_consignee'] ?></td>
																		<td><?= $getLast['status'] ?></td>
																		<?php if ($getLast['flag'] == 3) { ?>
																			<td>Scan IN</td>
																		<?php } elseif ($getLast['flag'] == 4) { ?>
																			<td>Scan Out</td>
																		<?php } ?>

																	</tr>

															<?php }
															} ?>
														</tbody>


													</table>
												</div>
											</div>
										</div>

									</div>
								</div>

							</div>
							<div class="tab-pane fade" id="nav-scanout" role="tabpanel" aria-labelledby="nav-profile-scanout">
								<div class="row">
									<div class="col-12">
										<div class="card card-custom card-stretch">

											<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
											<div class="row">
												<div class="col-md-6">
													<div class="panel-heading ml-2">
														<div class="navbar-form navbar-left">
															<h4>SCAN OUT</h4>
														</div>
														<div class="navbar-form navbar-center">
															<select class="form-control" id="camera-selectOut" style="width: 80%;"></select>
														</div>

													</div>
												</div>
												<div class="col-md-6">
													<div class="well" style="position: middle;">
														<form action="<?php echo base_url('scan/outbond'); ?>" method="POST">
															<canvas id="scanOutbondOut" width="400" height="400"></canvas>
															<br>
															<input type="text" name="id_karyawan" autofocus>
															<input type="submit">
														</form>

													</div>
												</div>
											</div>
											<!-- /.box-body -->
											<div class="row m-4" style="overflow: auto;">
												<div class="col-md-12">
													<table id="myTable" class="table table-bordered">
														<h3 class="title font-weight-bold">List Scan In/Out</h3>
														<!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
														<p><?= $this->session->flashdata('message'); ?></p>
														<thead>
															<tr>
																<th style="width: 10%;">Shipment ID</th>
																<th style="width: 15%;">Shipper</th>
																<th style="width: 15%;">Consignee</th>
																<th style="width: 5%;">Last Status</th>
																<th style="width: 5%;">Action</th>

															</tr>
														</thead>
														<tbody>
															<?php foreach ($outbond as $g) {

																$getLast = $this->order->getLastTracking($g['shipment_id'])->row_array();

																if ($getLast['flag'] >= 3 && $getLast['flag'] <= 4) {
															?>
																	<tr>
																		<td><?= $g['shipment_id'] ?></td>
																		<td><?= $g['shipper'] ?><br><?= $g['tree_shipper'] ?></td>
																		<td><?= $g['consigne'] ?><br><?= $g['tree_consignee'] ?></td>
																		<td><?= $getLast['status'] ?></td>
																		<?php if ($getLast['flag'] == 3) { ?>
																			<td>Scan IN</td>
																		<?php } elseif ($getLast['flag'] == 4) { ?>
																			<td>Scan Out</td>
																		<?php } ?>

																	</tr>

															<?php }
															} ?>
														</tbody>


													</table>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
					<!--begin: Datatable-->

					<!--end: Datatable-->

				</div>
			</div>
			<!--end::Card-->
		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->
</div>