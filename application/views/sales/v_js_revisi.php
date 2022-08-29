<!--begin::Entry-->
<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Dashboard-->
        <!--begin::Row-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header py-3">
                <div class="card-title align-items-start flex-column">
                    <h3 class="card-label font-weight-bolder text-dark">Sales Order Revision </h3>
                    <span class="text-muted font-weight-bold font-size-sm mt-1">Your Request Revision</span>
                </div>


            </div>
            <div class="card-body">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="myTable" class="table table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Pickup Date</th>
                                                    <th>No. SO</th>
                                                    <th>Shipment ID</th>
                                                    <th>Customer</th>
                                                    <th>Destination</th>
                                                    <th>Request Revisi</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($js as $j) {
                                                ?>
                                                    <tr>
                                                        <td><?= bulan_indo($j['tgl_pickup']) ?></td>
                                                        <td><?= $j['so_id'] ?></td>
                                                        <td><?= $j['shipment_id'] ?></td>
                                                        <td><?= $j['shipper'] ?></td>
                                                        <td><?= $j['tree_consignee'] ?></td>
                                                        <td><?= $j['tgl_pengajuan'] ?></td>
                                                        <td><?php if ($j['status_pengajuan'] == 0) {
                                                                echo '<span class="label label-danger label-inline font-weight-lighter" style="width: 150px;">Request Revisi</span>';
                                                            } elseif ($j['status_pengajuan'] == 1) {
                                                                echo '<span class="label label-primary label-inline font-weight-lighter" style="width: 150px;">Approve Request</span>';
                                                            } elseif ($j['status_pengajuan'] == 2) {
                                                                echo '<span class="label label-success label-inline font-weight-lighter" style="width: 150px;">Approve Finance</span>';
                                                            } elseif ($j['status_pengajuan'] == 4) {
                                                                echo '<span class="label label-secondary label-inline font-weight-lighter" style="width: 150px;">Decline</span>';
                                                            } ?></td>
                                                        <td>
                                                            <?php if ($j['status_pengajuan'] == 1) {
                                                                $cek_so_baru = $this->db->get_where('tbl_revisi_so', ['shipment_id' => $j['id']])->row_array();
                                                                if ($cek_so_baru) {
                                                            ?>
                                                                    <!-- <a href="#" class="btn btn-sm mb-1 text-light" data-toggle="modal" data-target="#modal-view<?= $j['id'] ?>" style="background-color: #9c223b;">View New SO</a> -->
                                                                    <a href="<?= base_url('sales/salesOrder/detailRevisi/' . $j['id']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">View Status SO</a>
                                                                <?php    } else {
                                                                ?>
                                                                    <a href="#" class="btn btn-sm mb-1 text-light" data-toggle="modal" data-target="#modal-lg<?= $j['id'] ?>" style="background-color: #9c223b;">Add New SO</a>
                                                            <?php }
                                                            }
                                                            ?>
                                                        </td>


                                                    </tr>

                                                <?php } ?>

                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    </div>


    <?php foreach ($js as $shp) {
    ?>

        <div class="modal fade" id="modal-lg<?= $shp['id'] ?>">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Sales Order with <?= $shp['shipment_id'] ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('sales/salesOrder/addNewSo') ?>" method="POST">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Freight</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" required name="freight_baru">
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="id" hidden required value="<?= $shp['id'] ?>">
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="id_so" hidden required value="<?= $shp['id_so'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Special Freight</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" required name="special_freight_baru">
                                        <!-- <input type="text" class="form-control" id="exampleInputEmail1" hidden required value="<?= $msr['id_msr'] ?>" name="id_msr"> -->
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Packing</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" required name="packing_baru">
                                        <!-- <input type="text" class="form-control" id="exampleInputEmail1" hidden required value="<?= $msr['id_msr'] ?>" name="id_msr"> -->
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Others</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" required name="others_baru">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Surcharge</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" required name="surcharge_baru">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Insurance</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" required name="insurance_baru">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Disc</label>
                                        <input type="number" class="form-control" id="exampleInputEmail1" required name="disc_baru" placeholder="ex: 2, it measn 2 %">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Cn</label>
                                        <input type="number" class="form-control" id="exampleInputEmail1" required name="cn_baru" placeholder="ex: 2, it measn 2 %">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Reason</label>
                                        <textarea name="alasan" class="form-control" required></textarea>
                                    </div>

                                </div>
                            </div>

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

    <?php } ?>



    <?php foreach ($js as $shp) {
        $cek_so_baru = $this->db->get_where('tbl_revisi_so', ['shipment_id' => $shp['id']])->row_array();
        if ($cek_so_baru) {
    ?>
            <div class="modal fade" id="modal-view<?= $shp['id'] ?>">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">View New Sales Order with <?= $shp['shipment_id'] ?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('sales/salesOrder/addNewSo') ?>" method="POST">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Freight</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" required name="freight_baru" value="<?= $cek_so_baru['freight_baru'] ?>">
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="id" hidden required value="<?= $shp['id'] ?>">
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="id_so" hidden required value="<?= $shp['id_so'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Special Freight</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" required name="special_freight_baru" value="<?= $cek_so_baru['special_freight_baru'] ?>">
                                            <!-- <input type="text" class="form-control" id="exampleInputEmail1" hidden required value="<?= $msr['id_msr'] ?>" name="id_msr"> -->
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Packing</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" required name="packing_baru" value="<?= $cek_so_baru['packing_baru'] ?>">
                                            <!-- <input type="text" class="form-control" id="exampleInputEmail1" hidden required value="<?= $msr['id_msr'] ?>" name="id_msr"> -->
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Others</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" required name="others_baru" value="<?= $cek_so_baru['others_baru'] ?>">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Surcharge</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" required name="surcharge_baru" value="<?= $cek_so_baru['surcharge_baru'] ?>">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Insurance</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" required name="insurance_baru" value="<?= $cek_so_baru['insurance_baru'] ?>">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Disc</label>
                                            <input type="number" class="form-control" id="exampleInputEmail1" required name="disc_baru" value="<?= $cek_so_baru['disc_baru'] ?>">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Cn</label>
                                            <input type="number" class="form-control" id="exampleInputEmail1" required name="cn_baru" value="<?= $cek_so_baru['cn_baru'] ?>">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Reason</label>
                                            <textarea name="alasan" class="form-control" required><?= $cek_so_baru['alasan'] ?></textarea>
                                        </div>

                                    </div>
                                </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                        </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

        <?php    } else {
            echo '';
        }

        ?>
        <!-- /.modal -->

    <?php } ?>