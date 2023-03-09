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

                        <h2 class="card-title">KPI Jobsheet
                            <div class="row">
                                <form action="<?= base_url('superadmin/Kpi/detailJobsheet') ?>" method="POST">
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

                            <!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
                            <p><?= $this->session->flashdata('message'); ?></p>
                            <thead>
                                <tr>
                                    <th style="width: 15%;">Resi</th>
                                    <th>Pickup At</th>
                                    <th>Submit So At</th>
                                    <th>Create Jobsheet At</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($resionjs->result_array() as $resi) {
                                    $so = $this->db->get_where('tbl_so', array('id_so' => $resi['id_so']))->row_array();
                                    $nilai = 0;

                                    $date1 = date_create(date('Y-m-d', strtotime($resi['tgl_pickup'])));
                                    $date2 = date_create(date('Y-m-d', strtotime($resi['create_js_at'])));
                                    $diff = date_diff($date1, $date2);

                                    // echo $resi['shipment_id'] . ' - ' . $diff->format("%R%a") . '<br>';

                                    if ($diff->format("%R%a") == 0) {
                                        // nilai A
                                        $nilai = 90;
                                    } elseif ($diff->format("%R%a") == 1) {
                                        // nilai B
                                        $nilai = 70;
                                    } elseif ($diff->format("%R%a") == 2) {
                                        // nilai C
                                        $nilai = 50;
                                    } elseif ($diff->format("%R%a") > 2) {
                                        // nilai D
                                        $nilai = 30;
                                    } else {
                                        $nilai = 0;
                                    }
                                    // echo $resi['shipment_id'] . ' - ' . $diff->format("%R%a") . ' ' . $nilai . ' ' . '<br>';
                                ?>
                                    <tr>
                                        <td><?= $resi['shipment_id'] ?></td>
                                        <td><?= date('d F Y', strtotime($resi['tgl_pickup']))  ?></td>
                                        <td><?php if ($so['submitso_at'] != NULL) {
                                                echo date('d F Y', strtotime($so['submitso_at']));
                                            }   ?></td>
                                        <td><?php if ($resi['create_js_at'] != NULL) {
                                                echo date('d F Y', strtotime($resi['create_js_at']));
                                            } else {
                                                echo 'Belum Buat JS';
                                            }  ?></td>
                                        <td><?= getGrade($nilai)  ?></td>
                                    </tr>
                                <?php } ?>

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