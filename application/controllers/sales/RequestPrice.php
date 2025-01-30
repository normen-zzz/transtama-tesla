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
        $this->load->library('form_validation');
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
        $this->backend->display('sales/requestprice/v_request_price', $data);
    }

    public function detailRequestPrice($id)
    {
        $data['title'] = 'Request Price';
        $data['provinsi'] = $this->db->get('tb_province');
        $data['kota'] = $this->db->get('tb_city');
        $data['moda'] = $this->db->get('tbl_moda');
        $data['customer'] = $this->db->get('tb_customer');
        $data['detailRequestPrice'] = $this->sales->getDetailRequestPrice(NULL, $id)->row_array();
        $this->backend->display('sales/requestprice/v_detailRequestPrice', $data);
    }


    public function addRequestPrice()
    {
        $this->load->library('form_validation');
        $data['title'] = 'Add Request Price';
        $data['provinsi'] = $this->db->get('tb_province');
        $data['kota'] = $this->db->get('tb_city');
        $data['moda'] = $this->db->get('tbl_moda');
        $data['customer'] = $this->db->get('tb_customer');
        $this->backend->display('sales/requestprice/v_addRequestPrice', $data);
    }

    public function editRequestPrice($id)
    {
        $data['title'] = 'Request Price';
        $data['provinsi'] = $this->db->get('tb_province');
        $data['kota'] = $this->db->get('tb_city');
        $data['moda'] = $this->db->get('tbl_moda');
        $data['customer'] = $this->db->get('tb_customer');
        $data['detailRequestPrice'] = $this->sales->getDetailRequestPrice($this->session->userdata('id_user'), $id)->row_array();
        $this->backend->display('sales/requestprice/v_editRequestPrice', $data);
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
            $countPengajuan = count($provinsi_from);
            $namaUser = $this->session->userdata('nama_user');
            if ($updateLog) {
                $pesan = "Hallo CS, ada" . $countPengajuan . " pengajuan oleh" . $namaUser . ", Silahkan cek di menu request price. Terima Kasih";

                $wa = $this->wa->pickup('+6285697780467', "$pesan");
                if ($wa) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit</div>');
                    redirect('sales/RequestPrice');
                }
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




    public function detailRequestPriceBulk($code)
    {
        $provinsi = $this->wilayah->getDataProvinsi();
        $data['title'] = 'Request Price Detail Bulk';
        $data['requestPrice'] = $this->sales->getDetailRequestPriceBulk($code);
        $data['provinsi'] = $provinsi->data;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $this->backend->display('sales/requestprice/v_request_price_bulk', $data);
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

    public function addSo($id_detailrequest)
    {
        $detailRequest = $this->db->get_where('detailrequest_price', ['id_detailrequest' => $id_detailrequest])->row_array();
        $data['detailrequest'] = $detailRequest;
        $data['title'] = 'Add Sales Order';
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['moda'] = $this->db->get('tbl_moda')->result_array();
        $data['packing'] = $this->db->get('tbl_packing')->result_array();
        $data['customer'] = $this->db->get_where('tb_customer', ['id_customer' => $detailRequest['customer']])->row_array();
        $this->backend->display('sales/requestprice/v_so_request_price', $data);
    }

    public function processAddSo($id_detailrequest)
    {
        $this->form_validation->set_rules('tgl_pickup', 'tgl_pickup', 'required');
        $this->form_validation->set_rules('shipper', 'shipper', 'required');
        $this->form_validation->set_rules('pu_moda', 'pu_moda', 'required');
        $this->form_validation->set_rules('pu_poin', 'pu_poin', 'required');
        $this->form_validation->set_rules('destination', 'destination', 'trim');
        $this->form_validation->set_rules('time', 'time', 'required');
        $this->form_validation->set_rules('is_incoming', 'is_incoming', 'required');
        $this->form_validation->set_rules('koli', 'koli', 'trim');
        $this->form_validation->set_rules('packing', 'packing', 'trim');
        $this->form_validation->set_rules('kg', 'kg', 'trim');
        $this->form_validation->set_rules('commodity', 'commodity', 'required');
        $this->form_validation->set_rules('service', 'service', 'required');
        $this->form_validation->set_rules('note', 'note', 'trim');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'Failed');
            $this->addSo($id_detailrequest);
        } else {
            $id_atasan = $this->db->get_where('tb_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
            $data = array(
                'tgl_pickup' => $this->input->post('tgl_pickup'),
                'shipper' => strtoupper($this->input->post('shipper')),
                'pu_moda' => $this->input->post('pu_moda'),
                'pu_poin' => strtoupper($this->input->post('pu_poin')),
                'destination' => $this->input->post('destination'),
                'time' => $this->input->post('time'),
                'koli' => $this->input->post('koli'),
                'kg' => $this->input->post('kg'),
                'type' => $this->input->post('type'),
                'commodity' => $this->input->post('commodity'),
                'service' => $this->input->post('service'),
                'note' => $this->input->post('note'),
                'shipper_address' => $this->input->post('shipper_address'),
                'consigne' => $this->input->post('consigne'),
                'consigne_address' => $this->input->post('consigne_address'),
                'payment' => $this->input->post('payment'),
                'packing' => $this->input->post('packing'),
                'is_incoming' => $this->input->post('is_incoming'),
                'id_sales' => $this->session->userdata('id_user'),
                'id_atasan_sales' => $id_atasan['id_atasan']
            );
            $id_atasan = $this->session->userdata('id_atasan');
            // kalo dia atasan
            if ($id_atasan == 0 || $id_atasan == NULL) {
                $data_approve = array(
                    'status_approve' => 1,
                );
                $data = array_merge($data, $data_approve);
            } else {
                $data_approve = array(
                    'status_approve' => 0,
                );
                $data = array_merge($data, $data_approve);
            }
            // var_dump($data);
            // die;

            $insert =  $this->db->insert('tbl_so', $data);
            // var_dump($insert);
            // die;
            if ($insert) {
                $shipper = strtoupper($this->input->post('shipper'));
                $tgl_pickup = $this->input->post('tgl_pickup');
                $pu_moda = $this->input->post('pu_moda');
                $time = $this->input->post('time');
                $commodity = $this->input->post('commodity');
                $note = $this->input->post('note');
                $sales = $this->session->userdata('nama_user');
                $destination = $this->input->post('destination');
                $pu_poin = strtoupper($this->input->post('pu_poin'));
                $service = $this->input->post('service');
                if ($destination != '' || $destination != NULL) {
                    $pesanDestination = "dengan tujuan *$destination*";
                } else {
                    $pesanDestination = "";
                }

                $pesanPickUp = "dan pick up di *$pu_poin*";
                $pesan = "Hallo Cs dan Ops, ada pickup dari *$shipper* $pesanDestination $pesanPickUp *$service* tanggal *$tgl_pickup* jam *$time* dengan moda $pu_moda dengan jenis barang $commodity. Catatan : $note. *Sales : $sales*";
                // kirim wa
                $this->wa->pickup('+6285697780467', "$pesan"); //Nomor Norman IT
                // $this->wa->pickup('+6281293753199', "$pesan"); //Nomor Bu Lili CS
                // $this->wa->pickup('+6285894438583', "$pesan"); //Mba Yunita  CS
                // $this->wa->pickup('+6281387909059', "$pesan"); //TYA  CS
                // $this->wa->pickup('+6281212603705', "$pesan"); //Mas Ali OPS
                // $this->wa->pickup('+6281398433940', "$pesan"); //Sarwan OPS
                $random = random_string('numeric', 8);

                $get_last_id_so = $this->db->limit(1)->order_by('id_so', 'DESC')->get('tbl_so')->row_array(); // mencari data terakhir yang baru diinput di tbl so
                $data = array(
                    'status' => 'Request Pickup From Shipper',
                    'id_so' => $get_last_id_so['id_so'],
                    'created_at' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'flag' => 1,
                    'status_eksekusi' => 0,
                    'shipment_id' => $random
                );
                $this->db->insert('tbl_tracking_real', $data);
                $data = array(
                    'id_so' => $get_last_id_so['id_so'],
                    'date_new' => date('Y-m-d'),
                    'tgl_pickup' => $this->input->post('tgl_pickup'),
                    'shipper' => strtoupper($this->input->post('shipper')),
                    'pu_moda' => $this->input->post('pu_moda'),
                    'pu_poin' => strtoupper($this->input->post('pu_poin')),
                    'destination' => $this->input->post('destination'),
                    'time' => $this->input->post('time'),
                    'koli' => $this->input->post('koli'),
                    'pu_commodity' => $this->input->post('commodity'),
                    'pu_service' => $this->input->post('service'),
                    'pu_note' => $this->input->post('note'),
                    'city_shipper' => $this->input->post('shipper_address'),
                    'consigne' => $this->input->post('consigne'),
                    'city_consigne' => $this->input->post('consigne_address'),
                    'payment' => $this->input->post('payment'),
                    'packing_type' => $this->input->post('packing'),
                    'is_incoming' => $this->input->post('is_incoming'),
                    'shipment_id' => $random
                );
                $this->db->insert('tbl_shp_order', $data);

                $updateDetailRequest = [
                    'id_so' => $get_last_id_so['id_so'],
                    'status' => 4
                ];
                $this->db->update('detailrequest_price', $updateDetailRequest, ['id_detailrequest' => $id_detailrequest]);

                $log = [
                    'id_detailrequestprice' => $id_detailrequest,
                    'log' => 'Request Telah dibuat SO oleh Sales',
                    'user' => $this->session->userdata('id_user'),
                    'date' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('requestprice_log', $log);

                $this->session->set_flashdata('message', '<div class="alert
                    alert-success" role="alert">Success</div>');
                redirect('sales/salesOrder');
            } else {
                $this->session->set_flashdata('message', '<div class="alert
                    alert-danger" role="alert">Failed</div>');
                redirect('sales/salesOrder/add');
            }
        }
    }

    public function getProvinsi()
    {

        $data  = $this->db->get('tb_province')->result();
        // Kirim data sebagai respons JSON
        echo json_encode($data);
    }

    public function import()
    {
        $id_so = $this->input->post('id_so');
        $date = date('Y-m-d');
        $deadline_pic_js = date('Y-m-d', strtotime('+2 days', strtotime($date)));
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

            $request = [
                'created_by' => $this->session->userdata('id_user'),
                'date_created' => date('Y-m-d H:i:s'),
                'status' => 0
            ];

            $this->db->insert('request_price', $request);
            $insert_id = $this->db->insert_id();
            if ($sheetData[0][0] == "ID Customer") {
                // kalo format awalnya sama
                $counter = 0;
                $count = 0;
                foreach ($sheetData as $rowdata) {
                    $counter++;
                    if ($counter == 1) {
                        continue; // skip 1 baris pertama
                    }
                    if ($rowdata[0] == '' || $rowdata[0] == NULL) {
                        break;
                    }
                    $data = array(
                        'id_request' => $insert_id,
                        'customer' => $rowdata[0],
                        'provinsi_from' => $rowdata[1],
                        'kota_from' => $rowdata[2],
                        'kecamatan_from' => $rowdata[3],
                        'alamat_from' => $rowdata[4],
                        'provinsi_to' => $rowdata[5],
                        'kota_to' => $rowdata[6],
                        'kecamatan_to' => $rowdata[7],
                        'alamat_to' => $rowdata[8],
                        'moda' => $rowdata[9],
                        'jenis' => $rowdata[10],
                        'berat' => $rowdata[11],
                        'koli' => $rowdata[12],
                        'panjang' => $rowdata[13],
                        'lebar' => $rowdata[14],
                        'tinggi' => $rowdata[15],
                        'notes_sales' => $rowdata[16],
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => $this->session->userdata('id_user'),
                        'status' => 0
                    );
                    $this->db->insert('detailrequest_price', $data);
                    $insert_id = $this->db->insert_id();
                    $log = [
                        'id_detailrequestprice' => $insert_id,
                        'log' => 'Request Dibuat',
                        'user' => $this->session->userdata('id_user'),
                        'date' => date('Y-m-d H:i:s')
                    ];
                    $this->db->insert('requestprice_log', $log);
                    $count++;
                }
                
                
                $pesan = "Hallo CS, ada " . $count . " pengajuan harga oleh " . $this->session->userdata('nama_user') . ", Silahkan cek di menu request price. Terima Kasih";

                $this->wa->pickup('+6285697780467', "$pesan");
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Add</div>');
                
                
                redirect('sales/RequestPrice');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed Add</div>');
                redirect('sales/RequestPrice');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed Add</div>');
            redirect('sales/RequestPrice');
        }
    }
}
