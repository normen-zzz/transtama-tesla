<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <?php foreach ($airlines as $airlines1) { ?>
                <div class="card">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">List of Cost
                                <span class="d-block text-muted pt-2 font-size-sm"></span>
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddSell">
                                Add Sell
                            </button>
                        </div>


                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <h3><?php echo $airlines1['name_airlines']; ?></h3>
                            <!--begin: Datatable-->

                            <table class="table table-separate table-head-custom table-checkable tableSell" id="tableSell">
                                <thead>
                                    <tr>
                                        <th>Id Sell</th>
                                        <th>City</th>
                                        <th>Airlines</th>
                                        <th>Freight_kg</th>
                                        <th>Special_freight</th>
                                        <th>packing</th>
                                        <th>others</th>
                                        <th>surcharge</th>
                                        <th>insurance</th>
                                        <th>disc</th>
                                        <th>cn</th>
                                        <th>special_cn</th>
                                        <th>Action</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($sell->result_array() as $key1) { ?>
                                        <?php if ($key1['id_airlines'] == $airlines1['id_airlines']) { ?>


                                            <tr>
                                                <td><?php echo $key1['id_sell_ptp']; ?></td>
                                                <td><?php echo $key1['name_city']; ?></td>
                                                <td><?php echo $key1['name_airlines']; ?></td>
                                                <td><?php echo $key1['freight_kg']; ?></td>
                                                <td><?php echo $key1['special_freight']; ?></td>
                                                <td><?php echo $key1['packing']; ?></td>
                                                <td><?php echo $key1['others']; ?></td>
                                                <td><?php echo $key1['surcharge']; ?></td>
                                                <td><?php echo $key1['insurance']; ?></td>
                                                <td><?php echo $key1['disc']; ?></td>
                                                <td><?php echo $key1['cn']; ?></td>
                                                <td><?php echo $key1['special_cn']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary editSell" data-toggle="modal" data-target="#modalEditSell" data-id="<?php echo $key1['id_sell_ptp']; ?>" data-city="<?php echo $key1['id_city_ptp']; ?>" data-airlines="<?php echo $key1['id_airlines']; ?>" data-freight_kg="<?php echo $key1['freight_kg']; ?>" data-special_freight="<?php echo $key1['special_freight']; ?>" data-packing="<?php echo $key1['packing']; ?>" data-others="<?php echo $key1['others']; ?>" data-surcharge="<?php echo $key1['surcharge']; ?>" data-insurance="<?php echo $key1['insurance']; ?>" data-disc="<?php echo $key1['disc']; ?>" data-cn="<?php echo $key1['cn']; ?>" data-special_cn="<?php echo $key1['special_cn']; ?>">Edit</button>
                                                    <button type="button" class="btn btn-danger deleteSell" data-id="<?php echo $key1['id_sell_ptp']; ?>">Delete</button>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>


                            <!--end: Datatable-->
                        </div>


                    </div>
                </div>
                <br>
                <br>
            <?php } ?>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!-- modalAddSell -->
<div class="modal fade" id="modalAddSell" tabindex="-1" role="dialog" aria-labelledby="modalAddSell" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formAddSell">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddSell">Add Sell</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>City</label>
                        <select name="city" class="form-control" id="id_city">
                            <option value="">Select City</option>
                            <?php foreach ($city as $key) { ?>
                                <option value="<?php echo $key['id_city_ptp']; ?>"><?php echo $key['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Airlines</label>
                        <select name="airlines" class="form-control" id="id_airlines">
                            <option value="">Select Airlines</option>
                            <?php foreach ($airlines as $key) { ?>
                                <option value="<?php echo $key['id_airlines']; ?>"><?php echo $key['name_airlines']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Freight Kg</label>
                        <input type="text" name="freight_kg" id="freight_kg" class="form-control" placeholder="Freight Kg" value="0">
                    </div>
                    <div class="form-group">
                        <label>Special Freight</label>
                        <input type="text" name="special_freight" id="special_freight" class="form-control" placeholder="Special Freight" value="0">
                    </div>

                    <div class="form-group">
                        <label>Packing</label>
                        <input type="text" name="packing" id="packing" class="form-control" placeholder="Packing" value="0">
                    </div>
                    <div class="form-group">
                        <label>Others</label>
                        <input type="text" name="others" id="others" class="form-control" placeholder="Others" value="0">
                    </div>
                    <div class="form-group">
                        <label>Surcharge</label>
                        <input type="text" name="surcharge" id="surcharge" class="form-control" placeholder="Surcharge" value="0">
                    </div>
                    <div class="form-group">
                        <label>Insurance</label>
                        <input type="text" name="insurance" id="insurance" class="form-control" placeholder="Insurance" value="0">
                    </div>
                    <div class="form-group">
                        <label>Disc</label>
                        <input type="text" name="disc" id="disc" class="form-control" placeholder="Disc" value="0">

                    </div>
                    <div class="form-group">
                        <label>CN</label>
                        <input type="text" name="cn" id="cn" class="form-control" placeholder="CN" value="0">
                    </div>
                    <div class="form-group">
                        <label>Special CN</label>
                        <input type="text" name="special_cn" id="special_cn" class="form-control" placeholder="Special CN" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Sell</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modalEditSell -->
<div class="modal fade" id="modalEditSell" tabindex="-1" role="dialog" aria-labelledby="modalEditSell" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formEditSell">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditSell">Edit Sell</h5>
                    <input type="text" name="id_sell" id="id_sell" hidden>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>City</label>
                        <select name="city" class="form-control" id="id_cityEdit">
                            <option value="">Select City</option>
                            <?php foreach ($city as $key) { ?>
                                <option value="<?php echo $key['id_city_ptp']; ?>"><?php echo $key['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Airlines</label>
                        <select name="airlines" class="form-control" id="id_airlinesEdit">
                            <option value="">Select Airlines</option>
                            <?php foreach ($airlines as $key) { ?>
                                <option value="<?php echo $key['id_airlines']; ?>"><?php echo $key['name_airlines']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Freight Kg</label>
                        <input type="text" name="freight_kg" id="freight_kgEdit" class="form-control" placeholder="Freight Kg">
                    </div>
                    <div class="form-group">
                        <label>Special Freight</label>
                        <input type="text" name="special_freight" id="special_freightEdit" class="form-control" placeholder="Special Freight">
                    </div>

                    <div class="form-group">
                        <label>Packing</label>
                        <input type="text" name="packing" id="packingEdit" class="form-control" placeholder="Packing">
                    </div>
                    <div class="form-group">
                        <label>Others</label>
                        <input type="text" name="others" id="othersEdit" class="form-control" placeholder="Others">
                    </div>
                    <div class="form-group">
                        <label>Surcharge</label>
                        <input type="text" name="surcharge" id="surchargeEdit" class="form-control" placeholder="Surcharge">
                    </div>
                    <div class="form-group">
                        <label>Insurance</label>
                        <input type="text" name="insurance" id="insuranceEdit" class="form-control" placeholder="Insurance">
                    </div>
                    <div class="form-group">
                        <label>Disc</label>
                        <input type="text" name="disc" id="discEdit" class="form-control" placeholder="Disc">

                    </div>
                    <div class="form-group">
                        <label>CN</label>
                        <input type="text" name="cn" id="cnEdit" class="form-control" placeholder="CN">
                    </div>
                    <div class="form-group">
                        <label>Special CN</label>
                        <input type="text" name="special_cn" id="special_cnEdit" class="form-control" placeholder="Special CN">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Edit Sell</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    // tableSell
    $(document).ready(function() {
        $('.tableSell').DataTable();
    });
</script>

<script>
    // formAddSell
    $(document).ready(function() {
        $('#formAddSell').submit(function(e) {
            e.preventDefault();
            var id_sell = $('#id_sell').val();
            var id_city_ptp = $('#id_city').val();
            var id_airlines = $('#id_airlines').val();
            var freight_kg = $('#freight_kg').val();
            var special_freight = $('#special_freight').val();
            var packing = $('#packing').val();
            var others = $('#others').val();
            var surcharge = $('#surcharge').val();
            var insurance = $('#insurance').val();
            var disc = $('#disc').val();
            var cn = $('#cn').val();
            var special_cn = $('#special_cn').val();

            $.ajax({
                url: "<?php echo base_url('superadmin/ptp/addSellPtp'); ?>",
                type: "post",
                data: {
                    id_sell: id_sell,
                    id_city_ptp: id_city_ptp,
                    id_airlines: id_airlines,
                    freight_kg: freight_kg,
                    special_freight: special_freight,
                    packing: packing,
                    others: others,
                    surcharge: surcharge,
                    insurance: insurance,
                    disc: disc,
                    cn: cn,
                    special_cn: special_cn
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Berhasil Ditambahkan',
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
                            title: 'Data Gagal Ditambahkan',
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
    // editSell 
    $(document).on('click', '.editSell', function() {
        var id_sell = $(this).data('id');
        var id_city = $(this).data('city');
        var id_airlines = $(this).data('airlines');
        var freight_kg = $(this).data('freight_kg');
        var special_freight = $(this).data('special_freight');
        var packing = $(this).data('packing');
        var others = $(this).data('others');
        var surcharge = $(this).data('surcharge');
        var insurance = $(this).data('insurance');
        var disc = $(this).data('disc');
        var cn = $(this).data('cn');
        var special_cn = $(this).data('special_cn');
        $('#id_sell').val(id_sell);
        $('#id_cityEdit').val(id_city);
        $('#id_airlinesEdit').val(id_airlines);
        $('#freight_kgEdit').val(freight_kg);
        $('#special_freightEdit').val(special_freight);
        $('#packingEdit').val(packing);
        $('#othersEdit').val(others);
        $('#surchargeEdit').val(surcharge);
        $('#insuranceEdit').val(insurance);
        $('#discEdit').val(disc);
        $('#cnEdit').val(cn);
        $('#special_cnEdit').val(special_cn);
    });
</script>

<script>
    // formEditSell 
    $(document).ready(function() {
        $('#formEditSell').submit(function(e) {
            e.preventDefault();
            var id_sell = $('#id_sell').val();
            var id_city_ptp = $('#id_cityEdit').val();
            var id_airlines = $('#id_airlinesEdit').val();
            var freight_kg = $('#freight_kgEdit').val();
            var special_freight = $('#special_freightEdit').val();
            var packing = $('#packingEdit').val();
            var others = $('#othersEdit').val();
            var surcharge = $('#surchargeEdit').val();
            var insurance = $('#insuranceEdit').val();
            var disc = $('#discEdit').val();
            var cn = $('#cnEdit').val();
            var special_cn = $('#special_cnEdit').val();
            Swal.fire({
                title: 'Loading',
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
                showConfirmButton: false,
                allowOutsideClick: false
            });
            $.ajax({
                url: "<?php echo base_url('superadmin/ptp/editSellPtp'); ?>",
                type: "post",
                data: {
                    id_sell_ptp: id_sell,
                    id_city_ptp: id_city_ptp,
                    id_airlines: id_airlines,
                    freight_kg: freight_kg,
                    special_freight: special_freight,
                    packing: packing,
                    others: others,
                    surcharge: surcharge,
                    insurance: insurance,
                    disc: disc,
                    cn: cn,
                    special_cn: special_cn
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Berhasil Diubah',
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
                            title: 'Data Gagal Diubah',
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
    $('.deleteSell').click(function() {
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
                        url: '<?= base_url('superadmin/Ptp/deleteSellPtp') ?>',
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
</script>