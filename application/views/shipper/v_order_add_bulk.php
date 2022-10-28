	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h2 class="card-title">Add Bulk Order</h2>

							<div class="card-toolbar">
								<a href="<?= base_url('uploads/import.xlsx') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-download text-light"> </i>
									Download Template
								</a>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<div class="card-body p-0">
								<!--begin: Wizard-->
								<div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="step-first" data-wizard-clickable="true">
									<!--begin: Wizard Body-->
									<div class="row justify-content-center py-10 px-8 py-lg-12 px-lg-10">
										<div class="col-xl-12 col-xxl-7">
											<!--begin: Wizard Form-->
											<form id="kt_form" novalidate="novalidate" action="<?= base_url('shipper/order/import') ?>" method="POST" enctype="multipart/form-data">
												<div class="form-group">
													<label class="col-form-label text-lg-right font-weight-bold">Upload File</label>
													<input type="file" id="input-file-now" name="upload_file" class="dropify" />
													<input type="text" name="id_so" value="<?= $id_so ?>" hidden>
													<input type="text" name="id_tracking" value="<?= $id_tracking ?>">
												</div>
												<!--begin: Wizard Actions-->
												<div class="d-flex justify-content-between border-top mt-5 pt-10">

													<button type="submit" class="btn mr-2 text-light" style="background-color: #9c223b;">Submit</button>
													<a href="<?= base_url('shipper/order/view/' . $id_so.'/'.$id_tracking) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
														<i class="fas fa-chevron-circle-left text-light"> </i>
														Back
													</a>

												</div>
												<!--end: Wizard Actions-->
											</form>
											<!--end: Wizard Form-->
										</div>
									</div>
									<!--end: Wizard Body-->
								</div>
								<!--end: Wizard-->
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