<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id_user')) {
			redirect('backoffice');
		}
		$this->load->model('PengajuanModel', 'order');
		cek_role();
	}
	public function index()
	{
		$bulan = date('m');
		$tahun = date('Y');

		$bulan_1 =  date('m', strtotime("-1 months"));
		$data['title'] = 'Dashboard';
		$data['order'] = $this->db->get_where('tbl_so', ['id_sales' => $this->session->userdata('id_user')])->num_rows();
		$data['shipments'] = $this->order->getShipmentBySales($bulan, $tahun)->result_array();
		$data['shipments_all'] = $this->order->getShipmentBySales()->result_array();
		$data['shipments_last_month'] = $this->order->getShipmentBySales($bulan_1, $tahun)->result_array();
		$this->backend->display('sales/index', $data);
	}
}
