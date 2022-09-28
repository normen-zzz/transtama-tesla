<!--begin::Entry-->
<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Dashboard-->
        <!--begin::Row-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header py-3">
                <div class="card-title align-items-start flex-column">
                    <h3 class="card-label font-weight-bolder text-dark"> DETAIL REQUEST REVISION </h3>
                    <!-- <span class="text-muted font-weight-bold font-size-sm mt-1">Shipment ID :<b> <?= $p['shipment_id'] ?></b></span>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Order ID :<b> <?= $p['order_id'] ?></b></span> -->
                </div>
                <div class="card-toolbar">
                    <a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder/revisiSo') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
                        <i class="fas fa-chevron-circle-left text-light"> </i>
                        Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-12">

                            <div class="box">
                                <div class="box-header with-border text-center">
                                    <h4 class="box-title with-border font-weight-bold">
                                        <?= $title; ?>
                                    </h4>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Pickup Date</th>
                                                    <th>Shipment ID</th>
                                                    <th>SO Number</th>
                                                    <th>Customer</th>
                                                    <th>Consignee</th>
                                                    <th>Service</th>
                                                    <th>Comm</th>
                                                    <th>Colly</th>
                                                    <th>Destination</th>
                                                    <th>Sales</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?= bulan_indo($msr['tgl_pickup']) ?></td>
                                                    <td><?= $msr['shipment_id'] ?></td>
                                                    <td><?= $msr['so_id'] ?></td>
                                                    <td><?= $msr['shipper'] ?></td>
                                                    <td><?= $msr['consigne'] ?></td>
                                                    <td><?= $msr['service_name'] ?></td>
                                                    <td><?= $msr['pu_commodity'] ?></td>
                                                    <td><?= $msr['koli'] ?></td>
                                                    <td><?= $msr['destination'] ?></td>
                                                    <td><?= $msr['nama_user'] ?></td>
                                                    <!-- <td><?= $msr['pu_note'] ?></td> -->
                                                </tr>

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
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-body">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title with-border text-danger text-center">
                                        <i class="fas fa-dollar-sign text-danger"></i> New Sales Order
                                    </h4>

                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th><b>Description</b> </th>
                                                    <th>Freight/KG</th>
                                                    <th>Special Freight</th>
                                                    <th>Packing</th>
                                                    <th>Others</th>
                                                    <th>Surcharge</th>
                                                    <th>Insurance</th>
                                                    <th>Disc.</th>
                                                    <th>Cn</th>
                                                    <!-- <th>Action</th> -->

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!--berart js = weight js/msr-->
                                                <!--berat_msr= special_freight-->
                                                <?php
                                                $service =  $msr['service_name'];
                                                if ($service == 'Charter Service') {
                                                    $packing = $request['packing_baru'];
                                                    $total_sales_new = ($request['freight_baru'] + $packing +  $request['special_freight_baru'] +  $request['others_baru'] + $request['surcharge_baru'] + $request['insurance_baru']);
                                                } else {
                                                    $disc = $request['disc_baru'];
                                                    // kalo gada disc
                                                    if ($disc == 0) {
                                                        $freight  = $msr['berat_js'] * $request['freight_baru'];
                                                        $special_freight  = $msr['berat_msr'] * $request['special_freight_baru'];
                                                    } else {
                                                        $freight_discount = $request['freight_baru'] * $disc;
                                                        $special_freight_discount = $request['special_freight_baru'] * $disc;

                                                        $freight = $freight_discount * $msr['berat_js'];
                                                        $special_freight  = $special_freight_discount * $msr['berat_msr'];
                                                    }

                                                    $packing = $request['packing_baru'];
                                                    $total_sales_new = ($freight + $packing + $special_freight +  $request['others_baru'] + $request['surcharge_baru'] + $request['insurance_baru']);
                                                    $total_sales_new = $total_sales_new;
                                                }
                                                ?>
                                                <tr>
                                                    <td>
                                                        <i><b> Value</b></i>
                                                    </td>
                                                    <td>
                                                        <?= rupiah($request['freight_baru']) ?>
                                                    </td>
                                                    <td>
                                                        <?= rupiah($request['special_freight_baru']) ?>
                                                    </td>
                                                    <td>
                                                        <?= rupiah($request['packing_baru']) ?>
                                                    </td>
                                                    <td>
                                                        <?= rupiah($request['others_baru']) ?>
                                                    </td>
                                                    <td>
                                                        <?= rupiah($request['surcharge_baru']) ?>
                                                    </td>
                                                    <td>
                                                        <?= rupiah($request['insurance_baru']) ?>
                                                    </td>
                                                    <td>
                                                        <?= $request['disc_baru'] ?> / <?= $request['disc_baru'] * 100 ?> %
                                                    </td>
                                                    <td>
                                                        <?= $request['cn_baru'] ?> / <?= $request['cn_baru'] * 100 ?> %
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i><b>Reason</b></i>
                                                    </td>
                                                    <td colspan="12">
                                                        <?= $request['alasan'] ?>
                                                    </td>
                                                </tr>

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




        <div class="row">
            <?php
            $tgl_approve_revisi = $this->db->get_where('tbl_approve_revisi_so', ['shipment_id' => $request['shipment_id']])->row_array();
            ?>
            <div class="col-md-3">
                <?php if ($tgl_approve_revisi['id_user_cs'] == NULL) {
                ?>
                    <div class="card card-custom gutter-b example example-compact" style="height:100px;">
                        <h3 class="text-title text-center mt-2"><i class="fa fa-calendar text-warning"></i> Wait PIC CS To Check Request</h3> <br>
                        <!-- <h4 class="text-title text-center"><?= $tgl_approve_revisi['tgl_approve_gm'] ?></h4> -->
                    </div>
                <?php  } else {
                ?>
                    <div class="card card-custom gutter-b example example-compact" style="height:100px;">

                        <h3 class="text-title text-center mt-2"><i class="fa fa-check text-success"></i> Request Approve By pic Cs</h3> <br>

                        <h4 class="text-title text-center"><?= $tgl_approve_revisi['tgl_approve_cs'] ?></h4>
                    </div>
                <?php  } ?>
            </div>
            <div class="col-md-3">
                <?php if ($tgl_approve_revisi['id_user_mgr'] == NULL) {
                ?>
                    <div class="card card-custom gutter-b example example-compact" style="height:100px;">
                        <h3 class="text-title text-center mt-2"><i class="fa fa-calendar text-warning"></i> Wait Manager CS To Check Request</h3> <br>
                        <!-- <h4 class="text-title text-center"><?= $tgl_approve_revisi['tgl_approve_gm'] ?></h4> -->
                    </div>
                <?php  } else {
                ?>
                    <div class="card card-custom gutter-b example example-compact" style="height:100px;">
                        <?php if ($tgl_approve_revisi['status_approve_cs'] == 0) {
                        ?>
                            <h3 class="text-title text-center mt-2"><i class="fa fa-window-close text-danger"></i> Request Decline By Manager Cs</h3> <br>
                        <?php  } else {
                        ?>
                            <h3 class="text-title text-center mt-2"><i class="fa fa-check text-success"></i> Request Approve By Manager Cs</h3> <br>
                        <?php  } ?>
                        <h4 class="text-title text-center"><?= $tgl_approve_revisi['tgl_approve_mgr_cs'] ?> / <?= $tgl_approve_revisi['note_mgr_cs'] ?></h4>
                    </div>
                <?php  } ?>
            </div>

            <div class="col-md-6">
                <?php if ($tgl_approve_revisi['id_user_gm'] == NULL) {
                ?>
                    <div class="card card-custom gutter-b example example-compact" style="height:100px;">
                        <h3 class="text-title text-center mt-2"><i class="fa fa-calendar text-warning"></i> Wait GM Check Request</h3> <br>
                    </div>
                <?php  } else {
                ?>
                    <div class="card card-custom gutter-b example example-compact" style="height:100px;">
                        <?php if ($tgl_approve_revisi['status_approve_gm'] == 0) {
                        ?>
                            <h3 class="text-title text-center mt-2"><i class="fa fa-window-close text-danger"></i> Request Decline By GM</h3> <br>
                        <?php  } else {
                        ?>
                            <h3 class="text-title text-center mt-2"><i class="fa fa-check text-success"></i> Request Approve By GM</h3> <br>
                        <?php  } ?>
                        <h4 class="text-title text-center"><?= $tgl_approve_revisi['tgl_approve_sm'] ?></h4>
                    </div>


                <?php
                }
                ?>
            </div>



            <div class="col-md-6">
                <?php if ($tgl_approve_revisi['id_sm'] == NULL) {
                ?>
                    <div class="card card-custom gutter-b example example-compact" style="height:100px;">
                        <h3 class="text-title text-center mt-2"><i class="fa fa-calendar text-warning"></i> Wait Senior Manager To Check Request</h3> <br>
                        <!-- <h4 class="text-title text-center"><?= $tgl_approve_revisi['tgl_approve_gm'] ?></h4> -->
                    </div>
                <?php  } else {
                ?>
                    <div class="card card-custom gutter-b example example-compact" style="height:100px;">
                        <?php if ($tgl_approve_revisi['status_approve_sm'] == 0) {
                        ?>
                            <h3 class="text-title text-center mt-2"><i class="fa fa-window-close text-danger"></i> Request Decline By SM</h3> <br>
                        <?php  } else {
                        ?>
                            <h3 class="text-title text-center mt-2"><i class="fa fa-check text-success"></i> Request Approve By SM</h3> <br>
                        <?php  } ?>
                        <h4 class="text-title text-center"><?= $tgl_approve_revisi['tgl_approve_sm'] ?></h4>
                    </div>

                <?php  } ?>
            </div>


        </div>

    </div>
    </div>