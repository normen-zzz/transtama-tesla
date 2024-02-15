<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta charset="utf-8" />
    <title>Tesla Smartwork</title>
    <meta name="description" content="Updates and statistics" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->

    <link href="<?= base_url('assets/back/metronic/') ?>plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/back/metronic/') ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="<?= base_url('assets/back/metronic/') ?>plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/back/metronic/') ?>plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/back/') ?>plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/back/') ?>plugins/dropify/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <!-- <link href="<?= base_url('assets/back/') ?>plugins/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css" /> -->
    <link href="<?= base_url('assets/back/metronic/') ?>css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/back/metronic/') ?>css/pages/wizard/wizard-3.css" rel="stylesheet" type="text/css" />

    <!-- scan -->
    <!-- 
	<link rel="stylesheet" href="<?= base_url('assets/scan/') ?>style.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
	<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script> -->
    <!-- <link rel="stylesheet" href="https://twitter.github.io/typeahead.js/css/examples.css" /> -->


    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('assets/back/metronic/') ?>plugins/custom/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

    <link type="text/css" href="<?= base_url('assets/back/metronic/') ?>css/jquery.signature.css" rel="stylesheet">

    <link rel="shortcut icon" href="<?= base_url('uploads/') ?>icon512.png" />
    <style>
        .dataTables_wrapper .dataTables_filter {
            float: left;
        }

        .dataTables_wrapper .dataTables_length {
            float: right;
        }
    </style>
    <style type="text/css">
        body {
            font-family: Helvetica, sans-serif;
        }

        h2,
        h3 {
            margin-top: 0;
        }

        form {
            margin-top: 15px;
        }

        form>input {
            margin-right: 15px;
        }

        #results {
            float: right;
            margin: 20px;
            padding: 20px;
            border: 1px solid;
            background: #ccc;
        }
    </style>


</head>
<!--end::Head-->

<body id="kt_body" class="header-fixed header-mobile-fixed header-bottom-enabled page-loading" style="background-color: #eee;">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Provinsi <?= $provinsi->name; ?></h2>
                            <h2 class="card-title">Kabupaten <?= $namaKabupaten->name; ?></h2>
                            <div class="card-toolbar">

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="overflow: auto;">
                            <div class="card-body p-0">
                                <!--begin: Wizard-->

                                <div class="row justify-content-center">
                                    <div class="col-xl-12 col-xxl-7">
                                        <table class="table table-bordered" id="table">
                                            <thead>
                                                <tr>

                                                    <th class="text-center">Nama Kecamatan</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($kecamatan as $kecamatan) {
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?= $kecamatan->name ?></td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>
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

    <!-- REQUIRED SCRIPTS -->
    <script>
        var HOST_URL = "#";
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

    <script src="<?php echo base_url() ?>assets/scans/js/qrcodelib.js"></script>
    <script src="<?php echo base_url() ?>assets/scans/js/webcodecamjquery.js"></script>
    <script src="<?php echo base_url() ?>assets/scans/app/core/scan.js"></script>

    <script src="<?= base_url('assets/back/metronic/') ?>plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="<?= base_url('assets/back/metronic/') ?>js/scripts.bundle.js"></script>
    <!--end::Global Theme Bundle-->
    <script src="<?= base_url('assets/back/metronic/') ?>js/pages/crud/forms/editors/summernote.js"></script>
    <!--begin::Page Vendors(used by this page)-->
    <script src="<?= base_url('assets/back/metronic/') ?>plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Vendors(used by this page)-->
    <script src="<?= base_url('assets/back/metronic/') ?>plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="<?= base_url('assets/back/metronic/') ?>js/pages/widgets.js"></script>
    <!--end::Page Scripts-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="<?= base_url('assets/back/metronic/') ?>js/pages/crud/datatables/basic/scrollable.js"></script>
    <!--end::Page Scripts-->

    <script src="<?= base_url('assets/back/metronic/') ?>js/pages/crud/forms/widgets/bootstrap-datetimepicker.js">
    </script>
    <script src="<?= base_url('assets/back/metronic/') ?>js/pages/custom/wizard/wizard-3.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url('assets/back/metronic/') ?>plugins/custom/sweetalert2/sweetalert2.min.js"></script>
    <!-- Select2 -->
    <script src="<?= base_url('assets/back/') ?>plugins/select2/js/select2.min.js"></script>
    <!-- Toastr -->
    <script src=" <?= base_url('assets/back/metronic/') ?>js/myscript.js"></script>
    <!-- jSignature -->
    <script src="<?= base_url('assets/back/metronic/') ?>js/jquery.signature.js"></script>
    <script src="<?= base_url('assets/back/metronic/') ?>js/jSignature.min.js"></script>
    <script src="<?= base_url('assets/back/') ?>plugins/dropify/js/dropify.min.js"></script>


    <script src="<?= base_url('assets/back/metronic/') ?>js/pages/crud/forms/widgets/typeahead.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#consigne').on('input', function() {
                var kode = $(this).val();
                console.log(kode);

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('shipper/order/get_consigne') ?>",
                    dataType: "JSON",
                    data: {
                        kode: kode
                    },
                    cache: false,
                    success: function(data) {
                        $.each(data, function(consigne, destination) {
                            $('[name="consigne"]').val(data.consigne);
                            $('[name="destination"]').val(data.destination);
                        });
                    }

                });
                return false;

            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "pageLength": 100,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $('.dropify').dropify();
            $('#shipper_id').change(function() {
                var id = $(this).val();
                // console.log(id);

                $.ajax({
                    url: "<?php echo site_url('shipper/customer/getCustomerById'); ?>",
                    method: "POST",
                    data: {
                        id: id
                    },
                    async: true,
                    dataType: 'json',
                    success: function(data) {
                        $('#origin_destination').val(data.alamat);
                        // $('#sender').val(data.pic);
                        $('#id_customer').val(data.id_customer);
                        $('#state_shipper').val(data.provinsi);
                        $('#city_shipper').val(data.kota);
                        $('#shipper').val(data.nama_pt);
                        // $('#nama1').html(html);

                    }
                });
                return false;
                // alert('not found');
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            // Initialize jSignature
            var $sigdiv = $("#signature").jSignature({
                'UndoButton': true,
                'height': 200,
                'width': 250

            });

            $('#click').click(function() {
                // Get response of type image
                var data = $sigdiv.jSignature('getData', 'image');
                // Storing in textarea
                $('#output').val(data);
                console.log(data);

                // Alter image source 
                $('#sign_prev').attr('src', "data:" + data);
                $('#sign_prev').show();


            });
        });
    </script>
    <script type="text/javascript">
        $('select').select2({
            allowClear: true,
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "ordering": false,
                // "dom": '<"top"f>rt<"bottom"ilp><"clear">',
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-12'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
                    "<'row'<'col-lg-10 col-md-10 col-xs-12'l>>",
            });
        });
        $(document).ready(function() {
            var myTable = $('#myTable2').DataTable({
                "ordering": false,
                "dom": '<"top"f>rt<"bottom"ilp><"clear">'
            });
        });

        // Class definition

        var KTSummernoteDemo = function() {
            // Private functions
            var demos = function() {
                $('.summernote').summernote({
                    height: 150,
                    width: 720
                });
            }

            return {
                // public functions
                init: function() {
                    demos();
                }
            };
        }();

        // Initialization
        jQuery(document).ready(function() {
            KTSummernoteDemo.init();
        });
    </script>

    <script type="text/javascript">
        function showSoal(select) {
            if (select.value == 'Pg') {
                document.getElementById('demo').style.display = "block";
                document.getElementById('essay').style.display = "none";
            } else if (select.value == 'essay') {
                document.getElementById('demo').style.display = "none";
                document.getElementById('essay').style.display = "block";
            } else {
                document.getElementById('demo').style.display = "none";
                document.getElementById('essay').style.display = "none";

            }
        }
    </script>




</body>
<!--end::Body-->

</html>



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