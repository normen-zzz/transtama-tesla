<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ap extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ApModel', 'ap');
    }

    public function getDataCa()
    {
        $ca = $this->input->post('nomor_ca');
        $this->db->select('amount_approved')->from('tbl_pengeluaran')->where('no_pengeluaran', $ca);
        $dataCa = $this->db->get();
        $period_array = array();
        foreach ($dataCa->result_array() as $row) {
            $period_array[] = intval($row['amount_approved']); //can it be float also?
        }
        echo array_sum($period_array);
    }
}
