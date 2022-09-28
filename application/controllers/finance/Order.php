<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


class Order extends CI_Controller
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
        $this->load->model('Api');
        cek_role();
    }

    public function index()
    {
        $data['title'] = 'My Shipment';
        $data['order'] = $this->db->order_by('id', 'DESC')->get('tbl_shp_order')->result_array();
        $this->backend->display('cs/v_order', $data);
    }

    public function detail($id, $id_so)
    {
        $data['title'] = 'Detail Order';
        $data['id_so'] = $id_so;
        $data['p'] = $this->order->order($id)->row_array();
        $this->backend->display('cs/v_detail_pengajuan', $data);
    }
    public function edit($id, $id_so)
    {
        $data['title'] = 'Edit Order';
        $data['id_so'] = $id_so;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $data['province'] = $this->db->get('tb_province')->result_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['p'] = $this->order->order($id)->row_array();
        $this->backend->display('cs/v_edit_order', $data);
    }

    function view_data_query()
    {
        $query  = "SELECT a.*, b.nama_user FROM tbl_shp_order a JOIN tb_user b ON a.id_user=b.id_user";
        $search = array('nama_user', 'shipment_id', 'order_id');
        $where  = null;
        // $where  = array('a.id_user' => $this->session->userdata('id_user'));

        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }

    public function processEdit()
    {
        $data = array(
            'weight' => $this->input->post('weight'),
            'koli' => $this->input->post('koli'),
            'is_weight_print' => $this->input->post('is_weight_print'),
        );

        $update =  $this->db->update('tbl_shp_order', $data, ['id' => $this->input->post('id')]);
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert
                alert-success" role="alert">Success</div>');
            redirect('cs/order/edit/' . $this->input->post('id'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert
                alert-danger" role="alert">Failed</div>');
            redirect('cs/order/edit/' . $this->input->post('id'));
        }
    }

    public function addMasterCustomer()
    {
        $nama_pt = strtoupper($this->input->post('shipper'));
        $query = $this->db->get_where('tb_customer', ['nama_pt' => $nama_pt])->row_array();
        if ($query == NULL) {
            $data = array(
                'nama_pt' => $nama_pt,
                'pic' => $this->input->post('sender'),
            );
            $this->db->insert('tb_customer', $data);
        }
    }

    public function print($id)
    {
        $where = array('shipment_id' => $id);
        $data['order'] = $this->db->get_where('tbl_shp_order', $where)->row_array();
        $where2 = array('code' => $data['order']['service_type']);
        $data['service'] = $this->db->get_where('tb_service_type', $where2)->row_array();
        // var_dump($data['order']);
        // die;
        $this->load->view('superadmin/v_cetak', $data);
        $html = $this->output->get_output();
        $this->load->library('dompdf_gen');
        $this->dompdf->set_paper("A6", 'potrait');
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $sekarang = date("d:F:Y:h:m:s");
        // return $this->dompdf->output();
        $output = $this->dompdf->output();
        // file_put_contents('uploads/barcode' . '/' . "$shipment_id.pdf", $output);
        $this->dompdf->stream("Cetak" . $sekarang . ".pdf", array('Attachment' => 0));
    }
    public function barcode($id)
    {
        // $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        // $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG(); // Pixel based PNG
        // echo $generatorPNG->getBarcode($id, $generatorPNG::TYPE_CODE_128);
        $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
        file_put_contents("uploads/barcode/$id.jpg", $generator->getBarcode($id, $generator::TYPE_CODE_128));
        // echo $image;
    }
    public function qrcode($id)
    {
        $this->load->library('ciqrcode');
        $params['data'] = $id;
        $params['level'] = 'H';
        $params['size'] = 4;
        $params['savename'] = FCPATH . "uploads/qrcode/" . $id . '.png';
        $this->ciqrcode->generate($params);
    }

    function get_autocomplete()
    {
        if (isset($_GET['term'])) {
            $result = $this->order->search_blog($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'nama_pt'         => $row->nama_pt,
                        'pic'   => $row->pic,
                    );
                echo json_encode($arr_result);
            }
        }
    }
}
