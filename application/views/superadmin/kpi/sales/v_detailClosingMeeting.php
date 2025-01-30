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

                        <h2 class="card-title">KPI CLOSING MEETING <?= $user['nama_user'] ?>
                            <div class="row">
                                <form action="<?= base_url('superadmin/SalesTracker/index') ?>" method="POST">
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
                                            <a href="<?= base_url('superadmin/SalesTracker') ?>" class="btn btn-primary mt-4 ml-1">Reset Filter</a>
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
                                    <th style="width: 15%;">Subject</th>
                                    <th style="width: 15%;">Description</th>
                                    <th style="width: 10%;">Location</th>
                                    <!-- <th>Created At</th> -->
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Close At</th>
                                    <th>PIC</th>
                                    <th>summary</th>
                                    <!-- <th>image</th> -->
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Grade</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nilai = 0;
                                $totalNilai = 0;
                                foreach ($salestracker->result_array() as $s) {
                                    if ($s['closing_at'] != NULL) {
                                    $date1 = date_create(date('Y-m-d', strtotime($s['closing_at'])));
                                    $date2 = date_create(date('Y-m-d', strtotime($s['end_date'])));
                                    $diff = date_diff($date2, $date1);
                                    $datetime1 = strtotime($s['closing_at']);
                                    $datetime2 = strtotime($s['end_date']);
                                    $interval  = abs($datetime2 - $datetime1);
                                    $minutes   = round($interval / 60);
                                    //jika perbedaan hari tidak ada
                                    if ($s['end_date'] == NULL) {
                                        $nilai = 30;
                                    }
                                    else{

                                    if ($diff->format("%R%a") == 0) {
                                        //mencari perbedaan menit
                                        if ($minutes <= 10 && $minutes > 0) {
                                            $nilai = 90;
                                        } elseif ($minutes > 10) {
                                            // nilai B 
                                            $nilai = 70;
                                        } elseif ($minutes < 0) {
                                            $nilai = 50;
                                        }
                                    } elseif ($diff->format("%R%a") == 1) {
                                        // nilai C
                                        $nilai = 50;
                                    } else {
                                        $nilai = 30;
                                        // Nilai D
                                    }
                                    }
                                } else{
                                    $nilai = 30;
                                    // Nilai D
                                }
                                ?>
                                    <tr>
                                        <td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?= $s['subject'] ?></td>
                                        <td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?= $s['description'] ?></td>
                                        <td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?= $s['location'] ?></td>
                                        <td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?= date('D d/m/Y H:i:s', strtotime($s['start_date'])) ?></td>
                                        <td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?php if ($s['end_date'] != NULL) {
                                                                                                                        echo date('D d/m/Y H:i:s', strtotime($s['end_date']));
                                                                                                                    } ?></td>
                                        <td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?= date('D d/m/Y H:i:s', strtotime($s['closing_at'])) ?></td>

                                        <td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?= $s['contact'] ?></td>
                                        <td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?= $s['summary'] ?></td>
                                        <!-- <td><img src="<?= base_url('uploads/salestracker/' . $s['image']) ?>" alt="" srcset="" width="70px"></td> -->
                                        <td><?php if ($s['end_date'] == NULL) { ?> <span class="badge badge-danger">On Going</span> <?php } else { ?> <span class="badge badge-success">held</span> <?php } ?></td>
                                        <td <?php if ($s['end_date'] == NULL) { ?> class="text-danger" <?php } ?>><?php if ($s['image'] != NULL) {

                                                                                                                    ?><a href="<?= base_url('uploads/salestracker/' . $s['image']) ?>" target="_blank">foto</a></td>
                                    <?php } ?>
                                    <td><?= getGrade($nilai)  ?></td>
                                    </tr>
                                <?php
                                    $totalNilai += $nilai;
                                } ?>
                            </tbody>


                        </table>
                        <p>total nilai = <?= $totalNilai/$salestracker->num_rows() ?> </p>
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