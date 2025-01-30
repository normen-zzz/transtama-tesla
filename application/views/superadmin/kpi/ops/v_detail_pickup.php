<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<script>
    console.log(document.getElementById("nilai").innerHTML + 'hehehe');
</script>

<!-- Main content -->
<?php
$nilaiAll = 0;
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

                        <h2 class="card-title">KPI PICKUP OPS
                            <h1></h1>
                            <div class="row">
                                <form action="<?= base_url('superadmin/Kpi/detailPickup') ?>" method="POST">
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
                            <!-- <button class="btn btn-icon waves-effect waves-light btn-success mb-4" data-toggle="modal" data-target="#addBukti"> <i class="fas fa-plus"></i> Lakukan Pembayaran Sample </button> -->

                            <!-- <div class="row">
									<a target="blank" href="<?= base_url('superadmin/order/exportexcel/null/null/0') ?>" class="btn btn-sm btn-danger mb-3 ml-2">Export Laporan Keseluruhan</a>
								</div> -->




                    </div>

                    <!-- /.card-header -->
                    <div class="card-body" style="overflow: auto;">

                        <table class="table table-bordered datatable">
                            <p><?= $this->session->flashdata('message'); ?></p>
                            <thead>
                                <tr>
                                    <th>Id Pickup</th>
                                    <th>Driver</th>
                                    <th style="width: 15%;">JADWAL PICKUP</th>
                                    <th style="width: 15%;">TER PICKUP</th>
                                    <th>Lead Time (Jam)</th>
                                    <th>Customer</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($pickup->result_array() as $p) {
                                    $nilai = 0;
                                    $get_last_status = $this->db->limit(1)->order_by('id_tracking', 'desc')->get_where('tbl_tracking_real', ['id_so' => $p['id_so'], 'flag' => 3])->row_array();


                                    if ($get_last_status != NULL) {
                                        $user = $this->db->get_where('tb_user', array('id_user' => $get_last_status['id_user']))->row_array();
                                        $date1 = date_create(date('Y-m-d H:i:s', strtotime($p['tgl_pickup'] . ' ' . $p['time'])));
                                        $date2 = date_create(date('Y-m-d H:i:s', strtotime($get_last_status['created_at'] . ' ' . $get_last_status['time'])));
                                        $diff = date_diff($date1, $date2);

                                        if ($diff->format("%R%H") > 0 && $diff->format("%R%H") <= 3 || $diff->format("%R%H") <= 0) {
                                            // nilai A
                                            $nilai = 90;
                                        } elseif ($diff->format("%R%H") > 3 && $diff->format("%R%H") <= 5) {
                                            // nilai B
                                            $nilai = 70;
                                        } elseif ($diff->format("%R%H") > 5 && $diff->format("%R%H") <= 9) {
                                            // nilai C
                                            $nilai = 50;
                                        } elseif ($diff->format("%R%H") > 9) {
                                            $nilai = 30;
                                        }
                                       
                                    }
                                    // echo $p['id_so'] . ' - ' . $diff->format("%R%H") . '-' . $nilai . '<br>';


                                ?>
                                    <tr>
                                        <td><?= $p['id_so'] ?></td>
                                        <td><?= $user['nama_user'] ?></td>
                                        <td><?= date('d F Y H:i:s', strtotime($p['tgl_pickup'] . ' ' . $p['time'])) ?></td>
                                        <td><?php if ($get_last_status != NULL) {
                                                echo  date('d F Y H:i:s', strtotime($get_last_status['created_at'] . ' ' . $get_last_status['time']));
                                            } else {
                                                echo 'Belum Di Pickup';
                                            } ?></td>
                                        <td><?= $diff->format("%R%H") ?></td>
                                        <td><?= $p['shipper'] ?></td>
                                        <td>
                                            <p><?php if ($get_last_status != NULL) {
                                                    echo getGrade($nilai);
                                                } else {
                                                    echo 'Belum di pickup';
                                                } ?></p>
                                        </td>



                                    </tr>
                                <?php
                                } ?>
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
    var text = document.getElementById('nilai').innerHTML;
    console.log('hehehehehe');
</script>