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
                            <a class="nav-item nav-link active" id="nav-plan-tab" data-toggle="tab" href="#nav-plan" role="tab" aria-controls="nav-plan" aria-selected="true">Meeting Plan</a>
                            <a class="nav-item nav-link" id="nav-closing-tab" data-toggle="tab" href="#nav-closing" role="tab" aria-controls="nav-closing" aria-selected="false">Closing Meeting</a>
                            <a class="nav-item nav-link" id="nav-so-tab" data-toggle="tab" href="#nav-so" role="tab" aria-controls="nav-so" aria-selected="false">Sales Order</a>

                        </div>
                    </nav>
                </div>
                <div class="card-body" style="overflow: auto;">

                    <div class="col-md-12">

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-plan" role="tabpanel" aria-labelledby="nav-plan-tab">
                                <table class="table table-separate table-head-custom table-checkable datatable">

                                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('error_upload'); ?>"></div>
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
                                        foreach ($sales->result_array() as $s) {
                                            $nilai = 0;
                                            $this->db->where('id_sales', $s['id_user']);
                                            $this->db->where('start_date >=', date('Y-m-d', strtotime($awal)));
                                            $this->db->where('start_date <=', date('Y-m-d', strtotime($akhir)));
                                            $salesTracker = $this->db->get('tbl_sales_tracker');

                                            foreach ($salesTracker->result_array() as $track) {

                                                $date1 = date_create(date('Y-m-d', strtotime($track['start_date'])));
                                                $date2 = date_create(date('Y-m-d', strtotime($track['created_at'])));

                                                $diff = date_diff($date2, $date1);
                                                // echo $track['start_date'] . '<br>';
                                                // echo $track['created_at'] .s '<br>';
                                                // echo $sales['nama_user'] . $diff->format(" %R%a days <br>");


                                                // jika meeting plan disubmit hari yang sama
                                                if ($diff->format("%R%a") == 0) {

                                                    if (date('H:i:s', strtotime($track['created_at'])) <= '12:00:00') {
                                                        // nilai B
                                                        $nilai  += 70;
                                                    } else {
                                                        // nilai C
                                                        $nilai += 50;
                                                    }
                                                }
                                                // jika meeting plan dibuat di hari sebelum meeting
                                                elseif ($diff->format("%R%a") > 0) {
                                                    // nilai A 
                                                    $nilai  += 90;
                                                    // echo $s['nama_user'] . 'a';
                                                } elseif ($diff->format("%R%a") < 0) {
                                                    // nilai D
                                                    $nilai += 30;
                                                }
                                            }
                                            if ($nilai != 0) {
                                                $nilai = $nilai / $salesTracker->num_rows();
                                            }

                                        ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $s['nama_user'] ?></td>
                                                <td><?= getGrade($nilai)  ?></td>
                                                <td><a class="btn btn-primary" href="<?= base_url('superadmin/Kpi/detailMeetingPlan/' . $s['id_user'] . '/' . strtotime($awal) . '/' . strtotime($akhir)) ?>">Detail</a></td>

                                            </tr>
                                        <?php $no++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="nav-closing" role="tabpanel" aria-labelledby="nav-profile-closing">
                                <table class="table table-separate table-head-custom table-checkable datatable">

                                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('error_upload'); ?>"></div>
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
                                        foreach ($sales->result_array() as $s) {
                                            $nilai = 0;
                                            $this->db->where('id_sales', $s['id_user']);
                                            $this->db->where('start_date >=', date('Y-m-d', strtotime($awal)));
                                            $this->db->where('start_date <=', date('Y-m-d', strtotime($akhir)));
                                            $salesTracker = $this->db->get_where('tbl_sales_tracker', array('id_sales' => $s['id_user']));
                                            foreach ($salesTracker->result_array() as $track) {
                                                $date1 = date_create(date('Y-m-d', strtotime($track['closing_at'])));
                                                $date2 = date_create(date('Y-m-d', strtotime($track['end_date'])));
                                                $diff = date_diff($date2, $date1);

                                                $datetime1 = strtotime($track['closing_at']);
                                                $datetime2 = strtotime($track['end_date']);
                                                $interval  = abs($datetime2 - $datetime1);
                                                $minutes   = round($interval / 60);
                                                // echo 'Diff. in minutes is: ' . $minutes . '<br>';
                                                if ($diff->format("%R%a") == 0) {
                                                    if ($minutes <= 10 && $minutes > 0) {

                                                        // echo $s['nama_user'] . 'Kurang 10 <br>';
                                                        // nilai A
                                                        $nilai += 90;
                                                    } elseif ($minutes > 10) {
                                                        // nilai B 
                                                        $nilai += 70;
                                                    } elseif ($minutes < 0) {
                                                        $nilai += 50;
                                                    }
                                                } elseif ($diff->format("%R%a") == 1) {
                                                    // nilai C
                                                    $nilai += 50;
                                                } else {
                                                    $nilai += 30;
                                                    // Nilai D
                                                }
                                            }
                                            if ($nilai != 0) {
                                                $nilai = $nilai / $salesTracker->num_rows();
                                            }

                                        ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $s['nama_user'] ?></td>
                                                <td><?= getGrade($nilai)  ?></td>
                                                <td><a class="btn btn-primary" href="<?= base_url('superadmin/Kpi/detailClosingMeeting/' . $s['id_user'] . '/' . strtotime($awal) . '/' . strtotime($akhir)) ?>">Detail</a></td>

                                            </tr>
                                        <?php $no++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="nav-so" role="tabpanel" aria-labelledby="nav-profile-so">
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
                                        foreach ($sales->result_array() as $s) {
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