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
                        <h3 class="card-label">List of Cost
                            <span class="d-block text-muted pt-2 font-size-sm"></span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddCost">
                            Add Cost
                        </button>
                    </div>


                </div>
                <div class="card-body">
                    <div class="table-responsive">



                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable" id="tableCost">
                            <thead>
                                <tr>
                                    <th>Id Cost</th>
                                    <th>City</th>
                                    <th>Airlines</th>
                                    <th>Flight SMU</th>
                                    <th>RA</th>
                                    <th>PACKING</th>
                                    <th>REFUND</th>
                                    <th>SPECIAL REFUND</th>
                                    <th>INSURANCE</th>
                                    <th>SURCHARGE</th>
                                    <th>hand_cgk</th>
                                    <th>hand_pickup</th>
                                    <th>hd_daerah</th>
                                    <th>pph</th>
                                    <th>sdm</th>
                                    <th>others</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cost as $c) : ?>
                                    <tr>
                                        <td><?= $c['id_cost_ptp'] ?></td>
                                        <td><?= $c['name_city'] ?></td>
                                        <td><?= $c['name_airlines'] ?></td>
                                        <td><?= $c['flight_smu'] ?></td>
                                        <td><?= $c['ra'] ?></td>
                                        <td><?= $c['packing'] ?></td>
                                        <td><?= $c['refund'] ?></td>
                                        <td><?= $c['specialrefund'] ?></td>
                                        <td><?= $c['insurance'] ?></td>
                                        <td><?= $c['surcharge'] ?></td>
                                        <td><?= $c['hand_cgk'] ?></td>
                                        <td><?= $c['hand_pickup'] ?></td>
                                        <td><?= $c['hd_daerah'] ?></td>
                                        <td><?= $c['pph'] ?></td>
                                        <td><?= $c['sdm'] ?></td>
                                        <td><?= $c['others'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary editCost" data-toggle="modal" data-target="#editCost" data-id="<?= $c['id_cost_ptp'] ?>" data-city="<?= $c['id_city_ptp'] ?>" data-airlines="<?= $c['id_airlines'] ?>" data-flight="<?= $c['flight_smu'] ?>" data-ra="<?= $c['ra'] ?>" data-packing="<?= $c['packing'] ?>" data-refund="<?= $c['refund'] ?>" data-special="<?= $c['specialrefund'] ?>" data-insurance="<?= $c['insurance'] ?>" data-surcharge="<?= $c['surcharge'] ?>" data-handcgk="<?= $c['hand_cgk'] ?>" data-handpickup="<?= $c['hand_pickup'] ?>" data-hddaerah="<?= $c['hd_daerah'] ?>" data-pph="<?= $c['pph'] ?>" data-sdm="<?= $c['sdm'] ?>" data-others="<?= $c['others'] ?>">Edit</button>

                                            <button type="button" class="btn btn-danger deleteCost" data-id="<?= $c['id_cost_ptp'] ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>


                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>

<!-- modalAddCost  -->
<div class="modal fade" id="modalAddCost" tabindex="-1" role="dialog" aria-labelledby="ModalAddCost" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Cost PTP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAddCost" method="POST">
                    <div class="form-group">
                        <label for="city">City</label>
                        <select class="form-control" id="city" name="city">
                            <option value="">Select City</option>
                            <?php foreach ($city as $c) : ?>
                                <option value="<?= $c['id_city_ptp'] ?>"><?= $c['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="airlines">Airlines</label>
                        <select class="form-control" id="airlines" name="airlines">
                            <option value="">Select Airlines</option>
                            <?php foreach ($airlines as $a) : ?>
                                <option value="<?= $a['id_airlines'] ?>"><?= $a['name_airlines'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="flight">Flight SMU</label>
                        <input type="text" class="form-control" id="flight" name="flight" value="0">
                    </div>
                    <div class="form-group">
                        <label for="ra">RA</label>
                        <input type="text" class="form-control" id="ra" name="ra" value="0">
                    </div>
                    <div class="form-group">
                        <label for="packing">PACKING</label>
                        <input type="text" class="form-control" id="packing" name="packing" value="0">
                    </div>
                    <div class="form-group">
                        <label for="refund">REFUND (%)</label>
                        <input type="text" class="form-control" id="refund" name="refund" value="0">
                    </div>
                    <div class="form-group">
                        <label for="special">SPECIAL REFUND</label>
                        <input type="text" class="form-control" id="specialrefund" name="specialrefund" value="0">
                    </div>
                    <div class="form-group">
                        <label for="insurance">INSURANCE</label>
                        <input type="text" class="form-control" id="insurance" name="insurance" value="0">
                    </div>
                    <div class="form-group">
                        <label for="surcharge">SURCHARGE</label>
                        <input type="text" class="form-control" id="surcharge" name="surcharge" value="0">
                    </div>
                    <div class="form-group">
                        <label for="handcgk">hand_cgk</label>
                        <input type="text" class="form-control" id="handcgk" name="handcgk" value="0">
                    </div>
                    <div class="form-group">
                        <label for="handpickup">hand_pickup</label>
                        <input type="text" class="form-control" id="handpickup" name="handpickup" value="0">
                    </div>
                    <div class="form-group">
                        <label for="hddaerah">hd_daerah</label>
                        <input type="text" class="form-control" id="hddaerah" name="hddaerah" value="0">
                    </div>
                    <div class="form-group">
                        <label for="pph">pph</label>
                        <input type="text" class="form-control" id="pph" name="pph" value="0">
                    </div>

                    <div class="form-group">
                        <label for="sdm">sdm</label>
                        <input type="text" class="form-control" id="sdm" name="sdm" value="0">
                    </div>
                    <div class="form-group">
                        <label for="others">others</label>
                        <input type="text" class="form-control" id="others" name="others" value="0">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Cost</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modalEditCost -->
<div class="modal fade" id="editCost" tabindex="-1" role="dialog" aria-labelledby="editCost" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formEditCost" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Cost PTP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="text" id="idCostEdit" name="idCost" hidden>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="city">City</label>
                        <select class="form-control" id="cityEdit" name="city">
                            <option value="">Select City</option>
                            <?php foreach ($city as $c) : ?>
                                <option value="<?= $c['id_city_ptp'] ?>"><?= $c['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="airlines">Airlines</label>
                        <select class="form-control" id="airlinesEdit" name="airlines">
                            <option value="">Select Airlines</option>
                            <?php foreach ($airlines as $a) : ?>
                                <option value="<?= $a['id_airlines'] ?>"><?= $a['name_airlines'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="flight">Flight SMU</label>
                        <input type="text" class="form-control" id="flightEdit" name="flight">
                    </div>
                    <div class="form-group">
                        <label for="ra">RA</label>
                        <input type="text" class="form-control" id="raEdit" name="ra">
                    </div>
                    <div class="form-group">
                        <label for="packing">PACKING</label>
                        <input type="text" class="form-control" id="packingEdit" name="packing">
                    </div>
                    <div class="form-group">
                        <label for="refund">REFUND (%)</label>
                        <input type="text" class="form-control" id="refundEdit" name="refund">
                    </div>
                    <div class="form-group">
                        <label for="special">SPECIAL REFUND</label>
                        <input type="text" class="form-control" id="specialrefundEdit" name="specialrefund">
                    </div>
                    <div class="form-group">
                        <label for="insurance">INSURANCE</label>
                        <input type="text" class="form-control" id="insuranceEdit" name="insurance">
                    </div>
                    <div class="form-group">
                        <label for="surcharge">SURCHARGE</label>
                        <input type="text" class="form-control" id="surchargeEdit" name="surcharge">
                    </div>
                    <div class="form-group">
                        <label for="handcgk">hand_cgk</label>
                        <input type="text" class="form-control" id="handcgkEdit" name="handcgk">
                    </div>
                    <div class="form-group">
                        <label for="handpickup">hand_pickup</label>
                        <input type="text" class="form-control" id="handpickupEdit" name="handpickup">
                    </div>
                    <div class="form-group">
                        <label for="hddaerah">hd_daerah</label>
                        <input type="text" class="form-control" id="hddaerahEdit" name="hddaerah">
                    </div>
                    <div class="form-group">
                        <label for="pph">pph</label>
                        <input type="text" class="form-control" id="pphEdit" name="pph">
                    </div>

                    <div class="form-group">
                        <label for="sdm">sdm</label>
                        <input type="text" class="form-control" id="sdmEdit" name="sdm">
                    </div>
                    <div class="form-group">
                        <label for="others">others</label>
                        <input type="text" class="form-control" id="othersEdit" name="others">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Edit Cost</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // formAddCost
    $('#formAddCost').submit(function(e) {
        e.preventDefault();
        var city = $('#city').val();
        var airlines = $('#airlines').val();
        var flight = $('#flight').val();
        var ra = $('#ra').val();
        var packing = $('#packing').val();
        var refund = $('#refund').val();
        var specialrefund = $('#specialrefund').val();
        var insurance = $('#insurance').val();
        var surcharge = $('#surcharge').val();
        var handcgk = $('#handcgk').val();
        var handpickup = $('#handpickup').val();
        var hddaerah = $('#hddaerah').val();
        var pph = $('#pph').val();
        var sdm = $('#sdm').val();
        var others = $('#others').val();
        Swal.fire({
            title: 'Loading',
            onBeforeOpen: () => {
                Swal.showLoading()
            },
            showConfirmButton: false,
            allowOutsideClick: false
        });
        $.ajax({
            url: '<?= base_url('superadmin/Ptp/addCostPtp') ?>',
            type: 'POST',
            data: {
                city: city,
                airlines: airlines,
                flight_smu: flight,
                ra: ra,
                packing: packing,
                refund: refund,
                specialrefund: specialrefund,
                insurance: insurance,
                surcharge: surcharge,
                hand_cgk: handcgk,
                hand_pickup: handpickup,
                hd_daerah: hddaerah,
                pph: pph,
                sdm: sdm,
                others: others
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Cost has been added',
                        showConfirmButton: true,
                    }).then(function(confirm) {
                        if (confirm) {
                            // Swal loading 
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
                        title: 'Failed',
                        text: 'Cost has been added'
                    });

                }
            }
        });
    });
</script>

<script>
    // .deleteCost
    $('.deleteCost').click(function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this cost?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
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
                $.ajax({
                    url: '<?= base_url('superadmin/ptp/deleteCostPtp') ?>',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Cost has been deleted',
                                showConfirmButton: true,
                            }).then(function(confirm) {
                                if (confirm) {
                                    // Swal loading 
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
                                title: 'Failed',
                                text: 'Cost has been deleted'
                            });

                        }
                    }
                });
            }
        });
    });
</script>

<script>
    // editCost 
    $('.editCost').click(function() {
        var id = $(this).data('id');
        var city = $(this).data('city');
        var airlines = $(this).data('airlines');
        var flight = $(this).data('flight');
        var ra = $(this).data('ra');
        var packing = $(this).data('packing');
        var refund = $(this).data('refund');
        var special = $(this).data('special');
        var insurance = $(this).data('insurance');
        var surcharge = $(this).data('surcharge');
        var handcgk = $(this).data('handcgk');
        var handpickup = $(this).data('handpickup');
        var hddaerah = $(this).data('hddaerah');
        var pph = $(this).data('pph');
        var sdm = $(this).data('sdm');
        var others = $(this).data('others');
        $('#idCostEdit').val(id);
        $('#cityEdit').val(city);
        $('#airlinesEdit').val(airlines);
        $('#flightEdit').val(flight);
        $('#raEdit').val(ra);
        $('#packingEdit').val(packing);
        $('#refundEdit').val(refund);
        $('#specialrefundEdit').val(special);
        $('#insuranceEdit').val(insurance);
        $('#surchargeEdit').val(surcharge);
        $('#handcgkEdit').val(handcgk);
        $('#handpickupEdit').val(handpickup);
        $('#hddaerahEdit').val(hddaerah);
        $('#pphEdit').val(pph);
        $('#sdmEdit').val(sdm);
        $('#othersEdit').val(others);
    });
</script>

<script>
    // formEditCost
    $('#formEditCost').submit(function(e) {
        e.preventDefault();
        var id = $('#idCostEdit').val();
        var city = $('#cityEdit').val();
        var airlines = $('#airlinesEdit').val();
        var flight = $('#flightEdit').val();
        var ra = $('#raEdit').val();
        var packing = $('#packingEdit').val();
        var refund = $('#refundEdit').val();
        var special = $('#specialrefundEdit').val();
        var insurance = $('#insuranceEdit').val();
        var surcharge = $('#surchargeEdit').val();
        var handcgk = $('#handcgkEdit').val();
        var handpickup = $('#handpickupEdit').val();
        var hddaerah = $('#hddaerahEdit').val();
        var pph = $('#pphEdit').val();
        var sdm = $('#sdmEdit').val();
        var others = $('#othersEdit').val();
        Swal.fire({
            title: 'Loading',
            onBeforeOpen: () => {
                Swal.showLoading()
            },
            showConfirmButton: false,
            allowOutsideClick: false
        });
        $.ajax({
            url: '<?= base_url('superadmin/ptp/editCostPtp') ?>',
            type: 'POST',
            data: {
                id_cost_ptp: id,
                city: city,
                airlines: airlines,
                flight_smu: flight,
                ra: ra,
                packing: packing,
                refund: refund,
                specialrefund: special,
                insurance: insurance,
                surcharge: surcharge,
                hand_cgk: handcgk,
                hand_pickup: handpickup,
                hd_daerah: hddaerah,
                pph: pph,
                sdm: sdm,
                others: others
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Cost has been edited',
                        showConfirmButton: true,
                    }).then(function(confirm) {
                        if (confirm) {
                            // Swal loading 
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
                        title: 'Failed',
                        text: 'Cost has been edited'
                    });

                }
            }
        });
    });
</script>