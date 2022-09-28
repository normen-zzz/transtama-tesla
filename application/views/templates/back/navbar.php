<!--begin::Header Mobile-->
<div id="kt_header_mobile" class="header-mobile header-mobile-fixed" style="background-color: #091f29;">
	<!--begin::Logo-->

	<a href="#">
		<img alt="Logo" src="<?= base_url('uploads/iconmenu2.png') ?>" class="max-h-50px" />
	</a>
	<!--end::Logo-->
	<!--begin::Toolbar-->
	<div class="d-flex align-items-center">
		<button class="btn p-0 burger-icon burger-icon-left ml-4" id="kt_header_mobile_toggle">
			<span></span>
		</button>

	</div>
	<!--end::Toolbar-->
</div>
<!--end::Header Mobile-->
<div class="d-flex flex-column flex-root">
	<!--begin::Page-->
	<div class="d-flex flex-row flex-column-fluid page">
		<!--begin::Wrapper-->
		<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
			<!--begin::Header-->
			<div id="kt_header" class="header flex-column header-fixed">
				<!--begin::Top-->
				<div class="header-top" style="background-color: #091f29;">
					<!--begin::Container-->
					<div class="container">
						<!--begin::Left-->
						<div class="d-none d-lg-flex align-items-center mr-3">
							<!--begin::Logo-->

							<a href="<?php echo base_url('#'); ?>">
								<img alt="Logo" src="<?= base_url('uploads/iconmenu2.png') ?>" class="max-h-60px" />
								<!-- SHIPPER-APPS -->

							</a>
							<!--end::Logo-->
							<!--begin::Tab Navs(for desktop mode)-->
							<ul class="header-tabs nav align-self-end font-size-lg" role="tablist">

							</ul>
							<!--begin::Tab Navs-->
						</div>
						<!--end::Left-->
						<!--begin::Topbar-->
						<div class="topbar" style="background-color: #091f29;">
							<!--begin::User-->
							<div class="topbar-item">
								<div class="btn btn-icon btn-hover-transparent-white w-sm-auto d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
									<div class="d-flex flex-column text-right pr-sm-3">
										<span class="text-white opacity-50 font-weight-bold font-size-sm d-none d-sm-inline">Selamat
											Datang, </span>
										<span class="text-white font-weight-bolder font-size-sm d-none d-sm-inline"><?= $this->session->userdata('nama_user') ?></span>
									</div>
									<span class="symbol symbol-35">
										<span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-30"><?php echo substr($this->session->userdata('nama_user'), 0, 1)  ?></span>
									</span>
								</div>
							</div>
							<!--end::User-->
						</div>
						<!--end::Topbar-->
					</div>
					<!--end::Container-->
				</div>
				<!--end::Top-->
				<!--begin::Bottom-->
				<div class="header-bottom">
					<!--begin::Container-->
					<div class="container">
						<!--begin::Header Menu Wrapper-->
						<div class="header-navs header-navs-left" id="kt_header_navs">
							<!--begin::Tab Navs(for tablet and mobile modes)-->
							<ul class="header-tabs p-5 p-lg-0 d-flex d-lg-none nav nav-bold nav-tabs" role="tablist" style="background-color: #091f29; height:55px;">
								<!--begin::Item-->
								<li class="nav-item mr-2">
									<a href="#" class="nav-link btn btn-clean text-light" data-toggle="tab" data-target="#kt_header_tab_1" role="tab" style="font-size: 15px;">Home</a>
								</li>

							</ul>
							<!--begin::Tab Navs-->
							<!--begin::Tab Content-->
							<div class="tab-content">
								<!--begin::Tab Pane-->
								<div class="tab-pane py-5 p-lg-0 show active" id="kt_header_tab_1">
									<!--begin::Menu-->
									<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
										<!--begin::Nav-->
										<?php $this->load->view('templates/back/aside'); ?>
										<!--end::Nav-->
									</div>
									<!--end::Menu-->
								</div>
								<!--begin::Tab Pane-->
								<!--begin::Tab Pane-->
								<div class="tab-pane p-5 p-lg-0 justify-content-between" id="kt_header_tab_2">
									<div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
										<!--begin::Actions-->
										<a href="#" class="btn btn-light-success font-weight-bold mr-3 my-2 my-lg-0">Latest
											Orders</a>
										<a href="#" class="btn btn-light-primary font-weight-bold my-2 my-lg-0">Customer
											Service</a>
										<!--end::Actions-->
									</div>
									<div class="d-flex align-items-center">
										<!--begin::Actions-->
										<a href="#" class="btn btn-danger font-weight-bold my-2 my-lg-0">Generate
											Reports</a>
										<!--end::Actions-->
									</div>
								</div>
								<!--begin::Tab Pane-->
							</div>
							<!--end::Tab Content-->
						</div>
						<!--end::Header Menu Wrapper-->
					</div>
					<!--end::Container-->
				</div>
				<!--end::Bottom-->
			</div>
			<!--end::Header-->


		</div>
		<!--end::Wrapper-->
	</div>
	<!--end::Page-->
</div>
<!--end::Main-->
<!-- begin::User Panel-->
<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
	<!--begin::Header-->
	<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
		<h3 class="font-weight-bold m-0"><?= $this->session->userdata('nama_user') ?>
			<small class="text-muted font-size-sm ml-2">Online</small>
		</h3>
		<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
			<i class="ki ki-close icon-xs text-muted"></i>
		</a>
	</div>
	<!--end::Header-->
	<!--begin::Content-->
	<div class="offcanvas-content pr-5 mr-n5">
		<!--begin::Header-->
		<div class="d-flex align-items-center mt-5">
			<div class="symbol symbol-100 mr-5">
				<span class="symbol-label font-size-h3 font-weight-bold text-white bg-primary"><?php $avatar = $this->session->userdata('nama_user');
																								$namaavatar = substr($avatar, 0, 1);
																								echo $namaavatar;
																								?></span>
				<i class="symbol-badge bg-success"></i>
			</div>
			<div class="d-flex flex-column">
				<div class="navi mt-2">
					<a href="#" class="navi-item">
						<span class="navi-link p-0 pb-2">
							<span class="navi-icon mr-1">
								<span class="svg-icon svg-icon-lg svg-icon-primary">
									<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg-->
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
											<circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
										</g>
									</svg>
									<!--end::Svg Icon-->
								</span>
							</span>
							<span class="navi-text text-muted text-hover-primary"><?= $this->session->userdata('email') ?></span>
						</span>
					</a>
					<?php $role = $this->session->userdata('id_role');; ?>
					<a href="<?= base_url('profile') ?>" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">My Profile</a>
					<a href="<?= base_url('logout') ?>" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Sign Out</a>


				</div>
			</div>
		</div>
		<!--end::Header-->
		<!--begin::Separator-->
		<div class="separator separator-dashed mt-8 mb-5"></div>
		<!--end::Separator-->


	</div>
	<!--end::Content-->
</div>
<!-- end::User Panel-->

<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop">
	<span class="svg-icon">
		<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				<polygon points="0 0 24 0 24 24 0 24" />
				<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
				<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
			</g>
		</svg>
		<!--end::Svg Icon-->
	</span>
</div>
<!--end::Scrolltop-->