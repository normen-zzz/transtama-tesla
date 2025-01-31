<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $this->load->model('M_Datatables');
        $this->load->library('form_validation');
        $this->load->model('PengajuanModel', 'order');
        $this->load->model('SalesModel', 'sales');
        $this->load->model('Api');
    }

    public function index()
    {
        $data['title'] = 'Scan';
        $data['bagging'] = $this->db->query('SELECT * FROM BAGGING AS a LEFT JOIN tbl_shp_order AS b ON a.id_bagging = b.bagging  WHERE a.is_deleted = 0 AND a.status_bagging = 3 AND (b.service_type = "f4e0915b-7487-4fae-a04c-c3363d959742" 
         OR b.service_type = "3c8b5fdd11cb10506705c16773204f8a") ');
        $this->backend->display('dispatcher/v_shipment', $data);
        // $this->load->view('dispatcher/v_shipment', $data);
    }
    public function history()
    {
        $data['title'] = 'History Task';
        $data['gateway'] = $this->order->dispatchHistory()->result_array();
        $this->backend->display('dispatcher/v_history_shipment', $data);
    }
    public function scanInBagging()
    {
        $id_bagging = $this->input->post('hasilscan');
        $bagging = $this->db->query('SELECT status_bagging,id_bagging FROM bagging WHERE id_bagging = ' . $id_bagging . ' ')->row_array();

        if ($bagging) {
            if ($bagging['status_bagging'] == 2) {
                $updateBagging = $this->db->update('bagging', ['status_bagging' => 3, 'dispatcher_in' => date('Y-m-d H:i:s')], ['id_bagging' => $id_bagging]);
                if ($updateBagging) {
                    $resi = $this->db->query('SELECT shipment_id,id_so FROM tbl_shp_order WHERE bagging = ' . $id_bagging . ' ')->result_array();

                    foreach ($resi as $resi1) {
                        $dataTracking = [
                            'status' => ucwords(strtolower("paket telah tiba di hub CGK")),
                            'id_so' => $resi1['id_so'],
                            'shipment_id' => $resi1['shipment_id'],
                            'created_at' => date('Y-m-d'),
                            'time' => date('H:i:s'),
                            'flag' => 7,
                            'status_eksekusi' => 1,
                            'id_user' => $this->session->userdata('id_user'),
                        ];
                        $this->db->insert('tbl_tracking_real', $dataTracking);
                    }
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Bagging ' . $bagging['id_bagging'] . ' berhasil scan in</div>');
                    redirect('dispatcher/scan');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Bagging ' . $bagging['id_bagging'] . ' belum discan out outbond</div>');
                redirect('dispatcher/scan');
            }
        }
    }

    public function doScanOut($id_bagging)
    {
        $bagging = $this->db->get_where('bagging', ['id_bagging' => $id_bagging])->row_array();
        $data = [
            'bagging' => $bagging,
            'resi' => $this->db->query('SELECT shipment_id,shipper,city_consigne,state_consigne FROM tbl_shp_order WHERE bagging = '.$id_bagging.' ')
        ];
        $this->backend->display('dispatcher/doScanOut', $data);
    }

    public function processScanOut($id_bagging)
    {
        $dataScanOut = [
            'no_flight' => $this->input->post('no_flight'),
            'flight_at' => date('Y-m-d H:i:s', strtotime($this->input->post('flight_at'))),
            'status_bagging' => 4,
            'dispatcher_out' =>  date('Y-m-d H:i:s')
        ];

        $updateBagging = $this->db->update('bagging', $dataScanOut, ['id_bagging' => $id_bagging]);
        if ($updateBagging) {
            redirect('dispatcher/scan');
        }
    }
}
