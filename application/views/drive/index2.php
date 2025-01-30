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
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />



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
    <?php $this->load->view('templates/back/navbar'); ?>

    <!-- Main content -->
    <section class="content">
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                    <!--begin::Dashboard-->
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-custom card-stretch">
                                <!-- /.box-body -->
                                <div class="row m-4" style="overflow: auto;">
                                    <div class="col-md-12">
                                        <!-- button modal add file  -->
                                        <?php if (($totalSize / 100) * 100 < 100) { ?>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFileDrive">
                                                Add File
                                            </button>
                                        <?php } ?>

                                        <table id="tableFileDrive" class="table table-bordered">
                                            <h3 class="title font-weight-bold">Your File</h3>

                                            <span><?= round($totalSize, 2)  ?>/100MB</span>
                                            <div class="progress">
                                                <?php if (($totalSize / 100) * 100 < 20) { ?>
                                                    <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: <?= ($totalSize / 100) * 100 ?>%;" aria-valuenow="<?= $totalSize / 100 ?>" aria-valuemin="0" aria-valuemax="100"><?= round(($totalSize / 100) * 100, 2)  ?>%</div>
                                                <?php } elseif (($totalSize / 100) * 100 < 50) { ?>
                                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?= ($totalSize / 100) * 100 ?>%;" aria-valuenow="<?= $totalSize / 100 ?>" aria-valuemin="0" aria-valuemax="100"><?= round(($totalSize / 100) * 100, 2)  ?>%</div>

                                                <?php } elseif (($totalSize / 100) * 100 < 75) { ?>
                                                    <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: <?= ($totalSize / 100) * 100 ?>%;" aria-valuenow="<?= $totalSize / 100 ?>" aria-valuemin="0" aria-valuemax="100"><?= round(($totalSize / 100) * 100, 2)  ?>%</div>
                                                <?php } else { ?>
                                                    <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?= ($totalSize / 100) * 100 ?>%;" aria-valuenow="<?= $totalSize / 100 ?>" aria-valuemin="0" aria-valuemax="100"><?= round(($totalSize / 100) * 100, 2)  ?>%</div>
                                                <?php } ?>
                                            </div>
                                            <!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
                                            <p><?= $this->session->flashdata('message'); ?></p>
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Description</th>
                                                    <th>Nama File</th>
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                <?php foreach ($drive as $d) : ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $d['description']; ?></td>
                                                        <td><?= $d['nama_file']; ?></td>
                                                        <td><?= $d['created_at']; ?></td>
                                                        <!-- button download  -->
                                                        <td>
                                                            <a target="_blank" href="<?= base_url('drive/download/' . $d['uuid']); ?>" class="btn btn-primary btn-sm">Download</a>
                                                            <!-- button modal  -->
                                                            <button type="button" class="btn btn-warning btn-sm getAccessDrive" data-toggle="modal" data-id_drive="<?= $d['id_drive'] ?>" data-target="#accessDrive">Access</button>

                                                            <button type="button" class="btn btn-danger btn-sm deleteDrive" data-id_drive="<?= $d['id_drive'] ?>">Delete</button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>

                                            </tbody>


                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                <!--end::Container-->
            </div>
            <!--end::Entry-->
        </div>
        <!--end::Content-->

        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                    <!--begin::Dashboard-->
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-custom card-stretch">
                                <!-- /.box-body -->
                                <div class="row m-4" style="overflow: auto;">
                                    <div class="col-md-12">
                                        <!-- button modal add file  -->

                                        <table id="tableFileDriveShares" class="table table-bordered">
                                            <h3 class="title font-weight-bold">File Shares with you</h3>
                                            <!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
                                            <p><?= $this->session->flashdata('message'); ?></p>
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Description</th>
                                                    <th>Nama File</th>
                                                    <th>File From</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                <?php foreach ($driveShares as $e) : ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $e['description']; ?></td>
                                                        <td><?= $e['nama_file']; ?></td>
                                                        <td><?= $e['pembuat']; ?></td>
                                                        <!-- button download  -->
                                                        <td>
                                                            <a target="_blank" href="<?= base_url('drive/download/' . $e['uuid']); ?>" class="btn btn-primary btn-sm">Download</a>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>

                                            </tbody>


                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                <!--end::Container-->
            </div>
            <!--end::Entry-->
        </div>
        <!--end::Content-->

        <!-- addFileDrive -->
        <div class="modal fade" id="addFileDrive" tabindex="-1" role="dialog" aria-labelledby="addFileDriveLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="formAddFile">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addFileDriveLabel">Add File Drive <span class="text-danger">*Max file 10MB</span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <!-- description  -->
                            <div class="form-group">
                                <label for="addDescription">Description</label>
                                <textarea name="description" id="addDescription" class="form-control" rows="3"></textarea>
                            </div>
                            <div class=" form-group">
                                <label for="addFile">File</label>
                                <input type="file" name="file" id="addFile" class="form-control">
                                <small class="text-danger">*Max file 10MB</small>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- modal access  -->
        <div class="modal fade" id="accessDrive" tabindex="-1" role="dialog" aria-labelledby="accessDriveLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="accessDriveLabel">Access Drive</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="AddAccess" class="mb-4" style="border: 1;">
                            <label for="addAccess">Add Access</label>
                            <div class="form-group">

                                <input type="text" name="id_drive" hidden id="id_drive">
                                <select name="userAccess" class="form-select userAccess">
                                    <option value="0">All Users</option>
                                    <?php foreach ($users as $u) : ?>
                                        <option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" id="submitUserAccess" class="btn btn-primary">Submit</button>
                        </form>
                        <table class="table mt-2" id="tableAccessDrive">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>

                            </tbody>
                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--/. container-fluid -->
    </section>
    <?php $this->load->view('templates/back/footer'); ?>
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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/back/metronic/') ?>plugins/global/plugins.bundle.js"></script>



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
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

    <script>
        $(document).ready(function() {
            $('#tableFileDrive').DataTable();
        });

        $(document).ready(function() {
            $('#tableFileDriveShares').DataTable();
        });
        // userAccess
        $('.userAccess').select2({

        });
        // deleteDrive
        $('.deleteDrive').on('click', function() {
            const id_drive = $(this).data('id_drive');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this file?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('drive/deleteDrive') ?>",
                        type: 'post',
                        data: {
                            id_drive: id_drive
                        },
                        success: function() {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            ).then((result) => {
                                Swal.fire({
                                    title: 'Reload',
                                    html: 'Please wait',
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                });
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'Your file has not been deleted.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>

    <script>
        // AddAccess
        $('#AddAccess').submit(function(e) {
            e.preventDefault();


            // swal loading 
            Swal.fire({
                title: 'Adding access',
                html: 'Please wait',
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
                allowOutsideClick: false,
                showConfirmButton: false,
            });
            $.ajax({
                url: "<?= base_url('drive/addAccess') ?>",
                type: 'post',
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                success: function() {
                    Swal.fire(
                        'Success!',
                        'Access has been added.',
                        'success'
                    ).then((result) => {
                        Swal.fire({
                            title: 'Reload',
                            html: 'Please wait',
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                            allowOutsideClick: false,
                            showConfirmButton: false,
                        });
                        location.reload();

                    });
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'Access has not been added.',
                        'error'
                    );
                }
            });
        });
    </script>

    <script>
        // formAddFile
        $('#formAddFile').submit(function(e) {
            // show swal loading 
            // ketika lagi proses upload file munculkan loading

            e.preventDefault();
            // swal confirm 
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to add this file?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, add it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // swal showLoading 

                    // jika file diatas 10MB maka false 
                    if ($('#addFile')[0].files[0].size > 10000000) {
                        Swal.fire(
                            'Error!',
                            'File melebihi 10MB',
                            'error'
                        );
                        return false;
                        location.reload();
                    } else {
                        Swal.fire({
                            title: 'WAIT',
                            html: 'Please wait',

                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                            allowOutsideClick: false,
                            // dont show ok button 
                            showConfirmButton: false,
                        });

                        $.ajax({
                            url: "<?= base_url('drive/addDrive') ?>",
                            type: 'post',
                            data: new FormData(this),
                            processData: false,
                            contentType: false,
                            cache: false,

                            success: function(data) {
                                const response = JSON.parse(data);

                                if (response.status == 'success') {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Your request has been processed successfully.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        // reload page
                                        Swal.fire({
                                            title: 'WAIT',
                                            html: 'Please wait',

                                            onBeforeOpen: () => {
                                                Swal.showLoading()
                                            },
                                            allowOutsideClick: false,
                                            // dont show ok button 
                                            showConfirmButton: false,
                                        });


                                        location.reload();

                                    });

                                } else {
                                    Swal.fire(
                                        'Error!',
                                        response.message,
                                        'error'
                                    );
                                }
                            },
                            error: function() {
                                Swal.fire(
                                    'Error!',
                                    'File gagal diupload',
                                    'error'
                                );
                            }
                        });
                    }
                }
            });






        });

        // getAccessDrive
        $('.getAccessDrive').on('click', function() {
            const id_drive = $(this).data('id_drive');
            $('#id_drive').val(id_drive);
            $.ajax({
                url: "<?= base_url('drive/getAccessDrive') ?>",
                type: 'post',
                data: {
                    id_drive: id_drive
                },
                success: function(data) {

                    const response = JSON.parse(data);
                    let html = '';
                    response.forEach(function(row) {
                        if (row.to == 0) {
                            row.penerima = 'All Users';
                            // hide form add access
                            $('#AddAccess').hide();

                        }
                        html += `<tr>
                            <td>${row.penerima}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm deleteAccess" data-id_access="${row.id_drive_access}">Delete</button>
                            </td>
                        </tr>`;
                    });
                    $('#tableAccessDrive tbody').html(html);
                    // Add event listener for deleteAccess button
                    $('.deleteAccess').on('click', function() {
                        const id_access = $(this).data('id_access');
                        $.ajax({
                            url: "<?= base_url('drive/deleteAccess') ?>",
                            type: 'post',
                            data: {
                                id_access: id_access
                            },
                            success: function() {
                                Swal.fire(
                                    'Deleted!',
                                    'Access has been deleted.',
                                    'success'
                                ).then((result) => {
                                    location.reload();
                                });
                            },
                            error: function() {
                                Swal.fire(
                                    'Error!',
                                    'Access has not been deleted.',
                                    'error'
                                );
                            }
                        });
                    });
                }
            });
        });
    </script>