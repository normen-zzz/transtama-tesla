<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>Login Page</title>
    <meta name="description" content="Login page example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/front/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="<?= base_url('assets/back/metronic/') ?>css/pages/login/login-1.css" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="<?= base_url('assets/back/metronic/') ?>plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/back/metronic/') ?>plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/back/metronic/') ?>css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="<?= base_url('assets/back/metronic/') ?>media/logos/favicon.ico" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed header-bottom-enabled subheader-enabled page-loading">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
            <!--begin::Aside-->
            <div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #F2C98A;">
                <!--begin::Aside Top-->
                <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                    <!--begin::Aside header-->
                    <a href="#" class="text-center mb-10">
                        <img src="<?= base_url('assets/back/metronic/') ?>media/logos/logo-letter-1.png" class="max-h-70px" alt="" />
                    </a>
                    <!--end::Aside header-->
                    <!--begin::Aside title-->
                    <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg" style="color: #986923;">GROW UP WITH
                        <br />LEARNING MANAGEMENT SYSTEM
                    </h3>
                    <!--end::Aside title-->
                </div>
                <!--end::Aside Top-->
                <!--begin::Aside Bottom-->
                <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url(<?= base_url('assets/back/metronic/') ?>media/svg/illustrations/login-visual-1.svg)"></div>
                <!--end::Aside Bottom-->
            </div>
            <!--begin::Aside-->
            <!--begin::Content-->
            <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
                <!--begin::Content body-->
                <div class="d-flex flex-column-fluid flex-center">
                    <!--begin::Signin-->
                    <div class="login-form login-signin">
                        <div class="container text-center" id="QR-Code">
                            <?= $this->session->userdata('message'); ?>
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="navbar-form navbar-left text-center">
                                        <h4>LMS SMART IDENTITY</h4>
                                    </div> <br>
                                    <div class="navbar-form navbar-center">
                                        <select class="form-control" id="camera-select"></select>
                                    </div>
                                </div>
                                <div class="panel-body text-center">
                                    <div class="col-md-11">
                                        <div class="well" style="position: middle;">
                                            <canvas width="400" height="400" id="webcodecam-canvas"></canvas>
                                            <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
                                            <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
                                            <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
                                            <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
                                        </div>
                                    </div>
                                </div>


                            </div><!-- /.box-body -->
                        </div>


                    </div>
                    <!--end::Signin-->


                </div>
                <div class="pb-lg-0 pb-5">
                    <!-- <button type="button" id="kt_login_signin_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Login</button> -->
                    <a href="<?= base_url('/') ?>" class="btn btn-light-primary font-weight-bolder px-8 py-4 my-3 font-size-lg">
                        <span class="fa fa-arrow-left">
                            <!--end::Svg Icon-->
                        </span> Kembali Ke Halaman Utama</a>
                </div>
                <!--end::Content body-->
                <!--begin::Content footer-->

                <!--end::Content footer-->
            </div>
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
    <script src="<?= base_url('assets/front/') ?>vendor/jquery/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/front/js/jquery.min.js"></script> -->

    <!-- <script src="<?php echo base_url() ?>template/dist/js/app.min.js"></script> -->
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url() ?>template/dist/js/demo.js"></script>
    <script src="<?php echo base_url() ?>assets/front/js/qrcodelib.js"></script>
    <script src="<?php echo base_url() ?>assets/front/js/webcodecamjquery.js"></script>
    <script src="<?php echo base_url() ?>assets/front/js/scan.js"></script>

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url() ?>template/bootstrap/js/bootstrap.min.js"></script>
    <!-- <script src="<?php echo base_url() ?>template/plugins/fastclick/fastclick.min.js"></script> -->
    <!-- AdminLTE App -->
    <!-- <script src="<?php echo base_url() ?>template/dist/js/app.min.js"></script> -->
    <!-- AdminLTE for demo purposes -->

    <!-- <script src="<?php echo base_url() ?>template/dist/js/demo.js"></script> -->
    <script src="<?= base_url('assets/back/metronic/') ?>plugins/global/plugins.bundle.js"></script>
    <script src="<?= base_url('assets/back/metronic/') ?>plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="<?= base_url('assets/back/metronic/') ?>js/scripts.bundle.js"></script>
    <!--end::Global Theme Bundle-->
    <!--begin::Page Scripts(used by this page)-->
    <!-- <script src="<?= base_url('assets/back/metronic/') ?>js/pages/custom/login/login-general.js"></script> -->
    <!--end::Page Scripts-->

    <script src="<?php echo base_url() ?>assets/front/vendor/sweetalert/sweetalert.min.js"></script>
    <script>
        <?= $this->session->flashdata('messageAlert'); ?>
    </script>

</body>
<!--end::Body-->

</html>