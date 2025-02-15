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

                        <h2 class="card-title">KPI Invoice
                            <div class="row">
                                <form action="<?= base_url('superadmin/Kpi/detailInvoice') ?>" method="POST">
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
                                    <th style="width: 15%;">No Invoice</th>
                                    <th>Created Invoice At</th>
                                    <th>Pod Tiba</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nilai = 0;
                                foreach ($noinvoice->result_array() as $inv1) {
                                    $this->db->select('shipment_id');
                                    $this->db->where('no_invoice', $inv1['no_invoice']);
                                    $resiInvoice = $this->db->get('tbl_invoice');
                                    $nilaiResi = 0;
                                    $allPod = [];
                                    foreach ($resiInvoice->result_array() as $resiInv) {
                                        $this->db->select('shipment_id');
                                        $resi = $this->db->get_where('tbl_shp_order', array('id' => $resiInv['shipment_id']))->row_array();
                                        $pod = $this->db->get_where('tbl_tracking_pod', array('shipment_id' => $resi['shipment_id']))->row_array();

                                        if ($pod != NULL) {
                                            // memberi jarak sehari
                                            $pod_sampe = date_create(date("Y-m-d", strtotime("1 day", strtotime($pod['tgl_sampe']))));
                                            $date2 = date_create(date('Y-m-d', strtotime($inv1['update_at'])));
                                            $diff = date_diff($pod_sampe, $date2);
                                            // jarak invoice dibuat dari pod diterima
                                            // echo $inv1['no_invoice'] . '/' . $pod['shipment_id'] . $diff->format(" %R%a days <br>");
                                            // jika meeting plan disubmit hari yang sama
                                            if ($diff->format("%R%a") == 0) {
                                                $nilaiResi  += 90;
                                            }
                                            // jika meeting plan dibuat di hari sebelum meeting
                                            elseif ($diff->format("%R%a") > 0 && $diff->format("%R%a") <= 3) {
                                                // nilai B 
                                                $nilaiResi  += 70;
                                            } elseif ($diff->format("%R%a") >= 4 && $diff->format("%R%a") <= 7) {
                                                // nilai C
                                                $nilaiResi += 50;
                                            } elseif ($diff->format("%R%a") > 7) {
                                                // nilai D
                                                $nilaiResi += 30;
                                            }
                                            array_push($allPod,  $resi['shipment_id'] . ' => ' . date("Y-m-d", strtotime("1 day", strtotime($pod['tgl_sampe']))));
                                        }
                                        $nilai = $nilaiResi / $resiInvoice->num_rows();
                                    }




                                ?>
                                    <tr>
                                        <td><?= $inv1['no_invoice'] ?></td>
                                        <td><?= $inv1['update_at'] ?></td>
                                        <td><?php if ($allPod != NULL) {

                                                foreach ($allPod as $pod) {
                                                    echo $pod . '<br>';
                                                }
                                            } else {
                                                echo 'Pod Belum Sampai';
                                            } ?></td>
                                        <td><?= getGrade($nilai)  ?></td>
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
</script>