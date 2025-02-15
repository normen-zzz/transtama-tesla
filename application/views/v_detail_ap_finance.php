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
                            <h2 class="card-title"><?= $title ?></h2>
                            <div class="card-toolbar">
                                <?php if ($info['status'] == 0) {
                                ?>
                                    <a onclick="return confirm('Are You Sure ?')" href="<?= base_url('approval/approveMgrFinance/' . $info['no_pengeluaran'] . '/' . $id_atasan) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
                                        Approve
                                    </a>
                                <?php    } else {
                                    echo '<h2 class="card-title">Approved</h2>';
                                } ?>
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

                                                            <?php    } ?>
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


                                            <div class="card-body" style="overflow: auto;">
                                                <h3>List <?= $info['nama_kategori'] ?></h3>
                                                <div class="row">
                                                    <table class="table table-separate table-head-custom table-checkable" id="myTable3">
                                                        <tr>
                                                            <td>Category</td>
                                                            <td>Description</td>
                                                            <td>Amount Proposed</td>
                                                            <td>Attachment</td>
                                                        </tr>
                                                        <?php foreach ($ap as $c) {
                                                        ?>
                                                            <tr>
                                                                <td><?= $c['nama_kategori'] ?></td>
                                                                <td><?= $c['description'] ?></td>
                                                                <td><?= rupiah($c['amount_proposed']) ?></td>
                                                                <td>
                                                                    <?php if ($info['status'] <= 0) {
                                                                    ?>
                                                                        <a data-toggle="modal" data-target="#modal-bukti<?= $c['id_pengeluaran'] ?>" class=" btn btn-sm text-light mt-1" style="background-color: #9c223b;">Attacment</a>
                                                                        <!-- <a data-toggle="modal" data-target="#modal-edit<?= $c['id_pengeluaran'] ?>" class=" btn btn-sm text-light mt-1" style="background-color: #9c223b;"> <i class="fa fa-edit text-light"></i> Edit</a> -->
                                                                    <?php    } else {
                                                                    ?>
                                                                        <a data-toggle="modal" data-target="#modal-bukti<?= $c['id_pengeluaran'] ?>" class=" btn btn-sm text-light mt-1" style="background-color: #9c223b;">Attacment</a>

                                                                    <?php    } ?>
                                                                </td>
                                                            </tr>

                                                        <?php } ?>

                                                    </table>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                                <?php if ($info['status'] == 2) {
                                                ?>

                                                <?php    } elseif ($info['status'] == 6) {
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
                    <form action="<?= base_url('cs/ap/edit') ?>" method="POST" enctype="multipart/form-data">
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