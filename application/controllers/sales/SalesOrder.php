<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
setlocale(LC_TIME, "id_ID.UTF8");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        $this->load->model('Sendwa', 'wa');
        $this->load->model('Api');
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        cek_role();
    }


    public function index()
    {
        $id_atasan = $this->session->userdata('id_atasan');
        // kalo dia atasan sales
        if ($id_atasan == 0 || $id_atasan == NULL) {
            $this->db->select('a.*,b.nama_user');
            $this->db->from('tbl_so a');
            $this->db->join('tb_user b', 'b.id_user=a.id_sales');
            $this->db->where('a.id_atasan_sales', $this->session->userdata('id_user'));
            $this->db->or_where('a.id_sales', $this->session->userdata('id_user'));
            $this->db->order_by('a.id_so', 'DESC');
            $query = $this->db->get()->result_array();
            $data['so'] = $query;
            $data['title'] = 'Sales Order';
            $this->backend->display('sales/v_so', $data);
        } else {
            $data['title'] = 'Sales Order';
            $this->backend->display('sales/v_so', $data);
        }
    }
    public function add()
    {
        $data['title'] = 'Add Sales Order';
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['moda'] = $this->db->get('tbl_moda')->result_array();
        $data['packing'] = $this->db->get('tbl_packing')->result_array();
        $data['customer'] = $this->db->get('tb_customer')->result_array();
        $this->backend->display('sales/v_so_add', $data);
    }
    public function addSpecial()
    {
        // $cek_api = $this->Api->kirim();
        // $cek_api = json_decode($cek_api);
        // $cek_api = $cek_api->accessToken;
        // $data = [
        //     'token' => $cek_api,
        // ];
        // $this->session->set_userdata($data);
        $data['title'] = 'Add Sales Order';
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['moda'] = $this->db->get('tbl_moda')->result_array();
        $data['packing'] = $this->db->get('tbl_packing')->result_array();
        $data['customer'] = $this->db->get('tb_customer')->result_array();
        $this->backend->display('sales/v_so_add_special', $data);
    }

    public function addNewSo()
    {
        $data = array(
            'freight_baru' => $this->input->post('freight_baru'),
            'special_freight_baru' => $this->input->post('special_freight_baru'),
            'packing_baru' => $this->input->post('packing_baru'),
            'insurance_baru' => $this->input->post('insurance_baru'),
            'surcharge_baru' => $this->input->post('surcharge_baru'),
            'disc_baru' => $this->input->post('disc_baru') / 100,
            'cn_baru' => $this->input->post('cn_baru') / 100,
            'special_cn_baru' => $this->input->post('special_cn_baru'),
            'others_baru' => $this->input->post('others_baru'),
            'alasan' => $this->input->post('alasan'),
            'shipment_id' => $this->input->post('id'),
            'id_sales' => $this->session->userdata('id_user'),
        );
        $nama = $this->session->userdata('nama_user');
        $insert = $this->db->insert('tbl_revisi_so', $data);
        if ($insert) {
            $pesan = "Hallo CS, Ada Revisi Harga SO Baru Yang Diajukan Oleh *$nama* . Silahkan Cek Melalu Sistem Ya . Terima Kasih";
            // no bu sri dan mba Lina
            $this->wa->pickup('+62818679758', "$pesan");
            $this->wa->pickup('+6281385687290', "$pesan");
            $this->wa->pickup('+6285697780467', "$pesan");


            $this->session->set_flashdata('message', '<div class="alert
            alert-success" role="alert">Success</div>');
            redirect('sales/salesOrder/revisiSo');
        } else {
            $this->session->set_flashdata('message', '<div class="alert
            alert-danger" role="alert">Failed</div>');
            redirect('sales/salesOrder/revisiSo');
        }
    }

    public function addNewSoDecline()
    {
        $data = array(
            'freight_baru' => $this->input->post('freight_baru'),
            'special_freight_baru' => $this->input->post('special_freight_baru'),
            'packing_baru' => $this->input->post('packing_baru'),
            'insurance_baru' => $this->input->post('insurance_baru'),
            'surcharge_baru' => $this->input->post('surcharge_baru'),
            'disc_baru' => $this->input->post('disc_baru') / 100,
            'cn_baru' => $this->input->post('cn_baru') / 100,
            'special_cn_baru' => $this->input->post('special_cn_baru'),
            'others_baru' => $this->input->post('others_baru'),
            'alasan' => $this->input->post('alasan'),
            'shipment_id' => $this->input->post('id'),
            'id_sales' => $this->session->userdata('id_user'),
        );
        $nama = $this->session->userdata('nama_user');
        $delete = $this->db->delete('tbl_revisi_so', array('shipment_id' => $this->input->post('id')));
        $deleteApprove = $this->db->delete('tbl_approve_revisi_so', array('shipment_id' => $this->input->post('id')));
        $insert = $this->db->insert('tbl_revisi_so', $data);
        if ($deleteApprove) {
            if ($delete) {
                if ($insert) {
                    $this->db->update('tbl_request_revisi', array('status' => 1), array('shipment_id' => $this->input->post('id')));
                    $pesan = "Hallo CS, Ada Revisi Harga SO Baru Yang Diajukan Oleh *$nama* . Silahkan Cek Melalu Sistem Ya . Terima Kasih";
                    // no bu sri dan mba Lina
                    $this->wa->pickup('+62818679758', "$pesan");
                    $this->wa->pickup('+6281385687290', "$pesan");
                    $this->wa->pickup('+6285697780467', "$pesan");


                    $this->session->set_flashdata('message', '<div class="alert
            alert-success" role="alert">Success</div>');
                    redirect('sales/salesOrder/revisiSo');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert
            alert-danger" role="alert">Failed</div>');
                    redirect('sales/salesOrder/revisiSo');
                }
            }
        }
    }

    public function processAdd()
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
            $this->add();
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
            $id_so = $this->db->insert_id();
            // var_dump($insert);
            // die;
            if ($insert) {
                $doReqPickup = $this->input->post('doReqPickup');
                if (sizeof($doReqPickup) != 0) {
                    for ($i = 0; $i < sizeof($doReqPickup); $i++) {

                        $dataDo = [
                            'do' => $doReqPickup[$i],
                            'id_so' => $id_so,
                        ];
                        $this->db->insert('do_requestpickup', $dataDo);
                    }
                }

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
                $this->wa->pickup('+6281293753199', "$pesan"); //Nomor Bu Lili CS
                $this->wa->pickup('+6285894438583', "$pesan"); //Mba Yunita  CS
                $this->wa->pickup('+6281212603705', "$pesan"); //Mas Ali OPS
                $this->wa->pickup('+6281398433940', "$pesan"); //Sarwan OPS



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
    // public function processAdd()
    // {
    //     $this->form_validation->set_rules('tgl_pickup', 'tgl_pickup', 'required');
    //     $this->form_validation->set_rules('shipper', 'shipper', 'required');
    //     $this->form_validation->set_rules('pu_moda', 'pu_moda', 'required');
    //     $this->form_validation->set_rules('pu_poin', 'pu_poin', 'required');
    //     $this->form_validation->set_rules('destination', 'destination', 'trim');
    //     $this->form_validation->set_rules('time', 'time', 'required');
    //     $this->form_validation->set_rules('is_incoming', 'is_incoming', 'required');
    //     $this->form_validation->set_rules('koli', 'koli', 'trim');
    //     $this->form_validation->set_rules('packing', 'packing', 'trim');
    //     $this->form_validation->set_rules('kg', 'kg', 'trim');
    //     $this->form_validation->set_rules('commodity', 'commodity', 'required');
    //     $this->form_validation->set_rules('service', 'service', 'required');
    //     $this->form_validation->set_rules('note', 'note', 'trim');
    //     if ($this->form_validation->run() == FALSE) {
    //         $this->session->set_flashdata('message', 'Failed');
    //         $this->add();
    //     } else {
    //         $id_atasan = $this->db->get_where('tb_user', ['id_user' => $this->session->userdata('id_user')])->row_array();
    //         $data = array(
    //             'tgl_pickup' => $this->input->post('tgl_pickup'),
    //             'shipper' => strtoupper($this->input->post('shipper')),
    //             'pu_moda' => $this->input->post('pu_moda'),
    //             'pu_poin' => strtoupper($this->input->post('pu_poin')),
    //             'destination' => $this->input->post('destination'),
    //             'time' => $this->input->post('time'),
    //             'koli' => $this->input->post('koli'),
    //             'kg' => $this->input->post('kg'),
    //             'type' => $this->input->post('type'),
    //             'commodity' => $this->input->post('commodity'),
    //             'service' => $this->input->post('service'),
    //             'note' => $this->input->post('note'),
    //             'shipper_address' => $this->input->post('shipper_address'),
    //             'consigne' => $this->input->post('consigne'),
    //             'consigne_address' => $this->input->post('consigne_address'),
    //             'payment' => $this->input->post('payment'),
    //             'packing' => $this->input->post('packing'),
    //             'is_incoming' => $this->input->post('is_incoming'),
    //             'id_sales' => $this->session->userdata('id_user'),
    //             'id_atasan_sales' => $id_atasan['id_atasan']
    //         );
    //         $id_atasan = $this->session->userdata('id_atasan');
    //         // kalo dia atasan
    //         if ($id_atasan == 0 || $id_atasan == NULL) {
    //             $data_approve = array(
    //                 'status_approve' => 1,
    //             );
    //             $data = array_merge($data, $data_approve);
    //         } else {
    //             $data_approve = array(
    //                 'status_approve' => 0,
    //             );
    //             $data = array_merge($data, $data_approve);
    //         }
    //         // var_dump($data);
    //         // die;

    //         $insert =  $this->db->insert('tbl_so', $data);
    //         // var_dump($insert);
    //         // die;
    //         if ($insert) {
    //             $shipper = strtoupper($this->input->post('shipper'));
    //             $tgl_pickup = $this->input->post('tgl_pickup');
    //             $pu_moda = $this->input->post('pu_moda');
    //             $time = $this->input->post('time');
    //             $commodity = $this->input->post('commodity');
    //             $note = $this->input->post('note');
    //             $sales = $this->session->userdata('nama_user');
    //             $destination = $this->input->post('destination');
    //             $pu_poin = strtoupper($this->input->post('pu_poin'));
    //             $service = $this->input->post('service');
    //             if ($destination != '' || $destination != NULL) {
    //                 $pesanDestination = "dengan tujuan *$destination*";
    //             } else {
    //                 $pesanDestination = "";
    //             }

    //             $pesanPickUp = "dan pick up di *$pu_poin*";
    //             $pesan = "Hallo Cs dan Ops, ada pickup dari *$shipper* $pesanDestination $pesanPickUp *$service* tanggal *$tgl_pickup* jam *$time* dengan moda $pu_moda dengan jenis barang $commodity. Catatan : $note. *Sales : $sales*";
    //             // kirim wa
    //             $this->wa->pickup('+6285697780467', "$pesan"); //Nomor Norman IT
    //             $this->wa->pickup('+6281293753199', "$pesan"); //Nomor Bu Lili CS
    //             $this->wa->pickup('+6285894438583', "$pesan"); //Mba Yunita  CS
    //             $this->wa->pickup('+6281212603705', "$pesan"); //Mas Ali OPS
    //             $this->wa->pickup('+6281398433940', "$pesan"); //Sarwan OPS
    //             $random = random_string('numeric', 8);

    //             $get_last_id_so = $this->db->limit(1)->order_by('id_so', 'DESC')->get('tbl_so')->row_array(); // mencari data terakhir yang baru diinput di tbl so
    //             $data = array(
    //                 'status' => 'Request Pickup From Shipper',
    //                 'id_so' => $get_last_id_so['id_so'],
    //                 'created_at' => date('Y-m-d'),
    //                 'time' => date('H:i:s'),
    //                 'flag' => 1,
    //                 'status_eksekusi' => 0,
    //                 'shipment_id' => $random
    //             );
    //             $this->db->insert('tbl_tracking_real', $data);
    //             $data = array(
    //                 'id_so' => $get_last_id_so['id_so'],
    //                 'date_new' => date('Y-m-d'),
    //                 'tgl_pickup' => $this->input->post('tgl_pickup'),
    //                 'shipper' => strtoupper($this->input->post('shipper')),
    //                 'pu_moda' => $this->input->post('pu_moda'),
    //                 'pu_poin' => strtoupper($this->input->post('pu_poin')),
    //                 'destination' => $this->input->post('destination'),
    //                 'time' => $this->input->post('time'),
    //                 'koli' => $this->input->post('koli'),
    //                 'pu_commodity' => $this->input->post('commodity'),
    //                 'pu_service' => $this->input->post('service'),
    //                 'pu_note' => $this->input->post('note'),
    //                 'city_shipper' => $this->input->post('shipper_address'),
    //                 'consigne' => $this->input->post('consigne'),
    //                 'city_consigne' => $this->input->post('consigne_address'),
    //                 'payment' => $this->input->post('payment'),
    //                 'packing_type' => $this->input->post('packing'),
    //                 'is_incoming' => $this->input->post('is_incoming'),
    //                 'shipment_id' => $random
    //             );
    //             $this->db->insert('tbl_shp_order', $data);
    //             $this->session->set_flashdata('message', '<div class="alert
    //                 alert-success" role="alert">Success</div>');
    //             redirect('sales/salesOrder');
    //         } else {
    //             $this->session->set_flashdata('message', '<div class="alert
    //                 alert-danger" role="alert">Failed</div>');
    //             redirect('sales/salesOrder/add');
    //         }
    //     }
    // }
    public function processAddSpecial()
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
        $this->form_validation->set_rules('total_shipment', 'total_shipment', 'required');
        $this->form_validation->set_rules('service', 'service', 'required');
        $this->form_validation->set_rules('note', 'note', 'trim');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'Failed');
            $this->addSpecial();
        } else {
            $total_shpment = $this->input->post('total_shipment');
            // var_dump($total_shpment);
            // die;
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
                'total_shipment' => $this->input->post('total_shipment'),
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
                'id_atasan_sales' => $id_atasan['id_atasan'],
                'type' => 1
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
                $state_shipper2 = $this->input->post('state_shipper2');
                $city_shipper2 = $this->input->post('city_shipper2');
                $pu_moda = $this->input->post('pu_moda');
                $time = $this->input->post('time');
                $commodity = $this->input->post('commodity');
                $note = $this->input->post('note');
                $sales = $this->session->userdata('nama_user');
                $pesan = "Hallo Cs, ada pickup dari *$shipper* tanggal *$tgl_pickup* jam *$time* dengan moda $pu_moda dengan jenis barang $commodity. Catatan : $note. *Sales : $sales*";
                // kirim wa
                // $this->wa->pickup('+6281617435559', "$pesan");
                // $this->wa->pickup('+6285894438583', "$pesan");
                // $this->wa->pickup('+6281385687290', "$pesan");
                // $this->wa->pickup('+6285774086919', "$pesan");
                $get_last_id_so = $this->db->limit(1)->order_by('id_so', 'DESC')->get('tbl_so')->row_array();
                $total_shpment = $this->input->post('total_shipment');
                for ($j = 0; $j < $total_shpment; $j++) {
                    $koli = 1;
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

                    $img = $this->input->post('ttd');
                    $img = str_replace('data:image/png;base64,', '', $img);
                    $service_type = "9194a22e-392f-4940-8229-e5df3557c2ac";

                    $date = date('Y-m-d');
                    $pickup_start = date('Y-m-d', strtotime('+1 days', strtotime($date)));
                    $delivery_start = date('Y-m-d', strtotime('+1 days', strtotime($pickup_start)));
                    $delivery_commit = date('Y-m-d', strtotime('+3 days', strtotime($delivery_start)));

                    $startTime = date("H:i:s", time() + 600);
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
                            'shipper_name' => $shipper,
                            'shipper_phone' => "0000",
                            'shipper_email' => "sender@gmail.com",
                            'consignee_name' => "DUMMY",
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
                                'state' => ucwords(strtolower("JAKARTA")),
                                // 'state' => 'Jakarta',
                                'city' => ucwords(strtolower("WEST JAKARTA")),
                                // 'city' => 'West jakarta',
                                'postal_code' => '000',
                                'address_line1' => "JAKARTA",
                                'address_line2' => "JAKARTA",
                                'address_line3' => "JAKARTA",

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

                        $data = array(
                            'shipper' => strtoupper($this->input->post('shipper')),
                            'origin' => $this->input->post('origin'),
                            'city_shipper' => $this->input->post('city_shipper2'),
                            'state_shipper' => $this->input->post('state_shipper2'),
                            'consigne' => strtoupper("DUMMY"),
                            'destination' => "JAKARTA",
                            'city_consigne' => "JAKARTA",
                            'state_consigne' => "JAKARTA",
                            'koli' => 1,
                            'is_jabodetabek' => 1,
                            'sender' => "NULL",
                            'note_driver' => "NULL",
                            'id_so' => $get_last_id_so['id_so'],
                            'id_user' => $this->session->userdata('id_user'),
                            'signature' => $img,
                            'tree_shipper' => "JKT",
                            'tree_consignee' => "JKT",
                            'shipment_id' => $shipment_id,
                            'order_id' => $order_id,
                            'service_type' =>  $service_type,
                            'date_new' => date('Y-m-d'),
                            'so_id' => $kode,
                            'tgl_pickup' => $tgl_pickup,
                            'pu_moda' => $this->input->post('pu_moda'),
                            'pu_poin' => $this->input->post('pu_poin'),
                            'time' => $this->input->post('time'),
                            'pu_commodity' => $this->input->post('commodity'),
                            'pu_service' => $this->input->post('service'),
                            'pu_note' => $this->input->post('note'),
                            'payment' => $this->input->post('payment'),
                            'packing_type' => $this->input->post('packing'),
                            'is_incoming' => $this->input->post('is_incoming'),
                        );

                        $insert =  $this->db->insert('tbl_shp_order', $data);
                        if ($insert) {
                            $this->barcode($shipment_id);
                            $this->qrcode($shipment_id);
                            $data = array(
                                'shipment_id' => $shipment_id,
                                'status' => "Request Pickup From Shipper",
                                'id_so' => $get_last_id_so['id_so'],
                                'created_at' => date('Y-m-d'),
                                'note' => NULL,
                                'bukti' => NULL,
                                'id_user' => $this->input->post('id_user'),
                                'update_at' => date('Y-m-d H:i:s'),
                                'pic_task' => NULL,
                                'time' => $this->input->post('time'),
                                'flag' => 1,
                                'status_eksekusi' => 1,
                            );
                            $this->db->insert('tbl_tracking_real', $data);
                            $data = array(
                                'shipment_id' => $shipment_id,
                                'status' => "Driver Menuju Lokasi Pickup",
                                'id_so' => $get_last_id_so['id_so'],
                                'created_at' => date('Y-m-d'),
                                'note' => NULL,
                                'bukti' => NULL,
                                'id_user' => $this->input->post('id_user'),
                                'update_at' => date('Y-m-d H:i:s'),
                                'pic_task' => NULL,
                                'time' => $this->input->post('time'),
                                'flag' => 2,
                                'status_eksekusi' => 1,
                            );
                            $this->db->insert('tbl_tracking_real', $data);
                            $data = array(
                                'shipment_id' => $shipment_id,
                                'status' => "Shipment Telah Dipickup Dari Shipper",
                                'id_so' => $get_last_id_so['id_so'],
                                'created_at' => date('Y-m-d'),
                                'note' => NULL,
                                'bukti' => NULL,
                                'id_user' => $this->input->post('id_user'),
                                'update_at' => date('Y-m-d H:i:s'),
                                'pic_task' => NULL,
                                'time' => $this->input->post('time'),
                                'flag' => 3,
                                'status_eksekusi' => 0,
                            );
                            $this->db->insert('tbl_tracking_real', $data);
                        }
                    }
                }
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
    function getTreeLetterCode($province)
    {
        $code = $this->db->get_where('tb_province', ['name' => $province])->row_array();
        if ($code) {
            return $code['tree_code'];
        } else {
            return null;
        }
    }

    public function processEditOrder()
    {
        $where = array('id_so' => $this->input->post('id_so'));

        $so = $this->db->get_where('tbl_so', $where)->row_array();

        $data = array(
            'tgl_pickup' => $this->input->post('tgl_pickup'),
            'shipper' => strtoupper($this->input->post('shipper')),
            'pu_moda' => $this->input->post('pu_moda'),
            'pu_poin' => strtoupper($this->input->post('pu_poin')),
            'destination' => $this->input->post('destination'),
            'time' => $this->input->post('time'),
            'koli' => $this->input->post('koli'),
            'kg' => $this->input->post('kg'),
            'packing' => $this->input->post('packing'),
            'commodity' => $this->input->post('commodity'),
            'service' => $this->input->post('service'),
            'note' => $this->input->post('note'),
            'shipper_address' => $this->input->post('shipper_address'),
            'consigne' => $this->input->post('consigne'),
            'consigne_address' => $this->input->post('consigne_address'),
            'payment' => $this->input->post('payment'),
            'is_incoming' => $this->input->post('is_incoming'),
        );

        $shipper1 = strtoupper($so['shipper']);
        $tgl_pickup1 = $so['tgl_pickup'];
        $pu_moda1 = $so['pu_moda'];
        $time1 = $so['time'];
        $commodity1 = $so['commodity'];
        $note1 = $so['note'];
        $sales1 = $this->session->userdata('nama_user');
        $destination1 = $so['destination'];
        $pu_poin1 = strtoupper($so['pu_poin']);
        $service1 = $so['service'];
        if ($destination1 != '' || $destination1 != NULL) {
            $pesanDestination1 = "dengan tujuan *$destination1*";
        } else {
            $pesanDestination1 = "";
        }

        $pesanPickUp1 = "dan pick up di *$pu_poin1*";
        $pesan1 = "BEFORE: pickup dari *$shipper1* $pesanDestination1 $pesanPickUp1 *$service1* tanggal *$tgl_pickup1* jam *$time1* dengan moda $pu_moda1 dengan jenis barang $commodity1. Catatan : $note1.";

        $shipper2 = strtoupper($this->input->post('shipper'));
        $tgl_pickup2 = $this->input->post('tgl_pickup');
        $pu_moda2 = $this->input->post('pu_moda');
        $time2 = $this->input->post('time');
        $commodity2 = $this->input->post('commodity');
        $note2 = $this->input->post('note');

        $destination2 = $this->input->post('destination');
        $pu_poin2 = strtoupper($this->input->post('pu_poin'));
        $service2 = $this->input->post('service');
        if ($destination2 != '' || $destination2 != NULL) {
            $pesanDestination2 = "dengan tujuan *$destination2*";
        } else {
            $pesanDestination2 = "";
        }

        $pesanPickUp2 = "dan pick up di *$pu_poin2*";
        $pesan2 = "AFTER:  pickup dari *$shipper2* $pesanDestination2 $pesanPickUp2 *$service2* tanggal *$tgl_pickup2* jam *$time2* dengan moda $pu_moda2 dengan jenis barang $commodity2. Catatan : $note2. \r\n\r\n *Sales : $sales1*";




        // kirim wa
        $this->wa->pickup('+6285697780467', '*REVISI REQUEST PICKUP* \r\n\r\n' . $pesan1 . '\r\n\r\n' . $pesan2); //Nomor Norman IT
        $this->wa->pickup('+6281293753199', '*REVISI REQUEST PICKUP* \r\n\r\n' . $pesan1 . '\r\n\r\n' . $pesan2); //Nomor Bu Lili CS
        $this->wa->pickup('+6285894438583', '*REVISI REQUEST PICKUP* \r\n\r\n' . $pesan1 . '\r\n\r\n' . $pesan2); //Mba Yunita  CS
        $this->wa->pickup('+6281212603705', '*REVISI REQUEST PICKUP* \r\n\r\n' . $pesan1 . '\r\n\r\n' . $pesan2); //Mas Ali OPS
        $this->wa->pickup('+6285777396665', '*REVISI REQUEST PICKUP* \r\n\r\n' . $pesan1 . '\r\n\r\n' . $pesan2); //AMEL  CS
        $this->wa->pickup('+6281398433940', '*REVISI REQUEST PICKUP* \r\n\r\n' . $pesan1 . '\r\n\r\n' . $pesan2); //Sarwan OPS

        $update =  $this->db->update('tbl_so', $data, $where);
        if ($update) {



            $deleteDo = $this->db->delete('do_requestpickup', ['id_so' => $this->input->post('id_so')]);
            if ($deleteDo) {
                $doReqPickup = $this->input->post('doReqPickup');
                if (sizeof($doReqPickup) != 0) {
                    for ($i = 0; $i < sizeof($doReqPickup); $i++) {

                        $dataDo = [
                            'do' => $doReqPickup[$i],
                            'id_so' => $this->input->post('id_so'),
                        ];
                        $this->db->insert('do_requestpickup', $dataDo);
                    }
                }
            }
            $data = array(
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
            );


            $this->db->update('tbl_shp_order', $data, $where);
            $this->session->set_flashdata('message', '<div class="alert
                    alert-success" role="alert">Success</div>');
            redirect('sales/salesOrder/edit/' . $this->input->post('id_so'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert
                    alert-danger" role="alert">Failed</div>');
            redirect('sales/salesOrder/edit/' . $this->input->post('id_so'));
        }
    }


    public function countint()
    {
        $int = 12;
        if (strlen($int) > 2) {
            echo 'diatas 2';
        } else {
            echo 'dibawah 2';
        }
    }

    public function isWeekend($date)
    {
        $weekend = date('N', strtotime($date)) >= 5;
        if ($weekend == TRUE) {
            echo 'LIBURRRRRR';
        } else {
            echo 'MASOKKKKK';
        }
        var_dump($weekend);
    }

    public function prosesSo()
    {

        $date = date('Y-m-d');
        $weekend = date('N', strtotime($date)) >= 5;

        if ($weekend == TRUE) {
            if (date('H:i:s') >= date('H:i:s', strtotime('21:00:01')) && date('H:i:s') <= date('H:i:s', strtotime('23:59:59'))) {
                $deadline_pic_js = date('Y-m-d', strtotime('+5 days', strtotime($date)));
            } else {
                $deadline_pic_js = date('Y-m-d', strtotime('+4 days', strtotime($date)));
            }
        } else {
            if (date('H:i:s') >= date('H:i:s', strtotime('21:00:01')) && date('H:i:s') <= date('H:i:s', strtotime('23:59:59'))) {
                $deadline_pic_js = date('Y-m-d', strtotime('+4 days', strtotime($date)));
            } else {
                $deadline_pic_js = date('Y-m-d', strtotime('+3 days', strtotime($date)));
            }
        }


        $id_atasan = $this->session->userdata('id_atasan');
        if ($id_atasan == 0 || $id_atasan == NULL) {
            $id = $this->input->post('id');
            $id_so = $this->input->post('id_so');
            $freight_kg = $this->input->post('freight');
            $packing = $this->input->post('packing');
            $special_freight = $this->input->post('special_freight');
            $so_note = $this->input->post('so_note');
            $insurance = $this->input->post('insurance');
            $surcharge = $this->input->post('surcharge');
            $disc = $this->input->post('disc');
            $pic_invoice = $this->input->post('pic_invoice');
            $cn = $this->input->post('cn');
            $specialcn = $this->input->post('specialcn');
            $others = $this->input->post('others');
            // $id = sizeof($id);
            for ($i = 0; $i < sizeof($id); $i++) {
                $tblShpOrder = $this->db->get_where('tbl_shp_order', ['id' => $id[$i]])->row_array();
                if ($tblShpOrder->status_so < 1) {
                    $data = array(
                        'freight_kg' => $freight_kg[$i],
                        'packing' => $packing[$i],
                        'pic_invoice' => $pic_invoice[$i],
                        'special_freight' => $special_freight[$i],
                        'insurance' => $insurance[$i],
                        'surcharge' => $surcharge[$i],
                        'disc' => $disc[$i] / 100,
                        'cn' => $cn[$i] / 100,
                        'specialcn' => $specialcn[$i],
                        'others' => $others[$i],
                        'so_note' => $so_note[$i],
                        'status_so' => 1,
                        'deadline_pic_js' => $deadline_pic_js,
                    );
                } else {
                    $data = array(
                        'freight_kg' => $freight_kg[$i],
                        'packing' => $packing[$i],
                        'pic_invoice' => $pic_invoice[$i],
                        'special_freight' => $special_freight[$i],
                        'insurance' => $insurance[$i],
                        'surcharge' => $surcharge[$i],
                        'disc' => $disc[$i] / 100,
                        'cn' => $cn[$i] / 100,
                        'specialcn' => $specialcn[$i],
                        'others' => $others[$i],
                        'so_note' => $so_note[$i],
                        'deadline_pic_js' => $deadline_pic_js,
                    );
                }

                $this->db->update('tbl_shp_order', $data, ['id' => $id[$i]]);
            }
            $data = array(
                'lock' => 1,
                'status_approve' => 1,
                'submitso_at' => date('Y-m-d H:i:s')
            );
            $this->db->update('tbl_so', $data, ['id_so' => $id_so]);
            $data = array(
                'id_so' => $id_so,
                'approve_manager' => $this->session->userdata('id_user'),
                'created_at_manager' => date('Y-m-d H:i:s'),
            );
            $this->db->insert('tbl_approve_so', $data);

            $this->session->set_flashdata('message', '<div class="alert
            alert-success" role="alert">Success</div>');
            redirect('sales/salesOrder/detail/' . $id_so);
        } else {
            $id = $this->input->post('id');
            $id_so = $this->input->post('id_so');
            $freight_kg = $this->input->post('freight');
            $packing = $this->input->post('packing');
            $insurance = $this->input->post('insurance');
            $surcharge = $this->input->post('surcharge');
            $disc = $this->input->post('disc');
            $pic_invoice = $this->input->post('pic_invoice');
            $so_note = $this->input->post('so_note');
            $cn = $this->input->post('cn');
            $specialcn = $this->input->post('specialcn');
            $others = $this->input->post('others');
            $special_freight = $this->input->post('special_freight');
            // $id = sizeof($id);
            for ($i = 0; $i < sizeof($id); $i++) {
                $data = array(
                    'freight_kg' => $freight_kg[$i],
                    'packing' => $packing[$i],
                    'pic_invoice' => $pic_invoice[$i],
                    'special_freight' => $special_freight[$i],
                    'insurance' => $insurance[$i],
                    'surcharge' => $surcharge[$i],
                    'disc' => $disc[$i] / 100,
                    'cn' => $cn[$i] / 100,
                    'specialcn' => $specialcn[$i],
                    'others' => $others[$i],
                    'so_note' => $so_note[$i],
                    'status_so' => 1,
                    'deadline_pic_js' => $deadline_pic_js,
                );
                $this->db->update('tbl_shp_order', $data, ['id' => $id[$i]]);
            }
            $data = array(
                'lock' => 1,
                'submitso_at' => date('Y-m-d H:i:s')
            );
            $this->db->update('tbl_so', $data, ['id_so' => $id_so]);
        }
        $this->session->set_flashdata('message', '<div class="alert
        alert-success" role="alert">Success</div>');
        redirect('sales/salesOrder/detail/' . $id_so);
    }
    public function approve($id_so)
    {
        $data = array(
            'id_so' => $id_so,
            'approve_manager' => $this->session->userdata('id_user'),
            'created_at_manager' => date('Y-m-d H:i:s'),
        );
        $insert = $this->db->insert('tbl_approve_so', $data);
        if ($insert) {
            $data = array(
                'status_approve' => 1
            );
            $this->db->update('tbl_so', $data, ['id_so' => $id_so]);
        }
        $this->session->set_flashdata('message', '<div class="alert
        alert-success" role="alert">Success Approve</div>');
        redirect('sales/salesOrder');
    }
    public function requestRevisi($id_shipment, $id_so)
    {
        $data = array(
            'shipment_id' => $id_shipment,
            'id_so' => $id_so,
            'id_user' => $this->session->userdata('id_user'),
        );
        $insert = $this->db->insert('tbl_request_revisi', $data);

        $get_last_request = $this->db->order_by('id_request', 'DESC')->limit(1)->get('tbl_request_revisi')->row_array();
        $id_aktivasi = $get_last_request['id_request'];
        $nama = $this->session->userdata('nama_user');

        $link = "https://tesla-smartwork.transtama.com/approval/approveRequest/$id_aktivasi";
        $pesan = "Hallo CS, Ada Request Revisi SO Dari *$nama* . Silahkan Aktivasi Melalu Link Berikut : $link . Terima Kasih";
        // no bu sri
        $this->wa->pickup('+6285697780467', "$pesan");
        $this->wa->pickup('+62818679758', "$pesan");
        

        $this->session->set_flashdata('message', '<div class="alert
        alert-success" role="alert">Success Approve</div>');
        redirect('sales/salesOrder/detail/' . $id_so);
    }
    public function lock($id_so)
    {
        $data = array(
            'lock' => 1
        );
        $this->db->update('tbl_so', $data, ['id_so' => $id_so]);
        $this->session->set_flashdata('message', '<div class="alert
        alert-success" role="alert">Success Lock</div>');
        redirect('sales/salesOrder/detail/' . $id_so);
    }
    public function tracking($id, $id_so)
    {
        $data['title'] = 'Detail Order';
        $data['id_so'] = $id_so;
        $data['p'] = $this->order->order($id)->row_array();
        $this->backend->display('sales/v_detail_pengajuan', $data);
    }
    public function trackingReport($id, $id_so)
    {
        $data['title'] = 'Detail Order';
        $data['id_so'] = $id_so;
        $data['p'] = $this->order->order($id)->row_array();
        $this->backend->display('sales/v_tracking_report', $data);
    }
    public function detail($id)
    {
        $data['title'] = 'Detail Sales Order';
        $detailrequest = $this->db->get_where('detailrequest_price', ['id_so' => $id]);
        if ($detailrequest) {
            $data['detailrequest'] = $detailrequest->row_array();
        }
        $data['p'] = $this->db->get_where('tbl_so', ['id_so' => $id])->row_array();
        $data['request_aktivasi'] = $this->db->get_where('tbl_aktivasi_so', ['id_so' => $id])->row_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['moda'] = $this->db->get('tbl_moda')->result_array();
        $data['packing'] = $this->db->get('tbl_packing')->result_array();
        $data['shipment2'] =  $this->order->orderBySoSales($id)->result_array();
        // var_dump($data['request_aktivasi']);
        // die;

        $this->backend->display('sales/v_detail_order', $data);
    }
    public function cancel($id)
    {
        $data['title'] = 'Cancel Sales Order';
        $data['id_so'] = $id;
        $data['p'] = $this->db->get_where('tbl_so', ['id_so' => $id])->row_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['moda'] = $this->db->get('tbl_moda')->result_array();
        $data['packing'] = $this->db->get('tbl_packing')->result_array();
        $data['shipment2'] =  $this->order->orderBySo($id)->result_array();
        // var_dump($data['shipment2']);
        // die;
        $this->backend->display('sales/v_cancel_order', $data);
    }
    public function edit($id)
    {
        $data['title'] = 'Edit Sales Order';
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['moda'] = $this->db->get('tbl_moda')->result_array();
        $data['packing'] = $this->db->get('tbl_packing')->result_array();
        $data['p'] = $this->db->get_where('tbl_so', ['id_so' => $id])->row_array();
        $dataDo = $this->db->get_where('do_requestpickup',['id_so' => $id]);
        if ($dataDo) {
            $data['do'] = $dataDo;
        } else{
            $data['do'] = NULL;
        }
        $this->backend->display('sales/v_edit_order', $data);
    }

    public function export($id_so)
    {
        $detail = $this->db->get_where('tbl_so', ['id_so' => $id_so])->row_array();
        $shipments = $this->db->get_where('tbl_shp_order', ['id_so' => $id_so])->result_array();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Shipment ID');
        $sheet->setCellValue('B1', 'Shipper');
        $sheet->setCellValue('C1', 'Consignee');
        $sheet->setCellValue('D1', 'Freight/Kg');
        $sheet->setCellValue('E1', 'Special Freight/Kg');
        $sheet->setCellValue('F1', 'Packing');
        $sheet->setCellValue('G1', 'Insurance');
        $sheet->setCellValue('H1', 'Surcharge');
        $sheet->setCellValue('I1', 'Discount');
        $sheet->setCellValue('J1', 'Commision (%) ex. 10');
        $sheet->setCellValue('K1', 'Special Commision');
        $sheet->setCellValue('L1', 'Others');
        $sheet->setCellValue('M1', 'Note');
        $sheet->setCellValue('N1', 'PIC Invoice');
        $sheet->setCellValue('O1', 'City');
        $sheet->setCellValue('P1', 'Weight');
        $sheet->setCellValue('Q1', 'Pickup Poin');

        $no = 1;
        $x = 2;
        foreach ($shipments as $row) {
            $sheet->setCellValue('A' . $x, $row['shipment_id'])->getColumnDimension('A')
                ->setAutoSize(true);
            $sheet->setCellValue('B' . $x, $row['shipper'])->getColumnDimension('B')
                ->setAutoSize(true);
            $sheet->setCellValue('C' . $x, $row['consigne'])->getColumnDimension('C')
                ->setAutoSize(true);
            $sheet->setCellValue('D' . $x, $row['freight_kg'])->getColumnDimension('D')
                ->setAutoSize(true);
            $sheet->setCellValue('E' . $x, $row['special_freight'])->getColumnDimension('E')
                ->setAutoSize(true);
            $sheet->setCellValue('F' . $x, $row['packing'])->getColumnDimension('F')
                ->setAutoSize(true);
            $sheet->setCellValue('G' . $x, $row['insurance'])->getColumnDimension('G')
                ->setAutoSize(true);
            $sheet->setCellValue('H' . $x, $row['surcharge'])->getColumnDimension('H')
                ->setAutoSize(true);
            $sheet->setCellValue('I' . $x, $row['disc'])->getColumnDimension('I')
                ->setAutoSize(true);
            $sheet->setCellValue('J' . $x, $row['cn'] * 100)->getColumnDimension('J')
                ->setAutoSize(true);
            $sheet->setCellValue('K' . $x, $row['specialcn'] * 100)->getColumnDimension('J')
                ->setAutoSize(true);
            $sheet->setCellValue('L' . $x, $row['others'])->getColumnDimension('K')
                ->setAutoSize(true);
            $sheet->setCellValue('M' . $x, $row['so_note']);
            $sheet->setCellValue('N' . $x, $row['pic_invoice'])->getColumnDimension('M')
                ->setAutoSize(true);
            $sheet->setCellValue('O' . $x, $row['city_consigne'])->getColumnDimension('N')
                ->setAutoSize(true);
            $sheet->setCellValue('P' . $x, $row['berat_js']);
            $sheet->setCellValue('Q' . $x, $detail['pu_poin'])->getColumnDimension('P')
                ->setAutoSize(true);
            $x++;
        }
        $filename = "sales order $detail[shipper]";

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
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

            if ($sheetData[0][0] == "Shipment ID") {
                // kalo format awalnya sama
                foreach ($sheetData as $rowdata) {
                    $id_atasan = $this->session->userdata('id_atasan');
                    if ($id_atasan == 0 || $id_atasan == NULL) {
                        $data = array(
                            'freight_kg' => $rowdata[3],
                            'packing' => $rowdata[5],
                            'special_freight' => $rowdata[4],
                            'insurance' => $rowdata[6],
                            'surcharge' => $rowdata[7],
                            'disc' => $rowdata[8] / 100,
                            'cn' => $rowdata[9] / 100,
                            'specialcn' => $rowdata[10],
                            'others' => $rowdata[11],
                            'so_note' => $rowdata[12],
                            'pic_invoice' => $rowdata[13],
                            'status_so' => 1,
                            'deadline_pic_js' => $deadline_pic_js,
                        );
                        $this->db->update('tbl_shp_order', $data, ['shipment_id' => $rowdata[0]]);

                        $data = array(
                            'lock' => 1,
                            'status_approve' => 1,
                            'submitso_at' => date('Y-m-d H:i:s')
                        );
                        $this->db->update('tbl_so', $data, ['id_so' => $id_so]);
                        $data = array(
                            'id_so' => $id_so,
                            'approve_manager' => $this->session->userdata('id_user'),
                            'created_at_manager' => date('Y-m-d H:i:s'),
                        );
                        $this->db->insert('tbl_approve_so', $data);
                    } else {
                        $data = array(
                            'freight_kg' => $rowdata[3],
                            'packing' => $rowdata[5],
                            'special_freight' => $rowdata[4],
                            'insurance' => $rowdata[6],
                            'surcharge' => $rowdata[7],
                            'disc' => $rowdata[8] / 100,
                            'cn' => $rowdata[9] / 100,
                            'specialcn' => $rowdata[10],
                            'others' => $rowdata[11],
                            'so_note' => $rowdata[12],
                            'pic_invoice' => $rowdata[13],
                            'status_so' => 1,
                            'deadline_pic_js' => $deadline_pic_js,
                        );
                        $this->db->update('tbl_shp_order', $data, ['shipment_id' => $rowdata[0]]);

                        $data = array(
                            'lock' => 1
                        );
                        $this->db->update('tbl_so', $data, ['id_so' => $id_so]);
                    }
                }
                $this->session->set_flashdata('message', '<div class="alert
                            alert-success" role="alert">Success</div>');
                redirect('sales/salesOrder/detail/' . $this->input->post('id_so'));
            } else {
                $this->session->set_flashdata('message', '<div class="alert
                alert-danger" role="alert">Your Format Is Not Allowed</div>');
                redirect('sales/salesOrder/detail/' . $this->input->post('id_so'));
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert
            alert-danger" role="alert">Silahkan Upload File</div>');
            redirect('sales/salesOrder/detail/' . $this->input->post('id_so'));
        }
    }

    // public function import()
    // {
    //     $id_so = $this->input->post('id_so');
    //     $file_mimes = array(
    //         'text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream',
    //         'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv',
    //         'application/excel', 'application/vnd.msexcel', 'text/plain',
    //         'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    //     );
    //     if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
    //         $arr_file = explode('.', $_FILES['upload_file']['name']);
    //         $extension = end($arr_file);
    //         if ('csv' == $extension) {
    //             $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    //         } else {
    //             $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    //         }
    //         $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
    //         $sheetData = $spreadsheet->getActiveSheet()->toArray();

    //         foreach ($sheetData as $rowdata) {
    //             $id_atasan = $this->session->userdata('id_atasan');
    //             if ($id_atasan == 0 || $id_atasan == NULL) {
    //                 $data = array(
    //                     'freight_kg' => $rowdata[3],
    //                     'packing' => $rowdata[5],
    //                     'special_freight' => $rowdata[4],
    //                     'insurance' => $rowdata[6],
    //                     'surcharge' => $rowdata[7],
    //                     'disc' => $rowdata[8] / 100,
    //                     'cn' => $rowdata[9] / 100,
    //                     'others' => $rowdata[10],
    //                     'so_note' => $rowdata[11],
    // 					'pic_invoice' => $rowdata[12],
    //                     'status_so' => 1
    //                 );
    //                 $this->db->update('tbl_shp_order', $data, ['shipment_id' => $rowdata[0]]);

    //                 $data = array(
    //                     'lock' => 1,
    //                     'status_approve' => 1
    //                 );
    //                 $this->db->update('tbl_so', $data, ['id_so' => $id_so]);
    //                 $data = array(
    //                     'id_so' => $id_so,
    //                     'approve_manager' => $this->session->userdata('id_user'),
    //                     'created_at_manager' => date('Y-m-d H:i:s'),
    //                 );
    //                 $this->db->insert('tbl_approve_so', $data);
    //             } else {
    //                 $data = array(
    //                     'freight_kg' => $rowdata[3],
    //                     'packing' => $rowdata[5],
    //                     'special_freight' => $rowdata[4],
    //                     'insurance' => $rowdata[6],
    //                     'surcharge' => $rowdata[7],
    //                     'disc' => $rowdata[8] / 100,
    //                     'cn' => $rowdata[9] / 100,
    //                     'others' => $rowdata[10],
    //                     'so_note' => $rowdata[11],
    // 					'pic_invoice' => $rowdata[12],
    //                     'status_so' => 1
    //                 );
    //                 $this->db->update('tbl_shp_order', $data, ['shipment_id' => $rowdata[0]]);

    //                 $data = array(
    //                     'lock' => 1
    //                 );
    //                 $this->db->update('tbl_so', $data, ['id_so' => $id_so]);
    //             }
    //         }
    //         $this->session->set_flashdata('message', '<div class="alert
    //                     alert-success" role="alert">Success</div>');
    //         redirect('sales/salesOrder/detail/' . $this->input->post('id_so'));
    //     } else {
    //         $this->session->set_flashdata('message', '<div class="alert
    //         alert-danger" role="alert">Silahkan Upload File</div>');
    //         redirect('sales/salesOrder/detail/' . $this->input->post('id_so'));
    //     }
    // }

    function view_data_query()
    {
        $id_atasan = $this->session->userdata('id_atasan');
        // kalo dia atasan sales
        if ($id_atasan == 0 || $id_atasan == NULL) {
            $this->db->select('a.*,b.nama_user');
            $this->db->from('tbl_so', 'a');
            $this->db->join('tb_user b', 'b.id_user=a.id_sales');
            $this->db->where('a.id_atasan_sales', $this->input->post('id_sales'));
            $this->db->or_where('a.id_atasan_sales', 0);
            $query = $this->db->get()->result_array();
        } else {
            // kalo dia staff sales
            $query  = "SELECT * FROM tbl_so a";
            $search = array('shipper', 'destination');
            // $where  = null;
            $where  = array('a.id_sales' => $this->session->userdata('id_user'));
            // jika memakai IS NULL pada where sql
            $isWhere = null;
            // $isWhere = 'artikel.deleted_at IS NULL';
            header('Content-Type: application/json');
            echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
        }
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
    public function cancelOrder()
    {
        $data = array(
            'alasan_cancel' => $this->input->post('alasan_cancel'),
            'status' => 5,
            'cancel_date' => date('Y-m-d H:i:s')
        );

        $update =  $this->db->update('tbl_so', $data, ['id_so' => $this->input->post('id_so')]);
        if ($update) {
            $data = array(
                'status_eksekusi' => 1,
            );
            $this->db->update('tbl_tracking_real', $data, ['id_so' => $this->input->post('id_so')]);
            $this->session->set_flashdata('message', '<div class="alert
                alert-success" role="alert">Success</div>');
            redirect('sales/salesOrder/');
        } else {
            $this->session->set_flashdata('message', '<div class="alert
                alert-danger" role="alert">Failed</div>');
            redirect('sales/salesOrder/');
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

    // revisi so
    public function revisiSo()
    {
        $data['title'] = 'List Request Revisi Sales Order';

        $data['subtitle'] = 'List Request Revisi Sales Order';
        $data['js'] = $this->order->getRevisiJs()->result_array();
        $this->backend->display('sales/v_js_revisi', $data);
    }

    public function viewRevisiSo()
    {
        $data['title'] = 'List Revisi Sales Order';
        $data['subtitle'] = 'List Revisi Sales Order';
        $data['js'] = $this->order->getRevisiSoNew()->result_array();
        $this->backend->display('sales/v_js_revisi_so', $data);
    }
    public function detailRevisi($id)
    {
        $data['subtitle'] = 'Detail Sales Order';
        $data['title'] = 'Detail Shipment';
        $data['msr'] = $this->order->getDetailSo($id)->row_array();
        $data['request'] = $this->db->get_where('tbl_revisi_so', ['shipment_id' => $id])->row_array();
        $data['request_revisi'] = $this->db->get_where('tbl_request_revisi', ['shipment_id' => $id])->row_array();
        $data['so_lama'] = $this->db->get_where('tbl_revisi_so_lama', ['shipment_id' => $id])->row_array();
        $data['modal'] = $this->db->get_where('tbl_modal', ['shipment_id' => $id])->result_array();
        $this->backend->display('sales/v_detail_revisi', $data);
    }


    // request aktivasi

    public function requestAktivasi()
    {
        $data = array(
            'id_so' => $this->input->post('id_so'),
            'reason' => $this->input->post('reason'),
            'request_by' => $this->session->userdata('nama_user'),
        );
        $nama = $this->session->userdata('nama_user');
        $insert = $this->db->insert('tbl_aktivasi_so', $data);
        if ($insert) {

            $this->session->set_flashdata('message', '<div class="alert
            alert-success" role="alert">Request Submitted</div>');
            redirect('sales/salesOrder/detail/' . $this->input->post('id_so'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert
            alert-danger" role="alert">Request Failed</div>');
            redirect('sales/salesOrder/detail/' . $this->input->post('id_so'));
        }
    }

    // report
    function report_order()
    {
        $query  = "SELECT a.*, b.nama_user, c.pu_poin FROM tbl_shp_order a JOIN tb_user b ON a.id_user=b.id_user JOIN tbl_so c ON a.id_so=c.id_so";
        $search = array('nama_user', 'a.shipment_id', 'a.order_id', 'a.shipper', 'a.consigne');
        // $where = null;
        $where  = array('c.id_sales' => $this->session->userdata('id_user'));
        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }

    public function report()
    {
        $data['title'] = 'Report Order';
        $this->backend->display('sales/v_report', $data);
    }

    public function filterLaporan()
    {
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $data['awal'] = $awal;
        $data['akhir'] = $akhir;
        $data['title'] = "Laporan Order Tahun $awal Bulan $akhir";
        $data['order'] = $this->order->getLaporanTransaksiFilterByDate($awal, $akhir)->result_array();
        $this->backend->display('sales/v_report_filter', $data);
    }

    public function exportexcel($awal = null, $akhir = null)
    {

        if ($awal != null && $akhir != null) {
            $data['title'] = "Laporan Order Dari  $awal-$akhir ";
            $shipments = $this->order->getLaporanTransaksiFilterByDate($awal, $akhir)->result_array();
        } else {
            $data['title'] = "Laporan Order Keseluruhan";
            $shipments = $this->order->getLaporanSales()->result_array();
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'TANGGAL');
        $sheet->setCellValue('C1', 'NO STP');
        // $sheet->setCellValue('D1', 'NO DO/DN');
        // $sheet->setCellValue('E1', 'NO SO/PO');
        // $sheet->setCellValue('F1', 'STP');
        $sheet->setCellValue('D1', 'CUSTOMER');
        $sheet->setCellValue('E1', 'CONSIGNEE');
        $sheet->setCellValue('F1', 'DEST');
        $sheet->setCellValue('G1', 'SERVICE');
        $sheet->setCellValue('H1', 'COMM');
        $sheet->setCellValue('I1', 'COLLY');
        $sheet->setCellValue('J1', 'WEIGHT');
        $sheet->setCellValue('K1', 'SPECIAL WEIGHT');
        $sheet->setCellValue('L1', 'PETUGAS PICKUP');
        // $sheet->setCellValue('M1', 'NO FLIGHT');
        // $sheet->setCellValue('N1', 'NO SMU');
        // $sheet->setCellValue('O1', 'TANGGAL TIBA DI DAERAH');
        $sheet->setCellValue('M1', 'PENERIMA');
        $sheet->setCellValue('N1', 'JAM');
        $sheet->setCellValue('O1', 'TANGGAL');

        $no = 1;
        $x = 2;
        foreach ($shipments as $row) {
            // kalo dia outgoing itu ada 11 milestone
            // shipment telah tiba di hub tujuan itu poin 8
            // 1= ya
            // 2 = tidak
            $is_jabodetabek = $row['is_jabodetabek'];
            $tgl_daerah = '';
            // kalo iya


            //kalo dia masih di daerah yg sama itu ada 7 milestonenya
            $get_tracking = $this->order->getLastTracking($row['shipment_id'])->row_array();
            if ($get_tracking == NULL) {
                $tracking = '-';
            } else {
                $tracking = $get_tracking['status'];
                $nama_penerima = $get_tracking['pic_task'];
                $tgl_tiba = $get_tracking['created_at'];
                $jam = $get_tracking['time'];
            }
            $get_do = $this->db->select('no_do,no_so, berat, koli')->get_where('tbl_no_do', ['shipment_id' => $row['shipment_id']]);


            $no_do = '';
            $no_so = '';
            if ($get_do->num_rows() != 0) {
                $i = 1;
                foreach ($get_do->result_array() as $d) {
                    $no_do = ($i == $get_do->num_rows()) ? $d['no_do'] : $d['no_do'] . '/';
                    $i++;
                }
            } else {
                $no_do =  $row['note_cs'];
            }

            // no so
            if ($get_do->num_rows() != 0) {
                $i = 1;
                foreach ($get_do->result_array() as $d) {

                    $no_so =  ($i == $get_do->num_rows()) ? $d['no_so'] : $d['no_so'] . '/';
                    $i++;
                }
            } else {
                $no_so =  $row['no_so'];
            }

            $sheet->setCellValue('A' . $x, $no)->getColumnDimension('A')
                ->setAutoSize(true);
            $sheet->setCellValue('B' . $x, $row['tgl_pickup'])->getColumnDimension('B')
                ->setAutoSize(true);
            $sheet->setCellValue('C' . $x, $row['shipment_id'] . '/' . $row['no_stp'])->getColumnDimension('C')
                ->setAutoSize(true);
            $sheet->setCellValue('D' . $x, $row['shipper'])->getColumnDimension('D')
                ->setAutoSize(true);
            $sheet->setCellValue('E' . $x, $row['consigne'])->getColumnDimension('E')
                ->setAutoSize(true);
            $sheet->setCellValue('F' . $x, $row['tree_consignee'] . '/' . $row['city_consigne'])->getColumnDimension('F')
                ->setAutoSize(true);
            $sheet->setCellValue('G' . $x, $row['service_name'])->getColumnDimension('G')
                ->setAutoSize(true);
            $sheet->setCellValue('H' . $x, $row['pu_commodity'] . '/' . $no_do . '-' . $no_so)->getColumnDimension('H')
                ->setAutoSize(true);
            $sheet->setCellValue('I' . $x, $row['koli'])->getColumnDimension('I')
                ->setAutoSize(true);
            $sheet->setCellValue('J' . $x, $row['berat_js']);
            $sheet->setCellValue('K' . $x, $row['berat_msr'])->getColumnDimension('K')
                ->setAutoSize(true);
            $sheet->setCellValue('L' . $x, $row['nama_user'])->getColumnDimension('L')
                ->setAutoSize(true);

            if ($nama_penerima == NULL) {
                $sheet->setCellValue('M' . $x, '')->getColumnDimension('M')
                    ->setAutoSize(true);
            } else {
                $sheet->setCellValue('M' . $x, $nama_penerima)->getColumnDimension('M')
                    ->setAutoSize(true);
            };

            if ($nama_penerima == NULL) {
                $sheet->setCellValue('N' . $x, '')->getColumnDimension('N')
                    ->setAutoSize(true);
            } else {
                $sheet->setCellValue('N' . $x, $jam)->getColumnDimension('N')
                    ->setAutoSize(true);
            };
            if ($nama_penerima == NULL) {
                $sheet->setCellValue('O' . $x, '')->getColumnDimension('O')
                    ->setAutoSize(true);
            } else {
                $sheet->setCellValue('O' . $x,  bulan_indo2($tgl_tiba))->getColumnDimension('O')
                    ->setAutoSize(true);
            };

            $x++;
            $no++;
        }
        $filename = "report order";

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    //Untuk Generate Resi
    public function generateResi()
    {
        $data['title'] = 'Generate Resi';
        $data['customers'] = $this->db->get('tb_customer')->result_array();
        $data['generate'] = $this->order->getGenerate()->result_array();
        $this->backend->display('sales/v_generate', $data);
    }
    public function generateResiAdd()
    {
        $shipper = $this->input->post('customer');
        $id_customer = $this->input->post('id_customer');
        $total = $this->input->post('total');
        $notes = $this->input->post('notes');

        $sql_group = $this->db->query("SELECT * FROM tbl_booking_number_resi ORDER BY id_booking DESC LIMIT 1;")->row_array();
        if ($sql_group == NULL) {
            $noUrut = 1;
            $group  = "$noUrut";
        } else {
            $last_group = $sql_group['group'];
            $no = $last_group + 1;
            $group =  "$no";
        }
        // var_dump($no);

        for ($j = 0; $j < $total; $j++) {
            $sql = $this->db->query("SELECT max(no_resi) as shipment_id FROM tbl_no_resi  ORDER BY id_no_resi DESC LIMIT 1")->row_array();
            if ($sql == NULL) {
                $noUrut = 1;

                $shipment_id  = "$noUrut";
            } else {
                $last_shipment_id = $sql['shipment_id'];
                $no = $last_shipment_id + 1;
                $shipment_id =  ltrim($no, '0');
            }

            $data = array(
                'id_customer' => $id_customer,
                'shipment_id' => $shipment_id,
                'qr_id' => 0,
                'customer' => $shipper,
                'total' => $total,
                'created' => date('Y-m-d'),
                'notes' => $notes,
                'group' => $group
            );
            // input no shipment untuk cari max
            $this->db->insert('tbl_no_resi', ['no_resi' => $shipment_id, 'created_by' => $this->session->userdata('id_user')]);
            //untuk table booking
            $this->db->insert('tbl_booking_number_resi', $data);
            $this->barcode($shipment_id);
            $this->qrcode($shipment_id);
        }
        $this->session->set_flashdata('message', '<div class="alert
                    alert-success" role="alert">Success</div>');
        redirect('sales/SalesOrder/generateResi');
    }
    public function detailGenerate($group)
    {
        $data['title'] = 'Detail Generate Resi';
        $data['generate'] = $this->db->get_where('tbl_booking_number_resi', ['group' => $group])->result_array();
        $this->backend->display('sales/v_detail_generate', $data);
    }
    public function generatePdfGenerateResi($group)
    {

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [74, 105]]);

        $this->db->select('*, b.nama_pt,b.provinsi, b.kota');
        $this->db->from('tbl_booking_number_resi a');
        $this->db->join('tb_customer b', 'a.id_customer=b.id_customer');
        $this->db->where('a.group', $group);
        $this->db->where('a.status', 0);
        $data['orders'] = $this->db->get()->result_array();
        $data = $this->load->view('superadmin/v_cetak_resi', $data, TRUE);
        $mpdf->WriteHTML($data);
        $mpdf->Output();
    }
    public function printSatuanGenerateResi($id)
    {
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [74, 105]]);
        $this->db->select('*, b.nama_pt,b.provinsi, b.kota');
        $this->db->from('tbl_booking_number_resi a');
        $this->db->join('tb_customer b', 'a.id_customer=b.id_customer');
        $this->db->where('a.shipment_id', $id);
        $this->db->where('a.status', 0);
        $data['orders'] = $this->db->get()->result_array();
        $data = $this->load->view('superadmin/v_cetak_resi', $data, TRUE);
        $mpdf->WriteHTML($data);
        $mpdf->Output('GenerateResi-' . $id . '.pdf', 'D');
    }

    // public function Exportexcel($awal = null, $akhir = null)
    // {

    //     if ($awal != null && $akhir != null) {
    //         $data['title'] = "Laporan Order Dari  $awal-$akhir ";
    //         $shipments = $this->order->getLaporanTransaksiFilterByDate($awal, $akhir)->result_array();
    //     } else {
    //         $data['title'] = "Laporan Order Keseluruhan";
    //         $shipments = $this->order->getLaporanSales()->result_array();
    //     }

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', 'NO');
    //     $sheet->setCellValue('B1', 'TANGGAL');
    //     $sheet->setCellValue('C1', 'NO STP');
    //     // $sheet->setCellValue('D1', 'NO DO/DN');
    //     // $sheet->setCellValue('E1', 'NO SO/PO');
    //     // $sheet->setCellValue('F1', 'STP');
    //     $sheet->setCellValue('D1', 'CUSTOMER');
    //     $sheet->setCellValue('E1', 'CONSIGNEE');
    //     $sheet->setCellValue('F1', 'DEST');
    //     $sheet->setCellValue('G1', 'SERVICE');
    //     $sheet->setCellValue('H1', 'COMM');
    //     $sheet->setCellValue('I1', 'COLLY');
    //     $sheet->setCellValue('J1', 'WEIGHT');
    //     $sheet->setCellValue('K1', 'SPECIAL WEIGHT');
    //     $sheet->setCellValue('L1', 'PETUGAS PICKUP');
    //     $sheet->setCellValue('M1', 'NO FLIGHT');
    //     $sheet->setCellValue('N1', 'NO SMU');
    //     $sheet->setCellValue('O1', 'TANGGAL TIBA DI DAERAH');
    //     $sheet->setCellValue('P1', 'DELIVERY STATUS');
    //     $sheet->setCellValue('Q1', 'STATUS SAAT INI');

    //     $no = 1;
    //     $x = 2;
    //     foreach ($shipments as $row) {
    //         // kalo dia outgoing itu ada 11 milestone
    //         // shipment telah tiba di hub tujuan itu poin 8
    //         // 1= ya
    //         // 2 = tidak
    //         $is_jabodetabek = $row['is_jabodetabek'];
    //         $tgl_daerah = '';
    //         // kalo iya
    //         if ($is_jabodetabek == 1) {
    //             $daerah = $this->db->order_by('id_tracking', 'DESC')->get_where('tbl_tracking_real', ['shipment_id' => $row['shipment_id'], 'flag' => 8])->row_array();
    //         } else {
    //             $daerah = $this->db->order_by('id_tracking', 'DESC')->get_where('tbl_tracking_real', ['shipment_id' => $row['shipment_id'], 'flag' => 4])->row_array();
    //         }
    //         if ($daerah == NULL) {
    //             $tgl_daerah = '-';
    //         } else {
    //             $tgl_daerah = $daerah['created_at'];
    //         }


    //         //kalo dia masih di daerah yg sama itu ada 7 milestonenya
    //         $get_tracking = $this->db->order_by('id_tracking', 'DESC')->get_where('tbl_tracking_real', ['shipment_id' => $row['shipment_id']])->row_array();
    //         if ($get_tracking == NULL) {
    //             $tracking = '-';
    //         } else {
    //             $tracking = $get_tracking['status'];
    //             $nama_penerima = $get_tracking['pic_task'];
    //             $tgl_tiba = $get_tracking['created_at'];
    //             $jam = $get_tracking['time'];
    //         }
    //         $get_do = $this->db->select('no_do,no_so, berat, koli')->get_where('tbl_no_do', ['shipment_id' => $row['shipment_id']])->result_array();
    //         $jumlah = $this->db->select('no_do')->get_where('tbl_no_do', ['shipment_id' => $row['shipment_id']])->num_rows();

    //         $no_do = '';
    //         $no_so = '';
    //         if ($get_do) {
    //             $i = 1;
    //             foreach ($get_do as $d) {
    //                 $no_do = ($i == $jumlah) ? $d['no_do'] : $d['no_do'] . '/';
    //                 $i++;
    //             }
    //         } else {
    //             $no_do =  $row['note_cs'];
    //         }

    //         // no so
    //         if ($get_do) {
    //             $i = 1;
    //             foreach ($get_do as $d) {

    //                 $no_so =  ($i == $jumlah) ? $d['no_so'] : $d['no_so'] . '/';
    //                 $i++;
    //             }
    //         } else {
    //             $no_so =  $row['no_so'];
    //         }

    //         $sheet->setCellValue('A' . $x, $no)->getColumnDimension('A')
    //             ->setAutoSize(true);
    //         $sheet->setCellValue('B' . $x, $row['tgl_pickup'])->getColumnDimension('B')
    //             ->setAutoSize(true);
    //         $sheet->setCellValue('C' . $x, $row['shipment_id'] . '/' . $row['no_stp'])->getColumnDimension('C')
    //             ->setAutoSize(true);
    //         $sheet->setCellValue('D' . $x, $row['shipper'])->getColumnDimension('D')
    //             ->setAutoSize(true);
    //         $sheet->setCellValue('E' . $x, $row['consigne'])->getColumnDimension('E')
    //             ->setAutoSize(true);
    //         $sheet->setCellValue('F' . $x, $row['tree_consignee'] . '/' . $row['city_consigne'])->getColumnDimension('F')
    //             ->setAutoSize(true);
    //         $sheet->setCellValue('G' . $x, $row['service_name'])->getColumnDimension('G')
    //             ->setAutoSize(true);
    //         $sheet->setCellValue('H' . $x, $row['pu_commodity'] . '/' . $no_do . '-' . $no_so)->getColumnDimension('H')
    //             ->setAutoSize(true);
    //         $sheet->setCellValue('I' . $x, $row['koli'])->getColumnDimension('I')
    //             ->setAutoSize(true);
    //         $sheet->setCellValue('J' . $x, $row['berat_js']);
    //         $sheet->setCellValue('K' . $x, $row['berat_msr'])->getColumnDimension('K')
    //             ->setAutoSize(true);
    //         $sheet->setCellValue('L' . $x, $row['nama_user'])->getColumnDimension('L')
    //             ->setAutoSize(true);
    //         $sheet->setCellValue('M' . $x, $row['no_flight'])->getColumnDimension('M')
    //             ->setAutoSize(true);
    //         $sheet->setCellValue('N' . $x, $row['no_smu'])->getColumnDimension('N')
    //             ->setAutoSize(true);
    //         $sheet->setCellValue('O' . $x, bulan_indo2($tgl_daerah))->getColumnDimension('O')
    //             ->setAutoSize(true);
    //         $sheet->setCellValue('P' . $x, $nama_penerima . '/' . $jam . '/' . bulan_indo2($tgl_tiba))->getColumnDimension('P')
    //             ->setAutoSize(true);
    //         $sheet->setCellValue('Q' . $x, $tracking)->getColumnDimension('P')
    //             ->setAutoSize(true);
    //         $x++;
    //         $no++;
    //     }
    //     $filename = "report order";

    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    //     $writer->save('php://output');
    //     exit;
    // }
}
