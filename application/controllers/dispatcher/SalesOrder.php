<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SalesOrder extends CI_Controller
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
        // $this->getDataWisuda();
        $this->load->model('PengajuanModel', 'order');
        $this->load->model('SalesModel', 'sales');
        $this->load->model('Api');
        cek_role();
    }

    public function index()
    {
        $data['title'] = 'Sales Order';
        $this->backend->display('dispatcher/v_shipment', $data);
        // $this->load->view('dispatcher/v_shipment', $data);
    }
    function cek_id()
    {
        $id_user = $this->session->userdata('id_user');
        $result_code = $this->input->post('id_karyawan');
        // CEK APAKAHA ADA TUGAS YG BELUM DI SCAN
        $cek_task_gateway = $this->db->limit(1)->order_by('id_gateway', 'desc')->get_where('tbl_gateway', ['id_user' => $id_user, 'shipment_id' => $result_code, 'status_eksekusi' => 0])->row_array();
        if ($cek_task_gateway) {
            $cek_tracking = $this->db->limit(1)->order_by('id_tracking', 'desc')->get_where('tbl_tracking_real', ['shipment_id' => $result_code])->row_array();
            if ($cek_task_gateway['status'] == 'in') {
                $data = array(
                    'status' => "Shipment Telah Tiba Di Hub $cek_tracking[note]",
                    'id_so' => $cek_task_gateway['id_so'],
                    'shipment_id' => $result_code,
                    'note' => $cek_tracking['note'],
                    'id_user' => $this->session->userdata('id_user'),
                    'created_at' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'flag' => 6,
                );
                $insert = $this->db->insert('tbl_tracking_real', $data);
                if ($insert) {
                    $data = array(
                        'shipment_id' => $result_code,
                        'id_user' => $this->session->userdata('id_user'),
                        'status' => 'out',
                        'id_so' => $cek_task_gateway['id_so'],
                        'status_eksekusi' => 0
                    );
                    $this->db->insert('tbl_gateway', $data);
                    $data = array(
                        'status_eksekusi' => 1
                    );
                    $this->db->update('tbl_gateway', $data, ['id_gatewary' => $cek_task_gateway['id_gateway']]);
                    $this->session->set_flashdata('message', 'Success');
                    redirect('dispatcher/salesOrder/');
                } else {
                    $this->session->set_flashdata('message', 'Failed');
                    redirect('dispatcher/salesOrder/');
                }
            } else {
                $data = array(
                    'status' => "Shipment Keluar Dari Hub $cek_tracking[note]",
                    'id_so' => $cek_task_gateway['id_so'],
                    'shipment_id' => $result_code,
                    'id_user' => $this->session->userdata('id_user'),
                    'created_at' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'flag' => 7,
                );
                $insert = $this->db->insert('tbl_tracking_real', $data);
                if ($insert) {
                    $this->session->set_flashdata('message', 'Success');
                    redirect('dispatcher/salesOrder/');
                } else {
                    $this->session->set_flashdata('message', 'Failed');
                    redirect('dispatcher/salesOrder/');
                }
            }
        } else {
            $this->session->set_flashdata('message', 'No shipment with this QC');
            redirect('dispatcher/salesOrder/');
        }
    }

    public function assignDriver()
    {
        date_default_timezone_set("Asia/Jakarta");
        $where = array('id_so' => $this->input->post('id_so'));
        $data = array(
            'id_user' => $this->input->post('id_driver'),
            'update_at' => date('Y-m-d H:i:s')
        );
        $update =  $this->db->update('tbl_tracking', $data, $where);
        if ($update) {
            $this->session->set_flashdata('message', 'Success');
            redirect('shipper/salesOrder/detail/' . $this->input->post('id_so'));
        } else {
            $this->session->set_flashdata('message', 'Failed');
            redirect('shipper/salesOrder/detail/' . $this->input->post('id_so'));
        }
    }
    public function assignDriverDl()
    {
        date_default_timezone_set("Asia/Jakarta");
        $data = array(
            'status' => 'Shipment Keluar Dari Hub Benhil',
            'id_so' => $this->input->post('id_so'),
            'shipment_id' => $this->input->post('shipment_id'),
            'id_user' => $this->input->post('id_driver'),
            'created_at' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'flag' => 5,
        );
        $insert = $this->db->insert('tbl_tracking_real', $data);
        if ($insert) {
            $this->session->set_flashdata('message', 'Success');
            redirect('shipper/salesOrder/detail/' . $this->input->post('id_so'));
        } else {
            $this->session->set_flashdata('message', 'Failed');
            redirect('shipper/salesOrder/detail/' . $this->input->post('id_so'));
        }
    }
    public function assignDriverHub()
    {
        $gatway = $this->input->post('gateway');
        date_default_timezone_set("Asia/Jakarta");
        $data = array(
            'status' => 'Shipment Keluar Dari Hub Benhil',
            'id_so' => $this->input->post('id_so'),
            'shipment_id' => $this->input->post('shipment_id'),
            'id_user' => $this->input->post('id_driver'),
            'created_at' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'flag' => 5,
            'status_eksekusi' => 0,
            'note' => $this->input->post('note')
        );
        $insert = $this->db->insert('tbl_tracking_real', $data);
        if ($insert) {
            if ($gatway == 'ops') {
                $data = array(
                    'shipment_id' => $this->input->post('shipment_id'),
                    'id_user' => $this->input->post('driver_gateway'),
                    'status' => 'in',
                    'id_so' => $this->input->post('id_so'),
                    'status_eksekusi' => 0
                );
                $this->db->insert('tbl_gateway', $data);
            }

            $this->session->set_flashdata('message', 'Success');
            redirect('shipper/salesOrder/detail/' . $this->input->post('id_so'));
        } else {
            $this->session->set_flashdata('message', 'Failed');
            redirect('shipper/salesOrder/detail/' . $this->input->post('id_so'));
        }
    }
    public function receive($id)
    {
        $data = array(
            'status' => 'Driver Menuju Lokasi Pickup',
            'id_so' => $id,
            'created_at' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'flag' => 2,
            'id_user' => $this->session->userdata('id_user'),
        );
        $this->db->insert('tbl_tracking', $data);
        $this->session->set_flashdata('message', 'Terima Kasih');
        redirect('shipper/salesOrder');
    }
    public function receiveDelivery($id, $shipment_id)
    {
        $data = array(
            'status' => 'Shipment Dalam Proses Delivery',
            'id_so' => $id,
            'shipment_id' => $shipment_id,
            'created_at' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'flag' => 6,
            'id_user' => $this->session->userdata('id_user'),
        );
        $this->db->insert('tbl_tracking_real', $data);
        $this->session->set_flashdata('message', 'Terima Kasih');
        redirect('shipper/salesOrder');
    }
    public function receiveDeliveryHub($id)
    {
        $data = array(
            'status_eksekusi' => 1,
        );
        $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $id]);
        $this->session->set_flashdata('message', 'Terima Kasih');
        redirect('shipper/salesOrder');
    }

    public function arriveBenhil($id_so, $shipment_id)
    {
        $data = array(
            'status' => 'Shipment Telah Tiba Di Hub Benhil',
            'id_so' => $id_so,
            'shipment_id' => $shipment_id,
            'created_at' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'flag' => 4,
            'id_user' => $this->session->userdata('id_user'),
        );
        $this->db->insert('tbl_tracking_real', $data);
        $this->session->set_flashdata('message', 'Terima Kasih');
        redirect('shipper/salesOrder');
    }
    public function arriveCustomer($id_so, $shipment_id)
    {
        $consignee =  $this->input->post('consignee');
        $data = array(
            'status' => "Shipment Telah Diterima Oleh $consignee",
            'id_so' => $id_so,
            'shipment_id' => $shipment_id,
            'created_at' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'flag' => 7,
            'pic_task' => $consignee,
            'id_user' => $this->session->userdata('id_user'),
        );
        $this->db->insert('tbl_tracking_real', $data);
        $data = array(
            'status' => 3,
        );
        $this->db->update('tbl_so', $data, ['id_so' => $id_so]);
        $this->session->set_flashdata('message', 'Terima Kasih');
        redirect('shipper/salesOrder');
    }

    public function detail($id)
    {
        $data['title'] = 'Detail Sales Order';
        $data['p'] = $this->db->get_where('tbl_so', ['id_so' => $id])->row_array();
        if ($data['p']['status'] >= 2) {
            $query  = "SELECT a.*, b.id_tracking,b.id_so, b.flag FROM tbl_shp_order a 
                    JOIN tbl_tracking_real b ON a.shipment_id=b.shipment_id
                    JOIN tb_service_type c ON a.service_type=c.code 
                     WHERE b.id_user= ?  ORDER BY id_tracking DESC LIMIT 1 ";
            $result = $this->db->query($query, array($this->session->userdata('id_user')))->row_array();
            $data['shipment'] = $result;
            $data['p'] = $this->db->get_where('tbl_so', ['id_so' => $id])->row_array();
            $data['users'] = $this->db->get_where('tb_user', ['id_role' => 2])->result_array();
            $this->backend->display('shipper/v_detail_order_luar', $data);
        } else {
            $data['p'] = $this->db->get_where('tbl_so', ['id_so' => $id])->row_array();
            $data['users'] = $this->db->get_where('tb_user', ['id_role' => 2])->result_array();
            $this->backend->display('shipper/v_detail_order', $data);
        }
    }
    public function edit($id)
    {
        $data['title'] = 'Edit Sales Order';
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['p'] = $this->db->get_where('tbl_so', ['id_so' => $id])->row_array();
        $this->backend->display('shipper/v_edit_order', $data);
    }
    function view_data_query()
    {
        $akses = $this->session->userdata('akses');
        // kalo dia atasan driver
        if ($akses == 1) {
            $search = array('shipper', 'destination', 'b.nama_user');
            $query  = "SELECT a.*, b.nama_user as sales FROM tbl_so a 
        JOIN tb_user b ON a.id_sales=b.id_user";
            $where  = null;
            $isWhere = null;
            // $isWhere = 'artikel.deleted_at IS NULL';
            // jika memakai IS NULL pada where sql
            header('Content-Type: application/json');
            echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
        }
    }
}
