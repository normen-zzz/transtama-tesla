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
        $this->db->where('a.status_approve', 1);
        $this->db->or_where('a.status_approve', 2);
        $this->db->or_where('a.status_approve', 3);
        $this->db->order_by('a.id_so', 'DESC');
        $query = $this->db->get()->result_array();
        $data['so'] = $query;
        $data['title'] = 'Sales Order';
        $this->backend->display('finance/v_so', $data);
    }
    public function add($id_so)
    {
        $data['title'] = 'Add Order';
        $cek_api = $this->Api->kirim();
        $cek_api = json_decode($cek_api);
        $cek_api = $cek_api->accessToken;
        $data = [
            'token' => $cek_api,
        ];
        $this->session->set_userdata($data);
        // $data['imagecamera'] = $img;
        $data['id_so'] = $id_so;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $data['province'] = $this->db->get('tb_province')->result_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['customer'] = $this->db->get('tb_customer')->result_array();
        $this->backend->display('finance/v_order_add', $data);
    }
    public function bulk($id_so)
    {
        $data['title'] = 'Add Order';
        $cek_api = $this->Api->kirim();
        $cek_api = json_decode($cek_api);
        $cek_api = $cek_api->accessToken;
        $data = [
            'token' => $cek_api,
        ];
        $this->session->set_userdata($data);
        $data['id_so'] = $id_so;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $data['province'] = $this->db->get('tb_province')->result_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['customer'] = $this->db->get('tb_customer')->result_array();
        $this->backend->display('finance/v_order_add_bulk', $data);
    }
    public function import()
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
            // var_dump($sheetData);
            // die;
            // echo "<pre>";
            // print_r($sheetData);
            foreach ($sheetData as $rowdata) {
                $date = date('Y-m-d');
                $pickup_start = date('Y-m-d', strtotime('+1 days', strtotime($date)));
                $delivery_start = date('Y-m-d', strtotime('+1 days', strtotime($pickup_start)));
                $delivery_commit = date('Y-m-d', strtotime('+3 days', strtotime($delivery_start)));

                $startTime = date("H:i:s", time() + 6000);

                $koli = $rowdata[8];
                $package = array();
                for ($i = 0; $i < $koli; $i++) {
                    $p = $i + 1;
                    $package_list = array(
                        'weight' => '5',
                        'length' => '10',
                        'height' => '20',
                        'width' => '5',
                        'description' => "Package $p",
                        'package_type_id' => "7db61ef4-5c0f-4965-8eec-3fd938f5d16f",
                        'commodities_packages_attributes' => array(
                            '0' => array(
                                "commodity_id" => "dd7eb77d-431b-48a2-85b8-0c4a132c9bef",
                                "items_count" => "1",
                                "value_of_goods" => "1"
                            )
                        )
                    );
                    array_push($package, $package_list);
                }
                // var_dump($rowdata[10]);
                // die;
                $data = array(
                    'order' => array(
                        'user_id' => "6a85fa9d-154f-49ac-8710-35bf19122c31",
                        'reference_id' => '',
                        'service_type_id' => $rowdata[7],
                        'measurement_units' => "metric",
                        'pickup_start_time' => $date . "T$startTime.000Z",
                        'pickup_commit_time' => $pickup_start . 'T23:59:00.000',
                        'delivery_start_time' => $delivery_start . 'T00:00:00.000Z',
                        'delivery_commit_time' => $delivery_commit . 'T23:59:00.000Z',
                        // 'state_consigne' => $this->input->post('state_consigne'),
                        'shipper_name' => $rowdata[0],
                        'shipper_phone' => "0000",
                        'shipper_email' => "sender@gmail.com",
                        'consignee_name' => $rowdata[4],
                        'consignee_phone' => "00000",
                        'consignee_email' => "consigne@gmail.com",
                        'delivery_timezon' => "Asia/Jakarta",
                        'origin_attributes' => array(
                            'country' => 'Indonesia',
                            'state' => ucwords(strtolower($rowdata[1])),
                            // 'state' => 'South Kalimantan',
                            'city' => ucwords(strtolower($rowdata[2])),
                            // 'city' => 'Kabupaten Kota Baru',
                            'postal_code' => "12345",
                            'address_line1' => $rowdata[1],
                            // 'address_line1' => 'JL MH Thamrin no 51 Jakarta Pusat',
                            'address_line2' => $rowdata[1],
                            'address_line3' => $rowdata[1],
                            'latitude' => "",
                            'longitude' => ""
                        ),
                        'destination_attributes' => array(
                            'country' => "Indonesia",
                            'state' => ucwords(strtolower($rowdata[5])),
                            // 'state' => 'Jakarta',
                            'city' => ucwords(strtolower($rowdata[6])),
                            // 'city' => 'West jakarta',
                            'postal_code' => '000',
                            'address_line1' => $rowdata[5],
                            'address_line2' => $rowdata[5],
                            'address_line3' => $rowdata[5],

                        ),
                        'packages_attributes' => $package,
                        'pricing_info_attributes' => array(
                            "currency" => "IDR"
                        )
                    )
                );
                // var_dump($data);
                // die;

                $data = json_encode($data);
                $send = $this->Api->order($data);
                // echo $send;
                // die;
                $jsonIterator = new RecursiveIteratorIterator(
                    new RecursiveArrayIterator(json_decode($send, TRUE)),
                    RecursiveIteratorIterator::SELF_FIRST
                );

                $new = array();
                foreach ($jsonIterator as $key => $val) {
                    if (is_array($val)) {
                    } else {
                        if ($key == 'order_id_label' || $key == 'shipment_id_label') {
                            array_push($new, $val);
                        }
                    }
                }
                if ($new) {

                    $order_id = $new[0];
                    $shipment_id  = $new[1];

                    $img = $this->input->post('ttd');
                    $img = str_replace('data:image/png;base64,', '', $img);
                    $province_shipper = $rowdata[1];
                    $province_consigne = $rowdata[5];

                    $data = array(
                        'shipper' => strtoupper($rowdata[0]),
                        'origin' => $this->input->post('origin'),
                        'city_shipper' => $rowdata[2],
                        'state_shipper' => $rowdata[1],
                        'consigne' => strtoupper($rowdata[4]),
                        'destination' => $rowdata[3],
                        'city_consigne' => $rowdata[6],
                        'state_consigne' => $rowdata[5],
                        'koli' => $rowdata[8],
                        'sender' => $rowdata[9],
                        'id_user' => $this->session->userdata('id_user'),
                        'signature' => $img,
                        'tree_shipper' => $this->getTreeLetterCode($province_shipper),
                        'tree_consignee' => $this->getTreeLetterCode($province_consigne),
                        'shipment_id' => $shipment_id,
                        'order_id' => $order_id,
                        'service_type' =>  $rowdata[7],
                        'is_jabodetabek' =>  $rowdata[10],
                        'date_new' => date('Y-m-d'),
                        'id_so' => $this->input->post('id_so')

                    );
                    // cek order berdasarkan id_so
                    $get_last_order = $this->db->limit(1)->order_by('id', 'desc')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();
                    // kalo shipment id nya null, maka update tbl nya
                    if ($get_last_order['shipment_id'] == NULL) {
                        // echo 'kosong';
                        $update =  $this->db->update('tbl_shp_order', $data, ['id_so' => $this->input->post('id_so')]);
                        if ($update) {
                            $this->barcode($shipment_id);
                            $this->qrcode($shipment_id);
                            $data = array(
                                'shipment_id' => $shipment_id,
                                'status' => 'Shipment Telah Dipickup Dari Shipper',
                                'id_so' => $this->input->post('id_so'),
                                'created_at' => date('Y-m-d'),
                                'id_user' => $this->session->userdata('id_user'),
                                'pic_task' => $this->input->post('sender'),
                                'time' => date('H:i:s'),
                                'flag' => 3,
                                'status_eksekusi' => 0,
                            );
                            $this->db->insert('tbl_tracking_real', $data);
                            $data = array(
                                'status' => 2,
                            );
                            $this->db->update('tbl_so', $data, ['id_so' => $this->input->post('id_so')]);
                            $data = array(
                                'status_eksekusi' => 1,
                            );
                            $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $this->input->post('id_tracking')]);
                            $data = array(
                                'shipment_id' => $shipment_id,
                            );
                            $this->db->update('tbl_tracking_real', $data, ['id_so' => $this->input->post('id_so')]);
                        } else {
                        }
                    } else {
                        // kalo shipment id nya ada, maka insert tbl nya 
                        $insert =  $this->db->insert('tbl_shp_order', $data);
                        if ($insert) {
                            $this->barcode($shipment_id);
                            $this->qrcode($shipment_id);
                            $get_tracking = $this->db->get_where('tbl_tracking_real', ['id_so' => $this->input->post('id_so')])->result_array();
                            foreach ($get_tracking as $track) {
                                $data = array(
                                    'shipment_id' => $shipment_id,
                                    'status' => $track['status'],
                                    'id_so' => $this->input->post('id_so'),
                                    'created_at' => $track['created_at'],
                                    'note' => $track['note'],
                                    'bukti' => $track['bukti'],
                                    'id_user' => $track['id_user'],
                                    'update_at' => $track['update_at'],
                                    'pic_task' => $track['pic_task'],
                                    'time' => $track['time'],
                                    'flag' => $track['flag'],
                                    'status_eksekusi' => $track['status_eksekusi'],
                                );
                                $this->db->insert('tbl_tracking_real', $data);
                            }
                            $data = array(
                                'shipment_id' => $shipment_id,
                                'status' => 'Shipment Telah Dipickup Dari Shipper',
                                'id_so' => $this->input->post('id_so'),
                                'created_at' => date('Y-m-d'),
                                'id_user' => $this->session->userdata('id_user'),
                                'pic_task' => $this->input->post('sender'),
                                'time' => date('H:i:s'),
                                'flag' => 3,
                                'status_eksekusi' => 0,
                            );
                            $this->db->insert('tbl_tracking_real', $data);
                            $data = array(
                                'status' => 2,
                            );
                            $this->db->update('tbl_so', $data, ['id_so' => $this->input->post('id_so')]);
                            //         $this->session->set_flashdata('message', '<div class="alert
                            // alert-success" role="alert">Success</div>');
                            //         redirect('shipper/order/view/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
                        } else {
                            //         $this->session->set_flashdata('message', '<div class="alert
                            // alert-danger" role="alert">Failed Insert</div>');
                            //         $this->add($this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
                        }
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert
                    alert-danger" role="alert">Kota/Provinsi tidak ditemukan</div>');
                    redirect('finance/salesOrder/bulk/' . $this->input->post('id_so'));
                }
            }
            $this->session->set_flashdata('message', '<div class="alert
                        alert-success" role="alert">Success</div>');
            redirect('finance/salesOrder/detail/' . $this->input->post('id_so'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert
                    alert-danger" role="alert">Silahkan Upload File</div>');
            redirect('finance/salesOrder/bulk/' . $this->input->post('id_so'));
        }
    }

    public function processAdd()
    {
        $this->form_validation->set_rules('consigne', 'consigne', 'required');
        $this->form_validation->set_rules('state_consigne', 'State_consigne', 'required');
        $this->form_validation->set_rules('destination', 'Destination', 'required');
        $this->form_validation->set_rules('service_type', 'Service_type', 'required');
        $this->form_validation->set_rules('ttd', 'Ttd', 'required');
        $this->form_validation->set_rules('city_consigne', 'City_consigne', 'required');
        $this->form_validation->set_rules('state_consigne', 'State_consigne', 'required');
        $this->form_validation->set_rules('koli', 'Koli', 'required');
        $this->form_validation->set_rules('state_shipper2', 'State_shipper2', 'required');
        $this->form_validation->set_rules('city_shipper2', 'City_shipper2', 'required');
        $this->form_validation->set_rules('shipper2', 'Shipper2', 'required');
        $this->form_validation->set_rules('shipper_id', 'Shipper_id', 'required');
        $this->form_validation->set_rules('origin_destination', 'Origin_destination', 'required');
        $this->form_validation->set_rules('id_so', 'Id_so', 'required');
        $this->form_validation->set_rules('is_jabodetabek', 'Is_jabodetabek', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'Failed');
            $this->detail($this->input->post('id_so'));
        } else {
            $koli = $this->input->post('koli');
            $package = array();
            for ($i = 0; $i < $koli; $i++) {
                $p = $i + 1;
                $package_list = array(
                    'weight' => '5',
                    'length' => '10',
                    'height' => '20',
                    'width' => '5',
                    'description' => "Package $p",
                    'package_type_id' => "7db61ef4-5c0f-4965-8eec-3fd938f5d16f",
                    'commodities_packages_attributes' => array(
                        '0' => array(
                            "commodity_id" => "dd7eb77d-431b-48a2-85b8-0c4a132c9bef",
                            "items_count" => "1",
                            "value_of_goods" => "1"
                        )
                    )
                );
                array_push($package, $package_list);
            }
            // echo '<pre>';
            // print_r($package);
            // die;
            // var_dump($package_list);
            // die;
            $img = $this->input->post('ttd');
            $img = str_replace('data:image/png;base64,', '', $img);
            $service_type = $this->input->post('service_type');

            $date = date('Y-m-d');
            $pickup_start = date('Y-m-d', strtotime('+1 days', strtotime($date)));
            $delivery_start = date('Y-m-d', strtotime('+1 days', strtotime($pickup_start)));
            $delivery_commit = date('Y-m-d', strtotime('+3 days', strtotime($delivery_start)));

            $startTime = date("H:i:s", time() + 6000);
            // var_dump($startTime);
            // die;
            $data = array(
                'order' => array(
                    'user_id' => "6a85fa9d-154f-49ac-8710-35bf19122c31",
                    'reference_id' => '',
                    'service_type_id' => "$service_type",
                    'measurement_units' => "metric",
                    'pickup_start_time' => $date . "T$startTime.000Z",
                    'pickup_commit_time' => $pickup_start . 'T23:59:00.000',
                    'delivery_start_time' => $delivery_start . 'T00:00:00.000Z',
                    'delivery_commit_time' => $delivery_commit . 'T23:59:00.000Z',
                    // 'state_consigne' => $this->input->post('state_consigne'),
                    'shipper_name' => $this->input->post('shipper2'),
                    'shipper_phone' => "0000",
                    'shipper_email' => "sender@gmail.com",
                    'consignee_name' => $this->input->post('consigne'),
                    'consignee_phone' => "00000",
                    'consignee_email' => "consigne@gmail.com",
                    'delivery_timezon' => "Asia/Jakarta",
                    'origin_attributes' => array(
                        'country' => 'Indonesia',
                        'state' => ucwords(strtolower($this->input->post('state_shipper2'))),
                        // 'state' => 'South Kalimantan',
                        'city' => ucwords(strtolower($this->input->post('city_shipper2'))),
                        // 'city' => 'Kabupaten Kota Baru',
                        'postal_code' => "12345",
                        'address_line1' => $this->input->post('state_shipper2'),
                        // 'address_line1' => 'JL MH Thamrin no 51 Jakarta Pusat',
                        'address_line2' => $this->input->post('state_shipper2'),
                        'address_line3' => $this->input->post('state_shipper2'),
                        'latitude' => "",
                        'longitude' => ""
                    ),
                    'destination_attributes' => array(
                        'country' => "Indonesia",
                        'state' => ucwords(strtolower($this->input->post('state_consigne'))),
                        // 'state' => 'Jakarta',
                        'city' => ucwords(strtolower($this->input->post('city_consigne'))),
                        // 'city' => 'West jakarta',
                        'postal_code' => '000',
                        'address_line1' => $this->input->post('destination'),
                        'address_line2' => $this->input->post('destination'),
                        'address_line3' => $this->input->post('state_consigne'),

                    ),
                    'packages_attributes' => $package,
                    'pricing_info_attributes' => array(
                        "currency" => "IDR"
                    )
                )
            );
            // echo '<pre>';
            // print_r($data);
            // var_dump($data);
            // die;

            $data = json_encode($data);
            $send = $this->Api->order($data);
            // echo $send;
            // die;
            $jsonIterator = new RecursiveIteratorIterator(
                new RecursiveArrayIterator(json_decode($send, TRUE)),
                RecursiveIteratorIterator::SELF_FIRST
            );

            $new = array();
            foreach ($jsonIterator as $key => $val) {
                if (is_array($val)) {
                } else {
                    if ($key == 'order_id_label' || $key == 'shipment_id_label') {
                        array_push($new, $val);
                    }
                }
            }
            if ($new) {

                $order_id = $new[0];
                $shipment_id  = $new[1];

                $img = $this->input->post('ttd');
                $img = str_replace('data:image/png;base64,', '', $img);
                $province_shipper = $this->input->post('state_shipper2');
                $province_consigne = $this->input->post('state_consigne');

                $data = array(
                    'shipper' => strtoupper($this->input->post('shipper2')),
                    'origin' => $this->input->post('origin'),
                    'city_shipper' => $this->input->post('city_shipper2'),
                    'state_shipper' => $this->input->post('state_shipper2'),
                    'consigne' => strtoupper($this->input->post('consigne')),
                    'destination' => $this->input->post('destination'),
                    'city_consigne' => $this->input->post('city_consigne'),
                    'state_consigne' => $this->input->post('state_consigne'),
                    'koli' => $this->input->post('koli'),
                    'is_jabodetabek' => $this->input->post('is_jabodetabek'),
                    'sender' => $this->input->post('sender'),
                    'id_so' => $this->input->post('id_so'),
                    'id_user' => $this->session->userdata('id_user'),
                    'signature' => $img,
                    'tree_shipper' => $this->getTreeLetterCode($province_shipper),
                    'tree_consignee' => $this->getTreeLetterCode($province_consigne),
                    'shipment_id' => $shipment_id,
                    'order_id' => $order_id,
                    'service_type' =>  $service_type,
                    'date_new' => date('Y-m-d')

                );

                // var_dump($data);
                $config['upload_path'] = './uploads/berkas/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);

                $folderUpload = "./uploads/berkas/";
                $files = $_FILES;
                $files = $_FILES;
                $jumlahFile = count($files['ktp']['name']);

                if (!empty($_FILES['ktp']['name'][0])) {
                    $listNamaBaru = array();
                    for ($i = 0; $i < $jumlahFile; $i++) {
                        $namaFile = $files['ktp']['name'][$i];
                        $lokasiTmp = $files['ktp']['tmp_name'][$i];

                        # kita tambahkan uniqid() agar nama gambar bersifat unik
                        $namaBaru = uniqid() . '-' . $namaFile;

                        array_push($listNamaBaru, $namaBaru);
                        $lokasiBaru = "{$folderUpload}/{$namaBaru}";
                        $prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);

                        # jika proses berhasil
                        if ($prosesUpload) {
                        } else {
                            $this->session->set_flashdata('message', 'Gambar gagal Ditambahkan');
                            $this->add();
                        }
                    }
                    $namaBaru = implode("+", $listNamaBaru);
                    $ktp = array('image' => $namaBaru);
                    $bukti_tracking = array('bukti' => $namaBaru);
                    $data = array_merge($data, $ktp);
                }

                // cek order berdasarkan id_so
                $get_last_order = $this->db->limit(1)->order_by('id', 'desc')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();
                // kalo shipment id nya null, maka update tbl nya
                if ($get_last_order['shipment_id'] == NULL) {
                    // echo 'kosong';
                    $update =  $this->db->update('tbl_shp_order', $data, ['id_so' => $this->input->post('id_so')]);
                    if ($update) {
                        $this->barcode($shipment_id);
                        $this->qrcode($shipment_id);
                        $data = array(
                            'shipment_id' => $shipment_id,
                            'status' => 'Shipment Telah Dipickup Dari Shipper',
                            'id_so' => $this->input->post('id_so'),
                            'created_at' => date('Y-m-d'),
                            'id_user' => $this->session->userdata('id_user'),
                            'pic_task' => $this->input->post('sender'),
                            'time' => date('H:i:s'),
                            'flag' => 3,
                            'status_eksekusi' => 0,
                        );
                        $data = array_merge($data, $bukti_tracking);
                        $this->db->insert('tbl_tracking_real', $data);
                        $data = array(
                            'status' => 2,
                        );
                        $this->db->update('tbl_so', $data, ['id_so' => $this->input->post('id_so')]);
                        $data = array(
                            'status_eksekusi' => 1,
                        );
                        $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $this->input->post('id_tracking')]);
                        $data = array(
                            'shipment_id' => $shipment_id,
                        );
                        $this->db->update('tbl_tracking_real', $data, ['id_so' => $this->input->post('id_so')]);
                        $this->session->set_flashdata('message', '<div class="alert
                     alert-success" role="alert">Success</div>');
                        redirect('finance/salesOrder/detail/' . $this->input->post('id_so'));
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert
                     alert-danger" role="alert">Failed Update</div>');
                        $this->add($this->input->post('id_so'));
                    }
                } else {
                    // kalo shipment id nya ada, maka insert tbl nya 
                    $insert =  $this->db->insert('tbl_shp_order', $data);
                    if ($insert) {
                        $this->barcode($shipment_id);
                        $this->qrcode($shipment_id);
                        $get_tracking = $this->db->get_where('tbl_tracking_real', ['id_so' => $this->input->post('id_so')])->result_array();
                        foreach ($get_tracking as $track) {
                            $data = array(
                                'shipment_id' => $shipment_id,
                                'status' => $track['status'],
                                'id_so' => $this->input->post('id_so'),
                                'created_at' => $track['created_at'],
                                'note' => $track['note'],
                                'bukti' => $track['bukti'],
                                'id_user' => $track['id_user'],
                                'update_at' => $track['update_at'],
                                'pic_task' => $track['pic_task'],
                                'time' => $track['time'],
                                'flag' => $track['flag'],
                                'status_eksekusi' => $track['status_eksekusi'],
                            );
                            $this->db->insert('tbl_tracking_real', $data);
                        }
                        $data = array(
                            'shipment_id' => $shipment_id,
                            'status' => 'Shipment Telah Dipickup Dari Shipper',
                            'id_so' => $this->input->post('id_so'),
                            'created_at' => date('Y-m-d'),
                            'id_user' => $this->session->userdata('id_user'),
                            'pic_task' => $this->input->post('sender'),
                            'time' => date('H:i:s'),
                            'flag' => 3,
                            'status_eksekusi' => 0,
                        );
                        $data = array_merge($data, $bukti_tracking);
                        $this->db->insert('tbl_tracking_real', $data);
                        $data = array(
                            'status' => 2,
                        );
                        $this->db->update('tbl_so', $data, ['id_so' => $this->input->post('id_so')]);
                        // $data = array(
                        //     'status_eksekusi' => 1,
                        // );
                        // $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $this->input->post('id_tracking')]);
                        $this->session->set_flashdata('message', '<div class="alert
                        alert-success" role="alert">Success</div>');
                        redirect('finance/salesOrder/detail/' . $this->input->post('id_so'));
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert
                     alert-danger" role="alert">Failed Insert</div>');
                        $this->add($this->input->post('id_so'));
                    }
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert
                 alert-danger" role="alert">Kota/Provinsi tidak ditemukan</div>');
                $this->add($this->input->post('id_so'));
            }
        }
    }


    public function updateShipment()
    {
        $status = $this->input->post('status');
        $flag = '';
        if ($status == 'Shipment Telah Tiba Di Hub') {
            $flag = 8;
        } else if ($status == 'Shipment Keluar Di Hub Tujuan') {
            $flag = 9;
        } else if ($status == 'Shipment Dalam Proses Delivery') {
            $flag = 10;
        } else {
            $flag = 11;
        }

        $id_so = $this->input->post('id_so');
        $shipment_id = $this->input->post('shipment_id');
        $data = array(
            'status' => $this->input->post('status') . ' ' . $this->input->post('note'),
            'note' => $this->input->post('note'),
            'id_so' => $id_so,
            'shipment_id' => $shipment_id,
            'created_at' => $this->input->post('date'),
            'time' => $this->input->post('time'),
            'flag' => $flag,
            'id_user' => $this->session->userdata('id_user'),
        );
        $config['upload_path'] = './uploads/berkas/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);

        $folderUpload = "./uploads/berkas/";
        $files = $_FILES;
        $files = $_FILES;
        $jumlahFile = count($files['ktp']['name']);
        if (!empty($_FILES['ktp']['name'][0])) {
            $listNamaBaru = array();
            for ($i = 0; $i < $jumlahFile; $i++) {
                $namaFile = $files['ktp']['name'][$i];
                $lokasiTmp = $files['ktp']['tmp_name'][$i];

                # kita tambahkan uniqid() agar nama gambar bersifat unik
                $namaBaru = uniqid() . '-' . $namaFile;

                array_push($listNamaBaru, $namaBaru);
                $lokasiBaru = "{$folderUpload}/{$namaBaru}";
                $prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);

                # jika proses berhasil
                if ($prosesUpload) {
                } else {
                    $this->session->set_flashdata('message', 'Gambar gagal Ditambahkan');
                    redirect('finance/salesOrder/detail/' . $id_so);
                }
            }
            $namaBaru = implode("+", $listNamaBaru);
            $ktp = array('bukti' => $namaBaru);
            $data = array_merge($data, $ktp);
        }
        $this->db->insert('tbl_tracking_real', $data);
        $this->session->set_flashdata('message', 'Update Sukses');
        redirect('finance/salesOrder/detail/' . $id_so);
    }

    public function updateShipmentIncoming()
    {
        $status = $this->input->post('status');
        $flag = '';
        if ($status == 'Shipment Telah Tiba Di Hub') {
            $flag = 4;
        } else {
            $flag = 5;
        }

        $id_so = $this->input->post('id_so');
        $shipment_id = $this->input->post('shipment_id');
        $data = array(
            'status' => $this->input->post('status') . ' ' . $this->input->post('note'),
            'note' => $this->input->post('note'),
            'id_so' => $id_so,
            'shipment_id' => $shipment_id,
            'created_at' => $this->input->post('date'),
            'time' => $this->input->post('time'),
            'flag' => $flag,
            'id_user' => $this->session->userdata('id_user'),
        );
        $config['upload_path'] = './uploads/berkas/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);

        $folderUpload = "./uploads/berkas/";
        $files = $_FILES;
        $files = $_FILES;
        $jumlahFile = count($files['ktp']['name']);
        if (!empty($_FILES['ktp']['name'][0])) {
            $listNamaBaru = array();
            for ($i = 0; $i < $jumlahFile; $i++) {
                $namaFile = $files['ktp']['name'][$i];
                $lokasiTmp = $files['ktp']['tmp_name'][$i];

                # kita tambahkan uniqid() agar nama gambar bersifat unik
                $namaBaru = uniqid() . '-' . $namaFile;

                array_push($listNamaBaru, $namaBaru);
                $lokasiBaru = "{$folderUpload}/{$namaBaru}";
                $prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);

                # jika proses berhasil
                if ($prosesUpload) {
                } else {
                    $this->session->set_flashdata('message', 'Gambar gagal Ditambahkan');
                    redirect('finance/salesOrder/detail/' . $id_so);
                }
            }
            $namaBaru = implode("+", $listNamaBaru);
            $ktp = array('bukti' => $namaBaru);
            $data = array_merge($data, $ktp);
        }
        $insert = $this->db->insert('tbl_tracking_real', $data);
        if ($insert) {
            if ($status == 'Shipment Keluar Di Hub') {
                $data = array(
                    'shipment_id' => $shipment_id,
                    'id_user' => 'null',
                    'status' => 'in',
                    'id_so' => $id_so,
                    'status_eksekusi' => 0
                );
                $this->db->insert('tbl_gateway', $data);
            }
            $this->session->set_flashdata('message', 'Sukses');
            redirect('finance/salesOrder/detail/' . $id_so);
        } else {
            $this->session->set_flashdata('message', 'failed');
            redirect('finance/salesOrder/detail/' . $id_so);
        }
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
        $data['shipment2'] =  $this->order->orderBySo($id)->result_array();
        $id_jabatan = $this->session->userdata('id_jabatan');
        $this->backend->display('finance/v_detail_order_luar_all', $data);
        // if ($id_jabatan == 9 || $id_jabatan == 2) {
        // } else {
        //     $this->backend->display('finance/v_detail_order_luar', $data);
        // }
    }
    public function approve($id_so)
    {
        $data = array(
            'id_so' => $id_so,
            'approve_finance' => $this->session->userdata('id_user'),
            'created_at_finance' => date('Y-m-d H:i:s'),
        );
        $update =  $this->db->update('tbl_approve_so', $data, ['id_so' => $id_so]);
        if ($update) {
            $data = array(
                'status_approve' => 3
            );
            $this->db->update('tbl_so', $data, ['id_so' => $id_so]);
        }
        $this->session->set_flashdata('message', '<div class="alert
        alert-success" role="alert">Success</div>');
        redirect('finance/salesOrder');
    }
    public function edit($id)
    {
        $data['title'] = 'Edit Sales Order';
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['p'] = $this->db->get_where('tbl_so', ['id_so' => $id])->row_array();
        $this->backend->display('finance/v_edit_order', $data);
    }
    function view_data_query()
    {
        $akses = $this->session->userdata('akses');
        // kalo dia atasan driver
        if ($akses == 1) {
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
    public function barcode($id)
    {
        // $koli = sprintf("%02s",  $koli);
        // for ($i = 1; $i <= $koli; $i++) {
        //     $koli_ke =  sprintf("%02s", $i);
        //     $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
        //     file_put_contents("uploads/barcode/$id-$koli_ke-$koli.jpg", $generator->getBarcode($id . '-' . $koli_ke . '-' . $koli, $generator::TYPE_CODE_128));
        // }
        $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
        file_put_contents("uploads/barcode/$id.jpg", $generator->getBarcode($id, $generator::TYPE_CODE_128));
        // $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        // $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG(); // Pixel based PNG
        // echo $generatorPNG->getBarcode($id, $generatorPNG::TYPE_CODE_128);
        // fix
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
        $this->dompdf->set_paper("A7", 'potrait');
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $sekarang = date("d:F:Y:h:m:s");
        // return $this->dompdf->output();
        $output = $this->dompdf->output();
        ob_end_clean();
        // file_put_contents('uploads/barcode' . '/' . "$shipment_id.pdf", $output);
        $this->dompdf->stream("Cetak" . $sekarang . ".pdf", array('Attachment' => 0));
    }
}
