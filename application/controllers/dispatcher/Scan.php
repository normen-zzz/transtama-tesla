<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
setlocale(LC_TIME, "id_ID.UTF8");

class Scan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id_user')) {
            redirect('backoffice');
        }
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
        $data['gateway'] = $this->order->dispatch()->result_array();
        $this->backend->display('dispatcher/v_shipment', $data);
        // $this->load->view('dispatcher/v_shipment', $data);
    }
    public function history()
    {
        $data['title'] = 'History Task';
        $data['order'] = $this->order->dispatchHistory()->result_array();
        $this->backend->display('dispatcher/v_history_shipment2', $data);
    }
    function querydispatchhistory()
    {
        // $query  = "SELECT t1.shipment_id,t1.`created_at` AS 'tgl_masuk', t1.status,t2.created_at AS 'tgl_keluar',t1.status_eksekusi , t2.status,t3.`tgl_pickup`,t3.`shipper`,t3.`consigne`,t3.tgl_pickup
        // FROM tbl_gateway t1
        // JOIN (SELECT shipment_id, MAX(STATUS) AS STATUS,MAX(created_at) AS created_at FROM tbl_gateway GROUP BY shipment_id) t2
        //     ON t1.shipment_id = t2.shipment_id JOIN tbl_shp_order t3 ON t1.`shipment_id` = t3.`shipment_id`";

        $query = "SELECT a.shipper,a.consigne,a.tree_shipper,a.tree_consignee,b.status as sts,b.is_incoming,b.id_gateway,b.created_at,b.shipment_id,b.status_eksekusi,b.created_at FROM tbl_shp_order a JOIN tbl_gateway b ON a.shipment_id = b.shipment_id";
        $search = array('a.shipment_id', 'a.shipper', 'a.consigne');
        $where  = array('b.status_eksekusi' => 1, 'b.status' => 'out');
        // $where  = array('a.id_user' => $this->session->userdata('id_user'));

        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }

    public function processSubmitHistory()
    {
        $shipment_id = $this->input->post('shipment_id');
        $no_flight = $this->input->post('no_flight');
        $no_smu = $this->input->post('no_smu');
        $status_flight = $this->input->post('status_flight');
        $etd = $this->input->post('etd');
        $eta = $this->input->post('eta');

        for ($i = 0; $i < sizeof($shipment_id); $i++) {
            $data = array(
                'no_flight' => $no_flight,
                'no_smu' => $no_smu,
                'status_flight' => $status_flight,
                'etd' => $etd,
                'eta' => $eta
            );
            $this->db->update('tbl_gateway', $data, array('shipment_id' => $shipment_id[$i]));
        }
        $this->session->set_flashdata('message', 'Success');
        redirect('dispatcher/Scan/history');
    }
    function cek_id()
    {
        // $result_code = $this->input->post('id_karyawan');
        $result_code = $this->input->post('shipment_id');
        // untuk gateway
        // CEK APAKAH ADA TUGAS YG BELUM DI SCAN
        $cek_task_gateway = $this->db->limit(1)->order_by('id_gateway', 'desc')->get_where('tbl_gateway', ['shipment_id' => $result_code, 'status_eksekusi' => 0])->row_array();

        if ($cek_task_gateway) {
            // $cek_tracking = $this->db->limit(1)->order_by('id_tracking', 'desc')->get_where('tbl_tracking_real', ['shipment_id' => $result_code])->row_array();
            if ($cek_task_gateway['status'] == 'in') {
                $status = '';
                // cek servicenya
                if ($cek_task_gateway['service'] == 'Sea Service' || $cek_task_gateway['service'] == 'Regular Service') {
                    $status = "Shipment Telah Tiba Di Hub Jakarta Utara";
                } else {
                    $status = "Shipment Telah Tiba Di Hub CGK";
                }
                $data = array(
                    'status' => $status,
                    'id_so' => $cek_task_gateway['id_so'],
                    'shipment_id' => $result_code,
                    'note' => null,
                    'id_user' => $this->session->userdata('id_user'),
                    'created_at' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'flag' => 6,
                    'status_eksekusi' => 1
                );
                $insert = $this->db->insert('tbl_tracking_real', $data);
                if ($insert) {
                    $data = array(
                        'shipment_id' => $result_code,
                        'id_user' => $this->session->userdata('id_user'),
                        'status' => 'out',
                        'is_incoming' => $this->input->post('is_incoming'),
                        // 'note' => $cek_tracking['note'],
                        'id_so' => $cek_task_gateway['id_so'],
                        'service' => $cek_task_gateway['service'],
                        'status_eksekusi' => 0
                    );
                    $this->db->insert('tbl_gateway', $data);
                    $data = array(
                        'status_eksekusi' => 1
                    );
                    $this->db->update('tbl_gateway', $data, ['id_gateway' => $cek_task_gateway['id_gateway']]);
                    $this->session->set_flashdata('message', 'Success');
                    redirect('dispatcher/scan');
                } else {
                    $this->session->set_flashdata('message', 'Failed');
                    redirect('dispatcher/scan');
                }
            } else {
                $status = '';
                // cek servicenya
                if ($cek_task_gateway['service'] == 'Sea Service' || $cek_task_gateway['service'] == 'Regular Service') {
                    $status = "Shipment Telah Keluar Dari Hub Jakarta Utara";
                } else {
                    $status = "Shipment Telah Keluar Dari Hub CGK";
                }
                $data = array(
                    'status' => $status,
                    'id_so' => $cek_task_gateway['id_so'],
                    'shipment_id' => $result_code,
                    'id_user' => $this->session->userdata('id_user'),
                    'created_at' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'flag' => 7,
                    'status_eksekusi' => 1
                );
                $insert = $this->db->insert('tbl_tracking_real', $data);
                if ($insert) {
                    $data = array(
                        'status_eksekusi' => 1
                    );
                    $this->db->update('tbl_gateway', $data, ['id_gateway' => $cek_task_gateway['id_gateway']]);
                    // 1= delivery
                    // 2= ke hub
                    $data = array(
                        'is_delivery' => $this->input->post('is_delivery')
                    );
                    $this->db->update('tbl_shp_order', $data, ['shipment_id' => $result_code]);
                    $this->session->set_flashdata('message', 'Success');
                    redirect('dispatcher/scan');
                } else {
                    $this->session->set_flashdata('message', 'Failed');
                    redirect('dispatcher/scan');
                }
            }
        } else {
            $this->session->set_flashdata('message', 'No shipment with this QC');
            redirect('dispatcher/scan');
        }
    }
}
