<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">List of City
                            <span class="d-block text-muted pt-2 font-size-sm"></span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="#" class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#modal-lg" style="background-color: #9c223b;">
                            <span class="svg-icon svg-icon-md">
                                <i class="fa fa-plus text-light"></i>
                                <!--end::Svg Icon-->
                            </span>Add</a>
                        <!--end::Button-->

                        <!-- BUTTON MODALL  -->
                        <button type="button" class="btn text-light" data-toggle="modal" data-target="#EditTreeCodeBulky" style="background-color: #9c223b;">
                            <i class="fa fa-plus text-light"></i>
                            <!--end::Svg Icon-->
                            Edit Tree Code Bulky
                        </button>
                        <!--end::Button-->
                        <button type="button" class="btn text-light" data-toggle="modal" data-target="#editLeadBulky" style="background-color: #9c223b;">
                            <i class="fa fa-plus text-light"></i>
                            <!--end::Svg Icon-->
                            Edit Lead Bulky
                        </button>
                    </div>


                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable" id="myTable">

                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                        <thead>
                            <tr>
                                <th>Name Of City</th>
                                <th>Tree Code</th>
                                <th>Lead (MIN)</th>
                                <th>Lead (MAX)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($city as $p) { ?>
                                <tr>

                                    <td><?= $p['city_name'] ?></td>
                                    <td><?= $p['tree_code'] ?></td>
                                    <td><?= $p['lead_min'] ?></td>
                                    <td><?= $p['lead_max'] ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                <a href="#addBookDialog" class="open-Arrive dropdown-item" data-toggle="modal" data-id="<?= $p['id_city'] ?>" data-code="<?= $p['tree_code'] ?>" data-name="<?= $p['city_name']  ?>">Edit</a>
                                                <a href="<?= base_url('superadmin/city/delete/' . $p['id_city']) ?>" onclick="return confirm('Apakah Anda yakin ?')" class="dropdown-item">Delete</a>

                                            </div>
                                        </div>


                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>


<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New City</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('superadmin/city/add') ?>" method="POST">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama of City</label>
                                    <input type="text" class="form-control" required name="city_name">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tree Code</label>
                                    <input type="text" class="form-control" required name="tree_code">
                                </div>

                            </div>


                        </div>



                    </div>
                    <!-- /.card-body -->


            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="addBookDialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form role="form" action="<?= base_url('superadmin/city/edit') ?>" method="POST" class="form-horizontal">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <div class="p-2">

                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label" for="example-input-small">City Name</label>
                                        <div class="col-md-6">
                                            <input type="text" id="id" hidden name="id_city" value="">
                                            <input type="text" id="city_name" value="" name="city_name" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label" for="example-input-small">Tree Code</label>
                                        <div class="col-md-6">
                                            <input type="text" id="tree_code" value="" name="tree_code" class="form-control form-control-sm">
                                        </div>
                                    </div>


                                </div>
                            </div> <!-- end card-box -->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- EditTreeCodeBulky -->
<div class="modal fade" id="EditTreeCodeBulky" tabindex="-1" role="dialog" aria-labelledby="EditTreeCodeBulky" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Tree Code Bulky</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('superadmin/city/editTreeCodeBulky') ?>" method="POST" id="formEditTreeCodeBulky" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="exampleInputEmail1">Tree Code file</label>
                                    <input type="file" class="form-control" required name="file">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">

                    <button type="button" class="btn btn-primary" id="buttonEditTreeCodeBulky">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- editLeadBulky -->
<div class="modal fade" id="editLeadBulky" tabindex="-1" role="dialog" aria-labelledby="editLeadBulky" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Lead Bulky</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('superadmin/city/editLeadBulky') ?>" method="POST" id="formEditLeadBulky" enctype="multipart/form-data">
                <div class="modal-body ">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="exampleInputEmail1">Lead Min</label>
                                    <input type="file" class="form-control" required name="file">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">

                    <button type="button" class="btn btn-primary" id="buttonEditLeadBulky">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>




<script>
    //   buttonEditTreeCodeBulky
    $(document).on('click', '#buttonEditTreeCodeBulky', function() {
        //    form submit 
        // swal confirm 
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to edit Tree Code Bulky",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#formEditTreeCodeBulky').submit();
                // swal loading 
                Swal.fire({
                    title: 'Please Wait',
                    html: 'Loading...',
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    showConfirmButton: false,
                    allowOutsideClick: false
                })
            }
        })
    });

    //   buttonEditLeadBulky
    $(document).on('click', '#buttonEditLeadBulky', function() {
        //    form submit 
        // swal confirm 
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to edit Lead Bulky",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#formEditLeadBulky').submit();
                // swal loading 
                Swal.fire({
                    title: 'Please Wait',
                    html: 'Loading...',
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    showConfirmButton: false,
                    allowOutsideClick: false
                })
            }
        })
    });
</script>