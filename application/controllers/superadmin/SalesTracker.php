<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SalesTracker extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id_user')) {
            redirect('backoffice');
        }
        $this->load->model('UserModel');
        cek_role();
        $this->load->model('SalesModel', 'sales');
    }


    public function index()
    {
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $sales = $this->input->post('sales');
        $onGoing = 0;
        $held = 0;
        $data['title'] = 'Sales Tracker Report';
        $data['users'] = $this->db->get_where('tb_user', ['status' => 1])->result_array();
        if ($awal == NULL && $akhir == NULL) {
            $data['awal'] = NULL;
            $data['akhir'] = NULL;
            if ($sales == NULL) {
                $data['salestracker'] = $this->sales->getAllReportSalesTracker(0);
                $data['sales'] = 0;
            } else {
                $data['salestracker'] = $this->sales->getAllReportSalesTracker($sales);
                $data['sales'] = $sales;
            }
            foreach ($data['salestracker']->result_array() as $r) {
                if ($r['end_date'] != NULL) {
                    $held += 1;
                } else {
                    $onGoing += 1;
                }
            }
        } else {
            $data['awal'] = $awal;
            $data['akhir'] = $akhir;
            if ($sales == NULL) {
                $data['salestracker'] = $this->sales->getReportSalesTracker($awal, $akhir.' 23:59:00', 0);
                $data['sales'] = 0;
            } else {
                $data['salestracker'] = $this->sales->getReportSalesTracker($awal, $akhir.' 23:59:00', $sales);
                $data['sales'] = $sales;
            }
            foreach ($data['salestracker']->result_array() as $r) {
                if ($r['end_date'] != NULL) {
                    $held += 1;
                } else {
                    $onGoing += 1;
                }
            }
        }
        $data['ongoing'] = $onGoing;
        $data['held'] = $held;
        // var_dump($data['salestracker']->result_array());
        $this->backend->display('superadmin/v_salestracker_report', $data);
    }
}
