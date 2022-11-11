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
        $data['title'] = 'Sales Tracker Report';
        $data['users'] = $this->db->get_where('tb_user', ['id_role' => 4])->result_array();
        if ($awal == NULL && $akhir == NULL) {

            $data['awal'] = NULL;
            $data['akhir'] = NULL;
            if ($sales == NULL) {
                $data['salestracker'] = $this->sales->getAllReportSalesTracker(0)->result_array();
                $data['sales'] = 0;
            } else {
                $data['salestracker'] = $this->sales->getAllReportSalesTracker($sales)->result_array();
                $data['sales'] = $sales;
            }
        } else {
            $data['awal'] = $awal;
            $data['akhir'] = $akhir;
            if ($sales == NULL) {
                $data['salestracker'] = $this->sales->getReportSalesTracker($awal, $akhir, 0)->result_array();
                $data['sales'] = 0;
            } else {
                $data['salestracker'] = $this->sales->getReportSalesTracker($awal, $akhir, $sales)->result_array();
                $data['sales'] = $sales;
            }
        }
        $this->backend->display('superadmin/v_salestracker_report', $data);
    }
}
