<?php

use FontLib\Table\Type\post;

defined('BASEPATH') or exit('No direct script access allowed');

class SalesTracker extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id_user')) {
            redirect('backoffice');
        }
        $this->load->model('PengajuanModel', 'order');
        $this->load->model('SalesModel', 'sales');
        cek_role();
    }
    public function index($day = NULL, $month = NULL, $year = NULL)
    {

        if ($day == NULL && $month == NULL && $year == NULL) {
            $data['title'] = 'Sales Tracker';
            $data['date'] = date('d-m-y');
            // $this->load->view('sales/v_sales_tracker');
            $data['dataSalesTracker'] = $this->sales->getDataSalesTracker(date('Y-m-d'), $this->session->userdata('id_user'))->result_array();
            $this->backend->display('sales/v_sales_tracker', $data);
        } else {
            $data['title'] = 'Sales Tracker';
            $year = date('Y', strtotime($year . '-' . $month . '-' . $day));
            $tahun = date('Y', strtotime($year . '-' . $month . '-' . $day));
            $bulan = date('m', strtotime($year . '-' . $month . '-' . $day));
            $hari = date('d', strtotime($year . '-' . $month . '-' . $day));
            // var_dump($year);
            $data['date'] = $year . '-' . $month . '-' . $day;
            $data['dataSalesTracker'] = $this->sales->getDataSalesTracker(date('Y-m-d', strtotime("$tahun-$bulan-$hari")), $this->session->userdata('id_user'))->result_array();

            // $this->load->view('sales/v_sales_tracker');
            $this->backend->display('sales/v_sales_tracker', $data);
            // var_dump($data['dataSalesTracker']);
        }
    }

    public function detail($id)
    {
        $data['date'] = date('d-m-y');
        $data['title'] = 'Detail Sales Tracker';
        $data['dataSalesTracker'] = $this->sales->getDetailSalesTracker($id)->row_array();
        $this->backend->display('sales/v_detail_sales_tracker', $data);
    }

    public function addNewMeeting()
    {
        $dataNewMeeting = [
            'id_sales' => $this->input->post('sales'),
            'subject' => $this->input->post('subject'),
            'description' => $this->input->post('description'),
            'location' => $this->input->post('location'),
            'created_at' => date('Y-m-d H:i:s'),
            'start_date' => $this->input->post('start_date'),
            'contact' => $this->input->post('contact'),
        ];
        if ($this->db->insert('tbl_sales_tracker', $dataNewMeeting)) {
            $this->session->set_flashdata('message', '<div class="alert
            alert-success" role="alert">Success</div>');
            redirect('sales/SalesTracker/index/' . date('d/m/y', strtotime($this->input->post('start_date'))));
        } else {
            $this->session->set_flashdata('message', '<div class="alert
            alert-danger" role="alert">Failed</div>');
            redirect('sales/SalesTracker/index/' . date('d/m/y', strtotime($this->input->post('start_date'))));
        }
    }

    public function checkOut()
    {
        $dataCheckout = [
            'summary' => $this->input->post('summary'),
            'end_date' => $this->input->post('end_date'),
            'closing_at' => date('Y-m-d H:i:s'),
            'geo_location' => $this->input->post('koordinat'),


        ];
        if (isset($_FILES['photo']['name'])) {
            $config['upload_path']         = './uploads/salestracker/';
            $config['allowed_types']     = 'gif|jpg|png|jpeg';
            $config['overwrite']          = true;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            // $this->upload->initialize($config);
            $img = "photo";
            if (!$this->upload->do_upload($img)) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal Upload Photo</div>');
                $this->session->set_flashdata('error_upload', $error['error']);
                var_dump($error);
                // redirect($_SERVER['HTTP_REFERER']);
            } else {
                $img = $this->upload->data();
                $dataCheckout['image'] = $img['file_name'];
                if ($this->db->update('tbl_sales_tracker', $dataCheckout, array('id_sales_tracker' => $this->input->post('id_sales_tracker')))) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success</div>');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal Checkout</div>');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
        }
    }

    public function editSalesTracker()
    {
        $dataEditSalesTracker = [
            'subject' => $this->input->post('subject'),
            'description' => $this->input->post('description'),
            'location' => $this->input->post('location'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'contact' => $this->input->post('contact'),
            'summary' => $this->input->post('summary'),
        ];
        if (!empty($_FILES['photo']['name'])) {
            $config['upload_path']         = './uploads/salestracker/';
            $config['allowed_types']     = 'gif|jpg|png|jpeg';
            $config['overwrite']          = true;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('photo')) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal Upload Photo</div>');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $img = $this->upload->data();
                $dataEditSalesTracker['image'] = $img['file_name'];
                if ($this->db->update('tbl_sales_tracker', $dataEditSalesTracker, array('id_sales_tracker' => $this->input->post('id_sales_tracker')))) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success</div>');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal</div>');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
        } else {
            if ($this->db->update('tbl_sales_tracker', $dataEditSalesTracker, array('id_sales_tracker' => $this->input->post('id_sales_tracker')))) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success</div>');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal</div>');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function deleteSalesTracker($id)
    {
        if ($this->db->update('tbl_sales_tracker', array('is_deleted' => 1), array('id_sales_tracker' => $id))) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success</div>');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
