<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Outbond extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $this->load->model('M_Datatables2');
        $this->load->model('M_Datatables');
        $this->load->library('form_validation');
        $this->load->model('PengajuanModel', 'order');
        $this->load->model('SalesModel', 'sales');
        $this->load->model('Api');
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        cek_role();
    }

    public function index()
    {
        $data['title'] = 'Scan';

        // $data['outbond'] = $this->db->query('SELECT shipment_id,shipper,consigne,bagging,is_jabodetabek,delivery_status,delivery_by,service_type FROM tbl_shp_order WHERE outbond_status = 1 AND reason_delete IS NULL');
        $data['users'] = $this->db->query('SELECT id_user,nama_user FROM tb_user WHERE id_role = 2')->result_array();

        $this->backend->display('outbond/listOutbond', $data);
        // $this->load->view('dispatcher/v_shipment', $data);
    }

    public function scanBarcodeOutbond()
    {

        $shipment = $this->db->query('SELECT outbond_status,id_so FROM tbl_shp_order WHERE shipment_id = ' . $this->input->post('hasilscan') . ' ')->row_array();

        if ($shipment) {
            if ($shipment['outbond_status'] == NULL) {
                $this->db->update('tbl_shp_order', ['outbond_status' => 1], ['shipment_id' => $this->input->post('hasilscan')]);
                $dataTracking = [
                    'status' => ucwords(strtolower("paket telah tiba di hub jakarta pusat")),
                    'id_so' => $shipment['id_so'],
                    'shipment_id' => $this->input->post('hasilscan'),
                    'created_at' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'flag' => 5,
                    'status_eksekusi' => 1,
                    'id_user' => $this->session->userdata('id_user'),
                ];
                $this->db->insert('tbl_tracking_real', $dataTracking);

                $dataOutbond = [
                    'shipment_id' => $this->input->post('hasilscan'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('id_user'),
                    'in_date' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('tbl_outbond', $dataOutbond);
            }
        }


        redirect('shipper/Outbond');
    }

    public function bagging()
    {
        $data['title'] = 'Bagging';


        $data['bagging'] = $this->db->query('SELECT * FROM bagging WHERE is_deleted = 0 AND status_bagging < 2 ORDER BY id_bagging DESC');
        $this->backend->display('outbond/bagging', $data);
        // $this->load->view('dispatcher/v_shipment', $data);
    }

    public function doBagging()
    {
        $shipment_id = $this->input->post('shipment_id');

        if (sizeof($shipment_id) == 0) {
            redirect('shipper/Outbond');
        } else {

            $first_value = $this->db->query('SELECT service_type FROM tbl_shp_order WHERE shipment_id = ' . $shipment_id[0] . ' ')->row_array();

            $bagging = array();
            for ($i = 0; $i < sizeof($shipment_id); $i++) {
                $dataShipment = $this->db->query('SELECT shipper,consigne,shipment_id,service_type FROM tbl_shp_order WHERE shipment_id = ' . $shipment_id[$i] . ' ')->row_array();
                $bagging[] = $dataShipment;
                if ($dataShipment['service_type'] != $first_value['service_type']) {
                    redirect('shipper/Outbond');
                }
            }

            $data = [
                'bagging' => $bagging
            ];

            $this->backend->display('outbond/doBagging', $data);
        }
    }

    public function processBagging()
    {
        $shipment_id = $this->input->post('shipment_id');
        $dataBagging = [
            'status_bagging' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('id_user'),
            'smu' => $this->input->post('smu')
        ];
        $this->db->insert('bagging', $dataBagging);
        $id_bagging = $this->db->insert_id();
        for ($i = 0; $i < sizeof($shipment_id); $i++) {

            $dataUpdateShipment = [
                'bagging' => $id_bagging
            ];
            $this->db->update('tbl_shp_order', $dataUpdateShipment, ['shipment_id' => $shipment_id[$i]]);
        }

        redirect('shipper/Outbond');
    }

    public function printBagging($bagging)
    {
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [74, 105]]);
        $data = [
            'bagging' => $this->db->get_where('bagging', ['id_bagging' => $bagging])->row_array(),
            'resi' => $this->db->query('SELECT shipment_id FROM tbl_shp_order WHERE bagging = ' . $bagging . ' ')
        ];
        $data = $this->load->view('outbond/dokumenBagging', $data, TRUE);
        $mpdf->WriteHTML($data);
        $mpdf->Output('Bagging-' . $bagging, 'I');
        // $this->load->view('outbond/dokumenBagging', $data);
    }

    public function dispatchBagging()
    {
        $id_bagging = $this->input->post('hasilscan');
        $bagging = $this->db->query('SELECT status_bagging FROM bagging WHERE id_bagging = ' . $id_bagging . ' ')->row_array();
        if ($bagging && $bagging['status_bagging'] == 1) {
            $updateBagging = $this->db->update('bagging', ['status_bagging' => 2], ['id_bagging' => $id_bagging]);

            if ($updateBagging) {
                $resi = $this->db->query('SELECT shipment_id,id_so FROM tbl_shp_order WHERE bagging = ' . $id_bagging . ' ')->result_array();
                foreach ($resi as $resi1) {
                    $updateResi = $this->db->update('tbl_shp_order', ['outbond_status' => 2], ['shipment_id' => $resi1['shipment_id']]);
                    if ($updateResi) {
                        $dataTracking = [
                            'status' => ucwords(strtolower("paket telah keluar dari hub jakarta pusat")),
                            'id_so' => $resi1['id_so'],
                            'shipment_id' => $resi1['shipment_id'],
                            'created_at' => date('Y-m-d'),
                            'time' => date('H:i:s'),
                            'flag' => 6,
                            'status_eksekusi' => 1,
                            'id_user' => $this->session->userdata('id_user'),
                        ];
                        $this->db->insert('tbl_tracking_real', $dataTracking);
                    }
                }
                redirect('shipper/Outbond/bagging');
            } else{
                redirect('shipper/Outbond/bagging');
            }
        }
    }



    public function voidBagging($id)
    {

        $voidBegging = $this->db->update('bagging', ['is_deleted' => 1], ['id_bagging' => $id]);

        if ($voidBegging) {
            $shipment = $this->db->query('SELECT shipment_id FROM tbl_shp_order WHERE bagging = ' . $id . ' ')->result_array();
            foreach ($shipment as $shipment1) {
                $this->db->update('tbl_shp_order', ['bagging' => NULL], ['shipment_id' => $shipment1['shipment_id']]);
            }
            redirect('shipper/Outbond/bagging');
        }
    }

    public function assignDriverDelivery()
    {
        $dataUpdateDelivery = [
            'delivery_status' => 1,
            'delivery_by' => $this->input->post('id_driver')
        ];
        $updateDelivery = $this->db->update('tbl_shp_order', $dataUpdateDelivery, ['shipment_id' => $this->input->post('shipment_id')]);
        if ($updateDelivery) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Assign Driver</div>');
            redirect('shipper/Outbond');
        }
    }
    public function listDataOutbond()
{
    $search = array('a.shipment_id');
    $query  = "SELECT a.shipment_id, a.shipper, a.consigne, IFNULL(a.bagging, 0) AS bagging, a.is_jabodetabek, IFNULL(a.delivery_status, 0) AS delivery_status, IFNULL(a.delivery_by, 0) AS delivery_by, a.service_type, b.service_name, IFNULL(c.nama_user, 0) AS nama_user 
               FROM tbl_shp_order AS a 
               LEFT JOIN tb_service_type AS b ON a.service_type = b.code 
               LEFT JOIN tb_user AS c ON a.delivery_by = c.id_user 
               LEFT JOIN bagging AS d ON a.bagging = d.id_bagging";
    $where  = array('a.outbond_status' => 1, 'a.deleted' => 0);
    $isWhere = null;

    header('Content-Type: application/json');
    echo $this->M_Datatables->get_tables_query2($query, $search, $where, $isWhere);
}
}
