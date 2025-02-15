<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\WriterXlsx;
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
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model('PengajuanModel', 'order');
        $this->load->model('SalesModel', 'sales');
        $this->load->model('Api');
        cek_role();
    }

    public function index() {
        $akses = $this->session->userdata('akses');
        $user_id = $this->session->userdata('id_user');
    
        
    
        if ($akses == 1) {
            $data['title'] = 'Sales Order';
            $this->backend->display('shipper/v_so', $data);
        } else {
            $data['shipments'] = $this->order->get_shipments($user_id);
            $data['delivery'] = $this->order->get_deliveries($user_id);
            $data['users'] = $this->order->get_users();
            $data['title'] = 'My Shipment';
            $this->backend->display('shipper/v_shipmentv2', $data);
        }
    }

    // public function index()
    // {
    //     $akses = $this->session->userdata('akses');
    //     if ($akses == 1) {
    //         $data['title'] = 'Sales Order';
    //         $this->backend->display('shipper/v_so', $data);
    //     } else {
    //         $query  = "SELECT a.is_jabodetabek,a.shipper,a.tgl_pickup,a.time,a.pu_poin,a.pu_moda,a.koli,a.weight,a.destination,a.pu_commodity,a.pu_service,a.pu_note,a.shipment_id,a.consigne,a.city_consigne,a.state_consigne,b.note
    //         ,b.id_tracking,b.id_so,b.note as catatan, b.flag,c.service_name,
    //          b.update_at,b.status_eksekusi,b.created_at as tgl_tugas,
    //           b.time as jam_tugas
    //         FROM tbl_tracking_real b 
    //       JOIN tbl_shp_order a  ON a.shipment_id=b.shipment_id
    //         -- JOIN tbl_so d ON b.id_so=d.id_so
    //       LEFT JOIN tb_service_type c ON a.service_type=c.code 
    //          WHERE b.id_user= ?  AND b.status_eksekusi =0 AND a.deleted=0 AND a.tgl_diterima IS NULL GROUP BY a.shipment_id";
    //         $result = $this->db->query($query, array($this->session->userdata('id_user')))->result_array();
    //         $data['shipments'] = $result;
    //         // var_dump($result);
    //         // die;;
    //         $data['title'] = 'My Shipment';
    //         $this->backend->display('shipper/v_shipment', $data);
    //     }
    // }

    public function asign($shipment_id = Null)
    {
        if ($shipment_id == NULL) {
            $shipment_id = $this->input->post('shipment_id');
            $data['users'] = $this->db->get_where('tb_user', ['id_role' => 2])->result_array();
            $data['shipment_id'] = $shipment_id;
            $data['resi'] = $shipment_id;
            $data['tracking'] = $this->db->get_where('tbl_tracking_real', ['shipment_id' => $shipment_id])->result_array();
            $data['shipment'] = $this->db->get_where('tbl_shp_order', ['shipment_id' => $shipment_id])->row_array();
            $data['title'] = 'Sales Order';
            if ($this->input->post('modal') == 1) {
                $data['modal'] = '$("#modal-lg-dl-add' . $shipment_id . '").modal("show");';
            }
            $this->backend->display('shipper/v_asign', $data);
        } else {
            $data['shipment_id'] = $shipment_id;
            $data['users'] = $this->db->get_where('tb_user', ['id_role' => 2])->result_array();
            $data['resi'] = $shipment_id;
            $data['tracking'] = $this->db->get_where('tbl_tracking_real', ['shipment_id' => $shipment_id])->result_array();
            $data['shipment'] = $this->db->get_where('tbl_shp_order', ['shipment_id' => $shipment_id])->row_array();
            $data['title'] = 'Sales Order';
            $this->backend->display('shipper/v_asign', $data);
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
        $dataSo = [
            'pickup_by' => $this->input->post('id_driver'),
            'status_pickup' => 1,
        ];
        $update =  $this->db->update('tbl_tracking_real', $data, $where);
        $updateSo = $this->db->update('tbl_so', $dataSo, $where);
        if ($update && $updateSo) {
            $this->session->set_flashdata('message', 'Success');
            redirect('shipper/salesOrder/detail/' . $this->input->post('id_so'));
        } else {
            $this->session->set_flashdata('message', 'Failed');
            redirect('shipper/salesOrder/detail/' . $this->input->post('id_so'));
        }
    }
    public function assignDriverIncoming()
    {
        date_default_timezone_set("Asia/Jakarta");
        $where = array('id_tracking' => $this->input->post('id_tracking'));
        $data = array(
            'id_user' => $this->input->post('id_driver'),
            'update_at' => date('Y-m-d H:i:s')
        );
        $update =  $this->db->update('tbl_tracking_real', $data, $where);
        if ($update) {
            $this->session->set_flashdata('message', 'Success');
            redirect('shipper/salesOrder/detail/' . $this->input->post('id_so'));
        } else {
            $this->session->set_flashdata('message', 'Failed');
            redirect('shipper/salesOrder/detail/' . $this->input->post('id_so'));
        }
    }
    public function assignDriverIncomingLangsung()
    {
        date_default_timezone_set("Asia/Jakarta");
        $tracking_real = $this->db->limit(1)->order_by('id_tracking', 'DESC')->get_where('tbl_tracking_real', ['shipment_id' => $this->input->post('shipment_id'), 'flag' => 10])->row_array();
        $data = array(
            'status' => 'Shipment Dalam Proses Delivery',
            'id_so' => $this->input->post('id_so'),
            'shipment_id' => $this->input->post('shipment_id'),
            'created_at' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'flag' => 10,
            'status_eksekusi' => 0,
            'id_user' => $this->input->post('id_driver'),
        );
        if ($tracking_real) {
            $insert = $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $tracking_real['id_tracking']]);
        } else {
            $insert = $this->db->insert('tbl_tracking_real', $data);
        }
        if ($insert) {
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
        $cek_driver = $this->db->limit(1)->order_by('id_tracking', 'DESC')->get_where('tbl_tracking_real', ['shipment_id' => $this->input->post('shipment_id')])->row_array();
        if ($cek_driver['status'] == 'Shipment Keluar Dari Hub Jakarta Pusat') {
            $data = array(
                'id_user' => $this->input->post('id_driver'),
                'created_at' => date('Y-m-d'),
                'time' => date('H:i:s'),
                'flag' => 6,
                'status_eksekusi' => 0,
            );
            $update = $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $cek_driver['id_tracking']]);
            if ($update) {
                $this->session->set_flashdata('message', 'Success');
                redirect('shipper/salesOrder/detail/' . $this->input->post('id_so'));
            } else {
                $this->session->set_flashdata('message', 'Failed');
                redirect('shipper/salesOrder/detail/' . $this->input->post('id_so'));
            }
        } else {
            $data = array(
                'status' => 'Shipment Keluar Dari Hub Jakarta Pusat',
                'id_so' => $this->input->post('id_so'),
                'shipment_id' => $this->input->post('shipment_id'),
                'id_user' => $this->input->post('id_driver'),
                'created_at' => date('Y-m-d'),
                'time' => date('H:i:s'),
                'flag' => 6,
                'status_eksekusi' => 0,
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
    }

    public function assignDriverDlDarurat()
    {
        date_default_timezone_set("Asia/Jakarta");
        $cek_driver = $this->db->limit(1)->order_by('id_tracking', 'DESC')->get_where('tbl_tracking_real', ['shipment_id' => $this->input->post('shipment_id')])->row_array();
        if ($cek_driver['status'] == 'Shipment Keluar Dari Hub Jakarta Pusat') {
            $data = array(
                'id_user' => $this->input->post('id_driver'),
                'created_at' => date('Y-m-d'),
                'time' => date('H:i:s'),
                'flag' => 6,
                'status_eksekusi' => 0,
            );
            $update = $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $cek_driver['id_tracking']]);
            if ($update) {
                $this->session->set_flashdata('message', 'Success');
                redirect('shipper/salesOrder/detail/' . $this->input->post('id_so'));
            } else {
                $this->session->set_flashdata('message', 'Failed');
                redirect('shipper/salesOrder/detail/' . $this->input->post('id_so'));
            }
        } else {
            $data = array(
                'status' => 'Shipment Keluar Dari Hub Jakarta Pusat',
                'id_so' => $this->input->post('id_so'),
                'shipment_id' => $this->input->post('shipment_id'),
                'id_user' => $this->input->post('id_driver'),
                'created_at' => date('Y-m-d'),
                'time' => date('H:i:s'),
                'flag' => 6,
                'status_eksekusi' => 0,
            );
            $insert = $this->db->insert('tbl_tracking_real', $data);

            if ($insert) {
                $this->session->set_flashdata('message', 'Success');
                redirect('shipper/salesOrder/asign');
            } else {
                $this->session->set_flashdata('message', 'Failed');
                redirect('shipper/salesOrder/asign');
            }
        }
    }

    public function assignDriverHub()
    {
        $gatway = $this->input->post('gateway');
        date_default_timezone_set("Asia/Jakarta");
        $cek_driver = $this->db->limit(1)->order_by('id_tracking', 'DESC')->get_where('tbl_tracking_real', ['shipment_id' => $this->input->post('shipment_id')])->row_array();
        if ($cek_driver['status'] == 'Shipment Keluar Dari Hub Jakarta Pusat') {
            $data = array(
                'status' => 'Shipment Keluar Dari Hub Jakarta Pusat',
                'id_so' => $this->input->post('id_so'),
                'shipment_id' => $this->input->post('shipment_id'),
                'id_user' => $this->input->post('id_driver'),
                'created_at' => date('Y-m-d'),
                'time' => date('H:i:s'),
                'flag' => 6,
                'status_eksekusi' => 0,
                'note' => $this->input->post('note')
            );
            $update = $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $cek_driver['id_tracking']]);
            if ($update) {
                $this->session->set_flashdata('message', 'Success');
                redirect('shipper/salesOrder/detail/' . $this->input->post('id_so'));
            } else {
                $this->session->set_flashdata('message', 'Failed');
                redirect('shipper/salesOrder/detail/' . $this->input->post('id_so'));
            }
        } else {
            $data = array(
                'status' => 'Shipment Keluar Dari Hub Jakarta Pusat',
                'id_so' => $this->input->post('id_so'),
                'shipment_id' => $this->input->post('shipment_id'),
                'id_user' => $this->input->post('id_driver'),
                'created_at' => date('Y-m-d'),
                'time' => date('H:i:s'),
                'flag' => 6,
                'status_eksekusi' => 0,
                'note' => $this->input->post('note')
            );
            $insert = $this->db->insert('tbl_tracking_real', $data);
            if ($insert) {
                if ($gatway == 'ops') {
                    $data = array(
                        'shipment_id' => $this->input->post('shipment_id'),
                        'id_user' => $this->session->userdata('id_user'),
                        'status' => 'in',
                        // 'note' => $cek_tracking['note'],
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
    }


    public function receive($idSo)
    {

        $this->db->update('tbl_so', ['status_pickup' => 2, 'pickup_at' => date('Y-m-d H:i:s')], ['id_so' => $idSo]);
        $this->session->set_flashdata('message', 'Terima Kasih');
        redirect('shipper/salesOrder');
    }

    public function arrivePu($idSo)
    {

        $update = $this->db->update('tbl_so', ['status_pickup' => 3, 'arrived_at' => date('Y-m-d H:i:s')], ['id_so' => $idSo]);
        if ($update) {
            $this->session->set_flashdata('message', 'Terima Kasih');
            redirect('shipper/salesOrder');
        }
    }
    // public function arrivePu($id, $id_tracking, $shipment_id)
    // {
    //     $data = array(
    //         'status' => 'Driver Telah Sampai Di Lokasi Pickup',
    //         'id_so' => $id,
    //         'shipment_id' => $shipment_id,
    //         'created_at' => date('Y-m-d'),
    //         'time' => date('H:i:s'),
    //         'flag' => 3,
    //         'status_eksekusi' => 0,
    //         'id_user' => $this->session->userdata('id_user'),
    //     );
    //     $insert = $this->db->insert('tbl_tracking_real', $data);
    //     if ($insert) {
    //         $data = array(
    //             'status_eksekusi' => 1,
    //         );
    //         $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $id_tracking]);
    //         $this->session->set_flashdata('message', 'Terima Kasih');
    //         redirect('shipper/salesOrder');
    //     }
    // }
    public function receiveDelivery($id, $shipment_id, $id_tracking)
    {

        $data = array(
            'status' => 'Shipment Dalam Proses Delivery',
            'id_so' => $id,
            'shipment_id' => $shipment_id,
            'created_at' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'flag' => 7,
            'status_eksekusi' => 0,
            'id_user' => $this->session->userdata('id_user'),
        );
        $this->db->insert('tbl_tracking_real', $data);
        $this->updateEksekusiTracking($id_tracking);
        $this->session->set_flashdata('message', 'Terima Kasih');
        redirect('shipper/salesOrder');
    }

    public function receiveDeliveryIncoming($id, $shipment_id, $id_tracking)
    {
        $data = array(
            'status' => 'Shipment Dalam Proses Delivery',
            'id_so' => $id,
            'shipment_id' => $shipment_id,
            'created_at' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'flag' => 11,
            'id_user' => $this->session->userdata('id_user'),
        );
        $this->db->insert('tbl_tracking_real', $data);
        $this->updateEksekusiTracking($id_tracking);
        $this->session->set_flashdata('message', 'Terima Kasih');
        redirect('shipper/salesOrder');
    }
    public function deliveryOns($id, $shipment_id, $id_tracking)
    {
        $data = array(
            'status' => 'Shipment Dalam Proses Delivery',
            'id_so' => $id,
            'shipment_id' => $shipment_id,
            'created_at' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'flag' => 5,
            'status_eksekusi' => 0,
            'id_user' => $this->session->userdata('id_user'),
        );
        $this->db->insert('tbl_tracking_real', $data);
        $this->updateEksekusiTracking($id_tracking);
        $this->session->set_flashdata('message', 'Terima Kasih');
        redirect('shipper/salesOrder');
    }
    public function deliveryCharter($shipment_id)
    {
        $data['title'] = 'Sales Order';
        $data['shipment_id'] = $shipment_id;
        $this->backend->display('shipper/deliveryCharter', $data);
    }
    public function processDeliveryCharter($shipment_id)
    {
        $id_so = $this->db->query('SELECT id_so FROM tbl_shp_order WHERE shipment_id = ' . $shipment_id . ' ')->row_array();
        $dataShipment = [
            'tgl_diterima' => date('Y-m-d', strtotime($this->input->post('tgl_diterima'))),
        ];
        $updateShipment = $this->db->update('tbl_shp_order', $dataShipment, ['shipment_id' => $shipment_id]);

        $penerima = $this->input->post('penerima');

        $dataTracking = [
            'status' => ucwords(strtolower("paket telah diterima oleh $penerima")),
            'id_so' => $id_so['id_so'],
            'shipment_id' => $shipment_id,
            'created_at' => date('Y-m-d', strtotime($this->input->post('tgl_diterima'))),
            'time' => date('H:i:s', strtotime($this->input->post('tgl_diterima'))),
            'flag' => 6,
            'status_eksekusi' => 1,
            'id_user' => $this->session->userdata('id_user'),
        ];
        $insertTracking = $this->db->insert('tbl_tracking_real', $dataTracking);
        if ($updateShipment && $insertTracking) {
            redirect('shipper/salesOrder');
        } else {
            redirect('shipper/salesOrder');
        }
    }
    public function receiveDeliveryHub($id)
    {
        $data = array(
            'status_eksekusi' => 1,
        );
        $update = $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $id]);
        if ($update) {
            $this->session->set_flashdata('message', 'Terima Kasih');
            redirect('shipper/salesOrder');
        }
    }

    public function updateEksekusiTracking($id_tracking)
    {
        $data = array(
            'status_eksekusi' => 1,
        );
        return $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $id_tracking]);
    }

    public function arriveBenhil($id_so, $shipment_id, $id_tracking)
    {
        // var_dump($shipment_id);
        // die;
        $data = array(
            'status' => 'Shipment Telah Tiba Di Hub Jakarta Pusat',
            'id_so' => $id_so,
            'shipment_id' => $shipment_id,
            'created_at' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'flag' => 5,
            'status_eksekusi' => 1,
            'id_user' => $this->session->userdata('id_user'),
        );
        $this->db->insert('tbl_tracking_real', $data);
        $this->updateEksekusiTracking($id_tracking);

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
            'flag' => 8,
            'status_eksekusi' => 1,
            'pic_task' => $consignee,
            'id_user' => $this->session->userdata('id_user'),
        );
        $config['upload_path'] = './uploads/berkas_uncompress/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);

        // $folderUpload = "./uploads/berkas/";
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
                // if ($prosesUpload) {
                // } else {
                //     // $this->session->set_flashdata('message', 'Gambar gagal Ditambahkan');
                //     // redirect('shipper/salesOrder');
                // }
            }
            $namaBaru = implode("+", $listNamaBaru);
            $this->resizeImage($namaBaru);
            $ktp = array('bukti' => $namaBaru);
            $data = array_merge($data, $ktp);
        }
        $this->db->insert('tbl_tracking_real', $data);

        $data = array(
            'status' => 3,
        );
        $this->db->update('tbl_so', $data, ['id_so' => $id_so]);
        $data = array(
            'status_eksekusi' => 1,
        );
        $this->db->update('tbl_tracking_real', $data, ['shipment_id' => $shipment_id]);
        // update tgl diterima

        $data = array(
            'tgl_diterima' => date('Y-m-d'),
            // 'status_pod' => 2
        );
        $this->db->update('tbl_shp_order', $data, ['shipment_id' => $shipment_id]);

        // insert pod
        // $data = array(
        //     'shipment_id' => $shipment_id,
        //     'tgl_sampe' => date('Y-m-d'),
        //     'created_by' => $this->session->userdata('nama_user')
        // );
        // $this->db->insert('tbl_tracking_pod', $data);

        $this->session->set_flashdata('message', 'Terima Kasih');
        redirect('shipper/salesOrder');
    }
    public function arriveCustomerIncoming($id_so, $shipment_id, $id_tracking)
    {
        $consignee =  $this->input->post('consignee');
        $data = array(
            'status' => "Shipment Telah Diterima Oleh $consignee",
            'id_so' => $id_so,
            'shipment_id' => $shipment_id,
            'created_at' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'flag' => 12,
            'pic_task' => $consignee,
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
                // if ($prosesUpload) {
                // } else {
                //     $this->session->set_flashdata('message', 'Gambar gagal Ditambahkan');
                //     redirect('shipper/salesOrder');
                // }
            }
            $namaBaru = implode("+", $listNamaBaru);
            $this->resizeImage($namaBaru);
            $ktp = array('bukti' => $namaBaru);
            $data = array_merge($data, $ktp);
        }
        $this->db->insert('tbl_tracking_real', $data);
        $data = array(
            'status' => 3,
        );
        $this->db->update('tbl_so', $data, ['id_so' => $id_so]);
        $this->updateEksekusiTracking($id_tracking);
        // update tgl diterima
        $data = array(
            'tgl_diterima' => date('Y-m-d'),
            // 'status_pod' => 2
        );
        $this->db->update('tbl_shp_order', $data, ['shipment_id' => $shipment_id]);

        // insert pod
        // $data = array(
        //     'shipment_id' => $shipment_id,
        //     'tgl_sampe' => date('Y-m-d'),
        //     'created_by' => $this->session->userdata('nama_user')
        // );
        // $this->db->insert('tbl_tracking_pod', $data);

        $this->session->set_flashdata('message', 'Terima Kasih');
        redirect('shipper/salesOrder');
    }

    public function arriveCustomerOns($id_so, $shipment_id, $id_tracking)
    {
        $consignee =  $this->input->post('consignee');
        $data = array(
            'status' => "Shipment Telah Diterima Oleh $consignee",
            'id_so' => $id_so,
            'shipment_id' => $shipment_id,
            'created_at' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'flag' => 6,
            'status_eksekusi' => 1,
            'pic_task' => $consignee,
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
                    redirect('shipper/salesOrder');
                }
            }
            $namaBaru = implode("+", $listNamaBaru);
            $this->resizeImage($namaBaru);
            $ktp = array('bukti' => $namaBaru);
            $data = array_merge($data, $ktp);
        }
        $this->db->insert('tbl_tracking_real', $data);
        $data = array(
            'status' => 3,
        );
        $this->db->update('tbl_so', $data, ['id_so' => $id_so]);
        $this->updateEksekusiTracking($id_tracking);
        // update tgl diterima
        $data = array(
            'tgl_diterima' => date('Y-m-d'),
            // 'status_pod' => 2
        );
        $this->db->update('tbl_shp_order', $data, ['shipment_id' => $shipment_id]);

        // insert pod
        // $data = array(
        //     'shipment_id' => $shipment_id,
        //     'tgl_sampe' => date('Y-m-d'),
        //     'created_by' => $this->session->userdata('nama_user')
        // );
        // $this->db->insert('tbl_tracking_pod', $data);

        $this->session->set_flashdata('message', 'Terima Kasih');
        redirect('shipper/salesOrder');
    }

    public function detail($id)
    {
        $data['title'] = 'Detail Sales Order';

        $data['p'] = $this->db->get_where('tbl_so', ['id_so' => $id])->row_array();
        $data['users'] = $this->db->get_where('tb_user', ['id_role' => 2, 'status' => 1, 'id_atasan !=' => NULL])->result_array();
        $data['shipment2'] =  $this->order->orderBySo($id)->result_array();
        $this->backend->display('shipper/v_detail_order_luar', $data);
    }
    public function getModalDetailOrder()
    {
        $shipment_id = $this->input->get('shipment_id'); // Mengambil ID dari parameter GET


        // Ambil data dari database berdasarkan ID
        $query = "SELECT id_so,shipment_id FROM tbl_shp_order WHERE shipment_id = $shipment_id";
        // $shp = $this->db->get_where('tbl_shp_order', array('shipment_id' => $shipment_id))->row();
        $shp = $this->db->query($query)->row();
        $tracking_real = $this->db->limit(1)->order_by('id_tracking', 'DESC')->get_where('tbl_tracking_real', ['shipment_id' => $shipment_id, 'flag' => 9])->row();
        $get_last_status = $this->db->limit(1)->order_by("id_tracking", "desc")->get_where("tbl_tracking_real", ["shipment_id" => $shipment_id])->row();

        if ($tracking_real != NULL) {
            $data1 = array(
                'id_so' => $shp->id_so,
                'shipment_id' => $shp->shipment_id,
                'id_tracking' => $tracking_real->id_tracking,
                'bukti' => $get_last_status->bukti
            );
        } else {
            $data1 = array(
                'id_so' => $shp->id_so,
                'shipment_id' => $shp->shipment_id,
                'bukti' => $get_last_status->bukti

            );
        }


        // Kirim data sebagai respons JSON
        echo json_encode($data1);
    }

    public function weight($id)
    {
        $data['title'] = 'Detail Sales Order';
        $data['users'] = $this->db->get_where('tb_user', ['id_role' => 2])->result_array();
        $data['shipment'] = array('shipment_id' => $id);
        $data['dimension'] = $this->db->get_where('tbl_dimension', array('shipment_id' => $id))->result_array();
        $this->backend->display('shipper/v_weight', $data);
    }



    public function getModalEditDimension()
    {
        $id_dimension = $this->input->get('id_dimension'); // Mengambil ID dari parameter GET


        $data  = $this->db->get_where('tbl_dimension', array('id_dimension' => $id_dimension))->row();


        // Kirim data sebagai respons JSON
        echo json_encode($data);
    }
    public function addWeight($id)
    {
        $shipment_id = $this->input->post('shipment_id');
        $koli = $this->input->post('koli');
        $panjang = $this->input->post('panjang');
        $lebar = $this->input->post('lebar');
        $tinggi = $this->input->post('tinggi');
        $berat = $this->input->post('berat');

        $shipmentSebelum = $this->db->get_where('tbl_shp_order', array('shipment_id' => $shipment_id))->row_array();
        $dimensionSebelum = $this->db->get_where('tbl_dimension', array('shipment_id' => $shipment_id))->row_array();

        //pembagi untuk hitung berat volume 
        if ($shipmentSebelum['service_type'] == 'f4e0915b-7487-4fae-a04c-c3363d959742' || $shipmentSebelum['service_type'] == '0d71d936-dcc4-4f66-b77c-5ab4f062a766') {
            //untuk udara
            $pembagi = 6000;
        } else {
            // untuk darat
            $pembagi = 4000;
        }
        $no_do = $this->input->post('no_do');
        $totalKoli = 0;
        $berat_js = 0;
        for ($i = 0; $i < sizeof($panjang); $i++) {

            $volume = round(($panjang[$i] * $lebar[$i] * $tinggi[$i]) / $pembagi, 0, PHP_ROUND_HALF_UP); //0,5 keatas, dibawahnya buletin kebawah


            $data = array(
                'urutan' => ($i + 1),
                'shipment_id' => $shipment_id,
                'koli' => $koli[$i],
                'panjang' => $panjang[$i],
                'lebar' => $lebar[$i],
                'tinggi' => $tinggi[$i],
                'berat_aktual' => $berat[$i],
                'berat_volume' => $volume,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('id_user'),

            );

            // jika ada no DO
            if ($no_do[$i] != NULL) {
                $do = $this->db->get_where('tbl_no_do', array('no_do' => $no_do[$i], 'shipment_id' => $shipment_id))->row_array();
                $data['no_do'] = $no_do[$i];

                // menambah koli disetiap do 

                if ($do['koli'] != NULL) {
                    //jika koli di setiap do null
                    $this->db->update('tbl_no_do', array('koli' => ($do['koli'] + $koli[$i])), array('shipment_id' => $shipment_id, 'no_do' => $no_do[$i]));
                } else {
                    $this->db->update('tbl_no_do', array('koli' => $koli[$i]), array('shipment_id' => $shipment_id, 'no_do' => $no_do[$i]));
                }

                if ($do['berat'] != NULL) {  //jika berat di setiap do null

                    if ($volume > $berat[$i]) {
                        $this->db->update('tbl_no_do', array('berat' => ($do['berat'] + ($volume * $koli[$i]))), array('shipment_id' => $shipment_id, 'no_do' => $no_do[$i]));
                    } else {
                        $this->db->update('tbl_no_do', array('berat' => ($do['berat'] + ($berat[$i] * $koli[$i]))), array('shipment_id' => $shipment_id, 'no_do' => $no_do[$i]));
                    }
                } else {
                    if ($volume > $berat[$i]) {
                        $this->db->update('tbl_no_do', array('berat' => ($volume * $koli[$i])), array('shipment_id' => $shipment_id, 'no_do' => $no_do[$i]));
                    } else {
                        $this->db->update('tbl_no_do', array('berat' => ($berat[$i] * $koli[$i])), array('shipment_id' => $shipment_id, 'no_do' => $no_do[$i]));
                    }
                }
            }
            $this->db->insert('tbl_dimension', $data);



            if ($volume > $berat[$i]) {
                $berat_js += $volume * $koli[$i];
            } else {
                $berat_js += $berat[$i] * $koli[$i];
            }
            $totalKoli += $koli[$i];
        }

        if ($dimensionSebelum == null) {
            $koliSebelum = 0;
        } else {
            $koliSebelum = $shipmentSebelum['koli'];
        }

        $update = $this->db->update('tbl_shp_order', array('berat_js' => $shipmentSebelum['berat_js'] + $berat_js, 'koli' => $koliSebelum + $totalKoli), array('shipment_id' => $shipment_id));


        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert
                alert-success" role="alert">Success</div>');
            redirect('shipper/SalesOrder/weight/' . $id);
        }
    }



    public function mergeWeight($id)
    {
        $id_dimension = $this->input->post('check');
        $dimension = $this->db->get_where('tbl_dimension', array('id_dimension' => $id_dimension[0]))->row_array();
        $shipment = $this->db->get_where('tbl_shp_order', array('shipment_id' => $dimension['shipment_id']))->row_array();
        // var_dump(count($id_dimension));
        $dataMerge = [
            'panjang' => $this->input->post('panjang'),
            'lebar' => $this->input->post('lebar'),
            'tinggi' => $this->input->post('tinggi'),
            'berat_aktual' => $this->input->post('berat'),
            'created_by' => $this->session->userdata('id_user'),
            'created_at' => date('Y-m-d H:i:s'),
            'shipment_id' => $dimension['shipment_id']
        ];
        $createMerge = $this->db->insert('tbl_merge_dimension', $dataMerge);
        $total_berat = 0;
        if ($createMerge) {
            $getLastMerge = $this->db->select_max('id_merge')->get('tbl_merge_dimension')->row_array();
            for ($i = 0; $i < sizeof($id_dimension); $i++) {
                $dimension = $this->db->get_where('tbl_dimension', array('id_dimension' => $id_dimension[$i]))->row_array();
                $data = array(
                    'merge_to' => $getLastMerge['id_merge']
                );
                $this->db->update('tbl_dimension', $data, array('id_dimension' => $id_dimension[$i]));
            }
            $this->db->update('tbl_shp_order', array('koli' => $shipment['koli'] -  (sizeof($id_dimension) - 1)), array('shipment_id' => $dimension['shipment_id']));


            $this->session->set_flashdata('message', '<div class="alert
                    alert-success" role="alert">Success</div>');
            redirect('shipper/SalesOrder/weight/' . $id);
        }
    }

    public function unMerge($id)
    {
        $dimension = $this->db->get_where('tbl_dimension', array('id_dimension' => $id))->row_array();
        $shipment = $this->db->get_where('tbl_shp_order', array('shipment_id' => $dimension['shipment_id']))->row_array();
        $kelompok_merge_to = $this->db->get_where('tbl_dimension', array('merge_to' => $dimension['merge_to']));
        // cek merge to
        if ($kelompok_merge_to->num_rows() == 1) {
            $this->db->delete('tbl_merge_dimension', array('id_merge' => $dimension['merge_to']));
        } else {
            $this->db->update('tbl_shp_order', array('koli' => $shipment['koli'] + 1), array('shipment_id' => $dimension['shipment_id']));
        }



        $update =  $this->db->update('tbl_dimension', array('merge_to' => NULL), array('id_dimension' => $id));
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert
                alert-success" role="alert">Success</div>');
            redirect('shipper/SalesOrder/weight/' . $dimension['shipment_id']);
        }
    }

    public function changeDo($id_dimension)
    {
        $dimension = $this->db->get_where('tbl_dimension', array('id_dimension' => $id_dimension))->row_array();
        $do_sebelum = $this->db->get_where('tbl_no_do', array('no_do' => $dimension['no_do'], 'shipment_id' => $dimension['shipment_id']))->row_array();

        $do_baru = $this->db->get_where('tbl_no_do', array('no_do' => $this->input->post('no_do'), 'shipment_id' => $dimension['shipment_id']))->row_array();

        if ($do_baru['no_do'] != $dimension['no_do']) {
            if ($dimension['berat_aktual_handling'] > $dimension['berat_volume_handling']) {
                // menambah di do baru
                $this->db->update('tbl_no_do', array('berat' => $do_baru['berat'] + $dimension['berat_aktual_handling'], 'koli' => $do_baru['koli'] + 1), array('no_do' => $do_baru['no_do'], 'shipment_id' => $do_baru['shipment_id']));
                $this->db->update('tbl_no_do', array('berat' => $do_sebelum['berat'] - $dimension['berat_aktual_handling'], 'koli' => $do_sebelum['koli'] - 1), array('no_do' => $do_sebelum['no_do'], 'shipment_id' => $do_sebelum['shipment_id']));
            } else {
                $this->db->update('tbl_no_do', array('berat' => $do_baru['berat'] + $dimension['berat_volume_handling'], 'koli' => $do_baru['koli'] + 1), array('no_do' => $do_baru['no_do'], 'shipment_id' => $do_baru['shipment_id']));
                $this->db->update('tbl_no_do', array('berat' => $do_sebelum['berat'] - $dimension['berat_volume_handling'], 'koli' => $do_sebelum['koli'] - 1), array('no_do' => $do_sebelum['no_do'], 'shipment_id' => $do_sebelum['shipment_id']));
            }

            $this->db->update('tbl_dimension', array('no_do' => $this->input->post('no_do')), array('id_dimension' => $id_dimension));
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success</div>');
        redirect('shipper/SalesOrder/weight/' . $dimension['shipment_id']);
    }

    public function addHandling()
    {
        $id_dimension = $this->input->post('id_dimension');
        $dimensionSebelum = $this->db->get_where('tbl_dimension', array('id_dimension' => $id_dimension))->row_array();
        $shipmentSebelum = $this->db->get_where('tbl_shp_order', array('shipment_id' => $dimensionSebelum['shipment_id']))->row_array();
        $doSebelum = $this->db->get_where('tbl_no_do', array('no_do' => $dimensionSebelum['no_do'], 'shipment_id' => $dimensionSebelum['shipment_id']))->row_array();
        $panjang = $this->input->post('panjang');
        $lebar = $this->input->post('lebar');
        $tinggi = $this->input->post('tinggi');
        $berat = $this->input->post('berat');

        //menentukan pembagi untuk berat volume 
        if ($dimensionSebelum['service_type'] == 'f4e0915b-7487-4fae-a04c-c3363d959742') {
            //untuk udara
            $pembagi = 6000;
        } else {
            //untuk darat dn laut
            $pembagi = 4000;
        }
        $berat_volume = ceil(($panjang * $lebar * $tinggi) / $pembagi);


        // mengurangi yang ada di shp order
        if ($dimensionSebelum['berat_aktual'] > $dimensionSebelum['berat_volume']) {
            if ($berat > $berat_volume) {
                $this->db->update('tbl_shp_order', array('berat_js' => ($shipmentSebelum['berat_js'] - $dimensionSebelum['berat_aktual'] + $berat)), array('shipment_id' => $dimensionSebelum['shipment_id']));
            } else {
                $this->db->update('tbl_shp_order', array('berat_js' => ($shipmentSebelum['berat_js'] - $dimensionSebelum['berat_aktual'] + $berat_volume)), array('shipment_id' => $dimensionSebelum['shipment_id']));
            }
        } else {
            if ($berat > $berat_volume) {
                $this->db->update('tbl_shp_order', array('berat_js' => ($shipmentSebelum['berat_js'] - $dimensionSebelum['berat_volume'] + $berat)), array('shipment_id' => $dimensionSebelum['shipment_id']));
            } else {
                $this->db->update('tbl_shp_order', array('berat_js' => ($shipmentSebelum['berat_js'] - $dimensionSebelum['berat_volume'] + $berat_volume)), array('shipment_id' => $dimensionSebelum['shipment_id']));
            }
        }


        $data = array(
            'panjang_handling' => $panjang,
            'lebar_handling' => $lebar,
            'tinggi_handling' => $tinggi,
            'berat_aktual_handling' => $berat,
            'berat_volume_handling' => $berat_volume,
            'update_at' => date('Y-m-d H:i:s'),
            'update_by' => $this->session->userdata('id_user'),

        );
        if ($dimensionSebelum['no_do'] != NULL) {
            $data['no_do'] = $dimensionSebelum['no_do'];
            // mengurangi berat di do  sebelumnya
            $no_do = $dimensionSebelum['no_do'];

            //    jika berat aktual lebih besar dari volume maka di no do dikurang dengan aktual
            if ($dimensionSebelum['berat_aktual'] > $dimensionSebelum['berat_volume']) {
                $this->db->update('tbl_no_do', array('berat' => ($doSebelum['berat'] - $dimensionSebelum['berat_aktual'])), array('shipment_id' => $dimensionSebelum['shipment_id'], 'no_do' => $dimensionSebelum['no_do']));
            } else {
                $this->db->update('tbl_no_do', array('berat' => ($doSebelum['berat'] - $dimensionSebelum['berat_volume'])), array('shipment_id' => $dimensionSebelum['shipment_id'], 'no_do' => $dimensionSebelum['no_do']));
            }


            $doSekarang = $this->db->get_where('tbl_no_do', array('no_do' => $no_do, 'shipment_id' => $dimensionSebelum['shipment_id']))->row_array();
            // menambah di do yang sekarang
            if ($berat > $berat_volume) {
                $this->db->update('tbl_no_do', array('berat' => ($doSekarang['berat'] + $berat)), array('shipment_id' => $dimensionSebelum['shipment_id'], 'no_do' => $no_do));
                // if ($dimensionSebelum['berat_aktual'] > $dimensionSebelum['berat_volume']) {
                //     $this->db->update('tbl_shp_order', array('berat_js' => ($shipmentSebelum['berat_js'] - $dimensionSebelum['berat_aktual'] + $berat)), array('shipment_id' => $dimensionSebelum['shipment_id']));
                // } else {
                //     $this->db->update('tbl_shp_order', array('berat_js' => ($shipmentSebelum['berat_js'] - $dimensionSebelum['berat_volume'] + $berat)), array('shipment_id' => $dimensionSebelum['shipment_id']));
                // }
            } else {
                $this->db->update('tbl_no_do', array('berat' => ($doSekarang['berat'] + $berat_volume)), array('shipment_id' => $dimensionSebelum['shipment_id'], 'no_do' => $no_do));
                // if ($dimensionSebelum['berat_aktual'] > $dimensionSebelum['berat_volume']) {
                //     $this->db->update('tbl_shp_order', array('berat_js' => ($shipmentSebelum['berat_js'] - $dimensionSebelum['berat_aktual'] + $berat_volume)), array('shipment_id' => $dimensionSebelum['shipment_id']));
                // } else {
                //     $this->db->update('tbl_shp_order', array('berat_js' => ($shipmentSebelum['berat_js'] - $dimensionSebelum['berat_volume'] + $berat_volume)), array('shipment_id' => $dimensionSebelum['shipment_id']));
                // }
            }
        }


        $update = $this->db->update('tbl_dimension', $data, array('id_dimension' => $id_dimension));
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert
                alert-success" role="alert">Success</div>');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }



    public function editDimension()
    {
        $id_dimension = $this->input->post('id_dimension');
        $dimensionSebelum = $this->db->get_where('tbl_dimension', array('id_dimension' => $id_dimension))->row_array();
        $shipmentSebelum = $this->db->get_where('tbl_shp_order', array('shipment_id' => $dimensionSebelum['shipment_id']))->row_array();
        $doSebelum = $this->db->get_where('tbl_no_do', array('no_do' => $dimensionSebelum['no_do'], 'shipment_id' => $dimensionSebelum['shipment_id']))->row_array();

        $koli = $this->input->post('koli');
        $panjang = $this->input->post('panjang');

        $lebar = $this->input->post('lebar');

        $tinggi = $this->input->post('tinggi');

        $berat = $this->input->post('berat');



        if ($shipmentSebelum['service_type'] == 'f4e0915b-7487-4fae-a04c-c3363d959742' || $shipmentSebelum['service_type'] == '0d71d936-dcc4-4f66-b77c-5ab4f062a766') {
            $pembagi = 6000;
        } else {
            $pembagi = 4000;
        }


        $berat_volume = round(($panjang * $lebar * $tinggi) / $pembagi, 0, PHP_ROUND_HALF_UP); //0,5 keatas, dibawahnya buletin kebawah




        $data = array(
            'koli' => $koli,
            'panjang' => $panjang,
            'lebar' => $lebar,
            'tinggi' => $tinggi,
            'berat_aktual' => $berat,
            'berat_volume' => $berat_volume,
            'update_at' => date('Y-m-d H:i:s'),
            'update_by' => $this->session->userdata('id_user'),

        );



        //Cek apakah dimensi sebelumnya lebih berat aktual atau volume
        if ($dimensionSebelum['berat_aktual'] > $dimensionSebelum['berat_volume']) {
            // cek apakah berat sesudah itu lebih besar aktual atau volume 
            if ($berat > $berat_volume) {
                $this->db->update('tbl_shp_order', array('berat_js' => ($shipmentSebelum['berat_js'] - ($dimensionSebelum['berat_aktual'] * $dimensionSebelum['koli']) + ($berat * $koli)), 'koli' => ($shipmentSebelum['koli'] - $dimensionSebelum['koli'] + $koli)), array('shipment_id' => $dimensionSebelum['shipment_id']));
            } else {
                $this->db->update('tbl_shp_order', array('berat_js' => ($shipmentSebelum['berat_js'] - ($dimensionSebelum['berat_aktual'] * $dimensionSebelum['koli']) + ($berat_volume * $koli)), 'koli' => ($shipmentSebelum['koli'] - $dimensionSebelum['koli'] + $koli)), array('shipment_id' => $dimensionSebelum['shipment_id']));
            }

            // cek apakah dia punya no do
            if ($dimensionSebelum['no_do'] != NULL) {

                // cek apakah update data tersebut lebih berat aktual atau volume
                if ($berat > $berat_volume) {
                    // mengurangi berat di do  sebelumnya
                    $this->db->update('tbl_no_do', array('berat' => ($doSebelum['berat'] - ($dimensionSebelum['berat_aktual'] * $dimensionSebelum['koli']) + ($berat * $koli)), 'koli' => ($doSebelum['koli'] - $dimensionSebelum['koli'] + $koli)), array('shipment_id' => $dimensionSebelum['shipment_id'], 'no_do' => $dimensionSebelum['no_do']));
                } else {
                    $this->db->update('tbl_no_do', array('berat' => ($doSebelum['berat'] - ($dimensionSebelum['berat_aktual'] * $dimensionSebelum['koli']) + ($berat_volume * $koli)), 'koli' => ($doSebelum['koli'] - $dimensionSebelum['koli'] + $koli)), array('shipment_id' => $dimensionSebelum['shipment_id'], 'no_do' => $dimensionSebelum['no_do']));
                }
            }
        } else {
            if ($berat > $berat_volume) {
                $this->db->update('tbl_shp_order', array('berat_js' => ($shipmentSebelum['berat_js'] - ($dimensionSebelum['berat_volume'] * $dimensionSebelum['koli']) + ($berat * $koli)), 'koli' => ($shipmentSebelum['koli'] - $dimensionSebelum['koli'] + $koli)), array('shipment_id' => $dimensionSebelum['shipment_id']));
            } else {
                $this->db->update('tbl_shp_order', array('berat_js' => ($shipmentSebelum['berat_js'] - ($dimensionSebelum['berat_volume'] * $dimensionSebelum['koli']) + ($berat_volume * $koli)), 'koli' => ($shipmentSebelum['koli'] - $dimensionSebelum['koli'] + $koli)), array('shipment_id' => $dimensionSebelum['shipment_id']));
            }

            // cek apakah dia punya no do
            if ($dimensionSebelum['no_do'] != NULL) {

                // cek apakah update data tersebut lebih berat aktual atau volume
                if ($berat > $berat_volume) {
                    // mengurangi berat di do  sebelumnya dan menambahkan yang baru
                    $this->db->update('tbl_no_do', array('berat' => ($doSebelum['berat'] - ($dimensionSebelum['berat_volume'] * $dimensionSebelum['koli']) +  ($berat * $koli)), 'koli' => ($doSebelum['koli'] - $dimensionSebelum['koli'] + $koli)), array('shipment_id' => $dimensionSebelum['shipment_id'], 'no_do' => $dimensionSebelum['no_do']));
                } else {
                    $this->db->update('tbl_no_do', array('berat' => ($doSebelum['berat'] - ($dimensionSebelum['berat_volume'] * $dimensionSebelum['koli']) + ($berat_volume * $koli)), 'koli' => ($doSebelum['koli'] - $dimensionSebelum['koli'] + $koli)), array('shipment_id' => $dimensionSebelum['shipment_id'], 'no_do' => $dimensionSebelum['no_do']));
                }
            }
        }

        $update = $this->db->update('tbl_dimension', $data, array('id_dimension' => $id_dimension));
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert
                alert-success" role="alert">Success</div>');
            redirect('shipper/SalesOrder/weight/' . $dimensionSebelum['shipment_id']);
        }
    }

    public function deleteDimension($id_dimension)
    {

        $dimensionSebelum = $this->db->get_where('tbl_dimension', array('id_dimension' => $id_dimension))->row_array();
        $shipmentSebelum = $this->db->get_where('tbl_shp_order', array('shipment_id' => $dimensionSebelum['shipment_id']))->row_array();
        $doSebelum = $this->db->get_where('tbl_no_do', array('no_do' => $dimensionSebelum['no_do'], 'shipment_id' => $dimensionSebelum['shipment_id']))->row_array();

        //Cek apakah dimensi sebelumnya lebih berat aktual atau volume
        if ($dimensionSebelum['berat_aktual'] > $dimensionSebelum['berat_volume']) {
            // cek apakah berat sesudah itu lebih besar aktual atau volume 

            $this->db->update('tbl_shp_order', array('berat_js' => ($shipmentSebelum['berat_js'] - ($dimensionSebelum['berat_aktual'] * $dimensionSebelum['koli'])), 'koli' => $shipmentSebelum['koli'] - $dimensionSebelum['koli']), array('shipment_id' => $dimensionSebelum['shipment_id']));

            // cek apakah dia punya no do
            if ($dimensionSebelum['no_do'] != NULL) {

                $this->db->update('tbl_no_do', array('berat' => ($doSebelum['berat'] - ($dimensionSebelum['berat_aktual'] * $dimensionSebelum['koli'])), 'koli' => $doSebelum['koli'] - $dimensionSebelum['koli']), array('shipment_id' => $dimensionSebelum['shipment_id'], 'no_do' => $dimensionSebelum['no_do']));
            }
        } else {
            $this->db->update('tbl_shp_order', array('berat_js' => ($shipmentSebelum['berat_js'] - ($dimensionSebelum['berat_volume'] * $dimensionSebelum['koli'])), 'koli' => $shipmentSebelum['koli'] - $dimensionSebelum['koli']), array('shipment_id' => $dimensionSebelum['shipment_id']));
            // cek apakah dia punya no do
            if ($dimensionSebelum['no_do'] != NULL) {
                $this->db->update('tbl_no_do', array('berat' => ($doSebelum['berat'] - ($dimensionSebelum['berat_volume'] * $dimensionSebelum['koli'])), 'koli' => $doSebelum['koli'] - $dimensionSebelum['koli']), array('shipment_id' => $dimensionSebelum['shipment_id'], 'no_do' => $dimensionSebelum['no_do']));
            }
        }


        $hapus = $this->db->delete('tbl_dimension', array('id_dimension' => $id_dimension));
        if ($hapus) {
            $this->session->set_flashdata('message', '<div class="alert
                alert-success" role="alert">Success Delete</div>');
            redirect('shipper/SalesOrder/weight/' . $dimensionSebelum['shipment_id']);
        }
    }
    public function edit($id, $id_so)
    {
        $data['title'] = 'Edit Order';
        $data['id_so'] = $id_so;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $data['province'] = $this->db->get('tb_province')->result_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['p'] = $this->order->order($id)->row_array();
        $data['moda'] = $this->db->get('tbl_moda')->result_array();
        $this->backend->display('shipper/v_edit_order2', $data);
    }
    public function processEdit()
    {
        $data = array(
            'service_type' => $this->input->post('service_type'),
            'tree_shipper' => $this->input->post('tree_shipper'),
            'note_driver' => $this->input->post('note_driver'),
            'pu_moda' => $this->input->post('moda'),
            'tree_consignee' => $this->input->post('tree_consignee'),
            'is_jabodetabek' => $this->input->post('is_jabodetabek'),
        );
        $folderUpload = "./uploads/berkas_uncompress/";
        $files = $_FILES;
        $files = $_FILES;
        $jumlahFile = count($files['foto']['name']);
        // var_dump($jumlahFile);
        // die;
        if (!empty($_FILES['foto']['name'][0])) {
            $listNamaBaru = array();
            for ($i = 0; $i < $jumlahFile; $i++) {
                $namaFile = $files['foto']['name'][$i];
                $lokasiTmp = $files['foto']['tmp_name'][$i];

                # kita tambahkan uniqid() agar nama gambar bersifat unik
                $namaBaru = uniqid() . '-' . $namaFile;

                array_push($listNamaBaru, $namaBaru);
                $lokasiBaru = "{$folderUpload}/{$namaBaru}";
                $prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);

                # jika proses berhasil
                if ($prosesUpload) {
                } else {
                }
            }
            $namaBaru = implode("+", $listNamaBaru);
            $this->resizeImage($namaBaru);
            $ktp = array('image' => $namaBaru);
            $data = array_merge($data, $ktp);
        }


        $update =  $this->db->update('tbl_shp_order', $data, ['id' => $this->input->post('id')]);
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert
                alert-success" role="alert">Success</div>');
            redirect('shipper/salesOrder/edit/' . $this->input->post('id') . '/' . $this->input->post('id_so'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert
                alert-danger" role="alert">Failed</div>');
            redirect('shipper/salesOrder/edit/' . $this->input->post('id') . '/' . $this->input->post('id_so'));
        }
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
        }
    }
    public function completeTtd($id)
    {
        $this->db->select('a.image,a.signature, a.shipment_id,a.id');
        $this->db->from('tbl_shp_order a');
        $this->db->where('a.id_so', $id);
        $this->db->order_by('a.id', 'ASC');
        $this->db->limit(1);
        $orders = $this->db->get()->row_array();
        if ($orders['image'] == NULL || $orders['signature'] == NULL) {
            $this->session->set_flashdata('message', '<div class="alert
                    alert-danger" role="alert">Gagal, Pastikan Data Pertama Dari Shipment Ini telah di Tanda tangan dan sudah ada POP</div>');
            redirect('shipper/salesOrder/detail/' . $id);
        } else {
            $data = array(
                'signature' => $orders['signature'],
                'image' => $orders['image']
            );
            $update = $this->db->update('tbl_shp_order', $data, ['id_so' => $id]);
            if ($update) {
                $this->session->set_flashdata('message', '<div class="alert
                    alert-success" role="alert">Success Duplicate Signature</div>');
                redirect('shipper/salesOrder/detail/' . $id);
            } else {
                $this->session->set_flashdata('message', '<div class="alert
                    alert-danger" role="alert">Gagal</div>');
                redirect('shipper/salesOrder/detail/' . $id);
            }
        }
    }

    public function importWeight($shipment_id)
    {
        $do = $this->db->get_where('tbl_no_do', array('shipment_id' => $shipment_id))->result_array();
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

            $shipmentSebelum = $this->db->get_where('tbl_shp_order', array('shipment_id' => $shipment_id))->row_array();
            $dimensionSebelum = $this->db->get_where('tbl_dimension', array('shipment_id' => $shipment_id))->row_array();
            //pembagi untuk hitung berat volume 
            if ($shipmentSebelum['service_type'] == 'f4e0915b-7487-4fae-a04c-c3363d959742') {
                //untuk udara
                $pembagi = 6000;
            } else {
                // untuk darat
                $pembagi = 4000;
            }
            $urutan = 0;
            $berat_js = 0;
            $total_koli = 0;
            $queue = 0;
            foreach ($sheetData as $rowdata) {
                if ($queue == 0) {
                    $queue += 1;
                } else {
                    $panjang = $rowdata[0];
                    $lebar = $rowdata[1];
                    $tinggi = $rowdata[2];
                    $berat = $rowdata[3];

                    $volume = ceil(($panjang * $lebar * $tinggi) / $pembagi);

                    $data = array(
                        'urutan' => ($urutan + 1),
                        'shipment_id' => $shipment_id,
                        'panjang' => $panjang,
                        'lebar' => $lebar,
                        'tinggi' => $tinggi,
                        'berat_aktual' => $berat,
                        'berat_volume' => $volume,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => $this->session->userdata('id_user'),

                    );

                    if ($volume > $berat) {
                        $berat_js += $volume;
                    } else {
                        $berat_js += $berat;
                    }
                    $urutan += 1;


                    if ($do != NULL) {
                        $no_do = $this->db->get_where('tbl_no_do', array('no_do' => $rowdata[4], 'shipment_id' => $shipment_id))->row_array();
                        $data['no_do'] = $rowdata[4];
                        $this->db->where('no_do', $rowdata[4]);
                        $this->db->where('shipment_id', $shipment_id);
                        // menambah koli disetiap do 

                        if ($no_do['koli'] != NULL) {
                            //jika koli di setiap do null
                            $this->db->set('koli', '`koli`+ 1', FALSE);
                        } else {
                            $this->db->set('koli', '1', FALSE);
                        }

                        if ($no_do['berat'] != NULL) {  //jika berat di setiap do null

                            if ($volume > $rowdata[3]) {
                                $this->db->set('berat', '`berat`+' . $volume, FALSE);
                            } else {
                                $this->db->set('berat', '`berat`+' . $rowdata[3], FALSE);
                            }
                        } else {
                            if ($volume > $rowdata[3]) {
                                $this->db->set('berat', $volume, FALSE);
                            } else {
                                $this->db->set('berat', $rowdata[3], FALSE);
                            }
                        }
                        $this->db->update('tbl_no_do');
                    }
                    $this->db->insert('tbl_dimension', $data);
                    $total_koli++;
                }
            }
            if ($dimensionSebelum == null) {
                $koliSebelum = 0;
            } else {
                $koliSebelum = $shipmentSebelum['koli'];
            }

            $update = $this->db->update('tbl_shp_order', array('berat_js' => $shipmentSebelum['berat_js'] + $berat_js, 'koli' => $koliSebelum + $total_koli), array('shipment_id' => $shipment_id));

            if ($update) {
                $this->session->set_flashdata('message', '<div class="alert
                    alert-success" role="alert">Success</div>');
                redirect('shipper/SalesOrder/weight/' . $shipment_id);
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert
                    alert-danger" role="alert">Silahkan Upload File</div>');
            redirect('shipper/SalesOrder/weight/' . $shipment_id);
        }
    }

    public function receiveTaskDelivery($shipment_id)
    {
        $resi = $this->db->query('SELECT id_so FROM tbl_shp_order WHERE shipment_id = ' . $shipment_id . ' ')->row_array();
        $dataReceiveTask = [
            'delivery_status' => 2,
            'outbond_status' => 2
        ];
        $updateReceiveTask = $this->db->update('tbl_shp_order', $dataReceiveTask, ['shipment_id' => $shipment_id]);
        if ($updateReceiveTask) {
            $dataTracking = [
                'status' => ucwords(strtolower("paket telah keluar dari hub jakarta pusat dan dalam proses pengiriman")),
                'id_so' => $resi['id_so'],
                'shipment_id' => $shipment_id,
                'created_at' => date('Y-m-d'),
                'time' => date('H:i:s'),
                'flag' => 6,
                'status_eksekusi' => 1,
                'id_user' => $this->session->userdata('id_user'),
            ];
            $insertTracking = $this->db->insert('tbl_tracking_real', $dataTracking);
            if ($insertTracking) {
                redirect('shipper/SalesOrder');
            }
        }
    }

    public function finishDelivery()
    {
        $resi = $this->db->query('SELECT shipment_id,id_so FROM tbl_shp_order WHERE shipment_id = ' . $this->input->post("shipment_id") . '  ')->row_array();
        if ($resi) {
            $dataUpdateDiterima = [
                'tgl_diterima' => date('Y-m-d'),
                'delivery_status' => 3
            ];
            $updateDiterima = $this->db->update('tbl_shp_order', $dataUpdateDiterima, ['shipment_id' => $resi["shipment_id"]]);
            if ($updateDiterima) {
                $dataTracking = [
                    'status' => ucwords(strtolower("paket telah diterima oleh " . $this->input->post('penerima'))),
                    'id_so' => $resi['id_so'],
                    'shipment_id' => $resi['shipment_id'],
                    'created_at' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'flag' => 7,
                    'status_eksekusi' => 1,
                    'id_user' => $this->session->userdata('id_user'),
                ];
                $insertTracking = $this->db->insert('tbl_tracking_real', $dataTracking);
                if ($insertTracking) {
                    redirect('shipper/SalesOrder');
                }
            }
        }
    }

    // public function createExcelWeight($shipment_id)
    // {
    //     $do = $this->db->get_where('tbl_no_do', array('shipment_id' => $shipment_id))->result_array();
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', 'Panjang');
    //     $sheet->setCellValue('B1', 'Lebar');
    //     $sheet->setCellValue('C1', 'Tinggi');
    //     $sheet->setCellValue('D1', 'Berat Aktual');

    //     if ($do != NULL) {
    //         $sheet->setCellValue('E1', 'NO DO');
    //         $sheet->setCellValue('H1', 'LIST NO DO');
    //         $no = 2;
    //         foreach ($do as $do1) {
    //             $sheet->setCellValue('H' . $no, $do1['no_do']);
    //             $no++;
    //         }
    //     }


    //     $writer = new WriterXlsx($spreadsheet);

    //     // Simpan file ke tempat sementara
    //     $filename = 'Weight ' . $shipment_id . '.xlsx';
    //     $tempFile = tempnam(sys_get_temp_dir(), $filename);


    //     // Mengatur header untuk tipe konten dan nama file
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment; filename="' . $filename . '"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }

    // createResiPtp 
    public function createResiPtp($id_so)
    {
        $so = $this->db->get_where('tbl_so', ['id_so' => $id_so])->row_array();
        $city = $this->db->get_where('city_ptp', ['name' => $so['destination']])->row_array();
        $state = $this->db->get_where('state_ptp', ['id_state_ptp' => $city['id_state_ptp']])->row_array();
        $data['id_so'] = $id_so;



        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['city'] = $city;
        $data['state'] = $state;
        $data['customer'] = $this->db->get('tb_customer')->result_array();
        $data['moda'] = $this->db->get('tbl_moda')->result_array();
        $data['so'] = $so;
        $dataDo = $this->db->get_where('do_requestpickup', ['id_so' => $id_so]);
        if ($dataDo) {
            $data['do'] = $dataDo;
        } else {
            $data['do'] = NULL;
        }
        $this->backend->display('shipper/addResiPtp', $data);
    }

    public function ProcessResiPtp()
    {
        $this->db->trans_start();
        try {
          

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

            $so = $this->db->get_where('tbl_so', ['id_so' => $this->input->post('id_so')])->row_array();
            $shipper = $this->db->get_where('customer_ptp', ['nama_customer' => $so['shipper']])->row_array();
            $city = $this->db->get_where('city_ptp', ['name' => $so['destination']])->row_array();
            $state = $this->db->get_where('state_ptp', ['id_state_ptp' => $city['id_state_ptp']])->row_array();
            $sell = $this->db->get_where('sell_ptp', ['id_city_ptp' => $city['id_city_ptp']])->row_array();

            $data = array(
                'shipper' => strtoupper($shipper['nama_customer']),
                'origin' => $this->input->post('origin'),
                'city_shipper' => $shipper['city'],
                'state_shipper' => $shipper['state'],
                'consigne' => strtoupper($this->input->post('consignee')),
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
                'tree_shipper' => 'CGK',
                'tree_consignee' => $city['tlc'],
                'shipment_id' => $shipment_id,
                // 'order_id' => $order_id,
                'service_type' =>  $service_type,
                'date_new' => date('Y-m-d'),
                'so_id' => $kode,
                'tgl_pickup' => date('Y-m-d'),
                'pu_moda' => $this->input->post('moda'),
                'status_so' => 4,
                'freight_kg' => $sell['freight_kg'],
                'special_freight' => $sell['special_freight'],
                'packing' => $sell['packing'],
                'others' => $sell['others'],
                'surcharge' => $sell['surcharge'],
                'insurance' => $sell['insurance'],
                'disc' => $sell['disc'],
                'cn' => $sell['cn'],
                'specialcn' => $sell['special_cn'],
                'berat_js' => $this->input->post('weight'),
                'koli' => $this->input->post('koli'),
                'admin' => 10500
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
                $idshipment = $this->db->insert_id();
                // input no do
                $no_do = $this->input->post('note_cs');
                if ($no_do != NULL) {
                    for ($i = 0; $i < sizeof($no_do); $i++) {
                        $data = array(
                            'shipment_id' => $shipment_id,
                            'no_do' => $no_do[$i]
                        );
                        $insertDo = $this->db->insert('tbl_no_do', $data);
                        if (!$insertDo) {
                            throw new Exception('Error Insert No DO');
                        }
                    }
                    // update no so berdasarkan shipment id
                    $no_so = $this->input->post('no_so');
                    $no_so = implode(",", $no_so);
                    $data = array(
                        'no_so' => $no_so
                    );
                    $this->db->update('tbl_no_do', $data, ['shipment_id' => $shipment_id]);
                }
                
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
                    'created_at' =>  date('Y-m-d'),
                    'id_user' => $this->session->userdata('id_user'),
                    'time' =>  date('H:i:s'),
                    'flag' => 2,
                    'status_eksekusi' => 1,
                );
                $this->db->insert('tbl_tracking_real', $dataTracking2);

                $dataTracking3 = array(
                    'shipment_id' => $shipment_id,
                    'status' => ucwords(strtolower('Driver Telah Sampai Di Lokasi Pickup')),
                    'id_so' => $this->input->post('id_so'),
                    'created_at' => date('Y-m-d'),
                    'id_user' => $this->session->userdata('id_user'),
                    'time' =>  date('H:i:s'),
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

                $dataTracking5 = array(
                    'shipment_id' => $shipment_id,
                    'status' => ucwords(strtolower('Paket telah Tiba Di Hub Jakarta Pusat')),
                    'id_so' => $this->input->post('id_so'),
                    'created_at' => date('Y-m-d'),
                    'id_user' => $this->session->userdata('id_user'),
                    'time' => date('H:i:s'),
                    'flag' => 5,
                    'status_eksekusi' => 1,
                );
                $this->db->insert('tbl_tracking_real', $dataTracking5);

                $dataTracking6 = array(
                    'shipment_id' => $shipment_id,
                    'status' => ucwords(strtolower('Paket Telah Keluar Dari Hub Jakarta Pusat')),
                    'id_so' => $this->input->post('id_so'),
                    'created_at' => date('Y-m-d'),
                    'id_user' => $this->session->userdata('id_user'),
                    'time' => date('H:i:s'),
                    'flag' => 6,
                    'status_eksekusi' => 1,
                );
                $this->db->insert('tbl_tracking_real', $dataTracking6);

                $dataTracking7 = array(
                    'shipment_id' => $shipment_id,
                    'status' => ucwords(strtolower('Paket Telah Tiba Di Hub Cgk')),
                    'id_so' => $this->input->post('id_so'),
                    'created_at' => date('Y-m-d'),
                    'id_user' => $this->session->userdata('id_user'),
                    'time' => date('H:i:s'),
                    'flag' => 7,
                    'status_eksekusi' => 1,
                );
                $this->db->insert('tbl_tracking_real', $dataTracking7);


                $dataBagging = [
                    'status_bagging' => 3,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('id_user'),
                    'smu' => $this->input->post('smu'),
                    'dispatcher_in' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('bagging', $dataBagging);
                $id_bagging = $this->db->insert_id();
                $this->db->update('tbl_shp_order', ['bagging' => $id_bagging], ['shipment_id' => $shipment_id]);



                $data = array(
                    'status' => 2,
                    'deadline_sales_so' => $deadline_sales,
                    'submitso_at' => date('Y-m-d H:i:s'),

                );
                $this->db->update('tbl_so', $data, ['id_so' => $this->input->post('id_so')]);

                $cost = $this->db->get_where('cost_ptp', ['id_city_ptp' => $city['id_city_ptp']])->row_array();

                //add Cost
                $data = array(
                    'shipment_id' => $idshipment,
                    'flight_msu2' => $cost['flight_smu'],
                    'ra2' => $cost['ra'],
                    'packing2' => $cost['packing'],
                    'refund2' => $cost['refund'],
                    'insurance2' => $cost['insurance'],
                    'surcharge2' => $cost['surcharge'],
                    'hand_cgk2' => $cost['hand_cgk'],
                    'hand_pickup2' => $cost['hand_pickup'],
                    'hd_daerah2' => $cost['hd_daerah'],
                    'pph2' => $cost['pph'],
                    'sdm2' => $cost['sdm'],
                    'others2' => $cost['others'],
                    'note_mgr_cs' => 'PTP',
                );
                $insert = $this->db->insert('tbl_modal', $data);

                
                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    throw new Exception('Transaction failed');
                } else{
                    $this->session->set_flashdata('message', '<div class="alert
                    alert-success" role="alert">Success</div>');
                redirect('shipper/salesorder/detail/' . $this->input->post('id_so'));
                }
            } else {
                throw new Exception('Gagal Menambahkan Resi');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert
                    alert-danger" role="alert">' . $e->getMessage() . '</div>');
            redirect('shipper/salesorder/detail/' . $this->input->post('id_so'));
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
}
