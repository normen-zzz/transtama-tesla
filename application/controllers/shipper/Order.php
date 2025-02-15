<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        cek_role();
    }

    public function view($id)
    {
        $data['title'] = 'My Shipment';
        $data['order'] = $this->order->orderBySo($id)->result_array();
        $data['id_so'] = $id;
        $data['so'] = $this->db->select('type')->get_where('tbl_so', ['id_so' => $id])->row_array();
        $this->backend->display('shipper/v_orderv2', $data);
    }
    // public function view($id, $id_tracking)
    // {
    //     $data['title'] = 'My Shipment';
    //     $data['order'] = $this->order->orderBySo($id)->result_array();
    //     $data['id_so'] = $id;
    //     $data['id_tracking'] = $id_tracking;
    //     $data['so'] = $this->db->select('type')->get_where('tbl_so', ['id_so' => $id])->row_array();
    //     $this->backend->display('shipper/v_order', $data);
    // }
    public function detail($id, $id_so)
    {
        $data['title'] = 'Detail Order';
        $data['id_so'] = $id_so;
        $data['p'] = $this->order->order($id)->row_array();
        $this->backend->display('shipper/v_detail_pengajuan', $data);
    }
    public function edit($id, $id_so)
    {
        $data['title'] = 'Edit Order';
        $data['id_so'] = $id_so;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $data['province'] = $this->db->get('tb_province')->result_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['customer'] = $this->db->get('tb_customer')->result_array();
        $data['p'] = $this->order->order($id)->row_array();
        $data['moda'] = $this->db->get('tbl_moda')->result_array();
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
    public function add($id_so)
    {

        $data['title'] = 'Add Order';
        // $data['imagecamera'] = $img;
        $data['id_so'] = $id_so;

        $data['city'] = $this->db->get('tb_city')->result_array();
        $data['province'] = $this->db->get('tb_province')->result_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['customer'] = $this->db->get('tb_customer')->result_array();
        $data['moda'] = $this->db->get('tbl_moda')->result_array();
        $data['so'] = $this->db->get_where('tbl_so', ['id_so' => $id_so])->row_array();
        $dataDo = $this->db->get_where('do_requestpickup', ['id_so' => $id_so]);
        if ($dataDo) {
            $data['do'] = $dataDo;
        } else {
            $data['do'] = NULL;
        }
        $this->backend->display('shipper/v_order_add', $data);
    }
    // public function add($id_so, $id_tracking)
    // {

    //     $data['title'] = 'Add Order';
    //     // $data['imagecamera'] = $img;
    //     $data['id_so'] = $id_so;
    //     $data['id_tracking'] = $id_tracking;
    //     $data['city'] = $this->db->get('tb_city')->result_array();
    //     $data['province'] = $this->db->get('tb_province')->result_array();
    //     $data['service'] = $this->db->get('tb_service_type')->result_array();
    //     $data['customer'] = $this->db->get('tb_customer')->result_array();
    //     $data['moda'] = $this->db->get('tbl_moda')->result_array();
    //     $data['so'] = $this->db->get_where('tbl_so', ['id_so' => $id_so])->row_array();
    //     $this->backend->display('shipper/v_order_add', $data);
    // }
    public function bulk($id_so)
    {
        $data['title'] = 'Add Order';
        $data['id_so'] = $id_so;

        $this->backend->display('shipper/v_order_add_bulk', $data);
    }
    public function special($id_so, $id_tracking)
    {
        $data['title'] = 'Special Ordern';
        $data['id_so'] = $id_so;
        $data['id_tracking'] = $id_tracking;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $data['province'] = $this->db->get('tb_province')->result_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['customer'] = $this->db->get('tb_customer')->result_array();
        $this->backend->display('shipper/v_order_add_special', $data);
    }
    public function generateResi()
    {

        $data['title'] = 'Generate Resi';
        $data['customers'] = $this->db->get('tb_customer')->result_array();
        $data['generate'] = $this->order->getGenerate()->result_array();
        $this->backend->display('shipper/v_generate', $data);
    }
    public function detailGenerate($group)
    {
        $data['title'] = 'Detail Generate Resi';
        $data['generate'] = $this->db->get_where('tbl_booking_number_resi', ['group' => $group])->result_array();
        $this->backend->display('shipper/v_detail_generate', $data);
    }
    public function generatePdfGenerateResi($group)
    {
        $this->db->select('*, b.nama_pt,b.provinsi, b.kota');
        $this->db->from('tbl_booking_number_resi a');
        $this->db->join('tb_customer b', 'a.id_customer=b.id_customer');
        $this->db->where('a.group', $group);
        $this->db->where('a.status', 0);
        $data['orders'] = $this->db->get()->result_array();
        $this->load->view('superadmin/v_cetak_resi', $data);
        $html = $this->output->get_output();
        $this->load->library('dompdf_gen');
        $this->dompdf->set_paper("A7", 'potrait');
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $sekarang = date("d:F:Y:h:m:s");
        // return $this->dompdf->output();
        $output = $this->dompdf->output();
        // file_put_contents('uploads/barcode' . '/' . "$shipment_id.pdf", $output);
        $this->dompdf->stream("Cetak" . $sekarang . ".pdf", array('Attachment' => 0));
    }
    public function asignDriverGenerateResi()
    {
        $id_driver = $this->input->post('id_driver');
        $shipment_id = $this->input->post('shipment_id');
        $group = $this->input->post('group');
        for ($i = 0; $i < sizeof($shipment_id); $i++) {
            $data = array(
                'id_driver' => $id_driver,
            );
            $this->db->update('tbl_booking_number_resi', $data, ['shipment_id' => $shipment_id[$i]]);
        }
        redirect('shipper/order/detailGenerate/' . $group);
    }
    public function addShipmentGenerateResi($id_so, $id_tracking)
    {
        $data['title'] = 'Generate Resi Order';
        $data['id_so'] = $id_so;
        $data['id_tracking'] = $id_tracking;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $data['province'] = $this->db->get('tb_province')->result_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['customer'] = $this->db->get('tb_customer')->result_array();
        $this->backend->display('shipper/v_order_add_generate', $data);
    }
    public function processAddShipmentGenerateResi()
    {

        $this->form_validation->set_rules('shipment_id', 'Shipment_id', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'Harap Isi No Resi');
            $this->addShipmentGenerateResi($this->input->post('id_so'), $this->input->post('id_tracking'));
        } else {
            $this->db->where('shipment_id', $this->input->post('shipment_id'));
            $q = $this->db->get('tbl_booking_number_resi');
            $booking = $q->row_array();

            if ($q->num_rows() < 1 || $booking['status'] == 1) {
                $this->session->set_flashdata('message', 'Nomor Resi Tidak Ditemukan');
                $this->addShipmentGenerateResi($this->input->post('id_so'), $this->input->post('id_tracking'));
            } else {

                $img = $this->input->post('ttd');
                $img = str_replace('data:image/png;base64,', '', $img);
                $service_type = $this->input->post('service_type');
                $date = date('Y-m-d');
                $tahun = date("y");
                $bulan = date("m");
                $tgl = date("d");

                $shipment_id = $this->input->post('shipment_id');
                $shipmentGenerateResi = $this->db->get_where('tbl_booking_number_resi', array('shipment_id' => $shipment_id))->row_array();
                $customer = $this->db->get_where('tb_customer', array('nama_pt' => $shipmentGenerateResi['customer']))->row_array();
                // var_dump($shipment_id);
                // die;

                // kode referensi so
                //Mencari ANgka terbesar
                $sql = $this->db->query("SELECT max(so_id) as kode FROM tbl_shp_order")->row_array();
                $no = $sql['kode'];
                // SO - 0 0 0 0 0 0 0 0 9;
                $potongSO = ltrim($no, 'SO-');
                $potong = ltrim($potongSO, '0');
                $noUrut = $potong + 1;
                // $kode =  sprintf("%09s", $noUrut);
                $kode  = "SO-$noUrut";
                $deadline_sales = date('Y-m-d');

                // input no shipment
                $this->db->insert('tbl_no_resi', ['no_resi' => $shipment_id, 'created_by' => $this->session->userdata('id_user')]);

                $img = $this->input->post('ttd');
                $img = str_replace('data:image/png;base64,', '', $img);

                $get_pickup = $this->db->limit(1)->order_by('id', 'DESC')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();
                $service_type = $this->db->get_where('tb_service_type', array('service_name' => $get_pickup['pu_service']))->row_array();
                $data = array(
                    'shipper' => $shipmentGenerateResi['customer'],
                    'city_shipper' => $customer['kota'],
                    'state_shipper' => $customer['provinsi'],
                    'shipment_id' => $this->input->post('shipment_id'),
                    'is_jabodetabek' => $this->input->post('is_jabodetabek'),
                    'id_user' => $this->session->userdata('id_user'),
                    'service_type' => $service_type['code'],
                    'date_new' => date('Y-m-d'),
                    'so_id' => $kode,

                );


                // var_dump($data);
                $config['upload_path'] = './uploads/berkas_uncompress/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['encrypt_name'] = TRUE;
                // $this->upload->initialize($config);

                $folderUpload = "./uploads/berkas/";
                $files = $_FILES;
                $files = $_FILES;
                $jumlahFile = count($files['ktp2']['name']);
                if (!empty($_FILES['ktp2']['name'][0])) {
                    $listNamaBaru = array();
                    for ($i = 0; $i < $jumlahFile; $i++) {
                        $namaFile = $files['ktp2']['name'][$i];
                        $lokasiTmp = $files['ktp2']['tmp_name'][$i];
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
                    // $this->resizeImage($namaBaru);
                    $ktp = array('image' => $namaBaru);
                    $bukti_tracking = array('bukti' => $namaBaru);
                    $data = array_merge($data, $ktp);
                }
                // cek order berdasarkan id_so
                $get_last_order = $this->db->limit(1)->order_by('id', 'desc')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();
                // var_dump($get_last_order);
                // die;
                // kalo SO id nya null, maka update tbl nya
                if ($get_last_order['so_id'] == NULL) {
                    // echo 'kosong';
                    $update =  $this->db->update('tbl_shp_order', $data, ['id_so' => $this->input->post('id_so')]);
                    if ($update) {
                        // input no do
                        $no_do = $this->input->post('note_cs');
                        for ($i = 0; $i < sizeof($no_do); $i++) {
                            $data = array(
                                'shipment_id' => $shipment_id,
                                'no_do' => $no_do[$i]
                            );
                            $this->db->insert('tbl_no_do', $data);
                        }

                        // update no so berdasarkan shipment id
                        $no_so = $this->input->post('no_so');
                        $no_so = implode(",", $no_so);
                        $data = array(
                            'no_so' => $no_so
                        );
                        $this->db->update('tbl_no_do', $data, ['shipment_id' => $shipment_id]);
                        $this->db->update('tbl_booking_number_resi', array('status' => 1), ['shipment_id' => $shipment_id]);

                        $this->barcode($shipment_id);
                        $this->qrcode($shipment_id);
                        //Titik Gagal Beberapa shipper
                        $dataTrack = array(
                            'shipment_id' => $shipment_id,
                            'status' => 'Shipment Telah Dipickup Dari Shipper',
                            'id_so' => $this->input->post('id_so'),
                            'created_at' => date('Y-m-d'),
                            'id_user' => $this->session->userdata('id_user'),
                            'pic_task' => $this->input->post('sender'),
                            'time' => date('H:i:s'),
                            'flag' => 4,
                            'status_eksekusi' => 0,
                        );
                        //$data = array_merge($data, $bukti_tracking);
                        $this->db->insert('tbl_tracking_real', $dataTrack);
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
                        redirect('shipper/order/view/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert
                    alert-danger" role="alert">Failed Update</div>');
                        redirect('shipper/order/add/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
                    }
                } else {
                    // kalo shipment id nya ada, maka insert tbl nya 

                    $data2 = array(
                        'shipment_id' => $shipment_id,
                        'so_id' => $kode,
                        'shipper' => $shipmentGenerateResi['customer'],
                        'city_shipper' => $customer['kota'],
                        'state_shipper' => $customer['provinsi'],
                        'tree_shipper' => $this->getTreeLetterCode($customer['kota']),
                        'koli' => $get_last_order['koli'],
                        'date_new' => date('Y-m-d'),
                        'service_type' =>  $get_last_order['service_type'],
                        'id_so' => $get_last_order['id_so'],
                        'is_jabodetabek' => $get_last_order['is_jabodetabek'],
                        'packing_type' => $get_last_order['packing_type'],
                        'payment' => $get_last_order['payment'],
                        'tgl_pickup' => $get_last_order['tgl_pickup'],
                        'time' => $get_last_order['time'],
                        'pu_moda' => $get_last_order['pu_moda'],
                        'pu_poin' => $get_last_order['pu_poin'],
                        'pu_service' => $get_last_order['pu_service'],
                        'pu_commodity' => $get_last_order['pu_commodity'],
                        'pu_note' => $get_last_order['pu_note'],
                        'id_user' => $this->session->userdata('id_user'),
                        'is_incoming' => $get_last_order['is_incoming'],
                        'image' => $namaBaru
                    );
                    $insert =  $this->db->insert('tbl_shp_order', $data2);
                    if ($insert) {
                        //Update No Booking resi jadi unavailable
                        $this->db->update('tbl_booking_number_resi', array('status' => 1), array('shipment_id' => $shipment_id));
                        // input no do
                        $no_do = $this->input->post('note_cs');
                        for ($i = 0; $i < sizeof($no_do); $i++) {
                            $data = array(
                                'shipment_id' => $shipment_id,
                                'no_do' => $no_do[$i]
                            );
                            $this->db->insert('tbl_no_do', $data);
                        }
                        // update no so berdasarkan shipment id
                        $no_so = $this->input->post('no_so');
                        $no_so = implode(",", $no_so);
                        $data = array(
                            'no_so' => $no_so
                        );
                        $this->db->update('tbl_no_do', $data, ['shipment_id' => $shipment_id]);
                        $this->barcode($shipment_id);
                        $this->qrcode($shipment_id);
                        $get_tracking = $this->db->limit(3)->order_by('id_tracking', 'ASC')->get_where('tbl_tracking_real', ['id_so' => $this->input->post('id_so')])->result_array();
                        $dataTracking1 = array(
                            'shipment_id' => $shipment_id,
                            'status' => 'Request Pickup From Shipper',
                            'id_so' => $this->input->post('id_so'),
                            'created_at' => date('Y-m-d'),
                            'id_user' => $this->session->userdata('id_user'),
                            'time' => date('H:i:s'),
                            'flag' => 1,
                            'status_eksekusi' => 1,
                        );
                        $this->db->insert('tbl_tracking_real', $dataTracking1);

                        $dataTracking2 = array(
                            'shipment_id' => $shipment_id,
                            'status' => 'Driver Menuju Lokasi Pickup',
                            'id_so' => $this->input->post('id_so'),
                            'created_at' => date('Y-m-d'),
                            'id_user' => $this->session->userdata('id_user'),
                            'time' => date('H:i:s'),
                            'flag' => 2,
                            'status_eksekusi' => 1,
                        );
                        $this->db->insert('tbl_tracking_real', $dataTracking2);

                        $dataTracking3 = array(
                            'shipment_id' => $shipment_id,
                            'status' => 'Driver Telah Sampai Di Lokasi Pickup',
                            'id_so' => $this->input->post('id_so'),
                            'created_at' => date('Y-m-d'),
                            'id_user' => $this->session->userdata('id_user'),
                            'time' => date('H:i:s'),
                            'flag' => 3,
                            'status_eksekusi' => 1,
                        );
                        $this->db->insert('tbl_tracking_real', $dataTracking3);

                        $dataTracking4 = array(
                            'shipment_id' => $shipment_id,
                            'status' => 'Shipment Telah Dipickup Dari Shipper',
                            'id_so' => $this->input->post('id_so'),
                            'created_at' => date('Y-m-d'),
                            'id_user' => $this->session->userdata('id_user'),
                            'time' => date('H:i:s'),
                            'flag' => 4,
                            'status_eksekusi' => 0,
                        );
                        $this->db->insert('tbl_tracking_real', $dataTracking4);
                        $data = array(
                            'status' => 2,
                            'deadline_sales_so' => $deadline_sales
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
    }
    public function import()
    {
        $this->db->trans_start();
        try {
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
                $deadline_sales = date('Y-m-d');

                $queue = 0;
                foreach ($sheetData as $rowdata) {
                    if ($queue == 0) {
                        $queue += 1;
                    } else {
                        $date = date('Y-m-d');
                        $pickup_start = date('Y-m-d', strtotime('+1 days', strtotime($date)));

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

                        $sql = $this->db->query("SELECT no_resi as shipment_id FROM tbl_no_resi  ORDER BY id_no_resi DESC LIMIT 1")->row_array();
                        // var_dump($sql);
                        // die;
                        if ($sql == NULL) {
                            $noUrut = 1;
                            $shipment_id  = "$noUrut";
                        } else {
                            $last_shipment_id = $sql['shipment_id'];
                            $no = $last_shipment_id + 1;
                            $shipment_id =  ltrim($no, '0');
                        }
                        // input no shipment
                        $insertnoresi = $this->db->insert('tbl_no_resi', ['no_resi' => $shipment_id, 'created_by' => $this->session->userdata('id_user')]);
                        if (!$insertnoresi) {
                            throw new Exception('Error Insert No Resi');
                        }

                        // kode referensi so
                        $sql = $this->db->query("SELECT max(so_id) as kode FROM tbl_shp_order")->row_array();
                        $no = $sql['kode'];
                        // SO - 0 0 0 0 0 0 0 0 9;
                        $potongSO = ltrim($no, 'SO-');
                        $potong = ltrim($potongSO, '0');
                        $noUrut = $potong + 1;
                        // $kode =  sprintf("%09s", $noUrut);
                        $kode  = "SO-$noUrut";

                        $img = $this->input->post('ttd');
                        $img = str_replace('data:image/png;base64,', '', $img);
                        $get_pickup = $this->db->limit(1)->order_by('id', 'DESC')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();


                        // kode referensi so
                        $sql = $this->db->query("SELECT max(so_id) as kode FROM tbl_shp_order")->row_array();
                        $no = $sql['kode'];
                        // SO - 0 0 0 0 0 0 0 0 9;
                        $potongSO = ltrim($no, 'SO-');
                        $potong = ltrim($potongSO, '0');
                        $noUrut = $potong + 1;
                        // $kode =  sprintf("%09s", $noUrut);
                        $kode  = "SO-$noUrut";

                        $img = $this->input->post('ttd');
                        $img = str_replace('data:image/png;base64,', '', $img);
                        $city_shipper = $rowdata[2];
                        $city_consigne = $rowdata[6];

                        $get_pickup = $this->db->limit(1)->order_by('id', 'DESC')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();
                        $so = $this->db->get_where('tbl_so', ['id_so' => $this->input->post('id_so')])->row_array();

                        $data = array(
                            'shipper' => strtoupper($rowdata[0]),
                            'state_shipper' => $rowdata[1],
                            'city_shipper' => $rowdata[2],
                            'destination' => $rowdata[3],
                            'consigne' => strtoupper($rowdata[4]),
                            'state_consigne' => $rowdata[5],
                            'origin' => $this->input->post('origin'),
                            'city_consigne' => $rowdata[6],
                            'service_type' =>  $rowdata[7],
                            'koli' => $rowdata[8],
                            'sender' => $rowdata[9],
                            'note_cs' => '-',
                            'id_user' => $this->session->userdata('id_user'),
                            'signature' => $img,
                            'so_id' => $kode,
                            'tree_shipper' => $this->getTreeLetterCode($city_shipper),
                            'tree_consignee' => $this->getTreeLetterCode($city_consigne),
                            'shipment_id' => $shipment_id,
                            'is_jabodetabek' =>  2,
                            'date_new' => date('Y-m-d'),
                            'id_so' => $this->input->post('id_so'),
                            'tgl_pickup' => $so['tgl_pickup'],
                            'pu_moda' => $so['pu_moda'],
                            'pu_poin' => $so['pu_poin'],
                            'time' => $so['time'],
                            'pu_commodity' => $so['commodity'],
                            'pu_service' => $so['service'],
                            'pu_note' => $so['note'],
                            // 'city_shipper' => $get_pickup['city_shipper'],
                            'payment' => $so['payment'],
                            'packing_type' => $so['packing'],
                            'is_incoming' => $so['is_incoming'],

                        );
                       
                        // var_dump($get_last_order);
                        // die;
                        // kalo shipment id nya null, maka update tbl nya
                       
                            // kalo shipment id nya ada, maka insert tbl nya 
                            $insert =  $this->db->insert('tbl_shp_order', $data);
                            if ($insert) {
                                $this->barcode($shipment_id);
                                $this->qrcode($shipment_id);
                                $get_tracking = $this->db->limit(4)->order_by('id_tracking', 'ASC')->get_where('tbl_tracking_real', ['id_so' => $this->input->post('id_so')])->result_array();
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
                                    'deadline_sales_so' => $deadline_sales
                                );
                                $this->db->update('tbl_so', $data, ['id_so' => $this->input->post('id_so')]);
                            } else {
                                throw new Exception('Failed Insert to tbl shp order');
                            }
                        
                    }
                }
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    throw new Exception('Transaction failed');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert
                    alert-success" role="alert">Success</div>');
                    redirect('shipper/order/view/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
                }
            } else {
                throw new Exception('File not valid');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert
                        alert-danger" role="alert">' . $e->getMessage() . '</div>');
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
                                'flag' => 4,
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
        $this->form_validation->set_rules('shipper_id', 'Shipper_id', 'required');
        $this->form_validation->set_rules('id_so', 'Id_so', 'required');
        $this->form_validation->set_rules('is_jabodetabek', 'Is_jabodetabek', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'Failed');
            $this->add($this->input->post('id_so'), $this->input->post('id_tracking'));
        } else {

            $img = $this->input->post('ttd');
            $img = str_replace('data:image/png;base64,', '', $img);
            $service_type = $this->input->post('service_type');


            $sql = $this->db->query("SELECT no_resi as shipment_id FROM tbl_no_resi  ORDER BY id_no_resi DESC LIMIT 1")->row_array();
            // var_dump($sql);
            // die;
            if ($sql == NULL) {
                $noUrut = 1;
                // $kode =  sprintf("%06s", $noUrut);
                $shipment_id  = "$noUrut";
            } else {
                $last_shipment_id = $sql['shipment_id'];
                $no = $last_shipment_id + 1;
                $shipment_id =  $no;
            }

            // var_dump($shipment_id);
            // die;

            // kode referensi so
            $sql = $this->db->query("SELECT max(so_id) as kode FROM tbl_shp_order")->row_array();
            $no = $sql['kode'];
            // SO - 0 0 0 0 0 0 0 0 9;
            $potongSO = ltrim($no, 'SO-');
            $potong = ltrim($potongSO, '0');
            $noUrut = $potong + 1;
            // $kode =  sprintf("%09s", $noUrut);
            $kode  = "SO-$noUrut";
            $deadline_sales = date('Y-m-d');

            // input no shipment
            $this->db->insert('tbl_no_resi', ['no_resi' => $shipment_id, 'created_by' => $this->session->userdata('id_user')]);

            $img = $this->input->post('ttd');
            $img = str_replace('data:image/png;base64,', '', $img);
            $customer = $this->db->get_where('tb_customer', ['id_customer' => $this->input->post('shipper_id')])->row_array();
            $city_shipper = $customer['kota'];
            $city_consigne = $this->input->post('city_consigne');
            $so = $this->db->get_where('tbl_so', ['id_so' => $this->input->post('id_so')])->row_array();
            $data = array(
                'shipper' => strtoupper($customer['nama_pt']),
                'origin' => $this->input->post('origin'),
                'city_shipper' => $customer['kota'],
                'state_shipper' => $customer['provinsi'],
                'consigne' => strtoupper($this->input->post('consigne')),
                'destination' => $this->input->post('destination'),
                'city_consigne' => $this->input->post('city_consigne'),
                'state_consigne' => $this->input->post('state_consigne'),
                'koli' => $this->input->post('koli'),
                'is_jabodetabek' => $this->input->post('is_jabodetabek'),
                'sender' => $this->input->post('sender'),
                'note_driver' => $this->input->post('note_driver'),
                // 'note_cs' => $this->input->post('note_cs'),
                'id_so' => $this->input->post('id_so'),
                'id_user' => $this->session->userdata('id_user'),
                'signature' => $img,
                'tree_shipper' => $this->getTreeLetterCode($city_shipper),
                'tree_consignee' => $this->getTreeLetterCode($city_consigne),
                'shipment_id' => $shipment_id,
                // 'order_id' => $order_id,
                'service_type' =>  $service_type,
                'date_new' => date('Y-m-d'),
                'so_id' => $kode,
                'tgl_pickup' => date('Y-m-d'),
                'pu_moda' => $this->input->post('moda'),

            );

            // var_dump($data);
            $config['upload_path'] = './uploads/berkas_uncompress/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            // $this->upload->initialize($config);

            $folderUpload = "./uploads/berkas/";
            $files = $_FILES;
            $files = $_FILES;
            $jumlahFile = count($files['ktp2']['name']);
            if (!empty($_FILES['ktp2']['name'][0])) {
                $listNamaBaru = array();
                for ($i = 0; $i < $jumlahFile; $i++) {
                    $namaFile = $files['ktp2']['name'][$i];
                    $lokasiTmp = $files['ktp2']['tmp_name'][$i];
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
                //$this->resizeImage($namaBaru);
                $ktp = array('image' => $namaBaru);
                $bukti_tracking = array('bukti' => $namaBaru);
                $data = array_merge($data, $ktp);
            }
            $insert =  $this->db->insert('tbl_shp_order', $data);
            if ($insert) {
                // input no do
                $no_do = $this->input->post('note_cs');
                for ($i = 0; $i < sizeof($no_do); $i++) {
                    $data = array(
                        'shipment_id' => $shipment_id,
                        'no_do' => $no_do[$i]
                    );
                    $this->db->insert('tbl_no_do', $data);
                }
                // update no so berdasarkan shipment id
                $no_so = $this->input->post('no_so');
                $no_so = implode(",", $no_so);
                $data = array(
                    'no_so' => $no_so
                );
                $this->db->update('tbl_no_do', $data, ['shipment_id' => $shipment_id]);
                $this->barcode($shipment_id);
                $this->qrcode($shipment_id);
                $dataTracking1 = array(
                    'shipment_id' => $shipment_id,
                    'status' => ucwords(strtolower('permintaan pickup oleh pengirim')),
                    'id_so' => $this->input->post('id_so'),
                    'created_at' => $so['created_at'],
                    'id_user' => $this->session->userdata('id_user'),
                    'time' =>  $so['time'],
                    'flag' => 1,
                    'status_eksekusi' => 1,
                );
                $this->db->insert('tbl_tracking_real', $dataTracking1);

                $dataTracking2 = array(
                    'shipment_id' => $shipment_id,
                    'status' => ucwords(strtolower('Driver menuju lokasi pickup')),
                    'id_so' => $this->input->post('id_so'),
                    'created_at' =>  $so['pickup_at'],
                    'id_user' => $this->session->userdata('id_user'),
                    'time' =>  date('H:i:s', strtotime($so['pickup_at'])),
                    'flag' => 2,
                    'status_eksekusi' => 1,
                );
                $this->db->insert('tbl_tracking_real', $dataTracking2);

                $dataTracking3 = array(
                    'shipment_id' => $shipment_id,
                    'status' => ucwords(strtolower('Driver Telah Sampai Di Lokasi Pickup')),
                    'id_so' => $this->input->post('id_so'),
                    'created_at' =>  $so['arrived_at'],
                    'id_user' => $this->session->userdata('id_user'),
                    'time' =>  date('H:i:s', strtotime($so['arrived_at'])),
                    'flag' => 3,
                    'status_eksekusi' => 1,
                );
                $this->db->insert('tbl_tracking_real', $dataTracking3);

                $dataTracking4 = array(
                    'shipment_id' => $shipment_id,
                    'status' => ucwords(strtolower('Paket telah dipickup oleh driver')),
                    'id_so' => $this->input->post('id_so'),
                    'created_at' => date('Y-m-d'),
                    'id_user' => $this->session->userdata('id_user'),
                    'time' => date('H:i:s'),
                    'flag' => 4,
                    'status_eksekusi' => 1,
                );
                $this->db->insert('tbl_tracking_real', $dataTracking4);

                if ($service_type == '0aa2174a-5bab-4196-bc80-56c96457140e' || $service_type == 'd22c7bdf-2057-4233-9732-0c36d3cfde9c') {
                    $dataTracking5 = array(
                        'shipment_id' => $shipment_id,
                        'status' => 'Paket menuju lokasi penerima',
                        'id_so' => $this->input->post('id_so'),
                        'created_at' => date('Y-m-d'),
                        'id_user' => $this->session->userdata('id_user'),
                        'time' => date('H:i:s'),
                        'flag' => 5,
                        'status_eksekusi' => 1,
                    );
                    $this->db->insert('tbl_tracking_real', $dataTracking5);
                }


                $data = array(
                    'status' => 2,
                    'deadline_sales_so' => $deadline_sales
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

    public function doneShipmentDriver($id_so)
    {

        $updateSo = $this->db->update('tbl_so', ['status_pickup' => 4], ['id_so' => $id_so]);
        if ($updateSo) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success</div>');
            redirect('shipper/SalesOrder');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed Insert</div>');
            redirect('shipper/SalesOrder');
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
    //     $this->form_validation->set_rules('shipper_id', 'Shipper_id', 'required');
    //     $this->form_validation->set_rules('id_so', 'Id_so', 'required');
    //     $this->form_validation->set_rules('is_jabodetabek', 'Is_jabodetabek', 'required');
    //     if ($this->form_validation->run() == FALSE) {
    //         $this->session->set_flashdata('message', 'Failed');
    //         $this->add($this->input->post('id_so'), $this->input->post('id_tracking'));
    //     } else {

    //         $img = $this->input->post('ttd');
    //         $img = str_replace('data:image/png;base64,', '', $img);
    //         $service_type = $this->input->post('service_type');


    //         $sql = $this->db->query("SELECT no_resi as shipment_id FROM tbl_no_resi  ORDER BY id_no_resi DESC LIMIT 1")->row_array();
    //         // var_dump($sql);
    //         // die;
    //         if ($sql == NULL) {
    //             $noUrut = 1;
    //             // $kode =  sprintf("%06s", $noUrut);
    //             $shipment_id  = "$noUrut";
    //         } else {
    //             $last_shipment_id = $sql['shipment_id'];
    //             $no = $last_shipment_id + 1;
    //             $shipment_id =  $no;
    //         }

    //         // var_dump($shipment_id);
    //         // die;

    //         // kode referensi so
    //         $sql = $this->db->query("SELECT max(so_id) as kode FROM tbl_shp_order")->row_array();
    //         $no = $sql['kode'];
    //         // SO - 0 0 0 0 0 0 0 0 9;
    //         $potongSO = ltrim($no, 'SO-');
    //         $potong = ltrim($potongSO, '0');
    //         $noUrut = $potong + 1;
    //         // $kode =  sprintf("%09s", $noUrut);
    //         $kode  = "SO-$noUrut";
    //         $deadline_sales = date('Y-m-d');

    //         // input no shipment
    //         $this->db->insert('tbl_no_resi', ['no_resi' => $shipment_id, 'created_by' => $this->session->userdata('id_user')]);

    //         $img = $this->input->post('ttd');
    //         $img = str_replace('data:image/png;base64,', '', $img);
    //         $customer = $this->db->get_where('tb_customer', ['id_customer' => $this->input->post('shipper_id')])->row_array();
    //         $city_shipper = $customer['kota'];
    //         $city_consigne = $this->input->post('city_consigne');
    //         $get_pickup = $this->db->limit(1)->order_by('id', 'DESC')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();
    //         $data = array(
    //             'shipper' => strtoupper($customer['nama_pt']),
    //             'origin' => $this->input->post('origin'),
    //             'city_shipper' => $customer['kota'],
    //             'state_shipper' => $customer['provinsi'],
    //             'consigne' => strtoupper($this->input->post('consigne')),
    //             'destination' => $this->input->post('destination'),
    //             'city_consigne' => $this->input->post('city_consigne'),
    //             'state_consigne' => $this->input->post('state_consigne'),
    //             'koli' => $this->input->post('koli'),
    //             'is_jabodetabek' => $this->input->post('is_jabodetabek'),
    //             'sender' => $this->input->post('sender'),
    //             'note_driver' => $this->input->post('note_driver'),
    //             // 'note_cs' => $this->input->post('note_cs'),
    //             'id_so' => $this->input->post('id_so'),
    //             'id_user' => $this->session->userdata('id_user'),
    //             'signature' => $img,
    //             'tree_shipper' => $this->getTreeLetterCode($city_shipper),
    //             'tree_consignee' => $this->getTreeLetterCode($city_consigne),
    //             'shipment_id' => $shipment_id,
    //             // 'order_id' => $order_id,
    //             'service_type' =>  $service_type,
    //             'date_new' => date('Y-m-d'),
    //             'so_id' => $kode,
    //             'tgl_pickup' => date('Y-m-d'),
    //             'pu_moda' => $this->input->post('moda'),
    //             'pu_poin' => $get_pickup['pu_poin'],
    //             'time' => $get_pickup['time'],
    //             'pu_commodity' => $get_pickup['pu_commodity'],
    //             'pu_service' => $get_pickup['pu_service'],
    //             'pu_note' => $get_pickup['pu_note'],
    //             // 'city_shipper' => $get_pickup['city_shipper'],
    //             'payment' => $get_pickup['payment'],
    //             'packing_type' => $get_pickup['packing_type'],
    //             'is_incoming' => $get_pickup['is_incoming'],
    //         );

    //         // var_dump($data);
    //         $config['upload_path'] = './uploads/berkas_uncompress/';
    //         $config['allowed_types'] = 'jpg|png|jpeg';
    //         $config['encrypt_name'] = TRUE;
    //         // $this->upload->initialize($config);

    //         $folderUpload = "./uploads/berkas/";
    //         $files = $_FILES;
    //         $files = $_FILES;
    //         $jumlahFile = count($files['ktp2']['name']);
    //         if (!empty($_FILES['ktp2']['name'][0])) {
    //             $listNamaBaru = array();
    //             for ($i = 0; $i < $jumlahFile; $i++) {
    //                 $namaFile = $files['ktp2']['name'][$i];
    //                 $lokasiTmp = $files['ktp2']['tmp_name'][$i];
    //                 // # kita tambahkan uniqid() agar nama gambar bersifat unik
    //                 $namaBaru = uniqid() . '-' . $namaFile;

    //                 array_push($listNamaBaru, $namaBaru);
    //                 $lokasiBaru = "{$folderUpload}/{$namaBaru}";
    //                 $prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);

    //                 # jika proses berhasil
    //                 if ($prosesUpload) {
    //                     // $this->resizeImage($namaBaru);
    //                 } else {
    //                     // $this->session->set_flashdata('message', 'Gambar gagal Ditambahkan');
    //                     // $this->add($this->input->post('id_so'), $this->input->post('id_tracking'));
    //                 }
    //             }
    //             $namaBaru = implode("+", $listNamaBaru);
    //             //$this->resizeImage($namaBaru);
    //             $ktp = array('image' => $namaBaru);
    //             $bukti_tracking = array('bukti' => $namaBaru);
    //             $data = array_merge($data, $ktp);
    //         }
    //         // cek order berdasarkan id_so
    //         $get_last_order = $this->db->limit(1)->order_by('id', 'desc')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();
    //         // var_dump($get_last_order);
    //         // die;
    //         // kalo shipment id nya null, maka update tbl nya
    //         if ($get_last_order['so_id'] == NULL) {
    //             // echo 'kosong';
    //             $update =  $this->db->update('tbl_shp_order', $data, ['id_so' => $this->input->post('id_so')]);
    //             if ($update) {
    //                 // input no do
    //                 $no_do = $this->input->post('note_cs');
    //                 for ($i = 0; $i < sizeof($no_do); $i++) {
    //                     $data = array(
    //                         'shipment_id' => $shipment_id,
    //                         'no_do' => $no_do[$i]
    //                     );
    //                     $this->db->insert('tbl_no_do', $data);
    //                 }

    //                 // update no so berdasarkan shipment id
    //                 $no_so = $this->input->post('no_so');
    //                 $no_so = implode(",", $no_so);
    //                 $data = array(
    //                     'no_so' => $no_so
    //                 );
    //                 $this->db->update('tbl_no_do', $data, ['shipment_id' => $shipment_id]);

    //                 $this->barcode($shipment_id);
    //                 $this->qrcode($shipment_id);
    //                 $dataTracking = array(
    //                     'shipment_id' => $shipment_id,
    //                     'status' => 'Shipment Telah Dipickup Dari Shipper',
    //                     'id_so' => $this->input->post('id_so'),
    //                     'created_at' => date('Y-m-d'),
    //                     'id_user' => $this->session->userdata('id_user'),
    //                     'pic_task' => $this->input->post('sender'),
    //                     'time' => date('H:i:s'),
    //                     'flag' => 4,
    //                     'status_eksekusi' => 0,
    //                     'bukti' => $namaBaru
    //                 );
    //                 // $data = array_merge($data, $bukti_tracking);
    //                 $this->db->insert('tbl_tracking_real', $dataTracking);
    //                 $data = array(
    //                     'status' => 2,
    //                     'deadline_sales_so' => $deadline_sales
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
    //                 alert-success" role="alert">Success</div>');
    //                 redirect('shipper/order/view/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
    //             } else {
    //                 $this->session->set_flashdata('message', '<div class="alert
    //                 alert-danger" role="alert">Failed Update</div>');
    //                 redirect('shipper/order/add/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
    //             }
    //         } else {
    //             // kalo shipment id nya ada, maka insert tbl nya 
    //             $insert =  $this->db->insert('tbl_shp_order', $data);
    //             if ($insert) {
    //                 // input no do
    //                 $no_do = $this->input->post('note_cs');
    //                 for ($i = 0; $i < sizeof($no_do); $i++) {
    //                     $data = array(
    //                         'shipment_id' => $shipment_id,
    //                         'no_do' => $no_do[$i]
    //                     );
    //                     $this->db->insert('tbl_no_do', $data);
    //                 }
    //                 // update no so berdasarkan shipment id
    //                 $no_so = $this->input->post('no_so');
    //                 $no_so = implode(",", $no_so);
    //                 $data = array(
    //                     'no_so' => $no_so
    //                 );
    //                 $this->db->update('tbl_no_do', $data, ['shipment_id' => $shipment_id]);
    //                 $this->barcode($shipment_id);
    //                 $this->qrcode($shipment_id);
    //                 $getRequest = $this->db->limit(1)->order_by('id_tracking', 'ASC')->get_where('tbl_tracking_real', ['id_so' => $this->input->post('id_so'), 'flag' => 1])->row_array();
    //                 $getReceive = $this->db->limit(1)->order_by('id_tracking', 'ASC')->get_where('tbl_tracking_real', ['id_so' => $this->input->post('id_so'), 'flag' => 2])->row_array();
    //                 $getOnPointPickup = $this->db->limit(1)->order_by('id_tracking', 'ASC')->get_where('tbl_tracking_real', ['id_so' => $this->input->post('id_so'), 'flag' => 3])->row_array();
    //                 $dataTracking1 = array(
    //                     'shipment_id' => $shipment_id,
    //                     'status' => 'Request Pickup From Shipper',
    //                     'id_so' => $this->input->post('id_so'),
    //                     'created_at' => $getRequest['created_at'],
    //                     'id_user' => $this->session->userdata('id_user'),
    //                     'time' =>  $getRequest['time'],
    //                     'flag' => 1,
    //                     'status_eksekusi' => 1,
    //                 );
    //                 $this->db->insert('tbl_tracking_real', $dataTracking1);

    //                 $dataTracking2 = array(
    //                     'shipment_id' => $shipment_id,
    //                     'status' => 'Driver Menuju Lokasi Pickup',
    //                     'id_so' => $this->input->post('id_so'),
    //                     'created_at' =>  $getReceive['created_at'],
    //                     'id_user' => $this->session->userdata('id_user'),
    //                     'time' =>  $getReceive['time'],
    //                     'flag' => 2,
    //                     'status_eksekusi' => 1,
    //                 );
    //                 $this->db->insert('tbl_tracking_real', $dataTracking2);

    //                 $dataTracking3 = array(
    //                     'shipment_id' => $shipment_id,
    //                     'status' => 'Driver Telah Sampai Di Lokasi Pickup',
    //                     'id_so' => $this->input->post('id_so'),
    //                     'created_at' =>  $getOnPointPickup['created_at'],
    //                     'id_user' => $this->session->userdata('id_user'),
    //                     'time' =>  $getOnPointPickup['time'],
    //                     'flag' => 3,
    //                     'status_eksekusi' => 1,
    //                 );
    //                 $this->db->insert('tbl_tracking_real', $dataTracking3);

    //                 $dataTracking4 = array(
    //                     'shipment_id' => $shipment_id,
    //                     'status' => 'Shipment Telah Dipickup Dari Shipper',
    //                     'id_so' => $this->input->post('id_so'),
    //                     'created_at' => date('Y-m-d'),
    //                     'id_user' => $this->session->userdata('id_user'),
    //                     'time' => date('H:i:s'),
    //                     'flag' => 4,
    //                     'status_eksekusi' => 0,
    //                 );
    //                 $this->db->insert('tbl_tracking_real', $dataTracking4);
    //                 $data = array(
    //                     'status' => 2,
    //                     'deadline_sales_so' => $deadline_sales
    //                 );
    //                 $this->db->update('tbl_so', $data, ['id_so' => $this->input->post('id_so')]);

    //                 $this->session->set_flashdata('message', '<div class="alert
    //                 alert-success" role="alert">Success</div>');
    //                 redirect('shipper/order/view/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
    //             } else {
    //                 $this->session->set_flashdata('message', '<div class="alert
    //                 alert-danger" role="alert">Failed Insert</div>');
    //                 $this->add($this->input->post('id_so'), $this->input->post('id_tracking'));
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

    public function processEdit()
    {

        $img = $this->input->post('ttd');
        $img = str_replace('data:image/png;base64,', '', $img);
        $no_do = $this->input->post('note_cs');
        $no_do = implode(',', $no_do);
        $data = array(
            'consigne' => strtoupper($this->input->post('consigne')),
            'destination' => $this->input->post('destination'),
            'koli' => $this->input->post('koli'),
            'sender' => $this->input->post('sender'),
            'pu_moda' => $this->input->post('moda'),
            'note_driver' => $this->input->post('note_driver'),
            'note_cs' => $no_do,
            // 'no_so' => $this->input->post('no_so'),
            'no_stp' => $this->input->post('no_stp'),
            'tree_shipper' => $this->input->post('tree_shipper'),
            'tree_consignee' => $this->input->post('tree_consignee'),
            'service_type' => $this->input->post('service_type'),
            'city_consigne' => $this->input->post('city_consigne'),
            'state_consigne' => $this->input->post('state_consigne'),
        );
        //var_dump($data); die;
        if ($img != null) {
            $sig = array('signature' => $img);
            $data = array_merge($data, $sig);
        }

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

        $update =  $this->db->update('tbl_shp_order', $data, ['id' => $this->input->post('id')]);
        if ($update) {
            $id_do = $this->input->post('id_do');
            for ($i = 0; $i < sizeof($id_do); $i++) {
                $data = array(
                    'no_do' => $this->input->post('note_cs')[$i],
                    'no_so' => $this->input->post('no_so')
                );
                $this->db->update('tbl_no_do', $data, ['id_berat' => $id_do[$i]]);
            }
            $this->session->set_flashdata('message', '<div class="alert
                alert-success" role="alert">Success</div>');
            redirect('shipper/order/edit/' . $this->input->post('id') . '/' . $this->input->post('id_so'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert
                alert-danger" role="alert">Failed</div>');
            redirect('shipper/order/edit/' . $this->input->post('id') . '/' . $this->input->post('id_so'));
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

    public function printOutbond($id)
    {

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [74, 105]]);

        $where = array('shipment_id' => $id);
        $data['order'] = $this->db->get_where('tbl_shp_order', $where)->row_array();
        $where2 = array('code' => $data['order']['service_type']);
        $data['service'] = $this->db->get_where('tb_service_type', $where2)->row_array();
        // var_dump($data['order']);
        // die;
        // $this->load->view('superadmin/v_cetak', $data);


        $data = $this->load->view('superadmin/v_cetak_outbond', $data, TRUE);
        $mpdf->WriteHTML($data);
        $mpdf->Output();
    }
    public function completeTtd($id, $id_tracking)
    {
        $this->db->select('a.image,a.signature, a.shipment_id,a.id');
        $this->db->from('tbl_shp_order a');
        $this->db->where('a.id_so', $id);
        $this->db->order_by('a.id', 'ASC');
        $this->db->limit(1);
        $orders = $this->db->get()->row_array();
        if ($orders['image'] == NULL && $orders['signature'] == NULL) {
            $this->session->set_flashdata('message', '<div class="alert
                    alert-danger" role="alert">Gagal, Pastikan Data Pertama Dari Shipment Ini telah di Tanda tangan dan sudah ada POP</div>');
            redirect('shipper/order/view/' . $id . '/' . $id_tracking);
        } else {
            $data = array(
                'signature' => $orders['signature'],
                'image' => $orders['image']
            );
            $update = $this->db->update('tbl_shp_order', $data, ['id_so' => $id]);
            if ($update) {
                $this->session->set_flashdata('message', '<div class="alert
                    alert-success" role="alert">Success Duplicate Signature</div>');
                redirect('shipper/order/view/' . $id . '/' . $id_tracking);
            } else {
                $this->session->set_flashdata('message', '<div class="alert
                    alert-danger" role="alert">Gagal</div>');
                redirect('shipper/order/view/' . $id . '/' . $id_tracking);
            }
        }
    }
    public function printAll($id)
    {
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [74, 105]]);

        $where = array('id_so' => $id);
        $this->db->select('a.berat_js,a.shipment_id,a.id_so,a.shipper,a.tree_shipper,a.tree_consignee,a.consigne,a.destination,a.city_consigne,a.state_consigne,a.city_shipper,a.koli,a.is_weight_print,a.state_shipper,a.signature,a.created_at,a.sender,a.tgl_pickup, b.service_name, b.prefix');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tb_service_type b', 'a.service_type=b.code');
        $this->db->where('a.id_so', $id);
        $this->db->where('a.deleted', 0);
        $data['orders'] = $this->db->get()->result_array();
        $data = $this->load->view('shipper/v_cetak_all', $data, TRUE);
        $mpdf->WriteHTML($data);
        $mpdf->Output();
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
    public function downloadSpecial($id_so)
    {
        $detail = $this->db->get_where('tbl_so', ['id_so' => $id_so])->row_array();
        $shipments = $this->db->get_where('tbl_shp_order', ['id_so' => $id_so])->result_array();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Shipment ID');
        $sheet->setCellValue('B1', 'Shipper');
        $sheet->setCellValue('C1', 'Consignee');
        $sheet->setCellValue('D1', 'Destination');
        $sheet->setCellValue('E1', 'Provinsi');
        $sheet->setCellValue('F1', 'Kota');
        $sheet->setCellValue('G1', 'Service');
        $sheet->setCellValue('H1', 'Koli');
        $sheet->setCellValue('I1', 'PIC');
        $sheet->setCellValue('J1', 'NO.DO');
        $sheet->setCellValue('K1', 'Tree Shipper');
        $sheet->setCellValue('L1', 'Tree Consignee');
        $sheet->setCellValue('M1', 'Is Jabodetabek ?');
        $no = 1;
        $x = 2;
        foreach ($shipments as $row) {
            $sheet->setCellValue('A' . $x, $row['shipment_id'])->getColumnDimension('A')
                ->setAutoSize(true);
            $sheet->setCellValue('B' . $x, $row['shipper'])->getColumnDimension('B')
                ->setAutoSize(true);
            $sheet->setCellValue('C' . $x, $row['consigne'])->getColumnDimension('C')
                ->setAutoSize(true);
            $sheet->setCellValue('D' . $x, $row['destination'])->getColumnDimension('D')
                ->setAutoSize(true);
            $sheet->setCellValue('E' . $x, $row['state_consigne'])->getColumnDimension('E')
                ->setAutoSize(true);
            $sheet->setCellValue('F' . $x, $row['city_consigne'])->getColumnDimension('F')
                ->setAutoSize(true);
            $sheet->setCellValue('G' . $x, $row['service_type'])->getColumnDimension('G')
                ->setAutoSize(true);
            $sheet->setCellValue('H' . $x, $row['koli'])->getColumnDimension('H')
                ->setAutoSize(true);
            $sheet->setCellValue('I' . $x, $row['sender'])->getColumnDimension('I')
                ->setAutoSize(true);
            $sheet->setCellValue('J' . $x, $row['note_cs'])->getColumnDimension('J')
                ->setAutoSize(true);
            $sheet->setCellValue('K' . $x, $row['tree_shipper'])->getColumnDimension('K')
                ->setAutoSize(true);
            $sheet->setCellValue('L' . $x, $row['tree_consignee']);
            $sheet->setCellValue('M' . $x, $row['is_jabodetabek']);
            $x++;
        }
        $filename = "Order $detail[shipper]";

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
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
    function getTreeLetterCode($city)
    {
        $code = $this->db->get_where('tb_city', ['city_name' => $city])->row_array();
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
}
