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
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model('PengajuanModel', 'order');
        $this->load->model('CsModel', 'cs');

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
            $data['requestPrice'] = $this->cs->getRequestPriceNotApprove($awal, $akhir);
            $data['requestPriceApprove'] = $this->cs->getRequestPriceApprove($awal, $akhir);
            $data['province'] = $this->db->get('tb_province')->result_array();
            $data['city'] = $this->db->get('tb_city')->result_array();
            $this->backend->display('cs/v_request_price', $data);
        } else {
            $data['awal'] = $awal;
            $data['akhir'] = $akhir;
            $data['title'] = 'Request Price';
            $data['requestPrice'] = $this->cs->getRequestPriceNotApprove($awal, $akhir);
            $data['requestPriceApprove'] = $this->cs->getRequestPriceApprove($awal, $akhir);
            $data['province'] = $this->db->get('tb_province')->result_array();
            $data['city'] = $this->db->get('tb_city')->result_array();
            $this->backend->display('cs/v_request_price', $data);
        }
    }
    public function addPrice()
    {
        $price = [
            'price' => $this->input->post('price'),
            'notes_cs' => $this->input->post('notes_cs'),
            'id_cs' => $this->session->userdata('id_user'),
            'date_approved' => date('Y-m-d H:i:s')
        ];
        if ($this->db->update('tbl_request_price', $price, array('id_request_price' => $this->input->post('id')))) {
            $this->session->set_flashdata('message', 'Berhasil');
            redirect('cs/RequestPrice');
        }
    }


    public function deleteRequestPrice($id)
    {
        if ($this->db->delete('tbl_request_price', array('id_request_price' => $id))) {
            $this->session->set_flashdata('message', 'Berhasil Menghapus');
            redirect('cs/RequestPrice');
        }
    }
}
