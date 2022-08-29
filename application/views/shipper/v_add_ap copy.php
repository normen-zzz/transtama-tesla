	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h2 class="card-title"><?= $title ?></h2>
						</div>
						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<div class="card-body p-0">
								<!--begin: Wizard-->

								<div class="row justify-content-center">
									<div class="col-xl-12 col-xxl-7">
										<!--begin: Wizard Form-->
										<form action="<?= base_url('shipper/ap/processAdd') ?>" method="POST" enctype="multipart/form-data">
											<div class="row">
												<div class="col-md-8">
													<div class="form-group">
														<label for="exampleInputEmail1">Purpose <span class="text-danger">*</span></label>
														<textarea class="form-control" name="purpose"></textarea>
													</div>
												</div>
												<div class="col-md-4">
													<label for="note_cs">Choose AP</label>
													<div class="form-group">
														<select name="id_kategori_pengeluaran" class="form-control">
															<?php foreach ($kategori_ap as $kat) {
															?>
																<option value="<?= $kat['id_kategori_ap'] ?>"><?= $kat['nama_kategori'] ?></option>

															<?php	} ?>
														</select>
													</div>
												</div>
											</div>
											<!--begin: Wizard Step 1-->
											<label for="exampleInputEmail1"><button type="button" class="btn btn-info tambah-ap"><i class="fa fa-plus"> Add Details</i> </button> </label>
											<?= $this->session->userdata('message') ?>
											<!--begin::Input-->
											<div class="row">
												<div class="col-md-2">
													<label for="note_cs">Choose Category 1</label>
													<div class="form-group rec-element-ap">
														<select name="id_kategori_pengeluaran[]" class="form-control">
															<?php foreach ($kategori_pengeluaran as $kat) {
															?>
																<option value="<?= $kat['id_kategori'] ?>"><?= $kat['nama_kategori_pengeluaran'] ?></option>

															<?php	} ?>
														</select>
													</div>
												</div>
												<div class="col-md-3">
													<label for="note_cs">Description 1</label>
													<div class="form-group rec-element-ap">
														<textarea class="form-control" id="descriptions" name="descriptions[]"></textarea>
													</div>
												</div>
												<div class="col-md-3">
													<label for="note_cs">Amount Proposed 1</label>
													<div class="form-group rec-element-ap">
														<input type="text" class="form-control" id="amount" name="amount_proposed[]">
													</div>
												</div>
												<div class="col-md-4">
													<label for="note_cs">Attachment 1</label>
													<div class="form-group rec-element-ap">
														<input type="file" class="form-control" id="attachment" name="attachment[]">
													</div>
												</div>

												<div class="ln_solid_ap"></div>
												<div id="nextkolom_ap" name="nextkolom_ap"></div>
												<button type="button" id="jumlahkolom_ap" value="1" style="display:none"></button>


											</div>



											<!--end: Wizard Step 1-->

											<!--begin: Wizard Actions-->
											<div class="d-flex justify-content-between border-top mt-5 pt-10">
												<div>
													<button type="submit" class="btn btn font-weight-bolder text-uppercase px-9 py-4 text-light" data-wizard-type="action-submit" style="background-color: #9c223b;">Submit</button>
												</div>
											</div>
											<!--end: Wizard Actions-->
										</form>
										<!--end: Wizard Form-->
									</div>
								</div>
								<!--end: Wizard Body-->

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



	<div class="modal fade" id="modal-lg">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Signature</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('superadmin/role/addRole') ?>" method="POST">
						<div class="col-md-12">
							<label style="font-weight:bold">Signature</label>
							<div id="signature" style="height: 300%; width:100%;   border: 1px solid black;"></div><br />
						</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" id="click" class="btn text-light" data-dismiss="modal" style="background-color: #9c223b;">Submit</button>
					<!-- <button type="submit" class="btn btn-primary">Submit</button> -->
				</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->