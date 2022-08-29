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

    public function view($id, $id_tracking)
    {
        $data['title'] = 'My Shipment';
        $data['order'] = $this->order->orderBySo($id)->result_array();
        $data['id_so'] = $id;
        $data['id_tracking'] = $id_tracking;
        $this->backend->display('shipper/v_order', $data);
    }
    public function detail($id, $id_so)
    {
        $data['title'] = 'Detail Order';
        $data['id_so'] = $id_so;
        $data['p'] = $this->order->order($id)->row_array();
        $this->backend->display('shipper/v_detail_pengajuan', $data);
    }
    public function edit($id, $id_so, $id_tracking)
    {
        $data['title'] = 'Edit Order';
        $data['id_so'] = $id_so;
        $data['id_tracking'] = $id_tracking;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $data['province'] = $this->db->get('tb_province')->result_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['customer'] = $this->db->get('tb_customer')->result_array();
        $data['p'] = $this->order->order($id)->row_array();
        $this->backend->display('shipper/v_edit_order', $data);
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

    public function camera()
    {
        $data['title'] = 'Camera';
        $data['order'] = $this->db->order_by('id', 'DESC')->get_where('tbl_shp_order', ['id_user' => $this->session->userdata('id_user')])->result_array();
        $this->backend->display('shipper/v_camera', $data);
    }
    public function addImage()
    {

        $img = $this->input->post('image');
        redirect('shipper/order/add/' . $img);
    }
    public function add($id_so, $id_tracking)
    {

        $data['title'] = 'Add Order';
        // $cek_api = $this->Api->kirim();
        // $cek_api = json_decode($cek_api);
        // $cek_api = $cek_api->accessToken;
        // $data = [
        //     'token' => $cek_api,
        // ];
        // $this->session->set_userdata($data);
        // $data['imagecamera'] = $img;
        $data['id_so'] = $id_so;
        $data['id_tracking'] = $id_tracking;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $data['province'] = $this->db->get('tb_province')->result_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['customer'] = $this->db->get('tb_customer')->result_array();
        $this->backend->display('shipper/v_order_add', $data);
    }
    public function bulk($id_so, $id_tracking)
    {
        $data['title'] = 'Add Order';
        // $cek_api = $this->Api->kirim();
        // $cek_api = json_decode($cek_api);
        // $cek_api = $cek_api->accessToken;
        // $data = [
        //     'token' => $cek_api,
        // ];
        // $this->session->set_userdata($data);
        $data['id_so'] = $id_so;
        $data['id_tracking'] = $id_tracking;
        // var_dump($id_tracking);
        // die;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $data['province'] = $this->db->get('tb_province')->result_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['customer'] = $this->db->get('tb_customer')->result_array();
        $this->backend->display('shipper/v_order_add_bulk', $data);
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

                $koli = $rowdata[8];
                $img = $this->input->post('ttd');
                $img = str_replace('data:image/png;base64,', '', $img);
                $service_type = $this->input->post('service_type');
                $date = date('Y-m-d');
                $tahun = date("y");
                $bulan = date("m");
                $tgl = date("d");
                // var_dump($tgl);
                // die;


                $sql = $this->db->query("SELECT max(shipment_id) as shipment_id FROM tbl_shp_order WHERE date_new = '$date' ORDER BY id DESC LIMIT 1")->row_array();
                // var_dump($sql);
                // die;
                if ($sql == NULL) {
                    $shipment_id = "QC01$tahun$bulan$tgl";
                    $order_id = "QR01$tahun$bulan$tgl";
                    $shipment_id = $shipment_id . '00001';
                    $order_id = $order_id . '00001';
                } else {
                    $shipment_id = "QC01$tahun$bulan$tgl";
                    $order_id = "QR01$tahun$bulan$tgl";
                    $last_shipment_id = $sql['shipment_id'];
                    $potong = substr($last_shipment_id, 10);

                    $no = $potong + 1;

                    $kode =  sprintf("%05s", $no);
                    $shipment_id  = "$shipment_id$kode";
                    $order_id = "$order_id$kode";
                }
                // var_dump($shipment_id);
                // die;

                // $no = $sql['kode'];
                // // SO - 0 0 0 0 0 0 0 0 9;
                // $potong = substr($no, 3);

                // QC 01 200423 22448
                // $order_id = $new[0];
                // $shipment_id  = $new[1];
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
                $get_pickup = $this->db->limit(1)->order_by('id', 'DESC')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();


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
                    'note_cs' => $rowdata[10],
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
    public function importSpecial()
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
            // print_r($sheetData);
            foreach ($sheetData as $rowdata) {
                // cek apakah no resi ada di tbl_master_booking_resi
                $new = $this->db->select('shipment_id,qr_id,id_booking')->get_where('tbl_booking_number_resi', ['shipment_id' => $rowdata[0], 'status' => 0])->row_array();
                // echo $new;
                // die;
                if ($new) {
                    $order_id = $new['qr_id'];
                    $shipment_id  = $new['shipment_id'];
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
                    // $province_shipper = $rowdata[2];
                    // $province_consigne = $rowdata[6];
                    $get_pickup = $this->db->limit(1)->order_by('id', 'DESC')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();

                    $data = array(
                        'shipper' => strtoupper($rowdata[1]),
                        'origin' => $this->input->post('origin'),
                        'city_shipper' => $rowdata[3],
                        'state_shipper' => $rowdata[2],
                        'consigne' => strtoupper($rowdata[5]),
                        'destination' => $rowdata[4],
                        'city_consigne' => $rowdata[7],
                        'state_consigne' => $rowdata[6],
                        'koli' => $rowdata[9],
                        'sender' => $rowdata[10],
                        'note_cs' => $rowdata[11],
                        'id_user' => $this->session->userdata('id_user'),
                        'signature' => $img,
                        'so_id' => $kode,
                        'tree_shipper' => $rowdata[12],
                        'tree_consignee' => $rowdata[13],
                        'shipment_id' => $shipment_id,
                        'order_id' => $order_id,
                        'service_type' =>  $rowdata[8],
                        'is_jabodetabek' =>  $rowdata[14],
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
                        } else {
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
                        } else {
                        }
                    }
                    $data = array(
                        'status' => 1,
                    );
                    $this->db->update('tbl_booking_number_resi', $data, ['id_booking' => $new['id_booking']]);
                }
                //  else {
                //     $this->session->set_flashdata('message', '<div class="alert
                // alert-danger" role="alert">Nomor Resi Tidak Tersedia</div>');
                //     redirect('shipper/order/view/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
                // }
            }
            $this->session->set_flashdata('message', '<div class="alert
                        alert-success" role="alert">Success</div>');
            redirect('shipper/order/view/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert
                    alert-danger" role="alert">Silahkan Upload File</div>');
            redirect('shipper/order/special/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
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
            $this->add($this->input->post('id_so'), $this->input->post('id_tracking'));
        } else {

            $img = $this->input->post('ttd');
            $img = str_replace('data:image/png;base64,', '', $img);
            $service_type = $this->input->post('service_type');
            $date = date('Y-m-d');
            $tahun = date("y");
            $bulan = date("m");
            $tgl = date("d");
            // var_dump($tgl);
            // die;


            $sql = $this->db->query("SELECT max(shipment_id) as shipment_id FROM tbl_shp_order WHERE date_new = '$date' ORDER BY id DESC LIMIT 1")->row_array();
            // var_dump($sql);
            // die;
            if ($sql == NULL) {
                $shipment_id = "QC01$tahun$bulan$tgl";
                $order_id = "QR01$tahun$bulan$tgl";
                $shipment_id = $shipment_id . '00001';
                $order_id = $order_id . '00001';
            } else {
                $shipment_id = "QC01$tahun$bulan$tgl";
                $order_id = "QR01$tahun$bulan$tgl";
                $last_shipment_id = $sql['shipment_id'];
                $potong = substr($last_shipment_id, 10);

                $no = $potong + 1;

                $kode =  sprintf("%05s", $no);
                $shipment_id  = "$shipment_id$kode";
                $order_id = "$order_id$kode";
            }
            // var_dump($shipment_id);
            // die;

            // $no = $sql['kode'];
            // // SO - 0 0 0 0 0 0 0 0 9;
            // $potong = substr($no, 3);

            // QC 01 200423 22448
            // $order_id = $new[0];
            // $shipment_id  = $new[1];
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
            $province_shipper = $this->input->post('state_shipper2');
            $province_consigne = $this->input->post('state_consigne');
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
                'note_driver' => $this->input->post('note_driver'),
                'note_cs' => $this->input->post('note_cs'),
                'id_so' => $this->input->post('id_so'),
                'id_user' => $this->session->userdata('id_user'),
                'signature' => $img,
                'tree_shipper' => $this->getTreeLetterCode($province_shipper),
                'tree_consignee' => $this->getTreeLetterCode($province_consigne),
                'shipment_id' => $shipment_id,
                'order_id' => $order_id,
                'service_type' =>  $service_type,
                'date_new' => date('Y-m-d'),
                'so_id' => $kode,
                'tgl_pickup' => $get_pickup['tgl_pickup'],
                'pu_moda' => $this->input->post('moda'),
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

            // var_dump($data);
            $config['upload_path'] = './uploads/berkas_uncompress/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            // $this->upload->initialize($config);

            $folderUpload = "./uploads/berkas_uncompress/";
            $files = $_FILES;
            $files = $_FILES;
            $jumlahFile = count($files['ktp']['name']);
            if (!empty($_FILES['ktp']['name'][0])) {
                $listNamaBaru = array();
                for ($i = 0; $i < $jumlahFile; $i++) {
                    $namaFile = $files['ktp']['name'][$i];
                    $lokasiTmp = $files['ktp']['tmp_name'][$i];
                    // # kita tambahkan uniqid() agar nama gambar bersifat unik
                    $namaBaru = uniqid() . '-' . $namaFile;

                    array_push($listNamaBaru, $namaBaru);
                    $lokasiBaru = "{$folderUpload}/{$namaBaru}";
                    $prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);

                    # jika proses berhasil
                    if ($prosesUpload) {
                        // $this->resizeImage($namaBaru);
                    } else {
                        // $this->session->set_flashdata('message', 'Gambar gagal Ditambahkan');
                        // $this->add($this->input->post('id_so'), $this->input->post('id_tracking'));
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
                    redirect('shipper/order/view/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
                } else {
                    $this->session->set_flashdata('message', '<div class="alert
                    alert-danger" role="alert">Failed Update</div>');
                    redirect('shipper/order/add/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
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

                    $this->session->set_flashdata('message', '<div class="alert
                    alert-success" role="alert">Success</div>');
                    redirect('shipper/order/view/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
                } else {
                    $this->session->set_flashdata('message', '<div class="alert
                    alert-danger" role="alert">Failed Insert</div>');
                    $this->add($this->input->post('id_so'), $this->input->post('id_tracking'));
                }
            }
        }
    }

    public function processEdit()
    {
        $img = $this->input->post('ttd');
        $img = str_replace('data:image/png;base64,', '', $img);
        $data = array(
            'consigne' => strtoupper($this->input->post('consigne')),
            'destination' => $this->input->post('destination'),
            'koli' => $this->input->post('koli'),
            'tree_consignee' => $this->input->post('tree_consignee'),
            'tree_shipper' => $this->input->post('tree_shipper'),
            'city_consigne' => $this->input->post('city_consigne'),
            'state_consigne' => $this->input->post('state_consigne'),
            'pu_moda' => $this->input->post('moda'),
            'note_driver' => $this->input->post('note_driver'),
            'sender' => $this->input->post('sender'),
            'note_cs' => $this->input->post('note_cs'),
            'service_type' => $this->input->post('service_type'),
            // 'signature' => $img,
        );
        if ($img != null) {
            $sig = array('signature' => $img);
            $data = array_merge($data, $sig);
        }

        // var_dump($data);
        $config['upload_path'] = './uploads/berkas/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);

        if (!empty($_FILES['ktp']['name'])) {
            if ($this->upload->do_upload('ktp')) {
                $data_ktp = $this->upload->data();
                $file = $data_ktp['file_name'];
                $ktp = array('image' => $file);
                $data = array_merge($data, $ktp);
            }
        }

        $update =  $this->db->update('tbl_shp_order', $data, ['id' => $this->input->post('id')]);
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert
                alert-success" role="alert">Success</div>');
            redirect('shipper/order/edit/' . $this->input->post('id') . '/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert
                alert-danger" role="alert">Failed</div>');
            redirect('shipper/order/edit/' . $this->input->post('id') . '/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
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

    function get_autocomplete()
    {
        $q = $this->input->post('term');
        $result = $this->order->search_blog($q);
        if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    'consigne' => $row->consigne,
                    'address'   => $row->destination,
                );
            echo json_encode($arr_result);
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
    function get_consigne()
    {
        $kode = $this->input->post('kode');
        // $consigne = $_GET['consigne'];
        $data = $this->order->get_data_consigne($kode);
        echo json_encode($data);
    }
    function fetch()
    {
        // var_dump($this->uri->segment(4));
        // die;
        echo $this->order->fetch_data($this->uri->segment(4));
    }
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
}
