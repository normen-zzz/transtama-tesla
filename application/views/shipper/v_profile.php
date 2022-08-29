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
 					<div class="card card-custom card-stretch">
 						<!--begin::Header-->
 						<div class="card-header py-3">
 							<div class="card-title align-items-start flex-column">
 								<h3 class="card-label font-weight-bolder text-dark">Personal Information</h3>
 								<span class="text-muted font-weight-bold font-size-sm mt-1">Update your personal
 									informaiton</span>
 							</div>
 							<div class="card-toolbar">
 								<button type="reset" class="btn btn-success mr-2">Save Changes</button>
 								<button type="reset" class="btn btn-secondary">Cancel</button>
 							</div>
 						</div>
 						<!--end::Header-->
 						<!--begin::Form-->
 						<form class="form" action="<?php echo base_url('wakildekan/profile/update');?>">
 							<!--begin::Body-->
 							<div class="card-body">
 								<div class="row">
 									<label class="col-xl-3"></label>
 									<div class="col-lg-9 col-xl-6">
 										<h5 class="font-weight-bold mb-6">Profile Information</h5>
 									</div>
 								</div>
 								<div class="form-group row">
 									<label class="col-xl-3 col-lg-3 col-form-label">Nama</label>
 									<div class="col-lg-9 col-xl-6">
 										<input class="form-control form-control-lg form-control-solid" type="text"
 											value="<?= $this->session->userdata('nama_user') ?>">
 									</div>
 								</div>
								 
 								<div class="form-group row">
 									<label class="col-xl-3 col-lg-3 col-form-label">username</label>
 									<div class="col-lg-9 col-xl-6">
 										<input class="form-control form-control-lg form-control-solid" type="text"
 											value="<?= $this->session->userdata('username') ?>">
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
 											<input type="text" class="form-control form-control-lg form-control-solid"
 												value="<?= $this->session->userdata('email') ?>" placeholder="Email">
 										</div>
 									</div>
 								</div>
 								<div class="form-group row">
 									<label class="col-xl-3 col-lg-3 col-form-label">Role Akses</label>
 									<div class="col-lg-9 col-xl-6">
 										<input class="form-control form-control-lg form-control-solid" disabled type="text"
 											value="<?php 
											 $role = $this->session->userdata('id_role');
											 if($role == 1){
												 echo "BAAK";
											 }elseif($role == 2){
												 echo "Dekan";
											 }elseif($role == 3){
												 echo "Wakil Dekan";
											 }elseif($role == 4){
												 echo "Rektorat";
											 }else{
												 echo "Tata Usaha";
											 }
											 ?>">
 									</div>
 								</div>
 							</div>
 							<!--end::Body-->
 						</form>
 						<!--end::Form-->
 					</div>
 					<!--end::Mixed Widget 2-->
 				</div>
 				<div class="col-xl-4">
 					<!--begin::List Widget 7-->
 					<div class="card card-custom gutter-b card-stretch">
 						<!--begin::Header-->
 						<div class="card-header border-0">
 							<h3 class="card-title font-weight-bolder text-dark">More Settings</h3>
 							<div class="card-toolbar">
 								<div class="dropdown dropdown-inline">
 									<a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon"
 										data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
 										<i class="fa fa-key"></i>
 									</a>
 									<div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
 										<!--begin::Naviigation-->
 										<ul class="navi">
 											<li class="navi-header font-weight-bold py-5">
 												<span class="font-size-lg">Pengaturan</span>
 												<i class="flaticon2-information icon-md text-muted"
 													data-toggle="tooltip" data-placement="right"
 													title="Click to learn more..."></i>
 											</li>
 											<li class="navi-separator mb-3 opacity-70"></li>
 											<li class="navi-item m-2">
 												<a class="btn btn-primary font-weight-bolder" data-toggle="modal"
 													data-target="#modal-lg">
 													</span>Ubah Password</a>
 												</a>
 											</li>


 										</ul>
 										<!--end::Naviigation-->
 									</div>
 								</div>
 							</div>
 						</div>
 						<!--end::Header-->
 						<!--begin::Body-->
 						<div class="card-body pt-0">

 						</div>
 						<!--end::Body-->
 					</div>
 					<!--end::List Widget 7-->
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


 <div class="modal fade" id="modal-lg">
 	<div class="modal-dialog modal-lg">
 		<div class="modal-content">
 			<div class="modal-header">
 				<h4 class="modal-title">Change Password
				 <small>Jika tidak ingin ganti klik close</small></h4>
 				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
 					<span aria-hidden="true">&times;</span>
 				</button>
 			</div>
 			<div class="modal-body">
 				<form action="<?= base_url('wakildekan/profile/changepassword') ?>" method="POST">

 					<div class="form-group mb-4">
 						<label>Password Baru</label>
 						<input type="password" class="form-control" required name="newpassword">
 					</div>

 					<div class="form-group">
 						<label>Password</label>
 						<input type="password" class="form-control" required name="newpassword2">
 					</div>

 			</div>
 			<div class="modal-footer">
 				<button type="button" class="btn btn-light-primary font-weight-bold"
 					data-dismiss="modal">Close</button>
 				<button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
 			</div>
 			</form>
 		</div>
 		<!-- /.modal-content -->
 	</div>
 	<!-- /.modal-dialog -->
 </div>
 <!-- /.modal -->
