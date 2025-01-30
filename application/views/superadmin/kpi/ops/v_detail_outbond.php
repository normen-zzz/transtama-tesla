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

                        <h2 class="card-title">KPI Outbond OPS
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
                                    <th>Resi</th>
                                    <th style="width: 15%;">Barang Datang</th>
                                    <th style="width: 15%;">Barang Keluar</th>
                                    <th>Lead Time (Jam)</th>
                                    <th>Customer</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($outbond->result_array() as $p) {
                                    $nilai = 0;
                                        $date1 = date_create(date('Y-m-d H:i:s', strtotime($p['in_date'])));
                                        $date2 = date_create(date('Y-m-d H:i:s', strtotime($p['out_date'])));
                                        $diff = date_diff($date1, $date2);

                                        if ($diff->format("%R%H") >= 1 && $diff->format("%R%H") < 6) {
                                            // nilai A
                                            $nilai = 90;
                                        } elseif ($diff->format("%R%H") >= 6 && $diff->format("%R%H") < 8) {
                                            // nilai B
                                            $nilai = 70;
                                        } elseif ($diff->format("%R%H") >= 8 && $diff->format("%R%H") < 10) {
                                            // nilai C
                                            $nilai = 50;
                                        } elseif ($diff->format("%R%H") >= 10) {
                                            $nilai = 30;
                                        }
                                       
                                    
                                    // echo $p['id_so'] . ' - ' . $diff->format("%R%H") . '-' . $nilai . '<br>';


                                ?>
                                    <tr>
                                        <td><?= $p['shipment_id'] ?></td>
                                        <td><?= $p['in_date'] ?></td>
                                        <td><?= $p['out_date'] ?></td>
                                        <td><?= $diff->format("%R%H") ?></td>
                                        <td><?= $p['shipper'] ?></td>
                                        <td>
                                            <p><?php echo getGrade($nilai); ?></p>
                                        </td>



                                    </tr>
                                <?php
                                } ?>
                            </tbody>


                        </table>

                        <div id="nilai" value="<?= $nilaiAll ?>"><?= $nilaiAll ?></div>

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