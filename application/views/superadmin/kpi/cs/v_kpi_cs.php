<style>
    .datepicker-inline {
        width: auto;
        /*what ever width you want*/
    }
</style>

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

<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">

                        <h3 class="card-label"><?= $title ?>
                            <span class="d-block text-muted pt-2 font-size-sm"></span>
                        </h3>
                        <div class="row">
                            <form action="<?= base_url('superadmin/Kpi/cs') ?>" method="POST">
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
                    </div>


                    <div class="card-toolbar float-right">



                        <!--begin::Button-->
                        <a href="#" class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#modal-lg" style="background-color: #9c223b;">
                            <span class="svg-icon svg-icon-md">
                                <i class="fa fa-plus text-light"></i>
                                <!--end::Svg Icon-->
                            </span>Add</a>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="col-md-12">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-jobsheet-tab" data-toggle="tab" href="#nav-jobsheet" role="tab" aria-controls="nav-jobsheet" aria-selected="true">Jobsheet</a>
                            <a class="nav-item nav-link" id="nav-reservasi-tab" data-toggle="tab" href="#nav-reservasi" role="tab" aria-controls="nav-reservasi" aria-selected="false">Reservasi</a>
                            <a class="nav-item nav-link" id="nav-deliverydaerah-tab" data-toggle="tab" href="#nav-deliverydaerah" role="tab" aria-controls="nav-delivery" aria-selected="false">Delivery Daerah</a>
                            <a class="nav-item nav-link" id="nav-update-tab" data-toggle="tab" href="#nav-update" role="tab" aria-controls="nav-update" aria-selected="false">Update Sistem</a>
                            <a class="nav-item nav-link" id="nav-visit-tab" data-toggle="tab" href="#nav-visit" role="tab" aria-controls="nav-visit" aria-selected="false">Visit</a>

                        </div>
                    </nav>
                </div>
                <div class="card-body" style="overflow: auto;">

                    <div class="col-md-12">

                        <div class="tab-content" id="nav-tabContent">
                            <!-- JOBSHEET -->
                            <div class="tab-pane fade show active" id="nav-jobsheet" role="tabpanel" aria-labelledby="nav-jobsheet-tab">
                                <table class="table table-separate table-head-custom table-checkable datatable">

                                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('error_upload'); ?>"></div>
                                    <thead>
                                        <tr>
                                            <th>Total Resi</th>
                                            <th>Nilai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        $nilai = 0;
                                        foreach ($resionjs->result_array() as $resi) {
                                            $date1 = date_create(date('Y-m-d', strtotime($resi['tgl_pickup'])));
                                            $date2 = date_create(date('Y-m-d', strtotime($resi['create_js_at'])));
                                            $diff = date_diff($date1, $date2);

                                            // echo $resi['shipment_id'] . ' - ' . $diff->format("%R%a") . '<br>';

                                            if ($diff->format("%R%a") == 0) {
                                                // nilai A
                                                $nilai += 90;
                                            } elseif ($diff->format("%R%a") == 1) {
                                                // nilai B
                                                $nilai += 70;
                                            } elseif ($diff->format("%R%a") == 2) {
                                                // nilai C
                                                $nilai += 50;
                                            } elseif ($diff->format("%R%a") > 2) {
                                                // nilai D
                                                $nilai += 30;
                                            } else {
                                                $nilai += 0;
                                            }
                                            // echo $resi['shipment_id'] . ' - ' . $diff->format("%R%a") . ' ' . $nilai . ' ' . '<br>';
                                        }
                                        if ($resionjs->num_rows() != 0) {
                                            $nilai = $nilai / $resionjs->num_rows();
                                            // echo  $so->num_rows();
                                        }



                                        ?>
                                        <tr>
                                            <td><?= $resionjs->num_rows() ?></td>
                                            <td><?= getGrade($nilai)  ?></td>
                                            <td><a class="btn btn-primary" href="<?= base_url('superadmin/Kpi/detailJobsheet/' . strtotime($awal) . '/' . strtotime($akhir)) ?>">Detail</a></td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <!-- RESERVASI  -->
                            <div class="tab-pane fade" id="nav-reservasi" role="tabpanel" aria-labelledby="nav-profile-reservasi">
                                <table class="table table-separate table-head-custom table-checkable datatable">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Jumlah Resi</th>
                                            <th>Nilai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $start    = (new DateTime($awal))->modify('first day of this month');
                                        $end      = (new DateTime($akhir))->modify('first day of next month');
                                        $interval = DateInterval::createFromDateString('1 month');
                                        $period   = new DatePeriod($start, $interval, $end);

                                        foreach ($period as $dt) {
                                            $nilai = 0;
                                            $jumlahVisit = 0;
                                            // echo $dt->format("Y-m") . "<br>\n";
                                            $this->db->where('MONTH(tgl_pickup)', $dt->format("m"));
                                            $this->db->where('YEAR(tgl_pickup)', $dt->format("Y"));
                                            $this->db->where('service_type', 'f4e0915b-7487-4fae-a04c-c3363d959742');
                                            $resi = $this->db->get('tbl_shp_order');

                                            foreach ($resi->result_array() as $resi1) {
                                                if ($resi1['flight_at'] != NULL) {
                                                    if ($diff->format("%R%a") == 1) {
                                                        // nilai A
                                                        $nilai += 90;
                                                    } elseif ($diff->format("%R%a") == 2) {
                                                        // nilai B
                                                        $nilai += 70;
                                                    } elseif ($diff->format("%R%a") >= 3) {
                                                        // nilai C
                                                        $nilai += 50;
                                                    }
                                                }
                                            }
                                            if ($resi->num_rows() != 0) {
                                                $nilai = ($nilai / $resi->num_rows());
                                            }



                                        ?>
                                            <tr>

                                                <td><?php echo $dt->format("F Y") ?></td>
                                                <td><?= $resi->num_rows(); ?></td>
                                                <td><?= getGrade($nilai) . '-' . $nilai; ?></td>
                                                <td><a class="btn btn-primary" href="<?= base_url('superadmin/Kpi/detailReservasi/' . $dt->format("m") . '/' . $dt->format("Y")) ?>">Detail</a></td>

                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Delivery Daerah  -->
                            <div class="tab-pane fade" id="nav-deliverydaerah" role="tabpanel" aria-labelledby="nav-profile-deliverydaerah">
                                <table class="table table-separate table-head-custom table-checkable datatable">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Jumlah Resi</th>
                                            <th>Nilai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $start    = (new DateTime($awal))->modify('first day of this month');
                                        $end      = (new DateTime($akhir))->modify('first day of next month');
                                        $interval = DateInterval::createFromDateString('1 month');
                                        $period   = new DatePeriod($start, $interval, $end);

                                        foreach ($period as $dt) {
                                            $nilai = 0;
                                            $jumlahVisit = 0;
                                            // echo $dt->format("Y-m") . "<br>\n";
                                            $this->db->where('MONTH(tgl_pickup)', $dt->format("m"));
                                            $this->db->where('YEAR(tgl_pickup)', $dt->format("Y"));
                                            $this->db->where('is_jabodetabek', 2);
                                            $resi = $this->db->get('tbl_shp_order');

                                            foreach ($resi->result_array() as $s) {
                                                $date1 = date_create(date('Y-m-d', strtotime($s['tgl_pickup'])));
                                                $date2 = date_create(date('Y-m-d', strtotime($s['tgl_diterima'])));
                                                $diff = date_diff($date1, $date2);

                                                $city = $this->db->get_where('tb_city', array('city_name' => $s['city_consigne']))->row_array();

                                                if ($city['lead_awal'] != NULL) {

                                                    if ($diff->format("%R%a") < $city['lead_awal']) {
                                                        // nilai A
                                                        $nilai += 90;
                                                    } elseif ($diff->format("%R%a") >= $city['lead_awal'] && $diff->format("%R%a") <= $city['lead_akhir']) {
                                                        // nilai B
                                                        $nilai += 70;
                                                    } elseif ($diff->format("%R%a") > $city['lead_akhir'] && $diff->format("%R%a") - $city['lead_akhir'] <= 2) {
                                                        // nilai C
                                                        $nilai += 50;
                                                    } elseif ($diff->format("%R%a") > $city['lead_akhir'] && $diff->format("%R%a") - $city['lead_akhir'] > 2) {
                                                        // nilai D
                                                        $nilai += 30;
                                                    }
                                                }
                                            }

                                            if ($resi->num_rows() != 0) {
                                                $nilai = ($nilai / $resi->num_rows());
                                            }



                                        ?>
                                            <tr>

                                                <td><?php echo $dt->format("F Y") ?></td>
                                                <td><?= $resi->num_rows(); ?></td>
                                                <td><?= getGrade($nilai) . '-' . $nilai; ?></td>
                                                <td><a class="btn btn-primary" href="<?= base_url('superadmin/Kpi/detailDeliveryDaerah/' . $dt->format("m") . '/' . $dt->format("Y")) ?>">Detail</a></td>

                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Update Sistem  -->
                            <div class="tab-pane fade" id="nav-update" role="tabpanel" aria-labelledby="nav-profile-update">
                                <table class="table table-separate table-head-custom table-checkable datatable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Nilai</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($cs->result_array() as $s) {
                                            $nilai = 0;
                                            $this->db->where('id_sales', $s['id_user']);
                                            $this->db->where('tgl_pickup >=', date('Y-m-d', strtotime($awal)));
                                            $this->db->where('tgl_pickup <=', date('Y-m-d', strtotime($akhir)));
                                            $so = $this->db->get('tbl_so');
                                            foreach ($so->result_array() as $so1) {
                                                $this->db->where('id_so', $so1['id_so']);
                                                $this->db->where('flag', 3);
                                                $this->db->order_by('id_so', "DESC");
                                                $this->db->limit(1);
                                                $trackingResi = $this->db->get('tbl_tracking_real')->row_array();

                                                if ($so1['submitso_at'] != NULL && $trackingResi != NULL) {

                                                    $date1 = date_create(date('Y-m-d', strtotime($so1['submitso_at'])));
                                                    $date2 = date_create(date('Y-m-d', strtotime($trackingResi['created_at'])));
                                                    $diff = date_diff($date2, $date1);
                                                    // echo $so1['id_so'] . $diff->format(" %R%a days <br>");

                                                    $datetime1 = strtotime($so1['submitso_at']);
                                                    $datetime2 = strtotime($trackingResi['created_at']);
                                                    $interval  = abs($datetime2 - $datetime1);
                                                    $minutes   = round($interval / 60);


                                                    if ($diff->format("%R%a") == 0) {
                                                        if ($minutes <= 300) {
                                                            $nilai += 90;
                                                        } else {
                                                            $nilai += 70;
                                                        }
                                                    } elseif ($diff->format("%R%a") == 1) {
                                                        if (date('H:i:s', strtotime($trackingResi['created_at'])) >= '21:00:00') {
                                                            $nilai += 70;
                                                        } else {
                                                            $nilai += 50;
                                                        }
                                                    } elseif ($diff->format("%R%a") > 1) {
                                                        $nilai += 30;
                                                    }
                                                }
                                                // echo $nilai . '<br>';
                                            }
                                            if ($so->num_rows() != 0) {
                                                $nilai = $nilai / $so->num_rows();
                                                // echo  $so->num_rows();
                                            }

                                        ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $s['nama_user'] ?></td>
                                                <td><?= getGrade($nilai); ?></td>
                                                <td><a class="btn btn-primary" href="<?= base_url('superadmin/Kpi/detailSo/' . $s['id_user'] . '/' . strtotime($awal) . '/' . strtotime($akhir)) ?>">Detail</a></td>

                                            </tr>
                                        <?php $no++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Visit  -->
                            <div class="tab-pane fade" id="nav-visit" role="tabpanel" aria-labelledby="nav-profile-visit">
                                <table class="table table-separate table-head-custom table-checkable datatable">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Jumlah Visit</th>
                                            <th>Nilai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $start    = (new DateTime($awal))->modify('first day of this month');
                                        $end      = (new DateTime($akhir))->modify('first day of next month');
                                        $interval = DateInterval::createFromDateString('1 month');
                                        $period   = new DatePeriod($start, $interval, $end);
                                        $nilai = 0;
                                        foreach ($period as $dt) {

                                            $jumlahVisit = 0;
                                            // echo $dt->format("Y-m") . "<br>\n";
                                            $this->db->where('MONTH(start_date)', $dt->format("m"));
                                            $this->db->where('YEAR(start_date)', $dt->format("Y"));
                                            $visit = $this->db->get('tbl_sales_tracker');

                                            foreach ($visit->result_array() as $visit1) {
                                                $user = $this->db->get_where('tb_user', array('id_user' => $visit1['id_sales']))->row_array();
                                                if ($user['id_role'] == 3) {
                                                    // echo $user['nama_user'] . '-' . $dt->format("F Y") . '<br>';
                                                    $jumlahVisit += 1;
                                                }
                                            }
                                            $nilai = ($jumlahVisit / 6) * 100;


                                        ?>
                                            <tr>

                                                <td><?php echo $dt->format("F Y") ?></td>
                                                <td><?= $jumlahVisit; ?></td>
                                                <td><?= getGrade($nilai); ?></td>
                                                <td><a class="btn btn-primary" href="<?= base_url('superadmin/Kpi/detailVisitCs/' . $dt->format("m") . '/' . $dt->format("Y")) ?>">Detail</a></td>

                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>



                        </div>
                    </div>
                    <!--begin: Datatable-->

                    <!--end: Datatable-->

                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>