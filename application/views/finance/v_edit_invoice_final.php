<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Dashboard-->
        <!--begin::Row-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-body">
                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="mr-auto">
                            <center>
                                <h3 class="page-title text-center">INVOICE <?= $due_date['customer']
                                                                            ?> </h3>
                            </center>
                            <div class="d-inline-block align-items-center">
                                <a href="<?= base_url('finance//invoice/final') ?>" class="btn text-light" style="background-color: #9c223b;">
                                    <i class="fa fa-arrow-left"></i>
                                    Back</a>

                                <a href="#" class="btn btn-sm text-light mb-1" data-toggle="modal" data-target="#modal-lg-dl-add" style="background-color: #9c223b;">
                                    <span class="fa fa-plus">
                                    </span> Add Shipment</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main content -->
                <section class="content">
                    <form action="<?= base_url('finance/invoice/proceseditInvoiceFinal') ?>" method="POST">
                        <div class="row">
                            <div class="col-12">
                                <div class="box">
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>AWB</th>
                                                        <th>DATE</th>
                                                        <th>DEST</th>
                                                        <th style="width: 25%;">NO.DO</th>
                                                        <!-- <th style="width: 25%;">MODA</th> -->
                                                        <th>SERVICE</th>
                                                        <th>COLLIE</th>
                                                        <th>WEIGHT</th>
                                                        <th>RATE</th>
                                                        <th>SPECIAL WEIGHT</th>
                                                        <th>SPECIAL RATE</th>
                                                        <th>OTHERS</th>
                                                        <th>TOTAL AMOUNT</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $total_koli = 0;
                                                    $total_weight = 0;
                                                    $total_special_weight = 0;
                                                    $total_amount = 0;
                                                    $amount = 0;
                                                    // $pph = 0;

                                                    foreach ($invoice as $inv) {
                                                        $no = 1;


                                                        $service =  $inv['service_name'];
                                                        if ($service == 'Charter Service') {
                                                            $packing = $inv['packing'];
                                                            $total_sales = ($inv['freight_kg'] + $packing +  $inv['special_freight'] +  $inv['others'] + $inv['surcharge'] + $inv['insurance']);
                                                        } else {
                                                            $disc = $inv['disc'];
                                                            // kalo gada disc
                                                            if ($disc == 0) {
                                                                $freight  = $inv['berat_js'] * $inv['freight_kg'];
                                                                $special_freight  = $inv['berat_msr'] * $inv['special_freight'];
                                                            } else {
                                                                $freight_discount = $inv['freight_kg'] * $disc;
                                                                $special_freight_discount = $inv['special_freight'] * $disc;
                                                                $freight = $freight_discount * $inv['berat_js'];
                                                                $special_freight  = $special_freight_discount * $inv['berat_msr'];
                                                            }
                                                            $packing = $inv['packing'];
                                                            $total_sales = ($freight + $packing + $special_freight +  $inv['others'] + $inv['surcharge'] + $inv['insurance']);
                                                        }



                                                    ?>
                                                        <tr>

                                                            <input hidden type="text" name="shipment_id[]" value="<?= $inv['id'] ?>">
                                                            <td><?= $inv['shipment_id'] ?></td>
                                                            <td><?= bulan_indo($inv['tgl_pickup']) ?></td>
                                                            <td><?= $inv['tree_consignee'] ?></td>
                                                            <td>
                                                                <input type="text" name="note_cs[]" class="form-control" value="<?= $inv['note_cs'] ?>">
                                                            </td>
                                                            <td><?= $inv['prefix'] ?></td>
                                                            <td><?= $inv['koli'] ?></td>
                                                            <td><?= $inv['berat_js']; ?></td>
                                                            <td><?php
                                                                echo  rupiah($inv['freight_kg']);
                                                                ?></td>
                                                            <td><?= $inv['berat_msr']; ?></td>
                                                            <td><?php
                                                                echo rupiah($inv['special_freight']);
                                                                ?></td>
                                                            <td><?= rupiah($inv['others']); ?></td>

                                                            <td><?php
                                                                echo rupiah($total_sales);
                                                                ?></td>
                                                            <td> <a href="<?= base_url('finance/invoice/deleteInvoiceFinal/' . $inv['id_invoice'] . '/' . $inv['no_invoice'] . '/' . $inv['shipment_id']) ?>" class=" btn btn-sm text-light tombol-hapus" data-flashdata="<?= $inv['shipment_id'] ?>" style="background-color: #9c223b;">Delete</a></td>

                                                        </tr>

                                                    <?php
                                                        $total_koli = $total_koli + $inv['koli'];
                                                        $total_weight = $total_weight + $inv['berat_js'];
                                                        $total_special_weight = $total_special_weight + $inv['berat_msr'];
                                                        $amount = $amount + $total_sales;
                                                        $no++;
                                                    } ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center">TOTAL <?= $total_invoice ?> AWB</td>
                                                        <td><?= $total_koli ?></td>
                                                        <td><?= $total_weight ?></td>
                                                        <td></td>
                                                        <td><?= $total_special_weight ?></td>
                                                        <td></td>
                                                        <td class="font-weight-bold">SUB TOTAL</td>
                                                        <td><?= rupiah($amount) ?></td>
                                                    </tr>
                                                    <!-- kalo dia ada ppn -->
                                                    <?php if ($inv['is_ppn'] == 1) {
                                                    ?>
                                                        <tr style="border:none">
                                                            <td colspan="10">
                                                            </td>
                                                            <td class="font-weight-bold">
                                                                PPN 1,1 %
                                                            </td>
                                                            <td>
                                                                <?php

                                                                $ppn =  $amount * 0.011;
                                                                $pph =  $amount * 0.02;
                                                                echo rupiah($ppn);
                                                                ?>

                                                            </td>
                                                        </tr>
                                                    <?php  }  ?>
                                                    <?php
                                                    if ($inv['is_ppn'] == 0 || $inv['is_ppn'] == NULL) {
                                                        $ppn = 0;
                                                    } else {
                                                        $ppn = $ppn;
                                                    }
                                                    if ($inv['is_pph'] == 0 || $inv['is_pph'] == NULL) {
                                                        $pph = 0;
                                                    } else {
                                                        $pph = $pph;
                                                    }

                                                    ?>
                                                    <tr>
                                                        <td colspan="10">

                                                        </td>
                                                        <td class="font-weight-bold">
                                                            TOTAL
                                                        </td>
                                                        <td>
                                                            <?php $total_amount = $amount + $ppn;
                                                            echo  rupiah($total_amount);
                                                            ?>

                                                        </td>
                                                    </tr>

                                                </tbody>


                                            </table>

                                            <br><br>
                                            <h3 class="title text-center"><i class="fa fa-building"></i> INVOICE INFORMATION</h3>
                                            <br>


                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <?php
                                $f = new NumberFormatter('en', NumberFormatter::SPELLOUT);
                                $terbilang = $f->format($total_amount) . ' Rupiahs';
                                $terbilang = ucwords($terbilang);
                                ?>
                                <label for="pic" class="font-weight-bold">Customer</label>
                                <input type="text" class="form-control" name="terbilang" hidden value="<?= $terbilang ?>">
                                <input type="text" class="form-control" name="invoice" hidden value="<?= $amount ?>">
                                <input type="text" class="form-control" name="ppn" hidden value="<?= $ppn ?>">
                                <input type="text" class="form-control" name="pph" hidden value="<?= $pph ?>">
                                <input type="text" class="form-control" name="total_invoice" hidden value="<?= $total_amount ?>">
                                <input type="text" name="shipper" value="<?= $inv['customer'] ?>" class="form-control">
                            </div>
                            <div class="col-md-5">
                                <label for="pic" class="font-weight-bold">Address</label>
                                <textarea name="address" class="form-control"><?= $inv['address'] ?></textarea>
                            </div>
                            <div class="col-md-3">
                                <label for="pic" class="font-weight-bold">No. Telp</label>
                                <input type="no_telp" name="no_telp" class="form-control" value="<?= $inv['no_telp'] ?>">
                            </div>
                            <div class="col-md-2">
                                <label for="pic" class="font-weight-bold">PIC Invoice</label>
                                <input type="pic" name="pic" value="<?= $inv['pic'] ?>" class="form-control">
                                <input type="no_invoice" name="no_invoice" hidden value="<?= $inv['no_invoice'] ?>" class="form-control">
                                <input type="text" name="id_invoice" hidden value="<?= $inv['id_invoice'] ?>" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="due_date" class="font-weight-bold">Due Date</label>
                                <input type="date" class="form-control" name="due_date" value="<?= $inv['due_date'] ?>" required>

                            </div>

                        </div>
                        <br><br>
                        <h3 class="title text-center"><i class="fa fa-cog"></i> Setting Print Options</h3> <br>
                        <div class="row">
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="font-weight-bold">Print DO</label>
                                    <div class="form-check">
                                        <input class="form-check-input" name="print_do" type="checkbox" <?php if ($inv['print_do'] == 1) {
                                                                                                            echo 'checked';
                                                                                                        } ?> value="1" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="font-weight-bold">PPN</label>
                                    <div class="form-check">
                                        <input class="form-check-input" name="is_ppn" type="checkbox" value="1" id="ppn" <?php if ($inv['is_ppn'] == 1) {
                                                                                                                                echo 'checked';
                                                                                                                            } ?>>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="font-weight-bold">PPH</label>
                                    <div class="form-check">
                                        <input class="form-check-input" name="is_pph" type="checkbox" value="1" id="pph" <?php if ($inv['is_pph'] == 1) {
                                                                                                                                echo 'checked';
                                                                                                                            } ?>>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="font-weight-bold">Reimbursment</label>
                                    <div class="form-check">
                                        <input class="form-check-input" name="is_reimbursment" type="checkbox" value="1" <?php if ($inv['is_reimbursment'] == 1) {
                                                                                                                                echo 'checked';
                                                                                                                            } ?>>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="font-weight-bold">Special Rate</label>
                                    <div class="form-check">
                                        <input class="form-check-input" name="is_special" type="checkbox" value="1" <?php if ($inv['is_special'] == 1) {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="font-weight-bold">Packing</label>
                                    <div class="form-check">
                                        <input class="form-check-input" name="is_packing" type="checkbox" value="1" <?php if ($inv['is_packing'] == 1) {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-14">
                                <button type="submit" class="btn btn-success mt-2 ml-4" onclick="return confirm('Are you sure ?')">Update Invoice</button>
                                <?php $id_jabatan = $this->session->userdata('id_jabatan');
                                // kalo dia manajer
                                if ($id_jabatan == 2) {
                                ?>
                                    <a href="<?= base_url('finance/invoice/approve/' . $inv['no_invoice'] . '/' . $inv['id_invoice'] . '/' . encrypt_url($total_amount)) ?>" class="btn btn-danger mt-2 ml-4 tombol-konfirmasi">Approve Invoice</a>

                                <?php
                                }

                                ?>

                            </div>
                            <br><br>

                            <!-- /.box -->
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modal-lg-dl-add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Shipment </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="<?= base_url('finance/invoice/addShipmentFinal') ?>" method="POST">
                    <input type="text" name="no_invoice" hidden value="<?= $inv['no_invoice'] ?>">
                    <input type="text" name="due_date" hidden value="<?= $inv['due_date'] ?>">
                    <input type="text" name="pic" hidden value="<?= $inv['pic'] ?>">
                    <input type="text" name="is_packing" hidden value="<?= $inv['is_packing'] ?>">
                    <input type="text" name="is_special" hidden value="<?= $inv['is_special'] ?>">
                    <input type="text" name="is_reimbursment" hidden value="<?= $inv['is_reimbursment'] ?>">
                    <input type="text" name="is_pph" hidden value="<?= $inv['is_pph'] ?>">
                    <input type="text" name="is_ppn" hidden value="<?= $inv['is_ppn'] ?>">
                    <input type="text" name="terbilang" hidden value="<?= $terbilang ?>">
                    <input type="text" name="print_do" hidden value="<?= $inv['print_do'] ?>">
                    <input type="text" name="pic" hidden value="<?= $inv['pic'] ?>">
                    <input type="text" name="no_telp" hidden value="<?= $inv['no_telp'] ?>">
                    <input type="text" name="address" hidden value="<?= $inv['address'] ?>">
                    <input type="text" name="customer" hidden value="<?= $inv['customer'] ?>">
                    <input type="text" name="customer_pickup" hidden value="<?= $inv['customer_pickup'] ?>">
                    <input type="text" name="id_invoice" hidden value="<?= $inv['id_invoice'] ?>" class="form-control">
                    <button type="submit" class="btn btn-success mb-2"> <i class="fa fa-plus"></i> Add Shipment</button>
                    <table id="table" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pickup Date</th>
                                <th>No. SO</th>
                                <th>Shipment ID</th>
                                <th>Jobsheet ID</th>
                                <th>Customer</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($js as $j) {
                                $exis_invoice = $this->db->get_where('tbl_invoice', ['shipment_id' => $j['id']])->row_array();
                            ?>
                                <tr>
                                    <td>
                                        <?php if ($exis_invoice) {
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" name="shipment_id[]" value="<?= $j['id'] ?>">

                                        <?php  } ?>
                                    </td>
                                    <td><?= bulan_indo($j['tgl_pickup']) ?></td>
                                    <td><?php
                                        echo $j['so_id'];
                                        ?></td>
                                    <td><?= $j['shipment_id'] ?></td>
                                    <td><?php
                                        echo $j['jobsheet_id'];
                                        ?></td>
                                    <td><?= $j['shipper'] ?></td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>
                </form>


            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>