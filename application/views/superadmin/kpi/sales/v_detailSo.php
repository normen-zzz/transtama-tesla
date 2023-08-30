<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<!-- Main content -->
<?php
function getGrade($nilai)
{
    if ($nilai >= 80) {
        return 'A';
    } elseif ($nilai >= 60) {
        return 'B';
    } elseif ($nilai >= 40) {
        return 'C';
    } elseif ($nilai >= 20) {
        return 'D';
    } else {
        return 'E';
    }
}

?>
<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">

                        <h2 class="card-title">KPI Sales Order <?= $user['nama_user'] ?>
                            <div class="row">
                                <form action="<?= base_url('superadmin/Kpi/sales') ?>" method="POST">
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
                                            <button type="submit" class="btn btn-success mt-4 ml-3">Tampilkan</button>
                                            <!-- <a href="<?= base_url('superadmin/SalesTracker') ?>" class="btn btn-primary mt-4 ml-1">Reset Filter</a> -->
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <!-- <button class="btn btn-icon waves-effect waves-light btn-success mb-4" data-toggle="modal" data-target="#addBukti"> <i class="fas fa-plus"></i> Lakukan Pembayaran Sample </button> -->

                            <!-- <div class="row">
									<a target="blank" href="<?= base_url('superadmin/order/exportexcel/null/null/0') ?>" class="btn btn-sm btn-danger mb-3 ml-2">Export Laporan Keseluruhan</a>
								</div> -->




                    </div>

                    <!-- /.card-header -->
                    <div class="card-body" style="overflow: auto;">

                        <table class="table table-bordered datatable">
                            <!-- <a href="<?= base_url('shipper/order/add') ?>" class="btn btn-success mr-2 mb-4">
									<i class="fas fa-plus-circle"> </i>Add
								</a> -->
                            <!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
                            <p><?= $this->session->flashdata('message'); ?></p>
                            <thead>
                                <tr>
                                    <th style="width: 15%;">Sales</th>
                                    <th style="width: 15%;">Pu Date</th>
                                    <th>Submit SO AT</th>
                                    <th style="width: 10%;">Shipper</th>
                                    <th>Destination</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nilai = 0;
                                foreach ($so->result_array() as $so1) {
                                    $query = $this->db->query("SELECT created_at,time FROM tbl_tracking_real WHERE id_so =" . $so1['id_so'] . " AND flag = 4 ORDER BY id_so DESC LIMIT 1 ");
                                    $trackingResi = $query->row_array();
                                    if ($so1['submitso_at'] != NULL && $trackingResi != NULL) {

                                        $date1 = date_create(date('Y-m-d', strtotime($so1['submitso_at'])));
                                        $date2 = date_create(date('Y-m-d', strtotime($trackingResi['created_at'])));
                                        $diff = date_diff($date2, $date1);
                                        // echo $so1['id_so'] . $diff->format(" %R%a days <br>");

                                        $datetime1 = strtotime($so1['submitso_at']);
                                        $datetime2 = strtotime($trackingResi['created_at'].$trackingResi['time']);
                                        $interval  = abs($datetime2 - $datetime1);
                                        $minutes   = round($interval / 60);


                                        if ($diff->format("%R%a") == 0) {
                                            if ($minutes <= 300) {
                                                $nilai = 90;
                                            } else {
                                                $nilai = 70;
                                            }
                                        } elseif ($diff->format("%R%a") == 1) {
                                            if (date('H:i:s', strtotime($trackingResi['time'])) >= '21:00:00') {
                                                $nilai = 70;
                                            } else {
                                                $nilai = 50;
                                            }
                                        } elseif ($diff->format("%R%a") > 1) {
                                            $nilai = 30;
                                        }
                                    


                                ?>
                                    <tr>
                                        <td><?= $user['nama_user'] ?></td>
                                        <td><?= date('d-m-Y H:i:s', strtotime($trackingResi['created_at'].$trackingResi['time']))  ?></td>
                                        <td><?= date('d-m-Y H:i:s', strtotime($so1['submitso_at']) )  ?></td>
                                        <td><?= $so1['shipper'] ?></td>
                                        <td><?= $so1['destination'] ?></td>
                                        <td><?= getGrade($nilai)  ?></td>
                                    </tr>
                                <?php
                                } }?>
                            </tbody>


                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

        </div>
        <!-- /.row -->

    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->
<script>
    $(document).ready(function() {
        var myTable = $('.datatable').DataTable({
            "ordering": false,
            "dom": '<"top"f>rt<"bottom"ilp><"clear">'
        });
    });
</script>