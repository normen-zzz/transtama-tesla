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
                        <h3 class="card-label">List of Airlines
                            <span class="d-block text-muted pt-2 font-size-sm"></span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addState">
                            Add Airlines
                        </button>
                    </div>


                </div>
                <div class="card-body">

                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable" id="dataAirlines">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Airlines</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if (!empty($airlines)) {
                                foreach ($airlines as $key => $value) {
                            ?>
                                    <tr>
                                        <td><?php echo $value['id_airlines']; ?></td>
                                        <td><?php echo $value['name_airlines']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary editAirlines" data-toggle="modal" data-target="#editAirlines" data-id="<?php echo $value['id_airlines']; ?>" data-airlines="<?php echo $value['name_airlines']; ?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger deleteAirlines" data-id="<?php echo $value['id_airlines']; ?>">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
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

<!-- modalAddAirlines  -->
<div class="modal fade" id="addState" tabindex="-1" role="dialog" aria-labelledby="addState" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Airlines</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addAirlinesForm">
                    <div class="form-group">
                        <label for="airlines">Airlines</label>
                        <input type="text" class="form-control" id="airlines" name="airlines" placeholder="Enter Airlines">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Airlines</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modalEditAirlines  -->
<div class="modal fade" id="editAirlines" tabindex="-1" role="dialog" aria-labelledby="editAirlines" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Airlines</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editAirlinesForm">
                    <div class="form-group">
                        <label for="airlines">Airlines</label>
                        <input type="text" class="form-control" id="airlinesEdit" name="airlines" placeholder="Enter Airlines">
                        <input type="text" class="form-control" id="idEdit" name="id" hidden>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit Airlines</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataAirlines').DataTable();

        $('#addAirlinesForm').submit(function(e) {
            e.preventDefault();
            var airlines = $('#airlines').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('superadmin/ptp/addAirlinesPtp'); ?>",
                data: {
                    airlines: airlines
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Airlines Added Successfully',
                            showConfirmButton: true,

                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: 'Loading',
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                                location.reload();
                            }
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Airlines Not Added',
                            showConfirmButton: true,

                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: 'Loading',
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                                location.reload();
                            }
                        });
                    }
                }
            });
        });


    });
</script>

<script>
    // .editAirlines 
    $('.editAirlines').click(function() {
        var id = $(this).data('id');
        var airlines = $(this).data('airlines');
        $('#airlinesEdit').val(airlines);
        $('#idEdit').val(id);
    });
</script>

<script>
    // formEditAirlines
    $('#editAirlinesForm').submit(function(e) {
        e.preventDefault();
        var airlines = $('#airlinesEdit').val();
        var id = $('#idEdit').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('superadmin/ptp/editAirlinesPtp'); ?>",
            data: {
                airlines: airlines,
                id: id
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Airlines Edited Successfully',
                        showConfirmButton: true,

                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Loading',
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                            location.reload();
                        }
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Airlines Not Edited',
                        showConfirmButton: true,

                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Loading',
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                            location.reload();
                        }
                    });
                }
            }
        });
    });
</script>

<script>
    // deleteAirlines
    $('.deleteAirlines').click(function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this Airlines!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('superadmin/ptp/deleteAirlinesPtp'); ?>",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Airlines Deleted Successfully',
                                showConfirmButton: true,

                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        title: 'Loading',
                                        onBeforeOpen: () => {
                                            Swal.showLoading()
                                        },
                                        showConfirmButton: false,
                                        allowOutsideClick: false
                                    });
                                    location.reload();
                                }
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Airlines Not Deleted',
                                showConfirmButton: true,

                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        title: 'Loading',
                                        onBeforeOpen: () => {
                                            Swal.showLoading()
                                        },
                                        showConfirmButton: false,
                                        allowOutsideClick: false
                                    });
                                    location.reload();
                                }
                            });
                        }
                    }
                });
            }
        });
    });
</script>