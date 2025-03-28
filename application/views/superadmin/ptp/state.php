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
                        <h3 class="card-label">List of STATE
                            <span class="d-block text-muted pt-2 font-size-sm"></span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addState">
                            Add State
                        </button>
                    </div>


                </div>
                <div class="card-body">

                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable" id="myTable">

                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($state as $s) : ?>
                                <tr>
                                    <td><?= $s['id_state_ptp'] ?></td>
                                    <td><?= $s['name_state'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary editState" data-toggle="modal" data-target="#modalEditState" data-id="<?= $s['id_state_ptp'] ?>" data-name="<?= $s['name_state'] ?>">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger deleteState" data-id="<?= $s['id_state_ptp'] ?>" >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

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

<!-- modalAddState -->

<div class="modal fade" id="addState" tabindex="-1" role="dialog" aria-labelledby="addState" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formAddState">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Add State</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name_state">Name State</label>
                        <input type="text" class="form-control" id="name_state" name="name_state" placeholder="Enter Name State">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add State</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modalEditState -->
<div class="modal fade" id="modalEditState" tabindex="-1" role="dialog" aria-labelledby="addState" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formEditState">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit State</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name_state">Name State</label>
                        <input type="number" name="id_state_ptp" id="id_state_ptpEdit">
                        <input type="text" class="form-control" id="name_stateEdit" name="name_state" placeholder="Enter Name State">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit State</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#formAddState').submit(function(e) {
            e.preventDefault();
            var name_state = $('#name_state').val();
            // swal loading 
            Swal.fire({
                title: 'Loading',
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
                showConfirmButton: false,
                allowOutsideClick: false
            });
            $.ajax({
                url: '<?= base_url('superadmin/ptp/addStatePtp') ?>',
                type: 'post',
                data: {
                    name_state: name_state
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == 'success') {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Data has been added'
                        }).then(function() {
                            Swal.fire({
                                title: 'Loading',
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: 'Data failed to add'
                        }).then(function() {
                            Swal.fire({
                                title: 'Loading',
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                            location.reload();
                        });

                    }

                }
            });
        });

        $('#formEditState').submit(function(e) {
            e.preventDefault();
            var id_state_ptp = $('#id_state_ptpEdit').val();
            var name_state = $('#name_stateEdit').val();
            $.ajax({
                url: '<?= base_url('superadmin/ptp/editStatePtp') ?>',
                type: 'post',
                data: {
                    id_state_ptp: id_state_ptp,
                    name_state: name_state
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Data has been edited'
                        }).then(function() {
                            // swal loading 
                            Swal.fire({
                                title: 'Loading',
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: 'Data failed to edit'
                        }).then(function() {
                            Swal.fire({
                                title: 'Loading',
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                            location.reload();
                        });

                    }

                }
            });
        });

        // editState
        $('.editState').click(function() {
            var id_state_ptp = $(this).data('id');
            var name_state = $(this).data('name');
            $('#id_state_ptpEdit').val(id_state_ptp);
            $('#name_stateEdit').val(name_state);
        });
    });
</script>

<script>
    // deleteState
    $('.deleteState').click(function() {
        var id_state_ptp = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this data",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('superadmin/ptp/deleteStatePtp') ?>',
                    type: 'post',
                    data: {
                        id_state_ptp: id_state_ptp
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status == 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Data has been deleted.',
                                'success'
                            ).then(function() {
                                // swal loading 
                                Swal.fire({
                                    title: 'Loading',
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Data failed to delete.',
                                'error'
                            ).then(function() {
                                // swal loading 
                                Swal.fire({
                                    title: 'Loading',
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                                location.reload();
                            });
                        }
                    }
                });
            }
        });
    });
</script>