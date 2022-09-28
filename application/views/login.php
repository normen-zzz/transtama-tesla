<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>

	<meta charset="utf-8" />
	<title>Login Page</title>
	<meta name="description" content="Login Shipper Transtama" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Page Custom Styles(used by this page)-->
	<link href="<?= base_url('assets/back/metronic/') ?>css/pages/login/classic/login-1.css" rel="stylesheet" type="text/css" />
	<!--end::Page Custom Styles-->
	<!--begin::Global Theme Styles(used by all pages)-->
	<link href="<?= base_url('assets/back/metronic/') ?>plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/back/metronic/') ?>plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/back/metronic/') ?>css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles-->
	<!--begin::Layout Themes(used by all pages)-->
	<!--end::Layout Themes-->
	<link rel="shortcut icon" href="<?= base_url('uploads/') ?>tlx.jpeg" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed header-bottom-enabled subheader-enabled page-loading">
	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Login-->
		<div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
			<div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden" style="background-color: #eee;">
				<!--begin::Content header-->

				<!--end::Content header-->
				<!--begin::Content body-->
				<div class="d-flex flex-column-fluid flex-center mt-lg-0">
					<!--begin::Signin-->
					<div class="login-form login-signin">
						<div class="text-center mb-5 mb-lg-10 mt-20">
							<img src="<?= base_url('uploads/LogoRaw.png') ?>" width="auto" height="100">
							<h1 style="font-size: 40px; color:#eee">Log In</h1>
							<p class="text-muted font-weight-bold">Masukan Username Dan Password</p>
						
						</div>
						<!--begin::Form-->
						<form class="form" action="<?= base_url('backoffice') ?>" method="POST">
							<div class="form-group">
								<input class="form-control form-control-solid h-auto py-5 px-6" required type="text" placeholder="Username" name="username" autocomplete="off" />
							</div>
							<div class="form-group">
								<input class="form-control form-control-solid h-auto py-5 px-6" required type="password" placeholder="Password" name="password" autocomplete="off" />
							</div>
							<!--begin::Action-->
							<div class="form-group d-flex align-items-center">
								<button type="submit" class="btn font-weight-bold px-9 py-4 my-3 text-light" style="background-color: #9c223b;">Login</button>
							</div>
							<!--end::Action-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Signin-->

				</div>
				<!--end::Content body-->

			</div>
			<!--begin::Aside-->
			<div class="login-aside d-flex flex-row-auto bgi-size-cover bgi-no-repeat p-5 p-lg-5" style="background-image: url(<?= base_url('assets/back/metronic/') ?>media/bg/back.png); height:150px;">
				<!--begin: Aside Container-->
				<div class="d-flex flex-row-fluid flex-column justify-content-between">
					<!--begin: Aside header-->
					<a href="#" class="flex-column-auto mt-5 pb-lg-0 pb-10">
						<!-- <img src="<?= base_url('uploads/tlx.jpeg') ?>" class="max-h-70px" alt="logo" /> -->
						<!-- <h2>PT TRANSTAMA LOGISTIK</h2> -->
					</a>
					<!--end: Aside header-->
					<!--begin: Aside content-->
					<div class="flex-column-fluid d-flex flex-column justify-content-center">

						<h3 class="font-size-h1 mb-5 text-white"></h3>
						<h2 class="font-weight-lighter text-white opacity-80"></h2>
					</div>
					<!--end: Aside content-->
					<!--begin: Aside footer for desktop-->
					<div class="d-none flex-column-auto d-lg-flex justify-content-between">
						<!-- <div class="opacity-70 font-weight-bold text-white">PT TRANSTAMA LOGISTIK</div> -->
						<div class="d-flex">
							<a href="#" class="text-white ml-10">PT TRANSTAMA LOGISTIK</a>
						</div>
					</div>
					<!--end: Aside footer for desktop-->
				</div>
				<!--end: Aside Container-->
			</div>
			<!--begin::Aside-->
			<!--begin::Content-->

			<!--end::Content-->
		</div>
		<!--end::Login-->
	</div>
	<!--end::Main-->
	<script>
		var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";
	</script>
	<!--begin::Global Config(global config for global JS scripts)-->
	<script>
		var KTAppSettings = {
			"breakpoints": {
				"sm": 576,
				"md": 768,
				"lg": 992,
				"xl": 1200,
				"xxl": 1200
			},
			"colors": {
				"theme": {
					"base": {
						"white": "#ffffff",
						"primary": "#6993FF",
						"secondary": "#E5EAEE",
						"success": "#1BC5BD",
						"info": "#8950FC",
						"warning": "#FFA800",
						"danger": "#F64E60",
						"light": "#F3F6F9",
						"dark": "#212121"
					},
					"light": {
						"white": "#ffffff",
						"primary": "#E1E9FF",
						"secondary": "#ECF0F3",
						"success": "#C9F7F5",
						"info": "#EEE5FF",
						"warning": "#FFF4DE",
						"danger": "#FFE2E5",
						"light": "#F3F6F9",
						"dark": "#D6D6E0"
					},
					"inverse": {
						"white": "#ffffff",
						"primary": "#ffffff",
						"secondary": "#212121",
						"success": "#ffffff",
						"info": "#ffffff",
						"warning": "#ffffff",
						"danger": "#ffffff",
						"light": "#464E5F",
						"dark": "#ffffff"
					}
				},
				"gray": {
					"gray-100": "#F3F6F9",
					"gray-200": "#ECF0F3",
					"gray-300": "#E5EAEE",
					"gray-400": "#D6D6E0",
					"gray-500": "#B5B5C3",
					"gray-600": "#80808F",
					"gray-700": "#464E5F",
					"gray-800": "#1B283F",
					"gray-900": "#212121"
				}
			},
			"font-family": "Poppins"
		};
	</script>
	<!--end::Global Config-->
	<!--begin::Global Theme Bundle(used by all pages)-->
	<script src="<?= base_url('assets/back/metronic/') ?>plugins/global/plugins.bundle.js"></script>
	<script src="<?= base_url('assets/back/metronic/') ?>plugins/custom/prismjs/prismjs.bundle.js"></script>
	<script src="<?= base_url('assets/back/metronic/') ?>js/scripts.bundle.js"></script>
	<!--end::Global Theme Bundle-->
	<!--begin::Page Scripts(used by this page)-->
	<script src="<?= base_url('assets/back/metronic/') ?>js/pages/custom/login/login-general.js"></script>
	<!--end::Page Scripts-->
</body>
<!--end::Body-->

</html>