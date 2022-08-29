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
                            <h3 class="page-title"><?= $title; ?></h3>
                            <div class="d-inline-block align-items-center">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="table" class="table table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Pickup Date</th>
                                                    <th>No. SO</th>
                                                    <th>Shipment ID</th>
                                                    <th>Jobsheet ID</th>
                                                    <th>Customer</th>
                                                    <th>Destination</th>
                                                    <th>Request Revisi</th>
                                                    <th>Sales</th>
                                                    <th>Last Status</th>
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
                                                        <td><?= $j['jobsheet_id'] ?></td>
                                                        <td><?= $j['shipper'] ?></td>
                                                        <td><?= $j['tree_consignee'] ?></td>
                                                        <td><?= $j['tgl_so_new'] ?></td>
                                                        <td><?= $j['nama_user'] ?></td>
                                                        <td>
                                                            <?php
                                                            if ($j['status_revisi'] == 0) {
                                                            ?>
                                                                <!-- <a href="<?= base_url('cs/jobsheet/detailRevisi/' . $j['id']) ?>" class=" btn btn-sm text-light" style="background-color: #9c223b;">View Revision</a> <br> -->
                                                                <small>Jobsheet New</small> <br>
                                                            <?php } elseif ($j['status_revisi'] == 1) {
                                                            ?>
                                                                <!-- <a href="<?= base_url('cs/jobsheet/detailRevisi/' . $j['id']) ?>" class=" btn btn-sm text-light" style="background-color: #9c223b;">View Revision</a> <br> -->
                                                                <small>Jobsheet Approve By Pic Js</small> <br>
                                                            <?php } elseif ($j['status_revisi'] == 2) {
                                                            ?>
                                                                <!-- <a href="<?= base_url('cs/jobsheet/detailRevisi/' . $j['id']) ?>" class=" btn btn-sm text-light" style="background-color: #9c223b;">View Revision</a> <br> -->
                                                                <small>Jobsheet Approve By Manager CS</small> <br>
                                                            <?php } elseif ($j['status_revisi'] == 3) {
                                                            ?>
                                                                <!-- <a href="<?= base_url('cs/jobsheet/detailRevisi/' . $j['id']) ?>" class=" btn btn-sm text-light" style="background-color: #9c223b;">View Revision</a> <br> -->
                                                                <small>Jobsheet Approve By GM</small> <br>
                                                            <?php } elseif ($j['status_revisi'] == 4) {
                                                            ?>
                                                                <!-- <a href="<?= base_url('cs/jobsheet/detailRevisi/' . $j['id']) ?>" class=" btn btn-sm text-light" style="background-color: #9c223b;">View Revision</a> <br> -->
                                                                <small>Jobsheet Decline By Pic Js</small> <br>
                                                            <?php } elseif ($j['status_revisi'] == 5) {
                                                            ?>
                                                                <!-- <a href="<?= base_url('cs/jobsheet/detailRevisi/' . $j['id']) ?>" class=" btn btn-sm text-light" style="background-color: #9c223b;">View Revision</a> <br> -->
                                                                <small>Jobsheet Decline By Manager CS</small> <br>
                                                            <?php } elseif ($j['status_revisi'] == 6) {
                                                            ?>
                                                                <!-- <a href="<?= base_url('cs/jobsheet/detailRevisi/' . $j['id']) ?>" class=" btn btn-sm text-light" style="background-color: #9c223b;">View Revision</a> <br> -->
                                                                <small>Jobsheet Decline By GM</small> <br>
                                                            <?php }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url('cs/jobsheet/detailRevisi/' . $j['id']) ?>" class=" btn btn-sm text-light" style="background-color: #9c223b;">View Revision</a> <br>

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