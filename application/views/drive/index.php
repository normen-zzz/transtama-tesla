<!--begin::Content-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/scans/css/style.css">
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
                                            <th>uuid</th>
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
                                                <td><?= $d['uuid']; ?></td>
                                                <td><?= $d['nama_file']; ?></td>
                                                <td><?= $d['created_at']; ?></td>
                                                <!-- button download  -->
                                                <td>
                                                    <a href="<?= base_url('drive/download/' . $d['uuid']); ?>" class="btn btn-primary btn-sm">Download</a>
                                                    <!-- button modal  -->
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#accessDrive">Access</button>

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
                                            <th>uuid</th>
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
                                                <td><?= $e['uuid']; ?></td>
                                                <td><?= $e['nama_file']; ?></td>
                                                <td><?= $e['pembuat']; ?></td>
                                                <!-- button download  -->
                                                <td>
                                                    <a href="<?= base_url('drive/download/' . $e['uuid']); ?>" class="btn btn-primary btn-sm">Download</a>

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

                        <select name="userAccess" class="form-select">
                            <option value="0">All Users</option>
                            <?php foreach ($users as $u) : ?>
                                <option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <table class="table mt-2">
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>John Doe</td>
                        <td><button type="button" class="btn btn-danger btn-sm DeleteAccess">Delete</button></td>
                    </tr>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#tableFileDrive').DataTable();
    });

    $(document).ready(function() {
        $('#tableFileDriveShares').DataTable();
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
    // formAddFile
    $('#formAddFile').submit(function(e) {
        // show swal loading 
        Swal.fire({
            title: 'Uploading file',
            html: 'Please wait',
            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        });

        e.preventDefault();
        // jika file diatas 10MB maka false 
        if ($('#addFile')[0].files[0].size > 10000000) {
            Swal.fire(
                'Error!',
                'File melebihi 10MB',
                'error'
            );
            return false;
            location.reload();
        }
        $.ajax({
            url: "<?= base_url('drive/addDrive') ?>",
            type: 'post',
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(data) {
                const response = JSON.parse(data);
                if (response.status == 'success') {
                    Swal.fire(
                        'Success!',
                        response.message,
                        'success'
                    ).then((result) => {
                        // loading 
                        Swal.fire({
                            title: 'Uploading file',
                            html: 'Please wait',
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
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
    });
</script>