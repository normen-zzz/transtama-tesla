<style>
    .datepicker-inline {
        width: auto;
        /*what ever width you want*/
    }
</style>

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

                        <h3 class="card-label"><?= $title ?>
                            <span class="d-block text-muted pt-2 font-size-sm"></span>
                        </h3>


                    </div>




                    <div class="card-toolbar float-right">




                        <!--end::Button-->
                    </div>
                </div>

                <div class="card-body" style="overflow: auto;">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom" id="myTable">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>ID Request</th>
                                <th>Created At</th>
                                <th>Customer</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Moda</th>
                                <th>Jenis</th>
                                <th>Berat (KG)</th>
                                <th>Koli</th>
                                <th>Dimension</th>
                                <th>Price Submitted</th>
                                <th>Notes Sales</th>
                                <th>Notes CS</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($detailRequestPrice->result_array() as $detailRequestPrice1) { ?>
                                <tr>
                                    <td><?= $no  ?></td>
                                    <td>REQP - <?= $detailRequestPrice1['id_detailrequest'] ?></td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($detailRequestPrice1['created_at']))  ?></td>
                                    <td><?= getNameCustomer($detailRequestPrice1['customer']) ?></td>
                                    <td><?= $detailRequestPrice1['alamat_from'] . ', ' . $detailRequestPrice1['kecamatan_from'] . ', ' . $detailRequestPrice1['kota_from'] . ', ' . $detailRequestPrice1['provinsi_from'] ?></td>
                                    <td><?= $detailRequestPrice1['alamat_to'] . ', ' . $detailRequestPrice1['kecamatan_to'] . ', ' . $detailRequestPrice1['kota_to'] . ', ' . $detailRequestPrice1['provinsi_to'] ?></td>
                                    <td><?= moda($detailRequestPrice1['moda'])  ?></td>
                                    <td><?= $detailRequestPrice1['jenis'] ?></td>
                                    <td><?= $detailRequestPrice1['berat'] ?></td>
                                    <td><?= $detailRequestPrice1['koli'] ?></td>
                                    <td><?= (int)$detailRequestPrice1['panjang'] . ' X ' . (int)$detailRequestPrice1['lebar'] . ' X ' . (int)$detailRequestPrice1['tinggi'] ?><br> Air :<?= ((int)$detailRequestPrice1['panjang'] * (int)$detailRequestPrice1['lebar'] * (int)$detailRequestPrice1['tinggi']) / 6000 ?> KG<br>Land :<?= ((int)$detailRequestPrice1['panjang'] * (int)$detailRequestPrice1['lebar'] * (int)$detailRequestPrice1['tinggi']) / 4000 ?> KG</td>
                                    <td><?= rupiah($detailRequestPrice1['price']) ?> </td>
                                    <td><?= $detailRequestPrice1['notes_sales'] ?></td>
                                    <td><?= $detailRequestPrice1['notes_cs'] ?></td>
                                    <td><?= statusRequestPrice($detailRequestPrice1['status']).'<br>'.$detailRequestPrice1['notes_decline_cs'].$detailRequestPrice1['notes_decline_sales']  ?></td>
                                    <td><a href="<?= base_url('cs/RequestPrice/detailRequestPrice/' . $detailRequestPrice1['id_detailrequest']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
                                        <?php if ($detailRequestPrice1['status'] == 0) { ?>
                                            <button type="button" href="#" class="btn btn-sm text-light mb-1 modalAddPrice" data-toggle="modal" data-target="#modalAddPrice" data-id_detailrequest="<?= $detailRequestPrice1['id_detailrequest'] ?>" style="background-color: #9c223b;">Add Price</button>
                                            <button type="button" href="#" class="btn btn-sm text-light mb-1 modalDeclineCs" data-toggle="modal" data-target="#modalDeclineCs" data-id_detailrequest="<?= $detailRequestPrice1['id_detailrequest'] ?>" style="background-color: #9c223b;">Decline</button>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php $no++;
                            } ?>

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
<div class="modal fade" id="modalAddPrice">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Price</b> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('cs/RequestPrice/addPriceProcess') ?>" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row" id="content-price">

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

<div class="modal fade" id="modalDeclineCs">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Decline Request Price </b> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('cs/RequestPrice/declineCs') ?>" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row" id="content-declinecs">

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

<script>
    $(document).ready(function() {
        $('.modalAddPrice').click(function() {
            console.log('kepencet harga')
            var id_detailrequest = $(this).data('id_detailrequest'); // Mendapatkan ID dari atribut data-id tombol yang diklik
            // $('#content-tracking').html('');
            // Memuat data menggunakan AJAX dengan mengirimkan ID sebagai parameter
            var content = '<div class="col">' +

                '<span>ID REQUEST : <b>REQP - ' + id_detailrequest + '</b></span>' +

                '<input type="text" name="id_detailrequest" value="' + id_detailrequest + '" hidden>' +

                '<div class="form-group mt-2">' +
                '<label for="price">Price</label>' +
                '<input type="number" name="price" class="form-control" id="price"  placeholder="Enter Price">' +
                '</div>' +
                '<div class="form-group mt-2">' +
                '<label for="notes_cs">Notes</label>' +
                ' <textarea name="notes_cs" id="notes_cs" class="form-control"></textarea>' +
                '</div>' +
                '</div>';
            $('#content-price').html(content);




        });
    })
</script>


<script>
    $(document).ready(function() {
        $('.modalDeclineCs').click(function() {
            
            var id_detailrequest = $(this).data('id_detailrequest'); // Mendapatkan ID dari atribut data-id tombol yang diklik
            // $('#content-tracking').html('');
            // Memuat data menggunakan AJAX dengan mengirimkan ID sebagai parameter
            var content = '<div class="col">' +

                '<span>ID REQUEST : <b>REQP - ' + id_detailrequest + '</b></span>' +

                '<input type="text" name="id_detailrequest" value="' + id_detailrequest + '" hidden>' +

                
                '<div class="form-group mt-2">' +
                '<label for="notes_decline_cs">Notes Decline</label>' +
                ' <textarea name="notes_decline_cs" id="notes_decline_cs" class="form-control"></textarea>' +
                '</div>' +
                '</div>';
            $('#content-declinecs').html(content);




        });
    })
</script>