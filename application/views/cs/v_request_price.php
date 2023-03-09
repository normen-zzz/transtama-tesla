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
                                <div class="row ml-2">
                                    <div class="form-group mr-2">
                                        <label>Start</label><br>
                                        <input type="date" <?php if ($awal != NULL) { ?> value="<?= $awal ?>" <?php } ?> name="awal" id="awal" class="form-control">


                                    </div>
                                    <div class="form-group mr-3">
                                        <label>End</label> <br>
                                        <input type="date" <?php if ($akhir != NULL) { ?> value="<?= $akhir ?>" <?php } ?> name="akhir" id="akhir" class="form-control">
                                    </div>

                                    <div class="form-group"> <br>
                                        <button type="submit" class="btn btn-success ml-3">Tampilkan</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>



                </div>
                <div class="col-md-12">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">On Request</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Approved</a>
                        </div>
                    </nav>
                </div>
                <div class="card-body" style="overflow: auto;">

                    <div class="col-md-12">

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <table class="table table-separate table-head-custom table-checkable" id="myTable">

                                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('error_upload'); ?>"></div>
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Moda</th>
                                            <th>Weight</th>
                                            <th>Collie</th>
                                            <th>Commodity</th>
                                            <th>Dimension (P x L x T) CM</th>
                                            <th>Notes Sales</th>
                                            <th>Price Approved</th>
                                            <th>Notes Cs</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($requestPrice->result_array() as $requestPrice) { ?>
                                            <tr>
                                                <td><?= date('d F Y H:i:s', strtotime($requestPrice['date_request'])) ?></td>
                                                <td><?= $requestPrice['alamat_from'] . ' ' .  $requestPrice['city_from'] . ', ' . $requestPrice['province_from']  ?></td>
                                                <td><?= $requestPrice['alamat_to'] . ' ' .  $requestPrice['city_from'] . ', ' . $requestPrice['province_from']  ?></td>
                                                <td><?= $requestPrice['moda'] ?></td>
                                                <td><?= $requestPrice['berat'] ?></td>
                                                <td><?= $requestPrice['koli'] ?></td>
                                                <td><?= $requestPrice['komoditi'] ?></td>
                                                <td><?= $requestPrice['panjang'] . ' x ' . $requestPrice['lebar'] . ' x ' . $requestPrice['tinggi'] ?></td>
                                                <td><?= $requestPrice['notes_sales'] ?></td>
                                                <td><?= rupiah($requestPrice['price']) ?></td>
                                                <td><?= $requestPrice['notes_cs'] ?></td>
                                                <td><a data-toggle="modal" data-target="#modal-lg<?= $requestPrice['id_request_price'] ?>" class="btn btn-primary ml-2 mt-2">Add Price</a></td>
                                            <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <table class="table table-separate table-head-custom table-checkable" id="myTable2">

                                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('error_upload'); ?>"></div>
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Moda</th>
                                            <th>Weight</th>
                                            <th>Collie</th>
                                            <th>Commodity</th>
                                            <th>Dimension (P x L x T) CM</th>
                                            <th>Notes Sales</th>
                                            <th>Price Approved</th>
                                            <th>Notes Cs</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($requestPriceApprove->result_array() as $requestPrice) { ?>
                                            <tr>
                                                <td><?= date('d F Y H:i:s', strtotime($requestPrice['date_request'])) ?></td>
                                                <td><?= $requestPrice['alamat_from'] . ' ' .  $requestPrice['city_from'] . ', ' . $requestPrice['province_from']  ?></td>
                                                <td><?= $requestPrice['alamat_to'] . ' ' .  $requestPrice['city_to'] . ', ' .  $requestPrice['province_to'] ?></td>
                                                <td><?= $requestPrice['moda'] ?></td>
                                                <td><?= $requestPrice['berat'] ?></td>
                                                <td><?= $requestPrice['koli'] ?></td>
                                                <td><?= $requestPrice['komoditi'] ?></td>
                                                <td><?= $requestPrice['panjang'] . ' x ' . $requestPrice['lebar'] . ' x ' . $requestPrice['tinggi'] ?></td>
                                                <td><?= $requestPrice['notes_sales'] ?></td>
                                                <td><?= rupiah($requestPrice['price']) ?></td>
                                                <td><?= $requestPrice['notes_cs'] ?></td>
                                                <td><a data-toggle="modal" data-target="#modal-lg<?= $requestPrice['id_request_price'] ?>" class="btn btn-primary ml-2 mt-2">Add Price</a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--begin: Datatable-->

                    <!--end: Datatable-->

                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>

<?php foreach ($requestPrice2->result_array() as $request) { ?>
    <div class="modal fade" id="modal-lg<?= $request['id_request_price'] ?>">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Price <?= $request['id_request_price'] ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('cs/RequestPrice/addPrice') ?>" method="POST">
                        <div class="card-body">
                            <input type="text" placeholder="Cth : Pt. ABC" class="form-control" value="<?= $request['id_request_price'] ?>" hidden name="id">

                            <div class="form-group">
                                <label for="exampleInputPassword1">Price (Rp.)</label>
                                <input type="text" class="form-control" name="price" id="price"></input>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Notes</label>
                                <textarea class="form-control" name="notes_cs" id="notes_cs"></textarea>
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
<?php } ?>
<!-- /.modal -->

<?php foreach ($requestPriceApprove2->result_array() as $request) { ?>
    <div class="modal fade" id="modal-lg<?= $request['id_request_price'] ?>">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Price <?= $request['id_request_price'] ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('cs/RequestPrice/addPrice') ?>" method="POST">
                        <div class="card-body">
                            <input type="text" placeholder="Cth : Pt. ABC" class="form-control" value="<?= $request['id_request_price'] ?>" hidden name="id">

                            <div class="form-group">
                                <label for="exampleInputPassword1">Price (Rp.)</label>
                                <input type="text" class="form-control" name="price" value="<?= $request['price'] ?>" id="price"></input>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Notes</label>
                                <textarea class="form-control" name="notes_cs" id="notes_cs"><?= $request['notes_cs'] ?></textarea>
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
<?php } ?>
<!-- /.modal -->