<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pod extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id_user')) {
            redirect('backoffice');
        }
        $this->load->model('PengajuanModel');
        $this->load->model('PodModel', 'pod');
        cek_role();
    }
    public function index()
    {
        if ($this->input->post('shipment_id') == NULL) {
            $data['title'] = 'POD';
            $data['resi'] = NULL;
            $data['shipment'] = NULL;
            $this->backend->display('cs/v_scan_pod', $data);
        } else {
            redirect('cs/Pod/scan/' . $this->input->post('shipment_id'));
        }
    }

    public function list()
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
            $data['title'] = 'POD';
            $data['shipment'] = $this->pod->getListPod($awal, $akhir);
            $data['shipmentOtw'] = $this->pod->getListPod($awal, $akhir);
            $data['shipmentArrive'] = $this->pod->getListPod($awal, $akhir);
            $this->backend->display('cs/v_list_pod', $data);
        } else {
            $data['awal'] = $awal;
            $data['akhir'] = $akhir;
            $data['title'] = 'POD';
            $data['shipment'] = $this->pod->getListPod($awal, $akhir);
            $data['shipmentOtw'] = $this->pod->getListPod($awal, $akhir);
            $data['shipmentArrive'] = $this->pod->getListPod($awal, $akhir);
            $this->backend->display('cs/v_list_pod', $data);
        }
    }

    public function scan($resi)
    {
        $data['title'] = 'POD';
        $data['resi'] = $resi;
        $data['shipment'] = $this->db->get_where('tbl_shp_order', array('shipment_id' => $resi))->row_array();
        $this->backend->display('cs/v_scan_pod', $data);
    }

    public function otw()
    {
        $dataPod = [
            'created_by' => $this->session->userdata('nama_user'),
            'shipment_id' => $this->input->post('shipment_id'),
            'tgl_otw' => $this->input->post('tgl_otw'),
            'provider' => $this->input->post('provider'),
            'resi' => $this->input->post('resi'),
        ];
        if ($this->db->insert('tbl_tracking_pod', $dataPod)) {
            if ($this->db->update('tbl_shp_order', array('status_pod' => 1), array('shipment_id' => $this->input->post('shipment_id')))) {
                $this->session->set_flashdata("success", "Update Success");
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function arrive()
    {
        $dataArrive = array(
            'tgl_sampe' => $this->input->post('tgl_sampe'),
            'penerima' => $this->input->post('penerima'),
        );
        if ($this->db->update('tbl_tracking_pod', $dataArrive, array('shipment_id' => $this->input->post('shipment_id')))) {
            if ($this->db->update('tbl_shp_order', array('status_pod' => 2), array('shipment_id' => $this->input->post('shipment_id')))) {
                $this->session->set_flashdata("success", "Update Success");
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}
