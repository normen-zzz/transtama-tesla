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
                        <div class="row">
                            <form action="<?= base_url('sales/RequestPrice') ?>" method="POST">
                                <!-- <div class="row ml-2">
                                    <div class="form-group mr-2">
                                        <label>Start</label><br>
                                        <input type="datetime-local" <?php if ($awal != NULL) { ?> value="<?= $awal ?>" <?php } ?> name="awal" id="awal" class="form-control">


                                    </div>
                                    <div class="form-group mr-3">
                                        <label>End</label> <br>
                                        <input type="datetime-local" <?php if ($akhir != NULL) { ?> value="<?= $akhir ?>" <?php } ?> name="akhir" id="akhir" class="form-control">
                                    </div>



                                    <div class="form-group"> <br>
                                        <button type="submit" class="btn btn-success ml-3">Tampilkan</button>
                                    </div>
                                </div> -->

                            </form>
                        </div>

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
                                    <td><?= statusRequestPrice($detailRequestPrice1['status'])  ?></td>
                                    <td><a href="<?= base_url('sales/RequestPrice/detailRequestPrice/'.$detailRequestPrice1['id_detailrequest']) ?>"  class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
                                    <?php if ($detailRequestPrice1['status'] == 0) { ?>
                                        <a href="<?= base_url('Sales/RequestPrice/deleteRequestPrice/'.$detailRequestPrice1['id_detailrequest']) ?>" onclick="return confirm('Are You Sure ?')" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Delete</a>
                                    <?php } elseif ($detailRequestPrice1['status'] == 1) {?>
                                        <a href="<?= base_url('sales/RequestPrice/confirmSales/'.$detailRequestPrice1['id_detailrequest']) ?>" onclick="return confirm('Are You Sure ?')" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Confirm</a>
                                        <a href="<?= base_url('sales/RequestPrice/declineSales/'.$detailRequestPrice1['id_detailrequest']) ?>" onclick="return confirm('Are You Sure ?')" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Decline</a>
                                    <?php } elseif ($detailRequestPrice1['status'] == 2) { ?>
                                        <a href="<?= base_url('sales/RequestPrice/addNewSo/'.$detailRequestPrice1['id_detailrequest']) ?>" onclick="return confirm('Are You Sure ?')" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Create So</a>
                                   <?php  } ?>
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
</div>