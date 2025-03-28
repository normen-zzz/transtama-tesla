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
                        <!--begin::Button-->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddCity">
                            Add City
                        </button>
                        <!--end::Button-->
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
                                <th>State</th>
                                <th>TLC</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            foreach ($city as $row) {
                            ?>
                                <tr>
                                    <td><?php echo $row->id_city_ptp; ?></td>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->name_state; ?></td>
                                    <td><?php echo $row->tlc; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary editCity" data-toggle="modal" data-target="#modalEditCity" data-id="<?php echo $row->id_city_ptp; ?>" data-name="<?php echo $row->name; ?>" data-state="<?php echo $row->id_state_ptp; ?>" data-tlc="<?php echo $row->tlc; ?>">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger deleteCity" data-id="<?php echo $row->id_city_ptp; ?>">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php

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

<!-- modalAddCity  -->

<div class="modal fade" id="modalAddCity" tabindex="-1" role="dialog" aria-labelledby="modalAddCity" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add City</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAddCity">
                    <div class="form-group">
                        <label for="name">Name City</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="state">State</label>
                        <select name="state" class="form-control" id="state" required>
                            <option value="">Select State</option>
                            <?php
                            foreach ($state->result_array() as $state2) {
                            ?>
                                <option value="<?php echo $state2['id_state_ptp']; ?>"><?php echo $state2['name_state']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tlc">TLC</label>
                        <!-- only text  -->
                        <input type="text" name="tlc" class="form-control" id="tlc" required maxlength="3">
                    </div>
                    <button type="submit" class="btn btn-primary">Add City</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modalEditCity -->
<div class="modal fade" id="modalEditCity" tabindex="-1" role="dialog" aria-labelledby="modalEditCity" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit City</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditCity">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="id" id="idEdit" hidden>
                        <input type="text" name="name" class="form-control" id="nameEdit" required>
                    </div>
                    <div class="form-group">
                        <label for="state">State</label>
                        <select name="state" class="form-control" id="stateEdit" required>
                            <option value="">Select State</option>
                            <?php
                            foreach ($state->result_array() as $state3) {
                            ?>
                                <option value="<?php echo $state3['id_state_ptp']; ?>"><?php echo $state3['name_state']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tlc">TLC</label>
                        <input type="text" name="tlc" class="form-control" id="tlcEdit" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Edit City</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--end::Content-->
<script>
    $(document).ready(function() {
        $('#formAddCity').submit(function(e) {
            e.preventDefault();
            var name = $('#name').val();
            var state = $('#state').val();
            var tlc = $('#tlc').val();
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
                url: '<?= base_url('superadmin/ptp/addCityPtp') ?>',
                type: 'post',
                data: {
                    name: name,
                    state: state,
                    tlc: tlc
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == 'success') {
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            type: 'success'
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
                            title: 'Error',
                            text: response.message,
                            type: 'error'
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

                    }
                }
            });
        });

        $('#formEditCity').submit(function(e) {
            e.preventDefault();
            var id = $('#idEdit').val();
            var name = $('#nameEdit').val();
            var state = $('#stateEdit').val();
            var tlc = $('#tlcEdit').val();
            $.ajax({
                url: '<?= base_url('superadmin/ptp/editCity') ?>',
                type: 'post',
                data: {
                    id: id,
                    name: name,
                    state: state,
                    tlc: tlc
                },
                success: function(data) {
                    $('#modalEditCity').modal('hide');
                    window.location.reload();
                }
            });
        });

        $('.deleteCity').click(function() {
            var id = $(this).data('id');
            Swal.fire({
                    title: 'Are you sure?',
                    text: "You will not be able to recover this data!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                })
                .then((result) => {
                    if (result.value) {
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
                            url: '<?= base_url('superadmin/Ptp/deleteCityPtp') ?>',
                            type: 'post',
                            data: {
                                id: id
                            },
                            success: function(response) {
                                response = JSON.parse(response);
                                if (response.status == 'success') {
                                    Swal.fire({
                                        title: 'Success',
                                        text: response.message,
                                        type: 'success'
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
                                        title: 'Error',
                                        text: response.message,
                                        type: 'error'
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

                                }
                            }
                        });
                    }
                });
        });
    });
</script>

<script>
    // .editCity 
    $('.editCity').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var state = $(this).data('state');
        var tlc = $(this).data('tlc');
        $('#idEdit').val(id);
        $('#nameEdit').val(name);
        $('#stateEdit').val(state);
        $('#tlcEdit').val(tlc);
    });

    // formEditCity 
    $('#formEditCity').submit(function(e) {
        e.preventDefault();
        var id = $('#idEdit').val();
        var name = $('#nameEdit').val();
        var state = $('#stateEdit').val();
        var tlc = $('#tlcEdit').val();
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
            url: '<?= base_url('superadmin/ptp/editCityPtp') ?>',
            type: 'post',
            data: {
                id_city_ptp: id,
                name: name,
                id_state_ptp: state,
                tlc: tlc
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.status == 'success') {
                    Swal.fire({
                        title: 'Success',
                        text: response.message,
                        type: 'success'
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
                        title: 'Error',
                        text: response.message,
                        type: 'error'
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

                }
            }
        });
    });
</script>