<?php


defined('BASEPATH') or exit('No direct script access allowed');

class RequestPrice extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id_user')) {
            redirect('backoffice');
        }
        $this->load->model('PengajuanModel', 'order');
        $this->load->model('SalesModel', 'sales');
        $this->load->model('Sendwa', 'wa');
        // $this->load->model('RequestPriceModel');

        cek_role();
    }
    public function index($awal = NULL, $akhir = NULL)
    {
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $dayNow = date('d');
        $monthNow = date('m');
        $yearNow = date('Y');
        if ($awal == NULL) {
            $awal = date('Y-m-d', strtotime($yearNow . '-' . $monthNow . '-' . '1'));
            $akhir = date('Y-m-t');

            $data['awal'] = $awal;
            $data['akhir'] = $akhir;
            $data['title'] = 'Request Price';
            $data['requestPrice'] = $this->sales->getRequestPriceNotApprove($this->session->userdata('id_user'), $awal, $akhir);
            $data['requestPriceApprove'] = $this->sales->getRequestPriceApprove($this->session->userdata('id_user'), $awal, $akhir);
            $data['province'] = $this->db->get('tb_province')->result_array();
            $data['city'] = $this->db->get('tb_city')->result_array();
            $this->backend->display('sales/v_request_price', $data);
        } else {
            $data['awal'] = $awal;
            $data['akhir'] = $akhir;
            $data['title'] = 'Request Price';
            $data['requestPrice'] = $this->sales->getRequestPriceNotApprove($this->session->userdata('id_user'), $awal, $akhir);
            $data['requestPriceApprove'] = $this->sales->getRequestPriceApprove($this->session->userdata('id_user'), $awal, $akhir);
            $data['province'] = $this->db->get('tb_province')->result_array();
            $data['city'] = $this->db->get('tb_city')->result_array();
            $this->backend->display('sales/v_request_price', $data);
        }
    }

    public function addNewRequest()
    {
        $request = [
            'id_sales' => $this->session->userdata('id_user'),
            'date_request' => date('Y-m-d H:i:s'),
            'province_from' => $this->input->post('province_from'),
            'city_from' => $this->input->post('city_from'),
            'province_to' => $this->input->post('province_to'),
            'city_to' => $this->input->post('city_to'),
            'moda' => $this->input->post('moda'),
            'jenis_barang' => $this->input->post('jenis'),
            'berat' => $this->input->post('berat'),
            'panjang' => $this->input->post('panjang'),
            'lebar' => $this->input->post('lebar'),
            'tinggi' => $this->input->post('tinggi'),
            'notes_sales' => $this->input->post('notes'),
        ];


        $update = $this->db->insert('tbl_request_price', $request);
        if ($update) {
            $pesan = "Hallo Finance, ada pengajuan harga baru dari " . $this->session->userdata('nama_user') . " Tolong Segera Cek Ya, Terima Kasih";
            $this->wa->pickup('+6285697780467', "$pesan");
            $this->session->set_flashdata('message', 'Anda Berhasil Menambah Request');
            redirect('sales/RequestPrice');
        }
    }

    public function deleteRequestPrice($id)
    {
        if ($this->db->delete('tbl_request_price', array('id_request_price' => $id))) {
            $this->session->set_flashdata('message', 'Berhasil Menghapus');
            redirect('sales/RequestPrice');
        }
    }
}
