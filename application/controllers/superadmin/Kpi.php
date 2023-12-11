<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kpi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id_user')) {
            redirect('backoffice');
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model('UserModel');
        $this->load->model('KpiModel');
        cek_role();
    }

    public function finance()
    {
        if ($this->input->post('awal') == NULL) {
            $data['title'] = 'KPI FINANCE';
            $data['awal'] = date('Y-m-d');
            $data['akhir'] = date('Y-m-t');
            $data['sales'] = $this->db->get_where('tb_user', array('id_role' => 6));
            $data['noinvoice'] = $this->KpiModel->getInvoice(strtotime(date('Y-m-d')), strtotime(date('Y-m-t')));
            $this->backend->display('superadmin/kpi/finance/v_kpi_finance', $data);
        } else {
            $data['title'] = 'KPI FINANCE';
            $data['awal'] = $this->input->post('awal');
            $data['akhir'] = $this->input->post('akhir');
            $data['sales'] = $this->db->get_where('tb_user', array('id_role' => 6));

            $data['noinvoice'] = $this->KpiModel->getInvoice(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $this->backend->display('superadmin/kpi/finance/v_kpi_finance', $data);
        }
    }

    public function detailInvoice($awal = NULL, $akhir = NULL)
    {
        if ($this->input->post('awal') != NULL) {
            $data['title'] = 'KPI Invoice';
            $data['awal'] = date('Y-m-d', strtotime($this->input->post('awal')));
            $data['akhir'] = date('Y-m-d', strtotime($this->input->post('akhir')));
            $data['user'] = $this->db->get_where('tb_user', array('id_user' => $this->input->post('user')))->row_array();
            $data['noinvoice'] = $this->KpiModel->getInvoice(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $this->backend->display('superadmin/kpi/finance/v_detailInvoice', $data);
        } else {
            $data['title'] = 'KPI Invoice';
            $data['awal'] = date('Y-m-d', $awal);
            $data['akhir'] = date('Y-m-d', $akhir);
            // $data['user'] = $this->db->get_where('tb_user', array('id_user' => $user))->row_array();
            $data['noinvoice'] = $this->KpiModel->getInvoice($awal, $akhir);
            $this->backend->display('superadmin/kpi/finance/v_detailInvoice', $data);
        }
    }

    //KPI SALES DONEEEEEEEEEEEEEEEEEEEEEEEEEE
    public function sales()
    {
        if ($this->input->post('awal') == NULL) {


            $data['title'] = 'KPI SALES';
            $data['awal'] = date('Y-m-d');
            $data['akhir'] = date('Y-m-t');
            $data['sales'] = $this->db->get_where('tb_user', array('id_role' => 4,'status' => 1));
            $this->backend->display('superadmin/kpi/sales/v_kpi_sales', $data);
        } else {
            $data['title'] = 'KPI SALES';
            $data['awal'] = $this->input->post('awal');
            $data['akhir'] = $this->input->post('akhir');
            $data['sales'] = $this->db->get_where('tb_user', array('id_role' => 4,'status' => 1));
            $this->backend->display('superadmin/kpi/sales/v_kpi_sales', $data);
        }
    }

    public function detailMeetingPlan($user, $awal, $akhir)
    {
        $data['title'] = 'KPI SALES';
        $data['awal'] = date('Y-m-d', $awal);
        $data['akhir'] = date('Y-m-d', $akhir);
        $data['user'] = $this->db->get_where('tb_user', array('id_user' => $user))->row_array();
        $data['salestracker'] = $this->KpiModel->getTrack($user, $awal, $akhir);
        $this->backend->display('superadmin/kpi/sales/v_detailMeetingPlan', $data);
    }

    public function detailClosingMeeting($user, $awal, $akhir)
    {
        $data['title'] = 'KPI SALES';
        $data['awal'] = date('Y-m-d', $awal);
        $data['akhir'] = date('Y-m-d', $akhir);
        $data['user'] = $this->db->get_where('tb_user', array('id_user' => $user))->row_array();
        $data['salestracker'] = $this->KpiModel->getTrack($user, $awal, $akhir);
        $this->backend->display('superadmin/kpi/sales/v_detailClosingMeeting', $data);
    }

    public function detailSO($user, $awal, $akhir)
    {
        $data['title'] = 'KPI SALES';
        $data['awal'] = date('Y-m-d', $awal);
        $data['akhir'] = date('Y-m-d', $akhir);
        $data['user'] = $this->db->get_where('tb_user', array('id_user' => $user))->row_array();
        $data['so'] = $this->KpiModel->getSo($user, $awal, $akhir);
        $this->backend->display('superadmin/kpi/sales/v_detailSo', $data);
    }
    // END OF KPI SALES 

    //KPI CS
    public function cs()
    {
        $data['title'] = 'KPI CS';
        $data['cs'] = $this->db->get_where('tb_user', array('id_role' => 3));
        if ($this->input->post('awal') == NULL) {
            $data['awal'] = date('Y-m-d');
            $data['akhir'] = date('Y-m-t');
            $data['resionjs'] = $this->KpiModel->getResiOnJs(strtotime(date('Y-m-d')), strtotime(date('Y-m-t')));
            $data['reservasi'] = $this->KpiModel->getResiOnReservasi(strtotime(date('Y-m-d')), strtotime(date('Y-m-t')));
            $data['daerah'] = $this->KpiModel->getResiOnDaerah(strtotime(date('Y-m-d')), strtotime(date('Y-m-t')));
            $data['visit'] = $this->KpiModel->getVisitCs(strtotime(date('Y-m-d')), strtotime(date('Y-m-t')));
            // $data['update'] = $this->KpiModel->getUpdateSistem(strtotime(date('Y-m-d')), strtotime(date('Y-m-t')));
        } else {
            $data['awal'] = $this->input->post('awal');
            $data['akhir'] = $this->input->post('akhir');
            $data['resionjs'] = $this->KpiModel->getResiOnJs(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $data['reservasi'] = $this->KpiModel->getResiOnReservasi(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $data['daerah'] = $this->KpiModel->getResiOnDaerah(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $data['visit'] = $this->KpiModel->getVisitCs(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            // $data['update'] = $this->KpiModel->getUpdateSistem(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
        }
        $this->backend->display('superadmin/kpi/cs/v_kpi_cs', $data);
    }

    public function detailJobsheet($awal = NULL, $akhir = NULL)
    {
        if ($this->input->post('awal') == NULL) {
            $data['title'] = 'KPI CS (Jobsheet)';
            $data['awal'] = date('Y-m-d', $awal);
            $data['akhir'] = date('Y-m-d', $akhir);
            $data['resionjs'] = $this->KpiModel->getResiOnJs($awal, $akhir);
            $this->backend->display('superadmin/kpi/cs/v_detail_jobsheet', $data);
        } else {
            $data['title'] = 'KPI CS (Jobsheet)';
            $data['awal'] = $this->input->post('awal');
            $data['akhir'] = $this->input->post('akhir');
            $data['resionjs'] = $this->KpiModel->getResiOnJs(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $this->backend->display('superadmin/kpi/cs/v_detail_jobsheet', $data);
        }
    }

    public function detailVisitCs($awal = NULL, $akhir = NULL)
    {
        if ($this->input->post('awal') == NULL) {
            $data['title'] = 'KPI CS (Visit)';
            $data['date'] =  $awal . '-' . $akhir;
            $data['visit'] = $this->KpiModel->getVisitCs($awal, $akhir);
            $data['awal'] = date('Y-m-d', $awal);
            $data['akhir'] = date('Y-m-d', $akhir);
            // var_dump(date('Y-m', strtotime($tahun . '-' . $bulan)));
            $this->backend->display('superadmin/kpi/cs/v_detail_visit', $data);
        } else {
            $data['title'] = 'KPI CS (Visit)';
            $data['date'] = $this->input->post('date');
            $data['awal'] = $this->input->post('awal');
            $data['akhir'] = $this->input->post('akhir');
            $data['visit'] = $this->KpiModel->getVisitCs(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $this->backend->display('superadmin/kpi/cs/v_detail_visit', $data);
        }
    }

    public function detailDeliveryDaerah($awal = NULL, $akhir = NULL)
    {
        if ($this->input->post('awal') == NULL) {
            $data['title'] = 'KPI CS (Delivery Daerah)';
            $data['date'] =  $awal . '-' . $akhir;
            $data['resi'] = $this->KpiModel->getDeliveryDaerah($awal, $akhir);
            // var_dump(date('Y-m', strtotime($tahun . '-' . $bulan)));
            $this->backend->display('superadmin/kpi/cs/v_detail_delivery_daerah', $data);
        } else {
            $data['title'] = 'KPI CS (Delivery Daerah)';
            $data['awal'] = $this->input->post('awal');
            $data['akhir'] = $this->input->post('akhir');
            $data['resi'] = $this->KpiModel->getDeliveryDaerah(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $this->backend->display('superadmin/kpi/cs/v_detail_delivery_daerah', $data);
        }
    }

    public function detailReservasi($awal = NULL, $akhir = NULL)
    {
        if ($this->input->post('awal') == NULL) {
            $data['title'] = 'KPI CS (Reservasi)';
            $data['date'] =  $awal . '-' . $akhir;
            $data['resi'] = $this->KpiModel->getReservasi($awal, $akhir);
            // var_dump(date('Y-m', strtotime($tahun . '-' . $bulan)));
            $this->backend->display('superadmin/kpi/cs/v_detail_reservasi', $data);
        } else {
            $data['title'] = 'KPI CS (Reservasi)';
            $data['date'] = $this->input->post('date');
            $data['awal'] = $this->input->post('awal');
            $data['akhir'] = $this->input->post('akhir');
            $data['resi'] = $this->KpiModel->getReservasi(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $this->backend->display('superadmin/kpi/cs/v_detail_reservasi', $data);
        }
    }

    public function detailUpdateSistem($awal = NULL, $akhir = NULL)
    {
        if ($this->input->post('awal') == NULL) {
            $data['title'] = 'KPI CS (Reservasi)';
            $data['date'] =  $awal . '-' . $akhir;
            $data['resi'] = $this->KpiModel->getUpdateSistem($awal, $akhir);
            $data['awal'] = date('Y-m-d', $awal);
            $data['akhir'] = date('Y-m-d', $akhir);
            // var_dump(date('Y-m', strtotime($tahun . '-' . $bulan)));

        } else {
            $data['title'] = 'KPI CS (Reservasi)';
            $data['date'] = $this->input->post('date');
            $data['awal'] = $this->input->post('awal');
            $data['akhir'] = $this->input->post('akhir');
            $data['resi'] = $this->KpiModel->getUpdateSistem(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
        }
        $this->backend->display('superadmin/kpi/cs/v_detail_update_sistem', $data);
    }
    //END OF KPI CS

    //KPI OPS
    public function ops()
    {
        $data['title'] = 'KPI OPS';
        $data['cs'] = $this->db->get_where('tb_user', array('id_role' => 2));
        if ($this->input->post('awal') == NULL) {
            $data['awal'] = date('Y-m-d');
            $data['akhir'] = date('Y-m-t');

            $data['pickup'] = $this->KpiModel->getSoOps(strtotime(date('Y-m-d')), strtotime(date('Y-m-t'))); //dpne
            $data['delivery'] = $this->KpiModel->getDelivery(strtotime(date('Y-m-d')), strtotime(date('Y-m-t')));
            $data['outbond'] = $this->KpiModel->getOutbond(strtotime(date('Y-m-d')), strtotime(date('Y-m-t')));
            $data['gateway'] = $this->KpiModel->getGateway(strtotime(date('Y-m-d')), strtotime(date('Y-m-t')));
            $data['pod'] = $this->KpiModel->getPodJabodetabek(strtotime(date('Y-m-d')), strtotime(date('Y-m-t')));
            $data['handover'] = $this->KpiModel->getHandover(strtotime(date('Y-m-d')), strtotime(date('Y-m-t')));
            $data['input'] = $this->KpiModel->getInput(strtotime(date('Y-m-d')), strtotime(date('Y-m-t')));
            $data['meetup'] = $this->KpiModel->getVisitOps(strtotime(date('Y-m-d')), strtotime(date('Y-m-t')));
        } else {
            $data['awal'] = $this->input->post('awal');
            $data['akhir'] = $this->input->post('akhir');

            $data['pickup'] = $this->KpiModel->getSoOps(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));//done
            $data['delivery'] = $this->KpiModel->getDelivery(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $data['outbond'] = $this->KpiModel->getOutbond(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $data['gateway'] = $this->KpiModel->getGateway(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $data['pod'] = $this->KpiModel->getPodJabodetabek(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $data['handover'] = $this->KpiModel->getHandover(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $data['input'] = $this->KpiModel->getInput(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $data['meetup'] = $this->KpiModel->getVisitOps(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            // print_r($this->KpiModel->getInput(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')))->result_array());
        }
        $this->backend->display('superadmin/kpi/ops/v_kpi_ops', $data);
        
    }

    public function detailPickup($awal = NULL, $akhir = NULL)
    {
        if ($this->input->post('date') == NULL) {
            $data['awal'] = date('Y-m-d',$awal);
            $data['akhir'] = date('Y-m-d',$akhir);
            $data['title'] = 'KPI OPS (Pickup)';
            $data['pickup'] = $this->KpiModel->getSoOps($awal, $akhir);
            $this->backend->display('superadmin/kpi/ops/v_detail_pickup', $data);
        } else {
            $data['awal'] = $this->input->post('awal');
            $data['akhir'] = $this->input->post('akhir');
            $data['title'] = 'KPI OPS (Pickup)';
            $data['pickup'] = $this->KpiModel->getSoOps(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $this->backend->display('superadmin/kpi/ops/v_detail_pickup', $data);
        }
    }

    public function detailDelivery($awal = NULL, $akhir = NULL)
    {
        if ($this->input->post('date') == NULL) {
            $data['awal'] = date('Y-m-d',$awal);
            $data['akhir'] = date('Y-m-d',$akhir);
            $data['title'] = 'KPI OPS (Pickup)';
            $data['delivery'] = $this->KpiModel->getDelivery($awal, $akhir);
            $this->backend->display('superadmin/kpi/ops/v_detail_delivery', $data);
        } else {
            $data['awal'] = $this->input->post('awal');
            $data['akhir'] = $this->input->post('akhir');
            $data['title'] = 'KPI OPS (Pickup)';
            $data['delivery'] = $this->KpiModel->getDelivery(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $this->backend->display('superadmin/kpi/ops/v_detail_delivery', $data);
        }
    }

    public function detailOutbond($awal = NULL, $akhir = NULL)
    {
        if ($this->input->post('date') == NULL) {
            $data['awal'] = date('Y-m-d',$awal);
            $data['akhir'] = date('Y-m-d',$akhir);
            $data['title'] = 'KPI OPS (Outbond)';
            $data['outbond'] = $this->KpiModel->getOutbond($awal, $akhir);
            $this->backend->display('superadmin/kpi/ops/v_detail_outbond', $data);
        } else {
            $data['awal'] = $this->input->post('awal');
            $data['akhir'] = $this->input->post('akhir');
            $data['title'] = 'KPI OPS (outbond)';
            $data['date'] = $this->input->post('date');
            $data['outbond'] = $this->KpiModel->getOutbond(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $this->backend->display('superadmin/kpi/ops/v_detail_outbond', $data);
        }
    }
    public function detailPod($awal = NULL, $akhir = NULL)
    {
        if ($this->input->post('date') == NULL) {
            $data['awal'] = date('Y-m-d',$awal);
            $data['akhir'] = date('Y-m-d',$akhir);
            $data['title'] = 'KPI OPS (POD)';
            $data['pod'] = $this->KpiModel->getPodJabodetabek($awal, $akhir);
            $this->backend->display('superadmin/kpi/ops/v_detail_podJabodetabek', $data);
        } else {
            $data['awal'] = $this->input->post('awal');
            $data['akhir'] = $this->input->post('akhir');
            $data['title'] = 'KPI OPS (POD)';
            $data['date'] = $this->input->post('date');
            $data['pod'] = $this->KpiModel->getPodJabodetabek(strtotime($this->input->post('awal')), strtotime($this->input->post('akhir')));
            $this->backend->display('superadmin/kpi/ops/v_detail_podJabodetabek', $data);
        }
    }



    // public function test()
    // {
    //     // Set your CSV feed
    //     $feed = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTCs3uD17VT-stCbrk49pp30YW38H6mGOlZDAWlQWjiIMUwVuU7Qz_Nz6QLCfYX3T9qgeT_aL4iLyZz/pub?output=csv';

    //     // Arrays we'll use later
    //     $keys = array();
    //     $newArray = array();

    //     // Function to convert CSV into associative array
    //     function csvToArray($file, $delimiter)
    //     {
    //         if (($handle = fopen($file, 'r')) !== FALSE) {
    //             $i = 0;
    //             while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
    //                 for ($j = 0; $j < count($lineArray); $j++) {
    //                     $arr[$i][$j] = $lineArray[$j];
    //                 }
    //                 $i++;
    //             }
    //             fclose($handle);
    //         }
    //         return $arr;
    //     }

    //     // Do it
    //     $data = csvToArray($feed, ',');

    //     // Set number of elements (minus 1 because we shift off the first row)
    //     $count = count($data) - 1;

    //     //Use first row for names  
    //     $labels = array_shift($data);

    //     foreach ($labels as $label) {
    //         $keys[] = $label;
    //     }

    //     // Add Ids, just in case we want them later
    //     $keys[] = 'id';

    //     for ($i = 0; $i < $count; $i++) {
    //         $data[$i][] = $i;
    //     }

    //     // Bring it all together
    //     for ($j = 0; $j < $count; $j++) {
    //         $d = array_combine($keys, $data[$j]);
    //         $newArray[$j] = $d;
    //     }

    //     foreach ($newArray as $n) {
    //         echo $n['nama'] . '<br>';
    //         echo $n['leadtime'] . '<br>';
    //         echo $n['harga'] . '<br>';
    //     }
    // }
}
