 <!--begin::Content-->
 <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
 	<!--begin::Entry-->
 	<div class="d-flex flex-column-fluid">
 		<!--begin::Container-->
 		<div class="container">
 			<!--begin::Dashboard-->
 			<!--begin::Row-->
 			<div class="row">
 				<div class="col-xl-8">
 					<!--begin::Mixed Widget 2-->
 					<!--begin::Form-->
 					<form class="form" method="POST" action="<?php echo base_url('profile/editProfile'); ?>">
 						<div class="card card-custom card-stretch">
 							<!--begin::Header-->
 							<div class="card-header py-3">
 								<div class="card-title align-items-start flex-column">
 									<h3 class="card-label font-weight-bolder text-dark">Personal Information</h3>
 									<span class="text-muted font-weight-bold font-size-sm mt-1">Update your personal
 										Information</span>
 								</div>
 								<div class="card-toolbar">
 									<button type="submit" class="btn mr-1 text-light" style="background-color: #9c223b;">Save Changes</button>
 								</div>
 							</div>
 							<!--end::Header-->
 							<!--begin::Body-->
 							<div class="card-body">
 								<div class="row">
 									<label class="col-xl-3"></label>
 									<div class="col-lg-9 col-xl-6">
 										<h5 class="font-weight-bold mb-6">Profile Information</h5>
 									</div>
 								</div>
 								<div class="form-group row">
 									<label class="col-xl-3 col-lg-3 col-form-label">Name</label>
 									<div class="col-lg-9 col-xl-6">
 										<!-- <input type="hidden" name="id_user" value="<?php echo $this->session->userdata('id_user'); ?>"> -->
 										<input class="form-control form-control-lg form-control-solid" name="nama_user" type="text" value="<?= $nama_user; ?>">
 									</div>
 								</div>

 								<div class="form-group row">
 									<label class="col-xl-3 col-lg-3 col-form-label">username</label>
 									<div class="col-lg-9 col-xl-6">
 										<input class="form-control form-control-lg form-control-solid" name="username" type="text" value="<?= $username ?>">
 									</div>
 								</div>
 								<div class="form-group row">
 									<label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
 									<div class="col-lg-9 col-xl-6">
 										<div class="input-group input-group-lg input-group-solid">
 											<div class="input-group-prepend">
 												<span class="input-group-text">
 													<i class="la la-at"></i>
 												</span>
 											</div>
 											<input type="text" class="form-control form-control-lg form-control-solid" name="email" value="<?= $email ?>" placeholder="Email">
 										</div>
 									</div>
 								</div>
 								<div class="form-group row">
 									<label class="col-xl-3 col-lg-3 col-form-label">Password</label>
 									<div class="col-lg-9 col-xl-6">
 										<input type="password" class="form-control form-control-lg form-control-solid" name="password" placeholder="Isi jika password ingin diubah" name="password">
 									</div>
 								</div>
 							</div>
 							<!--end::Body-->
 							<!--end::Form-->
 						</div>
 						<!--end::Mixed Widget 2-->

 					</form>
 				</div>
 			</div>
 			<!--end::Row-->

 			<!--end::Dashboard-->
 		</div>
 		<!--end::Container-->
 	</div>
 	<!--end::Entry-->
 </div>
 <!--end::Content-->