<?php


defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RequestPrice extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id_user')) {
            redirect('backoffice');
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model('PengajuanModel', 'order');
        $this->load->model('SalesModel', 'sales');
        $this->load->model('Sendwa', 'wa');
        $this->load->model('WilayahModel', 'wilayah');
        // $this->load->model('RequestPriceModel')

        cek_role();
    }
    public function index()
    {
        $data['title'] = 'Request Price';
        $data['detailRequestPrice'] = $this->sales->getDetailRequestPrice();
        $this->backend->display('cs/requestprice/v_request_price', $data);
    }



    public function detailRequestPrice($id)
    {
        $data['title'] = 'Request Price';
        $data['provinsi'] = $this->db->get('tb_province');
        $data['kota'] = $this->db->get('tb_city');
        $data['moda'] = $this->db->get('tbl_moda');
        $data['customer'] = $this->db->get('tb_customer');
        $data['detailRequestPrice'] = $this->sales->getDetailRequestPrice(NULL, $id)->row_array();
        $this->backend->display('cs/requestprice/v_detailRequestPrice', $data);
    }

    public function addPriceProcess()
    {
        $id_detailrequest = $this->input->post('id_detailrequest');
        $price = $this->input->post('price');
        $notes_cs = $this->input->post('notes_cs');

        $update = $this->db->update('detailrequest_price', ['price' => $price, 'notes_cs' => $notes_cs, 'status' => 1], ['id_detailrequest' => $id_detailrequest]);
        if ($update) {
            $log = [
                'id_detailrequestprice' => $id_detailrequest,
                'log' => 'Harga Telah Diinput',
                'user' => $this->session->userdata('id_user'),
                'date' => date('Y-m-d H:i:s')
            ];
            $updateLog = $this->db->insert('requestprice_log', $log);
            if ($updateLog) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Add Price</div>');
                redirect('cs/RequestPrice');
            }
        }
    }

    public function getModalEditRequest()
    {
        $id_request = $this->input->get('id_request'); // Mengambil ID dari parameter GET
        $request = $this->db->get_where('tbl_request_price', array('id_request_price' => $id_request))->row();

        // Kirim data sebagai respons JSON
        echo json_encode($request);
    }

    public function getdate()
    {
        var_dump(date('Y-m-t H:i:s'));
    }

    public function declineCs() {
        $id_detailrequest = $this->input->post('id_detailrequest');
        $notes_decline_cs = $this->input->post('notes_decline_cs');
       

        $update = $this->db->update('detailrequest_price', ['notes_decline_cs' => $notes_decline_cs, 'status' => 5], ['id_detailrequest' => $id_detailrequest]);
        if ($update) {
            $log = [
                'id_detailrequestprice' => $id_detailrequest,
                'log' => 'Request Telah di decline Oleh Cs',
                'user' => $this->session->userdata('id_user'),
                'date' => date('Y-m-d H:i:s')
            ];
            $updateLog = $this->db->insert('requestprice_log', $log);
            if ($updateLog) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Decline</div>');
                redirect('cs/RequestPrice');
            }
        }
    }
}
