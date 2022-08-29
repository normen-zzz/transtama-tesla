<style type="text/css">
	.txtedit {
		display: none;
		width: 98%;
	}
</style>

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h2 class="card-title"><?= $title ?></h2>
						<div class="card-toolbar">
							<a href="<?= base_url('finance/ap') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
								<i class="fas fa-chevron-circle-left text-light"> </i>
								Back
							</a>
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body" style="overflow: auto;">
						<div class="card-body p-0">
							<!--begin: Wizard-->

							<div class="row justify-content-center">
								<div class="col-xl-12 col-xxl-7">
									<!--begin: Wizard Form-->
									<form action="<?= base_url('finance/ap/processAddDetail') ?>" method="POST" enctype="multipart/form-data">
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Purpose <span class="text-danger">*</span></label>
													<textarea class="form-control" required name="purpose"><?= $info['purpose'] ?></textarea>
													<input type="text" class="form-control" name="no_pengeluaran1" hidden value="<?= $info['no_pengeluaran'] ?>">
													<input type="text" class="form-control" name="id_kategori_pengeluaran1" hidden value="<?= $info['id_kat_ap'] ?>">
													<input type="text" class="form-control" name="total_lama" hidden value="<?= $info['total'] ?>">
												</div>
											</div>
											<div class="col-md-4">
												<label for="note_cs">Choose AP</label>
												<div class="form-group">
													<select name="id_kategori_pengeluaran" disabled required class="form-control">
														<?php foreach ($kategori_ap as $kat) {
														?>
															<option value="<?= $kat['id_kategori_ap'] ?>" <?php if ($kat['id_kategori_ap'] == $info['id_kat_ap']) {
																												echo 'selected';
																											} ?>><?= $kat['nama_kategori'] ?></option>

														<?php	} ?>
													</select>
												</div>
											</div>

											<div class="col-md-4" id="mode">
												<label for="note_cs">Payment Mode</label>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="mode" value="0" <?php if ($info['payment_mode'] == 0) {
																															echo 'checked';
																														} ?>>
													<label class="form-check-label" for="mode1">
														Cash
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="mode" value="1" <?php if ($info['payment_mode'] == 1) {
																															echo 'checked';
																														} ?>>
													<label class="form-check-label" for="mode2">
														Bank Transfer
													</label>
												</div>
											</div>

											<div class="col-md-4" id="via">
												<div class="form-group">
													<label for="exampleInputEmail1">Via</label>
													<input type="text" name="via" class="form-control" value="<?= $info['via_transfer'] ?>">
												</div>
											</div>

										</div>

										<!--begin: Wizard Step 1-->
										<?php if ($info['status'] <= 0) {
										?>
											<label for="exampleInputEmail1"><button type="button" class="btn btn-info tambah-ap"><i class="fa fa-plus"> Add Details</i> </button> </label>
											<?= $this->session->userdata('message') ?>
											<!--begin::Input-->
											<div class="row">
												<div class="col-md-2">
													<label for="note_cs">Choose Category 1</label>
													<div class="form-group rec-element-ap">
														<input type="text" class="form-control" hidden id="id_category1" name="id_category[]">
														<input type="text" class="browse-category form-control" readonly data-index="1" id="nama_kategori1" name="nama_kategori_pengeluaran[]">
													</div>
												</div>
												<div class="col-md-3">
													<label for="note_cs">Description 1</label>
													<div class="form-group rec-element-ap">
														<textarea class="form-control" id="descriptions1" name="descriptions[]"></textarea>
													</div>
												</div>
												<div class="col-md-3">
													<label for="note_cs">Amount Proposed 1</label>
													<div class="form-group rec-element-ap">
														<input type="text" class="amount_proposed form-control" id="amount1" name="amount_proposed[]">
													</div>
												</div>
												<div class="col-md-4">
													<label for="note_cs">Attachment 1</label>
													<div class="form-group rec-element-ap">
														<input type="file" class="form-control" id="attachment1" name="attachment[]" onchange="handleImageUpload(this.id);" accept="image/*" capture>
														<input type="file" class="form-control" id="upload_file2" name="attachment2[]" accept="image/*" capture hidden>
													</div>
												</div>

												<div class="ln_solid_ap"></div>
												<div id="nextkolom_ap" name="nextkolom_ap"></div>
												<button type="button" id="jumlahkolom_ap" value="1" style="display:none"></button>


											</div>
											<div class="d-flex justify-content-between border-top mt-5 pt-10">
												<div>
													<button class="btn btn font-weight-bolder text-uppercase px-9 py-4 text-light" style="background-color: #9c223b;">Submit</button>
												</div>
											</div>

										<?php	} ?>
										<!-- Table Edit ap  -->
										<div class="card-body" style="overflow: auto;">
											<h3>List <?= $info['nama_kategori'] ?></h3>
											<p class="text-danger">***Klik ditempat yang ingin diedit***</p>


											<div class="col-md-9">
												<table class="table table-separate table-head-custom table-checkable" id="myTable3">
													<tr>
														<td>Category</td>
														<td>Description</td>
														<td>Amount Proposed</td>
														<td>Attachment</td>
														<td>Action</td>

													</tr>
													<?php $total = 0;
													foreach ($ap as $c) {
														$total += $c['amount_proposed'];
													?>
														<tr>
															<td><?= $c['nama_kategori'] ?></td>
															<td>
																<span class='edit'><?= $c['description'] ?></span>
																<input type='text' class='form-control txtedit' data-id="<?= $c['id_pengeluaran'] ?>" data-field='description' id='descriptiontxt_<?= $c['id_pengeluaran'] ?>' value='<?= $c['description'] ?>'>
															</td>

															<td><span class='edit'>Rp. <?= $c['amount_proposed'] ?></span>
																<input type='number' name="jumlah" class='form-control txtedit' data-id="<?= $c['id_pengeluaran'] ?>" data-field='amount_proposed' id='amount_proposedtxt_<?= $c['amount_proposed'] ?>' value='<?= $c['amount_proposed'] ?>'>
															</td>

															<td>

																<?php if ($info['status'] <= 0) {
																?>
																	<a data-toggle="modal" data-target="#modal-bukti<?= $c['id_pengeluaran'] ?>" class=" btn btn-sm text-light mt-1" style="background-color: #9c223b;">Attacment</a>

																	<!-- <a data-toggle="modal" data-target="#modal-edit<?= $c['id_pengeluaran'] ?>" class=" btn btn-sm text-light mt-1" style="background-color: #9c223b;"> <i class="fa fa-edit text-light"></i> Edit</a> -->
																<?php	} else {
																?>
																	<a data-toggle="modal" data-target="#modal-bukti<?= $c['id_pengeluaran'] ?>" class=" btn btn-sm text-light mt-1 mb-2" style="background-color: #9c223b;">Attacment</a>

																<?php	} ?>
															</td>
															<td width="20%">

																<div class="col">
																	<p class="text-danger">***Choose file jika ingin mengubah foto dan klik submit***</p>
																	<!-- <a data-toggle="modal" data-target="#modal-edit<?= $c['id_pengeluaran'] ?>" class=" btn btn-sm text-light mt-1" style="background-color: #9c223b;"> <i class="fa fa-edit text-light"></i> Edit</a> -->

																	<form action="<?= base_url('cs/ap/edit') ?>" method="POST" enctype="multipart/form-data">
																		<input type="text" name="id_pengeluaran" value="<?= $c['id_pengeluaran'] ?>" hidden>
																		<input type="text" name="no_pengeluaran" value="<?= $c['no_pengeluaran'] ?>" hidden>
																		<input type="file" class="form-control-file" id="attachmentedit<?= $c['id_pengeluaran'] ?>" data-idpengeluaran="<?= $c['id_pengeluaran'] ?>" name="attachment" onchange="handleImageEditUpload(this.id,this.dataset['idpengeluaran']);" accept="image/*" capture>
																		<input type="file" class="form-control" id="upload_fileedit<?= $c['id_pengeluaran'] ?>" name="attachmentedit" accept="image/*" capture hidden>
																		<button class="btn btn-primary mt-2" type="submit">Submit</button>

																	</form>
																</div>

															</td>
														</tr>

													<?php } ?>

												</table>
											</div>




										</div>
										<div class="col-md-3" id="car3">
											<label for="note_cs">Total</label>
											<input class="form-control total" type="text" name="total_expanses" disabled value="<?= rupiah($total); ?>">

										</div>

										<div class="d-flex justify-content-between border-top mt-5 pt-10">
											<?php if ($info['status'] == 2) {
											?>

											<?php	} elseif ($info['status'] == 6) {
											?>

												<span>
													<span class="fa fa-window-close text-danger"></span>
													This <b><?= $info['no_pengeluaran'] ?></b> has been Void At <b><?= $info['void_date'] ?></b> Because <b><?= $info['reason_void'] ?></b> <br>

												</span>

											<?php } elseif ($info['status'] == 5) {
											?>

												<span>
													<span class="fa fa-check-circle text-success"></span>
													This <b><?= $info['no_pengeluaran'] ?></b> has been <b> Approve GM</b>

												</span>
											<?php } elseif ($info['status'] == 4) {
											?>

												<span>
													<span class="fa fa-check-circle text-success"></span>
													This <b><?= $info['no_pengeluaran'] ?></b> has been Paid At <b><?= bulan_indo($info['payment_date']) ?> </b>

												</span>
											<?php } else {

											?>
												<!-- <span>
														<span class="fa fa-check-circle text-success"></span>
														This <?= $info['no_pengeluaran'] ?> has been Received Finance, Please Wait GM To Check
													</span> -->

											<?php } ?>
										</div>

										<!--end: Wizard Step 1-->

										<!--begin: Wizard Actions-->

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



<div class="modal" id="selectCategory" data-index="">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="largeModalLabel">Pilih Kategori</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>



			<div class="modal-body">


				<div id="view">

					<?php $this->load->view('shipper/view', array('siswa' => $kategori_pengeluaran)); // Load file view.php dan kirim data siswanya 
					?>
				</div>


			</div>
		</div>
	</div>
</div>

<?php foreach ($ap as $c) {
?>

	<div class="modal fade" id="modal-bukti<?= $c['id_pengeluaran'] ?>">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Attachment </h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('superadmin/role/addRole') ?>" method="POST">
						<div class="col-md-12">
							<img src="<?= base_url('uploads/ap/' . $c['attachment']) ?>" alt="attachment" width="100%">

						</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
<?php } ?>

<?php foreach ($ap as $c) {
?>

	<div class="modal fade" id="modal-edit<?= $c['id_pengeluaran'] ?>">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit <?= $c['description'] ?> </h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('finance/ap/edit') ?>" method="POST" enctype="multipart/form-data">
						<div class="col-md-12">
							<label for="description">Description</label>
							<input type="text" name="description" class="form-control" value="<?= $c['description'] ?>">
						</div>
						<div class="col-md-12">
							<label for="description">Amount Proposed</label>
							<input type="text" name="amount_proposed" class="form-control" value="<?= $c['amount_proposed'] ?>">
						</div>

						<div class="col-md-6">
							<label for="note_cs">Change Attachment</label>
							<div class="form-group rec-element-ap">
								<input type="file" class="form-control" name="attachment">
								<input type="text" class="form-control" name="attachment_lama" hidden value="<?= $c['attachment'] ?>">
								<input type="text" class="form-control" name="id_pengeluaran" hidden value="<?= $c['id_pengeluaran'] ?>">
								<input type="text" class="form-control" name="no_pengeluaran" hidden value="<?= $c['no_pengeluaran'] ?>">
							</div>
						</div>

						<div class="col-md-6">
							<img src="<?= base_url('uploads/ap/' . $c['attachment']) ?>" alt="attachment" width="100%">

						</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Update</button>
				</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
<?php } ?>