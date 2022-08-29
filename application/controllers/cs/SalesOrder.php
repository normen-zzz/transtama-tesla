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
        $this->backend->display('cs/v_so', $data);
    }
    public function tracking($shipment_id = Null)
    {
        if ($shipment_id == NULL) {
            $shipment_id = $this->input->post('shipment_id');
            $data['shipment_id'] = $shipment_id;
            $data['tracking'] = $this->db->get_where('tbl_tracking_real', ['shipment_id' => $shipment_id])->result_array();
            $data['shipment'] = $this->db->get_where('tbl_shp_order', ['shipment_id' => $shipment_id])->row_array();
            $data['title'] = 'Sales Order';
            $this->backend->display('cs/v_tracking', $data);
        } else {
            $data['shipment_id'] = $shipment_id;
            $data['tracking'] = $this->db->get_where('tbl_tracking_real', ['shipment_id' => $shipment_id])->result_array();
            $data['shipment'] = $this->db->get_where('tbl_shp_order', ['shipment_id' => $shipment_id])->row_array();
            $data['title'] = 'Sales Order';
            $this->backend->display('cs/v_tracking', $data);
        }
    }
    public function deleteShipmentTracking($id_tracking, $shipment_id)
    {
        $delete = $this->db->delete('tbl_tracking_real', ['id_tracking' => $id_tracking]);
        if ($delete) {
            $this->session->set_flashdata('message', 'Delete Sukses');
            redirect('cs/salesOrder/tracking/' . $shipment_id);
        } else {
            $this->session->set_flashdata('message', 'Delete Gagal');
            redirect('cs/salesOrder/tracking/' . $shipment_id);
        }
    }
    public function updateShipmentTracking()
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
            'created_at' => $this->input->post('date'),
            'time' => $this->input->post('time'),
            'pic_task' => $this->input->post('note')
        );
        $config['upload_path'] = './uploads/berkas/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);

        $folderUpload = "./uploads/berkas_uncompress/";
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
                    redirect('cs/salesOrder/detail/' . $id_so);
                }
            }
            $namaBaru = implode("+", $listNamaBaru);
            $this->resizeImage($namaBaru);
            $ktp = array('bukti' => $namaBaru);
            $data = array_merge($data, $ktp);
        }
        $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $this->input->post('id_tracking')]);
        if ($status == "Shipment Telah Diterima Oleh") {
            // update tgl diterima
            $data = array(
                'tgl_diterima' => $this->input->post('date')
            );
            $this->db->update('tbl_shp_order', $data, ['shipment_id' => $shipment_id]);
        }
        $this->session->set_flashdata('message', 'Update Sukses');
        redirect('cs/salesOrder/tracking/' . $shipment_id);
    }

    public function updateShipmentTrackingAdd()
    {
        $status = $this->input->post('status');
        $flag = '';
        if ($status == 'Shipment Telah Tiba Di Hub') {
            $flag = 8;
        } else if ($status == 'Shipment Keluar Di Hub Tujuan') {
            $flag = 9;
        } else if ($status == 'Shipment Dalam Proses Delivery') {
            $flag = 10;
        } elseif ($status == 'Shipment Telah Diterima Oleh') {
            $flag = 11;
        } elseif ($status == 'Request Pickup From Shipper') {
            $flag = 1;
        } elseif ($status == 'Driver Menuju Lokasi Pickup') {
            $flag = 2;
        } elseif ($status == 'Shipment Telah Dipickup Dari Shipper') {
            $flag = 3;
        } elseif ($status == 'Shipment Telah Tiba Di Hub Jakarta Pusat') {
            $flag = 4;
        } elseif ($status == 'Shipment Keluar Dari Hub Jakarta Pusat') {
            $flag = 5;
        } elseif ($status == 'Shipment Telah Tiba Di Hub CGK' || $status == 'Shipment Telah Tiba Di Hub Jakarta Utara') {
            $flag = 6;
        } elseif ($status == 'Shipment Keluar Dari Hub CGK' || $status == 'Shipment Keluar Dari Hub Jakarta Utara') {
            $flag = 7;
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
            'id_user' => $this->input->post('id_user'),
            'status_eksekusi' => 1
        );
        $config['upload_path'] = './uploads/berkas/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);

        $folderUpload = "./uploads/berkas_uncompress/";
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
                    redirect('cs/salesOrder/tracking/' . $shipment_id);
                }
            }
        }
        $namaBaru = implode("+", $listNamaBaru);
        $this->resizeImage($namaBaru);
        $ktp = array('bukti' => $namaBaru);
        $data = array_merge($data, $ktp);
        $this->db->insert('tbl_tracking_real', $data);

        if ($status == "Shipment Telah Diterima Oleh") {
            // update tgl diterima
            $data = array(
                'tgl_diterima' => $this->input->post('date')
            );
            $this->db->update('tbl_shp_order', $data, ['shipment_id' => $shipment_id]);
        }
        $this->session->set_flashdata('message', 'Update Sukses');
        redirect('cs/salesOrder/tracking/' . $shipment_id);
    }
    public function add($id_so)
    {
        // $data['imagecamera'] = $img;
        $data['id_so'] = $id_so;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $data['province'] = $this->db->get('tb_province')->result_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['customer'] = $this->db->get('tb_customer')->result_array();
        $this->backend->display('cs/v_order_add', $data);
    }
    // public function add($id_so)
    // {
    //     $data['title'] = 'Add Order';
    //     // $cek_api = $this->Api->kirim();
    //     // $cek_api = json_decode($cek_api);
    //     // $cek_api = $cek_api->accessToken;
    //     // $data = [
    //     //     'token' => $cek_api,
    //     // ];
    //     // $this->session->set_userdata($data);
    //     // $data['imagecamera'] = $img;
    //     $data['id_so'] = $id_so;
    //     $data['city'] = $this->db->get('tb_city')->result_array();
    //     $data['province'] = $this->db->get('tb_province')->result_array();
    //     $data['service'] = $this->db->get('tb_service_type')->result_array();
    //     $data['customer'] = $this->db->get('tb_customer')->result_array();
    //     $this->backend->display('cs/v_order_add', $data);
    // }
    public function bulk($id_so)
    {

        $data['id_so'] = $id_so;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $data['province'] = $this->db->get('tb_province')->result_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['customer'] = $this->db->get('tb_customer')->result_array();
        $this->backend->display('cs/v_order_add_bulk', $data);
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

                $startTime = date("H:i:s", time() + 600);

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
                // echo $new;
                // die;
                if ($new) {

                    $order_id = $new[0];
                    $shipment_id  = $new[1];

                    // kode referensi so
                    $sql = $this->db->query("SELECT max(so_id) as kode FROM tbl_shp_order")->row_array();
                    $no = $sql['kode'];
                    // SO - 0 0 0 0 0 0 0 0 9;
                    $potong = substr($no, 3);
                    $noUrut = $potong + 1;
                    $kode =  sprintf("%09s", $noUrut);
                    $kode  = "SO-$kode";

                    $img = $this->input->post('ttd');
                    $img = str_replace('data:image/png;base64,', '', $img);
                    $province_shipper = $rowdata[1];
                    $province_consigne = $rowdata[5];
                    $get_pickup = $this->db->limit(1)->order_by('id', 'DESC')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();

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
                        'so_id' => $kode,
                        'tree_shipper' => $this->getTreeLetterCode($province_shipper),
                        'tree_consignee' => $this->getTreeLetterCode($province_consigne),
                        'shipment_id' => $shipment_id,
                        'order_id' => $order_id,
                        'service_type' =>  $rowdata[7],
                        'is_jabodetabek' =>  $rowdata[10],
                        'date_new' => date('Y-m-d'),
                        'id_so' => $this->input->post('id_so'),
                        'tgl_pickup' => $get_pickup['tgl_pickup'],
                        'pu_moda' => $get_pickup['pu_moda'],
                        'pu_poin' => $get_pickup['pu_poin'],
                        'time' => $get_pickup['time'],
                        'pu_commodity' => $get_pickup['pu_commodity'],
                        'pu_service' => $get_pickup['pu_service'],
                        'pu_note' => $get_pickup['pu_note'],
                        'city_shipper' => $get_pickup['city_shipper'],
                        'payment' => $get_pickup['payment'],
                        'packing_type' => $get_pickup['packing_type'],
                        'is_incoming' => $get_pickup['is_incoming'],

                    );
                    // cek order berdasarkan id_so
                    $get_last_order = $this->db->limit(1)->order_by('id', 'desc')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();
                    // var_dump($get_last_order);
                    // die;
                    // kalo shipment id nya null, maka update tbl nya
                    if ($get_last_order['so_id'] == NULL) {
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
                            //         $this->session->set_flashdata('message', '<div class="alert
                            // alert-success" role="alert">Success</div>');
                            //         redirect('shipper/order/view/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
                        } else {
                            //         $this->session->set_flashdata('message', '<div class="alert
                            // alert-danger" role="alert">Failed Update</div>');
                            //         redirect('shipper/order/add/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
                        }
                    } else {
                        // kalo shipment id nya ada, maka insert tbl nya 
                        $insert =  $this->db->insert('tbl_shp_order', $data);
                        if ($insert) {
                            $this->barcode($shipment_id);
                            $this->qrcode($shipment_id);
                            $get_tracking = $this->db->limit(3)->order_by('id_tracking', 'ASC')->get_where('tbl_tracking_real', ['id_so' => $this->input->post('id_so')])->result_array();
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
                                'status' => 2,
                            );
                            $this->db->update('tbl_so', $data, ['id_so' => $this->input->post('id_so')]);
                            //         $this->session->set_flashdata('message', '<div class="alert
                            // alert-success" role="alert">Success</div>');
                            //         redirect('shipper/order/view/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
                        } else {
                            //         $this->session->set_flashdata('message', '<div class="alert
                            // alert-danger" role="alert">Failed Insert</div>');
                            //         $this->add($this->input->post('id_so'), $this->input->post('id_tracking'));
                        }
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert
                alert-danger" role="alert">Kota/Provinsi tidak ditemukan</div>');
                    $this->add($this->input->post('id_so'), $this->input->post('id_tracking'));
                }
            }
            $this->session->set_flashdata('message', '<div class="alert
                        alert-success" role="alert">Success</div>');
            redirect('shipper/order/view/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert
                    alert-danger" role="alert">Silahkan Upload File</div>');
            redirect('shipper/order/bulk/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
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
            $img = $this->input->post('ttd');
            $img = str_replace('data:image/png;base64,', '', $img);
            $service_type = $this->input->post('service_type');

            $sql = $this->db->query("SELECT max(no_resi) as shipment_id FROM tbl_no_resi  ORDER BY id_no_resi DESC LIMIT 1")->row_array();
            // var_dump($sql);
            // die;
            if ($sql == NULL) {
                $noUrut = 1;
                $kode =  sprintf("%06s", $noUrut);
                $shipment_id  = "$kode";
            } else {
                $last_shipment_id = $sql['shipment_id'];
                $no = $last_shipment_id + 1;
                $shipment_id =  sprintf("%06s", $no);
            }

            // kode referensi so
            $sql = $this->db->query("SELECT max(so_id) as kode FROM tbl_shp_order")->row_array();
            $no = $sql['kode'];
            // SO - 0 0 0 0 0 0 0 0 9;
            $potong = substr($no, 3);
            $noUrut = $potong + 1;
            $kode =  sprintf("%09s", $noUrut);
            $kode  = "SO-$kode";
            $img = $this->input->post('ttd');
            $img = str_replace('data:image/png;base64,', '', $img);

            $deadline_sales = date('Y-m-d');
            // input no shipment
            $this->db->insert('tbl_no_resi', ['no_resi' => $shipment_id, 'created_by' => $this->session->userdata('id_user')]);

            $city_shipper = $this->input->post('city_shipper2');
            $city_consigne = $this->input->post('city_consigne');
            $get_pickup = $this->db->limit(1)->order_by('id', 'DESC')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();
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
                'tree_shipper' => $this->getTreeLetterCode($city_shipper),
                'tree_consignee' => $this->getTreeLetterCode($city_consigne),
                'shipment_id' => $shipment_id,
                'order_id' => null,
                'service_type' =>  $service_type,
                'date_new' => date('Y-m-d'),
                'so_id' => $kode,
                'tgl_pickup' => $get_pickup['tgl_pickup'],
                'pu_moda' => $get_pickup['pu_moda'],
                'pu_poin' => $get_pickup['pu_poin'],
                'time' => $get_pickup['time'],
                'pu_commodity' => $get_pickup['pu_commodity'],
                'pu_service' => $get_pickup['pu_service'],
                'pu_note' => $get_pickup['pu_note'],
                // 'city_shipper' => $get_pickup['city_shipper'],
                'payment' => $get_pickup['payment'],
                'packing_type' => $get_pickup['packing_type'],
                'is_incoming' => $get_pickup['is_incoming'],

            );

            // var_dump($data);
            $config['upload_path'] = './uploads/berkas/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);

            $folderUpload = "./uploads/berkas_uncompress/";
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
                        // $this->session->set_flashdata('message', 'Gambar gagal Ditambahkan');
                        // $this->add();
                    }
                }
                $namaBaru = implode("+", $listNamaBaru);
                $this->resizeImage($namaBaru);
                $ktp = array('image' => $namaBaru);
                $bukti_tracking = array('bukti' => $namaBaru);
                $data = array_merge($data, $ktp);
            }
            // cek order berdasarkan id_so
            $get_last_order = $this->db->limit(1)->order_by('id', 'desc')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();
            // kalo shipment id nya null, maka update tbl nya
            if ($get_last_order['so_id'] == NULL) {
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
                        'deadline_sales_so' => $deadline_sales
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
                    redirect('cs/salesOrder/detail/' . $this->input->post('id_so'));
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
                        'deadline_sales_so' => $deadline_sales
                    );
                    $this->db->update('tbl_so', $data, ['id_so' => $this->input->post('id_so')]);
                    // $data = array(
                    //     'status_eksekusi' => 1,
                    // );
                    // $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $this->input->post('id_tracking')]);
                    $this->session->set_flashdata('message', '<div class="alert
                        alert-success" role="alert">Success</div>');
                    redirect('cs/salesOrder/detail/' . $this->input->post('id_so'));
                } else {
                    $this->session->set_flashdata('message', '<div class="alert
                     alert-danger" role="alert">Failed Insert</div>');
                    $this->add($this->input->post('id_so'));
                }
            }
        }
    }
    // public function processAdd()
    // {
    //     $this->form_validation->set_rules('consigne', 'consigne', 'required');
    //     $this->form_validation->set_rules('state_consigne', 'State_consigne', 'required');
    //     $this->form_validation->set_rules('destination', 'Destination', 'required');
    //     $this->form_validation->set_rules('service_type', 'Service_type', 'required');
    //     $this->form_validation->set_rules('ttd', 'Ttd', 'required');
    //     $this->form_validation->set_rules('city_consigne', 'City_consigne', 'required');
    //     $this->form_validation->set_rules('state_consigne', 'State_consigne', 'required');
    //     $this->form_validation->set_rules('koli', 'Koli', 'required');
    //     $this->form_validation->set_rules('state_shipper2', 'State_shipper2', 'required');
    //     $this->form_validation->set_rules('city_shipper2', 'City_shipper2', 'required');
    //     $this->form_validation->set_rules('shipper2', 'Shipper2', 'required');
    //     $this->form_validation->set_rules('shipper_id', 'Shipper_id', 'required');
    //     $this->form_validation->set_rules('origin_destination', 'Origin_destination', 'required');
    //     $this->form_validation->set_rules('id_so', 'Id_so', 'required');
    //     $this->form_validation->set_rules('is_jabodetabek', 'Is_jabodetabek', 'required');
    //     if ($this->form_validation->run() == FALSE) {
    //         $this->session->set_flashdata('message', 'Failed');
    //         $this->detail($this->input->post('id_so'));
    //     } else {
    //         $img = $this->input->post('ttd');
    //         $img = str_replace('data:image/png;base64,', '', $img);
    //         $service_type = $this->input->post('service_type');
    //         $date = date('Y-m-d');
    //         $tahun = date("y");
    //         $bulan = date("m");
    //         $tgl = date("d");

    //         $sql = $this->db->query("SELECT max(shipment_id) as shipment_id FROM tbl_shp_order WHERE date_new = '$date' ORDER BY id DESC LIMIT 1")->row_array();
    //         // var_dump($sql);
    //         // die;
    //         if ($sql == NULL) {
    //             $shipment_id = "QC01$tahun$bulan$tgl";
    //             $order_id = "QR01$tahun$bulan$tgl";
    //             $shipment_id = $shipment_id . '00001';
    //             $order_id = $order_id . '00001';
    //         } else {
    //             $shipment_id = "QC01$tahun$bulan$tgl";
    //             $order_id = "QR01$tahun$bulan$tgl";
    //             $last_shipment_id = $sql['shipment_id'];
    //             $potong = substr($last_shipment_id, 10);

    //             $no = $potong + 1;

    //             $kode =  sprintf("%05s", $no);
    //             $shipment_id  = "$shipment_id$kode";
    //             $order_id = "$order_id$kode";
    //         }
    //         // var_dump($shipment_id);
    //         // die;

    //         // $no = $sql['kode'];
    //         // // SO - 0 0 0 0 0 0 0 0 9;
    //         // $potong = substr($no, 3);

    //         // QC 01 200423 22448
    //         // $order_id = $new[0];
    //         // $shipment_id  = $new[1];
    //         // kode referensi so
    //         $sql = $this->db->query("SELECT max(so_id) as kode FROM tbl_shp_order")->row_array();
    //         $no = $sql['kode'];
    //         // SO - 0 0 0 0 0 0 0 0 9;
    //         $potong = substr($no, 3);
    //         $noUrut = $potong + 1;
    //         $kode =  sprintf("%09s", $noUrut);
    //         $kode  = "SO-$kode";

    //         $img = $this->input->post('ttd');
    //         $img = str_replace('data:image/png;base64,', '', $img);
    //         $province_shipper = $this->input->post('state_shipper2');
    //         $province_consigne = $this->input->post('state_consigne');
    //         $get_pickup = $this->db->limit(1)->order_by('id', 'DESC')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();
    //         $data = array(
    //             'shipper' => strtoupper($this->input->post('shipper2')),
    //             'origin' => $this->input->post('origin'),
    //             'city_shipper' => $this->input->post('city_shipper2'),
    //             'state_shipper' => $this->input->post('state_shipper2'),
    //             'consigne' => strtoupper($this->input->post('consigne')),
    //             'destination' => $this->input->post('destination'),
    //             'city_consigne' => $this->input->post('city_consigne'),
    //             'state_consigne' => $this->input->post('state_consigne'),
    //             'koli' => $this->input->post('koli'),
    //             'is_jabodetabek' => $this->input->post('is_jabodetabek'),
    //             'sender' => $this->input->post('sender'),
    //             'note_driver' => $this->input->post('note_driver'),
    //             'note_cs' => $this->input->post('note_cs'),
    //             'id_so' => $this->input->post('id_so'),
    //             'id_user' => $this->session->userdata('id_user'),
    //             'signature' => $img,
    //             'tree_shipper' => $this->getTreeLetterCode($province_shipper),
    //             'tree_consignee' => $this->getTreeLetterCode($province_consigne),
    //             'shipment_id' => $shipment_id,
    //             'order_id' => $order_id,
    //             'service_type' =>  $service_type,
    //             'date_new' => date('Y-m-d'),
    //             'so_id' => $kode,
    //             'tgl_pickup' => $get_pickup['tgl_pickup'],
    //             'pu_moda' => $this->input->post('moda'),
    //             'pu_poin' => $get_pickup['pu_poin'],
    //             'time' => $get_pickup['time'],
    //             'pu_commodity' => $get_pickup['pu_commodity'],
    //             'pu_service' => $get_pickup['pu_service'],
    //             'pu_note' => $get_pickup['pu_note'],
    //             'city_shipper' => $get_pickup['city_shipper'],
    //             'payment' => $get_pickup['payment'],
    //             'packing_type' => $get_pickup['packing_type'],
    //             'is_incoming' => $get_pickup['is_incoming'],
    //         );

    //         // var_dump($data);
    //         $config['upload_path'] = './uploads/berkas_uncompress/';
    //         $config['allowed_types'] = 'jpg|png|jpeg';
    //         $config['encrypt_name'] = TRUE;
    //         $this->upload->initialize($config);

    //         $folderUpload = "./uploads/berkas_uncompress/";
    //         $files = $_FILES;
    //         $files = $_FILES;
    //         $jumlahFile = count($files['ktp']['name']);

    //         if (!empty($_FILES['ktp']['name'][0])) {
    //             $listNamaBaru = array();
    //             for ($i = 0; $i < $jumlahFile; $i++) {
    //                 $namaFile = $files['ktp']['name'][$i];
    //                 $lokasiTmp = $files['ktp']['tmp_name'][$i];

    //                 # kita tambahkan uniqid() agar nama gambar bersifat unik
    //                 $namaBaru = uniqid() . '-' . $namaFile;

    //                 array_push($listNamaBaru, $namaBaru);
    //                 $lokasiBaru = "{$folderUpload}/{$namaBaru}";
    //                 $prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);

    //                 # jika proses berhasil
    //                 if ($prosesUpload) {
    //                 } else {
    //                     // $this->session->set_flashdata('message', 'Gambar gagal Ditambahkan');
    //                     // $this->add();
    //                 }
    //             }
    //             $namaBaru = implode("+", $listNamaBaru);
    //             $this->resizeImage($namaBaru);
    //             $ktp = array('image' => $namaBaru);
    //             $bukti_tracking = array('bukti' => $namaBaru);
    //             $data = array_merge($data, $ktp);
    //         }
    //         // cek order berdasarkan id_so
    //         $get_last_order = $this->db->limit(1)->order_by('id', 'desc')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();
    //         // kalo shipment id nya null, maka update tbl nya
    //         if ($get_last_order['so_id'] == NULL) {
    //             // echo 'kosong';
    //             $update =  $this->db->update('tbl_shp_order', $data, ['id_so' => $this->input->post('id_so')]);
    //             if ($update) {
    //                 $this->barcode($shipment_id);
    //                 $this->qrcode($shipment_id);
    //                 $data = array(
    //                     'shipment_id' => $shipment_id,
    //                     'status' => 'Shipment Telah Dipickup Dari Shipper',
    //                     'id_so' => $this->input->post('id_so'),
    //                     'created_at' => date('Y-m-d'),
    //                     'id_user' => $this->session->userdata('id_user'),
    //                     'pic_task' => $this->input->post('sender'),
    //                     'time' => date('H:i:s'),
    //                     'flag' => 3,
    //                     'status_eksekusi' => 0,
    //                 );
    //                 $data = array_merge($data, $bukti_tracking);
    //                 $this->db->insert('tbl_tracking_real', $data);
    //                 $data = array(
    //                     'status' => 2,
    //                 );
    //                 $this->db->update('tbl_so', $data, ['id_so' => $this->input->post('id_so')]);
    //                 $data = array(
    //                     'status_eksekusi' => 1,
    //                 );
    //                 $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $this->input->post('id_tracking')]);
    //                 $data = array(
    //                     'shipment_id' => $shipment_id,
    //                 );
    //                 $this->db->update('tbl_tracking_real', $data, ['id_so' => $this->input->post('id_so')]);
    //                 $this->session->set_flashdata('message', '<div class="alert
    //                  alert-success" role="alert">Success</div>');
    //                 redirect('cs/salesOrder/detail/' . $this->input->post('id_so'));
    //             } else {
    //                 $this->session->set_flashdata('message', '<div class="alert
    //                  alert-danger" role="alert">Failed Update</div>');
    //                 $this->add($this->input->post('id_so'));
    //             }
    //         } else {
    //             // kalo shipment id nya ada, maka insert tbl nya 
    //             $insert =  $this->db->insert('tbl_shp_order', $data);
    //             if ($insert) {
    //                 $this->barcode($shipment_id);
    //                 $this->qrcode($shipment_id);
    //                 $get_tracking = $this->db->get_where('tbl_tracking_real', ['id_so' => $this->input->post('id_so')])->result_array();
    //                 foreach ($get_tracking as $track) {
    //                     $data = array(
    //                         'shipment_id' => $shipment_id,
    //                         'status' => $track['status'],
    //                         'id_so' => $this->input->post('id_so'),
    //                         'created_at' => $track['created_at'],
    //                         'note' => $track['note'],
    //                         'bukti' => $track['bukti'],
    //                         'id_user' => $track['id_user'],
    //                         'update_at' => $track['update_at'],
    //                         'pic_task' => $track['pic_task'],
    //                         'time' => $track['time'],
    //                         'flag' => $track['flag'],
    //                         'status_eksekusi' => $track['status_eksekusi'],
    //                     );
    //                     $this->db->insert('tbl_tracking_real', $data);
    //                 }
    //                 $data = array(
    //                     'shipment_id' => $shipment_id,
    //                     'status' => 'Shipment Telah Dipickup Dari Shipper',
    //                     'id_so' => $this->input->post('id_so'),
    //                     'created_at' => date('Y-m-d'),
    //                     'id_user' => $this->session->userdata('id_user'),
    //                     'pic_task' => $this->input->post('sender'),
    //                     'time' => date('H:i:s'),
    //                     'flag' => 3,
    //                     'status_eksekusi' => 0,
    //                 );
    //                 $data = array_merge($data, $bukti_tracking);
    //                 $this->db->insert('tbl_tracking_real', $data);
    //                 $data = array(
    //                     'status' => 2,
    //                 );
    //                 $this->db->update('tbl_so', $data, ['id_so' => $this->input->post('id_so')]);
    //                 // $data = array(
    //                 //     'status_eksekusi' => 1,
    //                 // );
    //                 // $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $this->input->post('id_tracking')]);
    //                 $this->session->set_flashdata('message', '<div class="alert
    //                     alert-success" role="alert">Success</div>');
    //                 redirect('cs/salesOrder/detail/' . $this->input->post('id_so'));
    //             } else {
    //                 $this->session->set_flashdata('message', '<div class="alert
    //                  alert-danger" role="alert">Failed Insert</div>');
    //                 $this->add($this->input->post('id_so'));
    //             }
    //         }
    //     }
    // }
    public function resizeImage($filename)
    {
        $files = explode("+", $filename);
        // var_dump($files);
        // die;
        for ($i = 0; $i < sizeof($files); $i++) {
            $source_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/berkas_uncompress/' . $files[$i];
            $target_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/berkas/';
            $config_manip = array(
                'image_library' => 'gd2',
                'source_image' => $source_path,
                'new_image' => $target_path,
                'maintain_ratio' => TRUE,
                'width' => 500,
            );

            $this->load->library('image_lib');
            $this->image_lib->initialize($config_manip);
            $this->image_lib->resize();
            $this->image_lib->clear();
            // if (!$this->image_lib->resize()) {
            //     echo $this->image_lib->display_errors();
            // }
            // $this->image_lib->resize();
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

        $folderUpload = "./uploads/berkas_uncompress/";
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
                    redirect('cs/salesOrder/detail/' . $id_so);
                }
            }
            $namaBaru = implode("+", $listNamaBaru);
            $this->resizeImage($namaBaru);
            $ktp = array('bukti' => $namaBaru);
            $data = array_merge($data, $ktp);
        }
        $this->db->insert('tbl_tracking_real', $data);
        $this->session->set_flashdata('message', 'Update Sukses');
        redirect('cs/salesOrder/detail/' . $id_so);
    }

    public function updateShipmentIncoming()
    {
        $service = $this->input->post('service');
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
            'status_eksekusi' => 1,
            'id_user' => $this->session->userdata('id_user'),
        );
        $config['upload_path'] = './uploads/berkas/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);

        $folderUpload = "./uploads/berkas_uncompress/";
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
                    redirect('cs/salesOrder/detail/' . $id_so);
                }
            }
            $namaBaru = implode("+", $listNamaBaru);
            $this->resizeImage($namaBaru);
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
                    'status_eksekusi' => 0,
                    'service' => $service,
                    'is_incoming' => 1
                );
                $this->db->insert('tbl_gateway', $data);
            }
            $this->session->set_flashdata('message', 'Sukses');
            redirect('cs/salesOrder/detail/' . $id_so);
        } else {
            $this->session->set_flashdata('message', 'failed');
            redirect('cs/salesOrder/detail/' . $id_so);
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
        // kali dia manager atau pic jobsheet
        // if ($id_jabatan == 9 || $id_jabatan == 2) {
        //     $this->backend->display('cs/v_detail_order_luar_all', $data);
        // } else {
        //     $this->backend->display('cs/v_detail_order_luar', $data);
        // }
        $this->backend->display('cs/v_detail_order_luar', $data);
    }
    public function approve($id_so)
    {
        $data = array(
            'id_so' => $id_so,
            'approve_cs' => $this->session->userdata('id_user'),
            'created_at_cs' => date('Y-m-d H:i:s'),
        );
        $update =  $this->db->update('tbl_approve_so', $data, ['id_so' => $id_so]);
        if ($update) {
            $data = array(
                'status_approve' => 2
            );
            $this->db->update('tbl_so', $data, ['id_so' => $id_so]);
        }
        $this->session->set_flashdata('message', '<div class="alert
        alert-success" role="alert">Success</div>');
        redirect('cs/salesOrder');
    }
    public function edit($id)
    {
        $data['title'] = 'Edit Sales Order';
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['p'] = $this->db->get_where('tbl_so', ['id_so' => $id])->row_array();
        $this->backend->display('cs/v_edit_order', $data);
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

    function getTreeLetterCode($city)
    {
        $code = $this->db->get_where('tb_city', ['city_name' => $city])->row_array();
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
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [74, 105]]);

        $where = array('shipment_id' => $id);
        $data['order'] = $this->db->get_where('tbl_shp_order', $where)->row_array();
        $where2 = array('code' => $data['order']['service_type']);
        $data['service'] = $this->db->get_where('tb_service_type', $where2)->row_array();
        // var_dump($data['order']);
        // die;
        // $this->load->view('superadmin/v_cetak', $data);


        $data = $this->load->view('superadmin/v_cetak', $data, TRUE);
        $mpdf->WriteHTML($data);
        $mpdf->Output();
    }
}
