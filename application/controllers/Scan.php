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
        if ($this->session->userdata('id_role') == 5) {
            $data['title'] = 'Scan';
            // $data['gateway'] = $this->db->order_by('id_gateway', 'desc')->get('tbl_gateway')->result_array();
            $data['gateway'] = $this->order->dispatch()->result_array();
            $this->backend->display('v_shipment', $data);
            // $this->load->view('dispatcher/v_shipment', $data);
        } else {
            //Jika Outbond
            $data['title'] = 'Scan';
            // $data['gateway'] = $this->db->order_by('id_gateway', 'desc')->get('tbl_gateway')->result_array();
            $data['gateway'] = $this->order->outbond()->result_array();

            $this->backend->display('v_shipment_outbond', $data);
            // $this->load->view('dispatcher/v_shipment', $data);
        }
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
                        'status' => "Shipment Telah Tiba Di Hub Benhil",
                        'id_so' => $cek_tracking['id_so'],
                        'shipment_id' => $result_code,
                        'id_user' => $this->session->userdata('id_user'),

                        'created_at' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                        'flag' => 8,
                    );
                    $this->db->insert('tbl_tracking_real', $data);
                    $this->session->set_flashdata('message', 'Success');
                    redirect('scan');
                    // scan out
                } elseif ($cek_tracking['flag'] == 8) {
                    $data = array(
                        'status' => "Shipment Keluar Dari Hub Benhil",
                        'id_so' => $cek_tracking['id_so'],
                        'shipment_id' => $result_code,
                        'id_user' => $this->session->userdata('id_user'),
                        'created_at' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                        'flag' => 9,
                    );
                    $this->db->insert('tbl_tracking_real', $data);
                    $this->session->set_flashdata('message', 'Success');
                    redirect('scan');
                } else {
                    $this->session->set_flashdata('message', 'No Data');
                    redirect('scan');
                }
            } else {
                $this->session->set_flashdata('message', 'No shipment with this QC');
                redirect('scan');
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
                        'status' => "Shipment Telah Tiba Di Hub Bandara/Pelabuhan",
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
                        redirect('scan');
                    } else {
                        $this->session->set_flashdata('message', 'Failed');
                        redirect('scan');
                    }
                } else {
                    $data = array(
                        'status' => "Shipment Keluar Dari Hub Bandara/Pelabuhan",
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
                        redirect('scan');
                    } else {
                        $this->session->set_flashdata('message', 'Failed');
                        redirect('scan');
                    }
                }
            } else {
                $this->session->set_flashdata('message', 'No shipment with this QC');
                redirect('scan');
            }
        }
    }

    function cek_idOutbond()
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
                        'status' => "Shipment Telah Tiba Di Hub Benhil",
                        'id_so' => $cek_tracking['id_so'],
                        'shipment_id' => $result_code,
                        'id_user' => $this->session->userdata('id_user'),

                        'created_at' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                        'flag' => 8,
                    );
                    $this->db->insert('tbl_tracking_real', $data);
                    $this->session->set_flashdata('message', 'Success');
                    redirect('scan');
                    // scan out
                } elseif ($cek_tracking['flag'] == 8) {
                    $data = array(
                        'status' => "Shipment Keluar Dari Hub Benhil",
                        'id_so' => $cek_tracking['id_so'],
                        'shipment_id' => $result_code,
                        'id_user' => $this->session->userdata('id_user'),
                        'created_at' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                        'flag' => 9,
                    );
                    $this->db->insert('tbl_tracking_real', $data);
                    $this->session->set_flashdata('message', 'Success');
                    redirect('scan');
                } else {
                    $this->session->set_flashdata('message', 'No Data');
                    redirect('scan');
                }
            } else {
                $this->session->set_flashdata('message', 'No shipment with this QC');
                redirect('scan');
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
                        'status' => "Shipment Telah Tiba Di Hub Bandara/Pelabuhan",
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
                        redirect('scan');
                    } else {
                        $this->session->set_flashdata('message', 'Failed');
                        redirect('scan');
                    }
                } else {
                    $data = array(
                        'status' => "Shipment Keluar Dari Hub Bandara/Pelabuhan",
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
                        redirect('scan');
                    } else {
                        $this->session->set_flashdata('message', 'Failed');
                        redirect('scan');
                    }
                }
            } else {
                $this->session->set_flashdata('message', 'No shipment with this QC');
                redirect('scan');
            }
        }
    }
}
