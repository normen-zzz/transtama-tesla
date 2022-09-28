<?php $role = $this->session->userdata('id_role'); ?>
<!-- jika dia superadmin -->
<?php if ($role == 1) {
?>
	<ul class="menu-nav">
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('superadmin/dashboard') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
						<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo7/dist/../src/media/svg/icons/Home/Home.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24" />
								<path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z" fill="#000000" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span></i>Dashboard</span>
			</a>
		</li>
		<li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
			<a href="javascript:;" class="menu-link menu-toggle">
				<span class="menu-text">
					<span class="svg-icon svg-icon-danger mr-2">
						<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo7/dist/../src/media/svg/icons/Shopping/Box1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24" />
								<polygon fill="#000000" opacity="0.3" points="6 3 18 3 20 6.5 4 6.5" />
								<path d="M6,5 L18,5 C19.1045695,5 20,5.8954305 20,7 L20,19 C20,20.1045695 19.1045695,21 18,21 L6,21 C4.8954305,21 4,20.1045695 4,19 L4,7 C4,5.8954305 4.8954305,5 6,5 Z M9,9 C8.44771525,9 8,9.44771525 8,10 C8,10.5522847 8.44771525,11 9,11 L15,11 C15.5522847,11 16,10.5522847 16,10 C16,9.44771525 15.5522847,9 15,9 L9,9 Z" fill="#000000" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>Master Data</span>
				<span class="menu-desc"></span>
				<i class="menu-arrow"></i>
			</a>
			<div class="menu-submenu menu-submenu-classic menu-submenu-left">
				<ul class="menu-subnav">
					<li class="menu-item" aria-haspopup="true">
						<a href="<?= base_url('superadmin/customer') ?>" class="menu-link">
							<span class="menu-text"><i class="fa fa-city text-danger mr-2"></i>Customer</span>
						</a>
					</li>

					<li class="menu-item" aria-haspopup="true">
						<a href="<?= base_url('superadmin/users') ?>" class="menu-link">
							<span class="menu-text"><i class="flaticon-user text-danger mr-2"></i>Users</span>
						</a>
					</li>

					<li class="menu-item" aria-haspopup="true">
						<a href="<?= base_url('superadmin/province') ?>" class="menu-link">
							<span class="menu-text">
								<i class="fa fa-city text-danger mr-2"></i>Province</span>
						</a>
					</li>
					<li class="menu-item" aria-haspopup="true">
						<a href="<?= base_url('superadmin/city') ?>" class="menu-link">
							<span class="menu-text">
								<i class="fa fa-city text-danger mr-2"></i>City</span>
						</a>
					</li>
					<li class="menu-item" aria-haspopup="true">
						<a href="<?= base_url('superadmin/role') ?>" class="menu-link">
							<span class="menu-text">
								<i class="flaticon-user-settings text-danger mr-2"></i>Role Management</span>
						</a>
					</li>


				</ul>
			</div>
		</li>

		<li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
			<a href="javascript:;" class="menu-link menu-toggle">
				<span class="menu-text">
					<span class="menu-text"> <i class="fa fa-car-side mr-2 text-danger"></i> Order</span>
					<!--end::Svg Icon-->
					<span class="menu-desc"></span>
					<i class="menu-arrow"></i>

			</a>
			<div class="menu-submenu menu-submenu-classic menu-submenu-left">
				<ul class="menu-subnav">

					<li class="menu-item" aria-haspopup="true">
						<a href="<?= base_url('superadmin/salesOrder') ?>" class="menu-link">
							<span class="menu-text"><i class="fa fa-book text-danger mr-2"></i>Sales Order</span>
						</a>
					</li>
					<li class="menu-item" aria-haspopup="true">
						<a href="<?= base_url('superadmin/order') ?>" class="menu-link">
							<span class="menu-text"><i class="fa fa-car-side text-danger mr-2"></i>List Shipment</span>
						</a>
					</li>

					<li class="menu-item" aria-haspopup="true">
						<a href="<?= base_url('superadmin/order/report') ?>" class="menu-link">
							<span class="menu-text">
								<i class="fa fa-chart-bar text-danger mr-2"></i>Report</span>
						</a>
					</li>
					<li class="menu-item menu-item" aria-haspopup="true">
						<a href="<?= base_url('superadmin/order/tracking') ?>" class="menu-link">
							<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
									<i class="fa fa-cog text-danger mr-2">
								</span></i>Tracking</span>
						</a>
					</li>
					<li class="menu-item menu-item" aria-haspopup="true">
						<a href="<?= base_url('superadmin/order/generate') ?>" class="menu-link">
							<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
									<i class="fa fa-cog text-danger mr-2">
								</span></i>Generate Resi</span>
						</a>
					</li>



				</ul>
			</div>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('profile') ?>" class="menu-link">
				<span class="menu-text">
					<span class="svg-icon svg-icon-danger svg-icon mr-2">
						<i class="fa fa-user text-danger"></i>

					</span></i>My Profile</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('logout') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
						<i class="fa fa-sign-out-alt text-danger"></i>
						<!--end::Svg Icon-->
					</span></i>Logout</span>
			</a>
		</li>



	</ul>
	<!-- jika role sebagai shipper -->
<?php } elseif ($role == 2) { ?>

	<ul class="menu-nav">
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('shipper/dashboard') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
						<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo7/dist/../src/media/svg/icons/Home/Home.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24" />
								<path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z" fill="#000000" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span></i>Dashboard</span>
			</a>
		</li>
		<?php $akses = $this->session->userdata('akses');
		// kalo dia atasannya driver
		if ($akses == 1) {
		?>
			<li class="menu-item menu-item" aria-haspopup="true">
				<a href="<?= base_url('shipper/salesOrder') ?>" class="menu-link">
					<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
							<i class="fa fa-book text-danger mr-2">
						</span></i>Sales Order</span>
				</a>
			</li>

			<li class="menu-item menu-item" aria-haspopup="true">
				<a href="<?= base_url('scan') ?>" class="menu-link">
					<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
							<i class="fa fa-eye text-danger mr-2">
						</span></i>Scan In/Out</span>
				</a>
			</li>




		<?php	} else {
		?>
			<li class="menu-item menu-item" aria-haspopup="true">
				<a href="<?= base_url('shipper/salesOrder') ?>" class="menu-link">
					<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">

							<i class="fa fa-car-side text-danger mr-2">

						</span></i>My Shipment</span>
				</a>
			</li>

		<?php	}
		?>


		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('shipper/customer') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">

						<i class="fa fa fa-city text-danger mr-2">

					</span></i>Master Customer</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('shipper/ap') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
						<i class="fa fa-dollar-sign text-danger mr-2">
					</span></i>Account Payable</span>
			</a>
		</li>

		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('profile') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-success svg-icon mr-2">

						<i class="fa fa-user text-danger mr-2">

					</span></i>My Profile</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('logout') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-success svg-icon mr-2">
						<i class="fa fa-sign-out-alt text-danger mr-2">
					</span></i>Logout</span>
			</a>
		</li>

	</ul>
<?php } elseif ($role == 3) {
?>

	<ul class="menu-nav">
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('cs/dashboard') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
						<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo7/dist/../src/media/svg/icons/Home/Home.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24" />
								<path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z" fill="#000000" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span></i>Dashboard</span>
			</a>
		</li>

		<li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
			<a href="javascript:;" class="menu-link menu-toggle">
				<span class="menu-text">
					<span class="menu-text"> <i class="fa fa-book mr-2 text-danger"></i> Order</span>
					<!--end::Svg Icon-->
					<span class="menu-desc"></span>
					<i class="menu-arrow"></i>

			</a>
			<div class="menu-submenu menu-submenu-classic menu-submenu-left">
				<ul class="menu-subnav">
					<li class="menu-item menu-item" aria-haspopup="true">
						<a href="<?= base_url('cs/salesOrder') ?>" class="menu-link">
							<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
									<i class="fa fa-book text-danger mr-2">
								</span></i>Sales Order</span>
						</a>
					</li>
					<li class="menu-item menu-item" aria-haspopup="true">
						<a href="<?= base_url('cs/salesOrder/tracking') ?>" class="menu-link">
							<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
									<i class="fa fa-cog text-danger mr-2">
								</span></i>Tracking</span>
						</a>
					</li>
					<li class="menu-item" aria-haspopup="true">
						<a href="<?= base_url('cs/order/report') ?>" class="menu-link">
							<span class="menu-text">
								<i class="fa fa-chart-bar text-danger mr-2"></i>Report Order</span>
						</a>
					</li>
					<li class="menu-item" aria-haspopup="true">
						<a href="<?= base_url('cs/city') ?>" class="menu-link">
							<span class="menu-text">
								<i class="fa fa-chart-bar text-danger mr-2"></i>City</span>
						</a>
					</li>
				</ul>
			</div>
		</li>

		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('cs/customer') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">

						<i class="fa fa fa-city text-danger mr-2">

					</span></i>Master Customer</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('cs/ap') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
						<i class="fa fa-dollar-sign text-danger mr-2">
					</span></i>Account Payable</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('profile') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-success svg-icon mr-2">

						<i class="fa fa-user text-danger mr-2">

					</span></i>My Profile</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('logout') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-success svg-icon mr-2">
						<i class="fa fa-sign-out-alt text-danger mr-2">
					</span></i>Logout</span>
			</a>
		</li>

	</ul>
<?php } elseif ($role == 4) {
?>
	<ul class="menu-nav">
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('sales/dashboard') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
						<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo7/dist/../src/media/svg/icons/Home/Home.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24" />
								<path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z" fill="#000000" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span></i>Dashboard</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('sales/salesOrder') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">

						<i class="fa fa-book text-danger mr-2">

					</span></i>Sales Order</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('sales/salesOrder/revisiSo') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">

						<i class="fa fa-book text-danger mr-2">

					</span></i>Revisi Sales Order</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('sales/SalesOrder/generateResi') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
						<i class="fa fa-book text-danger mr-2">
					</span></i>Generate Resi</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('sales/salesOrder/report') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">

						<i class="fa fa-chart-bar text-danger mr-2">

					</span></i>Report</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('sales/ap') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
						<i class="fa fa-dollar-sign text-danger mr-2">
					</span></i>Account Payable</span>
			</a>
		</li>


		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('profile') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-success svg-icon mr-2">

						<i class="fa fa-user text-danger mr-2">

					</span></i>My Profile</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('logout') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-success svg-icon mr-2">
						<i class="fa fa-sign-out-alt text-danger mr-2">
					</span></i>Logout</span>
			</a>
		</li>

	</ul>
<?php } elseif ($role == 5) {
?>
	<ul class="menu-nav">
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('dispatcher/scan') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
						<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo7/dist/../src/media/svg/icons/Home/Home.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24" />
								<path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z" fill="#000000" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span></i>Dashboard</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('dispatcher/scan/history') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
						<i class="fa fa-clock text-danger mr-2 mt-1">
					</span></i>History</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('dispatcher/ap') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
						<i class="fa fa-dollar-sign text-danger mr-2">
					</span></i>Account Payable</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('profile') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-success svg-icon mr-2">

						<i class="fa fa-user text-danger mr-2">

					</span></i>My Profile</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('logout') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-success svg-icon mr-2">
						<i class="fa fa-sign-out-alt text-danger mr-2">
					</span></i>Logout</span>
			</a>
		</li>

	</ul>
<?php } elseif ($role == 6) {
?>
	<ul class="menu-nav">
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('finance/dashboard') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
						<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo7/dist/../src/media/svg/icons/Home/Home.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24" />
								<path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z" fill="#000000" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span></i>Dashboard</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('finance/ap') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-danger svg-icon mr-2">
						<i class="fa fa-dollar-sign text-danger mr-2">
					</span></i>Account Payable</span>
			</a>
		</li>


		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('profile') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-success svg-icon mr-2">

						<i class="fa fa-user text-danger mr-2">

					</span></i>My Profile</span>
			</a>
		</li>
		<li class="menu-item menu-item" aria-haspopup="true">
			<a href="<?= base_url('logout') ?>" class="menu-link">
				<span class="menu-text"><span class="svg-icon svg-icon-success svg-icon mr-2">
						<i class="fa fa-sign-out-alt text-danger mr-2">
					</span></i>Logout</span>
			</a>
		</li>

	</ul>
<?php } else {
} ?>