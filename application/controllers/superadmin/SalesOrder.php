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
        $this->db->select('a.*,b.nama_user');
        $this->db->from('tbl_so a');
        $this->db->join('tb_user b', 'b.id_user=a.id_sales');
        $this->db->order_by('a.id_so', 'DESC');
        $query = $this->db->get()->result_array();
        $data['so'] = $query;
        $data['title'] = 'Sales Order';
        $this->backend->display('superadmin/v_so', $data);
    }


    public function detail($id)
    {
        $data['title'] = 'Detail Sales Order';
        $query  = "SELECT a.*, b.id_tracking,b.id_so, b.flag,c.service_name FROM tbl_shp_order a 
                    JOIN tbl_tracking_real b ON a.shipment_id=b.shipment_id
                    JOIN tb_service_type c ON a.service_type=c.code 
                     WHERE a.id_so= ?  ORDER BY id_tracking DESC LIMIT 1 ";
        $result = $this->db->query($query, array($id))->row_array();
        $data['shipment'] = $result;
        // var_dump($result);
        // die;
        $data['p'] = $this->db->get_where('tbl_so', ['id_so' => $id])->row_array();
        $data['users'] = $this->db->get_where('tb_user', ['id_role' => 2])->result_array();
        $data['shipment2'] =  $this->order->orderBySoAdmin($id)->result_array();
        $id_jabatan = $this->session->userdata('id_jabatan');

        $this->backend->display('superadmin/v_detail_order_luar', $data);
    }

    function view_data_query()
    {
        $search = array('id_so', 'shipper', 'destination', 'b.nama_user');
        $query  = "SELECT a.*, b.nama_user as sales FROM tbl_so a 
        JOIN tb_user b ON a.id_sales=b.id_user";
        $where  = null;
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        // jika memakai IS NULL pada where sql
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }
    function getTreeLetterCode($province)
    {
        $code = $this->db->get_where('tb_province', ['name' => $province])->row_array();
        if ($code) {
            return $code['tree_code'];
        } else {
            return null;
        }
    }
}
