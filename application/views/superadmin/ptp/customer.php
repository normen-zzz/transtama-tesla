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
                        <h3 class="card-label">List of Customer
                            <span class="d-block text-muted pt-2 font-size-sm"></span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCustomer">
                            Add Customer
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
                                <th>Name Customer</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customer_ptp as $c) : ?>
                                <tr>
                                    <td><?= $c['id_customer_ptp'] ?></td>
                                    <td><?= $c['nama_customer'] ?></td>
                                    <td><?= $c['city'] ?></td>
                                    <td><?= $c['state'] ?></td>
                                    <td><?= $c['address'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary editCustomer" data-target="#editCustomer" data-toggle="modal" data-id="<?= $c['id_customer_ptp'] ?>" data-nama_customer="<?= $c['nama_customer'] ?>" data-city="<?= $c['city'] ?>" data-state="<?= $c['state'] ?>" data-address="<?= $c['address'] ?>">Edit</button>
                                        <button type="button" class="btn btn-danger deleteCustomer" data-id="<?= $c['id_customer_ptp'] ?>">Delete</button>
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

<!-- Modal Add Customer -->
<div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="addCustomer" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Add Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAddCustomer">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name_customer">Name Customer</label>
                        <input type="text" class="form-control" id="nama_customer" name="nama_customer">
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city">
                    </div>
                    <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" class="form-control" id="state" name="state">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modalEditCustomer -->
<div class="modal fade" id="editCustomer" tabindex="-1" role="dialog" aria-labelledby="editCustomer" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditCustomer">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name_customer">Name Customer</label>
                        <input type="text" class="form-control" id="name_customerEdit" name="nama_customer">
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="cityEdit" name="city">
                    </div>

                    <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" class="form-control" id="stateEdit" name="state">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="addressEdit" name="address">
                    </div>
                    <input type="hidden" name="id_customer_ptp" id="id_customer_ptp">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#formAddCustomer').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Loading',
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
                showConfirmButton: false,
                allowOutsideClick: false
            });
            $.ajax({
                url: '<?= base_url('superadmin/ptp/addCustomerPtp') ?>',
                type: 'post',
                data: $(this).serialize(),
                success: function(data) {
                    var response = JSON.parse(data);
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then((result) => {
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
                            title: 'Error',
                            text: response.message
                        });
                    }
                }
            });
        });

        $('.editCustomer').click(function() {
            var id = $(this).data('id');
            var nama_customer = $(this).data('nama_customer');
            var city = $(this).data('city');
            var state = $(this).data('state');
            var address = $(this).data('address');

            $('#name_customerEdit').val(nama_customer);
            $('#cityEdit').val(city);
            $('#stateEdit').val(state);
            $('#addressEdit').val(address);
            $('#id_customer_ptp').val(id);
        });

        $('#formEditCustomer').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Loading',
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
                showConfirmButton: false,
                allowOutsideClick: false
            });
            $.ajax({
                url: '<?= base_url('superadmin/Ptp/editCustomerPtp') ?>',
                type: 'post',
                data: $(this).serialize(),
                success: function(data) {
                    console.log(data);
                    
                    var response = JSON.parse(data);
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then((result) => {
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
                            title: 'Error',
                            text: response.message
                        });
                    }
                }
            });
        });

        $('.deleteCustomer').click(function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('superadmin/ptp/deleteCustomerPtp') ?>',
                        type: 'post',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            var response = JSON.parse(data);
                            if (response.status == 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                ).then((result) => {
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
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        }
                    });
                }
            });
        });
    });
</script>