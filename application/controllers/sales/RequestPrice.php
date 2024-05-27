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
        $this->load->model('SalesModel', 'sales');
        $this->load->model('Sendwa', 'wa');
        $this->load->model('WilayahModel', 'wilayah');
        // $this->load->model('RequestPriceModel')

        cek_role();
    }
    public function index()
    {
        $data['title'] = 'Request Price';
        $data['detailRequestPrice'] = $this->sales->getDetailRequestPrice($this->session->userdata('id_user'));
        $this->backend->display('sales/v_request_price', $data);
    }

    public function detailRequestPrice($id)
    {
        $data['title'] = 'Request Price';
        $data['provinsi'] = $this->db->get('tb_province');
        $data['kota'] = $this->db->get('tb_city');
        $data['moda'] = $this->db->get('tbl_moda');
        $data['customer'] = $this->db->get('tb_customer');
        $data['detailRequestPrice'] = $this->sales->getDetailRequestPrice(NULL, $id)->row_array();
        $this->backend->display('sales/v_detailRequestPrice', $data);
    }


    public function addRequestPrice()
    {
        $this->load->library('form_validation');
        $data['title'] = 'Add Request Price';
        $data['provinsi'] = $this->db->get('tb_province');
        $data['kota'] = $this->db->get('tb_city');
        $data['moda'] = $this->db->get('tbl_moda');
        $data['customer'] = $this->db->get('tb_customer');
        $this->backend->display('sales/v_addRequestPrice', $data);
    }

    public function editRequestPrice($id)
    {
        $data['title'] = 'Request Price';
        $data['provinsi'] = $this->db->get('tb_province');
        $data['kota'] = $this->db->get('tb_city');
        $data['moda'] = $this->db->get('tbl_moda');
        $data['customer'] = $this->db->get('tb_customer');
        $data['detailRequestPrice'] = $this->sales->getDetailRequestPrice($this->session->userdata('id_user'), $id)->row_array();
        $this->backend->display('sales/v_editRequestPrice', $data);
    }

    public function processEditRequestPrice($id)
    {
        $provinsi_from = $this->input->post('provinsi_from');
        $kota_from = $this->input->post('kota_from');
        $kecamatan_from = $this->input->post('kecamatan_from');
        $alamat_from = $this->input->post('alamat_from');
        $provinsi_to = $this->input->post('provinsi_to');
        $kota_to = $this->input->post('kota_to');
        $kecamatan_to = $this->input->post('kecamatan_to');
        $alamat_to = $this->input->post('alamat_to');
        $moda = $this->input->post('moda'); // id modanya
        $jenis = $this->input->post('jenis');
        $berat = $this->input->post('berat');
        $koli = $this->input->post('koli');
        $panjang = $this->input->post('panjang');
        $lebar = $this->input->post('lebar');
        $tinggi = $this->input->post('tinggi');
        $notes = $this->input->post('notes');
        $detailRequest = [
            'customer' => $this->input->post('customer'),
            'provinsi_from' => $provinsi_from,
            'kota_from' => $kota_from,
            'kecamatan_from' => $kecamatan_from,
            'alamat_from' => $alamat_from,
            'provinsi_to' => $provinsi_to,
            'kota_to' => $kota_to,
            'kecamatan_to' => $kecamatan_to,
            'alamat_to' => $alamat_to,
            'moda' => $moda,
            'jenis' => $jenis,
            'berat' => $berat,
            'koli' => $koli,
            'panjang' => $panjang,
            'lebar' => $lebar,
            'tinggi' => $tinggi,
            'notes_sales' => $notes,

        ];
        $update = $this->db->update('detailrequest_price', $detailRequest, array('id_detailrequest' => $id));

        if ($update) {
            $log = [
                'id_detailrequestprice' => $id,
                'log' => 'Request Telah Diedit',
                'user' => $this->session->userdata('id_user'),
                'date' => date('Y-m-d H:i:s')
            ];
            $updateLog = $this->db->insert('requestprice_log', $log);
            if ($updateLog) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit</div>');
                redirect('sales/RequestPrice');
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

    public function addNewRequest()
    {
        $provinsi_from = $this->input->post('provinsi_from');
        $kota_from = $this->input->post('kota_from');
        $kecamatan_from = $this->input->post('kecamatan_from');
        $alamat_from = $this->input->post('alamat_from');
        $provinsi_to = $this->input->post('provinsi_to');
        $kota_to = $this->input->post('kota_to');
        $kecamatan_to = $this->input->post('kecamatan_to');
        $alamat_to = $this->input->post('alamat_to');
        $moda = $this->input->post('moda'); // id modanya
        $jenis = $this->input->post('jenis');
        $berat = $this->input->post('berat');
        $koli = $this->input->post('koli');
        $panjang = $this->input->post('panjang');
        $lebar = $this->input->post('lebar');
        $tinggi = $this->input->post('tinggi');
        $notes = $this->input->post('notes');

        $request = [
            'created_by' => $this->session->userdata('id_user'),
            'date_created' => date('Y-m-d H:i:s'),
            'status' => 0
        ];

        $this->db->insert('request_price', $request);
        $id_request = $this->db->insert_id();

        for ($i = 0; $i < sizeof($provinsi_from); $i++) {
            $detailRequest = [
                'id_request' => $id_request,
                'customer' => $this->input->post('customer'),
                'provinsi_from' => $provinsi_from[$i],
                'kota_from' => $kota_from[$i],
                'kecamatan_from' => $kecamatan_from[$i],
                'alamat_from' => $alamat_from[$i],
                'provinsi_to' => $provinsi_to[$i],
                'kota_to' => $kota_to[$i],
                'kecamatan_to' => $kecamatan_to[$i],
                'alamat_to' => $alamat_to[$i],
                'moda' => $moda[$i],
                'jenis' => $jenis[$i],
                'berat' => $berat[$i],
                'koli' => $koli[$i],
                'panjang' => $panjang[$i],
                'lebar' => $lebar[$i],
                'tinggi' => $tinggi[$i],
                'notes_sales' => $notes[$i],
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('id_user'),
                'status' => 0
            ];
            $this->db->insert('detailrequest_price', $detailRequest);
            $insert_id = $this->db->insert_id();
            $log = [
                'id_detailrequestprice' => $insert_id,
                'log' => 'Request Dibuat',
                'user' => $this->session->userdata('id_user'),
                'date' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('requestprice_log', $log);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Add</div>');
        redirect('sales/RequestPrice');
    }

    public function deleteRequestPrice($id)
    {
        if ($this->db->update('detailrequest_price', array('is_deleted' => 1), array('id_detailrequest' => $id))) {
            $log = [
                'id_detailrequestprice' => $id,
                'log' => 'Request Price Dihapus',
                'user' => $this->session->userdata('id_user'),
                'date' => date('Y-m-d H:i:s')
            ];
            if ($this->db->insert('requestprice_log', $log)) {
                $this->session->set_flashdata('message', '<div class="alert
                alert-success" role="alert">Success Delete</div>');
                redirect('sales/RequestPrice');
            }
        }
    }


    public function importRequestPrice()
    {

        $file_mimes = array(
            'text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream',
            'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv',
            'application/excel', 'application/vnd.msexcel', 'text/plain',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['upload_file']['name']);
            $extension = end($arr_file);
            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            $getLastRequest = $this->db->limit(1)->order_by('id_request_price', 'DESC')->get('tbl_request_price')->row_array();
            $code = $this->sales->getCodeRequestPrice();
            $queue = 0;
            foreach ($sheetData as $rowdata) {
                if ($queue == 0) {
                    $queue += 1;
                } else {
                    $data = array(
                        'id_sales' => $this->session->userdata('id_user'),
                        'code_request_price' => $code,
                        'date_request' => date('Y-m-d H:i:s'),
                        'province_from' => $rowdata[1],
                        'city_from' => $rowdata[2],
                        'subdistrict_from' => $rowdata[3],
                        'alamat_from' => $rowdata[4],
                        'province_to' => $rowdata[5],
                        'city_to' => $rowdata[6],
                        'subdistrict_to' => $rowdata[7],
                        'alamat_to' => $rowdata[8],
                        'moda' => $rowdata[9],
                        'jenis_barang' => $rowdata[10],
                        'berat' => $rowdata[11],
                        'koli' => $rowdata[12],
                        'komoditi' => $rowdata[13],
                        'panjang' => $rowdata[14],
                        'lebar' => $rowdata[15],
                        'tinggi' => $rowdata[16],
                        'notes_sales' => $rowdata[17],
                        'group' => $getLastRequest['group'] + 1,
                        'is_bulk' => 1
                    );
                    $this->db->insert('tbl_request_price', $data);
                }
            }

            $this->session->set_flashdata('message', '<div class="alert
                    alert-success" role="alert">Success</div>');
            redirect('sales/RequestPrice');
        }
    }

    public function detailRequestPriceBulk($code)
    {
        $provinsi = $this->wilayah->getDataProvinsi();
        $data['title'] = 'Request Price Detail Bulk';
        $data['requestPrice'] = $this->sales->getDetailRequestPriceBulk($code);
        $data['provinsi'] = $provinsi->data;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $this->backend->display('sales/v_request_price_bulk', $data);
    }

    public function confirmSales($id)
    {
        $confirm =  $this->db->update('detailrequest_price', array('status' => 2), array('id_detailrequest' => $id));
        if ($confirm) {
            $log = [
                'id_detailrequestprice' => $id,
                'log' => 'Request Price Di confirm sales',
                'user' => $this->session->userdata('id_user'),
                'date' => date('Y-m-d H:i:s')
            ];
            if ($log) {
                $this->session->set_flashdata('message', '<div class="alert
                    alert-success" role="alert">Success Confirm</div>');
                redirect('sales/RequestPrice');
            }
        }
    }

    public function declineSales()
    {
        $id_detailrequest = $this->input->post('id_detailrequest');
        $notes_decline_sales = $this->input->post('notes_decline_sales');


        $update = $this->db->update('detailrequest_price', ['notes_decline_sales' => $notes_decline_sales, 'status' => 3], ['id_detailrequest' => $id_detailrequest]);
        if ($update) {
            $log = [
                'id_detailrequestprice' => $id_detailrequest,
                'log' => 'Request Telah di decline Oleh Sales',
                'user' => $this->session->userdata('id_user'),
                'date' => date('Y-m-d H:i:s')
            ];
            $updateLog = $this->db->insert('requestprice_log', $log);
            if ($updateLog) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Decline</div>');
                redirect('sales/RequestPrice');
            }
        }
    }

    public function getProvinsi()
    {

        $data  = $this->db->get('tb_province')->result();
        // Kirim data sebagai respons JSON
        echo json_encode($data);
    }
}
