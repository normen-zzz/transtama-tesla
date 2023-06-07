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
                            <form action="<?= base_url('superadmin/Kpi/ops') ?>" method="POST">
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
                            <a class="nav-item nav-link active" id="nav-pickup-tab" data-toggle="tab" href="#nav-pickup" role="tab" aria-controls="nav-pickup" aria-selected="true">Pickup</a>
                            <a class="nav-item nav-link" id="nav-delivery-tab" data-toggle="tab" href="#nav-delivery" role="tab" aria-controls="nav-delivery" aria-selected="false">Delivery</a>
                            <a class="nav-item nav-link" id="nav-outbond-tab" data-toggle="tab" href="#nav-outbond" role="tab" aria-controls="nav-outbond" aria-selected="false">Outbond</a>
                            <a class="nav-item nav-link" id="nav-gateway-tab" data-toggle="tab" href="#nav-gateway" role="tab" aria-controls="nav-gateway" aria-selected="false">Gateway</a>
                            <a class="nav-item nav-link" id="nav-pod-tab" data-toggle="tab" href="#nav-pod" role="tab" aria-controls="nav-pod" aria-selected="false">Pod Jabodetabek</a>
                            <a class="nav-item nav-link" id="nav-input-tab" data-toggle="tab" href="#nav-input" role="tab" aria-controls="nav-input" aria-selected="false">Input Tesla</a>
                            <a class="nav-item nav-link" id="nav-handover-tab" data-toggle="tab" href="#nav-handover" role="tab" aria-controls="nav-handover" aria-selected="false">Handover</a>
                            <a class="nav-item nav-link" id="nav-meetup-tab" data-toggle="tab" href="#nav-meetup" role="tab" aria-controls="nav-meetup" aria-selected="false">Meet Up</a>


                        </div>
                    </nav>
                </div>
                <div class="card-body" style="overflow: auto;">

                    <div class="col-md-12">

                        <div class="tab-content" id="nav-tabContent">
                            <!-- PICKUP -->
                            <div class="tab-pane fade show active" id="nav-pickup" role="tabpanel" aria-labelledby="nav-pickup-tab">
                                <table class="table table-separate table-head-custom table-checkable datatable">
                                    <thead>
                                        <tr>

                                            <th>Jumlah Req Pickup</th>
                                            <th>Nilai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php


                                        $nilai = 0;
                                        $jumlahPickup = 0;

                                        foreach ($so->result_array() as $so1) {
                                            $get_last_status = $this->db->limit(1)->order_by('id_tracking', 'desc')->get_where('tbl_tracking_real', ['id_so' => $so1['id_so'], 'flag' => 3])->row_array();

                                            if ($get_last_status != NULL) {




                                                $date1 = date_create(date('Y-m-d H:i:s', strtotime($so1['tgl_pickup'] . ' ' . $so1['time'])));
                                                $date2 = date_create(date('Y-m-d H:i:s', strtotime($get_last_status['created_at'] . ' ' . $get_last_status['time'])));
                                                $diff = date_diff($date1, $date2);
                                                // echo $so1['id_so'] . ' - ' . $diff->format("%R%H") . '<br>';
                                                if ($diff->format("%R%H") > 0 && $diff->format("%R%H") <= 3 || $diff->format("%R%H") <= 0) {
                                                    // nilai A
                                                    $nilai += 90;
                                                } elseif ($diff->format("%R%H") > 3 && $diff->format("%R%H") <= 5) {
                                                    // nilai B
                                                    $nilai += 70;
                                                } elseif ($diff->format("%R%H") > 5 && $diff->format("%R%H") <= 9) {
                                                    // nilai C
                                                    $nilai += 50;
                                                } elseif ($diff->format("%R%H") > 9) {
                                                    $nilai += 30;
                                                }
                                                $jumlahPickup += 1;
                                            }
                                        }
                                        if ($so->num_rows() != 0) {
                                            $nilai = ($nilai / $jumlahPickup);
                                        }



                                        ?>
                                        <tr>


                                            <td><?= $jumlahPickup ?></td>
                                            <td><?= getGrade($nilai) ?></td>
                                            <td><a target="_blank" class="btn btn-primary" href="<?= base_url('superadmin/Kpi/detailPickup/' . strtotime($awal) . '/' . strtotime($akhir)) ?>">Detail</a></td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <!-- DELIVERY  -->
                            <div class="tab-pane fade" id="nav-delivery" role="tabpanel" aria-labelledby="nav-profile-delivery">
                                <table class="table table-separate table-head-custom table-checkable datatable">
                                    <thead>
                                        <tr>
                                            <th>Jumlah Resi</th>
                                            <th>Nilai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;

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

                                            <td><?= getGrade($nilai); ?></td>
                                            <td><a target="_blank" class="btn btn-primary" href="<?= base_url('superadmin/Kpi/detailSo/' . strtotime($awal) . '/' . strtotime($akhir)) ?>">Detail</a></td>

                                        </tr>
                                        <?php $no++;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- OUTBOND  -->
                            <div class="tab-pane fade" id="nav-outbond" role="tabpanel" aria-labelledby="nav-profile-outbond">
                                <table class="table table-separate table-head-custom table-checkable datatable">
                                    <thead>
                                        <tr>

                                            <th>Jumlah Resi</th>
                                            <th>Nilai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        $nilai = 0;
                                        foreach ($outbond->result_array() as $outbond1) {
                                            $date1 = date_create(date('Y-m-d', strtotime($outbond1['in_date'])));
                                            $date2 = date_create(date('Y-m-d', strtotime($outbond1['out_date'])));
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
                                        if ($outbond->num_rows() != 0) {
                                            $nilai = $nilai / $outbond->num_rows();
                                            // echo  $so->num_rows();
                                        }



                                        ?>
                                        <tr>


                                            <td><?= $outbond->num_rows() ?></td>
                                            <td><?= getGrade($nilai) ?></td>
                                            <td><a target="_blank" class="btn btn-primary" href="<?= base_url('superadmin/Kpi/detailOutbond/'  . strtotime($awal) . '/' . strtotime($akhir)) ?>">Detail</a></td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <!-- GATEWAY  -->
                            <div class="tab-pane fade" id="nav-gateway" role="tabpanel" aria-labelledby="nav-profile-gateway">
                                <table class="table table-separate table-head-custom table-checkable datatable">
                                    <thead>
                                        <tr>
                                            <th>Jumlah Resi</th>
                                            <th>Nilai</th>
                                            <th>Action</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        $nilai = 0;
                                        foreach ($gateway->result_array() as $gateway1) {
                                            $date1 = date_create(date('Y-m-d', strtotime($gateway1['tgl_pickup'])));
                                            $date2 = date_create(date('Y-m-d', strtotime($gateway1['tgl_pickup'])));
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
                                        if ($gateway->num_rows() != 0) {
                                            $nilai = $nilai / $gateway->num_rows();
                                            // echo  $so->num_rows();
                                        }



                                        ?>
                                        <tr>
                                            <td><?= $gateway->num_rows(); ?></td>
                                            <td><?= getGrade($nilai); ?></td>
                                            <td><a target="_blank" class="btn btn-primary" href="<?= base_url('superadmin/Kpi/detailGateway/' . strtotime($awal) . '/' . strtotime($akhir)) ?>">Detail</a></td>

                                        </tr>
                                        <?php $no++;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- POD  -->
                            <div class="tab-pane fade" id="nav-pod" role="tabpanel" aria-labelledby="nav-profile-pod">
                                <table class="table table-separate table-head-custom table-checkable datatable">
                                    <thead>
                                        <tr>
                                            <th>Jumlah Resi</th>
                                            <th>Nilai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        $nilai = 0;
                                        foreach ($pod->result_array() as $pod1) {
                                            $date1 = date_create(date('Y-m-d', strtotime($pod1['tgl_pickup'])));
                                            $date2 = date_create(date('Y-m-d', strtotime($pod1['tgl_sampe'])));
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
                                        if ($pod->num_rows() != 0) {
                                            $nilai = $nilai / $pod->num_rows();
                                            // echo  $so->num_rows();
                                        }



                                        ?>
                                        <tr>


                                            <td><?= $pod->num_rows(); ?></td>
                                            <td><?= getGrade($nilai); ?></td>
                                            <td><a target="_blank" class="btn btn-primary" href="<?= base_url('superadmin/Kpi/detailPod/' . strtotime($awal) . '/' . strtotime($akhir))  ?>">Detail</a></td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <!-- INPUT  -->
                            <div class="tab-pane fade" id="nav-input" role="tabpanel" aria-labelledby="nav-profile-input">
                                <table class="table table-separate table-head-custom table-checkable datatable">
                                    <thead>
                                        <tr>
                                            <th>Jumlah Resi</th>
                                            <th>Nilai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        $nilai = 0;
                                        $resifix = 0;
                                        $CI = &get_instance();
                                        $CI->load->model('KpiModel');
                                        foreach ($input->result_array() as $input1) {

                                            $inputawal = $this->KpiModel->getInputAwal($input1['shipment_id'])->row_array();
                                            $inputakhir = $this->KpiModel->getInputAkhir($input1['shipment_id'])->row_array();
                                            if ($inputawal != NULL && $inputakhir != NULL) {

                                                $resifix += 1;
                                                $date1 = date_create(date('Y-m-d H:i:s', strtotime($inputawal['tgl_tracking'].' '.$inputawal['waktu_tracking'])));
                                                $date2 = date_create(date('Y-m-d H:i:s', strtotime($inputakhir['tgl_tracking'].' '.$inputakhir['waktu_tracking'])));
                                                $diff = date_diff($date1, $date2);

                                                // echo $resi['shipment_id'] . ' - ' . $diff->format("%R%a") . '<br>';

                                                if ($diff->format("%R%H") < 1) {
                                                    // nilai A
                                                    $nilai += 90;
                                                } elseif ($diff->format("%R%H") >= 1 && $diff->format("%R%H") < 3) {
                                                    // nilai B
                                                    $nilai += 70;
                                                } elseif ($diff->format("%R%H") >= 3 && $diff->format("%R%H") < 5) {
                                                    // nilai C
                                                    $nilai += 50;
                                                } elseif ($diff->format("%R%H") >= 5) {
                                                    // nilai D
                                                    $nilai += 30;
                                                } else {
                                                    $nilai += 0;
                                                }
                                                echo $input1['shipment_id'] . ' - ' . $diff->format("%R%H") . ' ' . $nilai . ' ' . '<br>';
                                            }
                                        }
                                        if ($resifix) {
                                            $nilai = $nilai / $resifix;
                                            // echo  $so->num_rows();
                                        }



                                        ?>
                                        <tr>


                                            <td><?= $resifix; ?></td>
                                            <td><?= getGrade($nilai); ?></td>
                                            <td><a target="_blank" class="btn btn-primary" href="<?= base_url('superadmin/Kpi/detailInput/' . strtotime($awal) . '/' . strtotime($akhir))  ?>">Detail</a></td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <!-- HANDOVER  -->
                            <div class="tab-pane fade" id="nav-handover" role="tabpanel" aria-labelledby="nav-profile-handover">
                                <table class="table table-separate table-head-custom table-checkable datatable">
                                    <thead>
                                        <tr>
                                            <th>Jumlah Resi</th>
                                            <th>Nilai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        $nilai = 0;
                                        foreach ($handover->result_array() as $handover1) {
                                            $date1 = date_create(date('Y-m-d H:i:s', strtotime($handover1['updatesistem_at'])));
                                            $date2 = date_create(date('Y-m-d H:i:s', strtotime($handover1['tgl_tracking'] . ' ' . $handover1['waktu_tracking'])));
                                            $diff = date_diff($date1, $date2);

                                            // echo $resi['shipment_id'] . ' - ' . $diff->format("%R%a") . '<br>';

                                            if ($diff->format("%R%H") < 1) {
                                                // nilai A
                                                $nilai += 90;
                                            } elseif ($diff->format("%R%H") < 3) {
                                                // nilai B
                                                $nilai += 70;
                                            } elseif ($diff->format("%R%H") < 5) {
                                                // nilai C
                                                $nilai += 50;
                                            } elseif ($diff->format("%R%H") >= 5) {
                                                // nilai D
                                                $nilai += 30;
                                            } else {
                                                $nilai += 0;
                                            }
                                            // echo $resi['shipment_id'] . ' - ' . $diff->format("%R%a") . ' ' . $nilai . ' ' . '<br>';
                                        }
                                        if ($handover->num_rows() != 0) {
                                            $nilai = $nilai / $handover->num_rows();
                                            // echo  $so->num_rows();
                                        }



                                        ?>
                                        <tr>


                                            <td><?= $handover->num_rows(); ?></td>
                                            <td><?= getGrade($nilai); ?></td>
                                            <td><a target="_blank" class="btn btn-primary" href="<?= base_url('superadmin/Kpi/detailHandover/' . strtotime($awal) . '/' . strtotime($akhir)) ?>">Detail</a></td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <!-- MEETUP  -->
                            <div class="tab-pane fade" id="nav-meetup" role="tabpanel" aria-labelledby="nav-profile-meetup">
                                <table class="table table-separate table-head-custom table-checkable datatable">
                                    <thead>
                                        <tr>

                                            <th>Jumlah Resi</th>
                                            <th>Nilai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        $nilai = 0;
                                        foreach ($meetup->result_array() as $meetup1) {
                                            $date1 = date_create(date('Y-m-d', strtotime($meetup1['in_date'])));
                                            $date2 = date_create(date('Y-m-d', strtotime($meetup1['out_date'])));
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
                                        if ($meetup->num_rows() != 0) {
                                            $nilai = $nilai / $meetup->num_rows();
                                            // echo  $so->num_rows();
                                        }



                                        ?>
                                        <tr>


                                            <td><?= $meetup->num_rows(); ?></td>
                                            <td><?= getGrade($nilai); ?></td>
                                            <td><a target="_blank" class="btn btn-primary" href="<?= base_url('superadmin/Kpi/detailMeetup/' . strtotime($awal) . '/' . strtotime($akhir))  ?>">Detail</a></td>

                                        </tr>

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