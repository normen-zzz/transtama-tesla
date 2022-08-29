	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h2 class="card-title">Tambah Pengajuan Wisuda</h2>
						</div>
						<!-- /.card-header -->
						<div class="card-body" style="overflow: auto;">
							<div class="card-body p-0">
								<!--begin: Wizard-->
								<div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="step-first" data-wizard-clickable="true">
									<!--begin: Wizard Nav-->
									<div class="wizard-nav">
										<div class="wizard-steps px-8 py-8 px-lg-15 py-lg-3">
											<!--begin::Wizard Step 1 Nav-->
											<div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
												<div class="wizard-label">
													<h3 class="wizard-title">
														<span>1.</span>Biodata Mahasiswa
													</h3>
													<div class="wizard-bar"></div>
												</div>
											</div>
											<!--end::Wizard Step 1 Nav-->
											<!--begin::Wizard Step 4 Nav-->
											<div class="wizard-step" data-wizard-type="step">
												<div class="wizard-label">
													<h3 class="wizard-title">
														<span>2.</span>Berkas
													</h3>
													<div class="wizard-bar"></div>
												</div>
											</div>
											<!--end::Wizard Step 4 Nav-->
										</div>

									</div>
									<!--end: Wizard Nav-->
									<!--begin: Wizard Body-->
									<div class="row justify-content-center py-10 px-8 py-lg-12 px-lg-10">
										<div class="col-xl-12 col-xxl-7">
											<!--begin: Wizard Form-->
											<form id="kt_form" novalidate="novalidate" action="<?= base_url('baak/pengajuan/add') ?>" method="POST" enctype="multipart/form-data">
												<!--begin: Wizard Step 1-->
												<div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
													<h4 class="mb-10 font-weight-bold text-dark">Lengkapi Biodata Diri Mahasiswa</h4>
													<!--begin::Input-->
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Nama Mahasiswa <small class="text-danger">(*Required)</small></label> <br>
																<?= form_error('nama_mhs', '<small class="text-danger pl-3">', '</small>'); ?>
																<input type="text" class="form-control" required name="nama_mhs">
															</div>
														</div>

														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Tempat Lahir </label>
																<input type="text" class="form-control" required name="tempat_lahir">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Tanggal Lahir </label>
																<input type="date" class="form-control" required name="tgl_lahir">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">NIM <small class="text-danger">(*Required)</small></label> <br>
																<?= form_error('nim', '<small class="text-danger pl-3">', '</small>'); ?>
																<input type="text" class="form-control" required name="nim">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">NIK <small class="text-danger">(*Required)</small></label> <br>
																<?= form_error('nik', '<small class="text-danger pl-3">', '</small>'); ?>
																<input type="number" class="form-control" max="16" min="16" required name="nik">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Prodi</label>
																<select name="prodi" class="form-control">
																	<?php foreach ($jurusan as $pr) {
																	?>
																		<option value="<?= $pr['id_prodi'] ?>"><?= $pr['nama_prodi'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Fakultas</label>
																<select name="fakultas" class="form-control">
																	<?php foreach ($fakultas as $f) {
																	?>
																		<option value="<?= $f['id_fak'] ?>"><?= $f['nama_fakultas'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Gelar</label>
																<select name="gelar" class="form-control">
																	<?php foreach ($jurusan as $pr) {
																	?>
																		<option value="<?= $pr['gelar'] ?>"><?= $pr['gelar'] ?></option>
																	<?php  } ?>
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Tanggal Lulus</label>
																<input type="date" class="form-control" required name="tgl_lulus">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">No. Ijazah</label>
																<input type="text" class="form-control" required name="no_ijazah">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">No. SK BAN-PT</label>
																<input type="text" class="form-control" required name="no_sk_ban_pt">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">No. SK Pendirian PT</label>
																<input type="text" class="form-control" required name="no_sk_pendirian">
															</div>
														</div>

													</div>

												</div>

												<!--end: Wizard Step 1-->
												<!--begin: Wizard Step 4-->
												<div class="pb-5" data-wizard-type="step-content">
													<h4 class="mb-10 font-weight-bold text-dark">Lengkapi Berkas Dibawah Ini - <small style="color: red;">Format yang diizinkan (PNG,JPEG,JPG)</small>
													</h4>
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">KTP</label>
																<input type="file" class="form-control" name="ktp">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Ijazah</label>
																<input type="file" class="form-control" name="ijazah">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Akte</label>
																<input type="file" class="form-control" name="akte">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">SKL</label>
																<input type="file" class="form-control" name="skl">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Yudisium</label>
																<input type="file" class="form-control" name="yudisium">
															</div>
														</div>
													</div>

												</div>
												<!--end: Wizard Step 4-->
												<!--begin: Wizard Actions-->
												<div class="d-flex justify-content-between border-top mt-5 pt-10">
													<div class="mr-2">
														<button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-prev">Previous</button>
													</div>
													<div>
														<button type="button" onclick="return confirm('Apakah Data Sudah Sesuai ?')" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-submit">Submit</button>
														<button type="button" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-next">Next</button>
													</div>
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

	<div class="modal fade" id="modal-lg">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Tambah Pengajuan Ijazah</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('superadmin/prodi/addProdi') ?>" method="POST">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1">Nama Mahasiswa</label>
									<input type="text" class="form-control" id="exampleInputEmail1" required name="nama_mhs">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1">NIM</label>
									<input type="text" class="form-control" id="exampleInputEmail1" required name="nim">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1">Tempat Lahir</label>
									<input type="text" class="form-control" id="exampleInputEmail1" required name="tempat_lahir">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1">Tanggal Lahir</label>
									<input type="date" class="form-control" id="exampleInputEmail1" required name="tgl_lahir">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1">Jenis Kelamin</label>
									<select name="jk" class="form-control">
										<option value="Laki-laki">Laki-laki</option>
										<option value="Perempuan">Perempuan</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1">NIK</label>
									<input type="text" class="form-control" id="exampleInputEmail1" required name="nik">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1">Agama</label>
									<select name="agama" class="form-control">
										<?php foreach ($agama as $a) {
										?>
											<option value="<?= $a['nm_agama'] ?>"><?= $a['nm_agama'] ?></option>
										<?php  } ?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1">Fakultas</label>
									<select name="fakultas" class="form-control">
										<?php foreach ($fakultas as $f) {
										?>
											<option value="<?= $f['nama_fakultas'] ?>"><?= $f['nama_fakultas'] ?></option>
										<?php  } ?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1">Prodi</label>
									<select name="prodi" class="form-control">
										<?php foreach ($jurusan as $pr) {
										?>
											<option value="<?= $pr['nama_jurusan'] ?>"><?= $pr['nama_jurusan'] ?></option>
										<?php  } ?>
									</select>
								</div>
							</div>

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
		<!-- /.modal -->