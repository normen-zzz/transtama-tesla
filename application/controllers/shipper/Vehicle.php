<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\WriterXlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Vehicle extends CI_Controller
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

    public function index()
    {

        $listVehicle = $this->order->getListVehicle();
        $listDataVehicle = [];
        $decodedVehicles = json_decode($listVehicle);
        foreach ($decodedVehicles as $a) {
            $dataVehicle = json_decode($this->order->getLocationVehicle($a->DeviceID));
            $listDataVehicle[] = [
                'DeviceID' => $a->DeviceID,
                'Latitude' => $dataVehicle->Latitude,
                'Longitude' => $dataVehicle->Longitude,
                'Nopol' => $dataVehicle->Nopol,
                'Status' => $dataVehicle->Acc,
            ];
        }
        $data['listVehicle'] = json_encode($listDataVehicle);
        $data['title'] = 'Sales Order';


        $this->backend->display('shipper/vehicle', $data);
    }


    // getListVehicle
    public function getListVehicle()
    {
        $data = [];
        $listVehicle = $this->order->getListVehicle();
        $decodedVehicles = json_decode($listVehicle);
        foreach ($decodedVehicles as $a) {
            $data[] = [
                'DeviceID' => $a->DeviceID,
            ];
        }
        // Set JSON content type header
        header('Content-Type: application/json');
        // Return JSON response for fetch API
        echo json_encode(['data' => $data]);
    }

    public function getLocationVehicle()
    {
        $data = [];
        $device_id = $this->input->post('device_id');
        $location = $this->order->getLocationVehicle($device_id);
        echo $location;
    }
}
