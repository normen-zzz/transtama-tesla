<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $this->load->model('M_Datatables');
        $this->load->library('form_validation');
        $this->load->model('PengajuanModel', 'order');
        $this->load->model('SalesModel', 'sales');
        $this->load->model('Api');
    }

    public function index()
    {
        $data['title'] = 'Scan';
        // $data['gateway'] = $this->db->order_by('id_gateway', 'desc')->get('tbl_gateway')->result_array();
        $data['gateway'] = $this->order->dispatch()->result_array();
        $data['outbond'] = $this->order->outbond()->result_array();
        $data['users'] = $this->db->get_where('tb_user', ['id_role' => 2])->result_array();

        $this->backend->display('v_shipment', $data);
        // $this->load->view('dispatcher/v_shipment', $data);
    }
    function cek_id()
    {
        $id_user = $this->session->userdata('id_user');
        $result_code = $this->input->post('id_karyawan');
        // untuk benhil
        if ($id_user != null) {
            // CEK APAKAHA ADA TUGAS YG BELUM DI SCAN
            $cek_tracking = $this->db->limit(1)->order_by('id_tracking', 'desc')->get_where('tbl_tracking_real', ['shipment_id' => $result_code])->row_array();
            // var_dump($cek_tracking);
            // die;
            if ($cek_tracking) {
                // scan in
                if ($cek_tracking['flag'] == 7) {
                    $data = array(
                        'status' => "Shipment Telah Tiba Di Hub Jakarta Pusat",
                        'id_so' => $cek_tracking['id_so'],
                        'shipment_id' => $result_code,
                        'id_user' => $this->session->userdata('id_user'),
                        'created_at' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                        'flag' => 8,
                    );
                    $this->db->insert('tbl_tracking_real', $data);
                    $this->session->set_flashdata('message', 'Success');
                    redirect('shipper/scan');
                    // scan out
                } elseif ($cek_tracking['flag'] == 8) {
                    $data = array(
                        'status' => "Shipment Keluar Dari Hub Jakarta Pusat",
                        'id_so' => $cek_tracking['id_so'],
                        'shipment_id' => $result_code,
                        'id_user' => $this->session->userdata('id_user'),
                        'created_at' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                        'flag' => 9,
                    );
                    $this->db->insert('tbl_tracking_real', $data);
                    $this->session->set_flashdata('message', 'Success');
                    redirect('shipper/scan');
                } else {
                    $this->session->set_flashdata('message', 'No Data');
                    redirect('shipper/scan');
                }
            } else {
                $this->session->set_flashdata('message', 'No shipment with this QC');
                redirect('shipper/scan');
            }
        } else {
            // untuk gateway
            // CEK APAKAHA ADA TUGAS YG BELUM DI SCAN
            $cek_task_gateway = $this->db->limit(1)->order_by('id_gateway', 'desc')->get_where('tbl_gateway', ['shipment_id' => $result_code, 'status_eksekusi' => 0])->row_array();
            // var_dump($cek_task_gateway);
            // die;
            if ($cek_task_gateway) {
                $cek_tracking = $this->db->limit(1)->order_by('id_tracking', 'desc')->get_where('tbl_tracking_real', ['shipment_id' => $result_code])->row_array();
                if ($cek_task_gateway['status'] == 'in') {
                    $data = array(
                        'status' => "Shipment Telah Tiba Di Hub CGK",
                        'id_so' => $cek_task_gateway['id_so'],
                        'shipment_id' => $result_code,
                        'note' => null,
                        'id_user' => $this->session->userdata('id_user'),
                        'created_at' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                        'flag' => 6,
                    );
                    $insert = $this->db->insert('tbl_tracking_real', $data);
                    if ($insert) {
                        $data = array(
                            'shipment_id' => $result_code,
                            'id_user' => $this->session->userdata('id_user'),
                            'status' => 'out',
                            // 'note' => $cek_tracking['note'],
                            'id_so' => $cek_task_gateway['id_so'],
                            'status_eksekusi' => 0
                        );
                        $this->db->insert('tbl_gateway', $data);
                        $data = array(
                            'status_eksekusi' => 1
                        );
                        $this->db->update('tbl_gateway', $data, ['id_gateway' => $cek_task_gateway['id_gateway']]);
                        $this->session->set_flashdata('message', 'Success');
                        redirect('shipper/scan');
                    } else {
                        $this->session->set_flashdata('message', 'Failed');
                        redirect('shipper/scan');
                    }
                } else {
                    $data = array(
                        'status' => "Shipment Keluar Dari Hub CGK",
                        'id_so' => $cek_task_gateway['id_so'],
                        'shipment_id' => $result_code,
                        'id_user' => $this->session->userdata('id_user'),
                        'created_at' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                        'flag' => 7,
                    );
                    $insert = $this->db->insert('tbl_tracking_real', $data);
                    if ($insert) {
                        $data = array(
                            'status_eksekusi' => 1
                        );
                        $this->db->update('tbl_gateway', $data, ['id_gateway' => $cek_task_gateway['id_gateway']]);
                        $this->session->set_flashdata('message', 'Success');
                        redirect('shipper/scan');
                    } else {
                        $this->session->set_flashdata('message', 'Failed');
                        redirect('shipper/scan');
                    }
                }
            } else {
                $this->session->set_flashdata('message', 'No shipment with this QC');
                redirect('shipper/scan');
            }
        }
    }

    function outbond()
    {
        $id_user = $this->session->userdata('id_user');
        $result_code = $this->input->post('id_karyawan');

        $data['result_code'] = $result_code;

        // untuk benhil
        $this->load->view('alert/scan', $data);
    }


    public function successScan($result_code)
    {
        // CEK APAKAHA ADA TUGAS YG BELUM DI SCAN
        $cek_tracking = $this->db->limit(1)->order_by('id_tracking', 'desc')->get_where('tbl_tracking_real', ['shipment_id' => $result_code])->row_array();
        // var_dump($cek_tracking);
        // die;

        if ($cek_tracking) {
            // scan in
            if ($cek_tracking['flag'] == 4) {
                $this->db->update('tbl_tracking_real', array('status_eksekusi' => 1), array('id_tracking' => $cek_tracking['id_tracking']));
                $data = array(
                    'status' => "Shipment Telah Tiba Di Hub Jakarta Pusat",
                    'id_so' => $cek_tracking['id_so'],
                    'shipment_id' => $result_code,
                    'id_user' => $this->session->userdata('id_user'),
                    'created_at' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'flag' => 5,
                    'status_eksekusi' => 1
                );
                $this->db->insert('tbl_tracking_real', $data);
                $dataOutbond = [
                    'shipment_id' => $result_code,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('id_user'),
                    'in_date' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('tbl_outbond', $dataOutbond);
                $this->session->set_flashdata('message', 'SUKSES SCAN IN RESI ' . $result_code);
                redirect('shipper/Scan');
                // scan out
            } elseif ($cek_tracking['flag'] == 8) {
                $data = array(
                    'status' => "Shipment Telah Tiba Di Hub Jakarta Pusat",
                    'id_so' => $cek_tracking['id_so'],
                    'shipment_id' => $result_code,
                    'id_user' => $this->session->userdata('id_user'),
                    'created_at' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'flag' => 9,
                    'status_eksekusi' => 1
                );
                $this->db->insert('tbl_tracking_real', $data);
                $dataOutbond = [
                    'shipment_id' => $result_code,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('id_user'),
                    'in_date' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('tbl_outbond', $dataOutbond);
                $this->session->set_flashdata('message', 'SUKSES SCAN IN RESI ' . $result_code);
                redirect('shipper/scan');
                // scan out
            }
            // elseif ($cek_tracking['flag'] == 8) {
            //     $data = array(
            //         'status' => "Shipment Keluar Dari Hub Jakarta Pusat",
            //         'id_so' => $cek_tracking['id_so'],
            //         'shipment_id' => $result_code,
            //         'id_user' => $this->session->userdata('id_user'),
            //         'created_at' => date('Y-m-d'),
            //         'time' => date('H:i:s'),
            //         'flag' => 9,
            //     );
            //     $this->db->insert('tbl_tracking_real', $data);

            //     $this->session->set_flashdata('message', 'Success');
            //     redirect('shipper/scan');
            // } 


            else {
                $this->session->set_flashdata('message', 'No Data');
                redirect('shipper/scan');
            }
        } else {
            $this->session->set_flashdata('message', 'TIDAK ADA TASK SCAN IN/OUT DI RESI ' . $result_code);
            redirect('shipper/scan');
        }
    }

    public function successScanIn($resi)

    {
        $data['resi'] = $resi;
        $this->load->view('alert/scanin', $data);
    }

    public function successScanOut($resi)

    {
        $data['resi'] = $resi;
        $this->load->view('alert/scanout', $data);
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
                'flag' => 5,
                'status_eksekusi' => 0,
            );
            $update = $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $cek_driver['id_tracking']]);
            if ($update) {
                $this->session->set_flashdata('message', 'Success');
                redirect('shipper/scan');
            } else {
                $this->session->set_flashdata('message', 'Failed');
                redirect('shipper/scan');
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
                redirect('shipper/scan');
            } else {
                $this->session->set_flashdata('message', 'Failed');
                redirect('shipper/scan');
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
                redirect('shipper/scan');
            } else {
                $this->session->set_flashdata('message', 'Failed');
                redirect('shipper/scan');
            }
        } else {
            $data = array(
                'status' => 'Shipment Keluar Dari Hub Jakarta Pusat',
                'id_so' => $this->input->post('id_so'),
                'shipment_id' => $this->input->post('shipment_id'),
                'id_user' => $this->input->post('id_driver'),
                'created_at' => date('Y-m-d'),
                'time' => date('H:i:s'),
                'flag' => 5,
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
                redirect('shipper/scan');
            } else {
                $this->session->set_flashdata('message', 'Failed');
                redirect('shipper/scan');
            }
        }
    }
    public function scanOutIncoming($shipment_id)
    {
        // CEK APAKAHA ADA TUGAS YG BELUM DI SCAN
        $cek_tracking = $this->db->limit(1)->order_by('id_tracking', 'desc')->get_where('tbl_tracking_real', ['shipment_id' => $shipment_id])->row_array();
        if ($cek_tracking['flag'] == 9) {
            $data = array(
                'status' => "Shipment Keluar Dari Hub Jakarta Pusat",
                'id_so' => $cek_tracking['id_so'],
                'shipment_id' => $shipment_id,
                
                'created_at' => date('Y-m-d'),
                'time' => date('H:i:s'),
                'flag' => 10,
            );
            $this->db->insert('tbl_tracking_real', $data);
            $dataOutbond = [

                'out_date' => date('Y-m-d H:i:s'),
            ];
            $this->db->update('tbl_outbond', $dataOutbond, array('shipment_id' => $shipment_id));
            $this->session->set_flashdata('message', 'Success');
            redirect('shipper/scan');
        }
    }
}
