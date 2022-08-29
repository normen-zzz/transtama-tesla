<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scan2 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $this->load->model('M_Datatables');
        $this->load->library('form_validation');
        // $this->getDataWisuda();
        $this->load->model('PengajuanModel', 'order');
        $this->load->model('SalesModel', 'sales');
        $this->load->model('Api');
    }

    public function index()
    {
        $data['title'] = 'Sales Order';
        $this->backend->display('dispatcher/v_shipment2', $data);
        // $this->load->view('dispatcher/v_shipment', $data);
    }
    function cek_id()
    {
        $id_user = $this->session->userdata('id_user');
        $result_code = $this->input->post('id_karyawan');
        // CEK APAKAHA ADA TUGAS YG BELUM DI SCAN
        $cek_tracking = $this->db->limit(1)->order_by('id_tracking', 'desc')->get_where('tbl_tracking_real', ['shipment_i' => $result_code])->row_array();

        if ($cek_tracking) {
            // scan in
            if ($cek_tracking['flag'] == 7) {
                $data = array(
                    'status' => "Shipment Telah Tiba Di Hub Benhil",
                    'id_so' => $cek_tracking['id_so'],
                    'shipment_id' => $result_code,
                    'id_user' => 'NULL',
                    'created_at' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'flag' => 8,
                );
                $this->db->insert('tbl_tracking_real', $data);
                // scan out
            } elseif ($cek_tracking['flag'] == 8) {
                $data = array(
                    'status' => "Shipment Telah Tiba Di Hub Benhil",
                    'id_so' => $cek_tracking['id_so'],
                    'shipment_id' => $result_code,
                    'id_user' => 'NULL',
                    'created_at' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'flag' => 9,
                );
                $this->db->insert('tbl_tracking_real', $data);
            } else {
                $this->session->set_flashdata('message', 'No Data');
                redirect('scan2');
            }
        } else {
            $this->session->set_flashdata('message', 'No shipment with this QC');
            redirect('scan2');
        }
    }
}
